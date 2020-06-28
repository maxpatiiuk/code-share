#include <iostream>
class Aspirant{
protected:
	int idOfWork;
	int timeLimit;
public:
	Aspirant(int v1=0, int v2){
		idOfWork=v1;
		timeLimit=v2;
	}
};
class Student: public Aspirant{
	int id;
	double averagePoint;
public:
	Student(int v1,int v2, int v3, double v4): Aspirant(v3,v4) {
		id=v1;
		averagePoint=v2;
	}
};

--------------------

#include <iostream>
class ForeignPassport{
protected:
	int visaId;
	int permissionsLevel;
public:
	ForeignPassport(int v1=0, int v2=0){
		visaId=v1;
		permissionsLevel=v2;
	}
};
class Passport: public ForeignPassport{
	int id;
	double unixTimeOfReg;
public:
	Passport(int v1,int v2, int v3, double v4): ForeignPassport(v3,v4) {
		id=v1;
		unixTimeOfReg=v2;
	}
};