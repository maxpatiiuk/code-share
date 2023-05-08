<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Конспект</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<?php
	function a($text=NULL,$title=NULL,$count='0',$bold=NULL){
		if($count){
			$count*=20;
			echo '<p style="width:'.$count.'px;"></p>';
		}
		if($bold)
			echo '<b>';
		if($title)
			echo '<abbr title="'.htmlentities($title).'">'.htmlentities($text).'</abbr></b><br>';
		else if($text)
			echo htmlentities($text).'</b><br>';
		else echo '<br>';
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
			a();
			a('$objaect = new User;','Create object with name object and class User');
			a('$objaect -> a=1;','Set a value to 1');
			a('$objaect -> abc();','Calling to function');
			a('Class User {','Start working with class');
			a('public $a, $b;','Declare public $a and $b',1);
			a('function abc() {...}','Declaring function with name abc',1);
			a('}','Outing of class');
			a('$object2 -> clone $oblect','Creat $object2 with parameters of $object');
			a();
			a('count();','Return count of elements in array');
			a('sort($arr,SORT_NUMERIC);','Sort array $arr nomeric. Can also use rsort and SORT_STRING');
			a('shufle();','Elements of array in random order');
			a('explore();','Each string word as new array element');
			a('compact();','Array from anems of elements in associative array');
			a();
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
			a();
			?>
		</div>
		<div class="html">
			<?php
			a();
			a('<form method="post" action="index2.php" enctype="multipart/form-data" id="form">','create form with id &quot;form&quot;, with enctype for uploading images and action of submit bitton to index2.php');
			a('<input type="file" name="filename" size="10">','create button with widt of 10 characters of current font and name &quot;filename&quot; for uploading file.',1);
			a('<input type="submit" value="upload">','create buttun for submition form with &quot;upload&quot; writed on it',1);
			a('</form>','closing form');
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
			a('echo "Uploaded image ".$name." as"$n":<br>"','echo name and type of file',2);
			a('echo "<img src="$n">"','showwing image',2);
			a('}','',1);
			a('else echo $name." is not an accepted image file";','echo error if uploaded file was not image',1);
			a('}','');
			a('else echo "No image has been uploaded";','');
			a();
			?>
		</div>
		<div class="html">
			<?php
			a('<form method="post" action="formtext.php" id="first_form">','creating post form with action to formtext.php and id of first_form');
			a('<input type="text" name="surname" value="Mambo" size="25" maxlenght="24" autocomplete="on" autofocus="autofocus" placeholder="Type your SurName" required="required" form="first_form">','Create required  text input with name &quot;surname&quot;, start value &quot;mambo&quot;, width of 25 charachers, maxlenght of 24 characters, autocomplete, autofocus and grey text &quot;Type your name&quot; for form &quot;first_form&quot;',1);
			a('<input type="submit" formaction="index2.php">','Create submit button with click action to index2.php',1);
			a('<textarea cols="5" rows="10">default text here$lt;/textarea>','creating textarea with width of 5 characters, height if 10 characters and default text &quot;default text here&quot;');
			a('<input type="checkbox" name="abc" checked="checked"','Creating checked flag. If there are more then one flag, set name as array. t.e: name=&quot;name[]&quot; and php - $ice=$_POST[&quot;ice&quot;]');
			a('<input type="hidden" value="$var"','Creating hidden input for sending some data. Browser does not show hidden input');
			a('<select size="30" multiple="multiple"','creates multi selective block');
			a('<option value="22"</option>...','create one of select options',1);
			a('</select>','close select tag');
			a('<label>Text<input type="checkbox">$lt;/label>','link &quot;Text&quot; and chechbox. So, after clicking on text, chechbox will be selected');
			?>
		</div>
		<div class="php">
			<?php
			a('isset($_POST["val"]);','check if varible has been asigned');
			a('setcookie(name,val,life_time,path,domain)','set cookie name with value of value and lifetime for example "time()+60*60*24*4" which will be avaible on cur directory by def ir in all domain if we will set path to "/". If domain set to main doman, cookie will be avaible from all donains. Is set to subdomain, only on subdomain. to delete thus cookie echo setcookie function with cur nane empty value and time of menus value : "time()-60*60*24*7*4".');
			a('isset($_COOKIE["name"])','Check if cookie with name of name has been set');
			a('hash(); md5();','encode string with md5 or other type of encoding');
			a();
			a('session_start();','Start sesion - analog of cookie');
			a('$_SESSION["somevalue"]=$val;','Set sesion somevalue val to $val');
			a('setcookie(session_name(),"",time()-2592000,"/"','Delete sesion name from cookie');
			a('session_destroy();','Permament deleting if this sesion');
			a('ini_set("session.gc_maxlivetime",60*60*24);','Set session lifetime to one day');
			?>
		</div>
		<div class="html">
			<?php
			a();
			a('<script src="a.js">/*scripts*/</script>','Import a.js script file to this html page. if we are using script tag without src, can type some scripts inside the script container');
			a('<noscript<>/noscript>','Some html code which will be displayed in brousers withoud support of js or with turned of js');
			a('js dev console in google chrone','Menu-Developer-JavaScripy Console. Or ctrl+shift+j');
			a('Best js debugger - www.getfirebug.com','');
			a('<a class="link" href="a.php">','');
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
			a('documeny.write(document.links[i].href+"<br>")','get all links which are on cur document',1);
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
			a();
			a('/a +b/','Check if string contain a with some amount of spaces and b');
			a('/<.*>/','Check if string contain < with or without content and >');
			a('/<.*>/','Check if string contain < with or without content and >. if we will use + except of *, function will not match empty content');
			a('/aban\.ana/','Will display fullstop as fulls top, not as regular parameter');
			?>
		</div>
		<div class="css">
			<?php
			a();
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
			a();
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
			a('onmouseout="this.src=\'apple.png\'">','This line will change image back to apple.png while mouse is out. Now, I am closing html tag');
			a('&#60;img id="object" src="apple.png">','We can do same, by another way:');
			a('&#60;script>','Starting script');
			a('O(\'object\').onmouseover=function(){this.src=\'orange.png\'}','In this exaple, I used "this" after using of O function',1);
			a('O(\'object\').onmouseout=function(){this.src=\'apple.png\'}','Change image back to apple.png',1);
			a('&#60;/script>','Closing script');
			?>
		</div>
		<div class="js">
			<?php
			a('onblur','When element loses focus');
			a('onclick','When object is clicked',0,1);
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
			a();
			a('$(\'#a, .class\').click(function(){$(\'div\').remone()})','Delete all div objects from DOM after clicking on element with id "a" or class "class"');
			a('$(\'.class\').css(\'font-family\',\'monospace\')','Make css value of font-family to "monospace" of all DOM elements with class of "class". If use .css without second argument, will return current value of element. We can replace this statment with this one : "getElementsByClassName(\'class\').style.fontfamily=\'monospace\'"');
			a('$(\'#ans\').html(\'<br>Text_123\')','Replace content of element with id "ans" to "<br>Text_123". What is more, we can use append - to write some code after existing content of element, or prepend - before the content');
			a('$(\'document\').ready(function(){ ... })','Perform function when the page is fully loaded');
			a('$(\'#obj\').hide(1000,linear,func())','Start linear (or swing) hiding of element with id "obj" with duration of 1000 minllisecond and starting function "func" after completing. Except of hide, we can use show to show element and toggle - switcher betwen hide and show');
			a('$(\'#obj\').fadeToggle','Fade element. Have same parameters as .hide() (prev line). Can use FadeIn, FadeOut and FadeTo - fading to percent value - second parameter');
			a('$(\'#obj\').slideUp','Slide element. Have same parameters as .fadeIn() (prev line). Can use slideDown and SlideToggle');
			a();
			a('/*For animating elements via JS, u need to set position of el to relative or fixed*/','');
			a('$(\'img\').animate({left:\'200px\',top:\'300px\'},\'slow\',\'linear\')','Animate images to 200px left and 300px right slowly and linearly. Can also use += or -=');
			a('alert(\'123\')','Create pop up alert window');
			a('$(\'input\').val(\'123\')','Setting value of input');
			a('$(\'a\').text(\'My site!\')','Change text of link');
			a('$(\'a\').attr({href: \'http://web.com\' title: \'Site\')}','Change link of link and adding title');
			a('width=$(window).width()','Will returt a number of pixels in width of currend window');
			a('width=$(document).css(\'width\')','Will returt a number of pixels and "px" in width of entire document');
			a('$(\'a\').remove()','Delete object from DOM. We can also use empty() method to delete only content of object');
			a('$(\'a\').addClass(\'mycls\')','Add class to element (class="mycls"). We can also use renoveClass and toggleClass');
			a('$(\'a\').innerWidth()','Return height of element including padding.');
			a('$(\'a\').outerWidth(true)','Return width, borde and padding of element. If we will use attribute "true", method will also return margin');
			a('$(\'a\').parent(\'.class\')','Return parent of cur el. Will retur only childs which maches the argument');
			a('$(\'a\').parents(".class")','Return al parents which matches the arguments. We can also use .parentUntill method to select only first paent which match the argument');
			a('$(\'a\').child()','Return childs of el. We can also use .find() which is inverse of .parents()');
			a('$(\'a\').siblings(".new").andSelf()','Will select all sublings of this elemet which have ckass of new. We can also add .andSelf() method to select this element');
			a('$(\'a\').next(".add")','Will select element which is located ater curent and has class of .add . We can also use .nextAll to select all next el which matches the argument and .nextUntil - first eagument is filter for stoping selecting next values and second is filter for seling elements');
			a('$(\'a>ul\').first()','Select first ul child of a. We can also use .last to select last child');
			a('$(\'ul>li\').eq(1)','Will select second li child of ul element (starting from 0)');
			a('$(\'#el\').filter(:even)','We  can select element whichmatches css filte (ex first-child). For using css :not statment, we can use ,not method');
			a('$(\'#el\').has("b")','Select #el which has b element inside');
			a('setInterval(func(),1000)','Will run func() function every 1000 milliseconds (1s)');
			a();
			?>
		</div>
		<div class="html">
			<?php
			a('<selection itemscope itemtype="http://website.com">','Starting micodata');
			a('<img itemorop="image" src="awg.jpg" alt="text">','Create image for microdata',1);
			a('/*Read more about microdataon - http://schema.org */','',1,1);
			a('</section>','');
			a('/*Social media website example - http:/lpmj.net */','','','1');
			a();
			a('<div class="row-fluid">','.row and .row-fluid creates grid of 12 columns. We can use row-fluid to make it adaptive');
			a('<div class="span6"></div>','Make a block with wodth of 6 columns (50vw)',1);
			a('<div class="span4 offset2">','Nest 4 columns with padimg-left of 2 columns',1);
			a('<div class="row"></div>','Normaly, we would have 4 columns in this grid. But because paent was row-fluid, this one will have 12 smaller columns',2);
			a('</div>','',1);
			a('</div>','');
			a('<small>123</small>','Make content inside the container smaller, less colorful and less bold');
			a('<p class="lead"></p>','Make content of this element larger, bolder and moe colorful');
			a('<strong><em>123</em></strong>','Make text bold and italic');
			a('<p class="muted">123</p>','Grey text');
			a('<p class="text-warning">123</p>','Orange text');
			a('<p class="text-error">123</p>','Red text');
			a('<p class="text-info">123</p>','Blue text');
			a('<p class="text-success"></p>','Green text');
			a('<addres>NYC, USA<br><a href="mailto:meail@em.ail">email</a></addres>','Use <addres> tag for creating contact blocks');
			a('<blockquote class="pull-right">','Creating quote. By adding class, we are floating quote ight');
			a('<p>Quote</p>','Block fo quote',1);
			a('<small>Citizen of Mars, </small>','Block for derscribing author',1);
			a('<cite title="Source title">Marica Debec</cite>','Block for author name',1);
			a('</blockquote/>','');
			a('<ul class="unstyled"></ul>','We can add "unstyled" class to ol or ul to delete standart css styles');
			a('<dl class="dl-horizontal">','Starting definition list. Adding class makes it horizontal');
			a('<dt>Definition</dt>','Creation definition',1);
			a('<dd>Description</dd>','Creating descriotion',1);
			a('</dl>','');
			a('<code><br></code>','For storing one-line code');
			a('<pre><div class="text">','For storing multiline code');
			a('</div></pre>','');
			a('<table class="table table-striped table-hover table-borded table-condensed">','Create flexible table. table-hover class will make row background gey while hoveing. table-boder will add all boders and border-radius. table-stiped will create stripes from rows backgrounds. table-condendsed will make padding smaller');
			a('<cation>This is exaple table</caption>','Describes table content',1);
			a('<thead>','Create first main bold row of table',1);
			a('<tr class="success">','Create row with green background',2);
			a('<th>Column 1</th>','Ceate column',3);
			a('<th>Column 2</th>','Create column',3);
			a('</tr>','',2);
			a('</thead>','',1);
			a('<tbody>','Starting of table content',1);
			a('<tr class="error warning info">','Create row. Will create row with red, yelow and blue background. Note: use only one of this for classes at onse',2);
			a('<th>Content 1</th>','Ceate column',3);
			a('<th>Content 2</th>','Create column',3);
			a('</tr>','',2);
			a('</tbody>','Closing table content',1);
			a('</table>','End of table');
			a('<form class="form-inline">','Create flexible form. By adding forn-inline class, we mamke el of form located inline. By adding class form-horizontal, we make it extra flexible');
			a('<fieldset>','Manage padding and allows to use <legend> tag',1);
			a('<legend>Login</legend>','Analog of h2+hr+flexile design',2);
			a('<div class="control-group controls-row">','Makes input and label extra flexible. We should use controls class for diving 1 el. And control-group for more then one. We can add controls-row class to make it inline',2);
			a('<label class="control-label" for="name">Name</label>','Creating label for input with id of "name". We make it extra flexible by adding class',3);
			a('<input id="name" type="text" placeholder="Enter your name">','',3);
			a('</div>','',2);
			a("<label class=\"radio\">","Creating label for radio input. We can also create chechbox. We can add inline class to make labels located inline","2","");
			a("<input type=\"radio\">","Creating radio. We can also create chekbox","3","");
			a("Label. Some text","Ceating label text","3","");
			a("</label>","","2","");
			a("<select multiple=\"multiple\">","Creating adaptive multiple select","2","");
			a("<option>1</option>","Option","3","");
			a("<option>2</option>","Option","3","");
			a("</select>","","2","");
			a('<div class="input-prepend">','Creating input with prependet text. We can also use input-append','2','');
			a('<span class="add-on">@</span>','Creating prependet or appendet text. If we use it for appending, swipe this and next lines','3','');
			a('<input class="span2" id="prependedInput" type="text">','Creating input. For appending use appendedInput id. If we would like to combine both, add both classes to div, create two spans and replace input id with appendedprependedinput','3','');
			a('<button class="btn" type="button">Generate</button>','We can add button with class of btn to append or pepend div','3','');
			a('</div>','','2','');
			a('<span class="help-block">We are accepting names no longer that 30 characters lenght</span>','Ceating aditional information. We can add lass help-inline except, to make block be located at same line with input',2);
			a('<label class="checkbox" for="chechbox">','Creating label with checkbox',2);
			a('<input type="checbox" id="checkbox">','Creating checkbox',3);
			a('Remember me','Label for checkbox',3);
			a('</label>','',2);
			a("<input type=\"text\" class=\"search-query input-medium input-block-level\">","creates input field with rounded edges and medium size. By adding iput-block-method class we made it displayed like block - width 100%","2");
			a('<input type="text" class="input-mini">','We can change input size b adding classe: input-mini, input-small, input-medium, input-large, input-xlarge,input-xxlarge. We can also control elements size by adding span class with number from 1 to 12','2','');
			a('<span  class="uneditable-input">Text</span>','We can create uneditabl input by adding uneditable-input class','2','');
			a('<input type="text" id="focusedInput">','Add blue shadow owhile input is on focus','2','');
			a('<input type="text" id="disabledinput">','Make input disabled an change its styles','2','');
			a('<div class="control-group warning">','Create warning box. Except warning, we can use info, error, succes...','2','');
			a('<label class="control-label" for="inputWarning">Warning</label>','Creating warning label','3','');
			a('<div class="controls">','Creating controls flexible block for input and label','3','');
			a('<input type="text" id="inputWarning">','Creating input with yelow boder','4','');
			a('<span class="help-inline">Corect something</span>','Ceating yellow color prepended label','4','');
			a('</div>','','3','');
			a('</div>','','2','');
			a('<button class="btn btn-large">BTN</button>','We can changebtn size with classes: btn-large, btn, btn-small, btn-mini','2','');
			a('<button class="btn btn-info">Buutons styles</button>','We can style button eassyly by adding one of this classes: btn-primary, btn-info, btn-success, btn-warning, btn-danger, btn-invese, btn-link','2','');
			a('<button class="btn-block">BTN</button>','Makes button display block - width 100%','2','');
			a('<button class="btn disabled" disabled="disabled">123</button>','Classes make button look like disabled and attibute disabled with value of disabled makes it truely disabled','2','');
			a('<button type="submit" class="btn btn-pimary">Login</button>','Creating submit button. By adding btn-pimary class, we make it blue',2);
			a('</fieldset>','Ending fieldset',1);
			a('</form>','Exiting form');
			a();
			a('<img class="img-rounded">','Create border radius of 6px','','');
			a('<img class="img-circle">','Create boder radius of 500px','','');
			a('<img class="img-polaroid">','Create polaroid-styled image','','');
			a('<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">','Creates simple dropdown menu using bootstrap js library. We can add pull-right class to make it right-aligned','','');
			a('<li><a tabindex="-1" href="#">Home</a></li>','Creates link to home page with adress of "#"','1','');
			a('<li><a tabindex="-1" href="#">Contacts</a></li>','Creates link to contacts page with adress of "#"','1','');
			a('<li class="divider"></li>','Create horizontal line (like hr). Can be used to separed menu links of grouups of links','1','');
			a('<li class="dropdown-submenu">','By adding dropdown-submenu class to li, we can create submanu','1','');
			a('<a tabindex="-1" href="#">Others</a>','Creating link','2','');
			a('<ul>','Starting submenu','2','');
			a('<li><a tabindex="-1" href="#">Ex1</a></li>','Creates link to Ex1 page with adress of "#"','3','');
			a('<li><a tabindex="-1" href="#">Ex2</a></li>','Creates link to Ex2 page with adress of "#"','3','');
			a('</ul>','Closing submenu','2','');
			a('</li>','Closing menu line','1','');
			a('</ul>','Close menu','','');
			a('<div class="btn-toolbar">','We can group multiple btn-groups inside btn-toolbar class, to make it auto aligned, responsible and inlined','','');
			a('<div class="btn-group">','Creaing aligned group of  buttons. We can add .btn-group-vertical to make it vertical','1','');
			a('<button class="btn">1</button>','Button 1','2','');
			a('<button class="btn">2</button>','Button 2','2','');
			a('</div>','Closing btn-group','1','');
			a('<div class="btn-group">','Creaing aligned group of  buttons','1','');
			a('<button class="btn">1</button>','Button 1','2','');
			a('</div>','Closing btn-group','1','');
			a('</div>','Closing btn-toolbar','','');
			a('<div class="btn-group dropup">','Creating button dropdown. By addind dropup class we made dropdown oppens to top (not to bottom). Also caret arrow now poits the top raither the bottom','','');
			a('<button class="btn btn-info">Info</buttom>','Creating regular information button (without dropdown)','1','');
			a('<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Danger</button>','Creating danger button with dropdown. (We added dropdown-toggle class and data-togle="dropdown")','1','');
			a('<span class="caret"></span>','Creating arow (which will visualy indecate the dropdown)','2','');
			a('</button>','Closing button','1','');
			a('<ul class="dropdown-menu">','Creating dropdown menu which will be togglin on or off by previus button (btn-danger)','1','');
			a('<li><a href="#">1</a></li>','Button 1','2','');
			a('<li><a href="#">1</a></li>','Button 2','2','');
			a('</ul>','Exiting dropdown menu','1','');
			a('</div>','Closing btn-group div','','');
			a('<ul class="nav nav-tabs nav-stacked">','Creating nav tabs. We can also replace naw-tavs with nav-list or nav-pills to make it look like buttons. By adding nav-stacked class we made it located verticaly','','');
			a('<li class="nav-header">List header</a>','We can add header wich will be located before menu and will name the curent group of menu links','1','');
			a('<li class="active"><a href="#">Home</a></li>','Creating active button, which will have diferent color than other tabs','1','');
			a('<li class="disabled"><a href="#">Tab 2</a></li>','Tab 2. By addign class disabled, we made it grey and unhoverble. We can also make it unklicabke by removing href atribute','1','');
			a('<li class="divider"></li>','Create horizintal divider (like hr tag)','1','');
			a('<li><a href="#">Tab 3</a></li>','Tab 3. We can also create dropdown inside the nav','1','');
			a('</ul>','','','');
			a('<div class="tabbable tabs-left">','Create tabs. By adding tabs-left or tabs-right class we made headers located on the leftor right sode of content','','');
			a('<ul class="nav nav-tabs">','Creating tabs headingg. We can also place tab-content before nav-tabs, so tabs headers will be located after content','1','');
			a('<li class="active"><a href="#tab1" data-toggle="tab">Home</a></li>','Class active make it painted another way. Creating tab heading with nameof Home and href of #tab1','2','');
			a('<li><a href="#tab1" data-toggle="tab">Others</a></li>','Unactive tab with header text of Others','2','');
			a('</ul>','','1','');
			a('<div class="tab-content">','Filling content for headers','1','');
			a('<div class="tab-pane active fade" id="tab1"><p>This is home page</p></div>','Creating content for Home tab. We can also add fade class to each tab-pane to make it fade on switching','2','');
			a('<div class="tab-pane fade" id="tab2"><p>This is not home page</p></div>','Creating content for Others tab','2','');
			a('</div>','','1','');
			a('</div>','','','');
			a('<div class="navbar navbar-inverse navbar-default navbar-fixed-top">','Creating horizontal menu. By addding navbar-fixed-top class we made its position fixed with top:0. We can also add navbar-fixed-bottom class or navbar-static-top. By adding navbar-inverse class we make colors inversed (black and dark grey)','','');
			a('<div class="navbar-inner">','Creating menu','1','');
			a('<a class="brand" href="#">MAMBO</a>','Creating site name','2','');
			a('<ul class="nav">','Creating other menu elements','2','');
			a('<li class="active"><a href="#">Home</a></li>','Creating active tab','3','');
			a('<li><a href="#">Contacts</a></li>','Creating tab','3','');
			a('<li class="divider-vertical">','Creating extra margin space','3','');
			a('<li><a href="#">Shop</a></li>','Creating tab','3','');
			a('<form class="navbar-form pull-right">','We can even create adapptive form inside navbar and align it by adding classes: pull-right, pull-left. We can alos replace class navbar-form by navbar-search to make elements inside have border radius','3','');
			a('<input type="text" class="span2" id="frame">','Creating text input. By adding search-query class (and replacing form class - prev line) we add border radius to it','4','');
			a('<button type="submit" class="btn">','Creatign submit button','4','');
			a('</form>','','3','');
			a('</ul>','','2','');
			a('</div>','','1','');
			a('</div>','','','');
			a('<div class="header">','Creating responsible menu with using bootstrap.js','','');
			a('<div class="navbar-inner">','','1','');
			a('<div class="container">','','2','');
			a('<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">','Creating button that will open or close navbar','3','');
			a('<span class="icon-bar"></span>','Generating buttom','4','');
			a('<span class="icon-bar"></span>','Generating buttom','4','');
			a('<span class="icon-bar"></span>','Generating buttom','4','');
			a('</a>','','3','');
			a('<a href="#" class="brand">MAMBO</a>','We are placing brand name outside the nav class, to do not colapse it by clicking the button','3','');
			a('<div class="nav colapse colapse">','Creating colapsed menu','3','');
			a('/*nav elements here*/','Content of menu goes here (<li>,<button>, <form> and others)','4','');
			a('</div>','','3','');
			a('</div>','','2','');
			a('</div>','','1','');
			a('</div>','','','');
			a('<ul class="breadcrump">','reates breadcrump which can be used to navigate easyly. It creates horizontal line made with links like this: Home > 1 > 2 > 3. And user can click to each to navigate','','');
			a('<li><a href="#">Home</a><span class="divider">&rarr;</span></li>','Creating link with divider','1','');
			a('<li><a href="#">1</a><span class="divider">&rarr;</span></li>','Creating link with divider','1','');
			a('<li><a href="#">2</a><span class="divider">&rarr;</span></li>','Creating link with divider','1','');
			a('<li><a href="#">3</a></li>','Creating link','1','');
			a('</ul>','','','');
			a('<ul class="pagination">','Creates paginator to easyly navigate throug blog pages. We can also resize it by adding class pagination-lg or pagination-sm','','');
			a('<li class="disabled"><a href="#">$laquo;</a></li>','We can add aditional styling by adding classes to li element: dissabled or active','1','');
			a('<li class="active"><a href="#">1</a></li>','We can add aditional styling by adding classes to li element: dissabled or active','1','');
			a('<li><a href="#">2</a></li>','','1','');
			a('<li><a href="#">3</a></li>','','1','');
			a('<li><a href="#">$raquo;</a></li>','','1','');
			a('</ul>','','','');
			a('<ul class="pager">','Another good way to create pagination. We can also add previous and next class to make it left or right aligned','','');
			a('<li><a href="#">1</a></li>','','1','');
			a('<li><a href="#">2</a></li>','','1','');
			a('</ul>','','','');
			a();
			a('<span class="label">Label</span>','Creating label','','');
			a('<span class="label label-success">Label</span>','We can stylize label by adding classes: label-success, -warning, -info, -important, -inverse','','');
			a('<span class="badge">Badge</span>','Creating badge. Diference bitwet label and badge: bedge has bigger border radius','','');
			a('<span class="badge badge-success">Badge</span>','We can stylize badge by adding classes: badge-success, -warning, -info, -important, -inverse','','');
			a('<div class="hero-unit">','We can create hero-unit class wicth will encrease font-size of its childs','','');
			a('<h1>Hello</h1>','','1','');
			a('<p>Hello 123<br>34ghj</p>','','1','');
			a('</div>','','','');
			a('<div class="page-header">','Create page header - usefull for blogs and articles','','');
			a('<h1>This is page header</h1>','','1','');
			a('</div>','','','');
			a('<ul class="thumbnails">','We can create grid of thumbnail by creaating ul tag and li as rows. it is very useful for locating elements grid-like (for shops and blogs)','','1');
			a('<li class="span4">','We can create grid of thumbnail by creaating ul tag and li as rows','1','');
			a('<a href="#" class="thumbnail"><imh src="img1.png"></a>','Creating thumbnail','2','');
			a('<a href="#" class="thumbnail"><imh src="img2.png"></a>','','2','');
			a('<a href="#" class="thumbnail"><imh src="img3.png"></a>','','2','');
			a('</li><li class="span4">/* ... thumbnails here ... */</li>','','1','');
			a('</ul>','','','');
			a('<div class="alert">','Creating alert. We should use alert-block class for multiline alerts. Except alert class we can use alert-error, alert-succes and allert-info','','');
			a('<a href="#" class="close" data-dismiss="alert">&tomes;</a>','Creatign cros, by clicking on which, this element will be deleted from DOM (using jquery)','1','');
			a('<strong>Alert!</strong> One line text here!','Alert text','1','');
			a('</div>','','','');
			a('<div class="progress progress-striped active">','Creating progress bar. By addign progress-striped class we made it striped and by adding active class we vmade it animated','','');
			a('<div class="bar bar-succes" style="width: 60%;"></div>','Controling of progress bar performs by changing width percent walue','1','');
			a('<div class="bar bar-warning" style="width: 10%;"></div>','','1','');
			a('<div class="bar bar-danger" style="width: 5%;"></div>','','1','');
			a('</div>','','','');
			?>
		</div>
	</div>
</body>
</html>