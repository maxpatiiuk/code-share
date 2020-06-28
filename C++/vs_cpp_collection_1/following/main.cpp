//1. class Combined > square + circle
//2. class Auto > weels, engine, doors

#include <iostream>
class Weels{
protected:
	int count;
	double size;
public:
	Weels(int v1=4, double v2=3.4){
		count=v1;
		size=v2;
	}
};
class Engine{
protected:
	double power;
	double size;
public:
	Engine(double v1=100.2, double v2=3.4){
		power=v1;
		size=v2;
	}
};
class Doors{
protected:
	int count;
	double size;
public:
	Doors(int v1=100.2, double v2=3.4){
		count=v1;
		size=v2;
	}
};
class Auto: public Weels, public Engine, public Doors{
	int id;
	double maxSpeed;
public:
	Auto(int v1,int v2, int v3, double v4, double v5, double v6, int v7, int v8): Weels(v3,v4), Engine(v5,v6), Doors(v7,v8) {
		id=v1;
		maxSpeed=v2;
	}
};



#include <iostream>
class Square{
protected:
	int x1;
	int x2;
	int y1;
	int y2;
public:
	Square(int v1=1, int v2=1, int v3=3, int v4=3){
		x1=v1;
		y1=v2;
		x2=v3;
		y2=v4;
	}
};
class Circle{
protected:
	int cx1;
	int cx2;
	int cy1;
	int cy2;
public:
	Circle(int v1=1, int v2=1, int v3=3, int v4=3){
		cx1=v1;
		cy1=v2;
		cx2=v3;
		cy2=v4;
	}
};
class Combined: public Square, public Circle{
	int id;
	double maxSpeed;
public:
	Combined(int v1,int v2, int v3, int v4, int v5, int v6, int v7, int v8): Square(v1,v2,v3,v4), Circle(v5,v6,v7,v8) {}
	bool isCombined();
};

bool Combined::isCombined(){
	if(
		(x2+x1)/2==(cx2+cx1)/2 && (y2+y1)/2==(cy2+cy1)/2//if center of square==center of circle
		&&
		(
			(
				(x2+x1)/2==(cx2+cx1)/2
				&&
				(
					y1==cy1
					||
					y2==cy2
				)
			)
			||
			(
				(y2+y1)/2==(cy2+cy1)/2
				&&
				(
					x2==cx2
					||
					x1==cx1
				)
			)
		)
	)
		return true;
	else
		return false;
}