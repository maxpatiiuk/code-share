#include "drobs.h"

void drobs::activeDrob(bool value) {
	curDrob=value;
}
void drobs::activeValue(bool value) {
	curValue=value;
}
void drobs::set(int value) {
	if(curValue==0)
	 top[curDrob]=value;
	else
		bottom[curDrob]=value;
}
void drobs::reset() {
	set(1);
}
drobs drobs::operator++(int){
	drobs temp(*this);
	++top[0];
	return temp;
}
drobs operator+(int p, const drobs & p1){
	return drobs(p+p1.returnInt());
}
double drobs::operator*(int val){
	return float((top[0]/bottom[1])*(top[1]/bottom[0]));
}
double drobs::operator/(int val){
	return float((top[0]*bottom[1])/(top[0]*bottom[1]));
}
int drobs::returnInt() {
	if(curValue==0)
		return top[curDrob];
	else
		return bottom[curDrob];
}
void drobs::cout(bool newline = 0) {
	std::cout << returnInt();
	if (newline)
		std::cout << std::endl;
}
void drobs::resetAll(){
	top[0]=1;
	bottom[0] = 1;
	top[1] = 1;
	bottom[1] = 1;
}
void drobs::returnAll() {
	std::cout << top[0] << "\t\t" << top[1] << "\n____\t\t____\n" << bottom[0] << "\t \t" << bottom[1]  << "\n";
}