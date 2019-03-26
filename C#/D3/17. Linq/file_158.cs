using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace linq
{
    static class helper
    {
        private static Random rnd = new Random();
        public static int generateRandomNumber(int min, int max)
        {
            return rnd.Next(min, max);
        }
        public static int generateRandomNumber(int max)
        {
            return rnd.Next(0, max);
        }
        public static string generateRandomName()
        {
            string[] names = { "Halley Hosley", "Vertie Verges", "Christel Chastain", "Thad Tirrell", "Barrie Billie", "Olga Overfelt", "Stacie Stickel", "Joleen Jakubowski", "Alane Abadie", "Phyliss Padro", "Terina Tallent", "Lieselotte Lanphear", "Diedre Donelan", "Azzie Aschenbrenner", "Tricia Thibeaux", "Vernice Ventura", "Maryrose Millsaps", "Renna Read", "Lanelle Lakey", "Jesica Jeffreys", "Fidelia Feldt", "Lorene Lankford", "Muriel Melby", "Krystal Kestner", "Ranee Rodela", "Lanita Lejeune", "Kim Kaczor", "Jan Jimenez", "Alisia Alonso", "Griselda Gladding", "Gregoria Gormley", "Deandra Deshong", "Carol Chapell", "Latasha Lawson", "Ursula Urrutia", "Takako Toth", "Gerda Goulding", "Porsche Pinto", "Aurora Averett", "Anika Artis", "Christinia Candler", "Herman Holding", "Cathleen Croskey", "Merissa Muncy", "Kelly Kindred", "Taina Tussey", "Noelle Neil", "Marcie Mace", "Georgianne Gallego", "Tawna Twiford" };
            return names[generateRandomNumber(names.Length)];
        }
        public static bool generateRandomBool()
        {
            return rnd.NextDouble() > 0.5;
        }
    }

    class Companies
    {
        public string name { get; set; } = helper.generateRandomName();
        public List<departments> department = new List<departments>();

        public void fillRandomData()
        {
            int numberOfDepartments = helper.generateRandomNumber(5,10);
            for(int i = 0; i < numberOfDepartments; i++)
            {
                departments tempDepartment = new departments();

                tempDepartment.name = helper.generateRandomName();

                int numberOfUnits = helper.generateRandomNumber(3,6);
                for(int ii = 0; ii < numberOfUnits; ii++)
                {
                    units tempUnit = new units();

                    tempUnit.manager.fullName = helper.generateRandomName();
                    tempUnit.manager.dateIn = helper.generateRandomNumber(1000000, 2000000);
                    tempUnit.manager.sallary = helper.generateRandomNumber(1, 50) * 1000;
                    tempUnit.manager.sex = helper.generateRandomBool();

                    int numberOfWorkerss = helper.generateRandomNumber(10,35);
                    for(int iii = 0; iii < numberOfWorkerss; iii++)
                    {
                        workers tempWorker = new workers();

                        tempWorker.fullName = helper.generateRandomName();
                        tempWorker.dateIn = helper.generateRandomNumber(1000000, 2000000);
                        tempWorker.sallary = helper.generateRandomNumber(1, 30) * 1000;
                        tempWorker.sex = helper.generateRandomBool();

                        tempUnit.worker.Add(tempWorker);
                    }

                    tempDepartment.unit.Add(tempUnit);
                }

                department.Add(tempDepartment);
            }
        }

        public void query1()
        {

            //Console.WriteLine(company.department[0].GetHashCode());
            //Console.WriteLine(company.department[1].GetHashCode());
            //var query = from element in department.unit.worker.Sum(item => item.Salary);
            int value = 0;
            /*for (int i = 0; i < department.Capacity; i++)
            {
                for(int ii = 0; ii < department[i].unit.Capacity; ii++)
                {
                    for(int iii = 0; iii < department[i].unit[ii].worker.Capacity; iii++)
                    {
                        var query = from v in department[i].unit[ii].worker[iii].sallary orderby sallary ascending select sallary;
                        int value = 0;
                    }
                }
            }*/
            int biggestVal = 0;
            int biggestId = -1;
            for (int i = 0; i < department.Count; i++)
            {
                value = 0;

                foreach (units u in department[i].unit)
                {
                    value += u.manager.sallary;
                    //var query = from v in u.worker.salary.Sum() select v;
                    foreach (workers w in u.worker)
                        value += w.sallary;
                }

                if (value > biggestVal)
                {
                    biggestVal = value;
                    biggestId = i;
                }
            }
            Console.WriteLine("Most profitable department name: " + department[biggestId].name + ". Proffits: " + biggestVal);
            /*foreach (departments d in department) {
                foreach(units u in d.unit)
                {
                    foreach(workers w in u.worker)
                    {

                    }
                }
            }*/
        }
        public void query2()
        {
            long sum = 0;
            float avg = 0;
            foreach (departments d in department)
            {
                sum = 0;
                foreach (units u in d.unit)
                {
                    sum += u.manager.sallary;
                    foreach (workers w in u.worker)
                        sum += w.sallary;
                }

                avg = sum / d.unit.Count;
                Console.WriteLine("Average revenue of department with name of " + d.name + ": " + avg);
            }

        }
        public void query3()
        {

            int value;
            long localMaxSum = 0;

            for (int i = 0; i < department.Count; i++)
            {
                localMaxSum = 0;

                for (int ii = 0; ii < department[i].unit.Count; ii++)
                {
                    value = department[i].unit[ii].manager.sallary;
                    foreach (workers w in department[i].unit[ii].worker)
                        value += w.sallary;
                    if(value > localMaxSum)
                        localMaxSum = value;
                }

                Console.WriteLine("Most profitable unit of department with name " + department[i].name + " earns " + localMaxSum);
            }
        }
        public void query4()
        {
            int biggestId = -1;
            int biggestValue = 0;
            int smallest;
            int biggest;

            for(int i = 0; i < department.Count; i++)
            {
                smallest = 100000;
                biggest = 0;
                foreach (units u in department[i].unit)
                {
                    biggest = u.manager.sallary;
                    foreach(workers w in u.worker)
                    {
                        if (w.sallary > biggest)
                            biggest = w.sallary;
                        if (w.sallary < smallest)
                            smallest = w.sallary;
                    }
                }
                if(biggest - smallest > biggestValue)
                {
                    biggestValue = biggest - smallest;
                    biggestId = i;
                }
            }

            Console.WriteLine(department[biggestId].name + " is department with biggest difference in earnngs of workers. Difference: " + biggestValue);
        }
        public void query5()
        {
            foreach(departments d in department)
            {
                int countT = 0, countF = 0;

                foreach (units u in d.unit)
                {
                    foreach (workers w in u.worker)
                    {
                        if (w.sex)
                            countT++;
                        else
                            countF++;
                    }
                }

                Console.WriteLine("In department with name " + d.name + " there are " + 100*countT/(countT+countF) + "% of men");
            }
        }
    }

    class departments
    {
        public string name { get; set; }
        public List<units> unit = new List<units>();
    }
    class units
    {
        public managers manager = new managers();
        public List<workers> worker = new List<workers>();

    }
    class managers : people
    {
        public managers()
        {
            role = "Manager";
        }
    }
    class workers : people
    {
        public workers()
        {
            role = "Worker";
        }
    }
    class people
    {
        public string fullName { get; set; }
        public long dateIn { get; set; }
        public int sallary { get; set; }
        public bool sex { get; set; }
        public string role { get; set; }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Companies company = new Companies();
            company.fillRandomData();
            int i;
            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Get name of company");
                Console.WriteLine("2. Set name of company");
                Console.WriteLine("3. Show department with biggest revenue");
                Console.WriteLine("4. Show average revenue of each department");
                Console.WriteLine("5. Show the most profitable unit of each department");
                Console.WriteLine("6. Show department with biggest difference in revenue");
                Console.WriteLine("7. Show persantage of men in each department");
                Console.WriteLine("0. Exit");
                i = Convert.ToInt32(Console.ReadLine());
                Console.Clear();
                switch (i)
                {
                    case 1:
                        Console.WriteLine(company.name);
                        break;
                    case 2:
                        company.name = Console.ReadLine();
                        break;
                    case 3:
                        company.query1();
                        break;
                    case 4:
                        company.query2();
                        break;
                    case 5:
                        company.query3();
                        break;
                    case 6:
                        company.query4();
                        break;
                    case 7:
                        company.query5();
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