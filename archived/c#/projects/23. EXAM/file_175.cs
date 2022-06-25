using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace exam
{
    static class helper
    {
        static private Random rnd = new Random();
        static public string n = Environment.NewLine;
        static public void fill(char symbol, int count, bool newLine = true)
        {
            for (int i = 0; i < count; i++)
                Console.Write(symbol);
            if (newLine)
                Console.WriteLine();
        }
        static public int generateRandomNumber(int min, int max)
        {
            return rnd.Next(min, max);
        }
        static public bool generateRandomBool()
        {
            return rnd.NextDouble() < 0.5;
        }
        static public void clear()
        {
            Console.Clear();
        }
        static public int shift(int value, int shift)
        {
            return 1;
        }
        static public bool generateRandomWin(float chance)
        {
            return generateRandomNumber(0, 100) < (chance * 100);
        }
        static public bool generateRandomWin(int chance)
        {
            return generateRandomNumber(0, 100) < chance;
        }
        /*static public object max(object a, object b)//make this a template
        {
            return (a.compareto(b)>0) ? a : b;
        }
        static public int min(int a, int b)
        {
            return (a > b) ? a : b;
        }*/
        /*static public void n()
        {
            Console.WriteLine();
        }*/
    }
    /*public class Temperature : IComparable<Temperature>
    {
        // Implement the generic CompareTo method with the Temperature 
        // class as the Type parameter. 
        //
        public int CompareTo(Temperature other)
        {
            // If other is not a valid object reference, this instance is greater.
            if (other == null) return 1;

            // The temperature comparison depends on the comparison of 
            // the underlying Double values. 
            return m_value.CompareTo(other.m_value);
        }

        // Define the is greater than operator.
        public static bool operator >(Temperature operand1, Temperature operand2)
        {
            return operand1.CompareTo(operand2) == 1;
        }

        // Define the is less than operator.
        public static bool operator <(Temperature operand1, Temperature operand2)
        {
            return operand1.CompareTo(operand2) == -1;
        }

        // Define the is greater than or equal to operator.
        public static bool operator >=(Temperature operand1, Temperature operand2)
        {
            return operand1.CompareTo(operand2) >= 0;
        }

        // Define the is less than or equal to operator.
        public static bool operator <=(Temperature operand1, Temperature operand2)
        {
            return operand1.CompareTo(operand2) <= 0;
        }

        // The underlying temperature value.
        protected double m_value = 0.0;
    }*/
    class line
    {
        public bool[] prop;
        static public float hardness;
        static public int trackWidth;
        private int position = 0;
        static public char propLook = '*';
        static public int hardnessDivision;

        public line()
        {
            prop = new bool[trackWidth];
        }
        public bool this[int i]
        {
            get {
                i = (i + position) % trackWidth;
                return prop[i];
            }
            set
            {
                i = (i + position) % trackWidth;
                prop[i] = value;
            }
        }
        public override string ToString()
        {
            string line = "";

            for(int i = 0; i < trackWidth; i++)
            {
                if (this[i])
                    line += propLook;
                else
                    line += " ";
            }

            return line;
        }
        public void generateNext()
        {
            this[0] = helper.generateRandomWin(hardness/hardnessDivision);
            position++;
        }
    }
    class Program
    {
        private static int lifes;
        private static bool lifeWasRemoved = false;
        static void removeLife()
        {
            lifes--;
            if (lifes < 0)
                death();
            lifeWasRemoved = true;
        }
        static void death()
        {
            Console.ForegroundColor = ConsoleColor.Red;
            helper.clear();
            Console.WriteLine("GAME OVER!!!");
            Console.ForegroundColor = ConsoleColor.White;
            Console.ReadKey();
            Environment.Exit(0);
        }
        static void Main(string[] args)
        {
            //settings
            string[] carLook = { "-+--+-", "|  o-|", "-+--+-" };
            char propLook = '*';
            int trackWidth = 50;//min 30
            int trackHeight = 15;
            float hardness = 0.5f;/*0 - peacefull; 1 - imposible*/
            int carLeftOffset = 2;
            lifes = 3; 
            System.ConsoleColor colorOfCar = ConsoleColor.Magenta;
            System.ConsoleColor defTextColor = ConsoleColor.White;
            System.ConsoleColor attentionColor = ConsoleColor.Red;

            //deffining
            Console.ForegroundColor = defTextColor;
            trackWidth = (trackWidth > 30) ? trackWidth : 30;
            int hardnessDivision = 20;
            ConsoleKeyInfo c;
            line.trackWidth = trackWidth;
            line.hardness = hardness;
            line.propLook = propLook;
            line.hardnessDivision = hardnessDivision;
            List<line> prop = new List<line>();
            for (int i = 0; i < trackHeight; i++)
                prop.Add(new line());
            int carWidth = carLook[0].Length;
            int carHeight = carLook.Length;
            int carPosition = trackHeight / 2;
            string currentLine = "";
            bool needToRemoveLife = false;

            Console.WriteLine("Controls:\nUp: Arrow Up / W\nDown: Arrow Down / S\nDo not move: Space / Any unused key\nExit: Esc");
            Console.ReadKey();
            helper.clear();

            //game
            do
            {
                if (lifeWasRemoved)
                    Console.ForegroundColor = attentionColor;
                Console.WriteLine("Lifes: " + lifes);
                if (lifeWasRemoved)
                {
                    Console.ForegroundColor = defTextColor;
                    lifeWasRemoved = false;
                }
                helper.fill('=', 50);
                
                for(int i = 0; i < trackHeight; i++)
                {
                    prop[i].generateNext();

                    if (i < carPosition || i >= carPosition + carHeight)
                        Console.WriteLine(prop[i]);
                    else
                    {
                        currentLine = prop[i].ToString();

                        for (int ii = 0; ii < carLeftOffset; ii++)
                            Console.Write(currentLine[ii]);

                        Console.ForegroundColor = colorOfCar;

                        Console.Write(carLook[i - carPosition]);

                        Console.ForegroundColor = defTextColor;

                        for (int ii = carLeftOffset + carWidth; ii < trackWidth; ii++)
                            Console.Write(currentLine[ii]);

                        for(int ii = carLeftOffset; ii < carLeftOffset + carWidth; ii++)
                            if (currentLine[ii] != ' ')
                            {
                                needToRemoveLife = true;
                                prop[i][ii] = false;
                                //currentLine[ii] = ' ';
                                currentLine = prop[i].ToString();
                            }
                        if (needToRemoveLife)
                            removeLife();
                        needToRemoveLife = false;
                        Console.WriteLine();
                    }

                    /*for (int ii = 0; ii < carPosition; ii++)
                        Console.WriteLine(prop[i]);
                    for (int ii = carPosition + carHeight; ii < trackHeight; ii++)
                        Console.WriteLine(prop[i]);*/
                }

                helper.fill('=', 50);
                c = Console.ReadKey();
                if ((c.Key == ConsoleKey.UpArrow || c.Key == ConsoleKey.W) && carPosition > 0)
                    carPosition--;
                else if ((c.Key == ConsoleKey.DownArrow || c.Key == ConsoleKey.S) && carPosition + carHeight < trackHeight)
                    carPosition++;
                helper.clear();

            } while (c.Key != ConsoleKey.Escape);
        }
    }
}
