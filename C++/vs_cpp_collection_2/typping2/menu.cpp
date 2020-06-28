#include "typping.h"


void menu(typping *type){
		int i;
		while(1){
			system("CLS");
			type->getCharset();
			int res;
			do {
				res=type->getKey();
			} while(res==1);
			if(res==2){
				cout << "\nDo you want to exit or restart?(0/1)\n";
				cin >> i;
				cin.ignore();
				if(i==0)
					exit(0);
			}
		}
}