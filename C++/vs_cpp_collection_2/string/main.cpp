#include <iostream>
using namespace std;

class String{
	char *str;
public:
	String() : str(new char[80]) {
		strcpy(str,"");
	}
	String(int size) : str(new char[size]) {
		strcpy(str,"");
	}
	String(char* istr) : str(new char[strlen(istr)]) {
		strcpy(str,istr);
	}
	String(const String &p) : str(new char[strlen(p.str)]){
		strcpy(str,p.str);
	};
	~String() {
		if (str)
			delete[]str;
	}
	void copy(const String&);
	void input();
	void print();
	char* returnStr();
};

void String::copy(const String &p){
	delete []str;
	str = new char[strlen(p.str+1)];
	strcpy(str,p.str);
}
void String::input(){
	cin.ignore();
	cout << "String:" << endl;
	cin.getline(str,1024);
}
char* String::returnStr(){
	return str;
}
void String::print(){
	cout << returnStr() << endl;
}


void addLine(const String& src);
int count();
int cou;
String *strr = new String;

void menu(){
	int i;
	while(1){
		system("CLS");
		cout << "1. Input into new str" << endl;
		cout << "2. Input into current str" << endl;
		cout << "3. Print current string" << endl;
		cout << "4. Count strings" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				cou++;
				{
					String p;
					p.input();
					addLine(p);
				}
				break;
			case 2:
				strr[cou].input();
				break;
			case 3:
				strr[cou].print();
				break;
			case 4:
				cout << count()+1;
				break;
			case 0:
				exit(0);
				break;
		}
		system("pause");
		system("CLS");
	}
}

int count(){
	return cou;
}
void addLine(const String& src){
	String *p = new String[cou+1];
	for (int i = 0; i < cou; i++)
		p[i].copy(strr[i].returnStr());
	p[cou].copy(src);
	/*for (int i = 0; i < cou+1; i++)
		p[i].print();*/
	delete[]strr;  // програма перестає працювати на цьому рядку
	strr = p;
	/*for (int i = 0; i < cou; i++)
		strr[i].copy(p[i]);
	strr[cou].copy(src);*/
}

void main(){
	menu();
}