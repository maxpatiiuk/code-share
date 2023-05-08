<?php
	$menu[0][0][0]="http://mambo.zzz.com.ua/coding/";
	$menu[1][0][0]="http://mambo.zzz.com.ua/coding/contacts/";
	$menu[0][1][0]="Головна";
	$menu[0][1][1]="Home";
	$menu[1][1][0]="Контакти";
	$menu[1][1][1]="Contacts";
	$menu[1][0][1]="?lang=ua";
	$menu[0][0][1]="?lang=en";
	$cont[0][0]="Що зробити з текстом?";
	$cont[0][1]="What to do with text?";
	$cont[1][0]="Кодувати";
	$cont[1][1]="Encode";
	$cont[2][0]="Декодувти";
	$cont[2][1]="Decode";
	$cont[3][0]="http://mambo.zzz.com.ua/coding/encode/";
	$cont[3][1]="http://mambo.zzz.com.ua/coding/decode/";
	$cont[4][0]="Виберіть спосіб декодування";
	$cont[4][1]="Choose decoding method";
	$cont[5][0]="ASCII";//[5][1]
	$cont[6][0]="Введіть текст";
	$cont[6][1]="Enter text";
	$cont[7][0]="Конвертувати";
	$cont[7][1]="Convert";
	$cont[8][0]="Стерти";
	$cont[8][1]="Reset";
	$cont[9][0]="Результат:";
	$cont[9][1]="Result:";
	$cur_l = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'));
	function top_ua($this){
		global $menu;
		echo '
		<div class="top">
			<nav>
				<a href="'.$menu[0][0][0].'" class="link';
		if($this==0){
			echo ' this';
		}
		echo '">'.$menu[0][1][0].'</a>
				<a href="'.$menu[1][0][0].'" class="link';
		if($this==1){
			echo ' this';
		}
		echo '">'.$menu[1][1][0].'</a>
			<a href="'.$cur_l.$menu[0][0][1].'" class="lang l_en r"></a>
			<a class="lang l_ua r l_cur"></a>
			</nav>
		</div>';
	}
	function top_en($this) {
		global $menu;
		echo '
		<div class="top">
			<nav>
				<a href="'.$menu[0][0][0].'" class="link';
		if($this==0){
			echo ' this';
		}
		echo '">'.$menu[0][1][1].'</a>
				<a href="'.$menu[1][0][0].'" class="link';
		if($this==1){
			echo ' this';
		}
		echo '">'.$menu[1][1][1].'</a>
			<a class="lang l_en l_cur r"></a>
			<a href="'.$cur_l.$menu[1][0][1].'" class="lang l_ua r"></a>
			</nav>
		</div>';
	}
function head($l_css){
	echo '
	<link href="'.$l_css.'style.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<meta charset="utf-8" />';
}
?>