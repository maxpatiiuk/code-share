//overloading of =
//types:
//from arbitrary type into private
//from private to arbitrary

//can be performed explicity and implicity
//first used when data can be losed during transformation. second, when data transformations is secure

class CPoint
{
	int x, y;
	public CPoint(int x, int y)
	{
		this.x = x;
		this.y = y;
	}
	public static explicit operator int(CPoint p)
	{
		return (int)Math.Sqrt(p.x * p.x + p.y * p.y);
		//return (int)(double)p;
	}
	public static implicit operator double(CPoint p)
	{
		return Math.Sqrt(p.x * p.x + p.y * p.y);
	}
	public static implicit operator CPoint(int a)
	{
		return new CPoint(a, a);
	}
	public static explicit operator CPoint(double a)
	{
		return new CPoint((int)a, (int)a);
	}
	public override string ToString()
	{
		return string.Format("X = {0} Y = {1}", x, y);
	}
}
CPoint p = new CPoint(2, 2);
int a = (int)p; //explicit CPoint to int
double d = p; //implicit CPoint в double
Console.WriteLine("p as int: {0}", a); //2
Console.WriteLine("p as double: {0:0.0000}", d); //2.828
p = 5; //implicit int to double
Console.WriteLine("p: {0}", p); //x = 5 y = 5
p = (CPoint)2.5; //explicit
Console.Writeline("p: {0}",p); //x = 2 y = 2


class Timer{
	public int Hours;
	public int Minutes;
	public int Seconds;
}
class Counter{
	public int Seconds;

	public Counter(int seconds){
		Seconds = seconds;
	}
	public static implicit operator Counter(int x){
		return new Counter(x);
	}
	public static explicit operator int(Counter counter){
		return counter.Seconds;
	}
	public static explicit operator Counter(Timer timer){
		int h = timer.Hours * 3600;
		int m = timer.Minutes * 60;
		return new Counter( h + m + timer.Seconds );
	}
	public static implicit operator Timer(Counter counter){
		int h = counter.Seconds / 3600;
		int m = (counter.Seconds - h * 3600) / 60;
		int s = counter.Seconds - h * 3600 - m * 60;
		return new Timer { Hours = h, Minutes = m, Seconds = s };
	}
}
Counter counter1 = new Counter(115);

Timer timer = counter1;
Console.WriteLine("{0}:{1}:{2}", timer.Hours, timer.Minutes, timer.Seconds); // 0:1:55

Counter counter2 = (Counter)timer;
Console.WriteLine(counter2.Seconds);  //115

Console.ReadKey();