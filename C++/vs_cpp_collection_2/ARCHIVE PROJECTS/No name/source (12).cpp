#include <iostream>
#include <time.h>
using namespace std;
unsigned __int16 a,b,c[10],l,d;
void main(){
	srand(time(0));
	for (a=0;a<10;a++){
		c[a]=rand()%10;
		cout << c[a] << " ";}
	cout << endl << "Vvedik diapazon" << endl;
	cin >> a>>b;
	l=0;
	b++;
	if (a>b)
		swap(a,b);
		for(;d<b-a;d++)
		l=l+c[d];
	cout << l;
}