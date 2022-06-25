int **a;
a=new int*[10];
for(int i=0;i<10;i++)
	a[i]=new int[7];
cin << a[3][4];
cin << *(*(a+3)+4)