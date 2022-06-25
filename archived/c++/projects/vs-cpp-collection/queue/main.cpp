#include <iostream>
#define size 10
#define loop for(int i=0;i<size;i++)
#define deafult -99999

using namespace std;

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

void menuText(){
	cout << "1. Set queue" << endl;
	cout << "2. Get queue" << endl;
	cout << "3. Get first" << endl;
	cout << "4. Get last" << endl;
	cout << "0. Exit" << endl;
}
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