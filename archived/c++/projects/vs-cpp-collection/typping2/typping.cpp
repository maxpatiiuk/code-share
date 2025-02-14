#include "typping.h"
#include <conio.h>

void typping::getCharset(){
	cout << "Enter charset of posible varibles:\n";
	charset[0] = '\0';
	gets_s(charset);
	system("CLS");
	generateList();
	system("CLS");
	progress = 0;
	typos = 0;
	cout << list << endl;
}
int typping::getKey(){
	currentKey=getch();
	if((char)currentKey==list[progress]){
		if (progress + 1 >= strlen(list)) {
			cout << "\nNumber of typos: " << typos << "\nPress Enter to continue";
			do {
				currentKey = getch();
			} while (currentKey != 13);
			return 0;
		}
		else {
			cout << list[progress];
			progress++;
			return 1;
		}	
	}
	else if((char)currentKey==13)
		return 2;
	else {
		typos++;
		return 1;
	}
}
void typping::generateList(){
	for (int i = 0; i < 40; i++) {
		do {
			list[i] = charset[rand() % strlen(charset)];
		} while ((i > 1 && list[i] == list[i - 1] && list[i] == list[i - 2]) || (i>0 && list[i] == list[i - 1] && list[i]==' '));
	}
}