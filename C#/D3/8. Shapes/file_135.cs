using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace enumerators
{
    struct shapes {
        public int type;
        public int color;
        public char fill;
    }
    class Shape
    {
        List<shapes> data = new List<shapes>();
        string[] shapeLook = new string[5];
        public Shape()
        {
            shapeLook[0] = "****\n****\n****";
            shapeLook[1] = " **\n****\n **";
            shapeLook[2] = "*\n**\n***";
            shapeLook[3] = "  **\n ****\n******";
            shapeLook[4] = " **\n****\n****\n **";
        }
        public void add(int vtype, int vcolor, char vfill)
        {
            shapes buf = new shapes();
            buf.type = vtype;
            buf.color = vcolor;
            buf.fill = vfill;
            data.Add(buf);
        }
        public void show()
        {

            for(int i = 0; i < data.Count; i++)
            {
                switch (data[i].color)
                {
                    case 1: Console.ForegroundColor = ConsoleColor.Black; break;
                    case 2: Console.ForegroundColor = ConsoleColor.Blue; break;
                    case 3: Console.ForegroundColor = ConsoleColor.Cyan; break;
                    case 4: Console.ForegroundColor = ConsoleColor.DarkBlue; break;
                    case 5: Console.ForegroundColor = ConsoleColor.DarkCyan; break;
                    case 6: Console.ForegroundColor = ConsoleColor.DarkGray; break;
                    case 7: Console.ForegroundColor = ConsoleColor.DarkGreen; break;
                    case 8: Console.ForegroundColor = ConsoleColor.DarkMagenta; break;
                    case 9: Console.ForegroundColor = ConsoleColor.DarkRed; break;
                    case 10: Console.ForegroundColor = ConsoleColor.DarkYellow; break;
                    case 11: Console.ForegroundColor = ConsoleColor.Gray; break;
                    case 12: Console.ForegroundColor = ConsoleColor.Green; break;
                    case 13: Console.ForegroundColor = ConsoleColor.Magenta; break;
                    case 14: Console.ForegroundColor = ConsoleColor.Red; break;
                    case 15: Console.ForegroundColor = ConsoleColor.White; break;
                    case 16: Console.ForegroundColor = ConsoleColor.Yellow; break;
                }
                Console.WriteLine(shapeLook[data[i].type-1].Replace('*',data[i].fill) + "\n\n\n");
            }

            Console.ForegroundColor = ConsoleColor.White;
        }
        public void clear()
        {
            data.Clear();
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Shape shapes = new Shape();
            int i,type,color;
            char fill;
            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Add shape");
                Console.WriteLine("2. Show results");
                Console.WriteLine("3. Remove all");
                Console.WriteLine("0. Exit");
                i = Convert.ToInt32(Console.ReadLine());
                Console.Clear();
                switch (i)
                {
                    case 1:
                        Console.WriteLine("Shapes:");
                        Console.WriteLine("1. Rectangle");
                        Console.WriteLine("2. Rhombus");
                        Console.WriteLine("3. Triangle");
                        Console.WriteLine("4. Trapezium");
                        Console.WriteLine("5. Polygon");
                        Console.WriteLine("0. Return");
                        type = Convert.ToInt32(Console.ReadLine());
                        if(type < 1 || type > 5)
                            break;

                        Console.Clear();

                        Console.WriteLine("1. Black");
                        Console.WriteLine("2. Blue");
                        Console.WriteLine("3. Cyan");
                        Console.WriteLine("4. DarkBlue");
                        Console.WriteLine("5. DarkCyan");
                        Console.WriteLine("6. DarkGray");
                        Console.WriteLine("7. DarkGreen");
                        Console.WriteLine("8. DarkMagenta");
                        Console.WriteLine("9. DarkRed");
                        Console.WriteLine("10. DarkYellow");
                        Console.WriteLine("11. Gray");
                        Console.WriteLine("12. Green");
                        Console.WriteLine("13. Magenta");
                        Console.WriteLine("14. Red");
                        Console.WriteLine("15. White");
                        Console.WriteLine("16. Yellow");
                        Console.WriteLine("0. Cancel");
                        color = Convert.ToInt32(Console.ReadLine());
                        if (color < 1 || color > 16)
                            break;

                        Console.Clear();

                        Console.WriteLine("Input character to fill shape with:");
                        fill = Console.ReadLine()[0];
                        shapes.add(type,color,fill);
                        break;
                    case 2:
                        shapes.show();
                        break;
                    case 3:
                        shapes.clear();
                        break;
                    case 0:
                        Environment.Exit(0);
                        break;
                }
                Console.ReadKey();
                Console.Clear();
            }
        }
    }

}