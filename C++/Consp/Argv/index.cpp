// copy.cpp : Defines the entry point for the console application.
//

#include "stdafx.h"
int main(int argc, char* argv[])
{
	if (argc == 3)
	{
		if (_access(argv[1], 00)!=0)
		{
			cout << "Source file not found" << endl;
			return 0;
		}
		if (_access(argv[2], 00) == 0)
		{
			char q;
			cout << "Destination file exists. Do you want to rewrite it? (Yes - y)" << endl;
			q = _getch();
			if (q != 'Y' && q != 'y')
			{
				cout << "Action is cancel
";
				return 0;
			}
		}

		FILE *source, *dest;

		source = fopen(argv[1], "rb");
		if (!source)
		{
			cout << "Error reading file" << endl;
			return 0;
		}
		dest = fopen(argv[2], "wb");
		if (!dest)
		{
			cout << "Error writing file" << endl;
			return 0;
		}
		do
		{
			char *str = new char[1000];
			fgets(str, 1000, source);
			fputs(str, dest);
			delete[]str;
		} while (!feof(source));
		fclose(source);
		fclose(dest);
		cout << "File was sucessfull copy" << endl;
	}
	else
	{
		cout << "Syntax error
";
	}
	return 0;
}