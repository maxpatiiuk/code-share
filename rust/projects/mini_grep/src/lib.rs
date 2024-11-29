//! # mini-grep
//!
//! Minimal grep implementation in Rust

use std::env;
use std::error::Error;
use std::fs;

pub struct Config {
    pub query: String,
    pub file_path: String,
    pub ignore_case: bool,
}

impl Config {
    /// Parse program configuration from the env variables
    ///
    /// # Examples
    ///
    /// ```
    /// use std::env;
    /// use std::error::Error;
    /// use mini_grep::{Config};
    ///
    /// // Can also use env::args() to get the arguments
    /// let args = vec![
    ///  String::from("mini-grep"),
    ///  String::from("query"),
    ///  String::from("file_path"),
    /// ].into_iter();
    /// let config = Config::build(args).unwrap();
    /// println!("Query: {}", config.query);
    /// println!("File path: {}", config.file_path);
    /// ```
    ///
    /// # Panics
    ///
    /// Never
    ///
    /// # Errors
    ///
    /// - If 1st argument (query) not provided
    /// - If 2nd argument (file path) not provided
    pub fn build(mut args: impl Iterator<Item = String>) -> Result<Config, &'static str> {
        // We return constant strings that exists for the whole lifecycle of the
        // program, thus use 'static

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

    let results = if config.ignore_case {
        search_insensitive(&contents, &config.query)
    } else {
        search(&contents, &config.query)
    };

    // Can use eprintln for printing to stderr
    println!("{}", results.join("\n"));

    Ok(())
}

fn search<'a>(contents: &'a str, query: &'a str) -> Vec<&'a str> {
    contents
        .lines()
        .filter(|line| line.contains(query))
        .collect()
}

fn search_insensitive<'a>(contents: &'a str, query: &'a str) -> Vec<&'a str> {
    let lowercase_query = query.to_lowercase();

    contents
        .lines()
        .filter(|line| line.to_lowercase().contains(&lowercase_query))
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

        let results = search(contents, query);

        assert_eq!(results, vec!["ing of", "ct ion ing"]);
    }

    #[test]
    fn case_insensitive() {
        let contents = "Test\nING of\nsearch fun\nct ion iNg";
        let query = "inG";

        let results = search_insensitive(contents, query);

        assert_eq!(results, vec!["ING of", "ct ion iNg"]);
    }
}
