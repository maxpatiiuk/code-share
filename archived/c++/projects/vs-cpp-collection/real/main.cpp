#include <iostream>

using namespace std;

class A {
	int digit;
public:
	A(int iDigit = 1): digit(iDigit){}
	void* operator new(size_t iz){
		cout << iz << endl;
		return malloc(iz);
	}
	void* operator new[](size_t iz){
		cout << iz << endl;
		return malloc(iz);
	}
	void operator delete(void *ptr){
		cout << "Deleted" << endl;
		free(ptr);
	}
	void operator delete[](void *ptr){
		cout << "Deleted" << endl;
		free(ptr);
	}
	ostream friend & operator << ( ostream & os, const A &p);
	istream friend & operator >> ( istream & os, A &p);
};


ostream & operator << ( ostream & os, const A &p){
	os << "A.a " << p.digit << endl;
	return os;
}
istream & operator >> ( istream & os, A &p){
	os >> p.digit;
	return os;
}


void main(){
		A *p=new A(),*g;
		g = new A();
		cin >> *g;
		cout << *g;
		delete []g;
		p = new A[10];
		cout << *p;
		delete []p;
		system("pause");
}