
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.XPath;

namespace XML2
{
    class Program
    {
        static void Main(string[] args)
        {
            XPathDocument doc = new XPathDocument("http://resources.finance.ua/ua/public/currency-cash.xml");
            XPathNavigator nav = doc.CreateNavigator();
            foreach (XPathNavigator n in nav.Select("//organization"))
            {
                Console.WriteLine("Name: " + n.SelectSingleNode("title").GetAttribute("value",""));
                foreach(XPathNavigator n2 in n.Select("currencies/c"))
                    if(n2.GetAttribute("title","").Length<1)
                        Console.WriteLine("\tId: " + n2.GetAttribute("id","") + "\tBr: " + n2.GetAttribute("br", "") + "\tAr: " + n2.GetAttribute("ar", ""));
            }
        }
    }
}
