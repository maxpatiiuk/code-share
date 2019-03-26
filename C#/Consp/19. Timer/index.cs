public static void Main(){
	System.Timers.Timer aTimer = new System.Timers.Timer();
	aTimer.Elapsed+=new ElapsedEventHandler(OnTimedEvent);
	aTimer.Interval=5000;
	aTimer.Enabled=true;

	//while(Console.Read()!='q');
}
private static void OnTimedEvent(object source, ElapsedEventArgs e){
	//...
}