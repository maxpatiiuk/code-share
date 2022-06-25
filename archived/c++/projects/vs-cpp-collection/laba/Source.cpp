#include <iostream>
using namespace std;
float sec,hou,min;
void multiply(float min, float hou, float sec){
	cout << min * 60 << endl << hou * 60 * 60 << endl << sec << endl;
}
void multiply(float sec) {
	cout << sec / 60 / 60 << endl << sec / 60 << endl << sec << endl;
}
void main() {
	cin >> min >> hou >> sec;
	multiply(min, hou, sec);
	cin >> sec;
	multiply(sec);
}

/*
#include <iostream>
using namespace std;
int a,b;
float c, d;
int multiply(int a,int b){
	return a*b;
}
float multiply(float c, float d) {
	return c*d;
}
void main() {
	cin >> a >> b;
	cout << multiply(a, b) << endl;
	cin >> c >> d;
	cout << multiply(c, d) << endl;
}
*/

/*
#include <iostream>
using namespace std;
int a[9],i=0,max=0;
int proces(int a[]){
	for (i=0; i<9; i++) {
		if (a[i] > a[max])
			max = i;
	}
	return max;
}
void main() {
	for(;i<9;i++){
		cout << i << ". >> ";
		cin >> a[i];
	}
	max = proces(a);
	cout << max << endl;
	for (i = 0; i < 9; i++) {
		if (i != max)
			cout << i << " >> " << 2 * a[i] << endl;
		else
			cout << i << " >> " << a[i] << endl;
	}
}
*/

/*
#include <iostream>
using namespace std;
int a[9],i=0,max=0;
void proces(int a[9], int max){
	for (i = 0; i < 9; i++) {
		if (i != max)
			cout << i << " >> " << 2 * a[i] << endl;
		else
			cout << i << " >> " << a[i] << endl;
	}
}
void main() {
	for(;i<9;i++){
		cout << i << ". >> ";
		cin >> a[i];
		if (a[i] > a[max])
			max = i;
	}
	proces(a,max);

}
*/

/*
#include <iostream>
using namespace std;
int a[8],i=0,sum=0,min=0,max=0;
void main() {
	for(;i<8;i++){
		cout << i << ". >> ";
		cin >> a[i];
		sum += a[i];
		if (a[i] < a[min])
			min = i;
		if (a[i] > a[max])
			max = i;
	}
	cout << "Average: " << (sum-min-max)/6;
}
*/