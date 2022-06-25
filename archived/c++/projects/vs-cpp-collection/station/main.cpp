#include <iostream>
#include <memory>
#include <string>
#include <vector>

using namespace std;

class train{
public:
	int id;
	string dTime;
	string destination;
	train(int iId, string iDTime="", string iDestination=""): id(iId), dTime(iDTime), destination(iDestination){}
	train(){
		train(0, "", "");
	}
	train(const train &buf){
		id = buf.id;
		dTime = buf.dTime;
		destination = buf.destination;
	}
	~train(){};
};

class railway{
	vector<train> f;
public:
	railway(){}
	void add(int,string,string);
	void seach(int);
	void print();
};

void railway::add(int bufInt, string bufString2, string bufString3){
	train *buf = new train(bufInt,bufString2,bufString3);
	f.push_back(*buf);
}
void railway::seach(int bufInt){
	for(vector<train>::iterator it=f.begin();it!=f.end();it++)
		if(it->id==bufInt)
			cout << it->id << "\t" << it->dTime << "\t" << it->destination << endl;
}
void railway::print(){
	for(vector<train>::iterator it=f.begin();it!=f.end();it++)
		cout << it->id << "\t" << it->dTime << "\t" << it->destination << endl;
}

void menu(){
	railway station;
	int i;
	string bufString2, bufString3;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Print by id" << endl;
		cout << "3. Print all" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin >> i;
				cin.ignore();
				getline(cin,bufString2);
				getline(cin,bufString3);
				station.add(i,bufString2,bufString3);
				break;
			case 2:
				cin >> i;
				station.seach(i);
				break;
			case 3:
				station.print();
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