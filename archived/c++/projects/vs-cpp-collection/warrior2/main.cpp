#include <iostream>
#include <time.h>

using namespace std;

class warriors {
	char *name;
	float health,damage,armor;
	bool canDoHeadShot, canHealHimself, canDoubleHit;
public:
	warriors(int vh=0, int vd=0, int va=0, bool b1=0, bool b2=0, bool b3=0): health(vh), damage(vd), armor(va), canDoHeadShot(b1), canHealHimself(b2), canDoubleHit(b3) {}
	warriors(const warriors &w): health(w.health), damage(w.damage), armor(w.armor) {}
	float getHealth();
	float getDamage();
	float getArmor();
	char *getName();
	void setHealth(float);
	void setDamage(float);
	void setArmor(float);
	float damagging(warriors &);
};

class Elf: public warriors {
public:
	Elf(int vh=0, int vd=0, int va=0, bool b1=1, bool b2=1, bool b3=0): warriors(vh, vd, va, b1, b2, b3){}
};
class Goblin: public warriors {
public:
	Goblin(int vh=0, int vd=0, int va=0, bool b1=0, bool b2=1, bool b3=1): warriors(vh, vd, va, b1, b2, b3){}
};
class Wiking: public warriors {
public:
	Wiking(int vh=0, int vd=0, int va=0, bool b1=1, bool b2=0, bool b3=1): warriors(vh, vd, va, b1, b2, b3){}
};

float warriors::damagging(warriors &vic){
	float hit,multiplyer;
	bool buf1=rand()%2, buf2=rand()%2, buf3=rand()%2;
	multiplyer=(100.0+rand()%70-35.0)/100.0;
	if(canDoHeadShot==1 && buf1)
		multiplyer*=1.5;
	if(canHealHimself==1 && buf2)
		setHealth(getHealth()*1.05);
	hit=(getDamage()*multiplyer)*(1-vic.getArmor()/100);
	if(canDoubleHit==1 && buf3)
		hit*=1.5;
	vic.setHealth(vic.getHealth()-hit);
	if(multiplyer>1.5)
		cout << "Critical strike!" << endl;
	return hit;
}
float warriors::getHealth(){
	return health;
}
float warriors::getDamage(){
	return damage;
}
float warriors::getArmor(){
	return armor;
}
char* warriors::getName(){
	return name;
}
void warriors::setHealth(float value){
	health = value;
}
void warriors::setDamage(float value){
	damage = value;
}
void warriors::setArmor(float value){
	armor = value;
}
void round(warriors &first, warriors &second, warriors &third){
	int rand1 = rand()%3, rand2 = rand()%3;
	while(rand1!=rand2)
		rand2=rand()%3;
	warriors *buf = new warriors;
	if(rand2==1)
		buf = &first;
	else if(rand2==2)
		buf = &second;
	else
		buf = &third;
	if(rand1==0)
		float hit = first.damagging(*buf);
	else if(rand1==1)
		float hit = second.damagging(*buf);
	else
		float hit = third.damagging(*buf);
	cout << "Elf: " << first.getHealth() << endl;
	cout << "Goblin: " << second.getHealth() << endl;
	cout << "Wiking: " << third.getHealth() << endl;
	_sleep(200);
	if(first.getHealth()<0){
		cout << "Elf died!" << endl;
		system("pause");
		exit(0);
	}
	else if(second.getHealth()<0){
		cout << "Goblin died!" << endl;
		system("pause");
		exit(0);
	}
	else if(third.getHealth()<0){
		cout << "Wiking died!" << endl;
		system("pause");
		exit(0);
	}
}

int main(){
	srand(time(0));
	warriors *first,*second,*third;
	first = new Elf(rand()%50+100, rand()%5+10, rand()%20+10);
	second = new Goblin(rand()%50+100, rand()%5+10, rand()%20+10);
	third = new Wiking(rand()%50+100, rand()%5+10, rand()%20+10);
	while(1)
		round(*first,*second,*third);
	return 0;
}