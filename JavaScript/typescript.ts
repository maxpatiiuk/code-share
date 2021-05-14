// Notes on some advanced TypeScript features

interface ObjectWithIndex {
  [key:string]: string;
  index: number;
}

type FunctionWithDescription = {
  (arg: number): number;
  description: string;
}

// Recursive Flattening with <infer Item> for automaticly figuring out
// the indexing
type Flatten<Type> = Type extends Flatten<Array<infer Item>> ? Item : Type;

if(a instance of Date){}

const b = (a,b)=>{};
const a = ['a','b'];
b(...a);  // error, b requires 2 parameters, >= were given
const a = ['a','b'] as const;
b(...a);  // all good

interface A {
  a: string;
  b: string;
}
type keys = A[keyof A]; // instead of A[string]

type A {
  new (s:string): Date;
  (s:string): Date;
}

type MappingPath = [...string[], MappingType?];

// Prefer:
const A = <T>(a:T[])=>{};
// Over:
const A = <V,T extends V[]>(a:T)=>{};

// Make all properties be mutable:
type CreateMutable<Type> = {
  -readonly [Property in keyof Type]: Type[Property];
};

// same as Required<Type>
type Concrete<Type> = {
  [Property in keyof Type]-?: Type[Property];
};

// Capitalize all keys that are strings (and prepend with "get")
type Getters<Type> = {
    [Property in keyof Type as `get${Capitalize<string & Property>}`]: () => Type[Property]  
} & {
    [Property in keyof Type as Exclude<Property, string>]: () => Type[Property]
};
// Uppercase Lowercase Uncapitalizes

ttype IsActionInDict<Type> = {
  [Property in keyof Type]: Type[Property] extends { type: `${string}Action` } ? true : false;
};
// Check if the type is a valid action:
type Actions = IsActionInDict<{
    'Action': {type:'Action'},  // true
    'Action2': {type:'Action2'},  // false
    'Something': {name:'something'},  // true
}>;

// Add an event subscribe with event listener for each field
type PropEventSource<Type> = {
    on<Key extends string & keyof Type>
        (eventName: `${Key}Changed`, callback: (newValue: Type[Key]) => void ): void;
};
declare function makeWatchedObject<Type>(obj: Type): Type & PropEventSource<Type>;
const person = makeWatchedObject({
  firstName: "Saoirse",
  lastName: "Ronan",
  age: 26
});
person.on("firstNameChanged", newName => {
  console.log(`new name is ${newName.toUpperCase()}`);
});

/*
 * Putting this here just in case:
 * CLASSES
 *
 * Can overload a constructor
 * For private vars (_length) can add `get length(){}` and `set length(){}`
 * Can declare index signature `[s:string]: boolean,`
 * If `class A extends B` then constructor must call super(this);
 * `class Can implements Inter,faces {}`
 * If base's method was overwritten, can call it with `super.base()`
 * Classes can extend Array, Error, Map, Date, ...
 * Properties can be private/protected/public and static
 * Methods' first parameter can be a pre-comile `this` to force correct type
 * Or: `isFile(): this is FileRef {},
 * Also for `hasValue(): this is {value:string} {}`, calling
 * class.hasValue() narrows the type of `value?:string` to string
 * constructor(public readonly x: number, private y: number)
 * const a = class { constructor(){} }
 * Classes, methods and fields can be abstract
 * Note, when accepting implementation of abstract, use func(prop:new()=>Base){} instead of ...typeof Base...
 * Mixins are functions that take a class and return an extended class
 *
 * */

// Decorators are super cool! ... but useless untill we can use them on
// functions and object's properties

const enum Type {
  Open = 'OPEN',
  Closed = 'CLOSED';
}
const open = Type.Open;
const Type = Type[key] as const;

// Iterable to array
function toArray<X>(xs: Iterable<X>): X[] {
  return [...xs]
}

// Don't write callback parameters as optional (it may mean they may not
// get invoked with those optional parameters specified)

// Put the most general overload last


