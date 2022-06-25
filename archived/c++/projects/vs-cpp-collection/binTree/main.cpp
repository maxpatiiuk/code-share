#include <iostream>
#pragma warning(disable:4996)

using namespace std;

struct Problem {
	char cont[1024];
	Problem *next;
	Problem() {
		next = NULL;
		cont[0] = '\0';
	}
	char* get();
	void set(char*);
};

struct Data {
	char name[9];
	Problem *pro;
	Data* l;
	Data* r;
	void print();
public:
	Data() {
		for (int i = 0; i < 9; i++)
			name[i] = '\0';
		pro = NULL;
		l = NULL;
		r = NULL;
	}
};

class bin {
	Data* host;
public:
	int count;
	bin() {
		count = 0;
		host = NULL;
	}
	~bin() {
		if (host != NULL)
			delete[]host;
	};
	void add(char*, char*);
	void seach(char*);
	void print(Data*);
	void printSome(char*, char*, Data *);
};

char* Problem::get() {
	return cont;
}
void Problem::set(char *buf) {
	strcpy(cont, buf);
}

void Data::print(){
	cout << name;
	Problem *buf = pro;
	while(buf!=NULL){
		cout << " " << buf->cont;
		buf=buf->next;
	}
	cout << endl;
}

void bin::add(char* val1, char* val2) {
	if (count == 1) {
		if (strcmp(host->name, val1) == 0) {
			Problem *buf = new Problem;
			Problem *buf2 = host->pro;
			strcpy(buf->cont, val2);
			while(buf2->next!=NULL)
				buf2=buf2->next;
			buf2->next=buf;
		}
		else {
			Data *buf = new Data;
			buf->pro = new Problem;
			strcpy(buf->pro->cont, val2);
			strcpy(buf->name, val1);
			if (strcmp(host->name, val1) == 1)
				host->l = buf;
			else
				host->r = buf;
			count++;
		}
	}
	else if (count == 0) {
		host = new Data;
		strcpy(host->name, val1);
		host->pro = new Problem;
		strcpy(host->pro->cont, val2);
		count++;
	}
	else {
		Data *buf = host;
		int buf2;
		while (buf != NULL) {
			buf2 = strcmp(buf->name, val1);
			if (buf2 == 1) {
				if (buf->l == NULL)
					break;
				buf = buf->l;
			}
			else if (buf2 == -1) {
				if (buf->r == NULL)
					break;
				buf = buf->r;
			}
			else
				break;
		}
		if (buf2 == 0) {
			Problem *buf3 = new Problem;
			Problem *buf4 = buf->pro;
			strcpy(buf3->cont,val2);
			while(buf4->next!=NULL)
				buf4=buf4->next;
			buf4->next=buf3;
		}
		else {
			Data *buf3 = new Data;
			strcpy(buf3->name, val1);
			buf3->pro = new Problem;
			strcpy(buf3->pro->cont, val2);
			if(buf2==1)
				buf->l=buf3;
			else
				buf->r=buf3;
			count++;
		}
	}
}
void bin::seach(char* val) {
	Data *buf = host;
	int buf2=0;
	while (1==1) {
		buf2=strcmp(buf->name, val);
		if(buf2== 1){
			if(buf->l==NULL)
				break;
			buf=buf->l;
		}
		else if(buf2 == -1){
			if(buf->r==NULL)
				break;
			buf=buf->r;
		}
		else
			break;
	}
	if(buf!=NULL)
		buf->print();
}
void bin::print(Data *val=NULL) {
	if (val == 0)
		val = host;
	if (val->name != NULL)
		val->print();
	if(val->l!=NULL)
		print(val->l);
	if(val->r!=NULL)
		print(val->r);
}

void bin::printSome(char* val1, char* val2, Data *val3=NULL) {
	if (val3 == 0)
		val3 = host;
	if (val3->name != NULL)
		val3->print();
	if(val3->l!=NULL)
		if(strcmp(val3->name,val1)==1)
			printSome(val1,val2,val3->l);
	if(val3->r!=NULL)
		if(strcmp(val3->name,val2)==-1)
			printSome(val1,val2,val3->r);
}

void menu() {
	bin tree;
	char *buf1 = new char;
	char *buf2 = new char;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Seach" << endl;
		cout << "3. Print" << endl;
		cout << "4. Print some" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		cin.ignore();
		system("CLS");
		switch (i) {
		case 1:
			cin.getline(buf1,1024);
			cin.getline(buf2, 1024);
			tree.add(buf1,buf2);
			break;
		case 2:
			if (tree.count != 0) {
				cin.getline(buf1, 1024);
				tree.seach(buf1);
			}
			else
				cout << "Base is empty";
			break;
			break;
		case 3:
			if (tree.count != 0)
				tree.print(0);
			else
				cout << "Base is empty";
			break;
		case 4:
			if(tree.count!=0){
				cin.getline(buf1, 1024);
				cin.getline(buf2, 1024);
				tree.printSome(buf1, buf2, 0);
			}
			else
				cout << "Base is empty";
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