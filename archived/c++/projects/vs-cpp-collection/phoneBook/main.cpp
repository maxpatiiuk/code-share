#include <iostream>
#include <memory>
#include <string>

using namespace std;

class phone{
public:
	phone *next;
	string name;
	string surname;
	string birthDate;
	string email;
	string phoneNumber;
	phone(string iName, string iSurname="", string iBirthDate="", string iEmail="", string iPhone="", phone *iNext=NULL): name(iName), surname(iSurname), birthDate(iBirthDate), email(iEmail), phoneNumber(iPhone), next(iNext){}
	phone(){
		phone("", "", "", "", "", NULL);
	}
	phone(const phone &buf){
		name = buf.name;
		surname = buf.surname;
		birthDate = buf.birthDate;
		email = buf.email;
		phoneNumber = buf.phoneNumber;
		next = buf.next;
	}
	~phone(){};
};

class phones{
	phone *f;
	int count;
	void del(phone*);
public:
	phones():f(NULL),count(0){}
	void add(string,string,string,string,string);
	void seach(string);
	void print();
	void sort(const int);
	void clear(int);
};

void phones::add(string bufString, string bufString2, string bufString3, string bufString4, string bufString5){
	if(count==0)
		f=new phone(bufString,bufString2,bufString3,bufString4,bufString5);
	else{
		phone *buf = new phone(bufString,bufString2,bufString3,bufString4,bufString5);
		phone *buf2=f;
		while(buf2!=NULL && buf2->next!=NULL)
			buf2=buf2->next;
		buf2->next=buf;
	}
	count++;
}
void phones::seach(string bufString){
	for(phone *buf=f;buf!=NULL;buf=buf->next)
		if(buf->name.compare(bufString)==0 || buf->surname.compare(bufString)==0 || buf->birthDate.compare(bufString)==0 || buf->email.compare(bufString)==0 || buf->phoneNumber.compare(bufString)==0)
			cout << buf->name << "\t" << buf->surname << "\t" << buf->birthDate << "\t" << buf->email << "\t" << buf->phoneNumber << endl;
}
void phones::print(){
	phone *buf=f;
	for(int i=1;buf!=NULL;buf=buf->next,i++)
		cout << i << "\t" << buf->name << "\t" << buf->surname << "\t" << buf->birthDate << "\t" << buf->email << "\t" << buf->phoneNumber << endl;
}
void phones::clear(int buf){
	if(count>0){
		phone *buf2=f;
		if(buf==1){
			if(count==1)
				del(f);
			else {
				f=f->next;
				del(buf2);
			}
		}
		else {
			int i=1;
			phone *buf3;
			for(;buf2!=NULL&&i+1!=buf;i++){}
			if(i+1==buf && buf2!=NULL && buf2->next!=NULL){
				buf3=buf2->next;
				buf2->next=buf2->next->next;
				del(buf3);
			}
		}
	}
}
void phones::del(phone *buf3){
	buf3->name.clear();
	buf3->surname.clear();
	buf3->birthDate.clear();
	buf3->email.clear();
	buf3->phoneNumber.clear();
	delete buf3;
	count--;
}
void phones::sort(const int type){
	if(count>0 && type>0 && type<6){
		bool buf2=1;
		while(buf2){
			int i=0;
			buf2=0;
			for(phone *buf=f;buf!=NULL&&buf->next!=NULL;i++,buf=buf->next){
				if(
					(type==1 && buf->name.compare(buf->next->name)<0) ||
					(type==2 && buf->surname.compare(buf->next->surname)<0) ||
					(type==3 && buf->birthDate.compare(buf->next->birthDate)<0) ||
					(type==4 && buf->email.compare(buf->next->email)<0) ||
					(type==5 && buf->phoneNumber.compare(buf->next->phoneNumber)<0)
				){
					buf->name.swap(buf->next->name);
					buf->surname.swap(buf->next->surname);
					buf->birthDate.swap(buf->next->birthDate);
					buf->email.swap(buf->next->email);
					buf->phoneNumber.swap(buf->next->phoneNumber);
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
		cout << "4. Sort" << endl;
		cout << "5. Print all" << endl;
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
			case 5:
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