//collection classes
//ArrayList Hashtable Stack Queue SortedList


ArrayList arr = new ArrayList();
Console.Write(arr.Capacity);
ArrayList arr1 = new ArrayList(5);
arr.Add("word");
arr.Capacity = 17;
arr.AddRange(new int[] { 1, 2, 3 });
arr.AddRange(arr1);
arr.TrimToSize();//remove useless elements
arr.Reverse();
Console.WriteLine(arr.Count);//count assignet elements

ArrayList arr = new ArrayList();
arr.Add("one");
arr.Add(10);
arr.Add(true);
Console.WriteLine(arr[0].ToString());
int i = (int)arr[1];//10
ArrayList arr1 = new ArrayList(arr.GetRange(0,3));
arr1.Insert(2/*pos*/, 22/*value*/);
numbers.RemoveAt(2);

ArrayList arr = new ArrayList(new int[] { 5, 7, 4 });
arr.Sort();


Stack s = new Stack();
Stack s = new Stack(5);
s.Push("one");
foreach (string str in s)
	Console.WriteLine(str);
s.Pop();//get last with removing it from stack
(string)s.Peek();//get last element without removing
s.Contains("ten");//true|false
Stack s2 = new Stack();
s.CopyTo(і2, 0);
s.Clear();


Queue q = new Queue();
q.Enqueue(i);
q.Dequeue();
q.Contains(2)l
q.Peek();

SortedList list = new SortedList();
list.Add("Me", "Anastasia");
Console.WriteLine(list.Capacity);

SortedList list = new SortedList();
list.Add(2, 20);
list.Add(1, 100);
list.Add(3, 3);
foreach (int i in list.GetKeyList())
	Console.WriteLine(i);
foreach (int i in list.GetValueList())
	Console.WriteLine(i);
for (int i = 0; i < list.Count; i++)
	Console.WriteLine("Key- " + list.GetKey(i) + " Value - " + list.GetByIndex(i));

list.RemoveAt(1);//by key
list.Remove(3);//by index


Hashtable hash = new Hashtable();//consist ofobjects
hash.Add(1, "one");
foreach (object o in hash.Keys)
	Console.Write(o.ToString());
foreach (object o in hash.Values)
	Console.Write(o.ToString());
/*...*/ return (new ArrayList(hash.Keys));
/*...*/ return (new ArrayList(hash.Values));