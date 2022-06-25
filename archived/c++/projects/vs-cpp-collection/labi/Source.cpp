#include <iostream>
#include <string>
#include <windows.h>
#include <time.h>
#define size 10
using namespace std;
void main() {//1sp = 10000 = 4.68, 4.57, 4.59, 4,67
	srand(time(0));//2sp = 10000 = 3.7, 4.05, 4.18, 4,19
	clock_t tStart = clock();
	/*int times = size, arr[size] = { -1 }, i = 0, ii = 0;
	bool was=1;
	for (i = 0; i < times; i++, was = 1) {
		while (was == 1) {
			was = 0;
			arr[i] = rand() % size;
			for (ii = 0; ii <= i; ii++)
				if (ii!=i && arr[ii] == arr[i])
					was = 1;
		}
	}
	for (i = 0; i < size; i++)
		cout << i+1 << " >> " << arr[i]+1 << endl;*/
	int arr[size] = { -1 },i=0,ii=0;
	bool was[size] = { 0 };
	for (; i < size; i++) {
		do
			arr[i] = rand() % size;
		while (was[arr[i]]);
		was[arr[i]] = 1;
		cout << i + 1 << " >> " << arr[i] + 1 << endl;
	}
	printf("Time taken: %.2fs\n", (double)(clock() - tStart) / CLOCKS_PER_SEC);
}