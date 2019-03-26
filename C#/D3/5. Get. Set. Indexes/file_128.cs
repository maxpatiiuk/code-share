using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace getSetArrays
{

    class Arrs/* : IEnumerable*/
    {
        public int min { get; set; }
        public int max { get; set; }
        public int[] data;
        public Arrs()
        {
            min = 0;
            max = 0;
            data = new int[10];
        }
        public Arrs(int iMin, int iMax)
        {
            min = iMin;
            max = iMax;
            data = new int[iMax - iMin];
        }
        public int Length
        {
            get { return data.Length + min; }
        }
        public int this[int pos]
        {
            get
            {
                if (pos - min >= data.Length)
                    throw new IndexOutOfRangeException();
                else
                    return data[pos - min];
            }
            set
            {
                data[pos - min] = value;
            }
        }
        #region IEnumerable Members
        /*IEnumerator IEnumerable.GetEnumerator()
        {
            return data.GetEnumerator();
        }*/
        #endregion

        public Arrs(Arrs buf)
        {
            min = buf.min;
            max = buf.max;
            data = buf.data;
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("Min: ");
            int min = int.Parse(Console.ReadLine());
            Console.WriteLine("Max: ");
            int max = int.Parse(Console.ReadLine());
            Arrs arr = new Arrs(min,max);
            int i;
            while (true)
            {
                Console.Clear();
                Console.WriteLine("1. Get min");
                //Console.WriteLine("2. Set min");
                Console.WriteLine("2. Get max");
                //Console.WriteLine("4. Set max");
                Console.WriteLine("3. Get data");
                Console.WriteLine("4. Set data");
                Console.WriteLine("0. Exit");
                i = Convert.ToInt32(Console.ReadLine());
                Console.Clear();

                switch (i)
                {
                    case 1:
                        Console.WriteLine(arr.min);
                        break;
                    /*case 2:
                        arr.min = Convert.ToInt32(Console.ReadLine());
                        break;*/
                    case 2:
                        Console.WriteLine(arr.max);
                        break;
                    /*case 4:
                        arr.max = Convert.ToInt32(Console.ReadLine());
                        break;*/
                    case 3:
                        for (int ii = arr.min; ii < arr.Length; ii++)
                            Console.WriteLine(arr[ii]);
                        break;
                    case 4:
                        for(int ii = arr.min; ii < arr.Length; ii++)
                            arr[ii] = Convert.ToInt32(Console.ReadLine());
                        break;
                    case 0:
                        Environment.Exit(0);
                        break;
                }
                Console.ReadKey();
                Console.Clear();
            }
        }
    }

}