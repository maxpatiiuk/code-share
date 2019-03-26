using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ping_pon
{
    class Ping
    {
        int count, max;
        public Ping(float vMax)
        {
            count = 0;
            max = (int)vMax;
        }
        public event EventHandler pong;
        public void Echo(object source, EventArgs e)
        {
            Console.WriteLine("Ping");
            ((Pong)source).onEcho(source,EventArgs.Empty);
        }
        public virtual void onEcho(object source, EventArgs e)
        {
            count++;
            if (pong != null && count <= max)
                pong(this, EventArgs.Empty);
        }
    }
    class Pong
    {
        int count, max;
        public Pong(float vMax)
        {
            count = 0;
            max = (int)vMax;
        }
        public event EventHandler ping;
        public void Echo(object source, EventArgs e)
        {
            Console.WriteLine("Pong");
            ((Ping)source).onEcho(source, EventArgs.Empty);
        }
        public virtual void onEcho(object source, EventArgs e)
        {
            count++;
            if (ping != null && count <= max)
                ping(this, EventArgs.Empty);
        }
    }
    class Program
    {
        const int count = 4;
        const int gameDuration = 4;
        static void Main(string[] args)
        {
            Ping[] ping = new Ping[count];
            Pong[] pong = new Pong[count];
            for (int i = 0; i < count; i++)
            {
                ping[i] = new Ping(gameDuration/2);
                pong[i] = new Pong(gameDuration/2);
                ping[i].pong += delegate (object sender, EventArgs e) {
                    ping[i].Echo(pong[i], EventArgs.Empty);
                };
                pong[i].ping+= delegate (object sender, EventArgs e) {
                    pong[i].Echo(ping[i], EventArgs.Empty);
                };
                Console.WriteLine("====");
                pong[i].Echo(ping[i],EventArgs.Empty);
            }


            Console.ReadKey();
        }
    }
}
