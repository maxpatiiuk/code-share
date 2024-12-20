#include "drobs.h"

bool whatValue(){
	bool what;
	cout << "Would you like to work with 'numerator' or 'denominator'? (0/1)" << endl;
	cin >> what;
	return what;
}
bool whatDrob(){
	bool what;
	cout << "Would you like to work with first or second drob? (0/1)" << endl;
	cin >> what;
	return what;
}

void menu(drobs *drob){
	int value;
	bool parameter;
	drob->resetAll();
	while(1){
		drob->returnAll();
		drob->activeDrob(1);
		drob->activeValue(1);
		drob->returnInt();
		cout << " 1. Set new value" << endl;
		cout << " 2. Reset value" << endl;
		cout << " 3. Increment value by 1" << endl;
		cout << " 4. Increment value by n" << endl;
		cout << " 5. Decrement value by 1" << endl;
		cout << " 6. Decrement value by n" << endl;
		cout << " 7. Return value" << endl;
		cout << " 8. Cout value" << endl;
		cout << " 9. Addition" << endl;
		cout << " 10. Subtraction" << endl;
		cout << " 11. Multiply" << endl;
		cout << " 12. Division" << endl;
		cout << " 0. Exit " << endl;
		cin >> value;
		system("CLS");
		if(value!=0 && (value<9 || value>12)){
			drob->activeDrob(whatDrob());
			drob->activeValue(whatValue());
		}
		switch(value){
			case 1:
				cout << "Enter new value: " << endl;
				cin >> value;
				drob->set(value);
				break;
			case 2:
				drob->reset();
				break;
			case 3:
				cout << ++drob;
				break;
			case 4:
				cout << "Enter value: " << endl;
				cin >> value;
				cout << drob + value;
				break;
			case 5:
				cout << drob-1;
				break;
			case 6:
				cout << "Enter value: " << endl;
				cin >> value;
				cout << drob + value;
				break;
			case 7:
				cout << drob->returnInt() << endl;
				break;
			case 8:
				parameter = false;
				drob->cout(parameter);
				break;
			case 9:
				cout << +drob;
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