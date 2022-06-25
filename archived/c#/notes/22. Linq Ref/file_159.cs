//LINQ
using System.Linq;

int[] array = { 1, 3, 5, 7 };
Console.WriteLine(array.Average());

static class ExtensionMethods {
	public static int MultiplyByTwo(this int value) {
		return value * 2;
	}
}
System.Console.WriteLine(4.MultiplyByTwo());

//CONVRT : ToArray ToDictionary ToList ToLookup
//MUTATE : AsEnumerable AsParallel AsQueryable Cast Concat Contains DefaultIfEmpty Distinct ElementAt ElementAtOrDefault Except First FirstOrDefault GroupBy GroupJoin Intersect Join Last LastOrDefault OfType OrderBy OrderByDescending Reverse Select SelectMany Single SingleOrDefault Union Where Zip
// Skip SkipWhile Take TakeWhile
// Aggregate All Any Average Count SequenceEqual Sum
// Max Min
// ENUMERABLE : Empty Range Repeat Query Imperative Declarative

int[] array = { 1, 2, 3, 6, 7, 8 };
var elements = from element in array orderby element descending where element > 2 select element;
foreach (var element in elements) //...

//ascending descending group join let orderby select new

var result = from n in array select n;