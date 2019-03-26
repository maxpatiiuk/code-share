//Events
class Handler_I {
	public void Message() { ... }
}
class Handler_II {
	public void Message() { ... }
}
class ClassCounter {
	public delegate void MethodContainer();
	public event MethodContainer onCount;
	public void Count(){
		for (int i = 0; i < 100; i++)
			if (i == 71)
				onCount();
	}
}
ClassCounter Counter = new ClassCounter();
Handler_I Handler1 = new Handler_I();
Handler_II Handler2 = new Handler_II();
Counter.onCount += Handler1.Message;
Counter.onCount += Handler2.Message;
Counter.Count();

delegate void MyHandler();
class MyEvent{
	public event MyHandler Event;
	public void MyMethod() {
		Event();
	}
}
static void Handler(){
	...
}
MyEvent me = new MyEvent();
me.Event += new MyHandler(Handler);
me.MyMethod();

//Using Event-Based Access Tools 
delegate void UI();
class MyEvent{
	UI[] evnt = new UI[5];
	public event UI UserEvent{
		add {
			evnt[0] = value;
		}
		remove {
			evnt[0] = null;
		}
	}
	public void OnUserEvent(){
		evnt[0]();
	}
}
class UserInfo{
	string uiName;
	public UserInfo(string Name){
		this.Name = Name;
	}
	public string Name { set { uiName = value; } get { return uiName; } }
	public void UserInfoHandler(){
		Console.WriteLine("1");
	}
}
MyEvent evt = new MyEvent();
UserInfo user1 = new UserInfo(Name: "Alex");
evt.UserEvent += user1.UserInfoHandler;
evt.OnUserEvent();


public class Person {
	public event EventHandler WorkEnded;
	public String FirstName;
	public Person(String firstName) {
		this.FirstName = firstName;
	}
	public void Work() {
		if (WorkEnded != null)
			WorkEnded(this, EventArgs.Empty);
	}
}
static void Main(string[] args){
	Person person = new Person("Bill");
	person.WorkEnded += delegate(object sender, EventArgs e){ 
		Console.WriteLine("Finished!\n"); 
	};//or
	//person.WorkEnded += new EventHandler(Person_WorkEnded);
	person.Work();
}
/*static void Person_WorkEnded(object sender, EventArgs e){
	Console.WriteLine("finished");
}*/

delegate int Sum(int number);
static Sum SomeVar(){
	int result = 0;
	Sum del = delegate (int number){
		for (int i = 0; i <= number; i++)
			result += i;
		return result;
	};
	return del;
}
Sum del1 = SomeVar();
for (int i = 1; i <= 5; i++)
	Console.WriteLine("Sum of {0} = {1}",i,del1(i));

//Applying an event for a multicast delegate
public delegate void TickEventHandler(Object sender, TickerArgs args);
public class TickerArgs : EventArgs{
public Int32 Tick;
public TickerArgs(Int32 tick) { this.Tick = tick; }
public class Ticker{
	public event TickEventHandler TickEvent;
	private Boolean isEnabled = false;
	public Boolean IsEnabled{
		get { return isEnabled; }
		set { isEnabled = value; }
	}
	private Int32 ticks = 0;
	public void RunTiker(){
		while (isEnabled && TickEvent != null){
			ticks++;
			TickEvent(this, new TickerArgs(ticks));
			Thread.Sleep(10);
		}
	}
}
static void ticker_TickEvent(object sender, TickerArgs args){
	Console.WriteLine("Сработал обработчик описанный в классе Program, Tick = " + args.Tick.ToString());
}
public class TickerFilter{
	private Ticker ticker;
	public TickerFilter(Ticker ticker){
		this.ticker = ticker;
		this.ticker.TickEvent += new TickEventHandler(ticker_TickEvent);
	}
	void ticker_TickEvent(object sender, TickerArgs args){
		if (args.Tick % 5 == 0)
			Console.WriteLine("Сработал обработчик описанный в классе TickerFilter, Tick = " + args.Tick.ToString());
	}
}
Ticker ticker = new Ticker();
ticker.TickEvent += new TickEventHandler(ticker_TickEvent);
TickerFilter tf = new TickerFilter(ticker);
ticker.IsEnabled = true;
Thread thr = new Thread(new System.Threading.ThreadStart(ticker.RunTiker));
thr.Start();
Thread.Sleep(150);
ticker.IsEnabled = false;