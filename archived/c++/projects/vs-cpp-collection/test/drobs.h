#pragma once
#include <iostream>

using namespace std;

class drobs {
		int top[2];
		int bottom[2];
		bool curDrob, curValue;
public:
		drobs(){
			top[0] = 1;
			bottom[0] = 1;
			curDrob = 1;
			curValue = 1;
		}
		void resetAll();
		void returnAll();
		void activeDrob(bool);
		void activeValue(bool);
		void set(int);
		void reset();
		void increment();
		void incrementBy(int);
		void decrement();
		void decrementBy(int);
		int returnInt();
		void cout(bool);
		void addition();
		void subtraction();
		void multiply();
		void division();
};

void menu(drobs *drob);
