using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace cars
{
    public delegate void prepare();

    class Race {
        public class Car
        {
            public string name { get; set; }
            public int speed { get; set; }
            public string slogan { get; set; }
            public string brand { get; set; }
            public string color { get; set; }
            public int number { get; set; }
            public float position { get; set; }
            public Car(string iName, int iNumber, string iSlogan, string iColor, int min, int max)
            {
                Random r = new Random();
                name = iName;
                speed = r.Next(min, max);
                slogan = iSlogan;
                brand = "Tesla";
                color = iColor;
                number = iNumber;
                position = 0;
            }
            public static string Space(int count)
            {
                string buf = "";
                for (int i = 0; i < count; i++)
                    buf += " ";
                return buf;
            }

            public void prepare()
            {
                Console.WriteLine("|| #" + number + " is prepared         ||\n|| " + slogan + Space(23 - slogan.Length) + "||");
            }
        }
        public string Space(int count)
        {
            return Car.Space(count);
        }
        public class TeslaS : Car
        {
            public TeslaS(string iName, int iNumber, string iSlogan, string iColor, int min, int max) : base(iName, iNumber, iSlogan, iColor, min, max) { }
        }
        public class TeslaX : Car
        {
            public TeslaX(string iName, int iNumber, string iSlogan, string iColor, int min, int max) : base(iName, iNumber, iSlogan, iColor, min, max) { }
        }
        public class TeslaRoadster2 : Car
        {
            public TeslaRoadster2(string iName, int iNumber, string iSlogan, string iColor, int min, int max) : base(iName, iNumber, iSlogan, iColor, min, max) { }
        }
        public class TeslaRoadster : Car
        {
            public TeslaRoadster(string iName, int iNumber, string iSlogan, string iColor, int min, int max) : base(iName, iNumber, iSlogan, iColor, min, max) { }
        }

        public TeslaS modelS;
        public TeslaX modelX;
        public TeslaRoadster2 model2;
        public TeslaRoadster modelR;
        public carPortfolio[] data = new carPortfolio[4];

        public Race(carPortfolio[] iData)
        {
            data = iData;

            int i = 0;
            modelS = new TeslaS(data[i].name, data[i].number, data[i].slogan, data[i].color, data[i].min, data[i++].max);
            modelX = new TeslaX(data[i].name, data[i].number, data[i].slogan, data[i].color, data[i].min, data[i++].max);
            model2 = new TeslaRoadster2(data[i].name, data[i].number, data[i].slogan, data[i].color, data[i].min, data[i++].max);
            modelR = new TeslaRoadster(data[i].name, data[i].number, data[i].slogan, data[i].color, data[i].min, data[i++].max);
        }
        public void divide()
        {
            Console.WriteLine("===========================");
        }
        public void prepare()
        {
            divide();

            prepare participians = new prepare(modelS.prepare);
            participians += modelX.prepare;
            participians += model2.prepare;
            participians += modelR.prepare;
            participians();
        }
        public void start()
        {
            divide();
            for (int i = 0; i < 4; i++)
                Console.WriteLine("|| " + data[i].name + " is #" + data[i].number + Space(18 - data[i].name.Length - data[i].number.ToString().Length) + "||");
            divide();
            Console.Write("||    Race has began!     ||\n");
            divide();
        }
        public void carryOn()
        {
            int position = 0;
            bool was = true;
            while (was)
            {
                was = false;

                Console.Write("||   | ");
                if (modelS.speed >= position)
                {
                    Console.Write("-");
                    was = true;
                }
                else
                    Console.Write(" ");
                Console.Write(" | ");
                if (modelX.speed >= position)
                {
                    Console.Write("-");
                    was = true;
                }
                else
                    Console.Write(" ");
                Console.Write(" | ");
                if (model2.speed >= position)
                {
                    Console.Write("-");
                    was = true;
                }
                else
                    Console.Write(" ");
                Console.Write(" | ");
                if (modelR.speed >= position)
                {
                    Console.Write("-");
                    was = true;
                }
                else
                    Console.Write(" ");
                Console.Write(" |    ||\n");
                System.Threading.Thread.Sleep(50);
                position += 2;
            }
            divide();
        }
        public void finish()
        {
            results[] r = new results[5];
            r[0] = new results(modelS.speed, modelS.number);
            r[1] = new results(modelX.speed, modelX.number);
            r[2] = new results(model2.speed, model2.number);
            r[3] = new results(modelR.speed, modelR.number);

            bool was = true;
            while (was)
            {
                was = false;
                for (int i = 0; i < 3; i++)
                    if (r[i].position < r[i + 1].position)
                    {
                        r[4] = r[i];
                        r[i] = r[i + 1];
                        r[i + 1] = r[4];
                        was = true;
                    }
            }
            for(int i = 0; i<4; i++)
                Console.WriteLine("|| Car #" + r[i].carNumber + " is " + (i + 1) + Space(12) + "||");
            divide();
        }

    }


    struct results
    {
        public int carNumber;
        public int position;
        public results(int pos, int num)
        {
            carNumber = num;
            position = pos;
        }
    }
    struct carPortfolio
    {
        public string name;
        public int number;
        public string slogan;
        public string color;
        public int min;
        public int max;

        public carPortfolio(string iName, int iNumber, string iSlogan, string iColor, int iMin, int iMax)
        {
            name = iName;
            number = iNumber;
            slogan = iSlogan;
            color = iColor;
            min = iMin;
            max = iMax;
        }
    }


    class Program
    {
        static void Main(string[] args)
        {
            carPortfolio[] data = new carPortfolio[4];
            data[0] = new carPortfolio("Tesla Model S", 1, "First indeed!", "grey", 30, 40);
            data[1] = new carPortfolio("Tesla Model X", 2, "Super xXx!", "white", 10, 20);
            data[2] = new carPortfolio("Tesla Roadster 2", 3, "The fasterest!", "red", 50, 70);
            data[3] = new carPortfolio("Tesla Roadster", 4, "Almost perfect car!", "red", 40, 60);
            Race race = new Race(data);

            race.prepare();
            race.start();
            race.carryOn();
            race.finish();


        }
    }

}