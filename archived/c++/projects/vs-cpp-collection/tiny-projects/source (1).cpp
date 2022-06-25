#include <iostream>
#include <time.h>
using namespace std;
void main()
{int i;
srand(time(0));
cout << "Загрузка..."<< endl;
for (i=0; i=100; i++)
{
	cout << "Загружено "<< i << " %" << endl;
}
cout << "Загрузку завершено!" << endl;
cin >> i;
}