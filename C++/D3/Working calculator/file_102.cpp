#include <iostream>
#include <string>
#include <sstream>

using namespace std;

struct signs{
	signs *next;
	char sign;
	int prioritet;
	int position;
	signs(char iSign=0, int iPrioritet=0, int iPosition=0, signs *iNext=NULL): sign(iSign),prioritet(iPrioritet),position(iPosition),next(iNext){}
	void remove();
};
void signs::remove(){
	if(next!=NULL){
		next->remove();
		delete next;
	}
	next=NULL;
	sign=0;
	prioritet=0;
	position=0;
}

class calculator{
	string str;
public:
	calculator(): str(""){}
	calculator(const calculator &buf){
		str = buf.str;
	}
	~calculator(){
	};
	bool check(string);
	void solve(string);
};

bool isDigit(char str){
	return str=='0' ||
		str=='1' ||
		str=='2' ||
		str=='3' ||
		str=='4' ||
		str=='5' ||
		str=='6' ||
		str=='7' ||
		str=='8' ||
		str=='9' ||
		str=='.';
}
bool isSign(char str){
	return str=='+' ||
		str=='-' ||
		str=='*' ||
		str=='/';
}
int getPrevDigit(string str,int pos){
	for(int i = pos-1; i >= 0; i--)
		if(!isDigit(str[i]))
			return i+1;
	return 0;
}
int getNextDigit(string str,int pos){
	for(int i = pos+1; i < str.size(); i++)
		if(!isDigit(str[i]))
			return i-1;
	return str.size();
}
template <typename T> string tostr(const T& t) { 
	ostringstream os; 
	os<<t;
	return os.str(); 
}
void replace(string &str, int &i, bool &was, char first, char second, char newFirst=0, char newSecond=0, char newThird=0){
	if(str[i-1]==first && str[i]==second){
		int buf=0;
		if(newSecond!=0)
			str[i]=newSecond;
		else {
			str.erase(i,1);
			buf++;
		}
		if(newFirst!=0)
			str[i-1]=newFirst;
		else {
			str.erase(i-1,1);
			buf++;
		}
		if(newThird!=0){
			str.insert(i+1,string(1,newThird),0,1);
			buf--;
		}
		i-=buf;
		was=1;
	}
}
void fix(string &str){
	bool was=1,was2=0;
	int buf3=0;
	while(was){
		was=0;
		if(str[0]=='+' || str[0]=='*' || str[0]=='/')
			str.erase(0,1);
		if(str.back()=='+' || str.back()=='-' || str.back()=='*' || str.back()=='/')
			str.erase(str.size()-1,1);
		for(int i=1;i<str.size();i++){
			replace(str,i,was,'+','+','+');
			replace(str,i,was,'+','-','-');
			replace(str,i,was,'+','*','*');
			replace(str,i,was,'+','/','/');
			replace(str,i,was,'-','+','-');
			replace(str,i,was,'-','-','+');
			replace(str,i,was,'-','*','*');
			replace(str,i,was,'-','/','/');
			replace(str,i,was,'*','+','*');
			replace(str,i,was,'*','*','*');
			replace(str,i,was,'*','/','*');
			replace(str,i,was,'/','+','/');
			replace(str,i,was,'/','*','/');
			replace(str,i,was,'/','/','/');
			replace(str,i,was,'.','.','.');
			replace(str,i,was,'+',')',')');
			replace(str,i,was,'-',')',')');
			replace(str,i,was,'*',')',')');
			replace(str,i,was,'/',')',')');
			replace(str,i,was,'(','+','(');
			replace(str,i,was,'(','*','(');
			replace(str,i,was,'(','/','(');
			replace(str,i,was,'/','0','*','0');
			replace(str,i,was,'(',')');
			replace(str,i,was,')','(',')','*','(');
			if(isSign(str[i-1]) && str[i]=='.'){
				str.insert(i,"0",0,1);
				was=1;
			}
			if(str[i-1]==')' && isDigit(str[i])){
				str.insert(i,"*",0,1);
				was=1;
			}
			if(isDigit(str[i-1]) && str[i]=='('){
				str.insert(i,"*",0,1);
				was=1;
			}
			if(i+1<str.size() && str[i-1]=='(' && isSign(str[i]) && str[i]!='-'){
				str.erase(i,1);
				was=1;
			}
			if(str[i-1]=='(' && isDigit(str[i])){
				was2=0;
				for(int ii=i;ii<str.size();ii++){
					if(str[ii]==')'){
						buf3=ii;
						break;
					}
					if(str[ii]=='+' || str[ii]=='/' || str[ii]=='*' || str[ii]=='-'){
						was2=1;
						break;
					}
				}
				if(!was2){
					str.erase(buf3,1);
					str.erase(i-1,1);
					was=1;
				}
			}
			if(i+1<str.size() && str[i-1]=='(' && str[i]=='-' && isDigit(str[i+1])){
				was2=0;
				for(int ii=i+1;ii<str.size();ii++){
					if(str[ii]==')'){
						buf3=ii;
						break;
					}
					if(str[ii]=='+' || str[ii]=='/' || str[ii]=='*' || str[ii]=='-'){
						was2=1;
						break;
					}
				}
				if(!was2){
					str.erase(buf3,1);
					str.erase(i-1,1);
					was=1;
				}
			}
		}
	}
}
int findFirstSign(string str){
	bool was=0;
	int c=0,buf=0;
	signs *f = new signs();
	for(int i=1;i<str.size()-1;i++){
		if(str[i]=='(')
			c++;
		if(str[i]==')')
			c--;
		if(isDigit(str[i-1]) && isSign(str[i])){
			if(str[i]=='+' || str[i]=='-')
				buf=0;
			else
				buf=1;
			if(was){
				signs *buf2 = f;
				signs *buf3 = new signs(str[i],c*2+buf,i);
				while(buf2->next!=NULL)
					buf2=buf2->next;
				buf2->next=buf3;
				buf2=NULL;
			}
			else {
				f->sign=str[i];
				f->prioritet=c*2+buf;
				f->position=i;
				was=1;
			}
		}
	}
	if(was==0)
		return -1;
	signs *buf3 = f;
	for(signs *buf2 = f;buf2;buf2=buf2->next)
		if(buf2->prioritet>buf3->prioritet)
			buf3=buf2;
	buf=buf3->position;
	f->remove();
	delete f;
	return buf;
}

bool calculator::check(string buf){
	if(buf.size()<=0)
		return 0;
	int c=0;
	for(string::iterator it=buf.begin();it!=buf.end();it++){
		if(*it=='(')
			c++;
		if(*it==')')
			c--;
		if(!isDigit(*it) && !isSign(*it) && *it!='(' && *it!=')')
			return 0;
	}
	if(c!=0)
		return 0;
}
void calculator::solve(string str){
	if(check(str)){
		fix(str);
		bool c=1;
		size_t buf;
		int buf2,buf4;
		string buf3;
		float buf5;
		while(c){
			c=0;
			buf=findFirstSign(str);
			if(buf==-1)
				break;
			switch(str[buf]){
				case '+':
					buf2=getPrevDigit(str,buf);
					buf4=getNextDigit(str,buf);
					buf5=stof(str.substr(buf2,buf-buf2))+stof(str.substr(buf+1,buf4-buf));
					buf3=tostr(buf5);
					str.erase(buf2,buf4-buf2+1);
					if(str.size()>0 && isDigit(str[buf2]))
						str.insert(buf2,"+",0,1);
					str.insert(buf2,buf3,0,buf3.size());
					c=1;
					break;
				case '-':
					buf2=getPrevDigit(str,buf);
					buf4=getNextDigit(str,buf);
					buf5=stof(str.substr(buf2,buf-buf2))-stof(str.substr(buf+1,buf4-buf));
					buf3=tostr(buf5);
					str.erase(buf2,buf4-buf2+1);
					if(str.size()>0 && isDigit(str[buf2]))
						str.insert(buf2,"+",0,1);
					str.insert(buf2,buf3,0,buf3.size());
					c=1;
					break;
				case '*':
					buf2=getPrevDigit(str,buf);
					buf4=getNextDigit(str,buf);
					buf5=stof(str.substr(buf2,buf-buf2))*stof(str.substr(buf+1,buf4-buf));
					buf3=tostr(buf5);
					str.erase(buf2,buf4-buf2+1);
					if(str.size()>0 && isDigit(str[buf2]))
						str.insert(buf2,"+",0,1);
					str.insert(buf2,buf3,0,buf3.size());
					c=1;
					break;
				case '/':
					buf2=getPrevDigit(str,buf);
					buf4=getNextDigit(str,buf);
					buf5=stof(str.substr(buf2,buf-buf2))/stof(str.substr(buf+1,buf4-buf));
					buf3=tostr(buf5);
					str.erase(buf2,buf4-buf2+1);
					if(str.size()>0 && isDigit(str[buf2]))
						str.insert(buf2,"+",0,1);
					str.insert(buf2,buf3,0,buf3.size());
					c=1;
					break;
			}
			fix(str);
		}
		cout << str;
	}
	else
		cout << "Wrong format*&^$#" << endl;
}

void menu(){
	calculator c;
	string buf;
	while (1) {
		system("CLS");
		cin >> buf;
		c.solve(buf);
		cout << endl;
		system("pause");
		system("CLS");
	}
}

void main() {
	menu();
}