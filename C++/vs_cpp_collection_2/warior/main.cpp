#include <iostream>
#include <time.h>

using namespace std;

class warriors {
	char *name;
	float health,damage,armor;
public:
	warriors(char *w, int vh=0, int vd=0, int va=0): name(new char[strlen(w)]), health(vh), damage(vd), armor(va){}
	warriors(const warriors &w): name(new char[strlen(w.name)]){
		strcpy(name,w.name);
		health=w.health;
		damage=w.damage;
		armor=w.armor;
	}
	float getHealth();
	float getDamage();
	float getArmor();
	char *getName();
	void setHealth(float);
	void setDamage(float);
	void setArmor(float);
	float damagging(warriors &);
};

float warriors::damagging(warriors &vic){
	float hit,multiplyer;
	multiplyer=(100.0+rand()%70-35.0)/100.0;
	hit=(getDamage()*multiplyer)*(1-vic.getArmor()/100);
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
void round(warriors &first, warriors &second){
	bool coin;
	coin = rand()%2;
	if(coin==0){
		if(first.getHealth()>0){
			float hit = first.damagging(second);
			cout << "First kicked Second with damage of " << hit << ". Second new health is " << second.getHealth() << endl;
		}
		if(second.getHealth()>0){
			float hit = second.damagging(first);
			cout << "Second kicked first with damage of " << hit << ". First new health is " << second.getHealth() << endl;
		}
	}
	else {
		if(second.getHealth()>0){
			float hit = second.damagging(first);
			cout << "Second kicked first with damage of " << hit << ". First new health is " << second.getHealth() << endl;
		}
		if(first.getHealth()>0){
			float hit = first.damagging(second);
			cout << "First kicked Second with damage of " << hit << ". Second new health is " << second.getHealth() << endl;
		}
	}
	cout << endl;
	_sleep(200);
	if(first.getHealth()<0){
		cout << "First died!" << endl;
		system("pause");
		exit(0);
	}
	else if(second.getHealth()<0){
		cout << "Second died!" << endl;
		system("pause");
		exit(0);
	}
}

int main(){
	warriors first("Oswald", rand()%50+100, rand()%5+10, rand()%20+10),second("Molot", rand()%50+100, rand()%5+10, rand()%20+10);
	srand(time(0));
	while(1)
		round(first,second);
	return 0;
}