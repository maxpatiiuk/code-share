<?php
define('_EMAIL_','max@patii.uk');
# The URl at which website will be publicly available
define('LINK','http://test.mambo.zzz.com.ua/');
define('_DOMAIN_','test.mambo.zzz.com.ua');
define('_API_','../api/lrp3.php');
define('_DEAFULT_AVA_','https://s8.hostingkartinok.com/uploads/images/2018/01/74c8325ebdff4081319b7ca7adf4e7e8.png');
define('_COMMENTS_',3-1);//How many comments display
# Database table names:
define('_PRODUCTS_','`l_products`');
define('_USERS_','`l_users`');
define('_MV_','`l`');
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
function selCon2($name,$sname=NULL){
	global $res,$row;
	if($name=='email' || $sname==3){
		if(preg_match('/^[0-4]$/',$_COOKIE['lang']))
			$buf=$_COOKIE['lang'];
		else
			$buf=1;
	}
	else
		$buf=NULL;
	que('SELECT value FROM '._MV_.' WHERE name="'.$name.$buf.'"');
	$row=mysql_fetch_array($res);
	if($sname!=2)
		define('_'.strtoupper($name).'_',(isset($row['value']))?$row['value']:$sname);
}
selCon2('title',3);
selCon2('keywords',3);
selCon2('tel1',3);
selCon2('tel2',3);
selCon2('email','max@patii.uk');
selCon2('address',3);
selCon2('fblink');
selCon2('twlink');
selCon2('inlink');
selCon2('ytlink');
define('_NAME_',_TITLE_);
if(preg_match('/^[0-4]$/',$_COOKIE['lang']))
	$buf=$_COOKIE['lang'];
else
	$buf=1;
que('SELECT o1'.$buf.' FROM '._PRODUCTS_.' WHERE id="0"');
$row=mysql_fetch_array($res);
define('_ABOUT_',$row['o1'.$buf]);
$about=$row['value'];
function getName($userID){
	global $ras;
	que('SELECT u_name,u_surname,login FROM '._USERS_.' WHERE id="'.$userID.'"',2);
	$raw=mysql_fetch_array($ras);
	if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
		return $raw['u_name'].' '.$raw['u_surname'];
	else
		return str_rot13($raw['login']);
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
					if($placeholder)
						echo ' placeholder="'.$placeholder.'"';
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
$extentions=array('jpeg','png','JPG','jfjf','jpg','tiff','gif','bmp','gif');
function getAva($userLogin,$isBackground=0,$default=NULL){
	global $extentions;
	if($isBackground===1)
		$lsrc=LINK.'images/p/b_'.str_rot13($userLogin).'.';
	else if($isBackground===0)
		$lsrc=LINK.'images/p/'.str_rot13($userLogin).'.';
	else
		$lsrc=$isBackground;
	foreach($extentions as $e)
		if(@getimagesize($lsrc.$e))
			return $lsrc.$e;
	if(isset($default))
		return $default;
	return _DEAFULT_AVA_;
}
function alert($text,$parameter){
	echo '<div class="alert';
		if($parameter)
			echo ' alert-'.$parameter;
		echo ' fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="'.la('close').'">&times;</a>
		'.$text.'
	</div>';
}
function isInjected($str){ return preg_match('/(union|select|delete|insert|alter|drop)/',strtolower($str)); }
function replaceRegLat($str){ return preg_replace('/[^a-zA-Z\d]/','',$str); }
function validExtLat($str){ return !preg_match('/[^\w\-]/',$str); }
function replaceNum($str){ return preg_replace('/[^\d]/','',$str); }
function validNum($str){ return preg_match('/^\d+$/',$str); }
function replaceForbit($str){ return preg_replace('/[!"№|=;%:"%#$&~`%\?\*\^\(\)\+\{\}\[\]\/\\\\]/','',$str); }
function validForbit($str){ return !preg_match('/[!"|=;%:"_%#$&~`%\?\*\^\(\)\+\{\}\[\]\/\\\\]/',$str); }
function validEmail($str){ return preg_match('/^[A-Za-z0-9\.\-_]{3,}@[A-Za-z0-9\.\-_]{2,}.[A-Za-z0-9\.\-_]{2,}$/',$str); }
function validLight($str){ return preg_match('/^[^%\*#\^<>&\{\}\|\\\\\/\[\]]{1,500}$/',$str); }
function correct($str,$replace=1,$html=1){
	if($replace)
		$str=replaceForbit($str);
	if($html)
		$str=htmlentities($str, ENT_QUOTES);
	if(isInjected($str)){
		alert(la('sqlInjection').': union, select, delete, insert, alter, drop','danger');
		exit('SQL injection detected');
	}
	return $str;
}
function head ($title,$keywords=0,$description=0,$cont=0,$others=0){
	global $row,$res,$keywords,$description,$basketLink;
	if($title)
		$title.=' - ';
	$title.=_TITLE_;
	if($keywords)
		$keywords.=',  ';
	$keywords.=_KEYWORDS_.'. ';
	if(!$description)
		$description.=$title.'. '.$keywords;
	$description.=_ABOUT_;
	?><meta charset="utf-8">
	<meta name="keywords" content="<?=$keywords?>">
	<meta name="description" content="<?=$description?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index,follow">
	<title><?=$title?></title>
	<link href="<?=LINK?>css/main.css" rel="stylesheet"><?php
	if($others)
		echo '<link href="'.LINK.'css/others.css" rel="stylesheet">'; ?>
	<link rel="icon" href="<?=LINK?>favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400|Roboto|Oswald" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		$basketLink='login';
	}
	else {
		define('_ID_',$row['id']);
		define('_LOGIN_',$row['login']);
		define('_U_NAME_',getName(_ID_));
		setcookie('hesh',$_COOKIE['hesh'],time()+60*60*24*4,'/',_DOMAIN_);
		$srr=getAva($row['login']);
		define('_SRC_',$srr);
		$basketLink='basket';
	}
}
define('_LANGUAGE_',1);
require_once 'language.php';
function top($cont=0,$spageti=0,$active=0){
	/*if(strlen($cont)>2){*/ ?>
		<div class="fakeNotepad"></div>
		<script>
			function myFunction() {
				$('.topnav').toggleClass('responsive');
			}
		</script>
		<div class="topnav<?php
		if($spageti==1 || $spageti==130)
			echo ' topnav-quote';
		?>"><?php
	/*}
	else {*/ ?>
		<!--<div class="topnav" id="myTopnav">--> <?php /*}*/ ?>
			<a href="<?=LINK?>"><img src="<?=LINK?>/images/logo.png" alt="<?=_NAME_?>"></a>
			<a href="<?=LINK?>about/" <?php if($active==1) echo 'class="active"'?>><?=la('aboutMe')?></a>
			<a href="<?=LINK?>shopscroll/" <?php if($active==2) echo 'class="active"'?>>Персональні тренування</a>
			<a href="<?=LINK?>t/p5/" <?php if($active==3) echo 'class="active"'?>>Саморозвиток</a>
			<a href="<?=LINK?>feedback/" <?php if($active==4) echo 'class="active"'?>>Перевтілення</a>
			<a href="<?=LINK?>feedback/" <?php if($active==5) echo 'class="active"'?>>Блог</a>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a> <?php
			if(_ID_!=-1)
				echo '<a class="menu-r" href="'.LINK.'profile/?id='._ID_.'">'.la('profile').'</a>';
			else
				echo '<a class="menu-r" href="'.LINK.'login/">'.la('logIn').'</a>'; ?>
			<a class="menu-r" href="<?=LINK?>help/"><?=la('help')?></a>
		</div><?php
		if($cont==1){
			echo '<div class="row">
				<div class="col-xs-12 content';
					if(_IS_CONT_==1)
						echo ' cont';
					if($spageti==130)
						echo '" style="padding-top:130px !important';
				echo '">';
	}	
}
function sml($href,$src){
	if(strlen($href)>1)
		echo '<a target="_blank" class="t3" href="'.$href.'" rel="author"><img alt="'.ucfirst(substr($href,12,strpos(substr($href,12),'.'))).' link" src="'.$src.'"></a>';
}
function footer($cont=0){
	if($cont!=0 && $cont!=3)
		echo '</div>
		</div>';
	if($cont!=3)
  echo '<footer>
			<div class="container text-center">&copy; '._NAME_.' '.date("Y").'</div>
		</footer>'; ?>
		<script>
			if($('.container').height() + 70 < $('.clearContainer1').height())
				$('footer').addClass('sticky');
			//setTimeout(function(){ $('.cc').css('padding-top','190px'); },500);
			//$('.cc').css('padding-top','190px');
			
		</script> <?php
}
?>