/*#include <iostream>
#include <time.h>
using namespace std;
bool a[4][4] = {0};
int x, y, i, ii;
void game() {
	cout << " 123|x";
	for (i = 0; i < 3;) {
		cout << endl << ++i;
		for (ii = 1; ii < 4; ii++) {
			if (a[ii][i] == 1)
				cout << '*';
			else
				cout << ' ';
		}
	}
	cout << endl << '-' << endl << 'y' << endl;
}
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	int n = 0;
	cout << "a=[x][y]" << endl;
	while (n < 5) {
		game();
		cin >> x;
		system("CLS");
		y = x - 10 * int(x / 10);
		x = int(x / 10);
		if (a[x][y] != 1) {
			a[x][y] = 1;
			if (n < 5) {
				if (a[1][1] == 1 && a[1][2] == 1 && a[1][3] == 0)
					a[1][3] = 1;
				else if (a[2][1] == 1 && a[2][2] == 1 && a[2][3] == 0)
					a[2][3] = 1;
				else if (a[3][1] == 1 && a[3][2] == 1 && a[3][3] == 0)
					a[3][3] = 1;
				else if (a[1][1] == 1 && a[1][2] == 0 && a[1][3] == 1)
					a[1][2] = 1;
				else if (a[2][1] == 1 && a[2][2] == 0 && a[2][3] == 1)
					a[2][2] = 1;
				else if (a[3][1] == 1 && a[3][2] == 0 && a[3][3] == 1)
					a[3][2] = 1;
				else if (a[1][1] == 0 && a[1][2] == 1 && a[1][3] == 1)
					a[1][1] = 1;
				else if (a[2][1] == 0 && a[2][2] == 1 && a[2][3] == 1)
					a[2][1] = 1;
				else if (a[3][1] == 0 && a[3][2] == 1 && a[3][3] == 1)
					a[3][1] = 1;
				else if (a[1][1] == 1 && a[1][2] == 1 && a[1][3] == 0)
					a[1][3] = 1;
				else if (a[1][2] == 1 && a[2][2] == 1 && a[3][2] == 0)
					a[3][2] = 1;
				else if (a[1][3] == 1 && a[2][3] == 1 && a[3][3] == 0)
					a[3][3] = 1;
				else if (a[1][1] == 1 && a[2][1] == 0 && a[3][1] == 1)
					a[2][1] = 1;
				else if (a[1][2] == 1 && a[2][2] == 0 && a[3][2] == 1)
					a[2][2] = 1;
				else if (a[1][3] == 1 && a[2][3] == 0 && a[3][3] == 1)
					a[2][3] = 1;
				else if (a[1][1] == 0 && a[2][1] == 1 && a[3][1] == 1)
					a[1][1] = 1;
				else if (a[1][2] == 0 && a[2][2] == 1 && a[3][2] == 1)
					a[1][2] = 1;
				else if (a[1][3] == 0 && a[2][3] == 1 && a[3][3] == 1)
					a[1][3] = 1;
				else
					do {
						x = rand() % 3 + 1;
						y = rand() % 3 + 1;
					} while (a[x][y] == 1);
					a[x][y] = 1;
					n++;
			}
		}
		else
			cout << "—прбуйте ввести iншi кординати!" << endl;
	}
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int a, b;
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cin >> a >> b;
	cout << time(0) % b + a << endl;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int a, b;
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "¬ведiть число" << endl;
	cin >> a;
a:
	cout << "¬ведiть степiнь (1-7)" << endl;
	cin >> b;
	if (b <= 7 && b >= 1)
		cout << endl << pow(a, b) << endl;
	else {
		cout << "—тепiнь повинен бути в межах вiд 1 до 7" << endl;
		goto a;
	}
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int a;
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cin >> a; //123456
				//int(a/10)//12345
				//a-10*int(a/10)//6
				//int(a/100000)//1
				//int((a-100000*int(a/100000)))//23456
				//int((a-100000*int(a/100000))/10000)//2
				//int(int(a/10)/10)//1234
				//int(a/10)-10*int(int(a/10)/10)//5
				//int(a/10)-10*int(int(a/10)/100)//4
				//int(int(a/10)/100//123
				//int(int(a/10)/1000//12
				//int(int(a/10)/100-10*int(int(a/10)/1000//3
	if (int(a / 100000) == a - 10 * int(a / 10) && int((a - 100000 * int(a / 100000)) / 10000) == int(a / 10) - 10 * int(int(a / 10) / 10) && int(int(a / 10) / 100 - 10 * int(int(a / 10) / 1000)) == int(int(a / 10) / 10) - 10 * int(int(a / 10) / 100))
		cout << "„исло э щасливим!" << endl;
	else
		cout << "„исло не э щасливим..." << endl;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int a;
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cin >> a; //1234
	if (a < 999 && a > 9999)
		cout << "„исло повино бути чотирьзначним" << endl;
	//a//1234
	//int(a/1000)//1
	//int(a/10)//123
	//a-10*int(a/10)//4
	//int(a/100)//12
	//int(a/10)-10*int(a/100)//3
	//int(a/100)-10*int(a/1000)//2
	cout << (int(a / 100) - 10 * int(a / 1000)) * 1000 + 100 * int(a / 1000) + 10 * (a - 10 * int(a / 10)) + int(a / 10) - 10 * int(a / 100) << endl;
	cout << int(a / 100) - 10 * int(a / 1000) << int(a / 1000) << a - 10 * int(a / 10) << int(a / 10) - 10 * int(a / 100) << endl;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int i = 0, ii = 0, a[6];
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	for (; i < 7; i++)
		cin >> a[i];
	for (i = 0; i < 7; i++)
		if (a[ii] < a[i])
			ii = i;
	cout << endl << ii + 1;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int ii,i=0,da1,da2,m1,m2,ye1,ye2,d1,d2,Month[13]={0,31,29,31,30,31,30,31,31,30,31,30,31},Month2[13]={0,31,28,31,30,31,30,31,31,30,31,30,31};
void main() {
	srand(time(0));
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "¬ведiть дату 1 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d1;
	cout << "¬ведiть дату 2 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d2;
	da1 = 10 * (int(d1 / 10000000) - 10 * int(d1 / 100000000)) + int(d1 / 1000000) - 10 * int(d1 / 10000000);
	m1 = 10 * (int(d1 / 100000) - 10 * int(d1 / 1000000)) + (int(d1 / 10000) - 10 * int(d1 / 100000));
	ye1 = 1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10));
	da2 = 10 * (int(d2 / 10000000) - 10 * int(d2 / 100000000)) + int(d2 / 1000000) - 10 * int(d2 / 10000000);
	m2 = 10 * (int(d2 / 100000) - 10 * int(d2 / 1000000)) + (int(d2 / 10000) - 10 * int(d2 / 100000));
	ye2 = 1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10));
	if (ye1 % 4 == 0 && ye1 % 100 != 0 || ye1 % 400 == 0)
		for (i = 1; i <= m1; i++)
			ii += Month[i];
	else
		for (i = 1; i <= m1; i++)
			ii += Month2[i];
	m1 = ii;
	ii = 0;
	for (i = 1; i <= ye1; i++) {
		if (ye1 % 4 == 0 && ye1 % 100 != 0 || ye1 % 400 == 0)
			ii += 366;
		else
			ii += 365;
	}
	ye1 = ii + m1 + da1;
	ii = 0;
	if (ye2 % 4 == 0 && ye2 % 100 != 0 || ye2 % 400 == 0)
		for (i = 1; i <= m2; i++)
			ii += Month[i];
	else
		for (i = 1; i <= m2; i++)
			ii += Month2[i];
	m2 = ii;
	ii = 0;
	for (i=1; i <= ye2; i++) {
		if (ye2 % 4 == 0 && ye2 % 100 != 0 || ye2 % 400 == 0)
			ii += 366;
		else
			ii += 365;
	}
	ye2=ii+m2+da2;
	cout << "ћiж цими датами пройшло " << ye2-ye1+3 << " днiв" << endl;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int d1, d2;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "¬ведiть дату 1 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d1;
	cout << "¬ведiть дату 2 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d2;
	cout << "ћiж цими датами пройшло " << abs((((10 * (int(d1 / 10000000) - 10 * int(d1 / 100000000)) + int(d1 / 1000000) - 10 * int(d1 / 10000000)+30*(10 * (int(d1 / 100000) - 10 * int(d1 / 1000000)) + (int(d1 / 10000) - 10 * int(d1 / 100000)))) * 86400 + ((1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10))) - 70) * 31536000 + (((1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10))) - 69) / 4) * 86400 - (((1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10))) - 1) / 100) * 86400 + (((1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10))) + 299) / 400) * 86400)- ((10 * (int(d2 / 10000000) - 10 * int(d2 / 100000000)) + int(d2 / 1000000) - 10 * int(d2 / 10000000) + 30 * (10 * (int(d2 / 100000) - 10 * int(d2 / 1000000)) + (int(d2 / 10000) - 10 * int(d2 / 100000)))) * 86400 + ((1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10))) - 70) * 31536000 + (((1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10))) - 69) / 4) * 86400 - (((1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10))) - 1) / 100) * 86400 + (((1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10))) + 299) / 400)))) << " днiв" << endl;
}*/

/*#include <iostream>
#include <time.h>
using namespace std;
int d1, d2;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "¬ведiть дату 1 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d1;
	cout << "¬ведiть дату 2 в вигл€дi <день><мiс€ць><рiк> (наприклад - 09082010)" << endl;
	cin >> d2;

	cout << "ћiж цими датами пройшло " << (((10 * (int(d2 / 10000000) - 10 * int(d2 / 100000000)) + int(d2 / 1000000) - 10 * int(d2 / 10000000)) + 30 * (10 * (int(d2 / 100000) - 10 * int(d2 / 1000000)) + (int(d2 / 10000) - 10 * int(d2 / 100000)))) / 365.242199 + (1000 * (int(d2 / 1000) - 10 * int(d2 / 10000)) + 100 * (int(d2 / 100) - 10 * int(d2 / 1000)) + 10 * (int(d2 / 10) - 10 * int(d2 / 100)) + (d2 - 10 * int(d2 / 10))) - ((10 * (int(d1 / 10000000) - 10 * int(d1 / 100000000)) + int(d1 / 1000000) - 10 * int(d1 / 10000000)) + 30 * (10 * (int(d1 / 100000) - 10 * int(d1 / 1000000)) + (int(d1 / 10000) - 10 * int(d1 / 100000)))) / 365.242199 + (1000 * (int(d1 / 1000) - 10 * int(d1 / 10000)) + 100 * (int(d1 / 100) - 10 * int(d1 / 1000)) + 10 * (int(d1 / 10) - 10 * int(d1 / 100)) + (d1 - 10 * int(d1 / 10))))*365.242199 << " днiв" << endl;
}*/