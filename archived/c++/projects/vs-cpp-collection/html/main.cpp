#include <iostream>
#include <fstream>
using namespace std;

class html {
	char* str;
public:
	html(){
		str=new char[1024];
	}
	~html() {
		if (str != NULL)
			delete[]str;
	};
	void set(char*);
	void write();
};

void html::set(char* val1) {
	int buf1, buf2, buf3;
	bool error;
setFirst:
	buf1 = 0;
	buf2 = 0;
	buf3 = 0;
	error = false;
	for(int i = 0; i < strlen(val1); i++){
		if(strlen(val1) < 2){
			error = true;
			break;
		}
		if(val1[i]=='<'){
			buf1++;
			buf2++;
			if(i+1<strlen(val1) && val1[i+1]=='/')
				buf2-=2;
		}
		if(val1[i]=='>')
			buf1--;

	}
	if(buf1 != 0 || buf2 != 0 || buf3 != 0 || error == true) {
		cout << "You have error in your html syntax! Please, input code again:" << endl;
		cin.getline(val1,1024);
		goto setFirst;
	}
	strcpy(str,val1);
}
void html::write(){
	fstream f("index.html",ios::out);
	f.write(str,strlen(str));
	f.close();
}
void menu() {
	html list;
	char* buf = new char[1024];
	cin.getline(buf,1024);
	list.set(buf);
	list.write();
	delete[]buf;
}

void main() {
	menu();
}