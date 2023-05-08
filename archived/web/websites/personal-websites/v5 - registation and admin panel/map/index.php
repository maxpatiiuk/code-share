<!-- index.php -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Головна сторінка</title>
		<style>
			a.new {
				color: red;
			}
			a.unr {
				color: green;
			}
			body {
				background: #222;
				margin: 0;
			}
			#a {
				border: none;
			}
			ul {
				float: left;
				list-style: none;
			}
			a {
				color: #f18a05;
			}
			* {
				text-decoration: none;
				outline: none;
				font-family: monospace;
				font-size: 1vw;
			}
			#clock {
				float: right;
				text-align: center;
				color: #ccc;
				padding: 1vh 7vw 0 0;
			}
			#main {
				font-size: 6vw;
			}
			#sec {
				font-size: 3vw;
			}
			#bookmarksBar {
				padding: 1vw;
				clear: both;
				float: right;
			}
			.bookmark {
				width: 12vw;
				float: left;
				display: flex;
				justify-content: center;
				align-items: center;
				height: 8vw;
				text-align: center;
				margin: 0 1vw;
				border: 0.2vw solid #444;
				color : #fff;
				font-family: Comic Sans MS;
				font-size: 2vw;
			}
			.bookmark:hover {
				border-color: #ddd;
			}
			.b1 {
				background: #d11;
			}
			.b2 {
				background: #14d;
			}
			.b3 {
				background: #000;
			}
			.b4 {
				background: #fc1;
			}
		</style>
	</head>
	<body>
		<ul>
			<li><a href="consp/">Конспект</a></li>
			<li><a href="files/d3_3.php">CSS анімації</a></li>
			<li><a href="files/d3_4.php">Прапори в CSS</a></li>
			<li><a href="files/d3_5.php">Виставка картин</a></li>
			<li><a href="files/d3_6.php">Гістограма</a></li>
			<li><a href="files/d3_7.php">Д/З з алгебри</a></li>
			<li><a href="files/d3_8.php">Задання стилів через форму</a></li>
			<li><a href="files/d3_9.php">Таблиця з гістограмою</a></li>
			<li><a class="unr" href="../coding">Сервіс кодування та декодування тексту</a></li>
			<li><a href="http://test.mambo.in.ua/site/">Сайт для УАС</a></li>
			<li><a href="http://shop.mambo.in.ua/">MAMBO SHOP 3.0</a></li>
			<li><a href="mysql/">Робота з базами даних</a></li>
			<li><a href="http://mambo.in.ua/map/shuft/index.php">Шифрування тексту</a></li>
			<li><a href="files/d3_10.php">Генератор конспекту</a></li>
			<li><a href="files/d3_12.php">Пропорції</a></li>
			<li><a href="files/d3_13.php">Генератор опису</a></li>
			<li><a class="unr" href="files/d3_11.php">(0DE</a></li>
			<li><a href="files/d3_14.php">Графік і таблиця для декількох заданих функції</a></li>
			<li><a href="files/d3_15.php">Візуальний генератор чисел</a></li>
			<li><a href="files/d3_16.php">HEX рандомайзер і шифрувальник</a></li>
			<li><a href="files/d3_17.php">Bootstrap конспект</a></li>
			<li><a href="files/d3_20.php">Bootstrap конспект 2</a></li>
			<li><a href="files/d3_18.php">Шукач закономірностей в степeнях</a></li>
			<li><a class="unr" href="files/d3_19.php">Web game (JS+Jquery+Bootstrap)</a></li>
			<li><a class="unr" href="shuft/">Шифрування тексту</a></li>
			<li><a class="unr" href="espanol.zzz.com.ua">Espanol.zzz.com.ua</a></li>
			<li><a class="unr" href="nauka.zzz.com.ua">Nauka.zzz.com.ua</a></li>
		</ul>
		<div id="clock">
			<div id="main"></div>
			<div id="sec"></div>
		</div>
		<div id="bookmarksBar">
			<a class="bookmark b1" href="https://www.youtube.com/">youtube</a>
			<a class="bookmark b3" href="https://itc.ua/">itc</a>
			<a class="bookmark b2" href="https://translate.google.com.ua/">translate</a>
			<a class="bookmark b4" href="https://www.coindesk.com/price/">coindesk</a>
		</div>
	</body>
	<script>
	function startTime() {
		var t = new Date();
		document.getElementById("main").innerHTML = t.getHours()+":"+checkTime(t.getMinutes())+":"+checkTime(t.getSeconds());
		document.getElementById("sec").innerHTML = t.getDate()+"/"+(t.getMonth()+1);
		var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
		if (i < 10) {i = "0" + i};
		return i;
	}
	startTime();
	</script>
</html>