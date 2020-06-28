#include <iostream>
#pragma warning(disable:4996)

using namespace std;

struct Data {
	int count;
	char*w1;
	char*w2;
	Data* l;
	Data* r;
	void print();
public:
	Data() {
		w1=new char;
		w2=new char;
		count = 0;
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
	Data* seach(char*);
	void seachAndEdit(char*);
	void seachAndDelete(char*);
	void print(Data*);
	int most(int,Data*);
	int less(int,Data*);
};


void Data::print(){
	count++;
	if(strcmp(w1,"-1")!=0)
		cout << count << " " << w1 << " " << w2 << endl;
}

void bin::add(char* val1, char* val2) {
	if (count == 1) {
		Data *buf = new Data;
		strcpy(buf->w1, val1);
		strcpy(buf->w2, val2);
		if (strcmp(host->w1, val1) == 1)
			host->l = buf;
		else
			host->r = buf;
		count++;
	}
	else if (count == 0) {
		host = new Data;
		strcpy(host->w1, val1);
		strcpy(host->w2, val2);
		count++;
	}
	else {
		Data *buf = host;
		int buf2;
		while (buf != NULL) {
			buf2 = strcmp(buf->w1, val1);
			if (buf2 == 1) {
				if (buf->l == NULL)
					break;
				buf = buf->l;
			}
			else {
				if (buf->r == NULL)
					break;
				buf = buf->r;
			}
		}
		Data *buf3 = new Data;
		strcpy(buf3->w1, val1);
		strcpy(buf3->w2, val2);
		if(buf2==1)
			buf->l=buf3;
		else
			buf->r=buf3;
		count++;
	}
}
Data* bin::seach(char* val) {
	if(strcmp(val,"-1")==0){
		cout << "Can't find this word!";
		return NULL;
	}
	Data *buf = host;
	int buf2=0;
	while (1==1) {
		buf2=strcmp(buf->w1, val);
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
	return buf;
}
void bin::seachAndEdit(char*val){
	Data *buf = seach(val);
	if(buf==NULL){
		cout << "Can't find this word!";
		return;
	}
	/*cin.getlne(buf->w1,1024); // For newer versions of vs
	cin.getlne(buf->w2,1024);*/
	gets(buf->w1); // For older versions of vs
	gets(buf->w2);
	cin >> buf->count;
}
void bin::seachAndDelete(char*val){
	Data *buf = seach(val);
	if(buf==NULL){
		cout << "Can't find this word!";
		return;
	}
	strcpy(buf->w1,"-1");
}
void bin::print(Data *val=NULL) {
	if (val == 0)
		val = host;
	if (val->w1 != NULL && strcmp(val->w1,"-1")!=0)
		val->print();
	if(val->l!=NULL && strcmp(val->l->w1,"-1")!=0)
		print(val->l);
	if(val->r!=NULL && strcmp(val->r->w1,"-1")!=0)
		print(val->r);
}
int bin::most(int big=0, Data*val=NULL){
	int buf3=0;
	if (val == 0)
		val = host;
	if(val->count>big)
		big=count;
	if(val->l!=NULL && strcmp(val->l->w1,"-1")!=0){
		buf3=most(big,val->l);
		if(buf3>big)
			big=buf3;
	}
	if(val->r!=NULL && strcmp(val->r->w1,"-1")!=0){
		buf3=most(big,val->r);
		if(buf3>big)
			big=buf3;
	}
	return big+2;
}
int bin::less(int big=0, Data*val=NULL){
	int buf3=0;
	if (val == 0)
		val = host;
	if(val->count<big)
		big=count;
	if(val->l!=NULL && strcmp(val->l->w1,"-1")!=0){
		buf3=most(big,val->l);
		if(buf3<big)
			big=buf3;
	}
	if(val->r!=NULL && strcmp(val->r->w1,"-1")!=0){
		buf3=most(big,val->r);
		if(buf3<big)
			big=buf3;
	}
	return big+2;
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
		cout << "3. Seach and edit" << endl;
		cout << "4. Seach and delete" << endl;
		cout << "5. Print" << endl;
		cout << "6. Most popular" << endl;
		cout << "7. Less popular" << endl;
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
				cout << "Dictionary is empty";
			break;
		case 3:
			if (tree.count != 0) {
				cin.getline(buf1, 1024);
				tree.seachAndEdit(buf1);
			}
			else
				cout << "Dictionary is empty";
			break;
		case 4:
			if (tree.count != 0) {
				cin.getline(buf1, 1024);
				tree.seachAndDelete(buf1);
			}
			else
				cout << "Dictionary is empty";
			break;
		case 5:
			if (tree.count != 0){
				cout << "Views | Word 1 | Word 2" << endl;
				tree.print(0);
			}
			else
				cout << "Dictionary is empty";
			break;
		case 6:
			if (tree.count != 0)
				cout << tree.most(0,0);
			else
				cout << "Dictionary is empty";
			break;
		case 7:
			if (tree.count != 0)
				cout << tree.less(0,0);
			else
				cout << "Dictionary is empty";
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