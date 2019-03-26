//operators overloading
//cant fork with out or ref
public static bool operator ++ (int paramethers){}

//- ~ ! ++ -- true false + - * % / & | ^ << >> == != < > <= >= && || [] () - can be overloaded
// += -= *= /= %= &= |= ^= <<= >>= = . ?: new as is typeof - can not be overloaded
//-> sizeof * & - can be overloaded, but may be insecure


//overloading of unary operators
class cp{
	int x, y;
	public cp(int x, int y){
		this.x = x; this.y = y;
	}
	public static cp operator ++(cp s){
		s.x++; s.y++; return s;
	}
	public static cp operator -(cp s){
		cp p = new cp(s.x, s.y);
		p.x = -p.x; p.y = -p.y; return p;
	}
	public override string ToString(){
		return string.Format("X = {0} Y = {1}", x, y);
	}
}
cp p = new cp(10, 10);
Console.WriteLine(++p);//same result as p++
Console.WriteLine(-p);


//binary operators overloading
class CPoint
{
	private int x;
	private int y;
	public CPoint(int x, int y){
		this.x = x; this.y = y;
	}
	public static CPoint operator *(CPoint p, int a){
			return new CPoint(p.x * a, p.y * a);
	}
	public override string ToString(){
		return string.Format("Point: X = {0} Y = {1}", x, y);
	}
}
CPoint p1 = new CPoint(10,10);
Console.Write(p1 * 10);


//relations operatos overloading
//shoup be overloaded in this pairs
//== and !=
//< and >
//<= and >=

//equality can be checked by equality of links or values
//this are overloaded in class Object
public static bool ReferenceEquals(Object obj1, Object obj2){}
public bool virtual Equals(Object obj){}

CPoint p = new CPoint(0, 0);
CPoint p1 = new CPoint(0, 0);
CPoint p2 = p1;
ReferenceEquals(p, p1); //false
ReferenceEquals(p1, p2);//true
ReferenceEquals(p3, p3); //false because ReferenceEquals is compressing data and putting them into different addresses

CPoint cp = new CPoint(0, 0);
CPoint cp1 = new CPoint(0, 0);
Equals(cp, cp1); //false because CPount is link type

SPoint sp = new SPoint(0, 0);
SPoint sp1 = new SPoint(0, 0);
Equals(sp, sp1); //true because SPoint is value type


class CPoint
{
	int x, y;
	public CPoint(int x, int y){
		this.x = x; this.y = y;
	}
	public override bool Equals(object obj){
		if(obj == null)
			return false;
		CPoint p = obj as CPoint;
		if(p == null)
			return false;//obj is not a CPoint
		return ((x == p.x) && (y == p.y));
	}
	public override int GetHashCode(){//should be overloaded in case of overloading Equals
		return x ^ y;
	}
	public static bool operator ==(CPoint p1, CPoint p2){
		if(ReferenceEquals(p1, p2))//p1==p2 will lead to recursion
			return true;
		if((object)p1 == null)//will lead to recursion if p1 not casted to object
			return false;
		return p1.Equals(p2);
	}
	public static bool operator !=(CPoint p1, CPoint p2){
		return (!(p1 == p2));
	}
}

CPoint cp = new CPoint(0, 0);
CPoint cp1 = new CPoint(0, 0);
CPoint cp2 = new CPoint(1, 1);
cp == cp1 //true
cp == cp2 //false