# Clipboard
A simple python script for interacting with your clipboard

For convinience, it is recommended to alias this file, like:
```zsh
alias clipboard="python3 /path/to/clip_board.py"
```

Then you can call it like this:
```zsh
clipboard
```
to print your clipboard. This output can be redirected into another
application, like this:
```zsh
clipboard | echo
```

Also, you can use this script to copy the output of another command.
For example:
```zsh
ls | clipboard
```

Note: this script is named `clip_board.py` instead of `clipboard.py`
because the later causes a circular import since one of the imports
is also called `clipboard`
