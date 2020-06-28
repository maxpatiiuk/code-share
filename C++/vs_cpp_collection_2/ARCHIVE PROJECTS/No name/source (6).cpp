#include <iostream>
#include <time.h>
using namespace std;
float a;
int q(int a)
{
	return sqrt(a);
}
	void main()
{
	cout << "Vvedit chuslo: ";
	cin >> a;
	cout << q(a) << endl;;
}