#include <iostream>
#include <time.h>

using namespace std;

class person {
	char *fio;
	long long phoneHome,phoneMobile;
public:
	person(char *vf = '\0', long long vpm = 0, long long vph = 0) : phoneMobile(vpm), phoneHome(vph) {
		if(vf=='\0')
			fio = new char[0];
		else
			fio = new char[strlen(vf)];
	}
	person(const person &w) : fio(new char[strlen(w.fio)]) {
		strcpy(fio, w.fio);
		phoneMobile = w.phoneMobile;
		phoneHome = w.phoneHome;
	}
	void show(int);
	char* getFio();
	int getPhoneHome();
	int getPhoneMobile();
	void setFio(char*);
	void setPhoneHome(long long);
	void setPhoneMobile(long long);
};
class contacts{
	static int size;
	person *p;
public:
	static int getSize();
	void setSize(int);
	void appendPerson();
	contacts() : size(NULL), p(new person[size]) {}
	contacts(const contacts &p);
	~contacts() {}
}

int contacts::getSize(){
	return size;
}
void contacts::setSize(int value){
	size=value;
}
void contacts::appendPerson(){
	setSize(getSize()+1);
	person *l= new person[getSize()];
	for(int i=0,size=getSize()-1;i<size;i++){
		
	}
}
void person::show(int id=-1){
	if(id!=-1)
		cout << id << "\t";
	else
		cout << " \t";
	cout << getFio() << "\t" << getPhoneHome() << "\t" << getPhoneMobile() << endl;
}
char* person::getFio(){
	return fio;
}
int person::getPhoneHome(){
	return phoneHome;
}
int person::getPhoneMobile(){
	return phoneMobile;
}
void person::setFio(char *value){
	strcpy(fio,value);
}
void person::setPhoneHome(long long value){
	phoneHome=value;
}
void person::setPhoneMobile(long long value){
	phoneMobile=value;
}

void menu(){
	while(1){
		long long i,val;
		char *fio = new char(0);
		bool was=0;
		system("CLS");
		cout << "1. Add person" << endl;
		cout << "2. Show person" << endl;
		cout << "3. Show all persons" << endl;
		cout << "4. Set fio" << endl;
		cout << "5. Set phone home" << endl;
		cout << "6. Set phone mobile" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				cout << "Enter fio of person:" << endl;
				cin.ignore();
				cin.getline(fio,1024);
				p[contacts::getSize()].setFio(fio);
				cout << "Enter mobile phone number of person:" << endl;
				cin >> i;
				p[contacts.getSize()].setPhoneMobile(i);
				cout << "Enter home phone number of person:" << endl;
				cin >> i;
				p[size].setPhoneHome(i);
				contacts->setSize(contacts.getSize()+1);
				break;
			case 2:
				cout << "Enter id of person to show:" << endl;
				cin >> i;
				if((p[i].getPhoneMobile()!=0) || (p[i].getPhoneHome()!=0) && i<=size)
					p[i].show();
				else
					cout << "Person not found!" << endl;
				break;
			case 3:
				if(size<=0){
					cout << "There are no contacts in phone book!" << endl;
					break;
				}
				for(i=0;i<size;i++)
					p[i].show(i);
				break;
			case 4:
				cout << "Enter id of person to set fio for:" << endl;
				cin >> i;
				if((p[i].getPhoneMobile()!=0 || p[i].getPhoneHome()!=0) && i<=size){
					cout << "Enter new fio:" << endl;
					cin.ignore();
					gets(fio);
					p[i].setFio(fio);
				}
				else
					cout << "Person not found!" << endl;
				break;
			case 5:
				cout << "Enter id of person to set home phone for:" << endl;
				cin >> i;
				if((p[i].getPhoneMobile()!=0 || p[i].getPhoneHome()!=0) && i<=size){
					cout << "Enter new home phone:" << endl;
					cin >> val;
					p[i].setPhoneHome(val);
				}
				else
					cout << "Person not found!" << endl;
				break;
			case 6:
				cout << "Enter id of person to set mobile phone for:" << endl;
				cin >> i;
				if((p[i].getPhoneMobile()!=0 || p[i].getPhoneHome()!=0) && i<=size){
					cout << "Enter new mobile phone:" << endl;
					cin >> val;
					p[i].setPhoneMobile(val);
				}
				else
					cout << "Person not found!" << endl;
				break;
			case 0:
				exit(0);
				break;
		}
		system("pause");
		system("CLS");
	}
}

int main() {
	cout << endl;
	srand(time(0));
	menu();
	return 0;
}