#include <iostream>
#include <fstream>
#include <io.h>
#include <string>
using namespace std;
int i=0, ii;
string buf[50];
void main() {
	ifstream inp("input.txt");
	while (!inp.eof()) {
		i++;
		getline(inp, buf[i]);
	}
	inp.close();
	ofstream out("output.txt");
	for (ii=i; ii > 0; ii--) {
		out << buf[ii] << endl;
	}
	out.close();
}