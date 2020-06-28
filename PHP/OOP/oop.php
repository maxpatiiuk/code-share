<?php
class cname {
	public $var = "s";
	//public - accessible everywhere
	//protected - accessible to this and parrents
	//private - hidden from everyone

	public function d(){
		echo $this->$var;
	}
}



class cname {
	public function d(){
		return '1';
	}
}
class cname2 {
	public function d2(){
		echo cname::d();
	}
}

$a = new cname();
echo $a->d();
echo cname::d();

$b = new cname2();
$b->d2();
cname2::d2();



class A {};

$a = new A();

$className = 'A';
$a2 = new $className();



class A {
	public $var = '1';
};

$a = new A();

$ass =  $a;
$ref =& $a;

$a->val = '2';

$a = NULL;

echo var_dump($a); //Null
echo var_dump($ref); //Null
echo var_dump($ass); //object



class Test{
	static public function getNew(){
		return new static;
	}
}
class Child extends Test{}

$obj1 = new Test();
$obj2 = new $obj1;
var_dump($obj1 !== $obj2); //true
var_dump($obj1); //object(Test)#1 (0)
var_dump($obj2); //object(Test)#2 (0)

$obj3 = Test::getNew();
var_dump($obj3 instanceof Test); //true

$obj4 = Child::getNew();
var_dump($obj4 instanceof Child); //true
var_dump($obj4 instanceof Test); //true



echo (new DateTime())->format('Y');



class A {
	public $b = 'property';

	public function b(){
		return 'method';
	}
}
$a = new A;
echo $a->b; //property
echo $a->b(); //method



class A {
	public $b;

	public function __construct(){
		$this->b = function(){
			return 'a';
		};
	}
}
$a = new A();
$func = $a->b;

echo $func(); //a
echo ($a->b)(); //a



class A {
	static public $b = 'a';
}
class B extends A {
	static public $c = 'b';
}
echo B::$b;
echo B::$c;



namespace A {
	class B {}
	echo B::class; //A\B
}



class A {
	const B = 'val';
	public static $a = 'a';

	function getB(){
		echo self::B;
	}
}

echo A::B; //val

$name = 'A';
echo $name::B; //val

$a = new A;
echo $a->getB(); //val
echo $a::B; //val   !!!
echo $a::$a; //a   !!!



const ONE = 1;
class A {
	const TWO = ONE * 2;
}



class A {
	private const B = 1;
}



spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

$obj  = new MyClass1();
$obj2 = new MyClass2();
//will automaticly include MyClass1.php and MyClass2.php



class A {
	function __construct(){
		echo 'Open A<br>';
	}
	function __destruct(){
		echo 'Close A<br>';
	}
}
class B extends A {
	function __construct(){
		parent::__construct();
		echo 'Open B<br>';
	}
}

$a = new A();
$b = new B();



class A {
	private $a = 'A';

	function __construct(A $obj){
		$obj->a = 'B';
	}
}



class A extends B {
	private static $a = 'a';

	public static function(){
		echo parrent::$a;
		echo self::$a;
	}
}



abstract class A {
	abstract public function g();

	public function b(){
		echo 'b';
	}
}
class B extends A {
	public function g(){
		echo 'g';
	}
}



abstract class A {
	abstract public function g($a);//need to specify only required arguments
}
class B extends A {
	public function g($a,$b = '1'){
		//...
	}
}



interface IA {
	public function a();
}

interface IB {
	public $b;
}

interface IC extends IA, IB {

}

class A implements IC {
	public $b = '2';

	function a(){
		echo '1';
	}
}



trait TA {
	function a(){

	}
}

class A {
	use TA;
}



class A {
	public function fa(){
		echo 'A';
	}
}

trait TB {
	public function fb(){
		parrent::fa();
		echo 'B';
	}
}

trait TC {
	public function fc(){
		echo 'c';
	}
}

class D extends A {
	use TB, TC;

	public function do(){
		fb();
		fc();
	}
}

$d = new D();
$d->do();



trait TA {
	public function name(){
		echo 'a';
	}
}
trait TB {
	public function name(){
		echo 'b';
	}
}
class C {
	use TA, TB {
		TA::name insteadof TB;
		TB::name as /*public|protected|private*/ name2;
	}
}



$a->b(new class {
	public $c;

	public function d($e){
		echo $e.$c;
	}
});



$a->b(new class(10/*constructor paramether*/) extends C implements ID {
	public $e;

	public function f($g){
		echo $e.$g;
	}
});



function anonymous_Class(){
	return new class{};
}

echo get_class(anonymous_Class()) === get_class(anonymous_Class());//1



class A {
	private $b = 2;

	public function __set($name, $value){
		$this->$name = $value;
	}
	public function __get($name){
		return $this->$name;
	}
	public function __isset($name){
		return isset($this->$name);
	}
	public function __unset($name){
		unset($this->$name);
	}
}

$a = new A();

$a->b = 1;//b = 1
echo $a->b;//1
unset($a->b);//b - undefined
echo var_dump(isset($a->b));//false



class A {
	public function __call($name, $arguments){
		echo "object method '$name' ". implode(', ', $arguments). "\n";
	}
	public static function __callStatic($name, $arguments){
		echo "static method '$name' ". implode(', ', $arguments). "\n";
	}
}

$a = new A();
$a->echo('1','2','3');//object method 'echo' 1, 2, 3

A::echoStatic('1static');//static method 'echoStatic' 1static



class A {
	public $var1 = '1';
	public $var2 = '2';
	public $var3 = '3';
	private $pvar4 = 'p4';

	function iterateVisible(){
		foreach($this as $key => $value)
			echo $key.' => '.$value.'<br>';
	}
}

$a = new A();

foreach($a as $key => $value)
	echo $key.' => '.$value.'<br>';
/*
var1 => 1
var2 => 2
var3 => 3
*/

$a->iterateVisible();
/*
var1 => 1
var2 => 2
var3 => 3
pvar5 => p4
*/



class MyIterator implements Iterator {
	private $b = array();

	public function __construct($array){
		if(is_array($array))
			$this->b = $array;
	}

	public function rewind(){
		reset($this->b);
	}
	public function current(){
		return current($this->b);
	}
	public function key(){
		return key($this->b);
	}
	public function next(){
		return next($this->b);
	}
	public function valid(){
		$key = key($this->b);
		return ($key !== NULL && $key !== FALSE);
	}
}

$values = array(1,2,3);
$it = new MyIterator($values);

foreach($it as $a => $b){
	echo $a.'=>'.$b.'<br>';
}
/*
0=>1
1=>2
2=>3 
*/

class MyCollection implements IteratorAggregate {
	private $items = array();
	private $count = 0;

	public function getIterator(){//required by interface
		return new MyIterator($this->items);
	}

	public function add($value){
		$this->items[$this->count++] = $value;
	}
}

$col = new MyCollection();
$col -> add('1');
$col -> add('2');
$col -> add('3');

foreach($col as $key => $val)
	echo "$key => $val<br>";
/*
0 => 1
1 => 2
2 => 3
*/



$a = array('1','2','3');//pointer on first
echo current($a);//'1'
echo key($a);//0
next($a);//pointer on second
reset($a);//pointer on first



class A {
	private $b = '123';

	public function __toString(){
		return (string)$this->b;
	}
	public function __invoke($val){
		$this->b = $val;
	}
}

$a = new A();

$a(2);
echo $a;



class A {
	public function __debugInfo(){
		return [
			'key' => 'value'
		];
	}
}

$a = new A();

echo var_dump($a);//object(A)#1 (1) { ["key"]=> string(5) "value" }



class A {
	final public function b(){
		echo '1';
	}
}

class B extends A {
	public function b(){}//error
}



final class A {}

class B extends A {}//error



class A {}

$a = new A();
$b = clone $a;


function test(array $a){}
/*
	Force paramether of specific type
	class/interface name, self (paramether must be instance of same class, in which this method is defined), array, callable, bool, float, int, string, iterable (array or instanceof Traversable), object
*/



class A {
	public static function ma(){}
	public static function mb(){
		static::ma();
	}
}

class B extends A {
	public static function ma(){}
}

A:mb(); //calles A::ma
B:mb(); //calles B::ma



class A {}

$a = new A();
$b = $a;// ($a) = ($b) = <id>

$c = new A();
$d = &$c;// ($c,$d) = <id>
//any change in $d will lead to same change in $c, because $d is reference of $c



//a.php
class A{}

//serialize.php
require_once 'a.php';

$a = new A;

$data = serialize($a);
file_put_contents('data', $data);

//unserialize
require_once 'a.php';

$data = file_get_contents('data');
$a = unserialize($data);//now $a is object of class A, than can be used