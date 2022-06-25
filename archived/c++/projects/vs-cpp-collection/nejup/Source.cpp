#include <iostream>
using namespace std;
int a[10] = { 0 }, i = 0, ii = 0, co, cNum[10] = { 0 }, pos = 0;
void func(int a[], int co) {
	if (co == 1) {
		cout << a[0] << endl;
		return;
	}
	else {
		if (pos >= co) {
			i++;
			pos = 0;
			cout << endl;
		}
		if (pos >= co - 1)
			cNum[pos]++;
		if (i >= pow(co, co))
			return;
		for (ii = co; ii >= 0; ii--) {
			if (cNum[ii] >= co && ii != 0) {
				cNum[ii] = 0;
				cNum[ii - 1]++;
			}
		}
		cout << a[cNum[pos]];
		pos++;
		func(a, co);
	}
}
void main() {
	cin >> co;//к-ть елеметів масиву (макс 10)
	for (; i<co; i++)
		cin >> a[i];//вводимo масив чисел (напр 0,1,2,3,4,5)
	i = 0;
	func(a, co);
}