<?php require_once('../../config.php'); ?>
<!-- 3.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Як знімати в 8K з телефону? - В гостях у MAMBO - офіційний вебсайт</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, 8K, 8К, 8K камера, Україна, 8k, 8k video, first 8k, first 8k vidoo, 8к, перше 8к відео, знімаю 8к, якз няти 8к, що таке 8к?, 8л, як зняти 8к з телефону, 4к, 4k, 4к камера, як зняти в 4к, знімаю в 4к, найкрутіша камера, дуже дорога камера, лайфхак, топ лайфак, топ лайфаків, first 4k video" />
<meta name="description" content="Як знімати в 8K з телефону? - В гостях у MAMBO - офіційний вебсайт"/>
<link href="<?=LINK?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<?=LINK?>css/description.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://www.iconj.com/ico/s/b/sb4gicay3n.ico" type="image/x-icon" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
</head>

<body>
<div w3-include-html="<?=LINK?>top.php"></div>
<div class="hr"></div>
<div class="content">
	<div class="c_left">
	<?php
		function post($p_name, $p_date, $p_src, $p_text, $p_type="0"){
			echo "
				<div class=\"p_name\">
				<p>
				$p_name	
				</p>
				</div>
				<div class=\"p_others\">
					<div class=\"p_data\">
						<p>
							<div class=\"p_clock\">
								<img src=\"http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png\">
							</div>
							<div class=\"p_date\">
								$p_date
							</div>
						</p><br>
					</div>
				</div>
				<div class=\"p_img\">";
				if($p_type="0")
				echo "<img src=\"$p_src\" width=\"700px\" height=\"\"393>";
				else
				echo "<iframe width=\"700\" height=\"393\" src=\"https://www.youtube.com/embed/$p_src\" frameborder=\"0\" allowfullscreen></iframe>";
				echo "
				</div>
				<div class=\"p_text\">
					<p>
					$p_text	
					</p>
				</div>";
		}
		//post($p_name, $p_date, $p_src, $p_text)
		post("Огляд сайту", "27 грудня, 2016 в 15:00", "9wXwVNZTE_I", "Хей Хей Хо! З вами MAMBO! І саме зараз я представляю вам огляд сайту на якому ви саме зараз знаходетесь. Для початку нагадаю, що декілька днів тому він отримав конкретний редизайн. І тепер він став витонченішим, стильнішим та сучаснішим.<br><br>З метою провести коротку екскурсію по сайту та розповісти вам про всі його нововедення, було створене відео, яке ви модете бачити вище.<br><br>Окрім цього, представляю до вашої уваги невеличкий конкурс на 1 призове місце. Умова досить проста: написати приблизний час за який я зробив свій сайт. Той, чия відповідь була найточнішою, отримає одинз призів які ви бачите нижчее:<br>Ліцензія Minecraft<br>Random Steam Key<br>Шляпа для каналу<br>Аватарка (текстова)<br>Піар в кінці відео<br><br>Результати конкурсу відбудуться в одному з наступних відео.<br><br>Дякую всім за участь!", "1");
	?>	
	</div>
	<div class="c_right">	
		<div class="c_m_name">
			<p>
				Про наший сайт
			</p>
		</div>
		<p>
			Наший сайт створений для підписників каналу В гостях у MAMBO. Ми пропонуємо вам новини, відео, посилання та іншу інформацію стосовно цього каналу.	</p>
		<br>
		<!-- VK Widget -->
		<div id="vk_groups"></div>
		<script type="text/javascript">
			VK.Widgets.Group("vk_groups", {mode: 3, width: "240", color1: 'FFF', color2: '333', color3: '1EACE1'}, 67143145);
		</script>
	</div>
</div>
 <div w3-include-html="<?=LINK?>down.html"></div>
<script>
w3IncludeHTML();
</script> 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78140730-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>