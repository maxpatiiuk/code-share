#define _CRT_SECURE_NO_WARNINGS
#include <iomanip>
#include <iostream>
#include <conio.h>
#include <time.h>
using namespace std;
int x[200],z,t,i,q;
void n();
void m();
void l()
{
float a[20],b[6],l;
int i,s,c;
s=0;
srand(time(0));
l=0;
for(i=0;i<20;i++){
a[i]=rand()%20-10;
cout << a[i] << ' ';
l=l+a[i];
}
l=int(l/19);
s=int(19/3);
if(l>0){
//2/3 0 - 20
int size = 19-2*s;
int min, n_min, k = 0;
do{
min = a[k];
n_min = k;
for (int i = k; i < size; i++)
if (a[i] > min)
{
min = a[i];
n_min = i;
}
swap(a[k], a[n_min]);
k++;
} while (k < size);
/*for(k=size,i=size+2*s,min=s;min<size;min=min+2,i++,k--){
swap(a[i],a[k]);
}
*/
for(c=13,i=0,s=5;i<5;i++,s--)
a[c]=b[s];
for(c=13,i=0;i<5;i++,c++)
a[c]=b[i];
}
else{
//1/3 0 - 20
int size = 19-s;
int min, n_min, k = 0;
do{
min = a[k];
n_min = k;
for (int i = k; i < size; i++)
if (a[i] > min)
{
min = a[i];
n_min = i;
}
swap(a[k], a[n_min]);
k++;
} while (k < size);
for(c=7,i=0,s=5;i<5;i++,s--)
a[c]=b[s];
for(c=7,i=0;i<5;i++,c++)
a[c]=b[i];
}
cout << endl;
for(i=0;i<19;i++){
cout <<setprecision(2) << a[i] << ' ';
}
cout << endl;
}
void a()
{
system("CLS");
cout << "Старт - 1" << endl << "Iнструкцiя - 2" << endl << "Вихiд - 3" << endl;
z = _getch();
n();
}
void n()
{
switch(z)
{
case 49:
system("CLS");
l();
z = _getch();
if (z==13)
a();
break;
case 50:
cout << "Вiтаю вас в програмi. Якщо ви виберете ""Старт"", то програмазгенерує рядок з 19 цифр. Якщо середнє арифметичне >0, то 2/3 рядкапоставлять вiд найменшого до найбiльшого, а в iншому випадку 1/3поставится вiд найменшого до найбiльшого. А частина що залишиться,вiдобразиться в зворотньому порядку. Якщо ви виберете ""Вихiд"", топрограма автоматично закриється." << endl;
z = _getch();
if (z==13)
a();
break;
case 51:
exit(0);
break;
}
}
void main()
{
system("CLS");
setlocale(LC_ALL, "Russian");
t=0;
a();
system("pause");
}

/*
#include <iostream>
#include <time.h>
#include <iomanip>
#include <conio.h>
using namespace std;
int z,x;
void main();
void a();
void p();
void l()
{
for(;;)
{
z = _getch();
if(x == 1 && z == 83)
p();
if(x == 2 && z == 83)
{
cout << "Вiтаю вас в програмi. Якщо ви виберете ""Старт"", то програма
згенерує рядок з 19 цифр. Якщо середнє арифметичне >0, то 2/3 рядка
поставлять вiд найменшого до найбiльшого, а в iншому випадку 1/3
поставится вiд найменшого до найбiльшого. А частина що залишиться,
вiдобразиться в зворотньому порядку. Якщо ви виберете ""Вихiд"", то
програма автоматично закриється." << endl;
z = _getch();
if (z==13)
main();
}
if(x == 3 && z == 83)
exit(0);
}
}
void p()
{
float a[20],b[6],l;
__int8 i,s,c;
s=0;
srand(time(0));
l=0;
for(i=0;i<19;i++){
a[i]=rand()%20-10;
cout << a[i] << ' ';
l=l+a[i];
}
l=int(l/19);
s=int(19/3);
if(l>0){
//2/3 0 - 20
int size = 19-2*s;
int min, n_min, k = 0;
do{
min = a[k];
n_min = k;
for (int i = k; i < size; i++)
if (a[i] > min)
{
min = a[i];
n_min = i;
}
swap(a[k], a[n_min]);
k++;
} while (k < size);
for(k=size,i=size+2*s,min=s;min<size;min=min+2,i++,k--){
swap(a[i],a[k]);
}
for(c=13,i=0,s=5;i<6;i++,s--){
a[c]=b[s];
}
for(c=13,i=0;i<6;i++,c++)
a[c]=b[i];
}
else{
//1/3 0 - 20
int size = 19-s;
int min, n_min, k = 0;
do{
min = a[k];
n_min = k;
for (int i = k; i < size; i++)
if (a[i] > min)
{
min = a[i];
n_min = i;
}
swap(a[k], a[n_min]);
k++;
} while (k < size);
for(k=size,i=size+s,min=s;min<size;min=min+2,i++,k--){
swap(a[i],a[k]);
}
}
cout << endl;
for(i=0;i<19;i++){
cout <<setprecision(2) << a[i] << ' ';
}
cout << endl;
}
void m()
{
for(;;)
{
switch(z)
{
case 38:
x--;
a();
break;
case 40:
x++;
a();
break;
}
}

}
void a()
{
for(;;)
{
if(x==0)
x=3;
if(x==4)
x=1;
z = _getch();
if(x == 1)
cout << "[ Старт ]" << endl << "  Iнструкцiя  " << endl << "  Вихiд  " << endl;
z = _getch();
l();
if(x == 2)
{
cout << "  Старт  " << endl << "[ Iнструкцiя ]" << endl << "  Вихiд  " << endl;
main();
}
if(x == 3)
cout << "[ Старт ]" << endl << "  Iнструкцiя  " << endl << "[ Вихiд ]" << endl;
}

}
void main()
{
system("CLS");
setlocale(LC_ALL,"");
x=1;
z=0;
cout << "[ Старт ]" << endl << "  Iнструкцiя  " << endl << "  Вихiд  " << endl;
for(;;)
{
z = _getch();
}
m();
}

*/