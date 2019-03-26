using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace events3
{
    class ev3
    {
        private int a = 0;
        private int b = 0;
        public class ChangeArgs : EventArgs
        {
            public int newValue;
            public bool type;
            public ChangeArgs(int newVal, bool vType)
            {
                this.type = vType;
                this.newValue = newVal;
            }
        }
        public int A
        {
            get
            {
                return a;
            }
            set
            {
                ChangeArgs e = new ChangeArgs(value, true);
                onChange(this, e);
                b = value;
            }
        }
        public int B
        {
            get
            {
                return a;
            }
            set
            {
                ChangeArgs e = new ChangeArgs(value, false);
                onChange(this, e);
                b = value;
            }
        }
        
        public ev3()
        {
            A = 0;
            B = 0;
        }

        public delegate void ChangeHandler(object source, ChangeArgs e);
        public event ChangeHandler changer;
        private void onChange(object source, ChangeArgs e)
        {
            if (changer != null)
                changer(this, e);
        }

    }
    class Program
    {
        static void Main(string[] args)
        {
            ev3 Ev3 = new ev3();
            Ev3.changer += delegate (object sender, ev3.ChangeArgs e) {
                if(e.type)
                    Console.WriteLine("A is going to be changed from {0} to {1}",Ev3.A,e.newValue);
                else
                    Console.WriteLine("B is going to be changed from {0} to {1}", Ev3.B, e.newValue);
            };
            
            Ev3.A = 2;
            Ev3.B = 5;
            Ev3.A = -2;
            Ev3.B = 9;
            Ev3.A = 0;


            Console.ReadKey();
        }
    }
}
