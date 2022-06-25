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
	cout << "Введiть рядок:" << endl;
	cin >> a;
	cout << "Який символ шукати?" << endl;
	cin >> seach_query;
	for (; i < strlen(a); i++)
		if (a[i] == seach_query)
			ii++;
	cout << "Символ " << seach_query << " повторюється " << ii << " разiв" << endl;
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
	cout << endl << "Сума оцiнок: " << ii << endl;
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
	cout << "В " << count << " учнiв рiст вище середнього" << endl;
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
cout << "Елементи повторюються" << endl;
system("pause");
exit(0);
}
}
if(i+1==size)
cout << "Елементи не повторюються" << endl;
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
cout << "Число э в масивi" << endl << endl;
break;
}
if(i+1==size)
cout << "Число не э в масивi" << endl << endl;
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
cout << endl << "Максимальне: " << a[iii] << endl << "Мiнiмальне: " << a[iiii] << endl << "Середнэ арифметичне: " << (ii-a[iii]-a[iiii])/(size-2) << endl;
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
cout << endl << "Ненульових елементiв: " << ii << endl << "Середнэ арифметичне: " << iii/ii << endl;
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
cout << endl << "Мiнiмальний елемент: " << a[ii] << endl;
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
cout << endl << ii << " не нульових елементiв" << endl;
}
*/