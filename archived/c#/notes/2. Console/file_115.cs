//simplest program
using System;
namespae A/*name of project here*/ {
	class Class1 {
		static void Main(){

		}
	}
}

//program structure : namespace > clases > variables + methods > local_variables

using System;
namespace ToStringSample {
	class Program {
		static void Main(string[] args){
			Program prg = new Program();
			Console.WriteLine(prg.toString());//ToStringSample.Program (namespace.className)
		}
	}
}

//to make class child of object, just declare it inside of object

Console.WriteLine((10D)).GetType(); //System.Double
Console.WriteLine((10F)).GetType(); /*System.Single //return .NET data type, not C#

SUFIX  DESCRIPTION                                   GetType
L      long                                          System.Int64
F      float                                         System.Single
D      double                                        System.Double
M      decimal                                       System.Decimal
U      unsigned. can be combined with others (10DU)  

UL                                                   System.Uint64
(10)                                                 System.Int32 */

Console.WriteLine(0XFF) // 255

//can't convert older to youger type without sufix

Console.BackgroudColor // get/set backg color
Console.BufferHeight
Console.BufferWidth
Console.CapsLock // if capsLock it turned on
Console.NumberLock // is numbberlock turn on
Console.CursorLeft //number of col in buffer zone in which cursor is located
Console.CursorSize //height of cursor respectevly yo height of symbol cell
Console.CursorTop // number of line buffer zone in which curosr is
Console.CursorVisible // identificator of visibility of cursor
Console.Error // return deafult stream of information about errors (log)
Console.ForegroundColor // text color
Console.In //return deafult stream of output
Console.InputEncoding
Console.OutputEncoding
Console.KeyAvaible //if reaction to key press is avaible
Console.LargestWindowHeight //biggest count of rows in console buffer zone
Console.LargestWindowWidth //biggest count of cells in console buffer zone
Console.Out //return deafult output stream
Console.Title

Consloe.BackgroudColor = ConsoleColor.DarkBlue;

//VS 2017 Creating Project : Instaled > Other Languages > Visual C# > Get Started > Console App

//standart VC 2017 C# application
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TryC
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");
            Console.ReadKey();
        }
    }
}

Console.Write("I");
Console.BackgroundColor = ConsoleColor.Blue;
Console.Write("s");
Console.BackgroundColor = ConsoleColor.Black;
Console.Write(" ");
Console.BackgroundColor = ConsoleColor.Cyan;
Console.Write("t");
Console.BackgroundColor = ConsoleColor.DarkBlue;
Console.Write("h");
Console.BackgroundColor = ConsoleColor.DarkCyan;
Console.Write("i");
Console.BackgroundColor = ConsoleColor.DarkGray;
Console.Write("s");
Console.BackgroundColor = ConsoleColor.DarkGreen;
Console.Write(" ");
Console.BackgroundColor = ConsoleColor.DarkRed;
Console.Write("a");
Console.BackgroundColor = ConsoleColor.DarkMagenta;
Console.Write("w");
Console.BackgroundColor = ConsoleColor.DarkYellow;
Console.Write("e");
Console.BackgroundColor = ConsoleColor.Gray;
Console.Write("s");
Console.BackgroundColor = ConsoleColor.Green;
Console.Write("o");
Console.BackgroundColor = ConsoleColor.Magenta;
Console.Write("m");
Console.BackgroundColor = ConsoleColor.Red;
Console.Write("e");
Console.ForegroundColor = ConsoleColor.Black;
Console.BackgroundColor = ConsoleColor.White;
Console.Write("?");
Console.ReadKey();

Console.TreadConsoleCAsInput
Console.WindowHeight
Console.WindowLeft
Console.WindowTop
Console.WindowWidth
Console.Beep(ghz,ms)
Console.Clear
Console.MoveBufferArea //copy buffer
Console.OpenStandartError(1024) // return deafult list of errors with specified buffer size
Console.OpenStandartInput(1024) //open standart stream of input with specified size
Console.OpenStandartOutput(1024) //open standart stream of output with specified size
Console.Read // read next symbol in input stream
Console.ReadKey // everythink about pressed key
Console.ResetColor // reset colors
Console.SetBufferSize // set width and height of console buffer zone
Console.Write()
Console.WriteLine();


class Point {
	public int x;
}
Point a = new Poin();
a.x = 10;
Pointer b = a;
b.x = b.x - 5;
//a.x = b.x = 5;
//but a and b are different objects

class Point {
	public int x;
}
Point a = new Poin();
Point b = new Poin();
a.x=10;
b=a;
//object bis no longer existing, and a,b is same variable

/*Types transformations:
implicit - by compilator //cant be done from older to younger type
explisit - by user
*/

Convert.ToBase64CharArray(value);
Convert.ToBase64String(value);
Convert.ToBoolean(value);
Convert.ToByte(value);
Convert.ToBase(value);
Convert.ToDateTime(value);
Convert.ToDecimal(value);
Convert.ToDouble(value);
Convert.ToInt16(value);
Convert.ToInt32(value);
Convert.ToInt64(value);
Convert.ToSByte(value);
Convert.ToSingle(value);
Convert.ToString(value);
Convert.ToUInt16(value);
Convert.ToUInt32(value);
Convert.ToUInt64(value);

float x = 10.5F;
int y = int.Parse(x);
char  = 'a';
float z = float.Parse(s);

//if output type cant store such big value, it is looping

/// --- INPUT --- ///
string n = Console.ReadLine();
int number = Convert.ToInt32(n);
//or
int nimber = Convert.ToInt32(Console.ReadLine());

//result of if should always be true or false (not if(intValue) but if(intValue != null))

switch(val){
	case 1: a = 2; break;
	case 2: goto case 1; break;
	default: a = 3; break;
}
for(int i=0;i<10;i++){}
while(true){}
do {} while(true);
foreach(int iter in arr){}