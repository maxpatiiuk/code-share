#include <iostream>

using namespace std;

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