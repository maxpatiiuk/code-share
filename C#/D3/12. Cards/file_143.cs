using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Cards
{
    class Card
    {
        public int owner;
        public int fraction;
        public int type;

        public Card(int fraction, int type)
        {
            this.owner = 0;
            this.fraction = fraction;
            this.type = type;
        }
    }

    class Game
    {
        private int numberOfPlayers;//2
        private int numberOfTypes;//9
        private int numberOfFractions;//4

        private int miniPause; //25
        private int bigPause; //100

        private bool isGameFinished;
        private int[] players;
        private char[] fractionView;
        private char[] cardView;

        private static Random rand;
        private List<Card> cards = new List<Card>();

        public Game(int numberOfPlayers, char[] fractionView, char[] cardView, int miniPause, int bigPause)
        {
            this.numberOfPlayers = numberOfPlayers;
            rand                 = new Random();
            players              = new int[numberOfPlayers];

            this.fractionView = fractionView;
            this.cardView     = cardView;

            this.miniPause = miniPause;
            this.bigPause  = bigPause;

            isGameFinished    = false;
            numberOfTypes     = cardView.Length;
            numberOfFractions = fractionView.Length;

            prepateCards();
            give();
        }
        public void prepateCards()
        {
            int[] order = sort(numberOfTypes);

            for (int i = 0; i < numberOfTypes; i++)
                for(int ii = 0; ii < numberOfFractions; ii++)
                    cards.Add(new Card(ii, order[i]));

            /*for (int i = 0; i < numberOfCards; i++)
                cards.Add(new Card(i % 4, order[Convert.ToInt32(i / numberOfFractions)]));*/
        }
        public void play()
        {
            string[] display = new string[5];
            int[] moves = new int[numberOfPlayers];
            while (!isGameFinished)
            {
                for (int i = 0; i < 5; i++)
                    display[i] = "";
                for (int player = 0; player < numberOfPlayers; player++)
                {
                    IterationReturn buffer = iteration(player);
                    moves[player] = buffer.move;

                    for (int i = 0; i < 5; i++)
                        display[i] += buffer.display[i] + " ";

                    System.Threading.Thread.Sleep(miniPause);
                }

                for (int i = 0; i < 5; i++)
                    Console.WriteLine(display[i]);
                Console.WriteLine("\n#" + getWinner(moves) + " won this round");

                System.Threading.Thread.Sleep(bigPause);
            }
        }
        private int getWinner(int[] moves)
        {
            int winner = moves.Max();
            int inactivePlayersCount = 0;
            for (int i = 0; i < numberOfPlayers; i++)
                if (moves[i] != -1)
                    cards[moves[i]].owner = cards[winner].owner;
                else
                    inactivePlayersCount++;
            if(inactivePlayersCount == numberOfPlayers)
                win(cards[0].owner);

            return cards[winner].owner + 1;
        }
        private IterationReturn iteration(int player)
        {
            IterationReturn buffer = new IterationReturn();
            int times = 0;
            for (int i = 0; i < numberOfFractions * numberOfTypes; i++)
                if (cards[i].owner == player)
                    times++;
            int targetTimes = random(0, times) + 1;
            times = 0;
            for (int i = 0; i < numberOfFractions * numberOfTypes; i++)
            {
                if (cards[i].owner == player)
                    times++;
                if(times==targetTimes)
                {
                    buffer.move = i;
                    break;
                }
            }

            if (buffer.move == -1)
            {
                buffer.display[0] = "     ";
                buffer.display[1] = "     ";
                buffer.display[2] = "     ";
                buffer.display[3] = "     ";
                buffer.display[4] = "     ";
            }
            else
            {
                buffer.display[1] += fractionView[cards[buffer.move].fraction] + "  |";
                buffer.display[2] +=     cardView[cards[buffer.move].type]     + " |";
                buffer.display[3] += fractionView[cards[buffer.move].fraction] + "|";
            }

            return buffer;
        }
        private static int[] sort(int numberOfTypes)
        {
            int[] order = new int[numberOfTypes];
            for (int i = 0; i < numberOfTypes; i++)
                order[i] = i;
            int buf = 0;
            int pos = 0;
            for(int ii = 0; ii < 5; ii++) {
                for (int i = 0; i < numberOfTypes; i++)
                {
                    pos = random(0, numberOfTypes);

                    buf = order[i];
                    order[i] = order[pos];
                    order[pos] = buf;
                }
            }

            return order;
        }
        private static int random(int min, int max)
        {
            return rand.Next(min, max);
        }
        private void give() {
            for(int i = 0; i < numberOfTypes * numberOfFractions; i++)
                cards[i].owner = i%numberOfPlayers;
        }
        private static void win(int winnerId)
        {
            Console.WriteLine("Player #{0} won the game!",winnerId);
            Environment.Exit(0);
        }

    }

    class IterationReturn
    {
        public int move;
        public string[] display;

        public IterationReturn(int move, string[] display)
        {
            this.move = move;
            this.display = display;
        }
        public IterationReturn()
        {
            this.move = -1;
            this.display = new string[5] { "-----", "|","| ","|  ", "-----" };
        }
    }


    class Program
    {
        static void Main(string[] args)
        {
            int numberOfPlayers = 0;
            while (numberOfPlayers < 2 || numberOfPlayers > 18) {
                Console.WriteLine("How many players will play the game (2-18)");
                numberOfPlayers = Convert.ToInt32(Console.ReadLine());
            }

            char[] fractionsView = { '@', '#', '%', '&' };
            char[] cardsView     = { '6', '7', '8', '9', 'X', 'T', 'E', 'P', 'C'};//6-10, traider, explorer, pirate, cheater

            int miniPause = 25;
            int bigPause = 100;

            Game game = new Game(numberOfPlayers,fractionsView,cardsView, miniPause, bigPause);
            game.play();
            Console.ReadKey();
        }
    }
}
