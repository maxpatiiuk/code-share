import sys
import glob
import os


# find . -name '*.*' | xargs wc -l

filter_pattern = sys.argv[1] if len(sys.argv) > 1 \
    else '*.*'
files = glob.glob(os.path.join(sys.argv[1],filter_pattern))
total_line_count = 0

for file_name in files:
    with open(file_name) as file:
        line_count = len(file.read().split('\n'))
        print('%s: %d' % (file_name,line_count))
        total_line_count = total_line_count + line_count

print('Total lines: %d' % total_line_count)

