#include <iostream>
#include <time.h>
using namespace std;
class Animal {
	public:
	Animal(){ }
	virtual void voice(){}
};
class Dog: public Animal {
public:
	void voice() {
		cout << "Gav";
	}
};
class Cat: public Animal {
public:
	void voice() {
		cout << "Niav";
	}
};
class Duck: public Animal {
public:
	void voice() {
		cout << "Kra";
	}
};
void main(){
	srand(time(0));
	Animal *z[10];
	for(int buf=0,i=0;i<10;buf=0,i++){
		buf=rand()%4;
		if(buf==0)
			z[i]=new Dog;
		else if(buf==1)
			z[i]=new Cat;
		else
			z[i]=new Duck;
		z[i]->voice();
		cout << endl;
	}
	system("pause");
}