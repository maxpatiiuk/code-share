#include <iostream>
using namespace std;

class String {
	char* str;
public:
	String(int lenght=80): str(new char[lenght]){}
	String(const String &p){
		str = p.str;
	}
	virtual ~ String() = 0;
	int getLenght();
	char* returnStr();
	void getStr();
	bool setStr(char*);

};

char* String::returnStr() {
	return str;
}
int String::getLenght() {
	return strlen(returnStr());
}
void String::getStr() {
	cout << returnStr();
}
bool String::setStr(char* value) {
	return strcpy(str, value);
}

String a(40);

void menu() {
	int i;
	while (1) {
		system("CLS");
		cout << "1. " << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 0:
				exit(0);
				break;
		}
		system("pause");
		system("CLS");
	}
}

void main() {
	menu();
}