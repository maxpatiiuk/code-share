#pragma once
#include <iostream>

using namespace std;

class counters {
	public:
		int time = 0;
		int limitMax = 100;
		int limitMin = 0;
		void isValid();
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

counters *counter = new counters;