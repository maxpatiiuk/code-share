#include <iostream>
using namespace std;

class Strings {
	char *str;
public:
	Strings(int size = 80) : str(new char[size]) {
		strcpy(str, "");
	}
	Strings(char* istr) : str(new char[strlen(istr) + 1]) {
		strcpy(str, istr);
	}
	Strings(const Strings &p) : str(new char[strlen(p.str) + 1]) {
		strcpy(str, p.str);
	};
	~Strings() {
		if (str)
			delete[]str;
	}
	void input();
	void print() const;
	char* returnStr() const;
	void operator()(Strings&);
	void operator=(char*);
	void operator*(const Strings st);
	char operator[](int) const;
	void operator<<(Strings st);
	operator int();
	operator double();
};

void Strings::operator=(char* strr) {
	delete[]str;
	str = new char[strlen(strr) + 1];
	strcpy(str, strr);
}
void Strings::operator()(Strings &p) {
	delete[]str;
	str = new char[strlen(p.str) + 1];
	strcpy(str, p.str);
}
void Strings::operator*(const Strings st) {
	bool t1[256], t2[256];
	for (int i = 0; i<256; i++) {
		t1[i] = 0;
		t2[i] = 0;
	}
	for (int i = 0; i<strlen(st.str); i++)
		t1[int(st.str[i])] = 1;
	for (int i = 0; i<strlen(this->str); i++)
		t2[int(this->str[i]) % 256] = 1;
	for (int i = 0; i<256; i++)
		if (t1[i] == 1 && t2[i] == 1)
			cout << char(i);
}
char Strings::operator[](int id) const{
	if(id>strlen(str) || id<0)
		return '0';
	else
		return str[id];
}
void Strings::operator<<(Strings st){
	int s1 = strlen(this->returnStr()), s2 = strlen(st.returnStr());
	char *buf = new char[s1 + s2 + 1];
	buf[s1+s2]='\0';
	for (int i = 0; i < s1; i++)
		buf[i] = (*this)[i];
	for (int i = 0; i < s2; i++)
		buf[i+s1] = st[i];
	delete[]this->str;
	this->str = buf;
}
Strings::operator int(){
	return atoi(str);
}
Strings::operator double(){
	return atof(str);
}
void Strings::input() {
	cin.ignore();
	cout << "Strings:" << endl;
	cin.getline(str, 1024);
}
char* Strings::returnStr() const {
	return str;
}
void Strings::print() const {
	cout << returnStr() << endl;
}


void addLine(Strings& src);
void printAll();
int count();
int cou = 1;
Strings *strr;

void menu() {
	strr = new Strings[1];
	Strings b;
	int i, buf;
	while (1) {
		system("CLS");
		cout << "1. Input into new str" << endl;
		cout << "2. Input into current str" << endl;
		cout << "3. Return idx-character" << endl;
		cout << "4. Compare Strings" << endl;
		cout << "5. Append str" << endl;
		cout << "6. Str to int" << endl;
		cout << "7. Str to double" << endl;
		cout << "8. Print current Strings" << endl;
		cout << "9. Print all Strings" << endl;
		cout << "10. Count Strings" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
		case 1:
			b.input();
			addLine(b);
			break;
		case 2:
			strr[cou - 1].input();
			break;
		case 3:
			cout << endl << "Enter id of character to output:" << endl;
			cin >> i;
			cout << strr[cou - 1][i];
			break;
		case 4:
			printAll();
			cout << endl << "Enter id of first str:" << endl;
			cin >> i;
			cout << "Enter id of second str:" << endl;
			cin >> buf;
			strr[i] * strr[buf];
			break;
		case 5:
			printAll();
			cout << endl << "Enter id of first str:" << endl;
			cin >> i;
			cout << "Enter id of second str:" << endl;
			cin >> buf;
			strr[i] << strr[buf].returnStr();
			break;
		case 6:
			cout << int(strr[cou - 1]);
			break;
		case 7:
			cout << double(strr[cou - 1]);
			break;
		case 8:
			strr[cou - 1].print();
			break;
		case 9:
			printAll();
			break;
		case 10:
			cout << count();
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

int count() {
	return cou;
}

void addLine(Strings& src) {
	Strings *p = new Strings[cou + 1];
	for (int i = 0; i < cou; i++) {
		p[i](strr[i]);
		cout << endl;
	}
	p[cou](src);
	delete[]strr;
	strr = p;
	cou++;
}
void printAll(){
	for (int i = 0; i<cou; i++) {
		cout << i << " >> ";
		strr[i].print();
	}
}

void main() {
	menu();
}