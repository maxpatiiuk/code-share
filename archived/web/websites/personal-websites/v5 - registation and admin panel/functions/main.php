<?php
	$mysql_login='MYSQL_LOGIN';
	$mysql_host='MYSQL_HOST';
	$mysql_pass='MYSQL_PASSWORD';
	$mysql_db='MYSQL_DB';
	mysql_connect($mysql_host,$mysql_login,$mysql_pass);
	mysql_select_db($mysql_db);
	define('_LOCATION_',"http://mambo.in.ua/");
	function que($query=0,$ress=1){//$row=mysql_fetch_array($res);
		global $res;//$u=mysql_num_rows($res);
		if($ress==2)
			$ras = mysql_query($query) or die(mysql_error());
		else if($ress!=1)
			$$res = mysql_query($query) or die(mysql_error());
		else
			$res = mysql_query($query) or die(mysql_error());
	}//while ($row=mysql_fetch_array($res)){}
	function c($par=NULL){
		static $c=0;
		if($c==1) echo '</div><div class="down aw">MAMBO&copy; 2015-'.date("Y").'</div>';
		else if($par==NULL)
			echo '<div id="content">';
		else
			echo '<div id="content" class="'.$par.'">';
		$c++;
	}
	function head($title, $desc, $keywords, $style=0, $tabs=0, $posts=0, $other=0){
		if($desc)
			$desc.=' - ';
		$desc.="В гостях у MAMBO - офіційний вебсайт однойменного youtube каналу та каналу 'Mambo Experimental'. Цей сайт пропонує вам свіжі новини, інформацію та контакти";
		if(!$title)
			$title=$desc;
		if($keywords)
			$keywords.=', ';
		$keywords.='мамбо, сайт мамбо, mambo, В гостях у MAMBO';
		echo '<meta charset="utf-8">
		<title>'.$title.'</title>
		<link rel="shortcut icon" href="'._LOCATION_.'images/favicon.png" type="image/x-icon">
		<meta name="keywords" content="'.$keywords.'">
		<meta name="description" content="'.$desc.'">
		<link href="'._LOCATION_.'css/main.css" rel="stylesheet" type="text/css">';
		if($style)
			echo '<link href="'._LOCATION_.'css/style.css" rel="stylesheet" type="text/css">';
		if($tabs){
			echo '<link href="'._LOCATION_.'css/tabs.css" rel="stylesheet" type="text/css">';
			?>
			<script>
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
			<?php
		}
		if($other)
			echo '<link href="'._LOCATION_.'css/other.css" rel="stylesheet" type="text/css">';
		if($posts)
			echo '<link href="'._LOCATION_.'css/posts.css" rel="stylesheet" type="text/css">';
	}
	function menu($par=NULL){
		global $res, $is_loggined;
		que('SELECT * FROM menu_2 ORDER BY id ASC');
		echo '<div class="menu" id="menu">
			<a class="aw l" href="'._LOCATION_.'">MAMBO</a>';
		while ($row=mysql_fetch_array($res)){
			if(substr($row['link'],0,3)=='htt' || substr($row['link'],0,3)=='www')
				echo '	<a class="aw l" href="'.$row['link'].'" target="_blank">'.strtoupper($row['name']).'</a>';
			else {
				echo '	<a class="aw l" href="'._LOCATION_.$row['link'].'">'.strtoupper($row['name']).'</a>';
			}
		}
		$hesh=preg_replace('/[^A-Za-z0-9]/', '', $_COOKIE['hesh']);
		que('SELECT img,login,id FROM users WHERE hesh="'.$hesh.'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u==1){
			setcookie('hesh',$hesh,time()+60*60*24*2,'/','mambo.in.ua');
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
			else $srr='http://shop.mambo.in.ua/images/p/'.str_rot13($row['login']).'.'.$src;
			echo '<div class="user r">
				<a class="aw l" href="'._LOCATION_.'profile/">
					<img class="l" src="'.$srr.'">
					'.str_rot13($row['login']).'
				</a>
				<a class="aw l" href="'._LOCATION_.'login/out.php?f='.$dir.'">Вихід</a>';
		}
		else {
			setcookie('hesh','',time()-60*60*24*2,'/','mambo.in.ua');
			global $is_loggined;
			$is_loggined=0;
			echo '<div class="log r">
					<a class="aw l" href="'._LOCATION_.'register/">Реєстрація</a>
					<a class="aw l" href="'._LOCATION_.'login/?l='.$dir.'">Вхід</a>';
		}
		echo '</div></div>';
		c($par);
	}
	function menu_2(){}
?>