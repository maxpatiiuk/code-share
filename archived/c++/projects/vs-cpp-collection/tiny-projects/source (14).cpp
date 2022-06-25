#include <iostream>
#include <conio.h>
#include <windows.h>
using namespace std;
int x[200],z,t,i,q;
void n();
void m();
void a()
{
	system("CLS");
	cout << "Vvuvestu chuslo - 1" << endl << "Redaguvatu vse chuslo - 2" << endl << "Redaguvatu odny chufry - 3" << endl << "Zberegtu dani - 4" << endl << "Zakrutu programy - 0";
	z = _getch();	
	n();
}
void b()
{
	cout << endl << "Vvedit chuslo (do 200 sumvoliv)" << endl;
	for(;z!=13;)
	{
	z = _getch();	
	m();
	}
	cout << endl << "Chuslo yspishno zapusano" << endl;
	a();
}
void m()
{
	t++;
	switch(z)
	{
	case 49:
		cout << 1;
		x[t-1]=1;
		break;
	case 50:
		cout << 2;
		x[t-1]=2;
		break;
	case 51:
		cout << 3;
		x[t-1]=3;
		break;
	case 52:
		cout << 4;
		x[t-1]=4;
		break;
	case 53:
		cout << 5;
		x[t-1]=5;
		break;
	case 54:
		cout << 6;
		x[t-1]=6;
		break;
	case 55:
		cout << 7;
		x[t-1]=7;
		break;
	case 56:
		cout << 8;
		x[t-1]=8;
		break;
	case 57:
		cout << 9;
		x[t-1]=9;
		break;
	case 48:
		cout << 0;
		x[t-1]=0;
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
		cin >> i;
		cout << "Chuslo """ << x[i-1] << """, byde zaminene na chuslo: ";
		cin >> q;
		x[i]=q;
		cout << "Zapusane chuslo yspishno zmineno. Zapusane chuslo:" << endl;
		for(i=0;i+1<t;i++)
		{
		cout << x[i];
		}
		cout << endl;
		Sleep(1000);
		a();
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