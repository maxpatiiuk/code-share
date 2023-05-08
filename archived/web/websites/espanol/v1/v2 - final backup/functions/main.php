<?php
define('LINK','http://espanol.zzz.com.ua/');
define('_DOMAIN_','espanol.zzz.com.ua');
define('_LOCATION_',"http://espanol.zzz.com.ua/");
define('_API_','../api/lrp3.php');
mysql_connect('MYSQL_HOST','MYSQL_USER','MYSQL_PASSWORD');
mysql_select_db('MYSQL_DATABASE');
function que($query=0,$ress=1){//$row=mysql_fetch_array($res);
	global $res,$ras;//$u=mysql_num_rows($res);
	if($ress==2)
		$ras = mysql_query($query) or die(mysql_error());
	else if($ress!=1)
		$$res = mysql_query($query) or die(mysql_error());
	else
		$res = mysql_query($query) or die(mysql_error());
}//while ($row=mysql_fetch_array($res)){}
function selCon($name,$sname=0){
	define('_'.strtoupper($name).'_',$sname);
}
selCon('posts','e_posts');
selCon('users','e_users');
selCon('slider','e_slider');
selCon('email','max@patii.uk');
function head ($style=0, $cont=0, $title = 'Головна',$others=0){
	if($title!=NULL)
		$title.=' - ';
	$title.='Іспанська мова - сайт для виконання домашніх завдань';
	echo '<title>'.$title.'</title>
		<link rel="shortcut icon" href="'.LINK.'favicon.ico" type="image/x-icon">
		<link rel="icon" href="'.LINK.'favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108610375-1"></script>
		<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag(\'js\', new Date());gtag(\'config\', \'UA-108610375-1\');</script>';
	if($style==1)
		echo '<link href="'.LINK.'css/style.css" rel="stylesheet" type="text/css">';
	if($cont==1)
		echo '<link href="'.LINK.'css/content.css" rel="stylesheet" type="text/css">';
	if($others==1)
		echo '<link href="'.LINK.'css/other.css" rel="stylesheet" type="text/css">';
	echo '<link href="'.LINK.'css/main.css" rel="stylesheet" type="text/css">
		<script src="http://www.w3schools.com/lib/w3data.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
}
function top($is_cont=0){
	global $row,$res,$type,$src,$srr;
	?>
	<header class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=LINK?>"><img src="https://s8.hostingkartinok.com/uploads/images/2017/10/007bd9ea28bfa7aa5e6022bb8d956efb.png" height="75"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php $res = mysql_query('SELECT type,id,login,class FROM '._USERS_.' WHERE hesh="'.preg_replace('/[^a-z0-9]/','',$_COOKIE['hesh']).'"');
						$u=mysql_num_rows($res);
						$row=mysql_fetch_array($res);
						$type=$row['type'];
					if($u!=1){
						define('_ID_','-1');
						?>
						<li><a href="<?=LINK?>register/"><span class="glyphicon glyphicon-user"></span>
							Реєстрація</a>
						</li>
						<li><a href="<?=LINK?>login/"><span class="glyphicon glyphicon-log-in"></span>
							Вхід</a>
						</li>
					<?php }
					else {
						define('_ID_',$row['id']);
						setcookie('hesh',$_COOKIE['hesh'],time()+60*60*24*4,'/',_DOMAIN_);
						$lsrc=LINK.'images/p/'.str_rot13($row['login']).'.';
						if (@getimagesize($lsrc.'jpg'))
							$srr=$lsrc.'jpg';
						else if (@getimagesize($lsrc.'png'))
							$srr=$lsrc.'png';
						else if (@getimagesize($lsrc.'tiff'))
							$srr=$lsrc.'tiff';
						else if (@getimagesize($lsrc.'gif'))
							$srr=$lsrc.'gif';
						else
							$srr="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";
						if($type==2 && $row['class']!=0)
							que('UPDATE '._USERS_.' SET class="0" WHERE id="'._ID_.'"');
						que('UPDATE '._USERS_.' SET last_url="'.$_SERVER['PHP_SELF'].'" WHERE id="'._ID_.'"');
					?>
					<li>
						<a href="<?=LINK?>profile/?id=<?=_ID_?>" style="float:left"><img height="60px" width="60px" style="border-radius:100vh;" src="<?=$srr?>" alt="Профіль"></a>
						<a href="<?=LINK?>profile/out.php" style="float:left"><span class="glyphicon glyphicon-log-out"></span></a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</header>
	<div style="padding-top: 75px" class="
	<?php
	if($is_cont==1)
		echo 'container"><div class="cont" style="overflow:hidden">';
	else
		echo 'content">';
}
function down(){
	global $about,$keywords;
	echo '</div>
	<footer>
		<div class="l_down text-center">&copy; '.date("Y").' MAMBO</div>
	</footer>
	<script>
		function footer_m(){
			var footerTop = $(\'footer\').position().top + $(\'footer\').height();
			if (footerTop < $(window).height()) {
				$(\'footer\').css(\'margin-top\', ($(window).height() - footerTop) + \'px\');
			}
		}
		footer_m()
		setInterval(footer_m,500);
	</script>';
}
?>