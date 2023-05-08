<!-- Shop -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mambo Shop - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key.</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, магазин, магазин мамбо, mambo shop, minecraft за 2 гривні" />
<meta name="description" content="Mambo Shop - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key." />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/shop.css" rel="stylesheet" type="text/css" />
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<link rel="stylesheet" href="ism/css/my-slider.css"/>
<script src="ism/js/ism-2.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?127"></script>
<script type="text/javascript">
  VK.init({apiId: 5473757, onlyWidgets: true});
</script>
<script>
$(document).ready(function(){
	$(".tabs").lightTabs();
});
</script>
<script type="text/javascript" src="http://shop.mambo.zzz.com.ua/scripts/js1.js"></script>
<?php include 'http://shop.mambo.zzz.com.ua/head.php';?>
</head>
<body>
<?php include 'http://shop.mambo.zzz.com.ua/top.php';?>
    <div class="wrapper"><div class="content">
<div class="ism-slider" data-transition_type="fade" data-play_type="loop" data-interval="3000" id="my-slider">
  <ol>
    <li>
      <img src="ism/image/slides/_u/1481221771287_104973.jpg">
    </li>
    <li>
      <img src="ism/image/slides/_u/1481221770834_162982.jpg">
    </li>
    <li>
      <img src="ism/image/slides/_u/1481221771782_643709.jpg">
    </li>
    <li>
      <img src="ism/image/slides/_u/1481221771924_446850.jpg">
    </li>
    <li>
      <img src="ism/image/slides/_u/1481221772107_860134.jpg">
    </li>
  </ol>
</div>


<div class="tabs">
    <ul>
        <li>По рейтингу</li>
        <li>По ціні ▲</li>
        <li>По ціні ▼</li>
    </ul>
    <div>
<div>
<?php
function m1($link,$alt,$ilink,$name,$price) {
	echo "<a href=\"$link\"><div class=\"s1\">
			<div class=\"s1_img\"><img width=\"100\" height=\"100\" src=\"$ilink\" alt=\"$alt\"></div>
			<div class=\"s1_name\">$name</div>
			<div class=\"s1_price\"><div class=\"val\">&#8372</div><div class=\"val1\">$price</div></div>
		</div></a>";
}
function m2($link,$alt,$ilink,$name,$price) {
	echo "<a href=\"$link\"><div class=\"s2\">
			<div class=\"s2_img\"><img width=\"100\" height=\"100\" src=\"$ilink\" alt=\"$alt\"></div>
			<div class=\"s2_name\">$name</div>
			<div class=\"s2_price\"><div class=\"val\">&#8372</div><div class=\"val1\">$price</div></div>
		</div></a>";
}	
function minecraft($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/minecraft/";
$alt = "Купити Minecraft";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/07/d733e3d60751a167a3f4e884b7b9c06c.png";
$name = "Minecraft Premium Акаунт + Подарунок";
$price = 2;
$m1($link,$alt,$ilink,$name,$price);
}
function csgo($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/csgo/";
$alt = "Купити CSGO";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/08/139fb4b3919fa7b8394a6660289feb3c.jpeg";
$name = "Counter-strike : Global Offensive (GIFT)";
$price = 187;
$m1($link,$alt,$ilink,$name,$price);
}
function random($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/random/";
$alt = "Купити Random Key";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/02/9372ae8c72c642d595e43bf93566fd6c.png";
$name = "Random steam key (BRONZE / GOLD / DIAMOND)";
$price = "ВІД 4";
$m1($link,$alt,$ilink,$name,$price);
}
function outlast($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/outlast/";
$alt = "Купити Random Key";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/12/9c769bf262c0d7bc51e1d35d7c6862b6.jpg";
$name = "Outlast (Gift link) + Бонус";
$price = 62;
$m1($link,$alt,$ilink,$name,$price);
}
function gta($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/gta/";
$alt = "Купити GTA 5";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/07/51ff01ccc1580258e70f288e860060b7.png";
$name = "Grand Theft Auto V (GTA 5) PC";
$price = 128;
$m1($link,$alt,$ilink,$name,$price);
}
function rust($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/rust/";
$alt = "Купити RUST";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/10/a11595477275c279484ff06be9a008a2.jpg";
$name = "Rust(GIFT)";
$price = 163;
$m1($link,$alt,$ilink,$name,$price);
}
function batlefield($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/battlefield/";
$alt = "Купити Battlefield 1";
$ilink = "http://vignette3.wikia.nocookie.net/battlefield/images/5/5a/Battlefield_1_Icon.png/revision/latest?cb=20160927205246";
$name = "Battlefield 1 + Бонус";
$price = 27;
$m1($link,$alt,$ilink,$name,$price);
}
function starwars($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/star-wars/";
$alt = "Купити SW:B";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/07/d4268d146365c897fe2613b625451ccc.png";
$name = "STAR WARS Battlefront + random game";
$price = 12;
$m1($link,$alt,$ilink,$name,$price);
}
function left4dead2($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/left4dead2/";
$alt = "Купити SW:B";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/08/9d37bd274bbdfd457b02b73d9be7896f.jpg";
$name = "Left 4 Dead (Gift link)";
$price = 50;
$m1($link,$alt,$ilink,$name,$price);
}
function rocketleague($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/rocketleague/";
$alt = "Купити Rocket League";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/07/8594e4cb7aa3acfbf75e281c358b99df.png";
$name = "Rocket League (Gift link)";
$price = 109;
$m1($link,$alt,$ilink,$name,$price);
}
function payday2($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/payday2/";
$alt = "Купити PAYDAY 2";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/07/e815a2fd4254e91acf8237350c960ddc.jpg";
$name = "PAYDAY 2 + 14 DLC (GIFT LINK) + Бонус";
$price = 97;
$m1($link,$alt,$ilink,$name,$price);
}
function sims($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/sims/";
$alt = "Купити SIMS 4";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/08/b13a2437f1b6c606f4cc5ddd57d3caca.jpg";
$name = "The Sims 4 Digital Deluxe";
$price = 8;
$m1($link,$alt,$ilink,$name,$price);
}
function nfs($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/nfs/";
$alt = "Купити SIMS 4";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/08/b89508d3a9fac15a1b0b992f774e7bef.jpg";
$name = "Need for Speed™ Deluxe Edition 2016";
$price = 33;
$m1($link,$alt,$ilink,$name,$price);
}
function ark($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/ark/";
$alt = "Купити ARK SE";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2016/08/4ef7edf16c8654fb59f43ac0eac1d64d.jpg";
$name = "ARK: Survival Evolved + бонус";
$price = 47;
$m1($link,$alt,$ilink,$name,$price);
}
function watchdogs($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/watchdogs/";
$alt = "Купити Watch Dogs";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/01/edc60eb4afcf95726b594a4692b19846.jpg";
$name = "Watch Dogs (Upay gift link)";
$price = 85;
$m1($link,$alt,$ilink,$name,$price);
}
function fifa17($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/fifa17/";
$alt = "Купити FIFA 17";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/02/74b7d286ca960d5c67ef5bc865deddf6.png";
$name = "Fifa 17";
$price = 92;
$m1($link,$alt,$ilink,$name,$price);
}
function assassinsu($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/assassinsu/";
$alt = "Купити Assassins Creed Unity";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/02/57ebeb6d57b6714f06500bcb7f13410b.png";
$name = "Assassins Creed Unity";
$price = 7;
$m1($link,$alt,$ilink,$name,$price);
}
function crew($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/crew/";
$alt = "Купити The Crew";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/02/cbcc70002375ac01f77005bb6f8ed4cd.png";
$name = "The Crew";
$price = 11;
$m1($link,$alt,$ilink,$name,$price);
}	
function minecraft2($m1 = "m1") {
$link = "http://shop.mambo.zzz.com.ua/minecraft2/";
$alt = "Купити Minecraft Повний доступ";
$ilink = "http://s8.hostingkartinok.com/uploads/images/2017/02/0b5b6dd3d8a9af69628b8c7ea369c591.png";
$name = "Minecraft Premium Повний доступ + Подарунок";
$price = 9;
$m1($link,$alt,$ilink,$name,$price);
}
minecraft();
csgo("m2");
minecraft2();
random("m2");
gta();
rust("m2");
fifa17();
watchdogs("m2");
batlefield();
starwars("m2");
crew();
payday2("m2");
rocketleague();
assassinsu("m2");
nfs();
sims("m2");
left4dead2();
ark("m2");
outlast();
echo "</div><div>";
minecraft();
random("m2");
assassinsu();
sims("m2");
minecraft2();
crew("m2");
starwars();
batlefield("m2");
nfs();
ark("m2");
left4dead2();
outlast("m2");
fifa17();
watchdogs("m2");
payday2();
rocketleague("m2");
gta();
rust("m2");
csgo();
echo "</div><div>";
csgo();
rust("m2");
gta();
rocketleague("m2");
payday2();
watchdogs("m2");
fifa17();
outlast("m2");
left4dead2();
ark("m2");
nfs();
batlefield("m2");
starwars();
crew("m2");
minecraft2();
sims("m2");
assassinsu();
random("m2");
minecraft();
?> 
</div></div></div></div></div> 
 <?php include 'http://shop.mambo.zzz.com.ua/down.php';?></div>
<script>
w3IncludeHTML();
</script> 
</body>
<html>