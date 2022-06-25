#include <iostream>
#include <fstream>
using namespace std;

struct Data {
	int value;
	Data* next;
public:
	Data() {
		next = NULL;
	}
};

class file {
	Data* host;
public:
	file(): host(NULL) {}
	~file() {
		if (host != NULL)
			delete[]host;
	};
	void add(int);
	void deleteAll();
	void read();
	void write();
	void print();
};

void file::add(int val1) {
	if(host==NULL){
		host = new Data;
		host->value = val1;
	}
	else {
		Data *buf = host;
		Data *buf2 = new Data;
		while(buf->next!=NULL)
			buf=buf->next;
		buf2->value=val1;
		buf->next=buf2;
	}
}
void file::print() {
	if(host!=NULL)
		for(Data *buf = host;buf!=NULL;buf=buf->next)
			cout << buf->value << endl;
}
void file::deleteAll(){
	if(host!=NULL){
		Data *buf=host;
		Data *buf2=host;
		while(buf!=NULL){
			buf=buf2->next;
			delete buf2;
			buf2=NULL;
			if(buf==NULL)
				break;
			buf2=buf;
		}
		host=NULL;
	}
}
void file::read(){
	fstream f("buf.txt",ios::in);
	char buf2[100];
	int buf=0;
	f.seekg(0,ios::end);
	int lenght = f.tellg();
	deleteAll();
	for(int i=0;i<lenght;i+=strlen(buf2)){
		/*f.get(buf2,100); // this code reads empty string
		add(atoi(buf2));*/
		f >> buf; //this code read 0
		add(buf);
		itoa(buf,buf2,10);
	}
	f.close();
}
void file::write(){
	char *buf2 = new char[100];
	fstream f("buf.txt",ios::out);
	for(Data *buf = host;buf!=NULL;buf=buf->next){
		itoa(buf->value,buf2,10);
		f.write(buf2,strlen(buf2));
		f.write("\n",1);
	}
	f.close();
}

void menu() {
	file arr;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Read" << endl;
		cout << "3. Write" << endl;
		cout << "4. Delete " << endl;
		cout << "5. Print" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		cin.ignore();
		system("CLS");
		switch (i) {
		case 1:
			cin >> i;
			arr.add(i);
			break;
		case 2:
			arr.read();
			break;
		case 3:
			arr.write();
			break;
		case 4:
			arr.deleteAll();
			break;
		case 5:
			arr.print();
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