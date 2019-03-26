//Xpath
using System.Xml.XPath;

XPathDocument doc = new XPathDocument("Cars.xml");
XPathNavigator nav = doc.CreateNavigator();
XPathNodeIterator iterator = nav.Select("/Cars/Car");
while (iterator.MoveNext())
{
	XPathNodeIterator it = iterator.Current.Select("Manufactured");
	it.MoveNext();
	string manufactured = it.Current.Value;
	it = iterator.Current.Select("Model");
	it.MoveNext();
	string model = it.Current.Value;
	Console.WriteLine("{0} {1}", manufactured, model);
}