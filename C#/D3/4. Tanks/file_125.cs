using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace main
{

    class Tank
    {
        private string name;
        private int armor;
        private int bullets;
        private int speed;
        public Tank(string iName, int iArmor, int iBullets, int iSpeed)
        {
            name = iName;
            armor = iArmor;
            bullets = iBullets;
            speed = iSpeed;
        }
        public Tank()
        {
            name = "";
            armor = 0;
            bullets = 0;
            speed = 0;
        }
        public Tank(Tank buf)
        {
            name = buf.name;
            armor = buf.armor;
            bullets = buf.bullets;
            speed = buf.speed;
        }
        public string getName()
        {
            return name;
        }
        public void setName(string iName)
        {
            name = iName;
        }
        public int getArmor()
        {
            return armor;
        }
        public void setArmor(int iArmor)
        {
            armor = iArmor;
        }
        public int getBullets()
        {
            return bullets;
        }
        public void setBullets(int iBullets)
        {
            bullets = iBullets;
        }
        public int getSpeed()
        {
            return speed;
        }
        public void setSpeed(int iSpeed)
        {
            speed = iSpeed;
        }
        public string getFullStats() {
            return "Name: " + getName() + "\n" +
                "Armor: " + getArmor() + "\n" +
                "Bullets: " + getBullets() + "\n" +
                "Speed: " + getSpeed();
        }
        public void remove(int value)
        {
            bullets *= (1 - value);
            speed *= (1 - value);
            armor *= (1 - value);

            if (value == 1)
                Console.WriteLine(name + " is destoyed");
        }
        public static bool operator ^ (Tank p1, Tank p2)
        {
            int count = 0;
            if (p1.getArmor() > p2.getArmor())
                count++;
            else
                count--;
            if (p1.getBullets() > p2.getBullets())
                count++;
            else
                count--;
            if (p1.getSpeed() > p2.getSpeed())
                count++;
            else
                count--;

            if (count == 3)
            {
                p1.remove(1/3);
                p2.remove(1);
                return true;
            }
            else if(count == -3)
            {
                p2.remove(1 / 3);
                p1.remove(1);
                return false;
            }
            else if (count == 2)
            {
                p1.remove(1 / 2);
                p2.remove(1);
                return true;
            }
            else if (count == -2)
            {
                p2.remove(1 / 2);
                p1.remove(1);
                return false;
            }
            else if (count == 1)
            {
                p1.remove(2 / 3);
                p2.remove(1);
                return true;
            }
            else if (count == -1)
            {
                p2.remove(2 / 3);
                p1.remove(1);
                return false;
            }
            /*else
            {
                p1.remove(1);
                p2.remove(1);
                return false;
            }*/
            return false;
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            const int COUNT = 5;

            Tank[] oswald = new Tank[COUNT];
            Tank[] molot = new Tank[COUNT];

            Tank buf1 = new Tank();
            Tank buf2 = new Tank();

            int[] count = new int[2];

            Random rnd = new Random();

            for (int i = 0; i < COUNT; i++)
            {
                oswald[i] = new Tank();
                molot[i] = new Tank();

                oswald[i].setName("Oswald #" + i);
                oswald[i].setArmor(rnd.Next(1, 101));
                oswald[i].setBullets(rnd.Next(1, 101));
                oswald[i].setSpeed(rnd.Next(1, 101));

                molot[i].setName("Molot #" + i);
                molot[i].setArmor(rnd.Next(1, 101));
                molot[i].setBullets(rnd.Next(1, 101));
                molot[i].setSpeed(rnd.Next(1, 101));

                Console.WriteLine("______");

                if (oswald[i] ^ molot[i])
                    count[0]++;
                else
                    count[1]++;

                Console.WriteLine(oswald[i].getFullStats());
                Console.WriteLine(molot[i].getFullStats());
                
                /*Console.WriteLine(oswald[i].getName());
                Console.WriteLine(oswald[i].getArmor());
                Console.WriteLine(oswald[i].getSpeed());
                Console.WriteLine(oswald[i].getBullets());
                Console.WriteLine("___");
                Console.WriteLine(molot[i].getName());
                Console.WriteLine(molot[i].getArmor());
                Console.WriteLine(molot[i].getSpeed());
                Console.WriteLine(molot[i].getBullets());*/
            }
            Console.WriteLine("\nScore:\n\tOswalds - {0}\n\tMolots - {1}\n", count[0], count[1]);
            if (count[0] > count[1])
                Console.WriteLine("Oswalds Win");
            else
                Console.WriteLine("Molots Win");
        }
    }

}