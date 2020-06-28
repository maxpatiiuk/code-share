#include <iostream>
#include <fstream>
#include <stdlib.h>
#include <io.h>
#include <direct.h>
using namespace std;

class dir {
	char* str;
public:
	dir(): str(new char[1024]) {}
	~dir() {
		if (str != NULL)
			delete[]str;
	};
	void unlink(char*);
	void makedir(char*);
	void removeDir(char*);
	void rmove(char*,char*);
	void print(char*);
};
void dir::unlink(char* buf1){
	remove(buf1);
}
void dir::makedir(char* buf1){
	_mkdir(buf1);
}
void dir::removeDir(char* buf1){
	_rmdir(buf1);
}
void dir::rmove(char* buf1,char* buf2){
	rename(buf1,buf2);
}
void dir::print(char* buf1){
	_finddata_t fileInfo;
	int buf2=_findfirst(buf1,&fileInfo), buf3=0;
	while (buf3 != -1){
		cout << fileInfo.name << endl;
		buf3 = _findnext(buf2, &fileInfo);
	}
	_findclose(buf2);
}

void menu() {
	dir files;
	int i;
	char* buf = new char[1024];
	char* buf2 = new char[1024];
	while (1) {
		system("CLS");
		cout << "1. Print" << endl;
		cout << "2. Unlink" << endl;
		cout << "3. makedir" << endl;
		cout << "4. removeDir" << endl;
		cout << "5. Copy" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		cin.ignore();
		system("CLS");
		switch (i) {
		case 1:
			cin.getline(buf,1024);
			files.print(buf);
			break;
		case 2:
			cin.getline(buf,1024);
			files.unlink(buf);
			break;
		case 3:
			cin.getline(buf,1024);
			files.makedir(buf);
			break;
		case 4:
			cin.getline(buf,1024);
			files.removeDir(buf);
			break;
		case 5:
			cin.getline(buf,1024);
			cin.getline(buf2,1024);
			files.rmove(buf,buf2);
			break;
		case 0:
			exit(0);
			break;
		}
		cout << endl;
		system("pause");
		system("CLS");
	}
}

void main() {
	menu();
}