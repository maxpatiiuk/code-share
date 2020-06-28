#include <iostream>
using namespace std;

class Date {
	short d, m;
	int y;
public:
	Date(short id = 1, short im = 10, int iy = 2020) : d(id), m(im), y(iy) {}
	void print();
};
class DocLine {
	char *product;
	double qnt, price;
	double discount;
public:
	DocLine() : product(new char[1]), qnt(1), price(1), discount(1) {
		strcpy(product, "");
	}
	DocLine(char* iproduct, double iqnt = 2, double iprice = 10, double idiscount = 0) : product(new char[strlen(iproduct)]), qnt(iqnt), price(iprice), discount(idiscount) {
		strcpy(product, iproduct);
	}
	DocLine(const DocLine &p) : product(new char[strlen(p.product)]) {
		strcpy(product, p.product);
		product = p.product;
		qnt = p.qnt;
		price = p.price;
		discount = p.discount;
	};
	~DocLine() {}
	void input();
	void print();
	void copy(const DocLine&);
	double calcFullSum();
	double calcDiscountedSum();
	double getPrice();
};
class Document {
	Date curDate;
	DocLine * lines;
	int lines_count;
	Date doc_date;
	void printHeader();
	void printFooter();
	void printLines();
public:
	void addLine(const DocLine &line);
	Document() : lines_count(0), lines(NULL) {}
	~Document() {
		if (lines)
			delete lines;
	}
	int getLinesCount();
	void deleteLine(int idx);
	void print() {
		printHeader();
		printFooter();
		printLines();
	}
	double calcFullSum();
	double calcDiscountedSum();
};

void Date::print() {
	cout << d << ':' << m << ':' << y;
}

void DocLine::copy(const DocLine &p) {
	delete[]product;
	product = new char[strlen(p.product + 1)];
	strcpy(product, p.product);
	product = p.product;
	qnt = p.qnt;
	price = p.price;
	discount = p.discount;
}
void DocLine::input() {
	cin.ignore();
	cout << "Name of product:" << endl;
	cin.getline(product,1024);
	cout << "Quantity:" << endl;
	cin >> qnt;
	cout << "Price:" << endl;
	cin >> price;
	cout << "Discount" << endl;
	cin >> discount;
}
void DocLine::print() {
	cout << *product << '\t' << qnt << " x " << price << " = " << calcFullSum() << " - " << discount << "% = " << calcDiscountedSum();
}
double DocLine::calcFullSum() {
	return price*qnt;
}
double DocLine::calcDiscountedSum() {
	return price*qnt*(100 - discount) / 100;
}
double DocLine::getPrice() {
	return price;
}

void Document::addLine(const DocLine& src) {
	DocLine *p = new DocLine[lines_count + 1];
	for (int i = 0; i < lines_count; i++)
		p[i].copy(lines[i]);
	p[lines_count].copy(src);
	delete[]lines;
	DocLine *lines = p;
	lines_count++;
}
/*void Document::addLine(const DocLine& src) {
	DocLine *p = new DocLine[lines_count + 1];
	for (int i = 0; i < lines_count; i++)
		p[i].copy(lines[i]);
	p[lines_count].copy(src);
	lines_count++;
}*/
void Document::printHeader() {
	cout << "Bill" << endl;
	for (int i = 0; i<20; i++)
		cout << "=";
	cout << endl << "Operator: 1" << endl << "Time: ";
	curDate.print();
	cout << endl;
	for (int i = 0; i<20; i++)
		cout << "=";
	cout << endl;
}
void Document::printLines() {
	for (int i = 0; i<lines_count; i++)
		lines[i].print();
}
void Document::printFooter() {
	cout << endl;
	for (int i = 0; i<20; i++)
		cout << "=";
	double p1 = calcFullSum(), p2 = calcDiscountedSum();
	cout << endl << "Total: " << p1 << " - " << p1 - p2 << " = " << p2 << endl << "Thank you!!!" << endl;
}
double Document::calcFullSum() {
	double price = 0;
	for (int i = 0; i<lines_count; i++)
		price += lines[i].getPrice();
	return price;
}
double Document::calcDiscountedSum() {
	double price = 0;
	for (int i = 0; i<lines_count; i++)
		price += lines[i].getPrice();
	return price;
}
int Document::getLinesCount() {
	return lines_count;
}
void Document::deleteLine(int idx) {
	DocLine *p = new DocLine[lines_count -1];
	for (int i = 0; i < lines_count; i++)
		if(i!=idx)
			p[i].copy(lines[i]);
	delete[]lines;
	lines_count--;
}

void menu() {
	Document *bill = new Document;
	DocLine p;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Add product" << endl;
		cout << "2. Print bill" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
		case 1:
			p.input();
			bill->addLine(p);
		break;
		case 2:
			bill->print();
			break;
		case 0:
			exit(0);
			break;
		}
		system("pause");
		system("CLS");
	}
}

void main() {
	menu();
}