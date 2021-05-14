import os
import sys
import subprocess


target = sys.argv[1]
is_dir = target.endswith('/')
directory = os.getcwd()

while True:
    if (
        (is_dir and os.path.isdir(os.path.join(directory, target))) or
        (not is_dir and os.path.isfile(os.path.join(directory, target)))
    ):
        print(directory)
        exit(0)
    if directory == '/':
        exit(1)
    directory = os.path.dirname(directory)

