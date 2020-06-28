#include <iostream> 
using namespace std;
#include <stdio.h>
void main()
{char text[1024] = {0};
cout << "Vvedit nazvu vashoi kartu:	" << endl;
cin.getline(text,1023);
cout << "Vasha karta: " << text << endl;
cin >> text;
}