#include "counters.h"

int main(){
	
	counters *counter = new counters();
	menu(counter);
	delete counter;

	return 0;
}