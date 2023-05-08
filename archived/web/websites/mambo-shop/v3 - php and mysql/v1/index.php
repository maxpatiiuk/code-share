<!-- Shop -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Mambo Shop - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key.</title>
		<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, магазин, магазин мамбо, mambo shop, minecraft за 2 гривні" />
		<meta name="description" content="Mambo Shop - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Random Key." />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/shop.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="ism/css/my-slider.css"/>
		<script src="ism/js/ism-2.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$(".tabs").lightTabs();
		});
		</script>
		<script type="text/javascript" src="http://shop.mambo.zzz.com.ua/scripts/js1.js"></script>
		<?php include '../head.php';?>
	</head>
	
	<body>
		<?php include 'top.php';
		include 'functions/main.php';?>
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
				<div class="tabs">
					<ul>
						<li>По рейтингу</li>
						<li>По ціні ▲</li>
						<li>По ціні ▼</li>
					</ul>
					<div>
						<div>
							<?php
							main_1();
							echo "</div><div>";
							main_2();
							echo "</div><div>";
							main_3();
							?> 
						</div>
					</div>
				</div>
			</div>
		</div> 
		<?php include 'down.php';?>
	</body>
</html>