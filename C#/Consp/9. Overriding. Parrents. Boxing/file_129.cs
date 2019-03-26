class Name {}
class Name : inheritFromThisClass {}
class Name : inheritFromThisClass, Interface1, Interface2 {}

class Name {
	public Name(): base() {}//will use parent constructor in child class
	public Name(int par1): base(par1) {}
}

class parent {
	public method(){}
}
class child : parent {
	public new void method(){} //override parent.method
}

class parent {
	public method(){}
}
class child : parent {
	public override void method(){
		base.Work();
	} //use parent.method when calling child.method
}

class realParent {
	public method(){}
}
class parent : realParent{}
class child : parent {
	public override void method(){
		base.base.Work();
	} //use realParent.method when calling child.method
}

public sealed class lastChild(){} //can be child but cant be parrent

class hereWasNameBeforeUCome(){
	public sealed void lastChild(){} //can override, but not be overriden
}//public sealed override void lastChild


//VIRTUAL METHODS
//static classes and methods cant be virtual

class parent {
	public virtual void method(){}
}
class child : parent {
	public override void method(){}
}

//abstract classes
public abstract class parent {//can be parrent, but cant have objects
	public virtual void method(){}
}
class child : parent {
	public override void method(){}
}

//methods of class "object" //all public
virtual /*bool*/ Equals(obj1)
static /*bool*/ Equals(obj1, obj2)
/*type*/ GetType()
static /*bool*/ ReferenceEquals(obj1, obj2)
virtual string ToString()

//BOXING & UNBOXING
object o;
int i = 2;
o = i; //boxing
int a = (int)o;//unboxing
