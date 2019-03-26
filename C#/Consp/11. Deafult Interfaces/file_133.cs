//Deafult interfaces


//IEnumerable
GetEnumerator
Cast<TResult> (this IEnumerable source) //cast el to TResult
OfType<TResult> (this IEnumerable source) //filter all TResult els
MoveNext()//move to next. return false on last
Current
Reset() //to start

//ICollection 
//child of IEnumerable
Count
IsSynchronized 
CopyTo(Array array, int index)//copy colection to array from index

//IList 
//child of ICollection
int Add(object value) //add value. return index
void Clear() //delete all
bool Contains(object value) //if value exist in colection
int IndexOf(object value)
void Insert(int index, object value) //inser value into colection on index
void Remove(object value) //delete first value in colection
void RemoveAt(int index) //delete el on index
bool IsFixedSize 
bool IsReadOnly 
object Item[int index]{get;set;} //return or create el on this index

//IDisposable 
void Dispose(); //delete

//IComparable - for sorting
int CompareTo(object obj); //return on which position this object is located in comaprison to another

class Monster : IComparable {
	public int CompareTo( object obj ){
		Monster temp = (Monster) obj;
		if( this.health > temp.health )
			return  1;
		if( this.health < temp.health )
			return -1;
		return 0;  
		}
}
Monster[] stado = new Monster[3];
stado[0] = new Monster( 50, 50, "a1" );
stado[1] = new Monster( 80, 80, "a2" );
stado[2] = new Monster( 40, 10, "a3" );
Array.Sort( stado );

class MyInt : IEnumerable, IEnumerator {
	int[] ints = { 12, 13, 1, 4 };
	int index = -1;
	public IEnumerator GetEnumerator(){
		return this;
	}
	public bool MoveNext(){
		if (index == ints.Length - 1){
			Reset();
			return false;
		}
		index++;
		return true;
	}
	public void Reset(){
		index = -1;
	}
	public object Current{
		get {
			return ints[index];
		}
	}
}
MyInt mi = new MyInt();
foreach (int i in mi)
	Console.Write(i + "\t");

SimpleList test = new SimpleList();
test.Add("one");
test.Add("two");
test.PrintContents();
test.Remove("two");
test.Insert(0, "number");
test.PrintContents();
Console.WriteLine(test.Contains("three"));

class SimpleList : IList {
	private object[] _contents = new object[8];
	private int _count;
	public SimpleList(){
		_count = 0;
	}
	public int Add(object value){
		if (_count < _contents.Length){
			_contents[_count] = value;
			_count++;
			return (_count - 1);
		}
		else
			return -1;
	}
	public void Clear(){
		_count = 0;
	}
	public bool Contains(object value){
		bool inList = false;
		for (int i = 0; i < Count; i++)
			if (_contents[i] == value){
				inList = true;
				break;
			}
		return inList;
	}
	public int IndexOf(object value){
		int itemIndex = -1;
		for (int i = 0; i < Count; i++)
			if (_contents[i] == value){
				itemIndex = i;
				break;
			}
		return itemIndex;
	}
	public void Insert(int index, object value){
		if (!((_count + 1 <= _contents.Length) && (index < Count) && (index >= 0)){
			_count++;
			for (int i = Count - 1; i > index; i--)
				_contents[i] = _contents[i - 1];
			_contents[index] = value;
		}
	}
	public bool IsFixedSize {
		get {
			return true;
		}
	}
	public bool IsReadOnly {
		get {
			return false;
		}
	}
	public void Remove(object value) {
		RemoveAt(IndexOf(value));
	}
	public void RemoveAt(int index) {
		if ((index >= 0) && (index < Count)){
			for (int i = index; i < Count - 1; i++)
				_contents[i] = _contents[i + 1];
				_count--;
		}
	}
	public object this[int index]{
		get {
			return _contents[index];
		}
		set {
				_contents[index] = value;
		}
	}
	public void CopyTo(Array array, int index){
		for (int i = 0, j = index; i < Count; i++,j++)
			array.SetValue(_contents[i], j);
	}
	public int Count{
		get {
			return _count;
		}
	}
	public bool IsSynchronized{
		get {
			return false;
		}
	}
	public object SyncRoot {
		get {
			return this;
		}
	}
	public IEnumerator GetEnumerator(){
		throw new Exception("The method or operation is not implemented.");
	}
	public void PrintContents(){
		Console.WriteLine("Capacity: {0}\nUsed: {1}", _contents.Length, _count);
		for (int i = 0; i < Count; i++)
			Console.Write(_contents[i]);
	}
}