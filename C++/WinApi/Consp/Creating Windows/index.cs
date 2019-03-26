	WNDCLASSEX win(size,style,windowProcedurePointer,extraBytes,extraBytes2,programSample,icon,cursor,background,menuName,pointerWindowClass,smallButton);
	LoadIcon(programSample,nameOfIcon)//if first is null, than sec is one of those: IDI_APPLICATION(def), IDI_ASTERISK(info), IDI_EXCLAMATION(!)), IDI_hand(stop), IDI_QUESTION(?)
	LoadCursor(programSample,name)//IDC_ARROW(pointer), IDC_CROSS(x), IDC_IBEAM, IDC_WAIT(wait), IDC_HELP(?), IDC_SIZEALL(4side)
	CreateWindowsEx(extended,exStyle,title/*unicode*/,style,x,y,w,h,parrent,main,programSample,additionalInfo);
	//exStyle - WS_EX_ACCEPTFILES,WS_EX_CLIENTENGE(smallRound),WS_EX_CONTROLPARENT(tab allowing),WS_EX_MDICHILD(child),WS_EX_STATICCEDGE(3D),WS_EX_TOOLWINDOW(tools),WS_EX_TRANSPENT,WS_EX_WINDOWEDGE
	//style- WS_OVERLAPPED(def), WS_MAXIMIZEBOX(maxBut), WS_MINIMIZEBOX, WS_SYSMENU(withSusMenu), WS_HSCROLL, WS_VSCROLL
	ShowWindow(programSample,/*SW_HIDE,SW_MAXIMIZE,SW_MINIMIZE,SW_SHOW,SW_RESTORE*/);