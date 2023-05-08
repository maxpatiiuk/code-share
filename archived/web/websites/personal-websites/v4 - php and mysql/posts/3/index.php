<?php require_once('../../config.php'); ?>
<!-- 3.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MAMBO SHOP - магазин ігрових акаунтів та ключів - В гостях у MAMBO - офіційний вебсайт</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, контакти, shop, mambo, mambo shop, minecraft за 2 гривні" />
<meta name="description" content="MAMBO SHOP - магазин ігрових акаунтів та ключів - В гостях у MAMBO - офіційний вебсайт"/>
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
		function post($p_name, $p_date, $p_src, $p_text){
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
				<div class=\"p_img\">
				<img src=\"$p_src\" width=\"700px\" height=\"\"393>
				</div>
				<div class=\"p_text\">
					<p>
					$p_text	
					</p>
				</div>";
		}
		//post($p_name, $p_date, $p_src, $p_text)
		post("MAMBO SHOP - магазин ігрових акаунтів та ключів", "21 грудня, 2016 в 20:00", "http://s8.hostingkartinok.com/uploads/images/2016/12/46ae1e483e2155754f33896ef74f4b8a.jpg", "MAMBO SHOP - наший магазин цифрових акаунтів та ключів. Саме в <a href=\"http://shop.mambo.zzz.com.ua/\" target=\"_blank\">shop.mambo.zzz.com.ua</a> кожен має можливість придбати найкрутіші ігри за найнищі ціни. Час від часу тут проходять різноманітні акції та розіграши. Поспішіть, саме зараз тут проходять величезні знижки - Batlefield 1 за 26 грн, Sims 4 за 7 грн, Minecraft за 2 грн, Random Steam Key від 4 грн та ще багато всього іншого<br><br><a class=\"l_button\" href=\"\">Перейти в магазин</a>");
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