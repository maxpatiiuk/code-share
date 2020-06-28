/*
#include <iostream>
#define size 10
#define loop for(int i=0;i<size;i++)
#define deafult -99999

using namespace std;

namespace q{

	class queue{
		int l1[size];
		int l2[size];
	public:
		queue(int iL1, int iL2){
			setAll(1,iL1);
			setAll(0,iL2);
		}
		queue(){
			queue(deafult, deafult);
		}
		queue(const queue &buf){
			setAll(1,*buf.l1);
			setAll(0,*buf.l2);
		}
		void set();
		void setAll(bool,int);
		int getCount(bool);
		void print();
		void getFirst();
		void getLast();
	};

	void queue::set(){
		int buf[size];
		setAll(0,deafult);
		setAll(1,deafult);
		loop
			cin >> buf[i];
		loop {
			if(buf[i]%2==0)
				l1[i]=buf[i];
			else
				l2[i]=buf[i];
		}
	}
	void queue::setAll(bool l,int val){
		if(l==0)
			loop
				l2[i]=val;
		else
			loop
				l1[i]=val;
	}
	void queue::print(){
		loop {
			if(l1[i]!=deafult)
				cout << "L1: " << l1[i] << endl;
			else
				cout << "L2: " << l2[i] << endl;
		}
	}
	void queue::getLast(){
		if(l1[size-1]!=deafult)
			cout << "L1 last: " << l1[size-1] << endl;
		else
			cout << "L2 last: " << l2[size-1] << endl;
	}
	void queue::getFirst(){
		if(l1[0]!=deafult)
			cout << "L1 first: " << l1[0] << endl;
		else
			cout << "L2 first: " << l2[0] << endl;
	}
}

void menuText(){
	cout << "1. Set queue" << endl;
	cout << "2. Get queue" << endl;
	cout << "3. Get first" << endl;
	cout << "4. Get last" << endl;
	cout << "0. Exit" << endl;
}

using namespace q;

void menu(){
	queue *line = new queue;
	int i;
	queue buf;
	while (1) {
		system("CLS");
		menuText();
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				line->set();
				break;
			case 2:
				line->print();
				break;
			case 3:
				line->getFirst();
				break;
			case 4:
				line->getLast();
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
*/


/*
#include <iostream>
#pragma warning(disable:4996)

using namespace std;

namespace p{

	struct Data {
		char data[100];
		int prioritet;
		char name[100];
		Data() {
			data[0] = '\0';
			name[0] = '\0';
			prioritet = 0;
			for (int i = 1; i<100; i++) {
				data[i] = 0;
				name[i] = 0;
			}
		}
		void copy(Data val) {
			strcpy(data, val.data);
			prioritet = val.prioritet;
			strcpy(name, val.name);
		}
	};

	class queue {
		int count;
		Data* data;
	public:
		queue() {
			count = 0;
			data = NULL;
		}
		~queue() {
			if (data != NULL)
				delete[]data;
		};
		int getCount();
		void getQue();
		void getUsers();
		bool print();
		void add(int, char*, char*);
	};


	int queue::getCount() {
		return count;
	}
	void queue::getQue() {
		cout << "Data\tPrioritet\tName\n";
		for (int i = 0; i<count; i++)
			cout << data[i].data << "\t\t" << data[i].prioritet << "\t" << data[i].name << endl;
	}
	void queue::getUsers() {
		cout << "Name\tPrioritet\n";
		for (int i = 0; i<count; i++) {
			if(i+1==count)
				cout << data[i].name << "\t\t" << data[i].prioritet << endl;
			for (int ii = i + 1; ii<count; ii++) {
				if (strcmp(data[i].name, data[ii].name) == 0)
					break;
				if (ii + 1 >= count)
					cout << data[i].name << "\t\t" << data[i].prioritet << endl;
			}
		}
	}
	bool queue::print() {
		if (count == 0)
			return 0;
		else if (count == 1) {
			count = 0;
			delete[]data;
			cout << data[count - 1].data << "\t" << data[count - 1].prioritet << "\t" << data[count - 1].name << endl;
		}
		else {
			int max = 0;
			for (int i = 1; i<count; i++)
				if (data[i].prioritet>data[max].prioritet)
					max = i;
			cout << data[max].data << "\t" << data[max].prioritet << "\t" << data[max].name << endl;
			Data *buf = new Data[count-1];
			for (int i = 0, real = 0; i < count; i++) {
				if (i != max) {
					buf[real].copy(data[i]);
					real++;
				}
			}
			count--;
			delete[]data;
			data = buf;
		}
	}
	void queue::add(int vPrioritet, char* vData, char* vName) {
		if (count != 0) {
			count++;
			Data *buf = new Data[count];
			for (int i = 0; i < count - 1; i++)
				buf[i].copy(data[i]);
			strcpy(buf[count-1].data, vData);
			buf[count-1].prioritet = vPrioritet;
			strcpy(buf[count-1].name, vName);
			delete[]data;
			data = buf;
		}
		else {
			count = 1;
			data = new Data[1];
			data[0].prioritet = vPrioritet;
			strcpy(data[0].name, vName);
			strcpy(data[0].data, vData);
		}
	}
}

using namespace p;

void menu() {
	queue printing;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Get queue" << endl;
		cout << "2. Get users" << endl;
		cout << "3. Print" << endl;
		cout << "4. Add" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		char buf1[100], buf2[100];
		system("CLS");
		switch (i) {
		case 1:
			printing.getQue();
			break;
		case 2:
			printing.getUsers();
			break;
		case 3:
			printing.print();
			break;
		case 4:
			cin >> i;
			cin.ignore();
			cin.getline(buf1, 100);
			cin.getline(buf2, 100);
			printing.add(i, buf1, buf2);
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
*/

/*
#include <iostream>

using namespace std;

namespace n{

	struct Data {
		int data;
		Data* next;
		Data* prev;
		Data() {
			data = 0;
		}
		void copy(Data val) {
			data = val.data;
		}
		void print();
	};
	class node {
		int count;
		Data* f;
		Data* l;
	public:
		node() {
			count = 0;
			f = NULL;
			l = NULL;
		}
		~node() {
			if (f != NULL)
				delete[]f;
			if (l != NULL)
				delete[]l;
		};
		void addToHead(int);
		void addToTail(int);
		int addById(int,int);
		Data* seach(int);//Null
		Data* seachAndChange(int, int);//-1
		void reverse();
		Data* getById(int);
		void sort();
		void deleteFromHead();
		void deleteFromTail();
		void deleteAll();
		void print();
	};

	void Data::print() {
		cout << data;
	}

	void node::addToHead(int val) {
		if (count == 1) {
			l = new Data;
			swap(l, f);
			f->data = val;
			f->next = l;
			f->prev = NULL;
			l->prev = f;
		}
		else if (count == 0) {
			f = new Data;
			l = new Data;
			f->data = val;
			f->next = NULL;
			f->prev = NULL;
			l = f;
		}
		else {
			Data *buf = new Data;
			buf->next = f;
			buf->prev = NULL;
			f->prev = buf;
			buf->data = val;
			f = buf;
		}
		count++;
	}
	void node::addToTail(int val) {
		if (count == 1) {
			l = new Data;
			l->data = val;
			l->next = NULL;
			l->prev = f;
			f->next = l;
		}
		else if (count == 0) {
			f = new Data;
			l = new Data;
			f->data = val;
			l = f;
		}
		else {
			Data *buf = new Data;
			buf->next = NULL;
			buf->data = val;
			l->next = buf;
			buf->prev=l;
			l=buf;
		}
		count++;
	}
	int node::addById(int val, int val2) {
		if (val == count)
			addToTail(val2);
		else if (val == 0)
			addToHead(val2);
		else if(val<count){
			Data *buf = getById(val);
			Data *buf2 = new Data;
			buf2->data = val2;
			buf->prev->next = buf2;
			buf2->prev = buf->prev;
			buf->prev = buf2;
			buf2->next = buf;
			buf->next = buf2;
			count++;
		}
		return 1;
	}
	Data* node::seach(int val) {
		Data *buf;
		buf = f;
		while (buf->data != val && buf->next != NULL)
			buf = buf->next;
		if (buf->data!= val)
			return NULL;
		else
			return buf;
	}
	Data* node::seachAndChange(int val, int val2) {
		Data *buf;
		buf = f;
		while (buf->data != val && buf->next != NULL)
			buf = buf->next;
		if (buf->data != val)
			return NULL;
		else {
			buf->data= val2;
			return buf;
		}
	}
	void node::reverse() {
		Data *buf = f;
		for (int i = 1; i*2 < count; i++, buf = buf->next)
			swap(buf->data, getById(count - i)->data);
	}
	Data* node::getById(int val) {
		Data *buf = f;
		for (int i = 0; i < val; i++, buf = buf->next) {}
		return buf;
	}
	void node::sort() {
		Data *buf; 
		bool was=1;
		while(was){
			was = 0;
			buf = f;
			for (int i = 0; i < count; i++, buf = buf->next){
				if(i+1<count && buf->data > buf->next->data){
					swap(buf->data,buf->next->data);
					was = 1;
				}
			}
		}
	}
	void node::deleteFromHead() {
		if (count == 1)
			deleteAll();
		else if (count > 0){
			Data *buf;
			buf = f;
			f = f->next;
			delete[]buf;
			count--;
		}
	}
	void node::deleteFromTail() {
		if (count == 1)
			deleteAll();
		else if (count > 0){
			Data *buf;
			buf = f;
			while (buf->next != l)
				buf = buf->next;
			buf->next = NULL;
			delete[]l;
			l = buf;
			count--;
		}
	}
	void node::deleteAll() {
		if (count > 0){
			Data *buf, *buf2;
			buf = f;
			while (buf->next != NULL) {
				buf2 = buf->next;
				delete[]buf;
				buf = buf2;
			}
			count=0;
		}
	}
	void node::print() {
		Data*buf = f;
		for (int i = 0; i < count; i++, buf = buf->next)
			cout << i << ". " << buf->data << endl;
	}

}

using namespace n;

void menu() {
	node list;
	Data *buf2;
	int i,buf;
	while (1) {
		system("CLS");
		cout << "1. Add to head" << endl;
		cout << "2. Add to tail" << endl;
		cout << "3. Add by ID" << endl;
		cout << "4. Seach" << endl;
		cout << "5. Seach and change" << endl;
		cout << "6. Reverse" << endl;
		cout << "7. Sort" << endl;
		cout << "8. Delete from head" << endl;
		cout << "9. Delete from tail" << endl;
		cout << "10. Delete all" << endl;
		cout << "11. Print" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin >> i;
				list.addToHead(i);
				break;
			case 2:
				cin >> i;
				list.addToTail(i);
				break;
			case 3:
				cin >> i >> buf;
				list.addById(i,buf);
				break;
			case 4:
				cin >> i;
				buf2=list.seach(i);
				if (buf2 != NULL)
					buf2->print();
				break;
			case 5:
				cin >> i >> buf;
				list.seachAndChange(i, buf);
				break;
			case 6:
				list.reverse();
				break;
			case 7:
				list.sort();
				break;
			case 8:
				list.deleteFromHead();
				break;
			case 9:
				list.deleteFromTail();
				break;
			case 10:
				list.deleteAll();
				break;
			case 11:
				list.print();
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
*/

/*
#include <iostream>
#pragma warning(disable:4996)

using namespace std;

namespace p{

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
}

using namespace p;

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
*/

/*
#include <iostream>
#pragma warning(disable:4996)

using namespace std;

namespace d{

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
		// For newer versions of vs
		//cin.getlne(buf->w1,1024);
		//cin.getlne(buf->w2,1024);
		// For older versions of vs
		gets(buf->w1);
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
}

using namespace d;

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
*/