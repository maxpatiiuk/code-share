/*
#include <iostream>
#include <list>
#include <string>

using namespace std;

class phone{
public:
	string name;
	string surname;
	string birthDate;
	string email;
	string phoneNumber;
	phone(string iName, string iSurname, string iBirthDate, string iEmail, string iPhone): name(iName), surname(iSurname), birthDate(iBirthDate), email(iEmail), phoneNumber(iPhone){}
	phone(){
		phone("", "", "", "", "");
	}
	phone(const phone &buf){
		name = buf.name;
		surname = buf.surname;
		birthDate = buf.birthDate;
		email = buf.email;
		phoneNumber = buf.phoneNumber;
	}
	~phone(){};
};

class phones{
	list<phone> f;
public:
	phones(){};
	void add(string,string,string,string,string);
	void seach(string);
	void print();
	void sort(const int);
	void clear(int);
	void clearAll();
	list<phone>::iterator get(int);
};


list<phone>::iterator phones::get(int el){
	list<phone>::iterator it=f.begin();
	for(int i=0;it!=f.end() && i!=el;it++,i++){}
	return it;
}

void phones::add(string bufString, string bufString2, string bufString3, string bufString4, string bufString5){
	phone buf(bufString,bufString2,bufString3,bufString4,bufString5);
	f.push_back(buf);
}
void phones::seach(string bufString){
	for(int i=0;i<f.size();i++)
		if((*get(i)).name.compare(bufString)==0 || (*get(i)).surname.compare(bufString)==0 || (*get(i)).birthDate.compare(bufString)==0 || (*get(i)).email.compare(bufString)==0 || (*get(i)).phoneNumber.compare(bufString)==0)
			cout << (*get(i)).name << "\t" << (*get(i)).surname << "\t" << (*get(i)).birthDate << "\t" << (*get(i)).email << "\t" << (*get(i)).phoneNumber << endl;
}
void phones::print(){
	for(int i=0;i<f.size();i++)
		cout << i << "\t" << (*get(i)).name << "\t" << (*get(i)).surname << "\t" << (*get(i)).birthDate << "\t" << (*get(i)).email << "\t" << (*get(i)).phoneNumber << endl;
}
void phones::clearAll(){
	f.clear();
}
void phones::clear(int buf){
	f.erase(get(buf));
}
void phones::sort(const int type){
	if(!f.empty() && type>0 && type<6){
		bool buf2=1;
		while(buf2){
			buf2=0;
			for(int i=0;i<f.size()-1;i++){
				if(
					(type==1 && (*get(i)).name.compare((*get(i+1)).name)<0) ||
					(type==2 && (*get(i)).surname.compare((*get(i+1)).surname)<0) ||
					(type==3 && (*get(i)).birthDate.compare((*get(i+1)).birthDate)<0) ||
					(type==4 && (*get(i)).email.compare((*get(i+1)).email)<0) ||
					(type==5 && (*get(i)).phoneNumber.compare((*get(i+1)).phoneNumber)<0)
				){
					swap(*get(i),*get(i+1));
					buf2=1;
				}
			}
		}
	}
}

void menu(){
	phones book;
	int i;
	string bufString, bufString2, bufString3, bufString4, bufString5;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. Seach" << endl;
		cout << "3. Delete" << endl;
		cout << "4. Delete all" << endl;
		cout << "5. Sort" << endl;
		cout << "6. Print all" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cin.ignore();
				getline(cin,bufString);
				getline(cin,bufString2);
				getline(cin,bufString3);
				getline(cin,bufString4);
				getline(cin,bufString5);
				book.add(bufString,bufString2,bufString3,bufString4,bufString5);
				break;
			case 2:
				cin.ignore();
				getline(cin,bufString);
				book.seach(bufString);
				break;
			case 3:
				book.print();
				cout << "ID of ontact ot delete:" << endl;
				cin >> i;
				book.clear(i);
				break;
			case 4:
				cout << "Deleted" << endl;
				book.clearAll();
				break;
			case 5:
				cout << "1. Sort by name" << endl;
				cout << "2. Sort by surname" << endl;
				cout << "3. Sort by birthDate" << endl;
				cout << "4. Sort by email" << endl;
				cout << "5. Sort by phoneNumber" << endl;
				cout << "0. Exit" << endl;
				cin >> i;
				if(i!=0)
					book.sort(i);
				break;
			case 6:
				book.print();
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
*/

#include <iostream>
#include <list>
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
	list<word> f;
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
	list<word>::iterator get(int);
};


list<word>::iterator dictionary::get(int el){
	list<word>::iterator it=f.begin();
	for(int i=0;it!=f.end() && i!=el;it++,i++){}
	return it;
}

void dictionary::add(string bufString, string bufString2){
	word buf(bufString,bufString2);
	f.push_back(buf);
}
void dictionary::seach(string bufString){
	for(int i=0;i<f.size();i++)
		if((*get(i)).name.compare(bufString)==0 || (*get(i)).translation.compare(bufString)==0)
			cout << (*get(i)).name << "\t" << (*get(i)).translation << endl;
}
void dictionary::print(){
	for(int i=0;i<f.size();i++)
		cout << i << "\t" << (*get(i)).name << "\t" << (*get(i)).translation << endl;
}
void dictionary::clearAll(){
	f.clear();
}
void dictionary::clear(int buf){
	f.erase(get(buf));
}
void dictionary::sort(const int type){
	if(!f.empty() && type>0 && type<6){
		bool buf2=1;
		while(buf2){
			buf2=0;
			for(int i=0;i<f.size()-1;i++){
				if(
					(type==1 && (*get(i)).name.compare((*get(i+1)).name)<0) ||
					(type==2 && (*get(i)).translation.compare((*get(i+1)).translation)<0)
				){
					swap(*get(i),*get(i+1));
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
		char * buf21 = new char[(*get(i)).name.size() + 1];
		copy((*get(i)).name.begin(), (*get(i)).name.end(), buf21);
		buf21[(*get(i)).name.size()] = '\0';
		char * buf22 = new char[(*get(i)).translation.size() + 1];
		copy((*get(i)).translation.begin(), (*get(i)).translation.end(), buf22);
		buf21[(*get(i)).translation.size()] = '\0';
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