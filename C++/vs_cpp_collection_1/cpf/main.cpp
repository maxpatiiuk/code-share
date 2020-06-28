#include <iostream>

class Vector{
public:
	double x,y;
	double getX(){
		return x;
	}
	double getY(){
		return y;
	}
	void set(double xN, double yN){
		x=xN;
		y=yN;
	}
	Vector plus(Vector a){
		Vector k;
		k.x=x+a.x;
		k.y=y+a.y;
		return k;
	}
	Vector multiply(Vector a){
		Vector k;
		k.x=a.x*x;
		k.y=a.y*y;
		return k;
	}
	Vector multiply(double m){
		Vector k;
		k.x=x*m;
		k.y=y*m;
		return k;
	}
};

using namespace std;

Vector a,b,c;

void main(){
	b.set(5,6);
	c.set(7,8);
	a.set(b.getX(),c.getY());
	a=a.plus(b);
	cout << a.getX()  << "\t" << a.getY() << endl;
	b=b.multiply(c);
	cout << b.getX()  << "\t" << b.getY() << endl;
	c=c.multiply(10);
	cout << c.getX()  << "\t" << c.getY() << endl;
}

/*
#include <iostream>
#include "drop.h"

using namespace std;

doubleCalc a;

void menu(){
	while(0!=1){
		system("CLS");
		cout << "	1. cin()" << endl;
		cout << "	2. cout()" << endl;
		cout << "	3. setTop(double)" << endl;
		cout << "	4. setBottom(double)" << endl;
		cout << "	5. returnTop()" << endl;
		cout << "	6. returnBottom()" << endl;
		cout << "	7. calculateResult()" << endl;
		cout << "	8. calculateTwo(double, double)" << endl;
		cout << "	0. exit(0)" << endl;
		system("CLS");
		int menu;
		cin >> menu;
		switch (menu) {
			case 1:
				a.cin(value);
				break;
			case 2:
				a.cout();
				break;
			case 3:
				cin << value;
				a.setTop(double);
				break;
			case 4:
				cin << value;
				a.setBottom(double);
				break;
			case 5:
				a.returnTop();
				break;
			case 6:
				a.returnBottom();
				break;
			case 7:
				a.calculateResult();
				break;
			case 8:
				double fir,sec;
				cin >> fir >> sec;
				a.calculateTwo(double fir, double sec);
				break;
			case 0:
				exit(0);
				break;
		}
		system("pause");
	}
}

void main(){
	setTop(0);
	setBottom(0);
	menu();
}
*/

/*
#include <iostream>
class Drob {
	public:
		Drob(){//Конструктор по замовчуванню
			zn=0;
			ch=1;
		}
		Drob(int izn,int ich){//перегружений конструктор

			zn=izn;
			ch=ich;
		}
}
void main(){
	Drob::Drob a(5,6);
	Drob::Drob *b = new Drob(7,8);
}
*/

/*
#include <iostream>

using namespace std;

class date{
public:
	int day;
	int month;
	int year;
	void cin(){
		std::cin >> day >> month >> year;
	}
	void setDay(int value){
		day=value;
	}
	void setMonth(int value){
		month=value;
	}
	void setYear(int value){
		year=value;
	}
	int returnDay(){
		return day;
	}
	int returnMonth(){
		return month;
	}
	int returnYear(){
		return year;
	}
	void cout(){
		std::cout << std::endl << day << endl;
		std::cout << month << endl;
		std::cout << year << endl << endl;
	}
};
date a;
void main(){
	//a.day=01;
	//a.month=01;
	//a.year=2004;
	//cout << a.day << endl;
	//cout << a.month << endl;
	//cout << a.year << endl << endl;
	a.cin();
	a.cout();
	int buf=0;
	cin >> buf;
	a.setDay(buf);
	cin >> buf;
	a.setMonth(buf);
	cin >> buf;
	a.setYear(buf);
	cout << a.returnDay() << endl;
	cout << a.returnMonth() << endl;
	cout << a.returnYear() << endl;
	system("pause");
}
*/