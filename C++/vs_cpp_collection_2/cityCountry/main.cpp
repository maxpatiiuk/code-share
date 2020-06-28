#include <iostream>
#include <functional>
#include <algorithm>
#include <vector>
#include <fstream>
#include <string>

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
	countries(){}
	countries(const countries &buf){
		data = buf.data;
	}
	~countries(){};
	void read(string path){
		ifstream f(path);
		char buf21[1024];
		char buf22[1024];
		while(!f.eof()){
			Data buf;
			f >> buf.country >> buf.capital;
			add(buf);
		}
		f.close();
	}
	void write(string path){
		ofstream file(path);
		for(int i=0;i<data.size();i++){
			file << data[i].country << endl;
			file << data[i].capital;
			if(i+1<data.size())
				file << endl;
		}
		file.close();
	}
	void edit(int what, Data val){
		data[what]=val;
	}
	void seach(string what){
		for(int i=0;i<data.size();i++)
			if(data[i].country.compare(what)==0 || data[i].capital.compare(what)==0)
				cout << data[i].country << "\t" << data[i].capital << endl;
	}
	void add(Data val){
		data.push_back(val);
	}
	void print(){
		cout << "ID\tCountry\tCapital" << endl;
		for(int i=0;i<data.size();i++)
			cout << i << "\t" << data[i].country << "\t" << data[i].capital << endl;
	}
	int count(){
		return data.size();
	}
	void del(int what){
		data.erase(data.begin()+what);
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
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin.ignore();
				cin >> buf.country >> buf.capital;
				country.add(buf);
				break;
			case 2:
				country.print();
				cout << endl << "Which element do you want to edit? (-1 for cancel)" << endl;
				cin >> i;
				if(i!=-1){
					cin.ignore();
					cin >> buf.country >> buf.capital;
					country.edit(i,buf);
				}
				break;
			case 3:
				country.print();
				cout << endl << "Which element do you want to delete? (-1 for cancel)" << endl;
				cin >> i;
				if(i!=-1)
					country.del(i);
				break;
			case 4:
				cout << country.count() << endl;
				break;
			case 5:
				country.print();
				break;
			case 6:
				cin.ignore();
				cout << "Path:" << endl;
				cin >> buf.country;
				country.read(buf.country);
				break;
			case 7:
				cin.ignore();
				cout << "Path:" << endl;
				cin >> buf.country;
				country.write(buf.country);
				break;
			case 8:
				cin.ignore();
				cout << "What to seach for:" << endl;
				cin >> buf.country;
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