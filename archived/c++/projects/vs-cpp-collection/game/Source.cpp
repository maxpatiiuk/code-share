#include <iostream>
#include <stdlib.h>
#include <time.h>
using namespace std;
void main ()
{
	srand(time(0));
	int b,d,e,l,s;
	bool a;
	char c;
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "����i�!" << endl << "�i��� ��� � ��i, � ��i� �� ������ ��������� �����. ��� ������ ��� ����i�� - 0, � ��� ������ � ��� - 1" << endl;
    cin >> a;
	if (a==0)
	cout << "���������!!!" << endl;
	else
	goto a;
	b:
	cout << "�����i�� ����i���:" << endl << "����� - 1." << endl << "��������� - 2" << endl << "���� - 3" << endl << "��������� - 4" << endl << "����� � ��� - 6" << endl;
	cin >> c;
	if( c == '1' ) { 
	b=rand() % 10 +5;
	cout << "�c� �� ��� ����i���, �� ������� ����� ��� � �������. ��� �� �� ����� �� ������� �i��i ���������i, �� �������� ���� �����. ��� �i���� � ��� � 3 ������. ����� ����������� � �i������i �i� " << 0 << ", �� " << b+1 << "." << endl;
	}
	else if( c == '2' ) { 
	b=rand() % 20 +10;
	cout << "��� ����i��� ������� ����� ��� � �������. � ��� � 3 ������. ����� ����������� � �i������i �i� " << 0 << ", �� " << b+1 << "." << endl;	
	} 
	else if( c == '3' ) { 
	b=rand() % 50 +20;
	cout << "�� �� ��������� ������� ����? ���, ���� ����� ���������. � ��� � 3 ������. ����� ����������� � �i������i �i� " << 0 << ", �� " << b+1 << "." << endl;
	}
	else if( c == '4' ) { 
	b=rand() % 100 +50;
	cout << "���������� �i���� �������i ��������� ���,�� �i� ����������. ���� ��� ����� �� ������ ���� ������. � �����i� ���, ������ 1 ��� ����� � ���. ���, �� ��������� 2, �� �i���� ��� �������!" << endl;
	cin >> e;
	if (e == 1)
		{ 
		cout << "������! � ��� i �����. �i���� �� ������ �i ����" << endl;
		goto a;
		}
	else
				cout << "�� �� �����? ������. ����� ��������, ����, �� � ��� � �i���� 3 ������. ����� ����������� � �i������i �i� " << 0 << ", �� " << b+1 << "." << endl;	
	}
	else if( c == '5' ) { 
	cout << "������ i������ �� ���� :(..." << endl;
	goto b;
	}  
	else if( c == '6' ) { 
	goto a;
	}  
	else { 
	goto b;
	} 
	e=(rand() % b +a)+1;
	s=3;	
	d:
	cin >> d;
	if( d == e )
	{
		if(c == '1')
		{
			cout << "���, �� �������, � ������� ����� " << e << ". ��� �� ������� �����i ����� �����! � �� ���������� ����� �� �����������" << endl;
			goto b;
		}
		if(c == '2')
		{
			cout << "��������, �� ������� ����. � �� ���� ��� �� ����i?" << endl;
			goto b;
		}
		if(c == '3')
		{
			cout << "�i�� ���i, �� ������� ���� �� ����i. ��� �� ��������� ������� ���� �� ����������� �i��i ���������i. ������� �i� ���������� ����������." << endl;
			goto b;
		}
		if(c == '4')
		{
			cout << "�� �� �������? � ��� �� ���� ����i�. � ��� �� ����. �� ���������!" << endl;
			goto c;
		}
		if(c == '5')
		{
			cout << "�� �� ���� ���������?!?" << endl;
			goto b;
		}
		cout << "� ����� ������� ��� � ��i" << endl;
		goto b;

	}
	if(d!=e)
	{
		if(s == 3) 
		{
			if(c == '1')
			{
				cout << "���������, � ��� ���������� �i���� 2 ������!" << endl;
				cout << s;
				s--;
				cout << s;
				goto d;
			}
			if(c == '2')
			{
				cout << "�i. 2 ������..." << endl;
				s--;
				goto d;
			}
			if(c == '3')
			{
				cout << "�i�� ���i, �� ������� ���� �� ����i. ����, � ��� 2 ������" << endl;
				s--;
				goto d;
			}
			if(c == '4')
			{
				cout << "�� ��� ������������. �i���, �� �������i ��������. ���������� 2 ������..." << endl;
				s--;
				goto d;
			}
			cout << "�������i � ������, ��� ��� �� ���� ����" << endl;
			goto d;
		}
		else
		{
			goto h;
		}
		h:
	if(s == 2 && d!=e)
		{
			if(c == '1')
			{
				cout << "���� ��i��� ���� ����� ������ �� ������� �i��i. ������ ������. ����� �� ���� �� ��������" << endl;
				s--;
				goto d;
			}
			if(c == '2')
			{
				cout << "��� ����� ���� �����...   ...��� ����. ������ ������" << endl;
				s--;
				goto d;
			}
			if(c == '3')
			{
				cout << "���� ������������� � ����i����� - �����. ��� �� ������ ���� ���� ����. ������ ������" << endl;
				s--;
				goto d;
			}
			if(c == '4')
			{
				cout << "�� ������, �� ����� ����������... �����i�� ����� ����� �����, �� ���i ��� �� ��������� �������." << endl;
				s--;
				goto d;
			}
			cout << "� �� ����� ������! ������� �����!" << endl;
			goto d;
		}
	if(s == 1 && d!=e)
		{
			if(c == '1')
			{
				cout << "�� ���������..." << endl;
				s--;
				goto b;
			}
			if(c == '2')
			{
				cout << "�� ���� �� �i���, ����i!" << endl;
				s--;
				goto b;
			}
			if(c == '3')
			{
				cout << "�� ��� �����. �� �����. � ������. ����� ��� ������i��� ����� �� ������� �i��i ��������i, �� �i����" << endl;
				s--;
				goto b;
			}
			if(c == '4')
			{
				cout << "�����, ���i ��������i ����� ���� ���i�i�. ����, �� � ����� - ���! ��, � ����, ���� � �������, �i��� i �� ����i����� �� �� �������, ����i�� ����� �� ��! ����� (��)" << endl;
				s--;
				goto b;
			}
			else
			{
				cout << "�� ���, �� ���������!" << endl;
				goto a;
			}
		}
	c:
	a: ;
}
}