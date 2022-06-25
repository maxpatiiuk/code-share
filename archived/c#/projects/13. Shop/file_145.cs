using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace shopProject
{

    class Shops
    {
        public List<products> product = new List<products>();
        public List<developers> developer = new List<developers>();
        public List<logs> log = new List<logs>();
        public List<sells> sell = new List<sells>();

        public void addP(products p)
        {
            product.Add(p);
        }
        public void removeP(int id)
        {
            product.RemoveAt(id);
        }
        public void showP()
        {
            Console.WriteLine("#\tName\tCategory\tPrice\tDeveloper\tExpiry\tCount");
            for (int i = 0; i < product.Count; i++)
                Console.WriteLine(i + "\t" + product[i].name + "\t" + product[i].category + "\t" + product[i].price + "\t" + developer[product[i].developer].name + "\t" + product[i].count);
        }


        public void addD(developers d)
        {
            developer.Add(d);
        }
        public void removeD(int id)
        {
            developer.RemoveAt(id);
        }
        public void showD()
        {
            Console.WriteLine("#\tName\tCountry\tCity");
            for (int i = 0; i < developer.Count; i++)
                Console.WriteLine(i + "\t" + developer[i].name + "\t" + developer[i].country + "\t" + developer[i].city);
        }


        public void addL(logs l)
        {
            log.Add(l);
        }
        public void removeL(int id)
        {
            log.RemoveAt(id);
        }
        public void showL()
        {
            Console.WriteLine("#\tProduct Name\tDate in");
            for (int i = 0; i < log.Count; i++)
                Console.WriteLine(i + "\t" + product[log[i].product].name + "\t" + log[i].dateIn);
        }


        public void addS(sells s)
        {
            sell.Add(s);
        }
        public void removeS(int id)
        {
            sell.RemoveAt(id);
        }
        public void showS()
        {
            Console.WriteLine("#\tProduct Name\tOwner");
            for (int i = 0; i < sell.Count; i++)
                Console.WriteLine(i + "\t" + product[sell[i].product].name + "\t" + sell[i].owner);
        }


        public void showExpired()
        {
            Console.WriteLine("#\tName\tCategory\tPrice\tDeveloper\tExpiry");
            for (int i = 0; i < product.Count; i++)
                if(product[i].count==0)
                    Console.WriteLine(i + "\t" + product[i].name + "\t" + product[i].category + "\t" + product[i].price + "\t" + developer[product[i].developer].name);
        }
    }

    struct products
    {
        public string name;
        public string category;
        public float price;
        public int developer;
        public string expiry;
        public int count;

        public products(string name, string category, float price, int developer, string expiry, int count)
        {
            this.name = name;
            this.category = category;
            this.price = price;
            this.developer = developer;
            this.expiry = expiry;
            this.count = count;
        }
    }

    struct developers
    {
        public string name;
        public string country;
        public string city;

        public developers(string name, string country, string city)
        {
            this.name = name;
            this.country = country;
            this.city = city;
        }
    }

    struct logs
    {
        public int product;
        public string dateIn;

        public logs(int product, string dateIn)
        {
            this.product = product;
            this.dateIn = dateIn;
        }
    }

    struct sells
    {
        public int product;
        public string owner;

        public sells(int product, string owner)
        {
            this.product = product;
            this.owner = owner;
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Shops shop = new Shops();
            products product = new products();
            developers developer = new developers();
            logs log = new logs();
            sells sell = new sells();

            int i;
            string buf;
            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Show out of stock products");
                Console.WriteLine("----");
                Console.WriteLine("2. Add product");
                Console.WriteLine("3. Remove product");
                Console.WriteLine("4. Print products");
                Console.WriteLine("----");
                Console.WriteLine("5. Add developer");
                Console.WriteLine("6. Remove developer");
                Console.WriteLine("7. Print developers");
                Console.WriteLine("----");
                Console.WriteLine("8. Add to log");
                Console.WriteLine("9. Remove from log");
                Console.WriteLine("10. Print log");
                Console.WriteLine("----");
                Console.WriteLine("11. Add to sells");
                Console.WriteLine("12. Remove from sells");
                Console.WriteLine("13. Print sells");
                Console.WriteLine("----");
                Console.WriteLine("0. Exit");
                do
                {
                    buf = Console.ReadLine();
                } while (!Int32.TryParse(buf, out i));
                Console.Clear();
                switch (i)
                {
                    case 1:
                        shop.showExpired();
                        break;
                    case 2:
                        product = new products();
                        Console.WriteLine("List of developers");
                        shop.showD();
                        Console.WriteLine("Name:");
                        product.name = Console.ReadLine();
                        Console.WriteLine("Category:");
                        product.category = Console.ReadLine();
                        Console.WriteLine("Price:");
                        product.price = float.Parse(Console.ReadLine());
                        Console.WriteLine("Id of Developer:");
                        product.developer = Convert.ToInt32(Console.ReadLine());
                        Console.WriteLine("Expiry:");
                        product.expiry = Console.ReadLine();
                        Console.WriteLine("Count:");
                        product.count = Convert.ToInt32(Console.ReadLine());
                        shop.addP(product);
                        break;
                    case 3:
                        shop.showP();
                        shop.removeP(Convert.ToInt32(Console.ReadLine()));
                        break;
                    case 4:
                        shop.showP();
                        break;
                    case 5:
                        developer = new developers();
                        Console.WriteLine("Name:");
                        developer.name = Console.ReadLine();
                        Console.WriteLine("Country:");
                        developer.country = Console.ReadLine();
                        Console.WriteLine("City:");
                        developer.city = Console.ReadLine();
                        shop.addD(developer);
                        break;
                    case 6:
                        shop.showD();
                        shop.removeD(Convert.ToInt32(Console.ReadLine()));
                        break;
                    case 7:
                        shop.showD();
                        break;
                    case 8:
                        log = new logs();
                        Console.WriteLine("List of products");
                        shop.showP();
                        Console.WriteLine("Id of product:");
                        log.product = Convert.ToInt32(Console.ReadLine());
                        Console.WriteLine("Date in:");
                        log.dateIn = Console.ReadLine();
                        shop.addL(log);
                        break;
                    case 9:
                        shop.showL();
                        shop.removeL(Convert.ToInt32(Console.ReadLine()));
                        break;
                    case 10:
                        shop.showL();
                        break;
                    case 11:
                        sell = new sells();
                        Console.WriteLine("List of products");
                        shop.showP();
                        Console.WriteLine("Id of product:");
                        sell.product = Convert.ToInt32(Console.ReadLine());
                        Console.WriteLine("Name of buyer:");
                        sell.owner = Console.ReadLine();
                        shop.addS(sell);
                        break;
                    case 12:
                        shop.showS();
                        shop.removeS(Convert.ToInt32(Console.ReadLine()));
                        break;
                    case 13:
                        shop.showS();
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