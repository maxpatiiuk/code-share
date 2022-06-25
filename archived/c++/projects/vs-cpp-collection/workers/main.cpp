#include <iostream>
#include <time.h>

using namespace std;
class worker;
class Container{
public:
	int last1, last2, count1, count2;
	worker *t1,*t2;
	Container(): last1(0), last2(0), t1(NULL), t2(NULL){}
	void count(int);
	void sort(int);
	void read();
	void write();
	void repair();
	void add(int,char*,int);
};
class worker {
	char *name;
	int pay;
public:
	worker *n;
	worker(char *iName, int iPay): n(NULL), name(new char[strlen(iName)]), pay(iPay){
		strcpy(name, iName);
	}
	worker(){
		worker("", 0);
	}
	worker(const worker &buf){
		delete []name;
		name = new char[strlen(buf.name)];
		strcpy(name,buf.name);
		pay = buf.pay;
	}
	~worker(){
		if(name!=NULL)
			delete []name;
	};
};

class w1: public worker {
public:
	w1(char *iName, int iPay): worker(iName,iPay){}
};
class w2: public worker {
public:
	w2(char *iName, int iPay): worker(iName,iPay){}
};

void Container::count(int id){
	if(last1!=0){

	}
}
void Container::sort(int limit=0){
	if(last1!=0){
		
	}
}
void Container::read(){

}
void Container::write(){
	if(last1!=0){
		
	}
}
void Container::repair(){

}
void Container::add(int type,char* bufName, int bufPay){
	if(type==1){
		if(last1==0){
			t1 = new w1(bufName,bufPay);
			last1=1;
		}
		else {
			worker *buf = new w1(bufName,bufPay);
			worker *buf2 = t1;
			while(buf2->n!=NULL)
				buf2=buf2->n;
			buf2->n=buf;
		}
	}
	else {
		if(last2==0){
			t2 = new w2(bufName,bufPay);
			last2=1;
		}
		else {
			worker *buf = new w2(bufName,bufPay);
			worker *buf2 = t2;
			while(buf2->n!=NULL)
				buf2=buf2->n;
			buf2->n=buf;
		}
	}
}
void menu(){
	Container main;
	int i,bufInt;
	char* bufChar = new char[1024];
	while (1) {
		system("CLS");
		cout << "1. Sort" << endl;
		cout << "2. Sort (LIMIT=5)" << endl;
		cout << "3. Read" << endl;
		cout << "4. Write" << endl;
		cout << "5. Repair file" << endl;
		cout << "6. Add" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				main.sort();
				break;
			case 2:
				main.sort(5);
				break;
			case 3:
				main.read();
				break;
			case 4:
				main.write();
				break;
			case 5:
				main.repair();
				break;
			case 6:
				cout << "Worker type (1 - hourly, 2 - monthly): ";
				cin >> i;
				cout << "Name: ";
				cin.ignore();
				cin.getline(bufChar,1024);
				cout << "Salary: ";
				cin >> bufInt;
				main.add(i,bufChar,bufInt);
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