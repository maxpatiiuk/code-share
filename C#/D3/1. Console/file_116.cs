using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TryC{
    class Program
    {

        static void task1() {
            int count = 0;

            ConsoleKeyInfo cki = new ConsoleKeyInfo();
            do {
                while (Console.KeyAvailable == false)
                    System.Threading.Thread.Sleep(250); // Loop until input is entered.
                cki = Console.ReadKey(true);
                if (cki.Key == ConsoleKey.Spacebar)
                {
                    count++;
                    Console.Write(' ');
                }
                else if(cki.Key == ConsoleKey.Oem2 || cki.Key == ConsoleKey.OemPeriod)
                    Console.Write('.');
                else
                    Console.Write(cki.Key);
            } while (cki.Key != ConsoleKey.Decimal && cki.Key != ConsoleKey.OemPeriod && cki.Key != ConsoleKey.Oem2);
            Console.WriteLine("\n"+count);
        }
        static void task2() {
            String ticket = Console.ReadLine();
            if (ticket[0] == ticket[5]
               && ticket[1] == ticket[4]
               && ticket[2] == ticket[3])
                Console.WriteLine("Lucky");
            else
                Console.WriteLine("Regular");
        }
        static void task3() {
            Console.WriteLine("Press . to stop");
            ConsoleKeyInfo cki = new ConsoleKeyInfo();
            do
            {
                while (Console.KeyAvailable == false)
                    System.Threading.Thread.Sleep(250); // Loop until input is entered.
                cki = Console.ReadKey(true);
                if ((int)cki.KeyChar>=97 && (int)cki.KeyChar <= 122)
                {
                    Console.Write((char)(cki.KeyChar-32));
                }
                else
                    Console.Write(cki.Key);
            } while (cki.Key != ConsoleKey.Decimal && cki.Key != ConsoleKey.OemPeriod && cki.Key != ConsoleKey.Oem2);
        }
        static void task4() {
            int primary = Convert.ToInt16(Console.ReadLine()),
                secondary = Convert.ToInt16(Console.ReadLine());
            for (; primary <= secondary; primary++)
            {
                for (int i = 0; i < primary;i++)
                    Console.Write(primary);
                Console.WriteLine();
            }
        }
        static void task5() {
            String source = Console.ReadLine(),res="";
            for (int i = 0; i < source.Length; i++)
                res += source[source.Length-1-i];
            Console.WriteLine(res);
        }
        static void bonusTask() {
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
            Console.ResetColor();
        }
        static void Main(string[] args){
            while (true) {
                Console.WriteLine("1. Task1");
                Console.WriteLine("2. Task2");
                Console.WriteLine("3. Task3");
                Console.WriteLine("4. Task4");
                Console.WriteLine("5. Task5");
                Console.WriteLine("6. Bonus task");
                Console.WriteLine("0. Exit");
                String buf = Console.ReadLine();
                if (buf != "")
                {
                    Console.Clear();
                    int menu = Convert.ToInt32(buf);
                    switch (menu)
                    {
                        case 1: task1(); break;
                        case 2: task2(); break;
                        case 3: task3(); break;
                        case 4: task4(); break;
                        case 5: task5(); break;
                        case 6: bonusTask(); break;
                        case 0: Environment.Exit(0); break;
                    }
                    Console.ReadKey();
                }
                Console.Clear();
            }
            Console.ReadKey();
        }
    }
}
