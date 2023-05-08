<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Конспект</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<?php
	function a($text,$title='0',$count='0'){
		if($count){
			$count*=20;
			echo '<p style="width:'.$count.'px;"></p>';
		}
		if($title)
			echo '<abbr title="'.ucfirst($title).'">'.$text.'</abbr><br>';
		else echo $text.'<br>';
	}
	function b() {
		echo '<br>';
	}
	?>
</head>
<body>
	<header>
		<h1>Конспект</h1>
		<div class="php">php</div>
		<div class="html">html</div>
		<div class="sql">sql</div>
		<div class="js">js</div>
		<div class="css">css</div>
	</header>
	<div class="cont">
		<div class="php">
			<?
			a('strrrev();','reverse cur string');
			a('str_repeat($a,$b);','Repeat string $a $b times');
			a('strtoupper();','Make string in upper case');
			a('strtolover();','Make string in lover case');
			a('ucfirst();','First char is big');
			a('strip_tags($string, $tags);','delete from $string all html and php code except $tags (optional parameter)');
			b();
			a('$objaect = new User;','Create object with name object and class User');
			a('$objaect -> a=1;','Set a value to 1');
			a('$objaect -> abc();','Calling to function');
			a('Class User {','Start working with class');
			a('public $a, $b;','Declare public $a and $b',1);
			a('function abc() {...}','Declaring function with name abc',1);
			a('}','Outing of class');
			a('$object2 -> clone $oblect','Creat $object2 with parameters of $object');
			b();
			a('count();','Return count of elements in array');
			a('sort($arr,SORT_NUMERIC);','Sort array $arr nomeric. Can also use rsort and SORT_STRING');
			a('shufle();','Elements of array in random order');
			a('explore();','Each string word as new array element');
			a('compact();','Array from anems of elements in associative array');
			b();
			a('file_exists();','Check if file exists');
			a('$fh=fopen("a.txt","a+") or die("Failed");','Open file a.txt with a+ mode. If error appered, would echo &quot;Failed&quot;. Read modes: r,w,a,+. r- read file from begin or reurn false. W - wrire in begin and create file if need. A - write in end and return created file if need. + - read and write');
			a('if(flock($fh,LOCK_EX)) {','Chech if file is open. If not, will wait for oppening. Else - will lock file');
			a('fwrite($fh,$text)','Write string $text into file a.txt',1);
			a('fseek($fh,$i,SEEK_SET)','Set pointer in file a.txt into $i position. Also, can use SEEK_CUR - move $i cursor into $i charachers from cur position. If used SEEK_END, would move pointer into $i character from current position',1);
			a('copy($what,$where);','Copy file with destination $what to destination $where',1);
			a('rename($name, $name2)','Rename file $name into $name2',1);
			a('unlink($file)','Delete file $file',1);
			a('flock($fh,LOCK_UN)','Unlock file for editing by other scripts and users',1);
			a('}','');
			a('fclose($fh)','Clossing file');
			a('$_FILES[$file][$action]','if $action = name - name of uploaded file; type - content type (image/jpeg); size - file size in bytes; tmp_name - name of temporary file stored on server; error - error code');
			a('echo <<<_END /*some multiline content with html, dots sleshes...*/','echo content with sumbols and html');
			a('htmlentities();','html code into sumbols');
			b();
			?>
		</div>
		<div class="html">
			<?php
			b();
			a('&lt;form method="post" action="index2.php" enctype="multipart/form-data" id="form"&#62;','create form with id &quot;form&quot;, with enctype for uploading images and action of submit bitton to index2.php');
			a('&lt;input type="file" name="filename" size="10">','create button with widt of 10 characters of current font and name &quot;filename&quot; for uploading file.',1);
			a('&lt;input type="submit" value="upload">','create buttun for submition form with &quot;upload&quot; writed on it',1);
			a('&lt;/form&#62;','closing form');
			?>
		</div>
		<div class="php">
			<?php
			a('if($_FILES){','chech if file was uploaded');
			a('$name=strtolower(preg_replace("[A-Za-z0-9.]","",$_FILES["file"]["name"])','set value name to lover case name of file and change programming language code to emty',1);
			a('switch($_FILES["file"]["type"]){','start switch of type of uploaded file',1);
			a('case "image/jpeg":$ext="jpg";break;','if file type is jpeg, $ext=jpg',2);
			a('case "image/gif":$ext="gif";break;','',2);
			a('case "image/png":$ext="png";break;','',2);
			a('case "image/tiff":$ext="tiff";break;','',2);	
			a('default:$ext="";break;','Set default $ext value',2);
			a('}','Exiting of switch',1);
			a('if($ext){','check if uploaded file is image',1);
			a('$n="image.$ext"','declarig variable $n value &quot;image&quot;.$ext',2);
			a('move_uploaded_file($_FILES["filename"]["tmp_name"],$n)','rename uploaded file to $n',2);
			a('echo "Uploaded image ".$name." as"$n":&lt;br>"','echo name and type of file',2);
			a('echo "&lt;img src="$n">"','showwing image',2);
			a('}','',1);
			a('else echo $name." is not an accepted image file";','echo error if uploaded file was not image',1);
			a('}','');
			a('else echo "No image has been uploaded";','');
			b();
			?>
		</div>
		<div class="html">
			<?php
			a('&lt;form method="post" action="formtext.php" id="first_form"&#62;','creating post form with action to formtext.php and id of first_form');
			a('&lt;input type="text" name="surname" value="Mambo" size="25" maxlenght="24" autocomplete="on" autofocus="autofocus" placeholder="Type your SurName" required="required" form="first_form">','Create required  text input with name &quot;surname&quot;, start value &quot;mambo&quot;, width of 25 charachers, maxlenght of 24 characters, autocomplete, autofocus and grey text &quot;Type your name&quot; for form &quot;first_form&quot;',1);
			a('&lt;input type="submit" formaction="index2.php"&#62;','Create submit button with click action to index2.php',1);
			a('&lt;textarea cols="5" rows="10"&#62;default text here$lt;/textarea&#62;','creating textarea with width of 5 characters, height if 10 characters and default text &quot;default text here&quot;');
			a('&lt;input type="checkbox" name="abc" checked="checked"','Creating checked flag. If there are more then one flag, set name as array. t.e: name=&quot;name[]&quot; and php - $ice=$_POST[&quot;ice&quot;]');
			a('&lt;input type="hidden" value="$var"','Creating hidden input for sending some data. Browser does not show hidden input');
			a('&lt;select size="30" multiple="multiple"','creates multi selective block');
			a('&lt;option value="22"&lt;/option&#62;...','create one of select options',1);
			a('&lt;/select&#62;','close select tag');
			a('&lt;label&#62;Text&lt;input type="checkbox">$lt;/label&#62;','link &quot;Text&quot; and chechbox. So, after clicking on text, chechbox will be selected');
			?>
		</div>
		<div class="php">
			<?php
			a('isset($_POST["val"]);','check if varible has been asigned');
			a('setcookie(name,val,life_time,path,domain)','set cookie name with value of value and lifetime for example "time()+60*60*24*4" which will be avaible on cur directory by def ir in all domain if we will set path to "/". If domain set to main doman, cookie will be avaible from all donains. Is set to subdomain, only on subdomain. to delete thus cookie echo setcookie function with cur nane empty value and time of menus value : "time()-60*60*24*7*4".');
			a('isset($_COOKIE["name"])','Check if cookie with name of name has been set');
			a('hash(); md5();','encode string with md5 or other type of encoding');
			b();
			a('session_start();','Start sesion - analog of cookie');
			a('$_SESSION["somevalue"]=$val;','Set sesion somevalue val to $val');
			a('setcookie(session_name(),"",time()-2592000,"/"','Delete sesion name from cookie');
			a('session_destroy();','Permament deleting if this sesion');
			a('ini_set("session.gc_maxlivetime",60*60*24);','Set session lifetime to one day');
			?>
		</div>
		<div class="html">
			<?php
			b();
			a('&lt;script src="a.js"&#62;/*scripts*/&lt;/script&#62;','Import a.js script file to this html page. if we are using script tag without src, can type some scripts inside the script container');
			a('&lt;noscript&lt;&#62;/noscript&#62;','Some html code which will be displayed in brousers withoud support of js or with turned of js');
			a('js dev console in google chrone','Menu-Developer-JavaScripy Console. Or ctrl+shift+j');
			a('Best js debugger - www.getfirebug.com','');
			a('&lt;a class="link" href="a.php"&#62;','');
			?>
		</div>
		<div class="js">
			<?php
			a('("link").href="index.php"','change link of element with class link');
			a('document.write("Hello Word")','Echo hello word text');
			a('face=[["a","b"],["c","d"]','echo two layers array face with some values. We can also echo array of arrays to make it 2, 3 or more level');
			a('document.write(typeof var_a)','echo type of var_a variable');
			a('if(typeof a!="undefined"','chech is set varoable a');
			a('function a(a,b)','');
			a('a=1','define global var',1);
			a('var b=2','define local var',1);
			a('}','');
			a('numlinks=document.link.lenght','set numlinks to number of linjs in cur page');
			a('for(i=0;i<document.links.lenght;i++){','start loop');
			a('documeny.write(document.links[i].href+"&lt;br>")','get all links which are on cur document',1);
			a('}','');
			a('document.write(history.lenght)','get number of elements in history');
			a('history.go(-3)','sent tge browser back tree pages. Can also use history.back() and history.forward()');
			a('docunent.locatoin.href=http://google.com','replace the currently loaded url by another one');
			a('switch(a)','start switch');
			a('case "home": ... break','set case home and break it after completing some code',1);
			a('default: ... break','set default switch value',1);
			a('}','exiting switch');
			a('size=a<=5?"1":"2"','set var size to 1 if a<=5. Else set size to 2');
			a('while(a<100){','start while loop');
			a('documeny.write(displayItem.arguments[a])','echo a element of arr. Can also use displayItems.arguments.lenght',1);
			a('continue','stop perfoming current loop time. Also can use break to imedeadly skip loop',1);
			a('}','');
			a('parseInt()','make int value from float value');
			?>
		</div>
		<div class="php">
			<?php
			b();
			a('/a +b/','Check if string contain a with some amount of spaces and b');
			a('/<.*>/','Check if string contain &lt; with or without content and >');
			a('/<.*>/','Check if string contain &lt; with or without content and >. if we will use + except of *, function will not match empty content');
			a('/aban\.ana/','Will display fullstop as fulls top, not as regular parameter');
			?>
		</div>
		<div class="css">
			<?php
			b();
			a('p > b { color:red }','all bold text which is DIRECT child of p, will be red');
			a('[type="submit"] { width:100px; }','All submit elemets will have width of 100px');
			a('form input[type="submit"] { width:100px; }','All submit elemets in forms will have width of 100px');
			a('p[id=~"name"]{ color:red }','all p elements with id of name will be red, even if p element has more than one id');
			a('* { ','');
			a('word-spacing:30px','specifice padding betwen words',1);
			a('letter-spacing:3px','specifice padding betwen letters',1);
			a('}','');
			a('background:linear-gradient(top,#ccc,#fff)','Creating gradient starting from #ccc at the top and ending by #fff at the bottom');
			a('div + p { color:red; }','First p, which is located emedeatly after p, will be red.');
			a('div ~ p { color:red; }','All p, which is located after p, will be red.');
			a('a[href="http://st"]','Match all a elements, which href parameter containt "http://st" at the begining');
			a('p[color$="ccc"]','Match all p elements, which color parameter contain "ccc" at the end');
			a('a[href*="google"]','Match all a elements, which href elements contain "google"');
			a('.columns {','');
			a('column-count: 3;','Set column count to 3',1);
			a('column-gap: 1em;','Set column gap to 1em',1);
			a('column-rule: 1px solid black;','Set column rule to 1px solid black',1);
			a('}','');
			a('p { text-overflow:ellipsis; }','the p text ttrails off using an ellipsis');
			a('p { word-wrap:break-word; }','the p word wraps at the right-hang edge');
			a('@font-face {','loading local font');
			a('font-family:FontName;','Setting fon name',1);
			a('src:url(\'FontName.otf\');','Setting location of font. etf, ttf, and eot formats are suported',1);
			a('}','');
			a('transform: matrix() translate() scale() rotate() skew();','transforms, moves, resizes, rotate and skews element');
			a('transform: perspective() transform-origin() translate3d() scale3d() rotate3d();','perspective, transform, translate, scale and rotate object in 3d');
			a('transition-property:all;','Which parameters will have transition. Can also set to width, height and opacity');
			a('transition-duration:1.25s','Set duration of transition to 1.25s');
			a('transition-delay: 1s','Set delay before and after transition');
			a('transition-timing:ease/linear/ease-in/ease-out/ease-in-out/','Set speed of transition to start slofly, get faster, and then end slowly/linear/from slowly to faster/from faster to slowly/from slowly to faster and then slowly again. What is more, we can set our own speed by using transition-timing-function: cubuc-bezier(0.25,1.5,2.1)');
			a('transition: all .3s linear .2s','Start a transition for all parameters for 3 seconds with linear speed and delay of 2 seconds');
			?>
		</div>
		<div class="js">
			<?php
			b();
			a('function O(i){return typeof i==\'object\' ? i:document.getElementById(i)}','Select elemet by id or return this object');
			a('function S(i){return(i).style}','Retutn style of object');
			a('function C(i){return document.getElementsByClassName(i)}','Return all elements by class name.');
			a('S(C(\'text\')).setAttribute(\'style\',\'color:#ccc\')','Set color of text to #ccc for all elements with class "text"');
			?>
		</div>
		<div class="html">
			<?php
			a('&#60;img src="apple.png"','We can use javascript inside the html by writing js aftre opening and before closing of current tag');
			a('onmouseover="this.src=\'orange.png\'"','We can use "this." instead of getelementbyid function if we are using js inside html tag. This line will change image to orange.png while mouse is over it');
			a('onmouseout="this.src=\'apple.png\'"&#62;','This line will change image back to apple.png while mouse is out. Now, I am closing html tag');
			a('&#60;img id="object" src="apple.png"&#62;','We can do same, by another way:');
			a('&#60;script&#62;','Starting script');
			a('O(\'object\').onmouseover=function(){this.src=\'orange.png\'}','In this exaple, I used "this" after using of O function',1);
			a('O(\'object\').onmouseout=function(){this.src=\'apple.png\'}','Change image back to apple.png',1);
			a('&#60;/script&#62;','Closing script');
			?>
		</div>
		<div class="js">
			<?php
			a('onblur','When element loses focus');
			a('<b>onclick</b>','When object is clicked');
			a('ondbclick','When object is double clicked');
			a('onfocus','When element gets focus');
			a('onkeydown','When a key is being pressed (including Shift, Alt, Ctrl, and Esc)');
			a('onkeypress','When a key is being pressed (not including Shift, Alt, Ctrl, and Esc)');
			a('onkeyup','When a key is released');
			a('onmousemove','When the mouse is moved over an element');
			a('onmouseout','When the mouse leaves an element');
			a('onmouseup','When the mouse button is released');
			a('onsubmit','When a form is submitted');
			a('onreset','When a form is reset');
			a('onresize','When the browser is resized');
			a('onscroll','When the document is scrolled');
			a('onselect','When some text is selected');
			a('alert(\'Click OK to add an element\')','Creating alert with some text');
			a('newdiv = document.createElement(\'div\')','Creating new div');
			a('newdiv.id = \'NewDiv\'','Asigning id "NewDiv" to new div element');
			a('document.body.appendChild(newdiv)','Adding div to DOM');
			a('pnode = newdiv.parentNode','Delete newdiv element');
			a('pnode.removeChild(newdiv)','Delete newdiv element');
			a('tmp = pnode.offsetTop','Delete newdiv element');
			a('','');
			?>
		</div>
	</div>
</body>
</html>