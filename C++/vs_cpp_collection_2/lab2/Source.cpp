#include <iostream>
using namespace std;
void main() {
	int i = 0, ii = 0, size, maxx = 0, maxy = 0;
	cin >> size;
	int ** a = new int*[size];
	for (; i<size; i++) {
		a[i] = new int[size];
		for (ii = 0; ii<size; ii++) {
			cout << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if (a[i][ii]>a[maxx][maxy]) {
				maxx = i;
				maxy = ii;
			}
		}
	}
	for (ii = 0; ii<size; ii++)
		swap(a[maxx][ii], a[0][ii]);
	for (i = 0; i<size; i++)
		for (ii = 0; ii<size; ii++)
			cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii];
}


/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,maxx=0,maxy=0,a[7][4];
	for(;i<7;i++){
		for(ii=0;ii<4;ii++){
			cout << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(a[i][ii]>a[maxx][maxy]){
				maxx=i;
				maxy=ii;
			}
		}
	}
	for(ii=0;ii<4;ii++)
		swap(a[maxx][ii],a[0][ii]);
	for(i=0;i<7;i++)
		for(ii=0;ii<4;ii++)
			cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii];
}*/


/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,size,average=0;
	cin >> size;
	int ** a = new int*[size];
	for(;i<size;i++){
		a[i] = new int[size];
		for(ii=0;ii<size;ii++){
			cout << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			average+=a[i][ii];
		}
	}
	for(i=0;i<size;i++)
		for(ii=0;ii<size;ii++)
			cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii] << " : " << a[i][ii]-average/(size*size);
}*/

/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,size;
	cin >> size;
	int ** a = new int*[size];
	int * average = new int[size];
	for(;i<size;i++){
		average[i]=0;
		a[i] = new int[size];
		for(ii=0;ii<size;ii++){
			cout << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			average[i]+=a[i][ii];
		}
	}
	for(i=0;i<size;i++)
		for(ii=0;ii<size;ii++)
			cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii] << " : " << a[i][ii]-average[i]/size;
}*/


/*
#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,size,average=0;
	cin >> size;
	int ** a = new int*[size];
	for(;i<size;i++){
		a[i] = new int[size];
		for(ii=0;ii<size;ii++){
			cout << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			average+=a[i][ii];
		}
	}
	for(i=0;i<size;i++){
		for(ii=0;ii<size;ii++){
		if(a[i][ii]<0)
			a[i][ii]=average/(size*size);
		cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii];
		}
	}
}
*/

/*
#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,a[6][7]={0};
	for(;i<6;i++){
		for(ii=0;ii<6;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			a[i][6]+=a[i][ii];
		}
	}
	for(i=0;i<6;i++)
		for(ii=0;ii<6;ii++)
			if(a[i][ii]>a[i][6]-a[i][ii])
				cout << "[" << i << "][" << ii << "]  ";
}
*/

/*
#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,c1,c2,count=0,a[4][5];
	cin >> c1 >> c2;
	for(;i<4;i++){
		for(ii=0;ii<5;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(a[i][ii]>=c1 && a[i][ii]<=c2){}else
				count++;
		}
	}
	cout << endl << count << endl;
}
*/

/*
#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,size,count=0,buf=0;
	cin >> size;
	int ** a = new int*[size];
	for(;i<size;i++){
		a[i] = new int[size];
		for(ii=0;ii<size;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(ii>buf && a[i][ii]%2==0)
				count++;
		}
		buf++;
	}
	cout << endl << count << endl;
}
*/

/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,sizex,sizey,minx=0,miny=0;
	cin >> sizex >> sizey;
	int ** a = new int*[sizex];
	for(;i<sizex;i++){
		a[i] = new int[sizey];
		for(ii=0;ii<sizey;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(a[i][ii]<a[minx][miny]){
				minx=i;
				miny=ii;
			}
		}
	}
	cout << endl << "a[" << minx << "][" << miny << "] >> " << a[minx][miny] << endl;
}*/

/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,sizex,sizey,maxx=0,maxy=0;
	cin >> sizex >> sizey;
	int ** a = new int*[sizex];
	for(i=0;i<sizex;i++){
		a[i] = new int[sizey];
		for(ii=0;ii<sizey;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(a[i][ii]>a[maxx][maxy]){
				maxx=i;
				maxy=ii;
			}
		}
	}
	for(i=0;i<sizex;i++){
		for(ii=0;ii<sizey;ii++){
			if(a[i][ii]<0)
				a[i][ii]=a[maxx][maxy];
			cout << endl << "a[" << i << "][" << ii << "] >> " << a[i][ii];
		}
	}
}*/

/*#include <iostream>
using namespace std;
void main(){
	int i=0,ii=0,size,sum=0,buf=0;
	cin >> size;
	int ** a = new int*[size];
	for(;i<size;i++)
		a[i] = new int[size];
	for(i=0;i<size;i++){
		for(ii=0;ii<size;ii++){
			cout << endl << "a[" << i << "][" << ii << "] >> ";
			cin >> a[i][ii];
			if(ii<buf)
				sum+=a[i][ii];
		}
		buf++;
	}
	cout << endl << sum << endl;
}*/