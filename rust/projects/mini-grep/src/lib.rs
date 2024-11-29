use std::env;
use std::error::Error;
use std::fs;

pub struct Config {
    pub query: String,
    pub file_path: String,
    pub ignore_case: bool,
}

impl Config {
    // We return constant strings that exists for the whole lifecycle of the
    // program, thus use 'static
    pub fn build(mut args: impl Iterator<Item = String>) -> Result<Config, &'static str> {
        // Skip program name
        args.next();

        let query = args.next().ok_or("1st argument (query) not provided")?;
        let file_path = args.next().ok_or("2nd argument (file path) not provided")?;
        let ignore_case = env::var("IGNORE_CASE").is_ok();

        Ok(Config {
            query,
            file_path,
            ignore_case,
        })
    }
}

pub fn run(config: Config) -> Result<(), Box<dyn Error>> {
    let contents = fs::read_to_string(config.file_path)?;

    let results = search(&contents, &config.query, config.ignore_case);

    // Can use eprintln for printing to stderr
    println!("{}", results.join("\n"));

    Ok(())
}

fn search<'a>(contents: &'a str, query: &'a str, ignore_case: bool) -> Vec<&'a str> {
    let lowercase_query: Option<String>;
    let mut canonical_query = query;

    // Performance micro-optimization: don't create a lowercase string unless
    // we need to, while also avoiding copying "query" into "canonical_query".
    if ignore_case {
        lowercase_query = Some(query.to_lowercase());
        // Alternative: Box::leak(query.to_lowercase().into_boxed_str())
        canonical_query = &lowercase_query.as_ref().map_or(canonical_query, |s| &s);
    }

    contents
        .lines()
        .filter(|line| {
            // FEATURE: try extracting this condition outside the arrow?
            if ignore_case {
                line.to_lowercase().contains(canonical_query)
            } else {
                line.contains(canonical_query)
            }
        })
        .collect()
}

#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    fn config_new() {
        let args = vec![
            String::from("mini-grep"),
            String::from("query"),
            String::from("file_path"),
        ]
        .into_iter();
        let config = Config::build(args).unwrap();

        assert_eq!(config.query, "query");
        assert_eq!(config.file_path, "file_path");
    }

    #[test]
    fn case_sensitive() {
        let contents = "Test\ning of\nsearch fun\nct ion ing";
        let query = "ing";

        let results = search(contents, query, false);

        assert_eq!(results, vec!["ing of", "ct ion ing"]);
    }

    #[test]
    fn case_insensitive() {
        let contents = "Test\nING of\nsearch fun\nct ion iNg";
        let query = "inG";

        let results = search(contents, query, true);

        assert_eq!(results, vec!["ING of", "ct ion iNg"]);
    }
}
