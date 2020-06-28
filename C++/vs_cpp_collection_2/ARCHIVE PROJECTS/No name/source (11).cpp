#include <iostream>
#include <conio.h>
#include <fstream>
using namespace std;
int x[200],z,t,i,q,w;
unsigned long long p;
void n();
void m();
void a()
{
	system("CLS");
	cout << "Vvuvestu chuslo - 1" << endl << "Redaguvatu vse chuslo - 2" << endl << "Redaguvatu odny chufry - 3" << endl << "Zberegtu dani - 4" << endl << "Zberegtu dani yak - 5" << endl << "Zakrutu programy - 0";
	z = _getch();	
	n();
}
void b()
{
	system("CLS");
	cout << "Vvedit chuslo (do 200 sumvoliv)" << endl;
	for(;z!=13;)
	{
	z = _getch();	
	m();
	}
	cout << endl << "Chuslo yspishno zapusano" << endl;
		fstream f("value.txt", ios::out | ios::in);
		for(i=0;i<t;i++)
			f<<x[i];
		f.close();
system("pause");
	a();
}
void m()
{
	switch(z)
	{
	case 49:
		cout << 1;
		x[t]=1;
		t++;
		break;
	case 50:
		cout << 2;
		x[t]=2;
		t++;
		break;
	case 51:
		cout << 3;
		x[t]=3;
		t++;
		break;
	case 52:
		cout << 4;
		x[t]=4;
		t++;
		break;
	case 53:
		cout << 5;
		x[t]=5;
		t++;
		break;
	case 54:
		cout << 6;
		x[t]=6;
		t++;
		break;
	case 55:
		cout << 7;
		x[t]=7;
		t++;
		break;
	case 56:
		cout << 8;
		x[t]=8;
		t++;
		break;
	case 57:
		cout << 9;
		x[t]=9;
		t++;
		break;
	case 48:
		if(t!=0)
		{
		cout << 0;
		x[t]=0;
		}
		break;
	}
}
void n()
{
	switch(z)
	{
	case 49:
		system("CLS");
		for(i=0;i+1<t;i++)
		{
		cout << x[i];
		}
		cout << endl;
		z=0;
		for(;;)
		{
		z = _getch();
		if (z==13)
		a();
		}
		break;
	case 50:
		t=0;
		b();
		break;
	case 51:
		system("CLS");
		cout << "Vvedit poradkovui nomer chusla yake redaguvatu. Zapusane chuslo:" << endl;
		for(i=0;i+1<t;i++)
		{
		cout << x[i];
		}
		cout << endl;
		/*
		q=0;
		for(;q<int(t/12)+1;q++)
		{
			for(i=0;i+1<12*q-(t-(int(t-12)*q));i++)
			cout << x[i] << '\t';
			cout << endl << endl;
			for(i=0;i+1<12*q-(t-(int(t-12)*q));i++)
			cout << i+1 << '\t';
			cout << endl << endl;
		}
		*/
		cin >> i;
		i--;
		cout << "Chuslo """ << x[i] << """, byde zaminene na chuslo: ";
		cin >> q;
		x[i]=q;
		cout << "Zapusane chuslo yspishno zmineno. Zapusane chuslo:" << endl;
		for(i=0;i+1<t;i++)
		{
		cout << x[i];
		}
		cout << endl;
		a();
		break;
	case 52:
		cout << 0;
		x[t-1]=0;
		break;
	case 53:
		cout << 0;
		x[t-1]=0;
		break;
	case 48:
		cout << 0;
		x[t-1]=0;
		break;
	}
}
void main()
{
	system("CLS");
	t=0;
	b();
	a();
	system("pause");
}