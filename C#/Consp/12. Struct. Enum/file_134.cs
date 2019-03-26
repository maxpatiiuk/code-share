//STRUCTURES
struct struct1 {
	public double var1;
	public Dimensions(double value){
		var1 = value;
	}
	public double GetSqr {
		get {
			return var1 * var1;
		}
	}
}

//ENUMERATION
enum EnumName : ulong {
	var1 = 57900000,
	var2 = 149600000,
}
EnumName day = EnumName.var2;
for (user1 = EnumName.Name; user1 <= EnumName.Sex; user1++)
	Console.WriteLine("Element: {0}\nValue: {1}", user1, (int)user1);

//method
int CompareTo(object target) //return <0 0 >0
bool Equals(object obj)
string Format(Type enumType, object value, string format) 
void Finalize()//preparation of element to death
int GetHashCode() 
string GetName(Type enumType, Object value)//return const name
string[] GetNames(Type enumType) //return arr of names of constants
Type GetType() 
TypeCode GetTypeCode() 
Type GetUnderlyingType(Type enumType) //static. return base type
Array GetValues(Type enumType) //static. return array of constants
Boolean IsDefined(Type enumType, Object value) 
Object MemberwiseClone() //copy all el of tis obj, but not pointer
Object Parse(Type enumType, String value, bool caseSensetive/*optional*/) 
Object ToObject(Type type, Byte /*Int16,Int32,Int64,Object,Sbyte,UInt12,Int32,Int64*/value) 
String ToString(/*no param | IFormatProvider provider | String format | String format, IFormatProvider provider*/)