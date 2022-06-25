#pragma once
#include <iostream>

using namespace std;

class typping {
		char currentKey;
		int progress;
		int typos;
		char list[40];
		char charset[40];
public:
		typping(){
			typos = 0;
			currentKey=0;
			progress=0;
			list[40]=0;
			charset[40]=0;
		}
		void getCharset();
		int getKey();
		void generateList();
};

void menu(typping *type);
