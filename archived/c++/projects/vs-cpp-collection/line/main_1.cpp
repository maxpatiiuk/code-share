#include <iostream>

using namespace std;


struct add{
	int number;
	char* name;
	void copy(add*);
	void set(int,char*);
};

void add::copy(add *val){
	number=val->number;
	delete[]name;
	name = new char[strlen(val->name)];
	strcpy(name,val->name);
}
void add::set(int val,char* iName){
	number = val;
	name = new char[strlen(iName)];
	strcpy(name,iName);
}

class Line{
	add *data;
	int count;
public:
	Line(int,int,char*);
	Line();
	Line(Line&);
	add* Push(add*);
	add Pop();
	add Peek();
	int getCount() const;
};
Line::Line(int vcou,int val,char*valName): count(vcou){
	data = new add;
	data[count].set(val,valName);
	cout << count;
}
Line::Line(){
	Line(0,0,"");
	cout << count;
}
Line::Line(Line&S){
	delete[]data;
	data->copy(S.data);
	data=S.data;
}
add* Line::Push(add *value){
	count++;
	add *bigBuf = new add[count];
	for (int i = 0; i < count-1; i++)
		bigBuf[i].copy(&data[i]);
	bigBuf[count-1].copy(value);
	delete []data;
	data=bigBuf;
	return data;
}
add Line::Pop(){
	count--;
	add buf = data[count];
	add *bigBuf = new add[count];
	for (int i = 1; i <= count; i++)
		bigBuf[i].copy(&data[i]);
	delete []data;
	data=bigBuf;
	return buf;
}
add Line::Peek(){
	return data[count-1];
}
int Line::getCount() const {
	return count;
}

void menu(){
	Line *contacts = new Line;
	int i;
	char *name;
	while(1){
		system("CLS");
		cout << "1. Push" << endl;
		cout << "2. Pop" << endl;
		cout << "3. Peek" << endl;
		cout << "4. Count elements" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				cin >> i;
				name= new char;
				cin.getline(name,1024);
				{
					add buf;
					buf.set(i,name);
					contacts->Push(&buf);
				}
				break;
			case 2:
				cout << contacts->Pop().number << endl << contacts->Pop().name;
				break;
			case 3:
				cout << contacts->Peek().number << endl << contacts->Peek().name;
				break;
			case 4:
				cout << contacts->getCount();
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

void main(){
	menu();
}