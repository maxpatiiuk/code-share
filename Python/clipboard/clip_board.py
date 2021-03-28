import clipboard
import sys

if sys.stdin.isatty():
    print(clipboard.paste())
else:
    clipboard.copy(sys.stdin.read())

