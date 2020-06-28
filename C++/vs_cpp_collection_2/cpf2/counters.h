#pragma once
#include <iostream>

using namespace std;

class counters {
		int time;
		int limitMax;
		int limitMin;
public:
		counters(){
			time = 0;
			limitMax = 100;
			limitMin = 0;
		}
		void setTime(int);
		void resetTime();
		void incrementTime();
		void incrementTimeBy(int);
		void decrementTime();
		void decrementTimeBy(int);
		int returnTime();
		void coutTime(bool);
		void setMaxLimit(int);
		void setMinLimit(int);
};

void menu(counters *counter);
