#include "counters.h"

void menu(counters *counter){
	int selector, value;
	bool parameter;
	while(1){

		system("CLS");
		cout << " 1. Set new time" << endl;
		cout << " 2. Reset time" << endl;
		cout << " 3. increment time by 1" << endl;
		cout << " 4. Increment time by n" << endl;
		cout << " 5. Decrement time by 1" << endl;
		cout << " 6. Decrement time by n" << endl;
		cout << " 7. Return time" << endl;
		cout << " 8. Cout time" << endl;
		cout << " 9. Set max time limit" << endl;
		cout << " 10. Set min time limit" << endl;
		cout << " 0. Exit " << endl;
		cin >> selector;
		system("CLS");

		switch(selector){
			case 1:
				cout << "Enter new value: " << endl;
				cin >> value;
				counter->setTime(value);
				break;
			case 2:
				counter->resetTime();
				break;
			case 3:
				counter->incrementTime();
				break;
			case 4:
				cout << "Enter value: " << endl;
				cin >> value;
				counter->incrementTimeBy(value);
				break;
			case 5:
				counter->decrementTime();
				break;
			case 6:
				cout << "Enter value: " << endl;
				cin >> value;
				counter->decrementTimeBy(value);
				break;
			case 7:
				cout << counter->returnTime() << endl;
				break;
			case 8:
				parameter = false;//if set parameter to 'true', will cout new line after time variable
				counter->coutTime(parameter);
				break;
			case 9:
				cout << "Enter new max limit: " << endl;
				cin >> value;
				counter->setMaxLimit(value);
				break;
			case 10:
				cout << "Enter new min limit: " << endl;
				cin >> value;
				counter->setMinLimit(value);
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