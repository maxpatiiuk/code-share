//INTERFACES
//can have objects
//cant have fields
//cant have overriden operators
//all methods are public by def
//methods cant be virtual or static
//can be inherited

public interface interfaceName {
	void method1();
	void method2();
}

public interface interface1 {
	int method1();
}
public interface interface2 {
	int method2(int x);
}
class A : interface1 {
	public int x { get; set; }
	public A(int x) {
		this.x = x;
	}
	public virtual int method1() {
		return x*2;
	}
}
class Aa : A {
	public int y;
	public Aa(int y, int x): base(x) {
		this.y = y;
	}
	public override int method1() {
		return base.x + y;
	}
}
class Ab : A, interface2 {
	public int method2(int x) {
		return x * x;
	}
}

//Interface references
public interface interface1 {
	void method1();
}
class class1 : interface1 {
	string s;
	public class1(string s) {
		this.s = s;
	}
	public void method1() {
		Console.WriteLine(s);
	}
	public void method2(){
		Console.WriteLine("A");
	}
}
class1 object1 = new class1(s: "Ara");
interface1 obj;
obj = object1;
obj.method1();
//cant call method2() from obj

//as
interface1 obj = object1 as interface1;
if (obj != null)
	Console.WriteLine("Good");
else
	Console.WriteLine("class1 is not supporting interface1");

//also can use //is
if (object1 is interface1)
	Console.WriteLine("Good");
else
	Console.WriteLine("class1 is not supporting interface1");

public interface interface1 {
	object method();
}
public interface interface2 {
	object method();
}
public class class1 : interface1, interface2 {
	object interface1.method() {...}
	object interface2.method() {...}
}
class1 class1 = new class1();
interface1 interface1 = class1;
interface1.method();
interface2 interface2 = class1;
interface2.method();

interface interface1 {
	string Param { get; set; }
}
class class1 : interface1 {
	string var1;
	public string Param {
		set {
			var1 = value;
		}
		get {
			return var1;
		}
	}
}

//interface indexers
interface interface1 {
	string Param { get; set; }
	string this[int index] { get; set; }
}
class class1 : interface1 {
	string var1;
	public string Param {
		set {
			var1 = value;
		}
		get {
			return var1;
		}
	}
	public string this[int index] {
		set { var1 = value; }
		get { return var1; }
	}
}
class1 obj1 = new class1();
obj1.Param = "a";
obj1[5] = "b";

//interface inheritance
public interface A {
	int Sum();
}
public interface B : A {
	int Del();
}
class MyOperation : B {
	public int Sum() {...}
	public int Del() {...}
}

//Explicit interface implementation
public interface interface1 {
	void method1();
}
public interface interface2 {
	void method1();
	void method2();
}
public interface interface3 : interface2 {
	new void method1();//without "new" methods of the basic interface will hide
	void method22();
}
class class1 : interface3, interface1 {
	void interface1.method1() {...}
	void interface2.method2() {...}
	void interface2.method1() {...}
	void interface3.method1() { }
	public void method22() {
		class1 obj = new class1();
		interface1 link1 = (interface1)obj;
		link1.method1();
		interface2 link2 = (interface2)obj;
		link2.method1();
		link2.method2();
		interface3 link3 = (interface1)obj;
		link3.method1();
	}
}