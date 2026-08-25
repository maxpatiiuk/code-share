use serde::Deserialize;
use std::collections::{HashMap, HashSet};
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

#[derive(Debug, PartialEq)]
struct JavaScriptTarget {
    name: String,
    path: PathBuf,
}

#[derive(Clone, Copy, Debug, Eq, Ord, PartialEq, PartialOrd)]
struct MatchScore {
    exact_penalty: bool,
    unmatched_parts: usize,
    unmatched_characters: usize,
}

#[derive(Debug, PartialEq)]
enum PrimaryTarget<'a> {
    Script(&'a str),
    JavaScript(&'a JavaScriptTarget),
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

fn matches_query(candidate: &str, query_parts: &[Vec<Vec<String>>]) -> bool {
    let candidate_parts = split(candidate);
    query_parts.iter().enumerate().all(|(index, sub_parts)| {
        sub_parts
            .iter()
            .enumerate()
            .all(|(sub_index, sub_sub_parts)| {
                sub_sub_parts
                    .iter()
                    .enumerate()
                    .all(|(sub_sub_index, part)| {
                        if let Some(candidate_sub_parts) = candidate_parts.get(index) {
                            if let Some(candidate_sub_sub_parts) =
                                candidate_sub_parts.get(sub_index)
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
    })
}

fn resolve(candidates: &[String], query_parts: &[Vec<Vec<String>>]) -> Option<String> {
    candidates
        .iter()
        .find(|candidate| matches_query(candidate, query_parts))
        .cloned()
}

fn match_score(
    candidate: &str,
    scoring_name: &str,
    query: &str,
    query_parts: &[Vec<Vec<String>>],
) -> Option<MatchScore> {
    if !matches_query(candidate, query_parts) {
        return None;
    }

    let scoring_parts = split(scoring_name);
    let part_count = |parts: &[Vec<Vec<String>>]| {
        parts
            .iter()
            .flat_map(|parts| parts.iter())
            .map(Vec::len)
            .sum::<usize>()
    };
    let character_count = |parts: &[Vec<Vec<String>>]| {
        parts
            .iter()
            .flat_map(|parts| parts.iter())
            .flat_map(|parts| parts.iter())
            .map(String::len)
            .sum::<usize>()
    };

    Some(MatchScore {
        exact_penalty: scoring_name != query && candidate != query,
        unmatched_parts: part_count(&scoring_parts).saturating_sub(part_count(query_parts)),
        unmatched_characters: character_count(&scoring_parts)
            .saturating_sub(character_count(query_parts)),
    })
}

fn resolve_primary_target<'a>(
    scripts: Option<&'a [String]>,
    javascript_targets: &'a [JavaScriptTarget],
    query: &str,
    query_parts: &[Vec<Vec<String>>],
) -> Option<PrimaryTarget<'a>> {
    let script_match =
        scripts
            .into_iter()
            .flatten()
            .enumerate()
            .filter_map(|(index, candidate)| {
                match_score(candidate, candidate, query, query_parts)
                    .map(|score| (score, index, candidate.as_str()))
            });
    let javascript_match = javascript_targets
        .iter()
        .enumerate()
        .filter_map(|(index, target)| {
            let scoring_name = target.name.strip_suffix(".js").unwrap_or(&target.name);
            match_score(&target.name, scoring_name, query, query_parts)
                .map(|score| (score, index, target))
        });

    let best_script = script_match.min_by_key(|(score, index, _)| (*score, *index));
    let best_javascript = javascript_match.min_by_key(|(score, index, _)| (*score, *index));

    match (best_script, best_javascript) {
        (Some((script_score, _, script)), Some((javascript_score, _, javascript))) => {
            if script_score <= javascript_score {
                Some(PrimaryTarget::Script(script))
            } else {
                Some(PrimaryTarget::JavaScript(javascript))
            }
        }
        (Some((_, _, script)), None) => Some(PrimaryTarget::Script(script)),
        (None, Some((_, _, javascript))) => Some(PrimaryTarget::JavaScript(javascript)),
        (None, None) => None,
    }
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

fn collect_javascript_targets(
    directory: &Path,
    depth: usize,
    seen: &mut HashSet<String>,
    targets: &mut Vec<JavaScriptTarget>,
) {
    let Ok(entries) = fs::read_dir(directory) else {
        return;
    };
    let mut files: Vec<String> = entries
        .flatten()
        .filter_map(|entry| {
            let path = entry.path();
            if path.is_file() && path.extension().is_some_and(|extension| extension == "js") {
                entry.file_name().into_string().ok()
            } else {
                None
            }
        })
        .collect();
    files.sort_by(|left, right| left.len().cmp(&right.len()).then_with(|| left.cmp(right)));

    for name in files {
        if seen.insert(name.clone()) {
            let mut path = PathBuf::new();
            for _ in 0..depth {
                path.push("..");
            }
            path.push(&name);
            targets.push(JavaScriptTarget { name, path });
        }
    }
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
        let prefix = if has_node_options {
            "\"$NODE_OPTIONS "
        } else {
            ""
        };
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
    let mut javascript_targets: Vec<JavaScriptTarget> = Vec::new();
    let mut seen_javascript_targets: HashSet<String> = HashSet::new();

    let mut current_dir = cwd.clone();
    let mut depth = 0;
    loop {
        let package_json_path = current_dir.join("package.json");
        if package_json_path.exists() {
            if let Ok(contents) = fs::read_to_string(&package_json_path) {
                if let Ok(package_json) = serde_json::from_str::<PackageJson>(&contents) {
                    if let Some(scripts) = package_json.scripts {
                        if local_scripts.is_none() {
                            let mut keys: Vec<String> = scripts.keys().cloned().collect();
                            keys.sort_by(|a, b| a.len().cmp(&b.len()).then_with(|| a.cmp(b)));
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

        collect_javascript_targets(
            &current_dir,
            depth,
            &mut seen_javascript_targets,
            &mut javascript_targets,
        );

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
        depth += 1;
    }

    let formatted_arguments = format_shell_arguments(&args);

    match resolve_primary_target(
        local_scripts.as_deref(),
        &javascript_targets,
        &command_name,
        &query_parts,
    ) {
        Some(PrimaryTarget::Script(resolved)) => {
            let args_str = if !formatted_arguments.is_empty() {
                format!(" -- {}", formatted_arguments.join(" "))
            } else {
                String::new()
            };
            println!("{}node --run {}{}", node_flags, resolved, args_str);
            std::process::exit(0);
        }
        Some(PrimaryTarget::JavaScript(target)) => {
            let args_str = if !formatted_arguments.is_empty() {
                format!(" {}", formatted_arguments.join(" "))
            } else {
                String::new()
            };
            println!(
                "{}node {}{}",
                node_flags,
                shell_quote(&target.path.to_string_lossy()),
                args_str
            );
            std::process::exit(0);
        }
        None => {}
    }

    let mut global_candidates: Vec<String> = global_scripts_map.keys().cloned().collect();
    global_candidates.sort_by(|a, b| a.len().cmp(&b.len()).then_with(|| a.cmp(b)));
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

#[cfg(test)]
mod tests {
    use super::*;
    use std::time::{SystemTime, UNIX_EPOCH};

    fn temporary_directory() -> PathBuf {
        let unique = SystemTime::now()
            .duration_since(UNIX_EPOCH)
            .unwrap()
            .as_nanos();
        let directory = env::temp_dir().join(format!("npm-run-{unique}"));
        fs::create_dir(&directory).unwrap();
        directory
    }

    #[test]
    fn collects_javascript_files_in_resolution_order() {
        let directory = temporary_directory();
        fs::write(directory.join("cli.js"), "").unwrap();
        fs::write(directory.join("cli.test.js"), "").unwrap();
        fs::write(directory.join("cli.mjs"), "").unwrap();
        fs::create_dir(directory.join("fake.js")).unwrap();

        let mut seen = HashSet::new();
        let mut targets = Vec::new();
        collect_javascript_targets(&directory, 1, &mut seen, &mut targets);

        assert_eq!(
            targets,
            vec![
                JavaScriptTarget {
                    name: "cli.js".to_string(),
                    path: PathBuf::from("../cli.js"),
                },
                JavaScriptTarget {
                    name: "cli.test.js".to_string(),
                    path: PathBuf::from("../cli.test.js"),
                },
            ]
        );
        fs::remove_dir_all(directory).unwrap();
    }

    #[test]
    fn keeps_the_nearest_javascript_file_with_the_same_name() {
        let nearest = temporary_directory();
        let parent = temporary_directory();
        fs::write(nearest.join("cli.js"), "").unwrap();
        fs::write(parent.join("cli.js"), "").unwrap();

        let mut seen = HashSet::new();
        let mut targets = Vec::new();
        collect_javascript_targets(&nearest, 0, &mut seen, &mut targets);
        collect_javascript_targets(&parent, 1, &mut seen, &mut targets);

        assert_eq!(
            targets,
            vec![JavaScriptTarget {
                name: "cli.js".to_string(),
                path: PathBuf::from("cli.js"),
            }]
        );
        fs::remove_dir_all(nearest).unwrap();
        fs::remove_dir_all(parent).unwrap();
    }

    #[test]
    fn resolves_javascript_files_without_the_extension() {
        let candidates = vec!["cli.js".to_string(), "cli.test.js".to_string()];

        assert_eq!(
            resolve(&candidates, &split("cli")),
            Some("cli.js".to_string())
        );
        assert_eq!(
            resolve(&candidates, &split("cli.t")),
            Some("cli.test.js".to_string())
        );
    }

    #[test]
    fn prefers_a_more_specific_javascript_target_over_a_script() {
        let scripts = vec!["core:docs".to_string()];
        let javascript_targets = vec![JavaScriptTarget {
            name: "cli.js".to_string(),
            path: PathBuf::from("cli.js"),
        }];

        assert_eq!(
            resolve_primary_target(Some(&scripts), &javascript_targets, "c", &split("c")),
            Some(PrimaryTarget::JavaScript(&javascript_targets[0]))
        );
        assert_eq!(
            resolve_primary_target(Some(&scripts), &javascript_targets, "c:d", &split("c:d")),
            Some(PrimaryTarget::Script("core:docs"))
        );
    }

    #[test]
    fn prefers_a_script_when_match_specificity_is_tied() {
        let scripts = vec!["cli".to_string()];
        let javascript_targets = vec![JavaScriptTarget {
            name: "cli.js".to_string(),
            path: PathBuf::from("cli.js"),
        }];

        assert_eq!(
            resolve_primary_target(Some(&scripts), &javascript_targets, "cli", &split("cli")),
            Some(PrimaryTarget::Script("cli"))
        );
    }
}
