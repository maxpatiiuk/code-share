/*#include <iostream>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	const int size = 16;
	int i = 0, ii = size, count = 0;
	float a[size],seach_query;
	for (; i < size; i++) {
		cout << "a[" << i << "] >> ";
		cin >> a[i];
	}
	for (i=0; i < size / 2; i++,ii--)
		cout << "a[" << i << "] * a[" << ii << "] = " << a[i] * a[ii] << endl;
}*/

/*
#include <iostream>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	int i = 0, ii = 0, count = 0;
	const int size = 200;
	char a[size],seach_query;
	cout << "����i�� �����:" << endl;
	cin >> a;
	cout << "���� ������ ������?" << endl;
	cin >> seach_query;
	for (; i < strlen(a); i++)
		if (a[i] == seach_query)
			ii++;
	cout << "������ " << seach_query << " ������������ " << ii << " ���i�" << endl;
}
*/

/*
#include <iostream>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	int i = 2, ii = 0, count = 0;
	const int size = 20;
	float a[size]	;
	for (; i < size+3; i++) {
		cout << endl << i << " >> ";
		cin >> a[i];
		ii += a[i];
	}
	for (i = 2; i < size+3; i++)
		cout << endl << i << " >> " << a[i]/ii*100 << "%";
	cout << endl << "���� ��i���: " << ii << endl;
}
*/

/*#include <iostream>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	int i = 0, ii = 0, count = 0;
	const int size = 10;
	float a[size * 20] = { 1 };
	while (a[i] != 0) {
		i++;
		cout << endl << "a[" << i << "] >> ";
		cin >> a[i];
		ii += a[i];
	}
	ii /= (i - 1);
	for (i = 0; i<size; i++)
		if (a[i]>ii)
			count++;
	cout << "� " << count << " ���i� �i�� ���� ����������" << endl;
}*/


/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
int i=0,ii=0;
const int size=10;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i+1 << "] >> ";
cin >> a[i];
}
for(i=0;i<size;i++){
for(;ii<size;ii++){
if(a[i]==a[ii] && i!=ii){
cout << "�������� ������������" << endl;
system("pause");
exit(0);
}
}
if(i+1==size)
cout << "�������� �� ������������" << endl;
}
}
*/

/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
int i=0,ii=0,count=0;
const int size=10;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i+1 << "] >> ";
cin >> a[i];
}
cin >> ii;
while(1){
for(i=0;i<size;i++)
if(a[i]==ii)
count++;
cout << endl << count << endl;
}
}
*/

/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
int i=0,ii=0;
const int size=10;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i+1 << "] >> ";
cin >> a[i];
}
while(1){
cin >> ii;
for(i=0;i<size;i++){
if(a[i]==ii){
cout << "����� � � �����i" << endl << endl;
break;
}
if(i+1==size)
cout << "����� �� � � �����i" << endl << endl;
}
}
}
*/

/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
int i=0,iii=0,iiii=0;
float ii=0;
const int size=10;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i+1 << "] >> ";
cin >> a[i];
ii+=a[i];
}
for(i=0;i<size;i++){
if(a[i]>a[iii])
iii=i;
if(a[i]<a[iiii])
iiii=i;
}
cout << endl << "�����������: " << a[iii] << endl << "�i�i������: " << a[iiii] << endl << "������� �����������: " << (ii-a[iii]-a[iiii])/(size-2) << endl;
}
*/

/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
unsigned short int i=0;
float ii=0,iii=0;
const int size=10;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i+1 << "] >> ";
cin >> a[i];
if(a[i]!=0){
ii++;
iii+=a[i];
}
}
cout << endl << "���������� �������i�: " << ii << endl << "������� �����������: " << iii/ii << endl;
}
*/

/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
unsigned short int i=0,ii=0;
const int size=6;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i << "] >> ";
cin >> a[i];
}
cout << endl << endl;
for(i=0;i<size;i++){
if(a[i]<a[ii])
ii=i;
}
cout << endl << "�i�i������� �������: " << a[ii] << endl;
}*/


/*
#include <iostream>
using namespace std;
void main(){
setlocale(LC_CTYPE,"Ukrainian");
unsigned short int i=0,ii=0;
const int size=6;
float a[size];
for(;i<size;i++){
cout << endl << "a["  << i << "] >> ";
cin >> a[i];
}
cout << endl << endl;
for(i=0;i<size;i++){
cout << endl << "a["  << i << "] >> " << a[i];
if(a[i]!=0)
ii++;
}
cout << endl << ii << " �� �������� �������i�" << endl;
}
*/