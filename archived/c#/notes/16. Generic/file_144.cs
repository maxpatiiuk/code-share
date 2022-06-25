//Generics
public class cn<T>	{
	public T X { get; set; }
	public cn(T x){
		this.x = x;
	}
	public cn(){
		this.x = default(T);//0 | null
	}
}
cn<int> p1 = new cn<int>(10, 20);
cn<int> p2 = new cn<int>();
Console.WriteLine(typeof(cn<int>).ToString());

IList<T>, IDictionary<T>, ICollection<T>, IEnumerator<T>, IComparer<T>, IComparable<T>, Collection<T>, List<T>, Dictionary<TKey, TValue>, SortedList<TKey, TValue>, Stack<T>, Queue<T>, LinkedList<T> 

List<int> li = new List<int>();
Dictionary<string, int> gr = new Dictionary<string, int>();

class A<T>	{
	public class Inner	{ /*...*/ }
}
A<int>.Inner a = new A<int>.Inner();

class B<T>	{
	public class Inner<U>	{ /*...*/ }
}
B<int>.Inner<string> b = new B<int>.Inner<string>();

//limitations 
where T:
struct /*value*/, class/*link*/, new()/*class has def constructor*/, BaseClass, Interface

class MyGenericClass<T> where T: class, InteraceName, new()

public class Point2D<T>  where T: struct{
	private class P	{
		T p;
	}
}


//generic interfaces
interface ICalc<T>{
	T Sum(T b);
}
class calcInt : ICalc<calcInt>{
	int a = 0;
	public calcInt Sum(calcInt b)	{
		return new calcInt(this.a + b.a);
	}
	public override string ToString()	{
		return a.ToString();
	}
}
class MyArray{ /*...*/ }
MyArray<calcInt> a = new MyArray<calcInt>();


//generic delegates
public delegate void Action<T>(T obj);//do something with two el of colection
public delegate int Comparison<T>(T x,T y);//compare two
public delegate bool Predicate<T>(T obj);//ceck if valid

static void print(int arg){
	Console.WriteLine(arg);
}
static bool neg(int arg){
	return (arg < 0);
}
List<int> li = new List<int>(10);
li.ForEach(new Action<int>(print));
List<int> li_neg = li.FindAll(new Predicate<int>(neg));
li_neg.ForEach(new Action<int>(print));


//generioc methods
static T MaxElem<T>(T[] a) where T : IComparable<T>	{
	T m = a[0];
	foreach (T t in a)
		if (t.CompareTo(m) > 0)
			m = t;
	return m;
}
int[] a = new int[] { 2, 6, 8 };
Console.WriteLine(MaxElem<int>(a));
Console.WriteLine(MaxElem(a));//auto type detection