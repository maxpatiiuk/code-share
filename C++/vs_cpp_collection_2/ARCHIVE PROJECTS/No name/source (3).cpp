#include <iostream>
#include <time.h>
#include <stdlib.h>
using namespace std;
int Buv(int u[], int k, int gr)
{
		int b=0;
		for (int i = 0;i<k;i++)
		{
			if (u[i] == gr)
				b=1;
		}
		return b;
}
void main()
{
	int t,a,c,d,v,prus,nomer;
	d=v=0;
	cout << "K-t uchasnukiv: ";
	cin >> a;
	cout << "K-t pruziv: ";
	cin >> c;
	srand(time(0));
	int u[20] = { 0 };
s:nomer = rand() % a;
		for(t=0; t=c; t++)
		{
		if(u[nomer]!=0)
			goto s;
		prize: prus = 1 + rand() % c;
		if(Buv(u,20,prus) == 0)
		{
			u[nomer] = prus;
			cout << "Uchasnyk " << nomer + 1 << " vugrav " << u[nomer] << " pruz" << endl;
			d++;
		}
		else if(d>=c && v<a-c)
		{
			v++;
			cout << "Inshi ne vugralu pruz" << endl;
			goto l;
		}
		else
		{
			goto prize;
		}
		}l:
system("pause");
}