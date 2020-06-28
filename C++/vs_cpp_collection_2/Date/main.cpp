#include <iostream>
#include <ctime>
#include <string.h>

using namespace std;
/*
11 12 2002
21 3 2003
*/

class Date {
	int d, m, y;
public:
	Date() : d(1),m(1),y(1) {}
	Date(int id,int im=1, int iy=2018) : d(id),m(im),y(iy) {}
	Date(const Date &p) : d(p.d), m(p.m), y(p.y) {}
	~Date() {}
	void input();
	void print() const;
	int getD() const;
	int getM() const;
	int getY() const;
	void setD(int);
	void setM(int);
	void setY(int);
	void append(int);
	void operator*(const Date&);
};
class AllDates {
	int dates_count;
public:
	Date* dates;
	void addLine(const Date& line);
	AllDates(): dates_count(0), dates(NULL){}
	~AllDates()
	{
		if (dates)
			delete dates;
	}
	int getDatesCount() const;
	void deleteLine(int idx);
	void printAll();
};

bool isLeapYear(int year) {
	return (year % 4 == 0 && year % 100 != 0) || (year % 400 == 0);
}
int getDays(int month,int year) {
	int day;
	if (month > 12)
		month = month%12+1;
	if (month < 1)
		month = 1;
	if (month == 4 || month == 6 || month == 9 || month == 11)
		day = 30;
	else if (month == 2){
		if (isLeapYear(year))
			day = 29;
		else
			day = 28;
	}
	else
		day = 31; 
	return day;
}

void Date::input(){
	cout << "D:" << endl;
	cin >> d;
	cout << "M:" << endl;
	cin >> m;
	cout << "Y:" << endl;
	cin >> y;
}
void Date::append(int i){
	setD(getD()+i);
	int buf = getDays(getM(), getY());
	while(getD()>= buf){
		setD(getD()-buf);
		setM(getM()+1);
		buf = getDays(getM(), getY());
	}
	setY(getY() + (getM() - getM() % 12) / 12);
	setM(getM()%12);
}
void Date::print() const {
	cout << getD() << ':' << getM() << ':' << getY();
}
int Date::getD() const {
	return d;
}
int Date::getM() const {
	return m;
}
int Date::getY() const {
	return y;
}
void Date::setD(int val){
	d=val;
}
void Date::setM(int val){
	m=val;
}
void Date::setY(int val){
	y=val;
}
void Date::operator*(const Date& buf){//buf = 1 && this = 2
	int d = buf.getD(),m = buf.getM(),i=0;
	__int64 y = buf.getY(), r1 = (y - y % 4) * 1461, r2;
	y %= 4;
	for (; y != 0; y--, i++)
		r1 += (isLeapYear(buf.getY())) ? 366 : 365;
	y = this->getY();
	r2 = (y - y % 4) * 1461;
	y %= 4;
	for (i=0; y != 0; y--, i++)
		r2 += (isLeapYear(this->getY())) ? 366 : 365;
	for (i = 0; m != 0; i++, m--)
		r1 += getDays(m, buf.getY());
	m = this->getM();
	for (i = 0; m != 0; i++, m--)
		r2 += getDays(m, buf.getY());
	r1 += buf.getD();
	r2 += this->getD();
	cout << r2 - r1;
}
void AllDates::addLine(const Date& src){
	Date* p = new Date[dates_count + 1];
	for (int i = 0; i < dates_count; i++){
		p[i].setD(dates[i].getD());
		p[i].setM(dates[i].getM());
		p[i].setY(dates[i].getY());
	}
	p[dates_count].setD(src.getD());
	p[dates_count].setM(src.getM());
	p[dates_count].setY(src.getY());
	delete[] dates;
	dates = p;
	dates_count++;
}
void AllDates::printAll(){
	for (int i = 0; i < dates_count; i++){
		cout << endl << i << " >> ";
		dates[i].print();
	}
}
int AllDates::getDatesCount() const {
	return dates_count;
}
void AllDates::deleteLine(int idx){
	Date* p = new Date[dates_count - 1];
	for (int i = 0; i < dates_count; i++){
		if (i != idx){
			p[i].setD(dates[i].getD());
			p[i].setM(dates[i].getM());
			p[i].setY(dates[i].getY());
		}
	}
	delete[] dates;
	dates_count--;
}

void menu(){
	AllDates* Dates = new AllDates;
	Date p;
	int i,buf;
	while (1) {
		system("CLS");
		cout << "1. Add date" << endl;
		cout << "2. Append date" << endl;
		cout << "3. Compare dates" << endl;
		cout << "4. Print Date" << endl;
		cout << "5. Print Dates" << endl;
		cout << "6. Get dates count" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
		case 1:
			p.input();
			Dates->addLine(p);
			break;
		case 2:
			Dates->printAll();
			cout << endl << "Enter ID of date to append:" << endl;
			cin >> i;
			cout << endl << "Enter value:" << endl;
			cin >> buf;
			Dates->dates[i].append(buf);
			break;
		case 3:
			Dates->printAll();
			cout << endl << "Enter ID of date#1:" << endl;
			cin >> i;
			cout << endl << "Enter ID of date#2:" << endl;
			cin >> buf;
			Dates->dates[i]*Dates->dates[i];
			break;
		case 4:
			Dates->printAll();
			cout << endl << "Enter ID of date to print:" << endl;
			cin >> i;
			Dates->dates[i].print();
			break;
		case 5:
			Dates->printAll();
			break;
		case 6:
			cout << Dates->getDatesCount();
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

int main(){
	menu();
	return 0;
}
