class Class {
	private static int num = 5;
	public static int Num {
		get { return num; }
		set { num = value; }
	}
}
Class.Num = 10;
Console.WriteLine(Class.Num);

class UserInfo{
				int age;
				public int Age{
					get{
						return age;
					}
					private set{
						age = value;
					}
				}
				public int myAge(){
					Age = 26;
					return Age;
				}
}


//Indexator
public class Laptop{...}
public class Shop{
	...
	public Laptop this[int pos]{
		get {
			return (Laptop)LaptopArr[pos];
		}
		set {
			LaptopArr[pos] = (Laptop)value;
		}
	}
}


#region IEnumerable Members
	IEnumerator IEnumerable.GetEnumerator(){
		return LaptopArr.GetEnumerator();
	}
#endregion


public int this[int r, int c]{
		get { return arr[r, c]; }
}
obj[i, j];


String queue = new MessageQueue(".\\exampleQueue");
System.Collections.IEnumerator enumerator = queue.GetEnumerator();
while(enumerator.MoveNext()){
	Message msg = (Message)enumerator.Current;
	Console.WriteLine(msg.Label);
}