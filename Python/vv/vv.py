import sys
import os
from pathlib import Path


shell = '/usr/local/bin/zsh -ic'  # the shell to call
editor = 'v'  # the editor to call


def run_editor(file=''):
    os.system('%s "%s %s"' % (shell, editor,file))


if len(sys.argv) == 1:
    run_editor()

file_to_create = sys.argv[1]
file_location, file_name = os.path.split(file_to_create)
if file_location == '':
    file_location = './'

Path(file_location).mkdir(parents=True, exist_ok=True)

run_editor(*sys.argv[1:])

