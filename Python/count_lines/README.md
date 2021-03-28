# Count lines
Count the total number of lines of code in all of the files in a
directory.

Usage:
```zsh
python3 count_lines.py "*.*"
```

Last parameter is an optinal filter

Alternatively, you can use build in commands to atchive a similar
result:
```zsh 
find . -name '*.*' | xargs wc -l
```

