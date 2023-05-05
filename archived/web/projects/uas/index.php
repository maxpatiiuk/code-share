<!-- index.php -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once dirname(__FILE__) . '/functions/main.php';
			head(1, 0, 'Головна', 'Головна, Домашня, Home');
			function tblt2($src, $xtext, $text){
				echo '<div><img class="l" src="'.$src.'"><h2>'.$xtext.'</h2><p>'.$text.'</p></div>';
			}
		?>
		<link rel="stylesheet" href="ism/css.css"/>
		<script src="ism/js.js"></script>
	</head>
	<body>
		<?php top();?>
		<div class="content">
			<div class="ism-slider" data-play_type="loop" data-interval="3000" id="my-slider">
			  <ol>
				<li>
				  <img src="ism/image/slides/flower-729514_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 1</div>
				</li>
				<li>
				  <img src="ism/image/slides/beautiful-701678_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 2</div>
				</li>
				<li>
				  <img src="ism/image/slides/summer-192179_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 3</div>
				</li>
				<li>
				  <img src="ism/image/slides/city-690332_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 4</div>
				</li>
				<li>
				  <img src="ism/image/slides/bora-bora-685303_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 5</div>
				</li>
				<li>
				  <img src="ism/image/slides/pier-569314_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 6</div>
				</li>
				<li>
				  <img src="ism/image/slides/chainlink-690503_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 7</div>
				</li>
				<li>
				  <img src="ism/image/slides/tree-701688_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 8</div>
				</li>
				<li>
				  <img src="ism/image/slides/sky-690293_1280.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 9</div>
				</li>
				<li>
				  <img src="ism/image/slides/ye_25419.jpg">
				  <div class="ism-caption ism-caption-0">Слайд 10</div>
				</li>
			  </ol>
			</div>
			<a name="y_t1"></a>
			<div class="tblock t1">
				<div class="tb l" align="right">
					<h2 class="c27c">Про нас</h2>
					<h1>Українська Асоціація Студентів</h1>
				</div>
				<div class="tb r">
					<?=$about?>
				</div>
			</div>
			<a name="y_t2"></a>
			<div class="tblock t2">
				<h2>Наша історія</h2>	
				<?php
					tblt2("http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/sign-check-icon.png","Заголовок 1","Опис 1");
					tblt2("http://icons.iconarchive.com/icons/graphicloads/100-flat/256/home-icon.png","Заголовок 2","Опис 2");
					tblt2("http://i.imgur.com/1sGTsxv.png","Заголовок 3","Опис 3");
					tblt2("http://www.freeiconspng.com/uploads/flat-mac-icon-15.png","Заголовок 4","Опис 4");
				?>
			</div>
			<a name="y_t3"></a>
			<div class="tblock t3">
				<h2 class="c27c">Контакти</h2>
				<h3>Телефон:</h3>
				<p>+38 (050) 00 000 00</p>
				<p>+38 (097) 00 000 00</p>
				<h3>E-mail:</h3>
				<p>info@uas.com.ua</p>
				<a id="c27c" href="mailto:info@uas.com.ua">Написати повідомлення</a>
				<h3>Адреса:</h3>
				<p>м.Луцьк, вул.Лесі Українки, 1a, 43009</p>
				<h3>Ми в соцмережах:</h3>
				<a href="https://vk.com/mambooficial"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/f04e5a3deba44158d2209d38c07cfb2c.png"></a>
				<a href="https://www.facebook.com/mamboyoutube"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/b6d473f462cd9657b6288a4f2037db40.png"></a>
				<a href="https://twitter.com/maxxxxxdlp1"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/3f380a9e60a4bf1a8cf4e71ced861bc2.png"></a>
			</div>
			<a name="y_t4"></a>
			<div class="tblock t4">
				<h2>Наша команда</h2>	
				<?php
					tblt2("http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/sign-check-icon.png","Заголовок 1","Опис 1");
					tblt2("http://icons.iconarchive.com/icons/graphicloads/100-flat/256/home-icon.png","Заголовок 2","Опис 2");
					tblt2("http://i.imgur.com/1sGTsxv.png","Заголовок 3","Опис 3");
					tblt2("http://www.freeiconspng.com/uploads/flat-mac-icon-15.png","Заголовок 4","Опис 4");
				?>
			</div>
			<a name="y_t5"></a>
			<div class="tblock t4 cw">
				<h2>Ваканції</h2>	
				<?php
					$s='https://s8.hostingkartinok.com/uploads/images/2017/04/d47c9209b9bff668663c9979ade94a4b.png';
					tblt2($s,"Заголовок 1","Опис 1");
					tblt2($s,"Заголовок 2","Опис 2");
					tblt2($s,"Заголовок 3","Опис 3");
					tblt2($s,"Заголовок 4","Опис 4");
				?>
			</div>
			<a name="y_t6"></a>
			<div class="tblock t4 t6">
				<h2>Документи</h2>
				<?php
					$s='https://s8.hostingkartinok.com/uploads/images/2017/04/fef5a171c72cc858b820dc7c435a8523.png';
					tblt2($s,"Заголовок 1","Опис 1");
					tblt2($s,"Заголовок 2","Опис 2");
					tblt2($s,"Заголовок 3","Опис 3");
					tblt2($s,"Заголовок 4","Опис 4");
				?>
			</div>
			<a name="y_t7"></a>
			<div class="tblock t4 t7 cw">
				<h2>База УАС</h2>
			</div>
			<a name="y_t8"></a>
			<div class="tblock t4 t8">
				<h2>QA Pool</h2>
			</div>
			<?php down(); ?>
		</div>
	</body>
<html>