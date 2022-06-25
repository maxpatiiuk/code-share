#include <iostream>

using namespace std;

class circle{
	double r;
public:
	circle(): r(10) {}

	void setR(int value){
		r=value;
	}
	void getR(){
		return r;
	}
	float calcS(){
		return 3.141592*pow(r,2);
	}
	float calcP(){
		return 2*3.141592*r;
	}
};

class rectangle{
	double a,b;
public:
	rectangle(): a(10), b(20) {}

	void setA(int value){
		a=value;
	}
	void setB(int value){
		b=value;
	}
	void getA(){
		return a;
	}
	void getA(){
		return b;
	}
	float calcS(){
		return 3.141592*pow(r,2);
	}
	float calcP(){
		return 2*3.141592*r;
	}
};