#include "counters.h"

void counter::isValid() {
	if (time>limitMax)
		time = limitMin;
	else if (time<limitMin)
		time = limitMax;
}
void counter::setTime(int value) {
	time = value;
	isValid();
}
void counter::resetTime() {
	time = limitMin;
}
void counter::incrementTime() {
	time++;
	isValid();
}
void counter::incrementTimeBy(int value) {
	time += value;
	isValid();
}
void counter::decrementTime() {
	time--;
	isValid();
}
void counter::decrementTimeBy(int value) {
	time -= value;
	isValid();
}
int counter::returnTime() {
	return time;
}
void counter::coutTime(bool newline = 0) {
	cout << time;
	if (newline)
		cout << endl;
}
void counter::setMaxLimit(int value) {
	limitMax = value;
	isValid();
}
void counter::setMinLimit(int value) {
	limitMin = value;
	isValid();
}