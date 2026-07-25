# Exit on error or undefined variable
set -eu

# Ctrl + W - delete last word
# Ctrl + L - clean screen

mv temp.{txt,md} # rename temp.txt to temp.md
cp test.ts{,.bak} # copy test.ts to test.ts.bak
touch test.{a,b,c} # create empty files test.a, test.b, test.c

diff <(sort a.txt) <(sort b.txt) # Treat output as if it were a file

# | - pipe stdout
# |& - pipe both stdout and stderr (short for 2>&1 |)