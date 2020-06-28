/*
Створити оператори та методи розрідженого масиву, згідно шаблону.
Частина методів та операторів введено для зручності.
В результаті має відобразитись на екрані матриця, з усіма комірками.
Вмере получилось так:
##*####
#######
#######
##+####
#######
######*
*######
В прикладі створено багато "друзів" виключно для навчальних цілей
насправді це трохи зло.

struct Coord
{
    int row, col;

    Coord(int irow, int icol); // конструктор для зручності

    bool operator==(const Coord &p) const; // оператор порівняння координат
};

class Field;
class Cell
{
    friend class Field;
    friend ostream & operator<<(ostream &os, const Field &field);

    Coord coord;
    char data; // символ, що виводитиметься на екран
public:
    Cell(); // потрібен для створення динамічного масиву
    Cell(const Coord & icoord, char idata = '*');
    Cell(int irow, int icol, char idata = '*');

    bool operator==(const Cell &p) const; // оператор порівняння координат
                                          // двох комірок
};

class Field
{
    friend ostream & operator<<(ostream &os, const Field &field);

    Cell * cells;
    int size; // к-ть елементів масиву cells
public:
    Field();
    Field(const Field &field);
    ~Field();

    Field & operator<<(const Cell &cell); // добавлення комірки в масив, якщо
                                          // за даними координатами порожньо
    Cell & operator[](const Coord &coord); // знайти та повернути посилання на комірку.
                                        // з координатами. Якщо такої не існує, то добавити
                                        // в масив і повернути посилання на нову комірку
    Cell * findCellByCoord(const Coord &coord) const; // знайти комірку. Якщо порожньо, то NULL
};

ostream & operator<<(ostream &os, const Field & field){
	os << (*field.a);
	return str;
}
																												// вивести на екран поле у вигляді
                          	 // прямокутника max_col - min_col на max_row - min_row
                            // з символом '#' там, де комірки відсутні та символом з data
                            // там, де комірка існує

int main() {

    Field field;
    field << Cell(-2, 1) << Cell(1, 1, '+') << Cell(4, -1) <<
             Cell(3, 5);
    cout << field;

    return 0;
}


--------------------------------------------------------------------------------------------------------------------
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--------------------------------------------------------------------------------------------------------------------
*/

#include <iostream>
using namespace std;


struct Coord {
    int row, col;
	Coord(int irow=0, int icol=0): row(irow),col(icol){}
		bool operator==(const Coord &p) const;
	int r() const;
	void sr(int);
	int c() const;
	void sc(int);
};
class Cell{
	friend class Field;
	friend ostream & operator<<(ostream &os, const Field &field);
	Coord cor;
	char data;
public:
	Cell() : cor(0,0),data(1) {}
	Cell(int irow, int icol, char idata) : cor(irow,icol),data(idata) {}
	Cell(const Cell &p): cor(p.cor.r(),p.cor.c()),data(p.data){}
	~Cell() {}
	void input(bool);
	void print() const;
	void copy(const Cell&);
	char getData() const;
	bool operator==(const Cell&) const;
};
class Field{
	friend ostream & operator<<(ostream &os, const Field &field);
	int size;
public:
	Cell * cells;
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
	int getSize() const;
	Field & operator>>(const Cell &cell);

	Cell & operator[](const Cell &p); // знайти та повернути посилання на комірку.
	// з координатами. Якщо такої не існує, то добавити
	// в масив і повернути посилання на нову комірку
	Cell * findCellByCoord(const Coord &p) const;
};

int Coord::r() const{
	return row;
}
int Coord::c() const{
	return col;
}
void Coord::sr(int val){
	row=val;
}
void Coord::sc(int val){
	col=val;
}
bool Coord::operator==(const Coord &p) const{
	if(c()==p.c() && r()==p.r())
		return 1;
	else
		return 0;
}


bool Cell::operator==(const Cell &p) const{
	if(cor.c()==p.cor.c() && cor.r()==p.cor.r())
		return 1;
	else
		return 0;
}
void Cell::copy(const Cell &p) {
	cor.sc(p.cor.c());
	cor.sr(p.cor.r());
	data = p.data;
}
void Cell::input(bool d=1){
	int buf;
	cout << "Col:" << endl;
	cin >> buf;
	cor.sc(buf);
	cout << "Row:" << endl;
	cin >> buf;
	cor.sr(buf);
	if(d!=0){
		cout << "Data:" << endl;
		cin >> data;
	}
	else
		data=0;
}
void Cell::print() const {
	cout << "col: " << cor.c() << "\nrow: " << cor.r() << "\ndata: " << data << endl;
}
char Cell::getData() const {
	return data;
}

Cell * Field::findCellByCoord(const Coord &p) const{
	for(int i=0;i<size;i++)
		if(cells[i].cor.r()==p.r() && cells[i].cor.c()==p.c())
			return &cells[i];
	return NULL;
}
Cell & Field::operator[](const Cell &p){
	Cell*buf=findCellByCoord(p.cor);
	if(buf!=NULL)
		return	*buf;
	else {
		(*buf).cor.sc(p.cor.c());
		(*buf).cor.sr(p.cor.r());
		(*buf).data='*';
		*this >> *buf;
	}
}

ostream & operator<<(ostream &os, const Field & field){
	Coord buf;
	for (int i = 0; i < 20; i++) {
		for (int ii = 0; ii < 20; ii++) {
			for (int iii = 0; iii < field.getSize(); iii++) {
				buf.sr(i);
				buf.sc(ii);
				if (field.cells[iii].cor==buf) {
					os << field.cells[iii].getData();
					break;
				}
				if (iii + 1 >= field.getSize())
					os << "-";
			}
		}
		os << endl;
	}
	return os;
}
Field & Field::operator>>(const Cell &src){
	Cell *p = new Cell[size+1];
	for (int i = 0; i < size; i++)
		p[i].copy(cells[i]);
	p[size].copy(src);
	size++;
	delete []cells;
	cells=p;
	return *this;
}
int Field::getSize() const {
	return size;
}


void menu(){
	Field *fields = new Field;
	int i,col,row;
	Cell p;
	while(1){
		system("CLS");
		cout << "1. Add cell" << endl;
		cout << "2. Print current cell" << endl;
		cout << "3. Print all cells" << endl;
		cout << "4. Get data from this cell" << endl;
		cout << "5. Count elements" << endl;
		cout << "6. Find or get" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch(i){
			case 1:
				p.input();
				*fields >> p;
				break;
			case 2:
				(*fields).cells[(*fields).getSize()].print();
				break;
			case 3:
				cout << *fields;
				break;
			case 4:
				p.input(0);
				for (int i = 0; i < fields->getSize(); i++)
					if(fields->cells[i] == p)
						fields->cells[i].print();
				break;
			case 5:
				cout << (*fields).getSize();
				break;
			case 6:
				p.input(0);
				(*fields)[p];
				break;
			case 0:
				exit(0);
				break;
		}
		cout << endl;
		system("pause");
		system("CLS");
	}
}

void main(){
	menu();
}