#include "counters.h"

void counters::setTime(int value) {
	time = value;
	if(time>limitMax)
		time=limitMin;
	else if(time<limitMin)
		time=limitMax;
}
void counters::resetTime() {
	setTime(limitMin);
}
void counters::incrementTime() {
	setTime(returnTime()+1);
}
void counters::incrementTimeBy(int value) {
	setTime(returnTime()+value);
}
void counters::decrementTime() {
	setTime(returnTime()-1);
}
void counters::decrementTimeBy(int value) {
	setTime(returnTime()-value);
}
int counters::returnTime() {
	return time;
}
void counters::coutTime(bool newline = 0) {
	cout << time;
	if (newline)
		cout << endl;
}
void counters::setMaxLimit(int value) {
	limitMax = value;
	setTime(returnTime());
}
void counters::setMinLimit(int value) {
	limitMin = value;
	setTime(returnTime());
}