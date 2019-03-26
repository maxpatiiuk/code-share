/*UNICODE*/
	wchar_t s[100];
	//char - ansi == ascii
	//wchar_t - unicode
	//strcat - wcscat
	//strlen - wcslen
	wchar_t a[15]=L"Hello,";//literal

	#define _UNICODE//all macroses wiil be treated as unicode
	//if not defined, all _TC wiil be replaced with str
	#include <tchar.h>//macroses for unicode
	void main(){//macroses start with undeline
		_TCHAR s[15]=_TEXT("Hello,");
		_tcscat(s,_TEXT(" world!"));
		wcout << s << '\n';
	}

	//functions in os level // windows lbraries // faster
	//lstr-cat,cmp,cmpi(case-insansitive),cpy,len

	int MultiByteToWideChar(//return length
	UINT CodePage, // coding // CP_ACP
	DWORD dwFlags, // add settings // 0
	LPCSTR lpMultiByteStr, // pointer to source
	int cbMultiByte, // lenth in bytes
	LPWSTR lpWideCharStr, // pointer to biffer
	int cchWideChar // size of buffer
	);

	int length = MultiByteToWideChar(CP_ACP /*ANSI code page*/, 0, buffer, -1, NULL, 0);
	wchar_t *ptr = new wchar_t [length]; 
	// конвертируем ANSI-строку в Unicode-строку
	MultiByteToWideChar(CP_ACP, 0, buffer, -1, ptr, length);

	wcslen();//unicode size
	_msize();//allocated memory

	char buffer[] = "mbstowcs converts ANSI-string to Unicode-string";
	int length = mbstowcs(NULL, buffer, 0);
	wchar_t *ptr = new wchar_t[length]; 
	mbstowcs(ptr, buffer, length);//unicode - res//ansi - source//max len

	int WideCharToMultiByte(
	UINT CodePage, // unix str
	DWORD dwFlags, // add setting
	LPCWSTR lpWideCharStr, // unicode source
	int cchWideChar, // number of words
	LPSTR lpMultiByteStr, // buffer - res
	int cbMultiByte, // buf size
	LPCSTR lpDefaultChar, // def symbol if not existiong
	LPBOOL lpUsedDefaultChar // flag that show bool res
	);

	wchar_t buffer[] = L"WideCharToMultiByte converts Unicode-string to ANSI-string";
	int length = WideCharToMultiByte(CP_ACP /*ANSI code page*/, 0, buffer, -1, NULL, 0, 0, 0);
	char *ptr = new char[length];
	WideCharToMultiByte(CP_ACP, 0, buffer, -1, ptr, length, 0, 0);

/* BASICS
	BOOL 4
	BYTE 1
	COLORREF 4
	DWORD 4
	HANDLE 4
	HBITMAP rasterImg
	HBRUSH paintBrush
	HCURSOR cursor
	HDC device
	HFONT fontFace
	HICON icon
	HINSTANCE program
	HMENU menu
	HWND window
	INT 4
	LONG 4
	LPARAM 4
	LPCSTR 4 constStr
	LPCWSTR 4 constUnicodeStr
	LPSTR 4 str
	LPWSTR 4 unicodeStr
	LRESULT returnedLONG
	UINT 4
	WORD 2
	WPARAM 4
	*/
	WNDCLASSEX win(size,style,windowProcedurePointer,extraBytes,extraBytes2,programSample,icon,cursor,background,menuName,pointerWindowClass,smallButton);
	LoadIcon(programSample,nameOfIcon)//if first is null, than sec is one of those: IDI_APPLICATION(def), IDI_ASTERISK(info), IDI_EXCLAMATION(!)), IDI_hand(stop), IDI_QUESTION(?)
	LoadCursor(programSample,name)//IDC_ARROW(pointer), IDC_CROSS(x), IDC_IBEAM, IDC_WAIT(wait), IDC_HELP(?), IDC_SIZEALL(4side)
	CreateWindowsEx(extended,exStyle,title/*unicode*/,style,x,y,w,h,parrent,main,programSample,additionalInfo);
	//exStyle - WS_EX_ACCEPTFILES,WS_EX_CLIENTENGE(smallRound),WS_EX_CONTROLPARENT(tab allowing),WS_EX_MDICHILD(child),WS_EX_STATICCEDGE(3D),WS_EX_TOOLWINDOW(tools),WS_EX_TRANSPENT,WS_EX_WINDOWEDGE
	//style- WS_OVERLAPPED(def), WS_MAXIMIZEBOX(maxBut), WS_MINIMIZEBOX, WS_SYSMENU(withSusMenu), WS_HSCROLL, WS_VSCROLL
	ShowWindow(programSample,/*SW_HIDE,SW_MAXIMIZE,SW_MINIMIZE,SW_SHOW,SW_RESTORE*/);

	#include <windows.h>
	#include <tchar.h>
	INT WINAPI _tWinMain(HINSTANCE hInst, HINSTANCE hPrevInst, LPTSTR lpszCmdLine, int nCmdShow){}

	MessageBox(programSample/*0*/,ltext,ltitle,type);
	//type - MB_OK,MB_OKCZNCEL,MB_RETRYCANCEL,MB_YESNO,MB_YESNOCANCEL
	//to add icon, u need to combine than value with tone of those (|) - MB_ICONEXCELAMATION(!), MB_ICONINFORMATION(i), MB_ICONQUESTION(?), MB_ICONSTOPP(x)
	//return values: IDOK,IDCANCEL,IDABORT,IDIGNORE,IDYES,IDNO,IDRETRY,0(error on creating)

/* MOUSE
	WM_MOUSE - mouse is moving inside winidws
	WM_LBUTTONDOWN
	WM_MBUTTONDOWN
	WM_RBUTTONDOWN
	WM_LBUTTONUP
	WM_MBUTTONUP
	WM_RBUTTONUP
	WM_LBUTTONDBLCLK
	WM_MBUTTONDBLCLK
	WM_RBUTTONDBLCLK
	WM_MOUSEWHEEL
	lParam- xy of mouse */
	WORD LOWORD(DWORD dwValue) //return x
	WORD HIWORD(DWORD dwValue) //return y
	//DB clicks will be registered only if window has CS_DBLCLKS flag.
	DWORD SetClassLong(
		HWND hWnd,//window descriptor
		int nIndex,//What to change: GCL_STYLE GCL_HICON GCL_HCURSOR
		LONG dwNewLong//new value
	);
	DWORD GetClassLong(
		HWND hWnd,//window descriptor
	int nIndex //name
	);

	//enebling dbclicks
	UINT style = GetClassLong(hWnd, GCL_STYLE);
	SetClassLong(hWnd, GCL_STYLE, style | CS_DBLCLKS);

	BOOL SetWindowText (//change title
		HWND hWnd,//window descriptor
		LPCTSTR lpString //new text
	);

/* TIMER */
	//UINT timerId
	UINT SetTimer(hwnd,timerId,microLength,functionController);
	BOOL KillTimer(hwnd,timerId);
	//WM_TIMER - listen for this. wp = timerId

/* WINDOWS */
	typedef struct tagRECT{
		LONG left;
		LONG top;
		LONG right;
		LONG bottom;
	} RECT;
	GetWindowRect(hwnd,rectStructointer);
	GetClientRect(hwnd,rectStructointer);
	MoveWindow(hwnd,x,y,width,height,bool needForEmidiateRepaint);
	BringWindodToTop(hwnd);
	HWND FindWindow(nameOfClass,title);
	FindWindowEx(hwnd,hwndChildAfter/*0 to start seaching from start*/,nameOfClass,title);

/* MODAL & MODALESS */
	//modal
	#include <windows.h>
	#include <tchar.h>
	#include "resource.h"
	BOOL CALLBACK DlgProc(HWND, UINT, WPARAM, LPARAM);
	int WINAPI _tWinMain(HINSTANCE hInstance, HINSTANCE hPrevInst, LPTSTR lpszCmdLine, int nCmdShow){
		return DialogBox(hInstance, MAKEINTRESOURCE(IDD_DIALOG1), NULL,       DlgProc);
	}
	BOOL CALLBACK DlgProc(HWND hWnd, UINT message, WPARAM wp, LPARAM lp){
		switch(message){
			case WM_CLOSE:
				EndDialog(hWnd, 0);
				return TRUE;
		}
		return FALSE;
	}

	//modaless
	#include <windows.h>
	#include <tchar.h>
	#include "resource.h"
	BOOL CALLBACK DlgProc(HWND, UINT, WPARAM, LPARAM);
	int WINAPI _tWinMain(HINSTANCE hInst, HINSTANCE hPrev, LPTSTR lpszCmdLine,int nCmdShow){
		MSG msg;
		HWND hDialog = CreateDialog(hInst, MAKEINTRESOURCE(IDD_DIALOG1), NULL,       DlgProc);
		ShowWindow(hDialog, nCmdShow);
		while(GetMessage(&msg, 0, 0, 0)){
			TranslateMessage(&msg);
			DispatchMessage(&msg);
		}
		return msg.wParam;
	}
	BOOL CALLBACK DlgProc(HWND hWnd, UINT mes, WPARAM wp/*id*/, LPARAM lp){
		switch(mes){
			case WM_CLOSE:
				DestroyWindow(hWnd);
				PostQuitMessage(0);
				return TRUE;
		}
		return FALSE;
	}

	HWND GetDlgItem(HWND hDlg/*dialog window*/,int nIDDlgItem/*id of el*/);//get hwnd of element
	int GetDlgCtrlID(HWND hwndCtrl);//reversed
	BOOL EnableWindow(HWND hWnd,BOOL bEnable);
	//ctrl+alt+x - toolbox
	//Button,Check Box,Radio Button,List Box,Edit Control,Combo Box,Static Text,Scroll Bar,Group Box
	//PictureCtrl, Static Text - staic control elements
	SetWindowText(hwnd,L"Text");
	//WM_COMMAND
	//WM_INITDIALOG
	MAKEINTRESOURCE(IDD_DIALOG1) //transforms into resource

/* CHECKBOX */
	BOOL CheckDlgButton(HWND,int bId,BST_CHECKED/*BST_UNCHECKED*/);
	BOOL IsDlgButtonChecked(HWND,int bId);
	HWND h = CreateWindowEx(0, L"BUTTON",L"CheckBox", WS_CHILD | WS_VISIBLE | BS_AUTOCHECKBOX, LEFT, TOP, WIDTH, HEIGHT, hWnd, 0, GetModuleHandle(NULL), 0);//create checkbox
	BOOL CheckRadioButton(HWND,int firstId,last,cur);
	SendDlgItemMessage(hWnd/*dialog*/,radioId,BST_CHECKED/*BST_UNCHECKED*/,wParam,lParam);
	HWND hRadio = CreateWindowEx(0, TEXT("BUTTON"), TEXT("RadioButton"),WS_CHILD | WS_VISIBLE |  BS_AUTORADIOBUTTON, LEFT, TOP + i*20, WIDTH, HEIGHT, hWnd, 0, GetModuleHandle(0), 0);//create radio

/*EDIT CONTROL */
	SendMessage(hWnd,message,wParam,lParam);

	/*CODE           WPARAM  LPARAM   DESCRIPTION
	EM_SETSEL        iStart  iEnd     Select text
	EM_GETSEL        &iStart &iEnd    Get start and end of selection
	WM_CLEAR         0       0        Delete selected text
	WM_CUT           0       0        Cut selected text
	WM_COPY          0       0        Copy selected text
	WM_PASTE         0       0        Paste text to place where cursor is located 
	EM_CANUNDO       0       0        Can undo?
	WM_UNDO          0       0        Undo
	WM_GETTEXT       nMax    szBuffer Copy text into szBuffer
	EM_GETLINECOUNT  0       0        Get total line count
	EM_LINELENGTH    iLine   0        Get length of iLine
	EM_GETLINE       iLine   szBuffer Copy iLine into szBuffer
	EM_LINEFROMCHAR  -1      0        Get line number where cursor is located
	EM_LINEINDEX     iLine   0        get number of first symbol in iLine
	WM_GETTEXTLENGTH 0       0        get line length

	Switch cases (messages)
	CODE          DESCRIPTION
	EN_SETFOCUS   Window recived focus
	EN_KILLFOCUS  Window losed focus
	EN_UPDATE     Content wil be changed 
	EN_CHANGE     Content has changed
	EN_ERRSPACE   Buffer overflow*/

/* LIST BOX
	properties: selection, border, sort, vertical scroll, multicolumn, horizontal scroll

	Messages:
	CODE                  WPARAM         LPARAM       DESCRIPTION
	LB_ADDSTRING          0              szString     Add szString into list box
	LB_FINDSTRING         iStart         szString     Seach str that starts from szString from iStart+1 (-1 > 0)
	LB_GETCURSEL          0              0            Get index of selected item
	LB_GETSELCOUNT        0              0            Get count of selected items
	LB_GETSELITEMS        nMax           pBuf         Fill arr pBuf with indexes of selected items no more than nMax
	LB_INSERTSTRING       iIndex         szString     Insert szString after iIndex
	LB_SELECTSTRING       iStart         szString     Find and select
	LB_SETSEL             wParam         iIndex       Set iIndex select to @wParam. if lparam -1 > apply to all
	LB_GETTEXT            iIndex         szString     Copy iIndex line into szString
	LB_DELETESTRING       iIndex         0            Delete iIndex
	LB_GETCOUNT           0              0            Get count
	LB_GETTEXTLEN         iIndex         0            Get len
	LB_RESETCONTENT       0              0            Delete all from list box
	LB_SETCURSEL          iIndex         0            Select el (for one selectable)
	LB_SETITEMDATA        iIndex         nValue       Set nValue associated to iIndex
	LB_GETITEMDATA        iIndex         0            Get nValue of iIndex

	on edit: WM_COMMAND; LOWORD id of list; HIWORD code of message; lParam hWnd of list

	HIWORD:
	CODE          DESCRIPTION
	LBN_SETFOCUS		list gained focus
	LBN_KILLFOCUS list losed focus
	LBN_SELCHANGE changed
	LBN_DBLCLK    was db click (if property notify = 0)
	LBN_ERRSPACE  memory overflow */

/* COMBO BOX
	STYLE PROPERTY   DESC
	Simple           combined open list
	Dropdown         Simple with dropdown button
	Drop List        Dropdown, closed by def

	LIST BOX MESSAGES    	COMBO BOX ANALOGS
	EM_GETSEL             CB_GETEDITSEL
	EM_SETSEL             CB_SETEDITSEL
	LB_ADDSTRING          CB_ADDSTRING
	LB_DELETESTRING       CB_DELETESTRING
	LB_GETCOUNT           CB_GETCOUNT
	LB_GETCURSEL          CB_GETCURSEL
	LB_GETTEXT            CB_GETLBTEXT
	LB_SETCURSEL          CB_SETCURSEL

	LIST BOX CODES                COMBO BOX ANALOGS
	EN_SETFOCUS, LBN_SETFOCUS     CBN_SETFOCUS
	EN_KILLFOCUS, LBN_KILLFOCUS   CBN_KILLFOCUS
	EN_UPDATE                     CBN_EDITUPDATE
	EN_CHANGE                     CBN_EDITCHANGE
	EN_ERRSPACE, LBN_ERRSPACE     CBN_ERRSPACE
	LBN_SELCHANGE                 CBN_SELCHANGE */

/* CUSTOM CONTROL ELEMENTS
	Toolbar,Tooltip,Progress Bar,Spin Control,Status Bar are in dynamic lib comctl32.dll
	Will send WM_NOTIFY instead of WM_COMMAND */

	InitCommonControlsEx(LPINITCOMMONCONTROLSEX lpInitCtrls);
	typedef struct tagINITCOMMONCONTROLSEX { 
	DWORD dwSize;//size in bytes
	DWORD dwICC; // flags for DLL loads 
	}/*

	FLAGS FOR DLL           LOADED CLASSES
	ICC_ANIMATE_CLASS       animate
	ICC_BAR_CLASSES         toolbar, status bar, slider, tooltip
	ICC_LISTVIEW_CLASSES    list view, header
	ICC_PROGRESS_CLASS      progress bar
	ICC_TAB_CLASSES         tab, tooltip
	ICC_TREEVIEW_CLASSES    tree view, tooltip
	ICC_UPDOWN_CLASS        up-down
	ICC_WIN95_CLASSES       animate, header, hot key, list view, progress bar, status bar, tab, tooltip, toolbar, slider, tree view, up-down

	*/#pragma comment(lib,"comctl32")//add this line for comctl32.dll to be connected to program
	#include <comctl32>//if not found, than include commctrl.h

	int WINAPI _tWinMain(HINSTANCE hInst, HINSTANCE hPrev, LPTSTR lpszCmdLine, int nCmdShow){
		INITCOMMONCONTROLSEX icc = {sizeof(INITCOMMONCONTROLSEX)};
		icc.dwICC = ICC_WIN95_CLASSES;
		InitCommonControlsEx(&icc);
		return DialogBox(hInst, MAKEINTRESOURCE(IDD_DIALOG1), NULL, DlgProc);
	}/*sample win main

	Progress Control === Progress Bar
	Paramethers: Vertical,Smooth

	SENDMESSAGE CODES   WP          LP                         DESCRIPTION
	PBM_SETRANGE        0           MAKELPARAM (wMin, wMax)    setRange
	PBM_SETPOS          nNewPos     0                          setProggres
	PBM_DELTAPOS        nInc        0                          append pistion with nInc
	PBM_SETSTEP         nStepInc    0                          how many add in one step
	PBM_STEPIT          0           0                          reset progress bar to deafult position
	PBM_SETBARCOLOR     0           (COLORREF) clrBar          bg for filling rectangles
	PBM_SETBKCOLOR      0           (COLORREF) clrBk           set bk color */