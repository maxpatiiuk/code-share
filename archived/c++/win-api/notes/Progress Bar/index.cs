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