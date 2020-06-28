#include <iostream>
using namespace std;

class Cell{
	int col,row;
	char data;
public:
	Cell() : col(1),row(1),data(1) {}
	Cell(int icol, int irow, char idata) : col(icol),row(irow),data(idata) {}
	Cell(const Cell &p): col(p.col),row(p.row),data(p.data){}
	~Cell() {}
	void input();
	void print() const;
	void copy(const Cell&);
	char getData() const;
	bool isEqualCoords(const Cell &p) const;
	bool isEqualCoords(int icol, int irow) const;
};
class Field{
	int size;
public:
	Cell * cells;
	void addCell(const Cell &line);
	Field(): size(0), cells(){}
	Field(const Field &p): size(p.size) {
		Field *a = new Field[p.size];
		for (int i = 0; i = p.size; i++)
			a->cells = p.cells;
	}
	~Field() {
		if(cells)
			delete []cells;
	}
	void print();
	int getSize() const;
};

void Cell::copy(const Cell &p) {
	col = p.col;
	row = p.row;
	data = p.data;
}
void Cell::input(){
	cout << "Col:" << endl;
	cin >> col;
	cout << "Row:" << endl;
	cin >> row;
	cout << "Data:" << endl;
	cin >> data;
}
void Cell::print() const {
	cout << "col: " << col << "\nrow: " << row << "\ndata: " << data << endl;
}
char Cell::getData() const {
	return data;
}
bool Cell::isEqualCoords(const Cell &p) const{
	if(col==p.col && row==p.row)
		return 1;
	else
		return 0;
}
bool Cell::isEqualCoords(int icol, int irow) const {
	if(col==icol && row==irow)
		return 1;
	else
		return 0;
}


void Field::addCell(const Cell& src){
	Cell *p = new Cell[size+1];
	for (int i = 0; i < size; i++)
		p[i].copy(cells[i]);
	p[size].copy(src);
	size++;
	delete []cells;
	cells=p;
}
int Field::getSize() const {
	return size;
}
void Field::print() {
	for (int i = 0; i < 20; i++) {
		for (int ii = 0; ii < 20; ii++) {
			for (int iii = 0; iii < getSize(); iii++) {
				if (cells[iii].isEqualCoords(i, ii)) {
					cout << cells[iii].getData();
					break;
				}
				if (iii + 1 >= getSize())
					cout << "-";
			}
		}
		cout << endl;
	}
}

void menu(){
	Field *fields = new Field;
	int i,col,row;
	while(1){
		system("CLS");
		cout << "1. Add cell" << endl;
		cout << "2. Print cell" << endl;
		cout << "3. Print all cells" << endl;
		cout << "4. Get data of cell" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				{
					Cell p;
					p.input();
					fields->addCell(p);
				}
				break;
			case 2:
				cout << "Col:" << endl;
				cin >> col;
				cout << "Row:" << endl;
				cin >> row;
				for (int i = 0; i < fields->getSize(); i++)
					if(fields->cells[i].isEqualCoords(col,row))
						fields->cells[i].print();
				break;
			case 3:
				fields->print();
				break;
			case 4:
				cout << "Col:" << endl;
				cin >> col;
				cout << "Row:" << endl;
				cin >> row;
				for (int i = 0; i < fields->getSize(); i++)
					if (fields->cells[i].isEqualCoords(col, row))
						cout << fields->cells[i].getData();
				break;
			case 0:
				exit(0);
				break;
		}
		system("pause");
		system("CLS");
	}
}

void main(){
	menu();
}