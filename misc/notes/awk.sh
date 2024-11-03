## Sources

# https://www.geeksforgeeks.org/awk-command-unixlinux-examples/
# https://www.gnu.org/software/gawk/manual/gawk.html

## Impressions

# Useful for small scripts, but too unmaintainable and obscure on larger scripts
# It's quite concise for simple things, but more verbose for complex things
# Bad error messages
# Inconsistency between different awk variations. Limited regex support

## Meta

# Making an executable awk file:
# Add "#! /bin/awk -f" at the top
# Run `chmod +x file.awk`

# Use # for comments

# Use -d to dump variables to file or -D to debug awk files

# --csv for csv files # awk 'BEGIN { FS = "," } { print $0 }' test.csv

## Basic

# Pipe through unchanged
l | awk '{print}' # l # l | awk '{print $0}'

# Print lines containing DS
l | awk '/DS/ {print}' # l | grep DS # l | awk '/DS/'

# Print line number, space, and entire line
l | awk '{print NR,$0}'

# Print 3-6th lines, 6th field, dash, 7th space, and last field (field is space separated line part)
l | awk 'NR==3,NR==6 {print $6 " - " $7,$NF}'

# Print pre-last field
l | awk '{ print $(NF-1) }'

# Print non-empty lines
l | awk 'NF > 0'

# Print short lines
l | awk 'length($0) < 10'

# Print largest file
ls -la | awk '{ if($5 > max) max = $5 } END {print max}'

# Sum file sizes
ls -la | awk '{ max += $5 } END {print max / 1024 "kb"}'

# Print longest line length (END executes after per-line code)
l | awk '{ if(length($0) > max) max = length($0) } END {print max}'

# Count lines in file
l | awk 'END { print NF }' # l | wc -l

# Print every other line
l | awk 'NR % 2 == 0'

# Count lines containing "yarn"
l | awk '/yarn/ { max += 1 } END { print max }'

# Filter input to only lines containing "This"
awk '/This/'

# Print lines containing DS. Also print lines containing yarn
l | awk '/DS/ /yarn/'

# Match regex against 8th field
l | awk '$8 ~ /yarn/' # awk '{ if ($8 ~ /yarn/) print $0 }'

# Not yarn, and with fewer than 10 files inside:
l | awk '$8 !~ /yarn/ && $2 < 10'

# Split by character
l | awk 'BEGIN { FS = "" } {for (i = 1; i <= NF; i = i + 1) print NR, "Field", i, "is", $i }'
