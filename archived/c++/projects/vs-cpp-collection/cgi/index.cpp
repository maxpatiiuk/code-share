#include <iostream>
#include <string>
#define loop(el) for(i=0;i<el;i++)

using namespace std;

int i=0,size=0;
struct books{
	string name;
	string author;
	string publisher;
	string genre;
};
books *book;

void editing(int id){
	cout << "Name: ";
	cin >> book[id].name;
	cout << "Author: ";
	cin >> book[id].author;
	cout << "Publisher: ";
	cin >> book[id].publisher;
	cout << "Genre: ";
	cin >> book[id].genre;
}
void coutElement(int id){
	cout << endl << "ID = " << i << endl;
	cout << "Name: " << book[id].name << endl;
	cout << "Author: " << book[id].author << endl;
	cout << "Publisher: " << book[id].publisher << endl;
	cout << "Genre: " << book[id].genre << endl;
}
void add(){
	editing(size);
	size++;
}
void edit(){
	string query;
	int was=0,id=0;
	cout << "Which element do you want to edit (enter name, author, publisher or genre)?\n";
	cin >> query;
	for(i=0;i<size;i++){
		if(query==book[i].name || query==book[i].author || query==book[i].publisher || query==book[i].genre){
			coutElement(i);
			id=i;
			if(was==0)
				was=1;
			else
				was=2;
		}
	}
	if(was==0)
		cout << "No elements for this seach query" << endl;
	else if(was==2){
		cout << "Enter ID of element, you want to edit: ";
		cin >> id;
		editing(id);
	}
	else
		editing(id);
}
void print(){
	for(i=0;i<size;i++)
		coutElement(i);
}
void seach(){
	string query;
	cout << "Which element do you want to seach (enter name, author, publisher or genre)?\n";
	cin >> query;
	for(i=0;i<size;i++)
		if(query==book[i].name || query==book[i].author || query==book[i].publisher || query==book[i].genre)
			coutElement(i);
}
void swapping(int i, int ii){
	swap(book[ii].name,book[i].name);
	swap(book[ii].author,book[i].author);
	swap(book[ii].publisher,book[i].publisher);
	swap(book[ii].genre,book[i].genre);
}
void sortByName(){
	for(i=1;i<size;i++)
		for(int ii=0;ii<size;ii++)
			if(book[i].name<book[ii].name)
				swapping(i,ii);
}
void sortByAuthor(){
	for(i=1;i<size;i++)
		for(int ii=0;ii<size;ii++)
			if(book[i].author<book[ii].author)
				swapping(i,ii);
}

void menu(){
	while(1){
		system("CLS");
		cout << "	1. Add book\n";
		cout << "	2. Edit book\n";
		cout << "	3. Print books\n";
		cout << "	4. Seach books\n";
		cout << "	5. Sort books by name\n";
		cout << "	6. Sort books by author\n";
		cout << "	0. Exit\n";
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				add();
				break;
			case 2:
				edit();
				break;
			case 3:
				print();
				break;
			case 4:
				seach();
				break;
			case 5:
				sortByName();
				break;
			case 6:
				sortByAuthor();
				break;
			case 0:
				exit(0);
				break;
		}
		system("pause");
	}
}

void main(){
	book = new books [100];
	menu();
}

/*
#include <iostream>
#define loop(el) for(i=0;i<el;i++)

using namespace std;
int i=0, arr[20]={0};

void reverce(int *first,int lenght){
	int *last= first+lenght;
	for(i=0;i<lenght/2 && first!=last;i++,first++,last--)
		swap(*first,*last);
}
void main(){
	loop(20){
		arr[i]=i;
		cout << arr[i] << '\t';
	}
	cout << '\n';
	reverce(&arr[0],10);
	loop(20)
		cout << arr[i] << '\t';
}
*/