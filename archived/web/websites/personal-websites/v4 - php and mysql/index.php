<?php require_once('config.php'); ?>
<!-- index.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>В гостях у MAMBO - офіційний вебсайт</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк" />
<meta name="description" content="В гостях у MAMBO - офіційний вебсайт"/>
<link href="<?=LINK?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<?=LINK?>css/index.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://www.iconj.com/ico/s/b/sb4gicay3n.ico" type="image/x-icon" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
</head>

<body>
<?php
function i__post ($i_link,$i_i_link,$i_name,$i_date,$i_description,$i_isimp="0",$i_post="i_name"){
if($i_isimp !=0)
	$i_post="i_name_i";
echo "	<div class=\"i_post\">
			<a href=\"$i_link\">
				<img src=\"$i_i_link\" align=\"left\" height=\"150\" width=\"266\">
			</a>
			<div class=\"i_p_text\">
				<p>
					<a href=\"$i_link\">
						<div class=\"$i_post\">
								$i_name
						</div>
					</a>	
					<div class=\"i_p_clock\">
						<img src=\"http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png\">
					</div>
					<div class=\"i_p_date\">
						$i_date
					</div>
				</p>
				<br>
				<div class=\"i_p_description\">
					<p>
						$i_description
					</p>
				</div>
			</div>	
		</div>";
}
?>
<div w3-include-html="./top.php"></div>
<div class="hr"></div>
<div class="content">
	<div class="c_left">
	<?php
	/* i__post($i_link, $i_i_link, $i_name, $i_date, $i_description, ,$i_isimp='0') */
	i__post(LINK."posts/5/", "http://s8.hostingkartinok.com/uploads/images/2016/12/0e9a5c7b32bcf110ec07ebc1cd592cc9.png", "Огляд сайту + Конкурс", "27 грудня, 2016 в 15:00", "Хей Хей Хо! З вами MAMBO! І саме зараз я представляю вам огляд сайту на якому ви саме зараз знаходетесь. Для початку нагадаю, що декілька днів тому він отримав конкретний редизайн. І тепер він став витонченішим, стильнішим та сучаснішим...");
	i__post(LINK."posts/4/", "http://s8.hostingkartinok.com/uploads/images/2016/12/f7dd36ede6e2699e862d2d5de27c561e.png", "Як знімати в 8K з телефону?", "24 грудня, 2016 в 13:30", "Хей Хей Хо! З вами MAMBO! І сьогодні я покажу вам лайфхак не зовсі по тематиці мого каналу. А саме \"Як Знімати в 8K з телефону?\". Надіюся що це відео ва сподобається. Якщо так, то поставте лайк і зніму ще кілька класних лайфхаків...");
	i__post(LINK."posts/3/", "http://s8.hostingkartinok.com/uploads/images/2016/12/46ae1e483e2155754f33896ef74f4b8a.jpg", "MAMBO SHOP - магазин ігрових акаунтів та ключів", "21 грудня, 2016 в 20:00", "MAMBO SHOP - наший магазин цифрових акаунтів та ключів. Саме в shop.mambo.zzz.com.ua кожен має можливість придбати найкрутіші ігри за найнищі ціни. Час від часу тут проходять різноманітні акції та розіграши...");
	i__post(LINK."posts/2/", "http://s8.hostingkartinok.com/uploads/images/2016/12/cb306f8b9d2c4ae3c7f676d3656f93f1.jpg", "В готсях у MAMBO - наший YouTube канал", "21 грудня, 2016 в 20:00", "Ви знаходетесь на цій сторінці завдяки каналу - В гостях у MAMBO. Адже, наший сайт був створений спеціално для підписників цього каналу. Саме в mambo.zzz.com.ua ви зможете побачити всі новини, відео, контакти та інформацію стосовно нашого каналу...");
	i__post(LINK."posts/1/", "http://s8.hostingkartinok.com/uploads/images/2016/12/787736e67474d11e0126c9b6cf38a7a9.png", "Дизайн сайту оновлено!", "21 грудня, 2016 в 14:30", "Вітаємо всіх з редизайном нашого сайту. Тепер він став витонченішим, стильнішим та сучаснішим. Але, роботи на ним продовжуються. Саме тому ви маєте можливість спостерігати за тим, як сайт міняється та стає кращим...", "1");
	?>
	</div>
	<div w3-include-html="<?=LINK?>menu.html"></div>
</div>
<div w3-include-html="<?=LINK?>down.html"></div>
<script>
w3IncludeHTML();
</script> 

</body>
</html>