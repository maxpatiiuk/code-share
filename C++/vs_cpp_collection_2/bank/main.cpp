#include <iostream>

using namespace std;


namespace atm{

	namespace a {
		class account{
			int balance,pin;
			unsigned __int64 number;
		public:
			account(int iBalance, unsigned __int64 iNumber, int iPin):balance(iBalance),number(iNumber),pin(iPin){}
			account(const account &buf){
				balance = buf.balance;
				number = buf.number;
				pin=buf.pin;
			}
			~account(){};
			int getBalance(){
				return balance;
			}
			int getPin(){
				return pin;
			}
			unsigned __int64 getNumber(){
				return number;
			}
			void setBalance(int iBalance){
				balance = iBalance;
			}
		};
	}

	namespace u {
		class user: public a::account{
		public:
			user(int iBalance, unsigned __int64 iNumber, int iPin):a::account(iBalance,iNumber,iPin){}
		};
	}
	
	namespace b {
		class bank{
		public:
			void withdraw(u::user*,int);
			void deposit(u::user*,int);
			bank(){}
		};
		void bank::withdraw(u::user* buf,int sum){
			if(buf->getBalance()>sum){
				cout << "Success" << endl;
				buf->setBalance(buf->getBalance()-sum);
			}
			else
				cout << "Not enough money" << endl;
		}
		void bank::deposit(u::user* buf,int sum){
			cout << "Success" << endl;
			buf->setBalance(buf->getBalance()+sum);
		}
	}

}

bool correct(unsigned __int64 val){
	int i=0;
	for(;val!=0;i++,val/=10){}
	return i==16;
}

using namespace atm;
using namespace a;
using namespace b;
using namespace u;
void menu(){
	int i,buf2=3;
	unsigned __int64 buf;
	cout << "Enter PIN and number" << endl;
	cin >> i >> buf;
	if(!correct(buf)){
		cout << "Invalid card number" << endl;
		system("pause");
		exit(0);
	}
	user mainUser(0,buf,i);
	bank mainBank;
	cout << "Now, you need to log in\nInput your PIN and card number\n";
logIn:
	cin >> i >> buf;
	if(mainUser.getPin()!=i || mainUser.getNumber()!=buf){
		cout << "PIN or card nubmer is incorect. " << --buf2 << " attempts left" << endl;
		if(buf2==0){
			system("pause");
			exit(0);
		}
		goto logIn;
	}
	while (1) {
		system("CLS");
		cout << "1. Get balance" << endl;
		cout << "2. Deposit" << endl;
		cout << "3. Withdraw" << endl;
		cout << "0. Exit" << endl;
		cin >> i;
		system("CLS");
		switch (i) {
			case 1:
				cout << mainUser.getBalance() << endl;
				break;
			case 2:
				cout << "How many?" << endl;
				cin >> i;
				mainBank.deposit(&mainUser,i);
				break;
			case 3:
				cout << "How many?" << endl;
				cin >> i;
				mainBank.withdraw(&mainUser,i);
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

void main() {
	menu();
}