use serde::Deserialize;
use std::collections::{HashMap, HashSet};
use std::env;
use std::fs;
use std::path::{Path, PathBuf};

#[derive(Deserialize)]
struct PackageJson {
    name: Option<String>,
    #[serde(rename = "packageManager")]
    package_manager: Option<String>,
    scripts: Option<HashMap<String, String>>,
    workspaces: Option<Workspaces>,
}

#[derive(Deserialize)]
#[serde(untagged)]
enum Workspaces {
    Patterns(Vec<String>),
    Config { packages: Vec<String> },
}

impl Workspaces {
    fn patterns(&self) -> &[String] {
        match self {
            Self::Patterns(patterns) => patterns,
            Self::Config { packages } => packages,
        }
    }
}

#[derive(Default, Deserialize)]
struct PnpmWorkspace {
    #[serde(default)]
    packages: Vec<String>,
}

#[derive(Clone, Copy, Debug, Eq, PartialEq)]
enum PackageManager {
    Npm,
    Pnpm,
    Yarn,
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
            b'a'..=b'z'
                | b'A'..=b'Z'
                | b'0'..=b'9'
                | b'_'
                | b'-'
                | b'.'
                | b'/'
                | b':'
                | b'='
                | b'@'
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

fn parse_filter(args: &mut Vec<String>) -> Result<Option<String>, String> {
    let Some(first) = args.first() else {
        return Ok(None);
    };
    let inline_filter = ["--filter=", "-f=", "-F="]
        .iter()
        .find_map(|prefix| first.strip_prefix(prefix));
    if let Some(filter) = inline_filter {
        if filter.is_empty() {
            return Err("# Filter requires a package name".to_string());
        }
        let filter = filter.to_string();
        args.remove(0);
        return Ok(Some(filter));
    }
    if !matches!(first.as_str(), "-f" | "-F" | "--filter") {
        return Ok(None);
    }
    if args.len() < 2 || args[1].is_empty() {
        return Err("# Filter requires a package name".to_string());
    }

    args.remove(0);
    Ok(Some(args.remove(0)))
}

fn read_package_json(path: &Path) -> Option<PackageJson> {
    fs::read_to_string(path)
        .ok()
        .and_then(|contents| serde_json::from_str(&contents).ok())
}

fn find_workspace_root(cwd: &Path) -> Option<PathBuf> {
    let mut directory = cwd.to_path_buf();
    let mut turbo_root = None;
    let mut package_root = None;
    loop {
        let package_json_path = directory.join("package.json");
        if package_json_path.exists() {
            package_root.get_or_insert_with(|| directory.clone());
            if read_package_json(&package_json_path)
                .and_then(|package_json| package_json.workspaces)
                .is_some()
                || directory.join("pnpm-workspace.yaml").exists()
            {
                return Some(directory);
            }
        }
        if directory.join("turbo.json").exists() {
            turbo_root = Some(directory.clone());
        }
        if !directory.pop() {
            break;
        }
    }
    turbo_root.or(package_root)
}

fn workspace_patterns(root: &Path) -> Vec<String> {
    let pnpm_workspace_path = root.join("pnpm-workspace.yaml");
    if let Ok(contents) = fs::read_to_string(pnpm_workspace_path) {
        if let Ok(workspace) = serde_yaml::from_str::<PnpmWorkspace>(&contents) {
            if !workspace.packages.is_empty() {
                return workspace.packages;
            }
        }
    }
    read_package_json(&root.join("package.json"))
        .and_then(|package_json| package_json.workspaces)
        .map(|workspaces| workspaces.patterns().to_vec())
        .unwrap_or_default()
}

fn collect_workspace_packages(root: &Path) -> Vec<String> {
    let patterns = workspace_patterns(root);
    let exclusions: Vec<glob::Pattern> = patterns
        .iter()
        .filter_map(|pattern| pattern.strip_prefix('!'))
        .filter_map(|pattern| glob::Pattern::new(pattern).ok())
        .collect();
    let mut names = HashSet::new();

    if let Some(name) =
        read_package_json(&root.join("package.json")).and_then(|package_json| package_json.name)
    {
        names.insert(name);
    }
    for pattern in patterns.iter().filter(|pattern| !pattern.starts_with('!')) {
        let manifest_pattern = root.join(pattern).join("package.json");
        let Some(manifest_pattern) = manifest_pattern.to_str() else {
            continue;
        };
        let Ok(manifests) = glob::glob(manifest_pattern) else {
            continue;
        };
        for manifest in manifests.flatten() {
            let relative_directory = manifest
                .parent()
                .and_then(|directory| directory.strip_prefix(root).ok());
            if relative_directory.is_some_and(|directory| {
                exclusions
                    .iter()
                    .any(|pattern| pattern.matches_path(directory))
            }) {
                continue;
            }
            if let Some(name) =
                read_package_json(&manifest).and_then(|package_json| package_json.name)
            {
                names.insert(name);
            }
        }
    }

    let mut names: Vec<String> = names.into_iter().collect();
    names.sort();
    names
}

fn unscoped_package_name(name: &str) -> &str {
    name.rsplit_once('/').map_or(name, |(_, name)| name)
}

fn scoped_package_match_score(package: &str, query: &str) -> Option<MatchScore> {
    let (package_scope, package_name) = package.split_once('/')?;
    let (query_scope, query_name) = query.split_once('/')?;
    let scope_score = match_score(
        package_scope,
        package_scope,
        query_scope,
        &split(query_scope),
    )?;
    let name_score = match_score(package_name, package_name, query_name, &split(query_name))?;

    Some(MatchScore {
        exact_penalty: scope_score.exact_penalty || name_score.exact_penalty,
        unmatched_parts: scope_score.unmatched_parts + name_score.unmatched_parts,
        unmatched_characters: scope_score.unmatched_characters + name_score.unmatched_characters,
    })
}

fn resolve_package_filter(packages: &[String], query: &str) -> String {
    let query_parts = split(query);
    packages
        .iter()
        .filter_map(|package| {
            let unscoped = unscoped_package_name(package);
            let (match_kind, score) = if package == query {
                (0, None)
            } else if unscoped == query {
                (1, None)
            } else if let Some(score) = scoped_package_match_score(package, query) {
                (2, Some(score))
            } else {
                (3, match_score(unscoped, unscoped, query, &query_parts))
            };
            (match_kind < 3 || score.is_some()).then_some((
                match_kind,
                score,
                unscoped.len(),
                package,
            ))
        })
        .min_by_key(|(match_kind, score, length, package)| {
            (*match_kind, *score, *length, package.as_str())
        })
        .map_or_else(|| query.to_string(), |(_, _, _, package)| package.clone())
}

fn workspace_package_scripts(root: &Path, package_name: &str) -> Vec<String> {
    let patterns = workspace_patterns(root);
    let exclusions: Vec<glob::Pattern> = patterns
        .iter()
        .filter_map(|pattern| pattern.strip_prefix('!'))
        .filter_map(|pattern| glob::Pattern::new(pattern).ok())
        .collect();
    let root_manifest = root.join("package.json");
    let manifests = std::iter::once(root_manifest).chain(
        patterns
            .iter()
            .filter(|pattern| !pattern.starts_with('!'))
            .filter_map(|pattern| {
                root.join(pattern)
                    .join("package.json")
                    .to_str()
                    .map(str::to_string)
            })
            .filter_map(|pattern| glob::glob(&pattern).ok())
            .flatten()
            .flatten(),
    );

    for manifest in manifests {
        let relative_directory = manifest
            .parent()
            .and_then(|directory| directory.strip_prefix(root).ok());
        if relative_directory.is_some_and(|directory| {
            exclusions
                .iter()
                .any(|pattern| pattern.matches_path(directory))
        }) {
            continue;
        }
        let Some(package_json) = read_package_json(&manifest) else {
            continue;
        };
        if package_json.name.as_deref() == Some(package_name) {
            let mut scripts: Vec<String> = package_json
                .scripts
                .unwrap_or_default()
                .into_keys()
                .collect();
            scripts
                .sort_by(|left, right| left.len().cmp(&right.len()).then_with(|| left.cmp(right)));
            return scripts;
        }
    }
    Vec::new()
}

fn resolve_turbo_task_arguments(args: &[String], tasks: &[String]) -> Vec<String> {
    let mut resolved = args.to_vec();
    let task_start = usize::from(resolved.first().is_some_and(|argument| argument == "run"));
    for argument in resolved.iter_mut().skip(task_start) {
        if argument == "--" || argument.starts_with('-') {
            break;
        }
        if let Some(task) = resolve(tasks, &split(argument)) {
            *argument = task;
        }
    }
    resolved
}

fn package_manager(root: &Path) -> PackageManager {
    let declared = read_package_json(&root.join("package.json"))
        .and_then(|package_json| package_json.package_manager)
        .unwrap_or_default();
    if declared.starts_with("pnpm@") || root.join("pnpm-lock.yaml").exists() {
        PackageManager::Pnpm
    } else if declared.starts_with("yarn@") || root.join("yarn.lock").exists() {
        PackageManager::Yarn
    } else {
        PackageManager::Npm
    }
}

fn insert_turbo_filter(args: &[String], package: &str) -> Vec<String> {
    let mut args = args.to_vec();
    let insertion_index = args
        .iter()
        .position(|arg| arg == "--")
        .unwrap_or(args.len());
    args.insert(insertion_index, format!("--filter={package}"));
    args
}

fn format_filtered_binary(
    root: &Path,
    manager: PackageManager,
    package: &str,
    binary: &str,
    args: &[String],
    node_flags: &str,
) -> String {
    let mut command = match manager {
        PackageManager::Pnpm if binary == "pnpm" => {
            format!("pnpm --filter={}", shell_quote(package))
        }
        PackageManager::Pnpm => format!(
            "pnpm --filter={} exec {}",
            shell_quote(package),
            shell_quote(binary)
        ),
        PackageManager::Yarn if binary == "yarn" => {
            format!("yarn workspace {}", shell_quote(package))
        }
        PackageManager::Yarn => format!(
            "yarn workspace {} {}",
            shell_quote(package),
            shell_quote(binary)
        ),
        PackageManager::Npm if binary == "npm" => {
            format!("npm --workspace={}", shell_quote(package))
        }
        PackageManager::Npm => format!(
            "npm exec --workspace={} -- {}",
            shell_quote(package),
            shell_quote(binary)
        ),
    };
    let formatted_args = format_shell_arguments(args);
    if !formatted_args.is_empty() {
        command.push(' ');
        command.push_str(&formatted_args.join(" "));
    }
    format!(
        "(cd {} && {}{})",
        shell_quote(&root.to_string_lossy()),
        node_flags,
        command
    )
}

fn format_filtered_script(
    root: &Path,
    manager: PackageManager,
    package: &str,
    script: &str,
    args: &[String],
    node_flags: &str,
) -> String {
    let mut command = match manager {
        PackageManager::Pnpm => format!(
            "pnpm --filter={} run {}",
            shell_quote(package),
            shell_quote(script)
        ),
        PackageManager::Yarn => format!(
            "yarn workspace {} run {}",
            shell_quote(package),
            shell_quote(script)
        ),
        PackageManager::Npm => format!(
            "npm run --workspace={} {}",
            shell_quote(package),
            shell_quote(script)
        ),
    };
    let formatted_args = format_shell_arguments(args);
    if !formatted_args.is_empty() {
        command.push_str(" -- ");
        command.push_str(&formatted_args.join(" "));
    }
    format!(
        "(cd {} && {}{})",
        shell_quote(&root.to_string_lossy()),
        node_flags,
        command
    )
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

    let filter_query = match parse_filter(&mut args) {
        Ok(filter) => filter,
        Err(message) => {
            println!("{message}");
            std::process::exit(1);
        }
    };

    if args.is_empty() {
        println!("# Usage: x [-f <package>] <short-command> [args...]");
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
            println!("# Usage: x [-f <package>] <short-command> [args...]");
            std::process::exit(1);
        }
        command_name = args.remove(0);
    }

    let query_parts = split(&command_name);
    let workspace_root = find_workspace_root(&cwd);
    let resolved_filter = filter_query.as_deref().map(|query| {
        workspace_root.as_ref().map_or_else(
            || query.to_string(),
            |root| resolve_package_filter(&collect_workspace_packages(root), query),
        )
    });

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

    if resolved_filter.is_none() {
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
    }

    if resolved_filter.is_none() {
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
    }

    if let Some(package) = resolved_filter.as_deref() {
        let target_root = workspace_root.as_deref().unwrap_or(&cwd);
        let scripts = workspace_package_scripts(target_root, package);
        if let Some(script) = resolve(&scripts, &query_parts) {
            println!(
                "{}",
                format_filtered_script(
                    target_root,
                    package_manager(target_root),
                    package,
                    &script,
                    &args,
                    &node_flags,
                )
            );
            std::process::exit(0);
        }
    }

    let mut binary_candidates: Vec<String> = binary_map.keys().cloned().collect();
    binary_candidates.sort();

    if let Some(resolved_binary) = resolve(&binary_candidates, &query_parts) {
        if resolved_binary == "turbo" {
            let target_root = workspace_root.as_deref().unwrap_or(&cwd);
            let turbo_args = resolved_filter.as_deref().map_or_else(
                || args.clone(),
                |package| {
                    let tasks = workspace_package_scripts(target_root, package);
                    insert_turbo_filter(&resolve_turbo_task_arguments(&args, &tasks), package)
                },
            );
            let formatted_turbo_args = format_shell_arguments(&turbo_args);
            let args_str = if formatted_turbo_args.is_empty() {
                String::new()
            } else {
                format!(" {}", formatted_turbo_args.join(" "))
            };
            let binary_path = binary_map
                .get(&resolved_binary)
                .map(|location| location.join(&resolved_binary))
                .unwrap_or_else(|| PathBuf::from(&resolved_binary));
            println!(
                "(cd {} && {}{}{})",
                shell_quote(&target_root.to_string_lossy()),
                node_flags,
                shell_quote(&binary_path.to_string_lossy()),
                args_str
            );
            std::process::exit(0);
        }
        if let Some(package) = resolved_filter.as_deref() {
            let target_root = workspace_root.as_deref().unwrap_or(&cwd);
            println!(
                "{}",
                format_filtered_binary(
                    target_root,
                    package_manager(target_root),
                    package,
                    &resolved_binary,
                    &args,
                    &node_flags,
                )
            );
            std::process::exit(0);
        }
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

    if let Some(package) = resolved_filter.as_deref() {
        let target_root = workspace_root.as_deref().unwrap_or(&cwd);
        println!(
            "{}",
            format_filtered_binary(
                target_root,
                package_manager(target_root),
                package,
                &command_name,
                &args,
                &node_flags,
            )
        );
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
    use std::sync::atomic::{AtomicU64, Ordering};
    use std::time::{SystemTime, UNIX_EPOCH};

    static TEMPORARY_DIRECTORY_COUNTER: AtomicU64 = AtomicU64::new(0);

    fn temporary_directory() -> PathBuf {
        let unique = SystemTime::now()
            .duration_since(UNIX_EPOCH)
            .unwrap()
            .as_nanos();
        let counter = TEMPORARY_DIRECTORY_COUNTER.fetch_add(1, Ordering::Relaxed);
        let directory = env::temp_dir().join(format!("npm-run-{unique}-{counter}"));
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

    #[test]
    fn parses_filter_aliases_only_at_the_start() {
        for input in [
            vec!["-f", "m-c", "vite"],
            vec!["-F", "m-c", "vite"],
            vec!["--filter", "m-c", "vite"],
            vec!["--filter=m-c", "vite"],
        ] {
            let mut args: Vec<String> = input.into_iter().map(String::from).collect();
            assert_eq!(parse_filter(&mut args), Ok(Some("m-c".to_string())));
            assert_eq!(args, vec!["vite"]);
        }

        let mut args = vec!["vite".to_string(), "-f".to_string(), "m-c".to_string()];
        assert_eq!(parse_filter(&mut args), Ok(None));
        assert_eq!(args, vec!["vite", "-f", "m-c"]);
    }

    #[test]
    fn resolves_package_filters_deterministically() {
        let packages = vec![
            "@arcgis/map-components".to_string(),
            "@arcgis/map-core".to_string(),
            "@other/map-components".to_string(),
        ];

        assert_eq!(
            resolve_package_filter(&packages, "@other/map-components"),
            "@other/map-components"
        );
        assert_eq!(
            resolve_package_filter(&packages, "map-components"),
            "@arcgis/map-components"
        );
        assert_eq!(
            resolve_package_filter(&packages, "@a/m-c"),
            "@arcgis/map-core"
        );
        assert_eq!(
            resolve_package_filter(&packages, "@o/m-c"),
            "@other/map-components"
        );
        assert_eq!(resolve_package_filter(&packages, "m-c"), "@arcgis/map-core");
        assert_eq!(resolve_package_filter(&packages, "missing"), "missing");
    }

    #[test]
    fn discovers_packages_from_workspace_patterns() {
        let root = temporary_directory();
        fs::create_dir(root.join("packages")).unwrap();
        fs::create_dir(root.join("packages/map-components")).unwrap();
        fs::create_dir(root.join("packages/private")).unwrap();
        fs::write(
            root.join("package.json"),
            r#"{"name":"root","workspaces":["packages/*","!packages/private"]}"#,
        )
        .unwrap();
        fs::write(
            root.join("packages/map-components/package.json"),
            r#"{"name":"@arcgis/map-components"}"#,
        )
        .unwrap();
        fs::write(
            root.join("packages/private/package.json"),
            r#"{"name":"@arcgis/private"}"#,
        )
        .unwrap();

        assert_eq!(
            collect_workspace_packages(&root),
            vec!["@arcgis/map-components", "root"]
        );
        fs::remove_dir_all(root).unwrap();
    }

    #[test]
    fn inserts_turbo_filter_before_passthrough_arguments() {
        let args = vec!["build".to_string(), "--".to_string(), "--watch".to_string()];

        assert_eq!(
            insert_turbo_filter(&args, "@arcgis/map-components"),
            vec!["build", "--filter=@arcgis/map-components", "--", "--watch"]
        );
    }

    #[test]
    fn resolves_leading_turbo_task_abbreviations() {
        let tasks = vec![
            "build".to_string(),
            "test".to_string(),
            "build-dev".to_string(),
        ];

        assert_eq!(
            resolve_turbo_task_arguments(&["b".to_string()], &tasks),
            vec!["build"]
        );
        assert_eq!(
            resolve_turbo_task_arguments(
                &["run".to_string(), "b-d".to_string(), "t".to_string()],
                &tasks
            ),
            vec!["run", "build-dev", "test"]
        );
        assert_eq!(
            resolve_turbo_task_arguments(
                &["b".to_string(), "--dry".to_string(), "t".to_string(),],
                &tasks
            ),
            vec!["build", "--dry", "t"]
        );
        assert_eq!(
            resolve_turbo_task_arguments(
                &["b".to_string(), "--".to_string(), "t".to_string()],
                &tasks
            ),
            vec!["build", "--", "t"]
        );
    }

    #[test]
    fn reads_turbo_tasks_from_the_selected_package() {
        let root = temporary_directory();
        fs::create_dir_all(root.join("packages/map-components")).unwrap();
        fs::write(
            root.join("package.json"),
            r#"{"name":"root","workspaces":["packages/*"]}"#,
        )
        .unwrap();
        fs::write(
            root.join("packages/map-components/package.json"),
            r#"{"name":"@arcgis/map-components","scripts":{"build":"vite build","build-dev":"vite build --mode development"}}"#,
        )
        .unwrap();

        assert_eq!(
            workspace_package_scripts(&root, "@arcgis/map-components"),
            vec!["build", "build-dev"]
        );
        fs::remove_dir_all(root).unwrap();
    }

    #[test]
    fn resolves_filtered_package_script_abbreviations() {
        let scripts = vec![
            "start".to_string(),
            "start-external-storybook".to_string(),
            "start-internal-storybook".to_string(),
        ];

        for query in ["s-i", "start-in"] {
            assert_eq!(
                resolve(&scripts, &split(query)),
                Some("start-internal-storybook".to_string())
            );
        }
        assert_eq!(
            resolve(&scripts, &split("sta-")),
            Some("start-external-storybook".to_string())
        );
    }

    #[test]
    fn formats_filtered_package_scripts() {
        assert_eq!(
            format_filtered_script(
                Path::new("/repo"),
                PackageManager::Pnpm,
                "@arcgis/map-components",
                "start-internal-storybook",
                &["--quiet".to_string()],
                ""
            ),
            "(cd /repo && pnpm --filter=@arcgis/map-components run start-internal-storybook -- --quiet)"
        );
    }

    #[test]
    fn formats_filtered_binary_for_each_package_manager() {
        let root = Path::new("/repo");
        let args = vec!["--host".to_string()];

        assert_eq!(
            format_filtered_binary(
                root,
                PackageManager::Pnpm,
                "@arcgis/map-components",
                "vite",
                &args,
                ""
            ),
            "(cd /repo && pnpm --filter=@arcgis/map-components exec vite --host)"
        );
        assert_eq!(
            format_filtered_binary(
                root,
                PackageManager::Yarn,
                "@arcgis/map-components",
                "vite",
                &args,
                ""
            ),
            "(cd /repo && yarn workspace @arcgis/map-components vite --host)"
        );
        assert_eq!(
            format_filtered_binary(
                root,
                PackageManager::Npm,
                "@arcgis/map-components",
                "vite",
                &args,
                ""
            ),
            "(cd /repo && npm exec --workspace=@arcgis/map-components -- vite --host)"
        );
    }
}
