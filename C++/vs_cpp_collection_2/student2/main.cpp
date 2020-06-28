#include <iostream>
#include <vector>
#include <functional>
#include <time.h>
#include <random>
#include <string>
#include <algorithm>

using namespace std;

class students{
public:
	string name;
	string surname;
	int level;
	students(string iName, string iSurname, int iLevel):level(iLevel), name(iName), surname(iSurname){
	}
	students(){
		students("", "", 0);
	}
	students(const students &buf){
		level = buf.level;
		name = buf.name;
		surname = buf.surname;
	}
	~students(){
	};
};

string randStr(){
	char c[10];
	for(int i=0;i<10;i++)
		c[i]='a'+rand()%26;
	string buf(c);
	buf[10]='\0';
	return buf;
}

class Compare {
	int sortType;
	bool operator()(students v1, students v2){
		return (sortType==1 && strcmp(v1.name.c_str(),v2.name.c_str())>0) ||
			(sortType==2 && strcmp(v1.surname.c_str(),v2.surname.c_str())>0) ||
			(sortType==3 && v1.level>v2.level);
	}
public:
	Compare(): sortType(1){}
	void setType(int newType){
		sortType=newType;
	}
};

class container{
	vector<students> student;
public:
	Compare s;
	container(){
		student.clear();
		students buf;
		student.assign(10,buf);
	}
	~container(){
	};
	void print(){
		/*for_each(student.begin(),student.end(),[](students b){
			cout << b.name << " " << b.surname << " " << b.level << endl;
		});*/
		for(int i=0;i<10;i++)
			cout << student[i].name.substr(0,10) << " " << student[i].surname.substr(0,10) << " " << student[i].level << endl;
	}
	void fill(){
		for(int i=0;i<10;i++){
			students buf(randStr(),randStr(),rand()%5+1);
			student[i]=buf;
		}
	}
	void sortIt(int from, int to){
		sort(from,to,Compare());
	}
};

int sortType=0;

void menu(){
	container c;
	int i,buf1;
	while (1) {
		system("CLS");
		cout << "1. Print All" << endl;
		cout << "2. Random Fill" << endl;
		cout << "3. Sort" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				c.print();
				break;
			case 2:
				c.fill();
				break;
			case 3:
				cout << "1. By name" << endl;
				cout << "2. By surname" << endl;
				cout << "3. By level" << endl;
				cout << "0. Exit" << endl;
				cin >> i;
				if(i==0)
					break;
				c.s.setType(i);
				system("CLS");
				cout << "From: ";
				cin >> i;
				cout << "To: ";
				cin >> buf1;
				c.sortIt(i,buf1);
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