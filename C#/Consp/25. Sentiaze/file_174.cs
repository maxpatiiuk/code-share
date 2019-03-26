//Serializable
[Serializable]

using System.Runtime.Serialization.Formatters.Binary;
using System.Runtime.Serialization;

class A {
	public int b = 2;
	[NonSerialized]
	public stirng buf = "temp";

	public overrride string ToString(){
		return "someStr";
	}
}

Auto A = new Auto(100, 350, "Opel");
FileStream FS = new FileStream("auto.dat", FileMode.Create,FileAccess.ReadWrite);

BinaryFormatter BF = new BinaryFormatter();
BF.Serialize(FS, A);

FS.Seek(0, SeekOrigin.Begin);
Auto B = (Auto)BF.Deserialize(FS);
FS.Close();


//save into file
className objName = new className();
FileStream FS = new FileStream("choco.dat", FileMode.Create,FileAccess.Write);
BinaryFormatter BF = new BinaryFormatter();
BF.Serialize(FS, objName);
FS.Close();

className newObjName = null;
FS = new FileStream("choco.dat", FileMode.Open, FileAccess.Read);
newObjName = (className)BF.Deserialize(FS);
FS.Close();



//save onto ram
className objName = new className();
MemoryStream MS = new MemoryStream();
BinaryFormatter BF = new BinaryFormatter();
BF.Serialize(MS, objName);

MS.Seek(0, SeekOrigin.Begin);
className newObjName = null;
newObjName = (className)BF.Deserialize(MS);
MS.Close();


//old way
className objName = new className();
FileStream FS = new FileStream("choco.xml", FileMode.Create,
FileAccess.ReadWrite);
SoapFormatter SF = new SoapFormatter();
SF.Serialize(FS, objName);

FS.Seek(0, SeekOrigin.Begin);
className newObjName = null;
newObjName = (className)SF.Deserialize(FS);
FS.Close();



using System.Xml.Serialization;

Person person = new Person("Tom", 29);
XmlSerializer formatter = new XmlSerializer(typeof(Person));
using (FileStream fs = new FileStream("persons.xml", FileMode.OpenOrCreate)){
}

using (FileStream fs = new FileStream("persons.xml", FileMode.OpenOrCreate)){
	Person newPerson = (Person)formatter.Deserialize(fs);
}



//array into xml
Person person1 = new Person("Tom", 29, new Company("Microsoft"));
Person person2 = new Person("Bill", 25, new Company("Apple"));
Person[] persons = new Person[] { person1, person2 };
XmlSerializer formatter = new XmlSerializer(typeof(Person[]));
using (FileStream fs = new FileStream("persons.xml", FileMode.OpenOrCreate)){
	formatter.Serialize(fs, persons);
}
using (FileStream fs = new FileStream("persons.xml", FileMode.OpenOrCreate)){
	Person[] newPersons = (Person[])formatter.Deserialize(fs);
	foreach (Person p in newPersons){
		Console.WriteLine(p.Name + " " + p.Age + " " + p.Company.Name);
}