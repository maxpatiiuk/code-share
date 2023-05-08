<!-- Shop -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			include 'functions/main.php';
			include('functions/list.php');
			$dir=basename(dirname(__FILE__));
			head('','','Головна, магазин в гостях у мамбо, магазин в гостях у mambo',1,1);
		?>
		<link rel="stylesheet" href="ism/slider.css"/>
		<script src="ism/js.min.js"></script>
	</head>
	<body>
		<?php menu();?>
		<?php c()?>
			<div class="ism-slider" data-transition_type="fade" data-play_type="loop" data-interval="3000" id="my-slider"><ol><li><img src="ism/image/slides/_u/1493907327386_374974.jpg"></li><li><img src="ism/image/slides/_u/1493907327362_464412.jpg"></li><li><img src="ism/image/slides/_u/1493907327306_216056.jpg"></li><li><img src="ism/image/slides/_u/1493907327265_710812.jpg"></li><li><img src="ism/image/slides/_u/1493907327047_471670.jpg"></li><li><img src="ism/image/slides/_u/911119.jpg"></li></ol></div>
			<div class="tabs">
				<button id="b1" class="b cur" onclick="openC('a1', 'b1')">По рейтингу</button>
				<button id="b2" class="b" onclick="openC('a2', 'b2')">По популярності</button>
				<button id="b3" class="b" onclick="openC('a3', 'b3')">По ціні &#9650;</button>
				<button id="b4" class="b" onclick="openC('a4', 'b4')">По ціні &#9660;</button>
				<button id="b5" class="b" onclick="openC('a5', 'b5')">Новинки</button>
			</div>
			<div id="a1" class="tab_c"><?php products(1)?></div>
			<div id="a2" class="tab_c" style="display:none"><?php products(2)?></div>
			<div id="a3" class="tab_c" style="display:none"><?php products(3)?></div>
			<div id="a4" class="tab_c" style="display:none"><?php products(4)?></div>
			<div id="a5" class="tab_c" style="display:none"><?php products(5)?></div>
		<?php c(1)?>
	</body>
</html>