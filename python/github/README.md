# CLI integration with GitHub Web UI

Add this to your shell init file. Change the python script path to correct
location

```sh
g() {
  output=$(python3 ~/site/git/code_share/Python/github/github.py $@)
  if [[ "${output}" =~ "^cd " ]]; then
    # Running in Github URL to CLI mode
    eval ${output}
  else
    # Running in CLI to GitHub mode
    echo ${output}
  fi
}
```

## Open current directory in GitHub

Before running this script, cd into some dir inside of a cloned repository.
Also, you need to have GitHub setup as one of the remotes

Optional parameters:

- `-b` - branch (defaults to current branch or master/main)

  if parameter ends or starts with `.`, it tries to autocomplete the name

- `-r` - name of the remote (defaults to origin or first one alphabetically)
- `-f` - file to open (defaults to opening directory)

Example usage:

```sh
g -b master -r origin -f README.md
```

Or using default arguments:

```sh
g
```

## Open GitHub Webpage in terminal

Navigates to the directory or the file based on GitHub URL.

Create the

Before running the script, `cd` to correct repository.

For example, this will navigate to the root directory of current repository:

```sh
g https://github.com/specify/specify7/tree/production/
```

Besides navigation, it would also list files in that directory using `ls`
command. That behaviour can be customized by setting `LIST_FILES` environment
variable to the command you want to run instead

For example:

```sh
# In init file:
export LIST_FILES="ls -ahl"
# Later:
g https://github.com/specify/specify7/tree/production/
```

And this will open the `README.md` file in your editor:

```sh
g https://github.com/specify/specify7/blob/production/README.md
```

Note, this script would not change the current branch
