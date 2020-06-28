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
void drobs::increment() {
	set(returnInt()+1);
}
void drobs::incrementBy(int value) {
	set(returnInt()+value);
}
void drobs::decrement() {
	set(returnInt()-1);
}
void drobs::decrementBy(int value) {
	set(returnInt()-value);
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
	top[0]=0;
	bottom[0];
	top[1];
	bottom[1];
}
void drobs::addition(){
	std::cout << top[0]/bottom[0]+top[1]/bottom[1];
}
void drobs::subtraction(){
	std::cout << top[0]/bottom[0]-top[1]/bottom[1];
}
void drobs::multiply(){
	std::cout << (top[0]*bottom[1])*(top[1]*bottom[0]);
}
void drobs::division(){
	std::cout << (top[0]*bottom[0])*(top[1]*bottom[1]);
}