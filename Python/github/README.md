# Open current directory in GitHub

Before running this script, cd into some dir inside of a cloned
repository. Also, you need to have GitHub setup as one of the remotes

Optional parameters:
 -b - branch (defaults to current branch or master/main)
      if parameter ends or starts with `.`, it tries to autocomplete
      the name
 -r - name of the remote (defaults to origin or first one
      alphabetically)
 -f - file to open (defaults to opening directory)

Example usage:
```zsh
python github.py -b master -r origin -f README.md
```
Or using default arguments:
```zsh
python github.py
```

