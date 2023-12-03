A quick and dirty set of scripts for maintenance and cleanup of git history
across many repositories in bulk.

Example uses:

- get list of all authors that contributed to repositories
  - get list of git authors that you used
- see list of commits made using those authors
- replace all authors in those commits with a canonical git author, while
  maintaining authored and committed date, and preserving history as much as
  possible, and replacing only where safe
- search for occurrences of legacy words across the repositories and allow to
  replace them
- search for occurrences of legacy words across commit messages
