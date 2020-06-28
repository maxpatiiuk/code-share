#include <iostream>
#include <time.h>
using namespace std;
unsigned short m[10],i,l;
void main()
{
	srand(time(0));
	for(i=0;i<10;i++)
	{
		m[i]=rand() % 10;
		cout << m[i] << '\t';
	}
	cout << endl;
	for(i=0,l=9;i<5;i++, l--)
		swap(m[i],m[l]);
	for(i=0;i<10;i++)
		cout << m[i] << '\t';
}