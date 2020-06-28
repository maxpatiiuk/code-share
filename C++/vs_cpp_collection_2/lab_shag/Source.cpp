#include <iostream>
using namespace std;
int cou;
float num[100],ser=0;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "К-ть чисел: " << endl;
	cin >> cou;
	for (int i = 0; i < cou; i++) {
		cin >> num[i];
		ser += num[i];
	}
	cout << ser / cou << endl;
}

/*#include <iostream>
using namespace std;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	for (int i = 0; i < 11; i++)
		cout << endl << i << ". " << pow(2, i) << endl;
}*/

/*#include <iostream>
using namespace std;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	int n, s = 2;
	cin >> n;
	cout << "Сума перших " << n << " чисел: ";
	for (int i = 1; i < n; i++)
		s += pow(2, i) + 1;
	cout << s << endl;
}*/

/*#include <iostream>
using namespace std;
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	int n, s = 0;
	cin >> n;
	cout << "Сума перших " << n << " чисел: ";
	for (int i = 1; i < n + 1; i++)
		s += i;
	cout << s << endl;
}*/

/*#include <iostream>
void main() {
	for (int i = 1; i < 11; i++)
		std::cout << i << ". " << pow(i,2) << std::endl;
}*/

/*#include <iostream>
using namespace std;
char name[255], sur[255];
void main() {
	system("CLS");
	setlocale(LC_CTYPE, "Ukrainian");
	cout << "Iм'я: " << endl;
	cin >> name;
	cout << "Прiзвище: " << endl;
	cin >> sur;
	for (int i = 0; i < 10; i++)
		cout << endl << i + 1 << ". " << name << " " << sur << endl;
}*/