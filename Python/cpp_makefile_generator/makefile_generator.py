from os import listdir
from os.path import isfile, join
import sys

executable_name = 'Executable'


# getting list of files
if len(sys.argv) != 2:
	raise SystemExit('Provide valid folder path')

working_directory = sys.argv[1]

files = [file_name for file_name in listdir(working_directory) if isfile(join(working_directory, file_name))]

objects = {}

files_to_accept = ['cpp','h']

# creating list of objects
for file in files:

	object_parts = file.split('.')
	file_type = object_parts.pop()
	object_name = '.'.join(object_parts)

	if file_type not in files_to_accept or object_name == 'main':
		continue

	if object_name not in objects:
		objects[object_name] = {
			'cpp': False,
			'h': False,
			'is_template': False,
		}

	objects[object_name][file_type] = True

# checking if objects are templates
for object_name, object_data in objects.items():
	with open(join(working_directory, '%s.h' % object_name)) as file:
		file_content = file.read()
		if file_content.find('template <') != -1 or file_content.find('template<') != -1:
			object_data['is_template'] = True


def get_objects(has_cpp=True, is_template=False, return_extension='', concat=True):
	return_objects = []

	if return_extension != '':
		return_extension = '.' + return_extension

	for object_name, object_data in objects.items():
		if (object_data['cpp']==has_cpp or has_cpp is None) and (object_data['is_template']==is_template or is_template is None):
			return_objects.append('%s%s' % (object_name, return_extension))

	if concat:
		return ' '.join(return_objects)
	else:
		return return_objects


def get_compile_string(file):
	return '\n\tg++ -std=c++11 -g -Wall -c %s\n\n' % file


print(objects)

output = (
		'{executable_name}: {executables}\n\tg++ -std=c++11 -g -Wall {executables} -o {executable_name}\n\n' +
		'main.o: main.cpp {all_h} {templated_cpp} {compile_string}' +
		'{full_classes}' +
		'clean:\n\trm *.o {executable_name}'
	).format(
		executable_name=executable_name,
		executables='main.o ' + get_objects(has_cpp=True,is_template=False,return_extension='o'),
		all_h=get_objects(has_cpp=None,is_template=None,return_extension='h'),
		templated_cpp=get_objects(has_cpp=True,is_template=True,return_extension='cpp'),
		compile_string=get_compile_string('main.cpp'),
		full_classes=''.join(['{object_name}.o: {object_name}.h {object_name}.cpp'.format(object_name=object_name) + get_compile_string(object_name+'.cpp') for object_name in get_objects(has_cpp=True,is_template=False,concat=False)])
	)

with open(working_directory+'Makefile', 'w') as makefile:
	makefile.write(output)