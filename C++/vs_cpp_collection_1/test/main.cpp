#include "drobs.h"

int main(){
	
	drobs *drob = new drobs();
	menu(drob);
	delete drob;

	return 0;
}