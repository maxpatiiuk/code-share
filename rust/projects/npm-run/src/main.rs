use serde::Deserialize;
use std::collections::HashMap;
use std::env;
use std::fs;
use std::path::{Path, PathBuf};

#[derive(Deserialize)]
struct PackageJson {
    scripts: Option<HashMap<String, String>>,
}

#[derive(Debug)]
struct GlobalScript {
    cwd: PathBuf,
}

fn split(name: &str) -> Vec<Vec<Vec<String>>> {
    name.split(':')
        .map(|part| {
            part.split('.')
                .map(|sub_part| sub_part.split('-').map(|s| s.to_string()).collect())
                .collect()
        })
        .collect()
}

fn resolve(candidates: &[String], query_parts: &[Vec<Vec<String>>]) -> Option<String> {
    for candidate in candidates {
        let candidate_parts = split(candidate);
        let matches = query_parts.iter().enumerate().all(|(index, sub_parts)| {
            sub_parts.iter().enumerate().all(|(sub_index, sub_sub_parts)| {
                sub_sub_parts
                    .iter()
                    .enumerate()
                    .all(|(sub_sub_index, part)| {
                        if let Some(candidate_sub_parts) = candidate_parts.get(index) {
                            if let Some(candidate_sub_sub_parts) = candidate_sub_parts.get(sub_index)
                            {
                                if let Some(candidate_part) =
                                    candidate_sub_sub_parts.get(sub_sub_index)
                                {
                                    return candidate_part.starts_with(part);
                                }
                            }
                        }
                        false
                    })
            })
        });

        if matches {
            return Some(candidate.clone());
        }
    }
    None
}

fn shell_quote(arg: &str) -> String {
    let is_safe = arg.bytes().all(|b| {
        matches!(
            b,
            b'a'..=b'z' | b'A'..=b'Z' | b'0'..=b'9' | b'_' | b'-' | b'.' | b'/' | b':' | b'='
        )
    });

    if is_safe {
        arg.to_string()
    } else {
        format!("'{}'", arg.replace('\'', "'\"'\"'"))
    }
}

fn format_shell_arguments(args: &[String]) -> Vec<String> {
    args.iter().map(|arg| shell_quote(arg)).collect()
}

fn main() {
    let cwd = env::current_dir().unwrap_or_else(|_| PathBuf::from("."));
    let mut args: Vec<String> = env::args().skip(1).collect();

    if args.is_empty() {
        println!("# Usage: x <short-command> [args...]");
        std::process::exit(1);
    }

    let mut command_name = args.remove(0);
    let mut node_flags = String::new();

    if command_name.starts_with("--inspect")
        || command_name.starts_with("--inspect-brk")
        || command_name.starts_with("--inspectBrk")
        || command_name.starts_with("--inspect-wait")
        || command_name.starts_with("--inspectWait")
    {
        let has_node_options = env::var("NODE_OPTIONS").is_ok();
        let prefix = if has_node_options { "\"$NODE_OPTIONS " } else { "" };
        node_flags = format!(
            "NODE_OPTIONS={}{}\" ",
            prefix,
            command_name
                .replace("inspectBrk", "inspect-brk")
                .replace("inspectWait", "inspect-wait")
        );
        if args.is_empty() {
            println!("# Usage: x <short-command> [args...]");
            std::process::exit(1);
        }
        command_name = args.remove(0);
    }

    let query_parts = split(&command_name);

    let mut local_scripts: Option<Vec<String>> = None;
    let mut global_scripts_map: HashMap<String, GlobalScript> = HashMap::new();
    let mut binary_map: HashMap<String, PathBuf> = HashMap::new();

    let mut current_dir = cwd.clone();
    loop {
        let package_json_path = current_dir.join("package.json");
        if package_json_path.exists() {
            if let Ok(contents) = fs::read_to_string(&package_json_path) {
                if let Ok(package_json) = serde_json::from_str::<PackageJson>(&contents) {
                    if let Some(scripts) = package_json.scripts {
                        if local_scripts.is_none() {
                            let mut keys: Vec<String> = scripts.keys().cloned().collect();
                            keys.sort_by(|a, b| a.len().cmp(&b.len()));
                            local_scripts = Some(keys);
                        } else {
                            for name in scripts.keys() {
                                if !global_scripts_map.contains_key(name) {
                                    global_scripts_map.insert(
                                        name.clone(),
                                        GlobalScript {
                                            cwd: current_dir.clone(),
                                        },
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }

        let bin_dir = current_dir.join("node_modules").join(".bin");
        if bin_dir.exists() {
            if let Ok(entries) = fs::read_dir(bin_dir) {
                for entry in entries.flatten() {
                    if let Ok(file_name) = entry.file_name().into_string() {
                        if !binary_map.contains_key(&file_name) {
                            if let Some(parent) = entry.path().parent() {
                                binary_map.insert(file_name, parent.to_path_buf());
                            }
                        }
                    }
                }
            }
        }

        if !current_dir.pop() {
            break;
        }
    }

    let formatted_arguments = format_shell_arguments(&args);

    if let Some(locals) = &local_scripts {
        if let Some(resolved) = resolve(locals, &query_parts) {
            let args_str = if !formatted_arguments.is_empty() {
                format!(" -- {}", formatted_arguments.join(" "))
            } else {
                String::new()
            };
            println!("{}node --run {}{}", node_flags, resolved, args_str);
            std::process::exit(0);
        }
    }

    let global_candidates: Vec<String> = global_scripts_map.keys().cloned().collect();
    if let Some(resolved) = resolve(&global_candidates, &query_parts) {
        if let Some(match_script) = global_scripts_map.get(&resolved) {
            let target_cwd = &match_script.cwd;
            let is_local = target_cwd == &cwd;

            let mut normalized_arguments = args.clone();
            if !is_local && !normalized_arguments.is_empty() {
                normalized_arguments = normalized_arguments
                    .into_iter()
                    .map(|arg| {
                        let p = Path::new(&arg);
                        if p.exists() {
                            if let Ok(abs) = cwd.join(p).canonicalize() {
                                return abs.to_string_lossy().into_owned();
                            }
                        }
                        arg
                    })
                    .collect();
            }

            let normalized_formatted_arguments = format_shell_arguments(&normalized_arguments);
            let args_str = if !normalized_formatted_arguments.is_empty() {
                format!(" -- {}", normalized_formatted_arguments.join(" "))
            } else {
                String::new()
            };

            println!(
                "(cd \"{}\" && {}node --run {}{})",
                target_cwd.display(),
                node_flags,
                resolved,
                args_str
            );
            std::process::exit(0);
        }
    }

    let mut binary_candidates: Vec<String> = binary_map.keys().cloned().collect();
    binary_candidates.sort();

    if let Some(resolved_binary) = resolve(&binary_candidates, &query_parts) {
        let mut executable_path = format!("npx {}", command_name);
        if let Some(location) = binary_map.get(&resolved_binary) {
            let full_path = location.join(&resolved_binary);
            executable_path = full_path.to_string_lossy().into_owned();
        }

        let args_str = if !formatted_arguments.is_empty() {
            format!(" {}", formatted_arguments.join(" "))
        } else {
            String::new()
        };
        println!("{}{}{}", node_flags, executable_path, args_str);
        std::process::exit(0);
    }

    let args_str = if !formatted_arguments.is_empty() {
        format!(" {}", formatted_arguments.join(" "))
    } else {
        String::new()
    };
    println!("{}npx {}{}", node_flags, command_name, args_str);
}
