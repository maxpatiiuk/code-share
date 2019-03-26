using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Interfaces
{
    public interface IWorker
    {
        string Name { get; set; }
        string SurName { get; set; }
        int Type { get; set; }
    }
    public interface IPart
    {
        string Name { get; set; }
        bool IsFinished { get; set; }
        string DoneBy { get; set; }
    }

    class Basement : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Basement()
        {
            IsFinished = false;
            Name = "Basement";
        }
    }

    class Wall : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Wall()
        {
            IsFinished = false;
            Name = "Wall";
        }
    }

    class Door : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Door()
        {
            IsFinished = false;
            Name = "Door";
        }
    }
    class Window : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Window()
        {
            IsFinished = false;
            Name = "Window";
        }
    }
    class Roof : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Roof()
        {
            IsFinished = false;
            Name = "Roof";
        }
    }

    class House : IPart
    {
        public string Name { get; set; }
        public bool IsFinished { get; set; }
        public string DoneBy { get; set; }

        public Basement basement = new Basement();
        public Wall[] Walls = new Wall[4];
        public Door door = new Door();
        public Window[] Windows = new Window[4];
        public Roof roof = new Roof();

        public House(string vName)
        {
            Name = vName;

            for (int i = 0; i < 4; i++)
            {
                Walls[i] = new Wall();
                Windows[i] = new Window();
            }
        }
    }

    class Worker: IWorker{
        public string Name { get; set; }
        public string SurName { get; set; }
        public int Type { get; set; }

        public Worker(string vName, string vSurName)
        {
            Name = vName;
            SurName = vSurName;
            Type = 0;
        }
    }
    class TeamLeader : IWorker
    {
        public string Name { get; set; }
        public string SurName { get; set; }
        public int Type { get; set; }

        public TeamLeader(string vName, string vSurName)
        {
            Name = vName;
            SurName = vSurName;
            Type = 1;
        }
    }

    class Team: IWorker
    {
        public House Building;
        public Worker[] Workers;
        public TeamLeader Leader;
        public string Name { get; set; }
        public string SurName { get; set; }
        public int Type { get; set; }

        public int DayOfWork { get; set; }

        public Team(string vName, string vSurName)
        {
            Workers = new Worker[11];
            for(int i = 0; i < 11; i++)
            {
                Workers[i] = new Worker("Worker", "#"+(i+1));
            }
            Leader = new TeamLeader("Team", "Leader");
            Name = vName;
            SurName = vSurName;
            Building = new House("Real House");
            Type = 1;
            DayOfWork = 1;

        }
        public void Build()
        {
            if(DayOfWork%3 == 0)
            {
                Console.WriteLine("=========");
                Console.WriteLine();
                Console.WriteLine("Team Leader started checking the building process");
                Console.WriteLine();

                if (Building.basement.IsFinished)
                    Console.WriteLine("{0} was finished by {1}",Building.basement.Name, Building.basement.DoneBy);
                for(int i = 0; i < 4; i++) {
                    if (Building.Walls[i].IsFinished)
                        Console.WriteLine("{0} was finished by {1}", Building.Walls[i].Name, Building.Walls[i].DoneBy);
                }
                if (Building.door.IsFinished)
                    Console.WriteLine("{0} was finished by {1}", Building.door.Name, Building.door.DoneBy);
                for (int i = 0; i < 4; i++)
                {
                    if (Building.Windows[i].IsFinished)
                        Console.WriteLine("{0} was finished by {1}", Building.Windows[i].Name, Building.Windows[i].DoneBy);
                }
                if (Building.roof.IsFinished)
                    Console.WriteLine("{0} was finished by {1}", Building.roof.Name, Building.roof.DoneBy);

                Console.WriteLine();
                Console.WriteLine("=========");
            }
            else
            {
                switch (DayOfWork)
                {
                    case 1:
                        Building.basement.DoneBy = Workers[0].Name + ' ' + Workers[0].SurName;
                        Building.basement.IsFinished = true;
                        break;
                    case 2:
                        Building.Walls[0].DoneBy = Workers[1].Name + ' ' + Workers[1].SurName;
                        Building.Walls[0].IsFinished = true;
                        break;
                    case 4:
                        Building.Walls[1].DoneBy = Workers[2].Name + ' ' + Workers[2].SurName;
                        Building.Walls[1].IsFinished = true;
                        break;
                    case 5:
                        Building.Walls[2].DoneBy = Workers[3].Name + ' ' + Workers[3].SurName;
                        Building.Walls[2].IsFinished = true;
                        break;
                    case 7:
                        Building.Walls[3].DoneBy = Workers[4].Name + ' ' + Workers[4].SurName;
                        Building.Walls[3].IsFinished = true;
                        break;
                    case 8:
                        Building.door.DoneBy = Workers[5].Name + ' ' + Workers[5].SurName;
                        Building.door.IsFinished = true;
                        break;
                    case 10:
                        Building.Windows[0].DoneBy = Workers[6].Name + ' ' + Workers[6].SurName;
                        Building.Windows[0].IsFinished = true;
                        break;
                    case 11:
                        Building.Windows[1].DoneBy = Workers[7].Name + ' ' + Workers[7].SurName;
                        Building.Windows[1].IsFinished = true;
                        break;
                    case 13:
                        Building.Windows[2].DoneBy = Workers[8].Name + ' ' + Workers[8].SurName;
                        Building.Windows[2].IsFinished = true;
                        break;
                    case 14:
                        Building.Windows[3].DoneBy = Workers[9].Name + ' ' + Workers[9].SurName;
                        Building.Windows[3].IsFinished = true;
                        break;
                    case 16:
                        Building.roof.DoneBy = Workers[10].Name + ' ' + Workers[10].SurName;
                        Building.roof.IsFinished = true;
                        break;
                    case 17:
                        Building.DoneBy = this.Name + ' ' + this.SurName;
                        Building.IsFinished = true;
                        break;
                }
            }
            DayOfWork++;
        }

    }

    class Program
    {
        static void Main(string[] args)
        {
            Team main = new Team("Main","Team");
            Console.WriteLine("{0} {1} started working on {2}",main.Name, main.SurName, main.Building.Name);
            while (!main.Building.IsFinished)
            {
                main.Build();
            }
            Console.WriteLine("{0} {1} finished working on {2}", main.Name, main.SurName, main.Building.Name);
        }
    }

}