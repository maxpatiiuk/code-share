#include <iostream>
#include <functional>
#include <algorithm>
#include <vector>
#include <fstream>

using namespace std;

class Data{
public:
	string country;
	string capital;
	Data(string iC,string iCc): country(iC), capital(iCc){}
	Data(){
		Data("","");
	}
	~Data(){};
};
class countries{
	vector<Data> data;
public:
	countries(vector<Data> iData): data(iData){}
	countries(){
		vector<Data> buf;
		countries();
	}
	countries(const countries &buf){
		data = buf.data;
	}
	~countries(){};
	void write(string path){

	}
	void read(string path){

	}
	void edit(int what, Data val){
		data[what]=val;
	}
	void seach(string what){
		for(int i=0;i<data.size;i++)
			if(data[i].country.compare(what) || data[i].capital.compare(what))
				cout << data[i].country << "\t" << data[i].capital << endl;
	}
	void add(Data val){
		data.push_back(val);
	}
	void print(){
		cout << "ID\tCountry\tCapital" << endl;
		for(int i=0;i<data.size;i++)
			cout << i << "\t" << data[i].country << "\t" << data[i].capital << endl;
	}
	int count(){
		return data.size;
	}
	void del(int what){
		data.erase(what);
	}
	void edit(){

	}
};
void menu(){
	countries country;
	Data buf;
	string b;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Edit" << endl;
		cout << "3. Delete" << endl;
		cout << "4. Count" << endl;
		cout << "5. Print" << endl;
		cout << "6. Read" << endl;
		cout << "7. Write" << endl;
		cout << "8. Seach" << endl;
		cout << "9. Get data" << endl;
		cout << "10. Set data" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin.ignore();
				cin >> buf.country;
				gets(buf.country);
				gets_s(cin,buf.country);
				cin.getline(&buf.country);
				cin.getline(buf.country);
				cin.getline(buf.country,1024);
				cin.getline(b,1024);
				getline(cin,b);
				gets(buf.country);
				cin.getline(buf.capital,1024);
				country.add(buf);
				break;
			case 2:
				print();
				cout << endl << "Which element do you want to edit? (-1 for cancel)" << endl;
				cin >> i;
				if(i!=-1){
					cin.ignore();
					cin.getline(buf.country,1024);
					cin.getline(buf.capital,1024);
					country.edit(i,buf);
				}
				break;
			case 3:
				print();
				cout << endl << "Which element do you want to delete? (-1 for cancel)" << endl;
				cin >> i;
				if(i!=-1)
					country.del(i);
				break;
			case 4:
				cout << county.count() << endl;
				break;
			case 5:
				print();
				break;
			case 6:
				cin.ignore();
				cout << "Path:" << endl;
				cin.getline(buf.country,1024);
				country.read(buf.country);
				break;
			case 7:
				cin.ignore();
				cout << "Path:" << endl;
				cin.getline(buf.country,1024);
				country.write(buf.country);
				break;
			case 8:
				cin.ignore();
				cout << "What to seach for:" << endl;
				cin.getline(buf.country,1024);
				country.seach(buf.country);
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

void main() {
	menu();
}