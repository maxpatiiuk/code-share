#include <iostream>

using namespace std;

class Line {
	int count;
	char *data;
public:
	Line(int iCount, char *iData) :count(iCount), data(new char[strlen(iData)]) {
		strcpy(data, iData);
	}
	Line() {
		Line(0, "");
	}
	Line(const Line &buf) {
		count = buf.count;
		delete[]data;
		data = new char[strlen(buf.data)];
		strcpy(data, buf.data);
	}
	~Line() {
		if (data != NULL)
			delete[]data;
	};
};
void menu() {
	Line *contacts = new Line;
	int i, col, row;
	Line buf;
	while (1) {
		system("CLS");
		cout << "1. Add" << endl;
		cout << "2. 2ter" << endl;
		cout << "3. 3ert" << endl;
		cout << "4. 4ert" << endl;
		cout << "5. ert" << endl;
		cout << "6. ret" << endl;
		cout << "7. erter" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
		case 1:

			break;
		case 2:

			break;
		case 3:

			break;
		case 4:

			break;
		case 5:

			break;
		case 6:

			break;
		case 7:

			break;
		case 0:
			exit(0);
			break;
		}
		cout << endl;
		system("pause");
		system("CLS");
	}
}

void main() {
	menu();
}