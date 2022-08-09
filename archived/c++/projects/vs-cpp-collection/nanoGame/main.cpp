#include <windows.h>
#include <tchar.h>

/*  Declare Windows procedure  */
LRESULT CALLBACK WindowProcedure (HWND, UINT, WPARAM, LPARAM);

/*  Make the class name into a global variable  */
TCHAR szClassName[] = TEXT("Program");

int WINAPI WinMain (HINSTANCE hThisInstance,
                    HINSTANCE hPrevInstance,
                    LPSTR lpCmdLine,
                    int nCmdShow)

{
    HWND hwnd;               /* This is the handle for our window */
    MSG messages;            /* Here messages to the application are saved */
    WNDCLASSEX wincl;        /* Data structure for the windowclass */

    /* The Window structure */
    wincl.hInstance = hThisInstance;
    wincl.lpszClassName = szClassName;
    wincl.lpfnWndProc = WindowProcedure;      /* This function is called by windows */
    wincl.style = CS_DBLCLKS;                 /* Catch double-clicks */
    wincl.cbSize = sizeof (WNDCLASSEX);

    /* Use default icon and mouse-pointer */
    wincl.hIcon = LoadIcon (NULL, IDI_APPLICATION);
    wincl.hIconSm = LoadIcon (NULL, IDI_APPLICATION);
    wincl.hCursor = LoadCursor (NULL, IDC_ARROW);
    wincl.lpszMenuName = NULL;                 /* No menu */
    wincl.cbClsExtra = 0;                      /* No extra bytes after the window class */
    wincl.cbWndExtra = 0;                      /* structure or the window instance */
    /* Use Windows's default color as the background of the window */
    wincl.hbrBackground = (HBRUSH) COLOR_BACKGROUND;

    /* Register the window class, and if it fails quit the program */
    if (!RegisterClassEx (&wincl))
        return 0;

    /* The class is registered, let's create the program*/
    hwnd = CreateWindowEx (
           0,                   /* Extended possibilites for variation */
           wincl.lpszClassName,         /* Classname */
           TEXT("Program"),       /* Title Text */
           WS_OVERLAPPEDWINDOW, /* default window */
           CW_USEDEFAULT,       /* Windows decides the position */
           CW_USEDEFAULT,       /* where the window ends up on the screen */
           544,                 /* The programs width */
           375,                 /* and height in pixels */
           HWND_DESKTOP,        /* The window is a child-window to desktop */
           NULL,                /* No menu */
           hThisInstance,       /* Program Instance handler */
           NULL                 /* No Window Creation data */
           );

    /* Make the window visible on the screen */
    ShowWindow (hwnd, nCmdShow);

    /* Run the message loop. It will run until GetMessage() returns 0 */
    while (GetMessage (&messages, NULL, 0, 0))
    {
        /* Translate virtual-key messages into character messages */
        TranslateMessage(&messages);
        /* Send message to WindowProcedure */
        DispatchMessage(&messages);
    }

    /* The program return-value is 0 - The value that PostQuitMessage() gave */
    return messages.wParam;
}


/*  This function is called by the Windows function DispatchMessage()  */
LRESULT CALLBACK WindowProcedure (HWND hwnd, UINT message, WPARAM wParam, LPARAM lParam)
{
  tagRECT position;
  GetWindowRect(hwnd,&position);

/*  RECT r;
  GetWindowRect(&r);

  CWindow okB(GetDlgItem(IDOK));
  RECT okR;
  okB.GetWindowRect(&okR);
*/
  MessageBox(hwnd,NULL,L"Catch the button",MB_OK);
  //HWND dialog = FindWindow("#32770", "Catch the button");
  HWND dialog = FindWindowEx(hwnd,0,L"#32770",L"Catch the button");
  /*char WndName[50];
  GetWindowText(hwnd, WndName, 50);
  if(!strcmp(WndName, "Catch the button"))
  {
  // Do whatever you want to the MessageBox (eg: close it)
  PostMessage(hwnd, WM_CLOSE, 0, 0);
  // Return FALSE to end search
  return FALSE;*/

	const int MOVE_BY_IN_ONE_RUN = 10;
    switch (message)                  /* handle the messages */
    {
		case WM_LBUTTONDOWN:
			MoveWindow(dialog,position.left+MOVE_BY_IN_ONE_RUN ,position.top,position.right-position.left,position.bottom-position.top,true);
			break;
		case WM_RBUTTONDOWN:
			MoveWindow(dialog,position.left-MOVE_BY_IN_ONE_RUN ,position.top,position.right-position.left,position.bottom-position.top,true);
			break;
        case WM_DESTROY:
            PostQuitMessage (0);       /* send a WM_QUIT to the message queue */
            break;
        default:                      /* for messages that we don't deal with */
            return DefWindowProc (dialog, message, wParam, lParam);
    }
    return 0;
}