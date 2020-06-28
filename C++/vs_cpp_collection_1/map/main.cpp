#include <iostream>
#include <map>
#include <string>
#include <fstream>

using namespace std;

class word{
public:
	string name;
	string translation;
	word(string iName, string iTranslation): name(iName), translation(iTranslation){}
	word(){
		word("", "");
	}
	word(const word &buf){
		name = buf.name;
		translation = buf.translation;
	}
	~word(){};
};

class dictionary{
	map<int,word> f;
public:
	dictionary(){};
	void add(string,string);
	void seach(string);
	void print();
	void sort(const int);
	void clear(int);
	void clearAll();
	void read(string);
	void write(string);
};

void dictionary::add(string bufString, string bufString2){
	word buf(bufString,bufString2);
	f[f.size()]= buf;
}
void dictionary::seach(string bufString){
	for(int i=0;i<f.size();i++)
		if(f[i].name.compare(bufString)==0 || f[i].translation.compare(bufString)==0)
			cout << f[i].name << "\t" << f[i].translation << endl;
}
void dictionary::print(){
	for(int i=0;i<f.size();i++)
		cout << i << "\t" << f[i].name << "\t" << f[i].translation << endl;
}
void dictionary::clearAll(){
	f.clear();
}
void dictionary::clear(int buf){
	f.erase(buf);
}
void dictionary::sort(const int type){
	if(!f.empty() && type>0 && type<6){
		bool buf2=1;
		while(buf2){
			buf2=0;
			for(int i=0;i<f.size()-1;i++){
				if(
					(type==1 && f[i].name.compare(f[i+1].name)<0) ||
					(type==2 && f[i].translation.compare(f[i+1].translation)<0)
				){
					swap(f[i],f[i+1]);
					buf2=1;
				}
			}
		}
	}
}
void dictionary::read(string path){
	ifstream f(path);
	char buf21[1024];
	char buf22[1024];
	while(!f.eof()){
		f.read(buf21,1024);
		f.read(buf22,1024);
		add(buf21,buf22);
	}
	f.close();
}
void dictionary::write(string path){
	ofstream file(path);
	for(int i=0;i<f.size();i++){
		char * buf21 = new char[f[i].name.size() + 1];
		copy(f[i].name.begin(), f[i].name.end(), buf21);
		buf21[f[i].name.size()] = '\0';
		char * buf22 = new char[f[i].translation.size() + 1];
		copy(f[i].translation.begin(), f[i].translation.end(), buf22);
		buf21[f[i].translation.size()] = '\0';
		file.write(buf21,strlen(buf21));
		file.write(buf22,strlen(buf22));
		delete[]buf21;
		delete[]buf22;
	}
	file.close();
}

void menu(){
	dictionary words;
	int i;
	string bufString, bufString2;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Seach" << endl;
		cout << "3. Delete" << endl;
		cout << "4. Delete all" << endl;
		cout << "5. Sort" << endl;
		cout << "6. Print all" << endl;
		cout << "7. Read from file" << endl;
		cout << "8. Write into file" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin.ignore();
				getline(cin,bufString);
				getline(cin,bufString2);
				words.add(bufString,bufString2);
				break;
			case 2:
				cin.ignore();
				getline(cin,bufString);
				words.seach(bufString);
				break;
			case 3:
				words.print();
				cout << "ID of ontact ot delete:" << endl;
				cin >> i;
				words.clear(i);
				break;
			case 4:
				cout << "Deleted" << endl;
				words.clearAll();
				break;
			case 5:
				cout << "1. Sort by name" << endl;
				cout << "2. Sort by translation" << endl;
				cout << "0. Exit" << endl;
				cin >> i;
				if(i!=0)
					words.sort(i);
				break;
			case 6:
				words.print();
				break;
			case 7:
				cin.ignore();
				getline(cin,bufString);
				words.read(bufString);
				break;
			case 8:
				cin.ignore();
				getline(cin,bufString);
				words.write(bufString);
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