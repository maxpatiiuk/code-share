#include <iostream>
#include <fstream>
using namespace std;

struct Data {
	char* val1;
	char* val2;
	char* val3;
	char* val4;
	char* val5;
	Data* next;
public:
	Data(): next(NULL) {
		val1=new char;
		val2=new char;
		val3=new char;
		val4=new char;
		val5=new char;
	}
};

class helper {
	Data* host;
public:
	helper(): host(NULL) {}
	~helper() {
		if (host != NULL)
			delete[]host;
	};
	void add(char*,char*,char*,char*,char*);
	void write();
	void print();
	void seach(char*);
};

void helper::add(char* val1,char* val2,char* val3,char* val4,char* val5) {
	if(host==NULL){
		host = new Data;
		strcpy(host->val1,val1);
		strcpy(host->val2,val2);
		strcpy(host->val3,val3);
		strcpy(host->val4,val4);
		strcpy(host->val5,val5);
	}
	else {
		Data *buf = host;
		Data *buf2 = new Data;
		while(buf->next!=NULL)
			buf=buf->next;
		strcpy(buf2->val1,val1);
		strcpy(buf2->val2,val2);
		strcpy(buf2->val3,val3);
		strcpy(buf2->val4,val4);
		strcpy(buf2->val5,val5);
		buf->next=buf2;
	}
}
void helper::print() {
	if(host!=NULL)
		for(Data *buf = host;buf!=NULL;buf=buf->next)
			cout << buf->val1 << "\t" << buf->val2 << "\t" << buf->val3 << "\t" << buf->val4 << "\t" << buf->val5 << endl;
}
void helper::write(){
	char *buf2 = new char[100];
	fstream f("buf.txt",ios::out);
	for(Data *buf = host;buf!=NULL;buf=buf->next){
		f.write(buf->val1,strlen(buf->val1));
		f.write("\t",1);
		f.write(buf->val2,strlen(buf->val2));
		f.write("\t",1);
		f.write(buf->val3,strlen(buf->val3));
		f.write("\t",1);
		f.write(buf->val4,strlen(buf->val4));
		f.write("\t",1);
		f.write(buf->val5,strlen(buf->val5));
		f.write("\n",1);
	}
	f.close();
}
void helper::seach(char*val){
	Data*buf=host;
	while(buf!=NULL){
		if(strcmp(buf->val1,val)==0 || strcmp(buf->val2,val)==0 || strcmp(buf->val3,val)==0 || strcmp(buf->val4,val)==0 || strcmp(buf->val5,val)==0)
			cout << buf->val1 << "\t" << buf->val2 << "\t" << buf->val3 << "\t" << buf->val4 << "\t" << buf->val5 << endl;
		buf=buf->next;
	}
}

void menu() {
	helper list;
	int i;
	char* buf1 = new char;
	char* buf2 = new char;
	char* buf3 = new char;
	char* buf4 = new char;
	char* buf5 = new char;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Write" << endl;
		cout << "3. Print" << endl;
		cout << "4. Seach" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		cin.ignore();
		system("CLS");
		switch (i) {
		case 1:
			cin.getline(buf1,1024);
			cin.getline(buf2,1024);
			cin.getline(buf3,1024);
			cin.getline(buf4,1024);
			cin.getline(buf5,1024);
			list.add(buf1,buf2,buf3,buf4,buf5);
			break;
		case 2:
			list.write();
			break;
		case 3:
			list.print();
			break;
		case 4:
			cin.getline(buf1,1024);
			list.seach(buf1);
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