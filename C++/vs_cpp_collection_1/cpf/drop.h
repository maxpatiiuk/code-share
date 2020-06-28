#include "drop.cpp"
void doubleCalc::cin(){
	std::cin >> top >> bottom;
}
void doubleCalc::cout(){
	std::cout << std::endl << top << std::endl;
	std::cout << bottom << std::endl;
}
void doubleCalc::setTop(double value){
	top=value;
}
void doubleCalc::setBottom(double value){
	bottom=value;
}
double doubleCalc::returnTop(){
	return top;
}
double doubleCalc::returnBottom(){
	return bottom;
}
double doubleCalc::calculateResult(){
	if(bottom!=0)
		return top/bottom;
	else
		return 0;
}
double doubleCalc::calculateTwo(double fir, double sec){
	if(sec!=0)
		return fir/sec;
	else
		return 0;
}