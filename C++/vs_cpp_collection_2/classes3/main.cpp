#include <iostream>
#include "BPI.h"

using namespace std;

void menu(){
	Shop mainShop;
	int i,buf;
	char* buf2=new char;
	double buf3;
	while(1){
		system("CLS");
		mainShop.products[mainShop.getCurrent()].print();
		cout << "1 - setShopName" << endl;
		cout << "2 - setShopId" << endl;
		cout << "3 - setShopSize" << endl;
		cout << "4 - getProductsCount" << endl;
		cout << "5 - setCurrentProduct" << endl;
		cout << "6 - setProductName" << endl;
		cout << "7 - setProductPrice" << endl;
		cout << "8 - setProductCount" << endl;
		cout << "9 - addProduct" << endl;
		cout << "10 - printProduct" << endl;
		cout << "11 - printAll" << endl;
		cout << "0 - Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				cin.getLine(buf2,1024);
				mainShop.setName(buf2);
				break;
			case 2:
				cin >> buf;
				mainShop.setId(buf);
				break;
			case 3:
				cin >> buf;
				mainShop.setSize(buf);
				break;
			case 4:
				cout << mainShop.getSize() << endl;
				break;
			case 5:
				cin >> buf;
				mainShop.setCurrent(buf);
				break;
			case 6:
				cin.getline(buf2,1024);
				mainShop.products[mainShop.getCurrent()].setName(buf2);
				break;
			case 7:
				cin >> buf;
				mainShop.products[mainShop.getCurrent()].setCount(buf);
				break;
			case 8:
				cin >> buf3;
				mainShop.products[mainShop.getCurrent()].setPrice(buf3);
				break;
			case 9:
				cin.getline(buf2,1024);
				cin >> buf >> buf3;
				mainShop.addProduct(buf2,buf,buf3);
				break;
			case 10:
				mainShop.products[mainShop.getCurrent()].print();
				break;
			case 11:
				mainShop.printAll();
				break;
			case 0:
				exit(0);
				break;
		}
		cout << endl;
		system("pause");
	}
}

void main(){
	menu();
}