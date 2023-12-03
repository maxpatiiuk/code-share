<!-- coments -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			$dir=basename(dirname(__FILE__));
			$t='Ми будемо вам дуже вдячні якщо ви виділите свій час і напишете відгук про наший магазин. Якщо ви знайшли помилку на сайті, ціна не співпадає з ціною при оплаті, маєте ідею для сайту, ділову пропозицію або бажаєте щоб ваші товари появилися в нашому магазині, тоді пишіть нам на email: max@patii.uk.';
			head('Відгуки','Пропонуємо вам переглянути відгуки до нашого магазину, щоб отримати впевненість в надійності та безпеці нашого сайту. '.$t,'Відгуки до магазину mambo shop, mambo shop відгуки, mambo shop отзывы, coments',0,0,0,1);
			echo '<meta property="og:url" content="'._LOCATION_.'coments/">
			<meta property="fb:admins" content="maxpatiiuk">';
		?>
	</head>
	<body>
		<?php menu();?>
		<?php c()?>
			<h1 class="title">Відгуки до магазину MAMBO SHOP</h1>
			<p class="title"><?=$t?></p>
			<div class="fb-comments" data-href="<?=_LOCATION_?>coments" data-colorscheme="dark" data-width="auto" data-numposts="20"></div>
		<?php c(1)?>
	</body>
</html>