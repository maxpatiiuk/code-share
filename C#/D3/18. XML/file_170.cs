using System;
using System.Collections.Generic;
using System.Linq;
using System.Xml;
using System.Text;
using System.Threading.Tasks;

namespace xmldc
{
    class api
    {
        public static class helper
        {
            public static string n = Environment.NewLine;
            private static Random rnd = new Random();
            public static int unixExample = 1534510000;

            public static int generateRandomNumber(int min, int max)
            {
                return rnd.Next(min, max);
            }
            public static int generateRandomNumber(int max)
            {
                return rnd.Next(0, max);
            }
            public static int generateRandomUnix()
            {
                return unixExample + generateRandomNumber(-10000, 10000);
            }
            public static string generateRandomName(bool fullName = true)
            {
                string[] names = { "Halley Hosley", "Vertie Verges", "Christel Chastain", "Thad Tirrell", "Barrie Billie", "Olga Overfelt", "Stacie Stickel", "Joleen Jakubowski", "Alane Abadie", "Phyliss Padro", "Terina Tallent", "Lieselotte Lanphear", "Diedre Donelan", "Azzie Aschenbrenner", "Tricia Thibeaux", "Vernice Ventura", "Maryrose Millsaps", "Renna Read", "Lanelle Lakey", "Jesica Jeffreys", "Fidelia Feldt", "Lorene Lankford", "Muriel Melby", "Krystal Kestner", "Ranee Rodela", "Lanita Lejeune", "Kim Kaczor", "Jan Jimenez", "Alisia Alonso", "Griselda Gladding", "Gregoria Gormley", "Deandra Deshong", "Carol Chapell", "Latasha Lawson", "Ursula Urrutia", "Takako Toth", "Gerda Goulding", "Porsche Pinto", "Aurora Averett", "Anika Artis", "Christinia Candler", "Herman Holding", "Cathleen Croskey", "Merissa Muncy", "Kelly Kindred", "Taina Tussey", "Noelle Neil", "Marcie Mace", "Georgianne Gallego", "Tawna Twiford" };
                if (fullName)
                    return names[generateRandomNumber(names.Length)];
                else
                {
                    int tempPost = generateRandomNumber(names.Length);
                    return names[tempPost].Substring(0, names[tempPost].IndexOf(" "));
                }
            }
            public static bool generateRandomBool()
            {
                return rnd.NextDouble() > 0.5;
            }
        }

        public class menu
        {
            public string menuData = "Generate menu data firstly";
            public int showMenu()
            {
                Console.Clear();
                Console.WriteLine(menuData);
                int i = input.Int();
                if (i == 0)
                    Environment.Exit(0);
                return i;
            }
            public void afterMenu()
            {
                Console.ReadLine();
                Console.Clear();
            }
            public menu(string[] data)
            {
                menuData = "";
                for (int i = 0; i < data.Length; i++)
                    menuData += (i + 1) + ". " + data[i] + helper.n;
                menuData += "0. Exit" + helper.n;
            }
        }

        public static class input
        {
            private static bool bBool;
            private static byte bByte;
            private static sbyte bSbyte;
            private static int bInt;
            private static uint bUint;
            private static short bShort;
            private static ushort bUshort;
            private static long bLong;
            private static ulong bUlong;
            private static float bFloat;
            private static double bDouble;
            private static char bChar;
            private static string bString;
            private static decimal bDecimal;

            /*
				output - text that asks user for input
				param:
					0  - display newline after output and        dont validate input
					1  -                                         repeat input until it is valid
					2  -                                         use deafult value if input is invalid
					10 - do not display newline after ouput and  dont validate input
					11 -                                         repeat input until it is valid
					12 -                                         use deafult value if input is invalid
				deafult - value to return if user input is invalid and param is 2 or 12
			*/
            public static bool Bool(string output = "", int param = 1, bool deafult = false)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToBoolean(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!bool.TryParse(bString, out bBool))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !bool.TryParse(bString, out bBool))
                        return false;
                    return bBool;
                }
            }
            public static byte Byte(string output = "", int param = 1, byte deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToByte(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!byte.TryParse(bString, out bByte))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !byte.TryParse(bString, out bByte))
                        return 0;
                    return bByte;
                }
            }
            public static sbyte SByte(string output = "", int param = 1, sbyte deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToSByte(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!sbyte.TryParse(bString, out bSbyte))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !sbyte.TryParse(bString, out bSbyte))
                        return 0;
                    return bSbyte;
                }
            }
            public static int Int(string output = "", int param = 1, int deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToInt32(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!int.TryParse(bString, out bInt))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !int.TryParse(bString, out bInt))
                        return 0;
                    return bInt;
                }
            }
            public static uint UInt(string output = "", int param = 1, uint deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToUInt32(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!uint.TryParse(bString, out bUint))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !uint.TryParse(bString, out bUint))
                        return 0;
                    return bUint;
                }
            }
            public static short Short(string output = "", int param = 1, short deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToInt16(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!short.TryParse(bString, out bShort))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !short.TryParse(bString, out bShort))
                        return 0;
                    return bShort;
                }
            }
            public static ushort UShort(string output = "", int param = 1, ushort deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToUInt16(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!ushort.TryParse(bString, out bUshort))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !ushort.TryParse(bString, out bUshort))
                        return 0;
                    return bUshort;
                }
            }
            public static long Long(string output = "", int param = 1, long deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToInt64(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!long.TryParse(bString, out bLong))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !long.TryParse(bString, out bLong))
                        return 0;
                    return bLong;
                }
            }
            public static ulong ULong(string output = "", int param = 1, ulong deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToUInt64(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!ulong.TryParse(bString, out bUlong))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !ulong.TryParse(bString, out bUlong))
                        return 0;
                    return bUlong;
                }
            }
            public static float Float(string output = "", int param = 1, float deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToSingle(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!float.TryParse(bString, out bFloat))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !float.TryParse(bString, out bFloat))
                        return 0;
                    return bFloat;
                }
            }
            public static double Double(string output = "", int param = 1, double deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToDouble(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!double.TryParse(bString, out bDouble))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !double.TryParse(bString, out bDouble))
                        return 0;
                    return bDouble;
                }
            }
            public static char Char(string output = "", int param = 1, char deafult = ' ')
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToChar(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!char.TryParse(bString, out bChar))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !char.TryParse(bString, out bChar))
                        return ' ';
                    return bChar;
                }
            }
            public static string String(string output = "", int param = 1, string deafult = "")
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                return Console.ReadLine();
            }
            public static decimal Decimal(string output = "", int param = 1, decimal deafult = 0)
            {
                if (output.Length > 0)
                {
                    if (param > 9)
                        Console.Write(output);
                    else
                        Console.WriteLine(output);
                }
                if (param == 10 || param == 0)
                    return Convert.ToDecimal(Console.ReadLine());
                else
                {
                    bString = "";
                    if (param == 11 || param == 1)
                        while (!decimal.TryParse(bString, out bDecimal))
                            bString = Console.ReadLine();
                    else if ((param == 12 || param == 2) && !decimal.TryParse(bString, out bDecimal))
                        return 0;
                    return bDecimal;
                }
            }
        }

        public class worker : person
        {
            public int sallary = helper.generateRandomNumber(10, 50) * 1000;
            public int dateIn = helper.generateRandomNumber(1000000000, api.helper.unixExample);
            public string role = "Worker";

            public worker(int sallary, int dateIn, string role, string fullName, long unixBorn, bool sex, string nationality, string city) : base(fullName, unixBorn, sex, nationality, city)
            {
                this.sallary = sallary;
                this.dateIn = dateIn;
                this.role = role;
                //setData(fullName, unixBorn, sex, nationality, city);
            }
            public worker(int sallary, int dateIn, string role, person copy) : base(copy)
            {
                this.sallary = sallary;
                this.dateIn = dateIn;
                this.role = role;
            }
            public worker(worker copy) : base()
            {
                this.sallary = copy.sallary;
                this.dateIn = copy.dateIn;
                this.role = copy.role;
                this.fullName = copy.fullName;
                this.unixBorn = copy.unixBorn;
                this.sex = copy.sex;
                this.nationality = copy.nationality;
                this.city = copy.city;
            }
        }
        public class person
        {
            public string fullName = helper.generateRandomName();
            public long unixBorn = helper.generateRandomNumber(1000000000, helper.unixExample);
            public bool sex = false;
            public string nationality = "USA";
            public string city = "LA";

            public person() { }
            public person(string fullName, long unixBorn, bool sex, string nationality, string city)
            {
                this.fullName = fullName;
                this.unixBorn = unixBorn;
                this.sex = sex;
                this.nationality = nationality;
                this.city = city;
            }
            public person(person copy)
            {
                this.fullName = copy.fullName;
                this.unixBorn = copy.unixBorn;
                this.sex = copy.sex;
                this.nationality = copy.nationality;
                this.city = copy.city;
            }
        }
    }

    class Orders
    {
        public int product { get; set; }
        public int count { get; set; }
        public int date { get; set; }
        public Orders(int iProduct, int iCount, int iDate)
        {
            product = iProduct;
            count = iCount;
            date = iDate;
        }
        public Orders() : this(0, 0, 0) { }

        public Orders(Orders buf)
        {
            product = buf.product;
            count = buf.count;
            date = buf.date;
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            List<Orders> orders = new List<Orders>();

            int count = api.helper.generateRandomNumber(5,10);
            int i = 0;

            for(i = 0; i < count; i++)
                orders.Add(new Orders(api.helper.generateRandomNumber(0,10), api.helper.generateRandomNumber(5, 40), api.helper.generateRandomUnix()));
            
            XmlTextWriter xml = new XmlTextWriter("file.xml",null);
            xml.WriteStartDocument();
            xml.WriteStartElement("Orders");
            xml.WriteWhitespace("\n");

            foreach (var element in orders)
            {
                xml.WriteStartElement("Order");

                xml.WriteElementString("ID", element.product.ToString());
                xml.WriteElementString("Count", element.count.ToString());
                xml.WriteElementString("Date", element.date.ToString());

                xml.WriteEndElement();
                xml.WriteWhitespace("\n");
            }

            xml.WriteEndElement();
            xml.WriteEndDocument();

            xml.Close();

            //string result = str.ToString();
        }
    }

}