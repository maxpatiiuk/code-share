#include <iostream>
#include <time.h>
using namespace std;
unsigned short m[20],i,l,s,p,r;
void main()
{
	system("CLS");
	srand(time(0));
	p=200;
	for(i=0;i<20;i++)
	{
		m[i]=rand() % 20;
		cout << m[i] << '\t';
		if(i!=0 && m[i]>s)
		{
		l=i;
		s=m[i];
		}
		if(i!=0 && m[i]<p)
		{
		r=i;
		p=m[i];
		}
	}
	cout << "Chuslo z nomerom " << l << " naibilshe i = " << s << endl << "Chuslo z nomerom " << r << " naimensge i = " << p << endl;
	system("pause");
}