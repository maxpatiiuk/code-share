//DELEGATES
//are objects than can point to method
delegate int IntOperation(int i, int j);
class Program{
	static int Sum(int x, int y){
		return x + y;
	}
	static int Mul(int x, int y){
		return x * y;
	}
	static void Main(){
		IntOperation op1 = new IntOperation(Sum);
		int result = op1(5, 10);//15
		op1 = new IntOperation(Mul);//op1 = Mul
		result = op1(5, 10);//50
	}
}

public delegate Boolean Comparer(Object elem1, Object elem2);
public void Sort(Object[] array, Comparer comparer){ 
	...
	//comparer(obj1, obj2);
}
Sort(persons, new Comparer(PersonBirthdayComparer));

PrintInfo printInfo = new PrintInfo(circle.PrintRadius);
printInfo += circle.PrintDiameter;
printInfo += circle.PrintLenght;
printInfo += circle.PrintSquare;//will call all 4 method on call
PrintInfo printInfo1 = circle.PrintSquare;
printInfo -= printInfo1;//now will have 3 mehods
printInfo();
printInfo = printInfo + printInfo1 - new PrintInfo(circle.PrintRadius) 

class Test {
	public void func1(int arg){..}
}
private delegate void MyDelegate(int arg);
MyDelegate del = new MyDelegate(Test.func2);
del += (new Test()).func1;
del += Test.func2;
del(5);