#include <iostream>
#include <time.h>
#include <cstdio>
using namespace std;
char a[10],b[20];
unsigned short int i,l;
void main()
{
	cout << "Vedit text" << endl;
	gets(a);
	for(i=l=0;i<8;i++,l++)
	{
		b[l]=a[i];
		b[l+1]=' ';
		l++;
	}
	puts(b);
}