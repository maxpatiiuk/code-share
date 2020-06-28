#include "BPI.h"

BPI::BPI(): name(new char[1]),count(0), price(0){}
BPI::BPI(char* newName,int newCount=0,double newPrice=0):name(new char[strlen(newName)]),count(newCount),value(newPrice){
	strcpy(name,newName);
}
BPI::~BPI(){
	if(name)
		delete[]name;
}
char* BPI::getName() const{
	return name;
}
int BPI::getCount() const{
	return count;
}
int BPI::getPrice() const{
	return Price;
}
void BPI::setName(char* newName){
	strcpy(name,newName);
}
void BPI::setcount(int newcount){
	count=newCount;
}
void BPI::setPrice(int newPrice){
	price=newPrice;
}
void BPI::print(){
	std::cout << name << std::endl << count << std::endl << price << std::endl;
}

Shop::Shop(): name(new char[1]),id(0),size(0),current(0){}
Shop::Shop(char* newName,int newId=0,int newSize=0):name(new char[strlen(newName)]),type(newType),size(newSize),current(0){
	strcpy(name,newName);
}
Shop::~Shop(){
	if(name)
		delete[]name;
	if(products)
		delete[]products;
}
char* Shop::getName() const{
	return name;
}
int Shop::getId() const{
	return id;
}
int Shop::getSize() const{
	return size;
}
int Shop::getCurrent() const{
	return size;
}
void Shop::setName(char* newName){
	strcpy(name,newName);
}
void Shop::setId(int newId){
	id=newId;
}
void Shop::setCurrent(int newCurrent){
	current=newCurrent;
}
void Shop::printAll(){
	for(int i=0;i<getSize();i++)
		std::cout << products.name << std::endl << count << std::endl << price << std::endl;
}