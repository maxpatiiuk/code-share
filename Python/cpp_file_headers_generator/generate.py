import os
import sys
from datetime import date

authot_name = 'Max Patiiuk'
files_information = {
	'cpp': 'The implementation for the %s class',
	'h': 'The definitions for the %s class'
}
date = date.today().strftime("%d/%m/%Y")

# getting list of files
if len(sys.argv) != 2:
	raise SystemExit('Provide valid folder path')

working_directory = sys.argv[1]

files = [file_name for file_name in os.listdir(working_directory) if os.path.isfile(os.path.join(working_directory, file_name)) and os.path.splitext(file_name)[1][1:] in files_information.keys()]

for file_name in files:
	with open(os.path.join(working_directory, file_name), 'r+') as file:
		file_content = file.read()

		comment = ''
		partial_file_name, file_extension = os.path.splitext(file_name)
		file_extension = file_extension[1:]
		
		# ^(\/\*|\/\/)[^*+]+(\*\/|\/\/)[^@a-zA-Z#]+
		if has_comment := file_content[0:2] in ['//','/*']:

			comment_opening = file_content[0:2]
			comment = []
			line_number = 0

			for line in file_content.split('\n'):
				line_number = line_number + 1
				comment.append(line)
				if ((comment_opening == '//' and line[0:2] != '//')
					or
					(comment_opening == '/*' and line[0:2] == '*/')
					):
					break

			if line_number > 10:
				comment = ''
			else:
				comment = '\n'.join(comment)


		if file_name == 'main.cpp':
			brief = 'The main entry point for the program'
		else:
			brief = files_information[file_extension] % partial_file_name

		file_content = '/*\n\n@author {author}\n@file {file_name}\n@date {date}\n@brief {brief}\n\n*/\n\n{file_conent}'.format(
			author = authot_name,
			file_name = file_name,
			date = date,
			brief = brief,
			file_conent = file_content.replace(comment,'').strip(),
		)

		print(file_name)
		file.seek(0)
		file.write(file_content)
