#include "typping.h"
#include <time.h>
#include <windows.h>

int main(){
	
	srand(time(0));
	typping *type = new typping();
	menu(type);
	delete type;

	return 0;
}