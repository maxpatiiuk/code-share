/*#include <windows.h>
#include <tchar.h>
#define SIZE 3

INT WINAPI _tWinMain(HINSTANCE hInst, HINSTANCE hPrevInst, LPTSTR lpszCmdLine, int nCmdShow)
{
	INT length=0;
	TCHAR a[SIZE][1024] = {L"Login: mambo",L"Password: *****",L"Favorite Fruit: Mango"};
	TCHAR b[SIZE][1024] = {L"Login",L"Password",L"Favorite Fruit"};
	for(INT i = 0; i < SIZE; i++ ){
		MessageBox(0,a[i],b[i],MB_OK);
		length+=lstrlen(a[i]);
	}
	TCHAR buf[1024];
	wsprintf(buf,L"%i",length/SIZE);
	MessageBox(0,buf,L"LENGTH",MB_OK);
}*/

#include <windows.h>
#include <tchar.h>
#include <time.h>
#define SIZE 3


INT WINAPI _tWinMain(HINSTANCE hInst, HINSTANCE hPrevInst, LPTSTR lpszCmdLine, int nCmdShow)
{
	srand(time(0));
	INT times=0;
	BYTE correct=0;
	TCHAR buf[1024];
	do{
		wsprintf(buf,L"%i",rand()%100);
		times++;
	} while(MessageBox(0,buf,L"CORRECT?",MB_YESNO)!=IDYES);
	wsprintf(buf,L"Times: %i",times);
	MessageBox(0,buf,L"Times",MB_OK);
}