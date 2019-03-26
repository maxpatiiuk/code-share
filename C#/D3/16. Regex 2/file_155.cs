using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Text.RegularExpressions;

namespace regex
{

    class Program
    {
        static void Main(string[] args)
        {
            int i;
            Regex r;
            String s;
            String[] buf;

            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Valid email");
                Console.WriteLine("2. Valid phone number");
                Console.WriteLine("3. Show everything inside ()");
                Console.WriteLine("4. Get <img src=\"\"> and replace src");
                Console.WriteLine("5. Delete numbers from text");
                Console.WriteLine("6. Delete word followed by another");
                Console.WriteLine("7. Flip parts before and after @");
                Console.WriteLine("0. Exit");
                i = Convert.ToInt32(Console.ReadLine());
                Console.Clear();
                s = Console.ReadLine();
                    
                switch (i)
                {
                    case 1:
                        r = new Regex(@"[A-Za-z0-9]{4,}@[A-Za-z0-9]{2,}.[A-Za-z0-9.]{2,}");
                        Console.WriteLine(r.Match(s).Success);
                        break;
                    case 2:
                        r = new Regex(@"\+[0-9\-()]{7,}");
                        Console.WriteLine(r.Match(s).Success);
                        break;
                    case 3:
                        r = new Regex(@"\(.*?\)", RegexOptions.Compiled);
                        foreach (Match ItemMatch in r.Matches(s))
                            Console.WriteLine(/*((string)*/ItemMatch/*).Substring(1,-1)*/);
                        break;
                    case 4:
                        Console.WriteLine(Regex.Replace(s, "src=\".*?\"", "src=\"smile.pg\""));
                        break;
                    case 5:
                        Console.WriteLine(Regex.Replace(s, "[0-9]", ""));
                        break;
                    case 6:
                        buf = s.Split(' ');
                        s = buf[0] + " ";
                        for (i = 1; i < buf.Length; i++)
                            if (buf[i] != buf[i - 1])
                                s += buf[i] + " ";
                        Console.WriteLine(s.Substring(0,s.Length-1));
                        break;
                    case 7:
                        Console.WriteLine(s.Split('@')[1] + "@" + s.Split('@')[0]);
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