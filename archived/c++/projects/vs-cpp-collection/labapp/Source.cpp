#include <iostream>
#include <time.h>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	int i = 0, size = 10, ii, fir = 0, sec = 0;
	bool wasch = 1;
	int * a = new int[size];
	for (; i<size; i++) {
		cout << endl << "i=" << i << " ; a[i] = ";
		cin >> a[i];
	}
	while (wasch == 1) {
		wasch = 0;
		for (i = 0; i<size; i++) {
			if (a[i]>a[i + 1] && a[i + 1]>-1 && a[i]>-1) {
				swap(a[i], a[i + 1]);
				wasch = 1;
			}
		}
	}
	for (i = 0; i<size; i++)
		cout << endl << "i=" << i << " ; a[i] = " << a[i];
	cout << endl << "Введiть i: " << endl;
	cin >> ii;
	for (i = 0; i < size; i++) {
		if (a[i] < ii)
			fir += a[i];
		else
			sec += a[i];
	}
	cout << "Сума елементiв менших за i = " << fir << endl << "Сума елементiв бiльших за i: " << sec << endl;
}

/*#include <iostream>
#include <time.h>
using namespace std;
void main() {
	setlocale(LC_CTYPE, "Ukrainian");
	int i = 0, size = 10, ii;
	bool wasch = 1;
	int * a = new int[size];
	for (; i<size; i++) {
		cout << endl << "i=" << i << " ; a[i] = ";
		cin >> a[i];
	}
	while (wasch == 1) {
		wasch = 0;
		for (i = 0; i<size; i++) {
			if(a[i]>a[i+1] && a[i+1]>-1 && a[i]>-1){
				swap(a[i], a[i+1]);
				wasch = 1;
			}
		}
	}
	for (i=0; i<size; i++)
		cout << endl << "i=" << i << " ; a[i] = " << a[i];
	cout << endl << "Введiть i: " << endl;
	cin >> ii;
	cout << "Елементів до i = " << ii << endl << "Елементів після i: " << size - ii << endl;
}*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main() {
	int i = 0, size = 15;
	bool wasch = 1;
	int * a = new int[size];
	for (; i<size; i++) {
		cin >> a[i];
		a[i] = abs(a[i]);
	}
	while (wasch == 1) {
		wasch = 0;
		for (i = 0; i<size; i++) {
			if (i=size)
				break;
			if(a[i]>a[i+1] && a[i+1]>-1 && a[i]>-1){
				swap(a[i], a[i+1]);
				wasch = 1;
			}
		}
	}
	for (i=size; i>0; i--)
		cout << a[i-1] << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main() {
	int i = 0, size = 20;
	bool wasch = 1;
	int * a = new int[size];
	for (; i<size; i++)
		cin >> a[i];
	while (wasch == 1) {
		wasch = 0;
		for (i = 0; i<size; i=i+2) {
			if (i+1 >= size)
				break;
			if(a[i]<a[i+2]){
				swap(a[i], a[i+2]);
				wasch = 1;
			}
		}
	}
	wasch = 1;
	while (wasch == 1) {
		wasch = 0;
		for (i = 1; i<size; i = i + 2) {
			if (i+1 >= size)
				break;
			if (a[i] > a[i + 2]) {
				swap(a[i], a[i + 2]);
				wasch = 1;
			}
		}
	}
	for (i=0; i<size; i++)
		cout << a[i] << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main() {
	int i = 0, size = 20, ii;
	bool wasch = 1;
	int * a = new int[size];
	for (; i<size; i++) {
		cin >> a[i];
	}
	while (wasch == 1) {
		wasch = 0;
		for (i = 0; i<size; i++) {
			if (i % 2 == 0 && a[i]>0) {
				ii = i + 2;
				while (1) {
					if (a[ii]>0)
						break;
					ii = ii + 2;
					if (ii > size+1)
						goto a;
				}
				swap(a[i], a[ii]);
				wasch = 1;
			}
		}
	}
	a:
	for (i=0; i<size; i++)
		cout << a[i] << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main(){
	int i=0,size=16,ii=size,min=0;
	int * a=new int[size];
	for(;i<size;i++)
		cin >> a[i];
	for(i=0;i<size/2;i++,ii--)
		cout << i << ". a[" << i << "] * a[" << ii-1 << "] = " << a[i] << " * " << a[ii-1] << " = " << a[i]*a[ii-1] << endl;
	for(i=0;i<size/2;i++)
		if(a[i]*a[size-i]<a[min]*a[size-min])
			min=i;
	cout << endl << a[min]-1 << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main(){
	int i=0,size;
	cin >> size;
	int * a=new int[size];
	for(;i<size;i++)
		cin >> a[i];
	for(i=0;i<size;i++)
		if(a[i]%2!=0 && a[i]<0)
	cout << i << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main(){
	srand(time(0));
	int i=0,size=20,average=0,minimal=0,maximal=0;
	int * a=new int[size];
	for(;i<size;i++){
		a[i]=rand()% 5+20;
		average+=a[i];
		cout << "a[" << i << "] >> " << a[i] << endl;
	}
	for(i=0;i<size;i++){
		if(a[i]<a[minimal])
		minimal=i;
		if(a[i]>a[maximal])
		maximal=i;
	}
	cout << "Max: " << a[maximal] << "\nMin: " << a[minimal] << "\nAverage: " << average/size << endl;
}
*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main(){
	srand(time(0));
	setlocale(LC_ALL,"");
	int i=0,size=20,lim,sump=0,summ=0;
	bool was=0;
	int * a=new int[size];
	cin >> lim;
	for(;i<size;i++){
		if(lim>0)
			a[i]=rand()% lim+2;
		else
			a[i]=(rand()% lim)*(-1)+2;
		if(a[i]<0)
			summ+=pow(a[i],2);
		else
			sump+=pow(a[i],2);
		cout << "a[" << i << "] >> " << a[i] << endl;
	}
	cout << "Сума квадратiв числе бiльше 0: " << sump << endl << "Сума квадратiв числе менше 0: " << summ << endl;
}
*/

/*#include <iostream>
#include <time.h>
using namespace std;
void main(){
	srand(time(0));
	int size=20,i=0;
	bool was=0;
	int * a=new int[size];
	for(;i<size;i++){
		a[i]=rand()%20-5;
		if(a[i]<-2)
		was=1;
	}
	for(i=0;i<size;i++){
		if(was==1 && a[i]<0)
		a[i]=pow(a[i],2);
		cout << "a[" << i << "] >> " << a[i] << endl;
	}
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
void main(){
	srand(time(0));
	int size=20,i=0;
	int * a=new int[size];
	for(;i<size;i++){
		a[i]=rand()%2000-1000;
		cout << "a[" << i << "] >> " << a[i] << endl;
	}
	for(i=0;i<size;i++)
		if(i!=0 && a[i-1]>0 && a[i]>0)
	cout << a[i-1] << " > " << a[i] << endl;
}*/

/*
#include <iostream>
#include <time.h>
using namespace std;
void main(){
	srand(time(0));
	int size=20,i=0,s=0;
	int * a=new int[size];
	for(;i<size;i++){
		a[i]=rand()%2000;
		s+=a[i];
	}
	s/=size;
	cout << "Середнэ: " << s;
	for(i=0;i<size;i++)
		cout << endl << "a[" << i << "] >> " << a[i] << " >> " << a[i]-s;
}
*/