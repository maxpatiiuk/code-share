import sys
import os
import collections
import typing
from termcolor import colored


## CONFIG
# The shell to use to call the editor
shell = '/usr/local/bin/zsh -ic'

# The editor to open when no parameters are passed
editor = 'v'

# The location of the file that would store the data structure
storage_file_location = '/Users/mambo/Documents/SPOTIFY.md'


def parse_file() -> typing.Dict[str, typing.List[str]]:
	with open(storage_file_location) as file:
		lines = file.read().split('\n')

	category_name = ''
	parsed_structure: typing.Dict[str, typing.List[str]] = collections.defaultdict(list)

	for line in lines:
		if line == '':
			continue
		elif line[0] == '#':
			category_name = line[2:]
		elif line[0] == '*':
			parsed_structure[category_name].append(line[2:])

	return parsed_structure


def is_unique(item_name: str) -> bool:
	for category_name, items in data.items():
		if item_name.lower() in [item.lower() for item in items]:
			return input('"%s" is already in "%s". Do you want to add it again? [y/n]: ' % (
				colored(item_name, 'red'),
				colored(category_name, 'red')
			)) == 'y'
	return True


def add(category_name: str, item_name: str) -> typing.NoReturn:
	if is_unique(item_name):
		data[category_name].append(item_name)


def save_changes() -> typing.NoReturn:
	categories = [
		'# %s\n%s' % (
			category_name,
			'\n'.join(
				[
					'* %s' % item_name for item_name in items
				]
			)
		) for category_name, items in data.items()
	]

	with open(storage_file_location, 'w') as file:
		file.write('\n\n'.join(categories))


# if no parameters specified, open file for editing
if len(sys.argv) == 1:
	os.system('%s "%s %s"' % (shell, editor, storage_file_location))
	exit()

data: typing.Final = parse_file()

if sys.argv[1] == 'add':
	if len(sys.argv) >= 4:
                add(sys.argv[2], ' '.join(sys.argv[3:]))
	else:
		add(input('Category name: '), input('Artist name: '))

save_changes()

