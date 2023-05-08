<?php
define('LINK','http://test.mambo.zzz.com.ua/');
define('_DOMAIN_','test.mambo.zzz.com.ua');
define('_API_','../api/lrp3.php');
define('_DEAFULT_AVA_','https://s8.hostingkartinok.com/uploads/images/2018/01/74c8325ebdff4081319b7ca7adf4e7e8.png');
define('_COMMENTS_',4-1);//How many comments display
define('_PRODUCTS_','`products_t`');
define('_LOG_','`log`');
define('_USERS_','`users_t`');
define('_NAME_','MAMBO SHOP');
define('_EMAIL_','max@patii.uk');
define('_MAMBO_','http://mambo.in.ua/');
mysql_connect('MYSQL_HOST','MYSQL_USER','MYSQL_PASSWORD');
mysql_select_db('MYSQL_DATABASE');
function que($query=0,$ress=1){//$row=mysql_fetch_array($res);
	global $res;//$u=mysql_num_rows($res);
	if($ress==2)
		$ras = mysql_query($query) or die(mysql_error());
	else if($ress!=1)
		$$res = mysql_query($query) or die(mysql_error());
	else
		$res = mysql_query($query) or die(mysql_error());
}//while ($row=mysql_fetch_array($res)){}
function getName($userID){
	global $res;
	que('SELECT u_name,u_surname,login FROM '._USERS_.' WHERE id="'.$userID.'"');
	$row=mysql_fetch_array($res);
	if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
		return $row['u_name'].' '.$row['u_surname'];
	else
		return str_rot13($row['login']);
}
function a2input($firstName,$name,$type=0,$required=0,$value=0,$placeholder=0,$extra=0){ ?>
	<div class="form-group">
		<label class="control-label col-sm-2" for="a2<?=$name?>"><?=$firstName?>:</label>
		<div class="col-sm-9"> <?php
			if($type==3){
				echo '<textarea class="form-control" id="a2'.$name.'" name="'.$name.'"';
					if($required)
						echo ' required';
					if($extra)
						echo ' '.$extra;
				echo '>';
					if($value)
						echo $value;
				echo '</textarea>';
					?>
		</div>
	</div><?php
		return 0;
	}
	?><input class="form-control" id="a2<?=$name?>" name="<?=$name?>" type="<?php
				if($type==1)
					echo 'password"';
				else if($type==2)
					echo 'email"';
				else
					echo 'text"';
				if($required)
					echo ' required';
				if($value)
					echo ' value="'.$value.'"';
				if($placeholder)
					echo ' placeholder="'.$placeholder.'"';
				if($extra)
					echo ' '.$extra;
			?>>
		</div>
	</div><?php
}
function getAva($userLogin,$isBackground=0,$default=NULL){
	if($isBackground===1)
		$lsrc=LINK.'images/p/b_'.str_rot13($userLogin).'.';
	elseif($isBackground===0)
		$lsrc=LINK.'images/p/'.str_rot13($userLogin).'.';
	else
		$lsrc=$isBackground;
	if (@getimagesize($lsrc.'jpg'))
		return $lsrc.'jpg';
	else if (@getimagesize($lsrc.'jpeg'))
		return $lsrc.'jpeg';
	else if (@getimagesize($lsrc.'png'))
		return $lsrc.'png';
	else if (@getimagesize($lsrc.'tiff'))
		return $lsrc.'tiff';
	else if (@getimagesize($lsrc.'gif'))
		return $lsrc.'gif';
	else if (@getimagesize($lsrc.'bmp'))
		return $lsrc.'bmp';
	else if (@getimagesize($lsrc.'jfjf'))
		return $lsrc.'jfjf';
	else if(isset($default))
		return $default;
	else
		return _DEAFULT_AVA_;
}
function alert($text,$parameter){
	global $file;
	logg($file,2,$parameter." - ".$text);
	echo '<div class="alert';
	if($parameter)
		echo ' alert-'.$parameter;
	echo ' fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="закрити">&times;</a>
		'.$text.'
	</div>';
}
function isInjected($str){ return preg_match('/(union|select|delete|insert|alter|drop)/',strtolower($str)); }
function replaceRegLat($str){ return preg_replace('/[^a-zA-Z\d]/','',$str); }
function validExtLat($str){ return !preg_match('/[^\w\-]/',$str); }
function replaceNum($str){ return preg_replace('/[^\d]/','',$str); }
function validNum($str){ return preg_match('/[^\d]/',$str); }
function replaceForbit($str){ return preg_replace('/[!"№|=;%:"@%#$&~`%\?\*\^\(\)\+\{\}\[\]\/\\\\]/','',$str); }
function validForbit($str){ return preg_match('/[!"|=;%:"_@%#$&~`%\?\*\^\(\)\+\{\}\[\]\/\\\\]/',$str); }
function validEmail($str){ return preg_match('/(^[\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,14}(?:\.[a-z]{2})?)$/',$str); }
function validLight($str){ return preg_match('/^[^%\*@#\^<>&\{\}\|\\\\\/\[\]]{1,500}$/',$str); }
function correct($str,$replace=1,$html=1){
	if($replace)
		$str=replaceForbit($str);
	if($html)
		$str=htmlentities($str, ENT_QUOTES);
	if(isInjected($str)){
		alert('Заборонено використовувати наступні слова: union, select, delete, insert, alter, drop','danger');
		logg($file,10,'SQL injection detected');
		exit('SQL injection detected');
	}
	return $str;
}
function logg($dir,$type,$val){
	que('INSERT INTO '._LOG_.'(domain,directory,eTime,ip,userID,type,val) VALUES("'._DOMAIN_.'","'.$dir.'","'.date('H:i:s d:m:y').'","'.$_SERVER['REMOTE_ADDR'].'","'._ID_.'","'.$type.'","'.$val.'")');
}
function head ($title,$keywords=0,$description=0,$cont=0,$others=0){
	global $row,$res,$keywords,$description;
	if($title)
		$title.=' - ';
	$title.='Mambo Shop - український магазин ігрових акаунтів та ключів. Широкий асортимент. Найнищі ціни. Minecraft, CS GO, GTA 5, Battlefield 1';
	if($keywords)
		$keywords.=',  ';
	$keywords.='магазин мамбо, mambo shop, minecraft за 2 гривні, mambo, В гостях у MAMBO, мамбо';
	if(!$description)
		$description.=$title.'. '.$keywords; 
	?><meta charset="utf-8">         <!-- js validation +login/register button clicable if correct -->
	<meta name="keywords" content="<?=$keywords?>">         <!-- add css to mail -->
	<meta name="description" content="<?=$description?>">         <!-- 404 do -->
	<meta name="viewport" content="width=device-width, initial-scale=1">         <!-- add products -->
	<meta name="author" content="Максим Патіюк">
	<meta name="robots" content="index,follow">
	<title><?=$title?></title>
	<link href="<?=LINK?>css/main.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?=LINK?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?=LINK?>images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Oswald:200" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<?php if($others==1)
		echo '<link href="'.LINK.'css/other.css" rel="stylesheet">'; ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108610375-1"></script>
	<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-108610375');</script><?php
	que('SELECT type,id,login,u_name,u_surname FROM '._USERS_.' WHERE hesh="'.replaceRegLat($_COOKIE['hesh']).'"');
	$u=mysql_num_rows($res);
	$row=mysql_fetch_array($res);
	define('_TYPE_',$row['type']);
	define('_IS_CONT_',$cont);
	if($u!=1){
		define('_ID_','-1');
		define('_SRC_',_DEAFULT_AVA_);
	}
	else {
		define('_ID_',$row['id']);
		define('_LOGIN_',$row['login']);
		define('_U_NAME_',getName(_ID_));
		setcookie('hesh',$_COOKIE['hesh'],time()+60*60*24*4,'/',_DOMAIN_);
		$srr=getAva($row['login']);
		define('_SRC_',$srr);
		que('UPDATE '._USERS_.' SET last_url="'.$_SERVER['PHP_SELF'].'" WHERE id="'._ID_.'"');
	}
	logg($file,0,"User visited page");
}
function top($cont=0){
	?><header>
		<nav class="navbar navbar-inverse navbar-fixed-top" id="menu">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" id="navbarCollapseToggle" data-toggle="collapse" data-target="#navbarCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=LINK?>">MAMBO SHOP</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="nav navbar-nav">
					<li><a href="https://www.oplata.info/info/">Корзина</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li> <?php
						if(_ID_!=-1)
							echo '<a href="'.LINK.'profile/">Профіль</a></li>
							<li><a href="'.LINK.'profile/out.php">Вихід</a>';
						else
							echo '<a href="'.LINK.'login/">Вхід</a></li><li>
							<a href="'.LINK.'register/">Реєстрація</a>'; ?>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<?php if($cont){
		echo '<div class="row">
			<div class="col-xs-12 content';
				if(_IS_CONT_==1)
					echo ' cont';
				echo '" style="padding-top:5vh">';
		}
}
function sml($href,$src){
	echo '<a target="_blank" class="t3" href="'.$href.'" rel="author"><img alt="'.ucfirst(substr($href,12,strpos(substr($href,12),'.'))).' link" src="'.$src.'"></a>';
}
function footer($cont=0){
	global $keywords,$description;
	if($cont)
		echo '</div>
		</div>'; ?>
	<footer>
			<a href="<?=LINK?>light/">Легка версія сайту</a><br>
			&copy;MAMBO <?=date("Y")?>
	</footer> <?php
}
?>