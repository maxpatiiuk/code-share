#include <cstdlib>
#include <iostream>
#include <conio.h>
#include <windows.h>
using namespace std;

int main(int argc, char *argv[])
{
	while (true) {
		cout << "Input note: ";
		char note = getch();


		//do re mi fa sol la si do re mi fa sol
		if (note == 'a') {
			Beep(261, 100);
		}
		if (note == 's') {
			Beep(293, 100);
		}
		if (note == 'd') {
			Beep(329, 100);
		}
		if (note == 'f') {
			Beep(349, 100);
		}
		if (note == 'g') {
			Beep(392, 100);
		}
		if (note == 'h') {
			Beep(440, 100);
		}
		if (note == 'j') {
			Beep(493, 100);
		}
		if (note == 'k') {
			Beep(523, 100);
		}
		if (note == 'l') {
			Beep(587, 100);
		}
		if (note == ';') {
			Beep(659, 100);
		}
		if (note == '\'') {
			Beep(698, 100);
		}
		if (note == '\\') {
			Beep(784, 100);
		}

		//rebemol mibemol solbemol labemol sibemol rebemol mibemol solbemol
		if (note == 'w') {
			Beep(277, 100);
		}
		if (note == 'e') {
			Beep(311, 100);
		}
		if (note == 't') {
			Beep(370, 100);
		}
		if (note == 'y') {
			Beep(415, 100);
		}
		if (note == 'u') {
			Beep(466, 100);
		}
		if (note == 'o') {
			Beep(554, 100);
		}
		if (note == 'p') {
			Beep(622, 100);
		}
		if (note == ']') {
			Beep(740, 100);
		}

		system("cls");
	}

	return EXIT_SUCCESS;
}