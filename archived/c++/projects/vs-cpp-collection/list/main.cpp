#include <iostream>

using namespace std;

struct Data{
	int count;
	int data;
	Data* next;
	Data* prev;
	Data(){
		data=0;
	}
	void copy(Data val){
		data=val.data;
	}
};

class node{
	int count;
	Data* f;
	Data* l;
public:
	node(){
		count=0;
		f=NULL;
		l=NULL;
	}
	~node(){
		if(f!=NULL)
			delete []f;
		if(l!=NULL)
			delete []l;
	};
	void addToHead(int);
	void addToTail(int);
	bool addById(int);
	Data seach(int);//Null
	Data seachAndChange(int,int);//-1
	void reverse();
	void sort();
	void deleteFromHead();
	void deleteFromTail();
	void deleteAll();
	bool print();
};


void node::addToHead(int val){
	if(count==1){
		count=1;
		l=NULL;
		f.data=val;
		f.next=NULL;
		f.prev=NULL;
	}
	else if(count==0) {
		f=new Data;
		l=new Data;
		f.val=val;
		l=f;
	}
	else {
		count++;
		Data buf;
		buf.next=f;
		buf.prev=f;
		buf.val=val;
		*f=buf;
	}
}
void node::addToTail(int val){
	if(count==1){
		count=1;
		l=NULL;
		f.data=val;
		f.next=NULL;
	}
	else if(count==0) {
		f=new Data;
		l=new Data;
		f.val=val;
		l=f;
	}
	else {
		count++;
		Data buf;
		buf.next=NULL;
		buf.val=val;
		l.next=buf;
	}
}
bool node::addById(int val, int val2){
	Data *buf;
	buf=f;
	int i=0;
	for(;i<val;i++){
		if(buf.next==NULL)
			break;
		buf=buf.next;
	}
	if(i!=val)
		return -1;
	else {
		Data *buf2;
		buf2.val=val2;
		buf2.next=buf.next;
		buf.next=buf2;
	}
}
Data node::seach(int val){
	Data *buf;
	buf=f;
	while(buf.val!=val && buf.next!=NULL)
		buf=buf.next;
	if(buf.val!=val)
		return NULL;
	else 
		return buf;
}
Data node::seachAndChange(int val,int val2){
	Data *buf;
	buf=f;
	while(buf.val!=val && buf.next!=NULL)
		buf=buf.next;
	if(buf.val!=val)
		return -1;
	else {
		buf.val=val2;
		return buf;
	}
}
void node::reverse(){
	Data *buf;
	buf=f;
	int i=1;
	for(;buf.next!=NULL;i++)
		buf=buf.next;
	Data *buf2[i];

}
void node::sort(){

}
void node::deleteFromHead(){
	Data *buf;
	buf=f;
	f=f.next;
	delete[]buf;
}
void node::deleteFromTail(){
	Data *buf;
	buf=f;
	while(buf.next!=l)
		buf=buf.next;
	buf.next=NULL;
	delete[]l;
	l=buf;
}
void node::deleteAll(){
	Data *buf,*buf2;
	buf=f;
	while(buf.next!=NULL){
		buf2=buf.next;
		delete[]f;
		buf=buf2;
	}
}

bool node::print(){
	if(count==0)
		return 0;
	cout << data[count].data << endl;
	if(count==1){
		count = 0;
		delete []data;
	}
	else {
		int max=0;
		for(int i=1;i<count;i++)
			if(data[i].prioritet>data[max].prioritet)
				max=i;
		node *buf = new node[count-1];
		for (int i = 0,real=0; i < count; i++){
			if(i!=max){
				buf->data[real].copy(data[i]);
				real++;
			}
		}
		count--;
		delete []data;
		data=buf->data;
	}
}

void menu(){
	node list;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Add to head" << endl;
		cout << "2. Add to tail" << endl;
		cout << "3. Delete from head" << endl;
		cout << "4. Delete from tail" << endl;
		cout << "5. Delete all" << endl;
		cout << "6. Show all" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		char buf1[100], buf2[100];
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
				list.deleteFromHead();
				break;
			case 4:
				list.deleteAll();
				break;
			case 5:
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