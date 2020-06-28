#include <iostream>
#include <time.h>
#include <fstream>
#pragma warning(disable:4996)

using namespace std;

struct workerData{
	char name[1024];
	float pay;
};

class worker;
class Container{
public:
	int last1, last2, count1, count2;
	worker *t1,*t2;
	Container(): last1(0), last2(0), t1(NULL), t2(NULL){}
	void sort(int);
	void read(char*);
	void write(char*);
	bool isCorrect(char*);
	void add(int,char*,float);
};
class worker {
public:
	char *name;
	float pay;
	worker *n;
	worker(char *iName, float iPay): n(NULL), name(new char[strlen(iName)]), pay(iPay){
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
	float count(int);
};

class w1: public worker {
public:
	w1(char *iName, int iPay): worker(iName,iPay){}
};
class w2: public worker {
public:
	w2(char *iName, int iPay): worker(iName,iPay){}
};
void Container::sort(int limit=1000){
	int count=last1+last2;
	if(count>0){
		workerData *data = new workerData[count];
		bool wasChange=1;
		worker *buf2 = t1;
		for(int i=0;i<last1;i++,buf2=buf2->n){
			strcpy(data[i].name,buf2->name);
			data[i].pay=buf2->count(1);
		}
		buf2 = t2;
		for(int i=0;i<last2;i++,buf2=buf2->n){
			strcpy(data[last1+i].name,buf2->name);
			data[last1+i].pay=buf2->count(2);
		}
		while(wasChange){
			wasChange = 0;
			for(int i=1;i<count;i++){
				if(data[i-1].pay>data[i].pay){
					swap(data[i-1],data[i]);
					wasChange=1;
				}
				else if(data[i-1].pay==data[i].pay && strcmp(data[i-1].name,data[i].name)==1){
					swap(data[i-1],data[i]);
					wasChange=1;
				}
			}
		}
		for(int i=0;i<count && i<limit;i++)
			cout << i+1 << "\t" << data[i].name << "\t" << data[i].pay << endl;
	}
}
void Container::read(char* path){
	if(isCorrect(path)){
		ifstream f(path);
	if(f.is_open()){
		worker *buf = t1;
		char buf2[1024];
		char buf3[1024];
		char buf4[1024];
			while (!f.eof()){
				f >> buf3;
				f >> buf2;
				f >> buf4;
				add((*buf2 == '1') ? true : false,buf3,atof(buf4));
			}
		}
	}
}
void Container::write(char* path){
	if(last1+last2>0 && isCorrect(path)){
		ofstream f(path, ios::out);
		if(f.is_open()){
			worker *buf = t1;
			for(int i=0;i<last1;i++,buf=buf->n){
				f << buf[i].name << endl;
				f << 1 << endl;
				f << buf[i].pay << endl;
			}
			buf = t2;
			for(int i=0;i<last2;i++, buf = buf->n){
				f << buf[i].name << endl;
				f << 0 << endl;
				f << buf[i].pay << endl;
			}
		}
	}
}
bool Container::isCorrect(char* path){
	return strlen(path) > 3 && isalpha(path[0]) && path[1] == ':' && path[2] == '\\';
}
void Container::add(int type,char* bufName, float bufPay){
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
			last1++;
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
			last2++;
		}
	}
}

float worker::count(int type) {
	if (type == 1)
		return 20.8 * 8 * pay;
	else
		return pay;
}

void menu(){
	Container main;
	int i;
	float bufFloat;
	char* bufChar = new char[1024];
	while (1) {
		system("CLS");
		cout << "1. Sort" << endl;
		cout << "2. Sort (LIMIT=5)" << endl;
		cout << "3. Read" << endl;
		cout << "4. Write" << endl;
		cout << "5. Add" << endl;
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
				cin.ignore();
				cin.getline(bufChar,1024);
				main.read(bufChar);
				break;
			case 4:
				cin.ignore();
				cin.getline(bufChar,1024);
				main.write(bufChar);
				break;
			case 5:
				cout << "Worker type (1 - hourly, 2 - monthly): ";
				cin >> i;
				cout << "Name: ";
				cin.ignore();
				cin.getline(bufChar,1024);
				cout << "Salary: ";
				cin >> bufFloat;
				main.add(i,bufChar,bufFloat);
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