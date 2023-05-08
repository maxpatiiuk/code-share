<?php require_once('../config.php'); ?>
<!-- contacts.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Контакти - В гостях у MAMBO - офіційний вебсайт</title>
<meta name="keywords" content="mambo, В гостях у MAMBO, youtube, максим патіюк, контакти" />
<meta name="description" content="Контакти - В гостях у MAMBO - офіційний вебсайт"/>
<link href="<?=LINK?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<?=LINK?>css/description.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://www.iconj.com/ico/s/b/sb4gicay3n.ico" type="image/x-icon" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://www.w3schools.com/lib/w3data.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
</head>

<body>
<?php
function m_list($m_text, $m_list_a , $m_current="0", $m_div_name="m_list"){
	if ($m_current != '0')
		$m_div_name = "m_list_c";	
	echo "<a href=\"$m_list_a\"><div class=\"$m_div_name\">$m_text</div></a>";
};
function i__post($i_link, $i_i_link, $i_name, $i_date, $i_description, $i_isimp='0') {
	if($i_isimp != '0')
		$i_p_name = "i_p_name_i";
	else
		$i_p_name = "i_p_name";
	echo "
<a href=\"$i_link\">
	<div class=\"i_post\">
		<div class=\"i_p_img\">
			<img srс=\"$i_i_link\" width=\"266\" height=\"150\" align=\"left\">
		</div>
		<div class=\"i_p_text\">
			<div class=\"$i_p_name\">
			<p>
				$i_name
			</p>
			</div>
			<div class=\"i_p_other\">
				<p>
					<div class=\"i_p_clock\">
						<img src=\"http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png\">
					</div>
					<div class=\"i_p_date\">
						$i_date
					</div>
				</p><br>
			</div>
			<div class=\"i_p_description\">
			<p>
				$i_description...
			</p>
			</div>
		</div>
	</div>
</a>";}
?>
<div w3-include-html="<?=LINK?>top.php"></div>
<div class="hr"></div>
<div class="content">
	<div class="c_left">
		<?php
		function links($link, $src){
			echo "<a href=\"$link\"><img src=\"$src\"\ align=\"left\"></a>";}
		links("https://www.youtube.com/channel/UCSJcpWVrv6wVqH1YTmTCemw","http://s8.hostingkartinok.com/uploads/images/2016/07/81f7aa64b960da438c070c7a7276e940.jpg");
		links("https://www.oplata.info/asp2/pay_wm.asp?id_d=1709703&ai=600788","http://s8.hostingkartinok.com/uploads/images/2016/07/64cabff474b137221abd3a7f1d247d56.jpg");
		links("https://vk.com/mambooficial","http://s8.hostingkartinok.com/uploads/images/2016/07/3dc76f826263f02f236c4ff57bf38d11.jpg");
		links("http://vk.com/club93802493","http://s8.hostingkartinok.com/uploads/images/2016/07/aa69861859795ecb47fef179f4279fb6.jpg");
		links("https://vk.com/mambo_youtube","http://s8.hostingkartinok.com/uploads/images/2016/07/71131f9dfdaa81281524f17481fac48e.jpg");
		links("https://www.instagram.com/mambo_youtube/","http://s8.hostingkartinok.com/uploads/images/2016/07/e45d58557bf655dfecc90cf3a869552b.jpg");
		links("https://www.facebook.com/mamboyoutube","http://s8.hostingkartinok.com/uploads/images/2016/07/849dbbe244d315edc8d87d79c40de19a.jpg");
		links("https://twitter.com/maxxxxxdlp1","http://s8.hostingkartinok.com/uploads/images/2016/07/dbcdb9043f2e3d1583b25aee5abc96ea.jpg");	  
		links("http://maxxxxxdlp.tumblr.com","http://s8.hostingkartinok.com/uploads/images/2016/07/2dc0adbbdab5ef91b832495ac41882b9.jpg");	  
		links(LINK."mamb.io2/","http://s8.hostingkartinok.com/uploads/images/2016/08/5d4e3d10d67399cbe5aad3ea55cc839c.jpg");
		links("https://www.blogger.com/blogger.g?blogID=8618291164907612157","http://s8.hostingkartinok.com/uploads/images/2016/07/cedc4e7e5bd821f49520c04dc574078a.jpg");	  
		links("https://plus.google.com/111115728637484704415","http://s8.hostingkartinok.com/uploads/images/2016/07/e154a1f421461282c21f7489c11860a5.jpg");	  
		links("https://www.youtube.com/channel/UCCrYADQvPZG8Vdw_Rl7bMNA","http://s8.hostingkartinok.com/uploads/images/2016/08/42cd9b106cd3325ff45f12e240f79405.jpg");	  
		links("https://www.youtube.com/watch?v=pIaxRNboT_0","http://s8.hostingkartinok.com/uploads/images/2016/07/8a8abb89a562bd570b497462c63c03c1.jpg");	  
		links(LINK."shop/","http://s8.hostingkartinok.com/uploads/images/2016/08/669f356bdcf3b60f8bcfb180fb385106.jpg");
		links("http://vk.com/id0?149282990","http://s8.hostingkartinok.com/uploads/images/2016/08/d79f658bebb9f43fdeaac43268f72152.jpg");	  
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