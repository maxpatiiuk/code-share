/*#include <iostream>
using namespace std;
void main(){
	char number[1024];
	cin.getline(number,1024);
	__int64 buf=atoi(number);
	try{
		if(abs(buf)>32767)
			throw "Number is too big";
	}
	catch(char* buf){
		cout << buf << endl;
	}
}*/

#include <iostream>

using namespace std;

template <class T>

class Stacks{
	int count;
	T *p;
public:
	Stacks(int);
	Stacks();
	Stacks(const Stacks&);
	T* Push(T);
	T Pop();
	T Peek();
	int getCount() const;
};
template <class T>
Stacks<T>::Stacks(int val){
	count=val;
	if(count!=0){
		T *p = new T;
		for(int i=0; i<count; i++)
			p=0;
	}
}
template <class T>
Stacks<T>::Stacks(){
	count = 0;
	p=NULL;
}
template <class T>
Stacks<T>::Stacks(const Stacks&S){
	count=S.count;
	delete[]S;
	p=S;
	return *this;
}
template <class T>
T* Stacks<T>::Push(T value){
	count++;
	try{
		if(value==NULL)
			throw "Value is  not defined";
		if(count==NULL)
			throw "Count is not defined";
		if(count<0)
			throw "Count can't be negative";
		if(count>1 && p==NULL)
			throw "No memory";
	}
	catch(char* b){
		cout << b;
		return NULL;
	}
	T *bigBuf = new T[count];
	for (int i = 0; i < count-1; i++)
		bigBuf[i]=p[i];
	bigBuf[count-1]=value;
	delete []p;
	p=bigBuf;
	return p;
}
template <class T>
T Stacks<T>::Pop(){
	try{
		if(count>100)
			throw "To many elements in stack";
		if(count==NULL)
			throw "Count is not defined";
		if(count<0)
			throw "Count can't be negative";
		if(count>1 && p==NULL)
			throw "No memory";
	}
	catch(char* b){
		cout << b;
		return NULL;
	}
	count--;
	T buf = p[count];
	T *bigBuf = new T[count];
	for (int i = 0; i < count; i++)
		bigBuf[i]=p[i];
	delete []p;
	p=bigBuf;
	return buf;
}
template <class T>
T Stacks<T>::Peek(){
	return p[count-1];
}
template <class T>
int Stacks<T>::getCount() const {
	try{
		if(count==NULL)
			throw "Count is not defined";
		if(count<0)
			throw "Count can't be negative";
		if(count>1 && p==NULL)
			throw "No memory";
	}
	catch(char* b){
		cout << b;
		return NULL;
	}
	return count;
}

void menu(){
	Stacks<int> *stack = new Stacks<int>;
	int i;
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
				stack->Push(i);
				break;
			case 2:
				cout << stack->Pop();
				break;
			case 3:
				cout << stack->Peek();
				break;
			case 4:
				cout << stack->getCount();
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