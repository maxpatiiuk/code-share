<?php require_once('../../config.php'); ?>
<!-- 1.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Дизайн сайту оновлено! - В гостях у MAMBO - офіційний вебсайт</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, контакти" />
<meta name="description" content="Дизайн сайту оновлено! - В гостях у MAMBO - офіційний вебсайт"/>
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
		post("Дизайн сайту оновлено!", "21 грудня, 2016 в 14:30", "http://s8.hostingkartinok.com/uploads/images/2016/12/787736e67474d11e0126c9b6cf38a7a9.png", "Вітаємо всіх з редизайном нашого сайту. Тепер він став витонченішим, стильнішим та сучаснішим. Але, роботи на ним продовжуються. Саме тому ви маєте можливість спостерігати за тим, як сайт міняється та стає кращим.<br><br> Найблищим часом ми будемо активно збільшувати кількість постів. Окрім цього, ми плануємо добавити сумісність сайту з мобільними приладами та переробити меню.<br><br><b>Дякуюємо за те, що залишаєтеся з нами!</b>");
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