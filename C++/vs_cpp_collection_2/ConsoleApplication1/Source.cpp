#include <iostream>
#include <fstream>
#include <io.h>
#include <string>
using namespace std;
int i = 0, ii, iii;
string buf[50], buff;
void main() {
	ifstream inp("input.txt");
	while (!inp.eof()) {
		i++;
		getline(inp, buf[i]);
	}
	inp.close();
	ofstream out("output.txt");
	for (ii = i; ii > 0; ii--) {
/*		iii = buf[ii].length;*/
		buf[ii].erase(iii - 2, 2);
		buff = buf[ii];
		std::size_t found = buf[ii].find("m2");
		if (found != std::string::npos)
			cout << "num: " << found;
		out << buf[ii] << endl;
	}
	out.close();
}


