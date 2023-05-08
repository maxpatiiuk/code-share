<?php
	$mysql_login='MYSQL_LOGIN';
	$mysql_host='MYSQL_HOST';
	$mysql_pass='MYSQL_PASSWORD';
	$mysql_db='MYSQL_DB';
	mysql_connect($mysql_host,$mysql_login,$mysql_pass);
	mysql_select_db($mysql_db);
	if(preg_match('/shop\.mambo\.zzz\.com\.ua/',__FILE__))
		define('_LOCATION_',"http://shop.mambo.zzz.com.ua/");
	else if(preg_match('/test\.mambo\.zzz\.com\.ua\/shop/',__FILE__))
		define('_LOCATION_',"http://test.mambo.zzz.com.ua/shop/");
	else {
		echo 'Error. Unknown domain!';
		exit(0);
	}
	function que($query=0,$ress=1){//$row=mysql_fetch_array($res);
		global $res;//$u=mysql_num_rows($res);
		if($ress==2)
			$ras = mysql_query($query) or die(mysql_error());
		else if($ress!=1)
			$$res = mysql_query($query) or die(mysql_error());
		else
			$res = mysql_query($query) or die(mysql_error());
	}//while ($row=mysql_fetch_array($res)){}
	function head($title, $desc, $keywords, $style=0, $tabs=0, $description=0, $other=0){
		if($desc)
			$desc.=' - ';
		$desc.='Mambo Shop - магазин ігрових акаунтів та ключів. Найнищі ціни спеціально для вас. Minecraft, CS GO, GTA 5, Battlefield 1';
		if(!$title)
			$title=$desc;
		if($keywords)
			$keywords.=', ';
		$keywords.='магазин мамбо, mambo shop, minecraft за 2 гривні, mambo, В гостях у MAMBO';
		echo '<meta charset="utf-8">
		<title>'.$title.'</title>
		<link rel="shortcut icon" href="'._LOCATION_.'images/favicon.png" type="image/x-icon">
		<meta name="keywords" content="'.$keywords.'">
		<meta name="description" content="'.$desc.'">
		<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">
		<link href="'._LOCATION_.'css/main.css" rel="stylesheet" type="text/css">';
		if($style)
			echo '<link href="'._LOCATION_.'css/style.css" rel="stylesheet" type="text/css">';
		if($tabs)
			echo '<link href="'._LOCATION_.'css/tabs.css" rel="stylesheet" type="text/css">';
		if($other)
			echo '<link href="'._LOCATION_.'css/other.css" rel="stylesheet" type="text/css">';
		if($description)
			echo '<link href="'._LOCATION_.'css/decription.css" rel="stylesheet" type="text/css">';
		if($_COOKIE['back']==2){
			echo '<link href="'._LOCATION_.'css/over.css" rel="stylesheet" type="text/css">';
			$fir='#811';
			$sec='#222';
		}
		else {
			$fir='#eee';
			$sec='#ccc';
		}
	}
	function menu(){
		global $dir,$res, $is_loggined;
		que('SELECT * FROM menu ORDER BY id ASC');
		echo '<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=736320119826552";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, "script", "facebook-jssdk"));</script>
		<div class="dropdown m_but">
				<button onclick="men_u()" class="dropbtn mbut r">1</button>
			</div>
			<div class="ow">
				<div class="menu l" id="menu">
					<div><a class="an" href="'._LOCATION_.'">
						<p>MAMBO</p>
						<p>SHOP</p>
					</a>';
		while ($row=mysql_fetch_array($res)){
			if(substr($row['link'],0,3)=='htt' || substr($row['link'],0,3)=='www')		
				echo '	<a class="li" href="'.$row['link'].'" target="_blank">'.strtoupper($row['name']).'</a>';
			else {
				echo '	<a class="li" href="'._LOCATION_.$row['link'].'">'.strtoupper($row['name']).'</a>';
			}
		}
		echo '</div>';
		$hesh=preg_replace('/[^A-Za-z0-9]/', '', $_COOKIE['hesh']);
		que('SELECT img,login,id FROM users WHERE hesh="'.$hesh.'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u==1){
			setcookie('hesh',$hesh,time()+60*60*24*2,'/');
			$is_loggined=1;
			global $src,$srr;
			switch($row['img']){
				case 1:$src.="jpg";break;
				case 2:$src.="gif";break;
				case 3:$src.="png";break;
				case 4:$src.="tiff";break;
				default:$src="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";break;
			}
			if(strlen($src)>10) $srr=$src;
			else $srr=_LOCATION_.'images/p/'.str_rot13($row['login']).'.'.$src;
			echo '<div class="user">
				<a href="'._LOCATION_.'profile/">
					<img class="l" src="'.$srr.'">
					<br>'.str_rot13($row['login']).'
				</a>
				<a href="'._LOCATION_.'profile/out.php?f='.$dir.'">Вихід</a>';
		}
		else {
			setcookie('hesh','',time()-60*60*24*2,'/');
			global $is_loggined;
			$is_loggined=0;
			echo '<div class="log">
					<a href="'._LOCATION_.'register/">Реєстрація</a>
					<a href="'._LOCATION_.'login/?l='.$dir.'">Вхід</a>';
		}
		if($_COOKIE['display_footer']!=1)
			echo '<div class="down r">
					MAMBO&copy; 2015-'.date("Y").'
				</div>';
		echo '</div>
		</div>';
	}
	function c($par=NULL){
		if($par==1) echo '<div>';
		else echo '<div id="content" class="content r '.$par.'">';
	}
	if($_COOKIE['back']=='2'){
		echo '<link href="'._LOCATION_.'css/over.css" rel="stylesheet" type="text/css">';
		$fir='#ccc';
		$sec='#eee';
	}
	else {
		$fir="#222";
		$sec="#333";
	}
?>
<script>
	function men_u() {
		document.getElementById("menu").classList.toggle("df");
		document.getElementById("content").classList.toggle("show");
	}
	window.onclick = function(event) {
	  if (!event.target.matches('.dropbtn')) {
		var dropdowns = document.getElementsByClassName("menu");
		document.getElementsByClassName("ow").style.opacity = "0.8";
		var i;
		for (i = 0; i < dropdowns.length; i++) {
		  var openDropdown = dropdowns[i];
		  if (openDropdown.classList.contains('show')) {
			document.getElementsByClassName("ow").style.opacity = "0";
			openDropdown.classList.remove('show');
		  }
		}
	  }
	}
	function openC(cName, cBut) {
		var i;
		var x = document.getElementsByClassName("tab_c");
		var y = document.getElementsByClassName("b");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		for (i = 0; i < y.length; i++) {
			y[i].classList.remove("cur");
		}
		document.getElementById(cName).style.display = "block";
		document.getElementById(cBut).classList.toggle("cur");
	}
</script>