<?php
	define('LINK', 'http://localhost/');
	function head ($style, $cont, $title = 'Головна', $keyword){
		global $keywords;
		$keywords=$keyword;
		if($keywords!=NULL)
			$keywords.=', ';
		$keywords.='УАС, Українська Асоціація Студентів, UAS';
		$title.='- УАС - Українська Асоціація Студентів';
		echo '<title>'.$title.'</title>
			<meta http-equiv="Cache-Control" content="private">
			<meta name="keywords" content="'.$keywords.'">
			<meta name="description" content="'.$title.'">';
		if($style==1)
			echo '<link href="'.LINK.'css/style.css" rel="stylesheet" type="text/css">';
		if($cont==1)
			echo '<link href="'.LINK.'css/content.css" rel="stylesheet" type="text/css">';
		echo '<link href="'.LINK.'css/main.css" rel="stylesheet" type="text/css">
			<script src="http://www.w3schools.com/lib/w3data.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
		global $about;
		$about='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eget massa rutrum egestas vel id odio. Nam vulputate, augue ut pulvinar tincidunt, lorem nunc consequat ante, eget malesuada quam ipsum id ex. Duis cursus orci ac eleifend auctor. In lobortis est at tellus cursus dictum. Donec purus ligula, elementum sed ex non, suscipit fermentum massa. Quisque eu lobortis risus. Cras non dictum tellus. Aliquam erat volutpat. Nulla facilisi. Aliquam suscipit efficitur egestas. Vivamus ligula sapien, congue quis volutpat vel, vulputate vel arcu.';
	}
	function top(){
		?>
			<script>
				function Hide(a)
				{
				   var b = a.parentNode.getElementsByTagName('span')[0].style;
				   if(a.value == '.')
				   {
					  a.value = ',';
					  b.display = '';
				   }
				   else
				   {
					  a.value = '.';
					  b.display = 'none';
				   }
				}
			</script>
			<div class="menu">
				<a class="m_logo l" href="<?=LINK?>"><img src="https://s8.hostingkartinok.com/uploads/images/2017/04/91e26842cc0269e672a3e8ecceca1d32.png"></a>
				<nav>
					<a href="<?=LINK?>about">Про нас</a>
					<a href="<?=LINK?>history">Історія</a>
					<a href="<?=LINK?>contacts">Контакти</a>
					<a href="<?=LINK?>team">Наша команда</a>
					<a href="<?=LINK?>jobs">Ваканції</a>
					<a href="<?=LINK?>documents">Документи</a>
					<a href="<?=LINK?>base">База УАС</a>
					<a href="<?=LINK?>qa">QA Pool</a>
				</nav>
				<div>
					<input type="button" class="mbut r" value="." onclick="Hide(this)">
					<span style="display:none"><ul id="nav">
						<li><a href="<?=LINK?>about">Про нас</a></li>
						<li><a href="<?=LINK?>history">Історія</a></li>
						<li><a href="<?=LINK?>contacts">Контакти</a></li>
						<li><a href="<?=LINK?>team">Наша команда</a></li>
						<li><a href="<?=LINK?>jobs">Ваканції</a></li>
						<li><a href="<?=LINK?>documents">Документи</a></li>
						<li><a href="<?=LINK?>base">База УАС</a></li>
						<li><a href="<?=LINK?>qa">QA Pool</a></li>
					</ul></span>
				</div>
			</div>
		<?php
	}
	function down(){
		global $about;
		global $keywords;
		?>
		<div class="down">
				<div>
					<h4>Про нас</h4>
					<p><?=$about?></p>
				</div>
				<div>
					<h4>Контакти</h4>
					<a class="aw" href="mailto:info@uas.com.ua">info@uas.com.ua</a>
					<p>+38 (050) 00 000 00</p>
					<p>+38 (097) 00 000 00</p>
					<p>м.Луцьк, вул.Лесі Українки, 1a, 43009</p>
					<h4>Теги</h4>
					<p><?=$keywords?></p>
				</div>
				<div>
					<h4>Ми в соцмережах</h4>
					<a href="https://vk.com/mambooficial"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/f04e5a3deba44158d2209d38c07cfb2c.png"></a>
					<a href="https://facebook.patii.uk"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/b6d473f462cd9657b6288a4f2037db40.png"></a>
					<a href="https://twitter.patii.uk"><img src="http://s8.hostingkartinok.com/uploads/images/2016/11/3f380a9e60a4bf1a8cf4e71ced861bc2.png"></a>
				</div>
			</div>
			<div class="l_down">&copy; <?=date("Y")?> УAС</div>
		<?php
	}
?>