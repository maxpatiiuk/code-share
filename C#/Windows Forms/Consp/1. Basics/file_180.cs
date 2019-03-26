//Windows Forms Basics

using System;
using System.Windows.Forms;
namespace HelloWinFormsWorld{
	class FirstWinFormApp
	{
		public static void Main()
		{
			Form frm = new Form();
			frm.Text = "First Windows Forms application";
			frm.ShowDialog();
		}
	}
}

class MyForm : Form{
		public MyForm(string caption)
	{
		Text = caption;
	}
}
MyForm frm = new MyForm("Hello, world!!!");
frm.ShowDialog();
//or
Application.Run(new MyForm("Hello, world!!!"));


//events
public event EventHandler Click;
class MyForm : Form{
	public MyForm(string caption)
	{
		Text = caption;
		Click+=new EventHandler(ClickHandler);
	}
	public void ClickHandler(Object sender, EventArgs e)
	{
		 MessageBox.Show("Click");
	}
}
Application.Run(new MyForm("Hello, world!!!"));

//message boxxes
public static DialogResult Show(
	string text,
	string caption,
	MessageBoxButtons buttons,
	MessageBoxIcon icon
);
//OK, OKCancel, AbortRetryIgnore, YesNoCancel, YesNo, RetryCancel
//MessageBoxButtons.AbortRetryIgnore
//none, hand, exclamation

DialogResult result = MessageBox.Show("Error text","Caption", MessageBoxButtons.AbortRetryIgnore, MessageBoxIcon.Error);
if (result == DialogResult.Abort)
	MessageBox.Show("Вы нажали кнопку Прервать");
else if (result == DialogResult.Retry)
	MessageBox.Show("Вы нажали кнопку Повтор");
else if (result == DialogResult.Ignore)
	MessageBox.Show("Вы нажали кнопку Пропустить");


static DialogResult ShowMessageBoxes(){
	String message = "Окно, отображающее текстовое сообщение";
	MessageBox.Show(message);
	message = "Окно с текстом и двумя кнопками OK и CANCEL";
	String caption = "Окно с двумя кнопками";
	DialogResult result = MessageBox.Show(message, caption, MessageBoxButtons.OKCancel);
	String button = result.ToString();
	result = MessageBox.Show("Вы нажали кнопку " + button+". Повторить?", button, MessageBoxButtons.AbortRetryIgnore,  MessageBoxIcon.Asterisk);
	return result;
}
[STAThread]//for threading
static void Main(){
	DialogResult result;
	do {
		result = ShowMessageBoxes();
	} while (result == DialogResult.Retry);
}


private String CoordinatesToString(MouseEventArgs e){
	return "Координаты мыши: х=" + e.X.ToString() + "; y=" + e.Y.ToString();
}
// обработчик MouseMove
private void Form1_MouseMove(object sender, MouseEventArgs e){
	//отображение текущих координат мыши в заголовке окна
	Text = CoordinatesToString(e);
}
// обработчик события MouseClick
private void Form1_MouseClick(object sender, MouseEventArgs e){
	//определим какую кнопку мыши нажал пользователь
	String message = "";
	if (e.Button == MouseButtons.Right)
	{
		message = "Вы нажали правую кнопку мыши.";
	}
	if (e.Button == MouseButtons.Left)
	{
		message = "Вы нажали левую кнопку мыши.";
	}
	message += "\n" + CoordinatesToString(e);
	//выведем сообщение в диалоговое окно
	String caption = "Клик мыши";
	MessageBox.Show(message, caption, MessageBoxButtons.OK, MessageBoxIcon.Information);
}


//timer
public partial class Form1 : Form{
	Timer vTimer = new Timer();
	public Form1()
	{
		InitializeComponent();
		button2.Enabled = false;
		//определяем обработчик события для таймера
		vTimer.Tick += new EventHandler(ShowTimer);
	}
	private void ShowTimer(object vObject, EventArgs e)
	{
		//останавливаем таймер
		vTimer.Stop();
		button2.Enabled = false;
		MessageBox.Show("Таймер отработал!", "Таймер");
	}
	private void button1_Click(object sender, EventArgs e){
//разрешаем прервать таймер
button2.Enabled = true;
vTimer.Interval = Decimal.ToInt32(numSeconds.Value) * 1000;
vTimer.Start();
}
	private void button2_Click(object sender, EventArgs e)
	{
		//останавливаем таймер
		vTimer.Stop();
		MessageBox.Show("Таймер не успел отработать!", "Таймер");
		button2.Enabled = false;
	}
}


//dateTme and timeSpan
public DateTime(
	int year,
	int month,
	int day
);

public DateTime(
	int year,
	int month,
	int day,
	int hour,
	int minute,
	int second,
	int millisecond
);

public static DateTime Now { get; }//full time
public static DateTime Today { get; }//just date

DateTme.ToString(string param);
//param - dddd dd/mm/yy dd/m yyyy ...

//DateTime + TimeSpan = DateTime
//DateTime - DateTime = TimeSpan
//DateTime - TimeSpan = DateTime

public TimeSpan(
    int hours,
    int minutes,
    int seconds
)
public TimeSpan(
    int days,
    int hours,
    int minutes,
    int seconds
)
public TimeSpan(
    int days,
    int hours,
    int minutes,
    int seconds,
    int milliseconds
)

public partial class Form1 : Form
{
    private static Timer vTimer = new Timer();
    private void ShowTime(object vObj, EventArgs e)
    {
        labelTime.Text = DateTime.Now.ToLongTimeString();
    }
    public Form1()
    {
        InitializeComponent();
        labelTime.Text = DateTime.Now.ToLongTimeString();
        vTimer.Tick += new EventHandler(ShowTime);
        vTimer.Interval = 500;
        vTimer.Start();
    }
}

// Control ScrollableControl AxHost ButtonBase ListControl DataGrid TextBoxBase DataGridView DateTimePicker GroupBox ScrollBar Label ListView MdiClient MonthCalendar PictureBox ProgressBar Splitter StatusBar TabControl ToolBar TrackBar TreeView WebBrowserBase PrintPreviewControl Integration.ElementHost






























