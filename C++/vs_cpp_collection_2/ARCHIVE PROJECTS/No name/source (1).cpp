#include <iostream>
#include <time.h>
using namespace std;
void main()
{int i;
srand(time(0));
cout << "��������..."<< endl;
for (i=0; i=100; i++)
{
	cout << "��������� "<< i << " %" << endl;
}
cout << "�������� ���������!" << endl;
cin >> i;
}