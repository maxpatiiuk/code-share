/*
#include <iostream>
#include <map>
#include <string>
#include <vector>

using namespace std;

class data{
public:
	string name,surname;
	float point;
	data(){
		data("","",0);
	}
	data(string iName, string iSurname, float iPoint): name(iName), surname(iSurname), point(iPoint) {}
	data(const data &buf){
		name = buf.name;
		surname = buf.surname;
		point = buf.point;
	}
	~data(){}
};

void split(const string& s, char delim,vector<string>& v) {
	auto i = 0;
	auto pos = s.find(delim);
	while (pos != string::npos){
		v.push_back(s.substr(i, pos-i));
		i = pos++;
		pos = s.find(delim, pos);
		if (pos == string::npos)
			v.push_back(s.substr(i, s.length()));
	}
}

void main(){
	int buf,i=0;
	string line;
	multimap<int,data> student;
	cin >> buf;
	cin.ignore();
	for(;i<buf;i++){
		getline(cin,line);
		vector<string> bufVector;
		split(line,' ',bufVector);
		data dataBuf(bufVector[0],bufVector[1],(stof(bufVector[2])+stof(bufVector[3])+stof(bufVector[4]))/3);
		student.insert(student.end(),make_pair(student.size(),dataBuf));
	}
	bool was=1;
	while(was){
		was=0;
		for(i=1;i<student.size();i++){
			if(student.find(i-1)->second.point>student.find(i)->second.point){
				swap(student.find(i-1)->second.name,student.find(i)->second.name);
				swap(student.find(i-1)->second.surname,student.find(i)->second.surname);
				swap(student.find(i-1)->second.point,student.find(i)->second.point);
				was=1;
			}
		}
	}
	for(i=0;i<student.size();i++)
		cout << student.find(i)->second.name << student.find(i)->second.surname << endl;
	system("pause");
}
*/

#include <iostream>
#include <map>
#include <string>
#include <vector>

using namespace std;

class data{
public:
	string destination,departueTime;
	int id;
	/*data(){
		data("","",0);
	}*/
	data(string destination, string iDepartueTime, int iId=-1): destination(destination), departueTime(iDepartueTime), id(iId) {}
	/*data(const data &buf){
		destination = buf.destination;
		departueTime = buf.departueTime;
	}
	~data(){}*/
};

void split(const string& s, char delim,vector<string>& v) {
	auto i = 0;
	auto pos = s.find(delim);
	while (pos != string::npos){
		v.push_back(s.substr(i, pos-i));
		i = pos++;
		pos = s.find(delim, pos);
		if (pos == string::npos)
			v.push_back(s.substr(i, s.length()));
	}
}

void main(){
	int buf,i=0;
	string line;
	multimap<int,data> student;
	vector<data> bufVector2;
	cin >> buf;
	cin.ignore();
	for(;i<buf;i++){
		getline(cin,line);
		vector<string> bufVector;
		split(line,' ',bufVector);
		data dataBuf(bufVector[1],bufVector[2],stoi(bufVector[0]));
		student.insert(make_pair(stoi(bufVector[0]),dataBuf));
	}
	bool was=1;
	for(i=1;i<student.size()+1;i++)
		cout << student.find(i)->first << student.find(i)->second.destination << student.find(i)->second.departueTime << endl;
	line.clear();
	while(1){
		getline(cin,line);
		if(strcmp(line.c_str(),"0")==0)
			exit(0);
		system("CLS");
		line.insert(0,1,' ');
		for(i=1;i<student.size()+1;i++){
			if(strcmp(student.find(i)->second.destination.c_str(),line.c_str())==0){
				student.find(i)->second.id=i;
				bufVector2.insert(bufVector2.end(),student.find(i)->second);
			}
		}
		while(was){
			was=0;
			for(i=1;i<bufVector2.size();i++){
				if(strcmp(bufVector2[i-1].departueTime.c_str(),bufVector2[i].departueTime.c_str())<0){
					swap(bufVector2[i-1].id,bufVector2[i].id);
					swap(bufVector2[i-1].destination,bufVector2[i].destination);
					swap(bufVector2[i-1].departueTime,bufVector2[i].departueTime);
					was=1;
				}
			}
		}
		for(i=0;i<bufVector2.size();i++)
			cout << bufVector2[i].id << bufVector2[i].destination << bufVector2[i].departueTime << endl;
		bufVector2.clear();
		system("pause");
		system("CLS");
	}
	system("pause");
}