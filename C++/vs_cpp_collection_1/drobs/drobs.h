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
		double operator+(int val);
		double operator+();
		double operator-(int val);
		double operator-();
		double operator/(int val);
		double operator*(int val);
		int returnInt();
		void cout(bool);
		drobs & operator++(){
			++top[0];
			return *this;
		}
		drobs & operator--(){
			--top[0];
			return *this;
		}
		drobs operator++(int);
		/*drobs & operator+(){
			return float(top[curDrob]/bottom[curDrob]+1);
		}
		drobs & operator-(int val){
			return float(top[curDrob]/bottom[curDrob]-val);
		}
		drobs & operator-(){
			return float(top[curDrob]/bottom[curDrob]-1);
		}*/
};

void menu(drobs *drob);
