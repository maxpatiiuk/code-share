#include <iostream>
#pragma warning(disable:4996)

using namespace std;

struct Data {
	char data[100];
	int prioritet;
	char name[100];
	Data() {
		data[0] = '\0';
		name[0] = '\0';
		prioritet = 0;
		for (int i = 1; i<100; i++) {
			data[i] = 0;
			name[i] = 0;
		}
	}
	void copy(Data val) {
		strcpy(data, val.data);
		prioritet = val.prioritet;
		strcpy(name, val.name);
	}
};

class queue {
	int count;
	Data* data;
public:
	queue() {
		count = 0;
		data = NULL;
	}
	~queue() {
		if (data != NULL)
			delete[]data;
	};
	int getCount();
	void getQue();
	void getUsers();
	bool print();
	void add(int, char*, char*);
};


int queue::getCount() {
	return count;
}
void queue::getQue() {
	cout << "Data\tPrioritet\tName\n";
	for (int i = 0; i<count; i++)
		cout << data[i].data << "\t\t" << data[i].prioritet << "\t" << data[i].name << endl;
}
void queue::getUsers() {
	cout << "Name\tPrioritet\n";
	for (int i = 0; i<count; i++) {
		if(i+1==count)
			cout << data[i].name << "\t\t" << data[i].prioritet << endl;
		for (int ii = i + 1; ii<count; ii++) {
			if (strcmp(data[i].name, data[ii].name) == 0)
				break;
			if (ii + 1 >= count)
				cout << data[i].name << "\t\t" << data[i].prioritet << endl;
		}
	}
}
bool queue::print() {
	if (count == 0)
		return 0;
	else if (count == 1) {
		count = 0;
		delete[]data;
		cout << data[count - 1].data << "\t" << data[count - 1].prioritet << "\t" << data[count - 1].name << endl;
	}
	else {
		int max = 0;
		for (int i = 1; i<count; i++)
			if (data[i].prioritet>data[max].prioritet)
				max = i;
		cout << data[max].data << "\t" << data[max].prioritet << "\t" << data[max].name << endl;
		Data *buf = new Data[count-1];
		for (int i = 0, real = 0; i < count; i++) {
			if (i != max) {
				buf[real].copy(data[i]);
				real++;
			}
		}
		count--;
		delete[]data;
		data = buf;
	}
}
void queue::add(int vPrioritet, char* vData, char* vName) {
	if (count != 0) {
		count++;
		Data *buf = new Data[count];
		for (int i = 0; i < count - 1; i++)
			buf[i].copy(data[i]);
		strcpy(buf[count-1].data, vData);
		buf[count-1].prioritet = vPrioritet;
		strcpy(buf[count-1].name, vName);
		delete[]data;
		data = buf;
	}
	else {
		count = 1;
		data = new Data[1];
		data[0].prioritet = vPrioritet;
		strcpy(data[0].name, vName);
		strcpy(data[0].data, vData);
	}
}

void menu() {
	queue printing;
	int i;
	while (1) {
		system("CLS");
		cout << "1. Get queue" << endl;
		cout << "2. Get users" << endl;
		cout << "3. Print" << endl;
		cout << "4. Add" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		char buf1[100], buf2[100];
		system("CLS");
		switch (i) {
		case 1:
			printing.getQue();
			break;
		case 2:
			printing.getUsers();
			break;
		case 3:
			printing.print();
			break;
		case 4:
			cin >> i;
			cin.ignore();
			cin.getline(buf1, 100);
			cin.getline(buf2, 100);
			printing.add(i, buf1, buf2);
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