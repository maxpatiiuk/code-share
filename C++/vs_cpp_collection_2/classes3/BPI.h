#include <iostream>

class BPI {
	char* name;
	int count;
	double price;

public:

	BPI();
	BPI(char*, int, double);
	~BPI();

	char* getName() const;
	int getCount() const;
	int getPrice() const;

	void setName(char*);
	void setCount(int);
	void setPrice(double);

	void print();
};

class Shop {
	char* name;
	int id,size,current;
	BPI* products;

public:

	Shop();
	Shop(char*, int, BPI);
	~Shop();

	char* getName() const;
	int getId() const;
	int getSize() const;

	void setName(char*);
	void setId(int);
	void setCurrent(int);

	void printAll();
	void addProduct();
};