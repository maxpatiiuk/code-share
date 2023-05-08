<!-- Docs -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?php include 'head.php';?>
		<title>Docs docs - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key.</title>
		<meta name="description" content="Docs docs - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key." />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="ism/css/my-slider.css"/>
		<script src="ism/js/ism-2.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$(".tabs").lightTabs();
		});
		</script>
		<script type="text/javascript" src="http://docs.zzz.com.ua/scripts/js1.js"></script>
	</head>
	
	<body>
		<?php include 'top.php';?>
		<div class="wrapper">
			<div class="content">
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
					m1("http://docs.zzz.com.ua/minecraft/","Купити Minecraft","http://s8.hostingkartinok.com/uploads/images/2016/07/d733e3d60751a167a3f4e884b7b9c06c.png","Minecraft Premium Акаунт + Подарунок",2);
					m2("http://docs.zzz.com.ua/csgo/","Купити CSGO","http://s8.hostingkartinok.com/uploads/images/2016/08/139fb4b3919fa7b8394a6660289feb3c.jpeg","Counter-strike : Global Offensive (GIFT)",210);
					m1("http://docs.zzz.com.ua/gta/","Купити GTA 5","http://s8.hostingkartinok.com/uploads/images/2016/07/51ff01ccc1580258e70f288e860060b7.png","Grand Theft Auto V (GTA 5) PC",112);
					m2("http://docs.zzz.com.ua/fifa17/","Купити FIFA 17","http://s8.hostingkartinok.com/uploads/images/2017/02/74b7d286ca960d5c67ef5bc865deddf6.png","Fifa 17 + Подарунок + Бонус",33);
				?> 
		</div> 
		<?php include 'down.php';?>
	</body>
</html>