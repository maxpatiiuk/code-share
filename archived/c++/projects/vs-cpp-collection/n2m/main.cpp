#include <iostream>
using namespace std;
#define _SIZE_ 100
bool ch = true;
char str[_SIZE_] = { 0 };
bool is_number(char symbol){
	if((int)symbol>=48 && (int)symbol<=57)
		return 1;
	else
		return 0;
}
bool pregMatch(char symbol){
	if(((int)symbol>=40 && (int)symbol<=43) || (int)symbol==45 || ((int)symbol>=47 && (int)symbol<=57))
		return 1;
	else
		return 0;
}
void removeFromArray(int pos, int count){
	for(;str[pos]!=(char)0;pos++){
		if(str[pos+count]!=(char)0)
			str[pos]=str[pos+count];
		else
			str[pos]=char(0);
	}
}
void insertIntoArray(int pos, int val) {
	for (char b_str; pos < strlen(str)+1; pos++, val = b_str) {
		b_str = str[pos];
		str[pos] = (char)val;
	}
}
bool ifChars(int i, int val1, int val2) {
	if ((int)str[i - 1] == 40 + val1 && (int)str[i] == 40 + val2) {
		ch = true;
		return 1;
	}
	else
		return 0;
}
void fix() {
	int pos = -1;
	ch = true;
	while (ch) {
		ch = false;
		if (is_number(str[1]) && ((int)str[0] == 42 || (int)str[0] == 43 || (int)str[0] == 47))
			removeFromArray(0,1);
		for (int i = 1; i < strlen(str); i++) {
			if (is_number(str[i]) && (char)str[i] != 48)
				continue;
			if (ifChars(i, 3, 5))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 3, 7))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 3, 2))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 5, 3))
				removeFromArray(i, 1);
			if (ifChars(i, 2, 3))
				removeFromArray(i, 1);
			if (ifChars(i, 7, 3))
				removeFromArray(i, 1);
			if (ifChars(i, 1, 0))
				insertIntoArray(i, '*');
			if (ifChars(i, 3, 3))
				removeFromArray(i, 1);
			if (ifChars(i, 7, 7))
				removeFromArray(i, 1);
			if (ifChars(i, 7, 2))
				removeFromArray(i, 1);
			if (ifChars(i, 2, 2))
				removeFromArray(i, 1);
			if (ifChars(i, 2, 7))
				removeFromArray(i, 1);
			if (ifChars(i, 5, 7))
				removeFromArray(i, 1);
			if (ifChars(i, 5, 2))
				removeFromArray(i-1, 1);
			if (ifChars(i, 2, 1))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 3, 1))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 5, 1))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 7, 1))
				removeFromArray(i - 1, 1);
			if (ifChars(i, 0, 1))
				removeFromArray(i-1, 2);
			if (ifChars(i, 5, 5)) {
				removeFromArray(i - 1, 2);
				insertIntoArray(i - 1, '+');
			}
			if (ifChars(i, 7, 8)) {
				removeFromArray(i - 1, 1);
				insertIntoArray(i-1, '*');
			}
		}
	}
	ch = true;
	while (ch) {
		ch = false;
		for (int i = 0; i < strlen(str); i++) {
			if ((int)str[i] == 40)
				pos = i;
			if ((int)str[i] == 41) {
				bool wasN = false, wasS = false;
				for (int ii = pos+1; ii < i; ii++) {
					if (is_number(str[ii]))
						wasN = 1;
					if ((int)str[ii] == 42 || (int)str[ii] == 43 || (int)str[ii] == 45 || (int)str[ii] == 47)
						wasS = 1;
					if (wasS && wasN)
						break;
					if (ii + 1 == i) {
						ch = true;
						removeFromArray(pos, 1);
						removeFromArray(i-1, 1);
						i -= 2;
						break;
					}
				}
			}
		}
	}
}
void calc(){
	bool wasChanges=1;
	for(int i=1;str[i]!=(char)0;i++)
		if(!pregMatch(str[i]))
			removeFromArray(i,1);
	while(wasChanges){
		wasChanges=0;
		for(int i=1;str[i]!=(char)0;i++){
			if (is_number(str[i - 1]) && (int)str[i] == 43 && is_number(str[i + 1])) {
				wasChanges = 1;
				int f = 1, l = 1;
				char n1[20] = { 0 }, n2[20] = { 0 }, buf[20] = { 0 };
				while (is_number(str[i - f]))
					f++;
				f--;
				for (int ii = 0; ii < f; ii++)
					n1[ii] = str[i - f + ii];
				while (is_number(str[i + l])) {
					n2[l - 1] = str[i + l];
					l++;
				}
				if ((int)str[i - f - 1] == 45) {
					str[i - f - 1] = (char)43;
					if (atoi(n1) < atoi(n2))
						f = atoi(n2) - atoi(n1);
					else
						f = atoi(n1) - atoi(n2);
				}
				else
					f = atoi(n1) + atoi(n2);
				itoa(f,buf,10);
				for (int ii = 0; ii < strlen(buf); ii++)
					str[i-strlen(n1)+ii]=buf[ii];
				if(strlen(buf)>strlen(n1))
					l=0;
				else if(strlen(buf)==strlen(n1))
					l=1;
				else
					l = 1 + strlen(n2) - strlen(buf);
				removeFromArray(i-strlen(n1)+strlen(buf),strlen(n2)+l);
				i+=strlen(n2);
			}
			if(is_number(str[i-1]) && (int)str[i]==45 && is_number(str[i+1])){
				wasChanges=1;
				ch=false;
				int f=1,l=1;
				char n1[20]={0},n2[20]={0},buf[20]={0};
				while(is_number(str[i-f]))
					f++;
				f--;
				for(int ii=0;ii<f;ii++)
					n1[ii]=str[i-f+ii];
				while(is_number(str[i+l])){
					n2[l-1]=str[i+l];
					l++;
				}
				if ((int)str[i - f - 1] == 45) {
					if (i - f - 1 == 0)
						ch = true;
					else
						str[i - f - 1] = (char)43;
					if(atoi(n1) == atoi(n2))
						f = 0;
					else
						f = -(atoi(n1) + atoi(n2));
				}
				else
					f = atoi(n1) - atoi(n2);
				itoa(f,buf,10);
				for(int ii=0;ii<strlen(buf);ii++)
					str[i-strlen(n1)+ii]=buf[ii];
				l=strlen(n1)-strlen(buf);
				removeFromArray(i-l,strlen(n2)+1+l);
				i-=strlen(n1)-strlen(buf)+1;
			}
		}
	}
}
bool is_valid(char *str){
	int check=0;
	bool has_symb=false;
	if (strlen(str) < 1)
		return false;
	for(int i=0;i<strlen(str);i++){
		if(has_symb == false && pregMatch(str[i]))
			has_symb=true;
		if((int)str[i]==40)
			check++;
		if((int)str[i]==41)
			check--;
	}
	if (check != NULL || has_symb == false)
		return false;
	else
		return true;
}
void main(){
	cinStr:
	cin >> str;
	if(!is_valid(str)){
		cout << "Enter valid string ( 1 < lenght < 100, symbols = ()-+*/0123456789 and all '(' should have closing ')')";
		goto cinStr;
	}
	fix();
	calc();
	fix();
	cout << str << endl;
	system("pause");
}