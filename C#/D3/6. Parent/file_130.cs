using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace parrents
{

    public abstract class Storages
    {
        public string Name { get; set; }
        public string Brand { get; set; }
        public Storages(string iName, string iBrand)
        {
            Name = iName;
            Brand = iBrand;
        }
        public Storages()
        {
            Name = "";
            Brand = "";
        }
        public Storages(Storages buf)
        {
            Name = buf.Name;
            Brand = buf.Brand;
        }
        public virtual string getInfo()
        {
            return "Name: " + Name + "\n" +
                "Brand: " + Brand;
        }
        public virtual float getSize()
        {
            return 0;
        }
        public virtual float getSpeed()
        {
            return 0;
        }
    }

    class Flash : Storages
    {
        public float Size { get; set; }
        public float Speed { get; set; }
        public Flash(): base("Flash","Bit") {
            Size = 10;
            Speed = 5.7f;
        }
        public Flash(float iSize, float iSpeed, String iName, String iBrand) :
            base(iName,iBrand)
        {
            Size = iSize;
            Speed = iSpeed;
        }
        public override String getInfo()
        {
            return base.getInfo() + "\n" +
                "Size: " + getSize() + " gb \n" +
                "Speed: " + Speed + "gb/s";
        }
        public override float getSize()
        {
            return Size;
        }
        public override float getSpeed()
        {
            return Speed;
        }
    }
    class Dvd : Storages
    {
        public bool isBiliteral { get; set; }
        public float ReadSpeed { get; set; }
        public float WriteSpeed { get; set; }
        public Dvd() : base("DVD", "Bit")
        {
            isBiliteral = false;
            ReadSpeed = 5.7f;
            WriteSpeed = 3.4f;
        }
        public Dvd(bool iIsBiliteral, float iReadSpeed, float iWriteSpeed, String iName, String iBrand) :
            base(iName, iBrand)
        {
            isBiliteral = iIsBiliteral;
            ReadSpeed = iReadSpeed;
            WriteSpeed = iWriteSpeed;
        }
        public override String getInfo()
        {
            return base.getInfo() + "\n" +
                "Is biliteral: " + isBiliteral+ "\n" +
                "Size " + getSize() + "gb \n"+
                "Read speed: " + ReadSpeed + "gb/s\n" +
                "Write speed: " + WriteSpeed + "gb/s";
        }
        public override float getSize()
        {
            if (isBiliteral)
                return 9;
            else
                return 4.7f;
        }
        public float getSpeed(bool type)
        {
            if(type)
                return ReadSpeed;
            else
                return WriteSpeed;
        }
    }
    class Hdd : Storages
    {
        public float Size { get; set; }
        public int Partitions { get; set; }
        public float Speed { get; set; }
        public Hdd() : base("Hdd", "Bit")
        {
            Size = 10;
            Speed = 5.7f;
            Partitions = 1024;
        }
        public Hdd(float iSize, float iSpeed, int iPartitions, String iName, String iBrand) :
            base(iName, iBrand)
        {
            Size = iSize;
            Speed = iSpeed;
            Partitions = iPartitions;
        }
        public override String getInfo()
        {
            return base.getInfo() + "\n" +
                "Size: " + getSize() + " gb \n" +
                "Speed: " + Speed + "gb/s";
        }
        public override float getSize()
        {
            return Size * Partitions;
        }
        public override float getSpeed()
        {
            return Speed;
        }
    }


    class Program
    {
        static void Main(string[] args)
        {
            ///Storages storage = new Storages();
            object[] obj = new object[3];
            obj[0] = new Flash();
            obj[1] = new Dvd();
            obj[2] = new Hdd();
            int i;
            int drive = 0;
            String[] driveName = { "Flash", "DVD", "HDD" };
            Console.WriteLine("Flash speed: ");
            (obj[0] as Flash).Speed = (float)Convert.ToDouble(Console.ReadLine());
            Console.WriteLine("Flash size: ");
            (obj[0] as Flash).Size = float.Parse(Console.ReadLine());
            Console.WriteLine("Dvd speed of read: ");
            (obj[1] as Dvd).ReadSpeed = float.Parse(Console.ReadLine());
            Console.WriteLine("Dvd speed of write: ");
            (obj[1] as Dvd).WriteSpeed = float.Parse(Console.ReadLine());
            Console.WriteLine("Is Dvd biliteral (0/1): ");
            (obj[1] as Dvd).isBiliteral= Convert.ToBoolean(Convert.ToInt32(Console.ReadLine()));
            Console.WriteLine("Hdd speed: ");
            (obj[2] as Hdd).Speed = float.Parse(Console.ReadLine());
            Console.WriteLine("Hdd number of partions: ");
            (obj[2] as Hdd).Partitions = Convert.ToInt32(Console.ReadLine());
            Console.WriteLine("Hdd size of partion: ");
            (obj[2] as Hdd).Size = float.Parse(Console.ReadLine());

            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Change Drive. Selected: " + driveName[drive]);
                Console.WriteLine("2. Get size");
                Console.WriteLine("3. Calculate time");
                Console.WriteLine("4. Get properties");
                Console.WriteLine("5. Calculate which data unit will be needed for this file");
                Console.WriteLine("6. Get name");
                Console.WriteLine("7. Set name");
                Console.WriteLine("8. Get brand");
                Console.WriteLine("9. Set brand");
                Console.WriteLine("0. Exit");
                i = Convert.ToInt32(Console.ReadLine());
                Console.Clear();
                switch (i)
                {
                    case 1:
                        Console.WriteLine("1. {0}\n2. {1}\n3. {2}",driveName[0], driveName[1], driveName[2]);
                        i = Convert.ToInt32(Console.ReadLine());
                        Console.Clear();
                        if (i >= 1 && i <= 3)
                            drive = i - 1;
                        break;
                    case 2:
                        Console.Write((obj[drive] as Storages).getSize());
                        break;
                    case 3:
                        Console.Write((obj[drive] as Storages).getSpeed() * (obj[drive] as Storages).getSize());
                        break;
                    case 4:
                        Console.Write((obj[drive] as Storages).getInfo());
                        break;
                    case 5:
                        int tempSize = Convert.ToInt32(Console.ReadLine());
                        if (tempSize < (obj[0] as Storages).getSize())
                            Console.WriteLine(driveName[0]);
                        else if (tempSize < (obj[1] as Storages).getSize())
                            Console.WriteLine(driveName[1]);
                        else if (tempSize < (obj[2] as Storages).getSize())
                            Console.WriteLine(driveName[2]);
                        break;
                    case 6:
                        Console.WriteLine((obj[drive] as Storages).Name);
                        break;
                    case 7:
                        (obj[drive] as Storages).Name = Console.ReadLine();
                        break;
                    case 8:
                        Console.WriteLine((obj[drive] as Storages).Brand);
                        break;
                    case 9:
                        (obj[drive] as Storages).Brand = Console.ReadLine();
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
