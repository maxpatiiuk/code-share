# Clipboard
A simple python script for interacting with your clipboard

For convinience, it is recommended to alias this file, like:
```zsh
alias clipboard="python3 /path/to/clipboard.py"
```

Then you can call it like this:
```zsh
clipboard
```
to print your clipboard. This output can be redirected into another
application, like this:
```zsh
clipboard > tts
```

Also, you can use this script to copy the output of another command.
For example:
```zsh
ls / | clipboard
```

