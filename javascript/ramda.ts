// basic
equals(3)  // (a)=>a===3
pathOr('failed',['a','b'],{}) // 'failed'
pluck('prop', [{a: 1}, {a: 2}])  // [1, 2]  // map(prop('prop'))
divide(_, 10)  // (a)=>a/10
defaultTo('a',null)  // null ?? 'a'


// curry
const a = curryN(3,(a,b,c)=>a+b+c)
a(1,2,3) === a(1)(2)(3) === a(1)(2,3) === a(_, _, 1)(2, _, 3)
// use curry() if don't know funcs arity


// compose
compose(
	double,
	tap(console.log),
	triple
)


// sorting
sort(Math.abs, array)
sortWith([Math.abs, ascend(prop('age'))], array)
sortBy(compose(toLower, prop('name'), array)
comparator((a,b)=>a>b)  // -1|1


// branching
always(value)  // ()=>value
F()  // ()=>false
ifElse(
	equals(condition),
	always('true'),
	always('false')
)
when(condition, multiply(2))  // 2n | n
unless(condition, multiply(2))  // n | 2n
cond([
	[equals(value), always(result)]
	[else_condition, always(result_2)]
	[always(true), always(default_result)]
])


// misc
filter(propSatisfies(gte(20), 'price'), arr)   // less or equal 20
flip((a,b)=>a/b)  // (b,a)=>a/b
const searchFor = concat('https://i.o/search/?q=')  // end function
													// names with `For`
empty([1,2,3])  // []  // {a:1} --> {}

// lenses
lense(prop('prop'),assoc(obj)) === lenseProp('prop', obj)
assoc('b',2, {a:1})  // {a:1, b:2}
view(lenseProp('prop'), { prop: 1} )  // 1  // prop('prop', obj)
//lensPath(['a','b','c'], obj)
set(lensProp('prop'), 'value', { prop: 1} )  // { prop: 'value' }
over(lensProp('prop'), toUpper, { prop: 'a'} )  // {prop: 'A'}
view(lensIndex(1), [1, 2, 3])  // 2
view(compose(lensIndex(0), lensProp('value')), arr)  // can combine 'em

const Const = (x)=>({  // defining our own functor
	value: x,
	'fantasy-land/map': function() { return this; }  // with custom map
});


// arrays
adjust(index, toUpper, arr)  // set at index. index=-1 for last el


// strings


// strings and arrays
concat('a','b')  // 'ab'
append('3',['1','2'])  // ['1','2','3']
drop(2, [1,2,3])  // [1,2]  // .slice(0,n)
dropLast([1,2,3])  // drop(Last?)While  // dropRepeats(With?)
difference([1,2,3,4,5],[2,3])  // [1,4,5]  // differenceWith
ap([multiple(2), add(100)],[1,2,3])  // [2,4,6,101,102,103)
converge(concat, [toUpper, toLower], 'a')  // 'aA'


// boolean
and(true, false)  // either
both(gt(_,10),lt(_,20))


// comparison
eqBy(Math.abs, 5, -5)
eqProps('a',{a:1},{a:1})
endsWith('c','abc')  // startsWith
equals([1,2],[1,2])  // strict deep comparsion 1!=='1'


// iteration
forEach()  // forEachObjIndexed - Object.entries().forEach


// promises
compose(
	andThen(console.log),
	fetchData,
	makeQuery,
)


// objects
// assoc and assocPath to shalow-modify obj (dissoc)
propEq('prop','val',value)
allPass([propEq('a','1'), propEq('b','2')], obj)  // anyPass
applySpec({
	add,
	nested: {
		multiply,
	}
},[1,2])  // {add:3, nested: {multiply: 2 } }  // evolve()
fromPairs  // Object.fromEntries


// numbers
clamp(-1,1,-99)  // -1  // clamp a value between boundaries
dec(4)  // 3


// functions
applyTo(2)(identity)  // identity(2)
binary((a,b,c=0)=>a+b+c)  // (a,b)=>a+b+0
call(func, 1, 2)  // func(1,2)
chain(n=>[n,n],[1,2])  // [1,1,2,2]
chain(f,g,x)  // f(g(x),x)
complement(()=>false)  // ()=>true
composeWith((f,v)=>isNil(v) ? v : f(v), add(2), prop('val'))
converge(divide, [sum, length], arr)  // get avg arr val
countBy(toLower,['a','A','b'])  // {'a':2, 'b': 1}

