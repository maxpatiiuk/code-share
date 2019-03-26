Class name {}

Class student {

	public int s;
	public string i;

	static void Main(string[] args){
		Student s;
		s = new Student;
		Student s2 = new student();
	}

}

//public - avaible for evryone
//protected - avaible for childs
//private - avaible only for this class
//internal - avaible only for methods
//protected internal - avaible for methods of this class and childs
//static public|protected|... - set owner to class, not object
//readonly - editable only on iitialization or in any constructor

class c {

	public readonly int[] arr = {1,2,3};
	public readonly int fool;

	public c(int foolValue){
		fool = foolValue;
	}

}
class c2 {

	static void Main(string[] args){
		c obj = new c(5);
		obj.va1 = 100; //err
		obj.arr = new int[10]; //err
		obj.myArr[2] = 8; // cool
	}

}

class c {

	public void method(){}

}

//Constuctor types:
//Deafult, with paramethers and static

class c {

	private static int var = 1;

	static c(){
		var = 1;
	}

}

//this
class c {

	private int a,b;

	public c(): this(1,2){}
	public c(int a, int b){
		this.a = a;
		this.b = b;
	}

}

//ref - object was initialaized before entering the function
//out - object will be initialaized inside of this method
public void method(ref c3, out c2){

//Method with unknown number 
class c {

	static void Main(string[] args){
		sum(new int[]{4,6,8,3});
	}
	private static int sum(int[] arr){
		int res = 0;
		foreach(int i in arr)
			res += i;
		return  res;
	}

}

class c {

	static void Main(string[] args){
		sum(4,6,8,3);
	}
	private static int sum(params int[] arr){
		int res = 0;
		foreach(int i in arr)
			res += i;
		return  res;
	}

}

//multifile class
//first file
particial class c {

}
//sec file
particial class c {
	
}