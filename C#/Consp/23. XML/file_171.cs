//XML

using System;
using System.Text;
using System.Xml;

//XmlReader
XmlReader xmlReader = XmlReader.Create("http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml");
while(xmlReader.Read())
	if((xmlReader.NodeType == XmlNodeType.Element) && (xmlReader.Name == "Cube"))
		if(xmlReader.HasAttributes)
			Console.WriteLine(xmlReader.GetAttribute("currency") + ": " + xmlReader.GetAttribute("rate"));


//XmlDocument
XmlDocument xmlDoc = new XmlDocument();
xmlDoc.Load("http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml");
foreach(XmlNode xmlNode in xmlDoc.DocumentElement.ChildNodes[2].ChildNodes[0].ChildNodes)
	Console.WriteLine(xmlNode.Attributes["currency"].Value + ": " + xmlNode.Attributes["rate"].Value);


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.LoadXml("<user name=\"A\">B</user>");
Console.WriteLine(xmlDoc.DocumentElement.Name);//A
Console.WriteLine(xmlDoc.DocumentElement.InnerText);//B


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.LoadXml("<user><a>C</a></user>");
Console.WriteLine(xmlDoc.DocumentElement.InnerXML);//<a>C</a>
Console.WriteLine(xmlDoc.DocumentElement.OuterXML);//<user><a>C</a></user>


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.LoadXml("<user name=\"John Doe\" age=\"42\"></user>");
if(xmlDoc.DocumentElement.Attributes["name"] != null)
	Console.WriteLine(xmlDoc.DocumentElement.Attributes["name"].Value);
if(xmlDoc.DocumentElement.Attributes["age"] != null)
	Console.WriteLine(xmlDoc.DocumentElement.Attributes["age"].Value);


//XmlNode
XmlDocument xmlDoc = new XmlDocument();
xmlDoc.Load("http://rss.cnn.com/rss/edition_world.rss");
XmlNode titleNode = xmlDoc.SelectSingleNode("//rss/channel/title");
if(titleNode != null)
	Console.WriteLine(titleNode.InnerText);


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.Load("http://rss.cnn.com/rss/edition_world.rss");
XmlNodeList itemNodes = xmlDoc.SelectNodes("//rss/channel/item");
foreach(XmlNode itemNode in itemNodes){
	XmlNode titleNode = itemNode.SelectSingleNode("title");
	XmlNode dateNode = itemNode.SelectSingleNode("pubDate");
	if((titleNode != null) && (dateNode != null))
		Console.WriteLine(dateNode.InnerText + ": " + titleNode.InnerText);
}


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.Load("http://rss.cnn.com/rss/edition_world.rss");
XmlNodeList titleNodes = xmlDoc.SelectNodes("//rss/channel/item/title");
foreach(XmlNode titleNode in titleNodes)
	Console.WriteLine(titleNode.InnerText);


XmlWriter xmlWriter = XmlWriter.Create("test.xml");

xmlWriter.WriteStartDocument();
xmlWriter.WriteStartElement("users");

xmlWriter.WriteStartElement("user");
xmlWriter.WriteAttributeString("age", "42");
xmlWriter.WriteString("John Doe");
xmlWriter.WriteEndElement();

xmlWriter.WriteStartElement("user");
xmlWriter.WriteAttributeString("age", "39");
xmlWriter.WriteString("Jane Doe");

xmlWriter.WriteEndDocument();
xmlWriter.Close();

/*
<users>
  <user age="42">John Doe</user>
  <user age="39">Jane Doe</user>
</users>
*/


XmlDocument xmlDoc = new XmlDocument();
XmlNode rootNode = xmlDoc.CreateElement("users");
xmlDoc.AppendChild(rootNode);

XmlNode userNode = xmlDoc.CreateElement("user");
XmlAttribute attribute = xmlDoc.CreateAttribute("age");
attribute.Value = "42";
userNode.Attributes.Append(attribute);
userNode.InnerText = "John Doe";
rootNode.AppendChild(userNode);

userNode = xmlDoc.CreateElement("user");
attribute = xmlDoc.CreateAttribute("age");
attribute.Value = "39";
userNode.Attributes.Append(attribute);
userNode.InnerText = "Jane Doe";
rootNode.AppendChild(userNode);

xmlDoc.Save("test-doc.xml");

/*
<users>
  <user age="42">John Doe</user>
  <user age="39">Jane Doe</user>
</users>
*/


XmlDocument xmlDoc = new XmlDocument();
xmlDoc.Load("test-doc.xml");
XmlNodeList userNodes = xmlDoc.SelectNodes("//users/user");
foreach(XmlNode userNode in userNodes){
	int age = int.Parse(userNode.Attributes["age"].Value);
	userNode.Attributes["age"].Value = (age + 1).ToString();
}
xmlDoc.Save("test-doc.xml");


using (StringWriter str = new StringWriter())
using (XmlTextWriter xml = new XmlTextWriter(str)){
	xml.WriteStartDocument();
	xml.WriteStartElement("List");
	xml.WriteWhitespace("\n");

	foreach (var element in array){
		xml.WriteStartElement("Employee");

		xml.WriteElementString("ID", element.Item1.ToString());
		xml.WriteElementString("First", element.Item2);
		xml.WriteWhitespace("\n  ");
		xml.WriteElementString("Last", element.Item3);
		xml.WriteElementString("Salary", element.Item4.ToString());

		xml.WriteEndElement();
		xml.WriteWhitespace("\n");
	}

	xml.WriteEndElement();
	xml.WriteEndDocument();

	string result = str.ToString();
	Console.WriteLine("Length: {0}", result.Length);
	Console.WriteLine("Result: {0}", result);
}