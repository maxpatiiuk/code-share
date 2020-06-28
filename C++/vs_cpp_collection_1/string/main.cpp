#include <iostream>
using namespace std;

class Strings{
	char *str;
public:
	Strings(int size=80) : str(new char[size]) {
		strcpy(str,"");
	}
	Strings(char* istr) : str(new char[strlen(istr)+1]) {
		strcpy(str,istr);
	}
	Strings(const Strings &p) : str(new char[strlen(p.str)+1]){
		strcpy(str,p.str);
	};
	~Strings() {
		if (str)
			delete[]str;
	}
	void copy(const Strings&);
	void input();
	void print();
	char* returnStr();
	void operator*(Strings st){
		bool t1[256],t2[256];
		for(int i=0;i<256;i++){
			t1[i]=0;
			t2[i]=0;
		}
		for(int i=0;i<strlen(st.str);i++)
			t1[int(st.str[i])]=1;
		for(int i=0;i<strlen(this->str);i++)
			t2[int(this->str[i])%256]=1;
		for(int i=0;i<256;i++)
			if(t1[i]==1 && t2[i]==1)
				cout << char(i);
	}
};

void Strings::copy(const Strings &p){
	delete []str;
	str = new char[strlen(p.str)+1];
	strcpy(str,p.str);
}
void Strings::input(){
	cin.ignore();
	cout << "Strings:" << endl;
	cin.getline(str,1024);
}
char* Strings::returnStr(){
	return str;
}
void Strings::print(){
	cout << returnStr() << endl;
}


void addLine(const Strings& src);
void printAll();
int count();
int cou=1;
Strings *strr;

void menu(){
	strr = new Strings[1];
	Strings b;
	int i,buf;
	while(1){
		system("CLS");
		cout << "1. Input into new str" << endl;
		cout << "2. Input into current str" << endl;
		cout << "3. Compare Stringss" << endl;
		cout << "4. Print current Strings" << endl;
		cout << "5. Print all Stringss" << endl;
		cout << "6. Count Stringss" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				b.input();
				addLine(b);
				break;
			case 2:
				strr[cou-1].input();
				break;
			case 3:
				printAll();
				cout << endl << "Enter id of first str:" << endl;
				cin >> i;
				cout << "Enter id of second str:" << endl;
				cin >> buf;
				strr[i]*strr[buf];
				break;
			case 4:
				strr[cou-1].print();
				break;
			case 5:
				printAll();
				break;
			case 6:
				cout << count() << endl;
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

void addLine(const Strings& src){
	Strings *p = new Strings[cou+1];
	for (int i = 0; i < cou; i++){
		p[i].copy(strr[i].returnStr());
		cout << endl;
	}
	p[cou].copy(src);
	delete[]strr;
	strr = p;
	cou++;
}
void printAll(){
	for(int i=0;i<cou;i++){
		cout << i << " >> ";
		strr[i].print();
	}
}

void main(){
	menu();
}