<?php global $paslist,$file;
$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
function op2($name,$secname=NULL){
	if(!$secname)
		$secname=$name;
	global $row;
	if($row[$secname]!=NULL){
		echo '<div class="form-group">
		<label class="control-label col-sm-2" for="a2'.strtolower($secname).'">'.ucfirst($name).':</label>
		<div class="col-sm-9">';
			if($secname!='about')
				echo '<input class="form-control" id="a2'.strtolower($secname).'"t type="text" value="'.$row[$secname].'" readonly>';
			else
				echo '<textarea class="form-control" rows="5" maxlength="255" id="a2about" readonly>'.$row[$secname].'</textarea>';
			echo '</div>
		</div>';
	}
}
function err(){
	global $location;
	$str=la('noSuchUser').'!<br><a href=\"'.$location.'\">'.la('back2main').'</a><br><a href=\"'.$location;
	if(_ID_!=-1)
		$str.='profile/?id='._ID_.'\">'.la('back2profile');
	else 
		$str.='login\">'.la('addAccSuc').'</a><br><a href=\"'.$location.'register\">'.la('register');
	$str.='</a></div>';
	alert($str,'danger');
}
function a_link($names){
	global $row, $users;
	if(isset($_POST[$names]) && $_POST[$names]!=$row[$names]){
		if(preg_match('/^[a-zA-Z0-9_:#\/\?\&\.]{9,255}$/', $_POST[$names])){
			alert(''.ucfirst($names).' '.la('addAccSuc'),'success');
			que('UPDATE '.$users.' SET '.$names.'="'.$_POST[$names].'" WHERE id="'._ID_.'"');
		}
		else
			alert(la('smErr').' '.ucfirst($names).' '.la('acc'),'danger');
	}
}
function socialm($name){
	global $row;
	a2input(ucfirst($name),strtolower($name),0,0,$row[$name],ucfirst($name));
}
function o($domain='mambo.in.ua'){
	setcookie("hesh", NULL, -1, "/", $domain);
	header("Location: {$_SERVER['HTTP_REFERER']}");
	alert(la('loginSuccess').'!<br>'.la('redir').' <a href="'.$_SERVER['HTTP_REFERER'].'">'.la('here').'</a>','success');
}
function l($location,$users='users',$domain="mambo.in.ua"){
	global $row,$res,$paslist;
	echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
	$d=1;
	if(isset($_POST["login"]) && isset($_POST["pass"])) {
		$login=str_rot13(correct(preg_replace('/[^@-Za-z0-9\._\-]/', '', $_POST['login'])));
		$pas=str_rot13(correct(preg_replace('/[^A-Za-z0-9_\-]/', '', $_POST['pass'])));
		$hesh=md5($login).md5('Ag5l').md5($pas);
		que("SELECT r_ip,date,ip,id FROM ".$users." WHERE login='".$login."' AND val='".$pas."'");
		$row=mysql_fetch_array($res);
		$u1=mysql_num_rows($res);
		if($u1!=1){
			$hesh=md5(str_rot13(strtolower($login))).md5('Ag5l').md5($pas);
			que("SELECT r_ip,date,ip,id FROM ".$users." WHERE email='".str_rot13(strtolower($login))."' AND val='".$pas."'");
			$row=mysql_fetch_array($res);
			$u2=mysql_num_rows($res);
		}
		$i=$_POST['i'];
		$id=$row['id'];
		if($i>2){
			if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
				$r=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfnjSIUAAAAAMA1uDkemjvaiSlzB39R8KijOsZa&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
				if($r.success==false)
					alert(la('capcha'),'danger');
				else $i=0;
			}
			else
				alert(la('capcha'),'danger');
		}
		else if ($u1==1 || $u2==1){
			$ip=$_SERVER['REMOTE_ADDR'];
			alert(la('loginSuccess'),'success');
			if(strlen($_COOKIE['lang'])>0 && is_numeric($_COOKIE['lang']) && $_COOKIE['lang']<5 && $_COOKIE['lang']>0)
				$buf1=", lang='".$_COOKIE['lang']."'";
			else
				$buf1=NULL;
			$que="UPDATE ".$users." SET ip='".$ip."', hesh='".$hesh."', date='".date('H:i:s d:m:y')."'".$buf1;
			$que.=" WHERE id='".$id."'";
			que($que);
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
			$is_loggined=1;
			$i=0;
			if($row['ip']!=$ip && $ip==$row['r_ip'])
				alert(la('logErr1').' '.$row['date'].' ('.la('logErr2').': '.$row['ip'],'danger');
			else {
				alert(la('redir').' <a href=\"'.$location.'\">'.la('here').'</a>','warning');
				header('Location: '.$location.'');
			}
			echo '</p>';
		}
		else {
			alert(la('invalidLog'),'danger');
			$is_loggined=0;
			setcookie("hesh", NULL, -1, "/", $domain); 
			$i=$_POST['i']+1;
		}
	}
	else if(_ID_!=-1)
		header("Location: {$_SERVER['HTTP_REFERER']}");
	if(!$is_loggined){
		?><br><form class="form-horizontal" method="post" action="<?=$location?>login/"><?php
			a2input(la('loginS'),'login',0,1,$_POST['login'],la('loginS'),'maxlenght="20" autofocus');
			a2input(la('pass'),'pass',1,1,NULL,la('pass'),'autocomplete="off" maxlenght="40"');
			if($i>2)
				echo '<div class="form-group">
					<label class="control-label col-sm-2" for="a2email">'.la('capcha').':</label>
					<div class="col-sm-9">
						<div class="g-recaptcha" data-sitekey="6LfnjSIUAAAAANkRfSYdlIGK4H4sveFTjeOIdysV"></div>
					</div>
				</div>';
			?>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9 btn-group">
					<button type="submit" class="btn btn-goldi"><?=la('logIn')?></button>
					<a href="<?=$location?>register/" class="btn btn-goldi"><?=la('register')?></a>
					<a href="<?=$location?>register/conf.php?d=40" class="btn btn-goldi"><?=la('forgotPass')?></a>
				</div>
			</div>
			<input type="hidden" name="link" value="<?=$link?>">
			<input type="hidden" name="i" value="<?=$i?>">
		</form>
		<?php
	}
}
function r($users='users', $location, $domain='mambo.in.ua', $mail=NULL, $email=NULL, $name=NULL){
	global $row,$res,$paslist;
	if($email==NULL)
		$email='max@patii.uk';
	if($name==NULL)
		$name='MAMBO';
	if($mail==NULL)
		$mail=la('loginError11').' '.la('officialSite').' '.$name.' ('.$domail.'). '.la('loginError12').' - ';
	if(!isset($_POST['login']) && !isset($_POST['pass']) && !isset($_POST['login']) && !isset($_POST['d_pass']) && !isset($_POST['email']))
		$d=1;
	else {
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$d=0;
		if(!preg_match("/^[a-z@-Z0-9_]{3,20}$/",$login)){
			$d=1;
			alert(la('loginError1'),'danger');
		}
		if(!preg_match("/^[a-zA-Z0-9_\-]{6,40}$/",$pass)){
			$d=1;
			alert(la('loginError2'),'danger');
		}
		if($pass!=$_POST['d_pass']){
			$d=1;
			alert(la('loginError3'),'danger');
		}
		$login=correct($login);
		$pass=correct($pass);
		que("SELECT id FROM ".$users." WHERE login='".$login."'");
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u!=0){
			$d=1;
			alert(la('loginError4'),'danger');
		}
		if($login==$pass){
			$d=1;
			alert(la('loginError5'),'danger');
		}
		for($i=0;$i<=count($paslist);$i++)
			if($paslist[$i]==$pass && isset($pass)) $er=1;
		for($i=1;$i<=strlen($pass);$i++)
			if($pass[$i]!=$pass[0]) $er=2;
		if($er!=2 || $er==1){
			$d=1;
			alert(la('loginError6'),'danger');
		}
		$email=strtolower(correct($_POST['email']));
		echo var_dump($email);
		echo var_dump(validEmail($email));
		if(validEmail($email)){
			que("SELECT id FROM ".$users." WHERE email='".$email."'");
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			if($u!=0){
				$d=1;
				alert(la('loginError7'),'danger');
			}
		}
		else {
			$d=1;
			alert(la('loginError8'),'danger');
		}
		que('SELECT id FROM '.$users.' WHERE r_ip="'.$_SERVER['REMOTE_ADDR'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u>5){
			$d=1;
			alert(la('loginError9'),'danger');
		}
		if($d==0){
			$login=str_rot13($login);
			$pas=str_rot13($pass);
			$hesh=md5($login).md5('Ag5l').md5($pas);
			//$code=substr(md5(microtime()),rand(0,26),5);
			$code_f=$code.':::';
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
			alert(la('loginError10'),'success');
			if(strlen($_COOKIE['lang'])>0 && is_numeric($_COOKIE['lang']) && $_COOKIE['lang']<5 && $_COOKIE['lang']>0){
				$buf1=', lang';
				$buf2=",'".$_COOKIE['lang']."'";
			}
			else {
				$buf1=NULL;
				$buf2=NULL;
			}
			que("INSERT INTO ".$users."(login,val,ip,r_date,email,hesh,conf_c,conf".$buf1.") VALUES ('".$login."','".$pas."','".$_SERVER['REMOTE_ADDR']."','".date('H:i:s d:m:y')."','".$email."','".$hesh."','".$code_f."',1".$buf2.")");
			que('SELECT id FROM '.$users.' WHERE login="'.$login.'"');
			$row=mysql_fetch_array($res);
			//$message=la('loginError11').' '.$name.' ('.$domain.'). '.la('loginError12').' - '.$location.'register/conf.php?i='.$row['id'].'&c='.$code;
			//mail($_POST['email'],la('loginError13')." - ".$name,$message,"Content-Type: text/html; charset='utf-8'","From: ".$email);
		}
	}
	if($d==1){
		?>
		<br><form class="form-horizontal" method="post" action="<?=$location?>register/"><?php
			a2input(la('loginS'),'login',0,1,$_POST['login'],la('loginS'),'maxlenght="20" autofocus');
			a2input(la('pass'),'pass',1,1,NULL,la('pass'),'autocomplete="off" maxlenght="40"');
			a2input(la('rePass'),'d_pass',1,1,NULL,la('rePass'),'autocomplete="off" maxlenght="40"');
			a2input(la('email'),'email',2,1,$_POST['email'],'E-mail','maxlenght="30"');
			?>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9">
					<button type="submit" class="btn btn-goldi"><?=la('register')?></button>
					<a href="<?=$location?>login/" class="btn btn-goldi"><?=la('logIn')?></a>
				</div>
			</div>
		</form>
		<?php
	}
}
function co($users, $location,$i,$c,$de){
	global $row,$res,$paslist;
	$_GET['i']=$i;
	$_GET['c']=$c;
	$_GET['d']=$de;
	if((isset($_GET['i']) && strlen($_GET['c'])==5 && preg_match('/[0-9]/', $_GET['i'].$_GET['c'])) || $_GET['d']==40){
		$code=$_GET['c'];
		que("SELECT login,val,conf_c FROM ".$users." WHERE id='".$_GET['i']."'");
		$row=mysql_fetch_array($res);
		$l=$row['login'];
		$p=$row['val'];
		$codes=preg_split('/:/',$row['conf_c']);
		$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$codes[3];
		if($_GET['d']==37){//erase login+pas
			if(isset($_POST['login']) && isset($_POST['val'])){
				$login=$_POST['login'];
				$pass=$_POST['val'];
				$d=0;
				if(!preg_match("/^[a-zA-Z0-9-_]+$/",$login) || strlen($login) < 3 || strlen($login) > 20){
					$d=1;
					alert(la('loginError1'),'danger');
				}
				if(!validExtLat($pass) || strlen($pass) < 6 || strlen($pass) > 40){
					$d=1;
					alert(la('loginError2'),'danger');
				}
				if($login==$pass){
					$d=1;
					alert(la('loginError5'),'danger');
				}
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					alert(la('loginError6'),'danger');
				}
				if($d==0){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13(correct($login))."'");
					$u=mysql_num_rows($res);
					if($u!=0){
						$d=1;
						if(str_rot13($l)==$login)
							alert(la('repeated1'),'danger');
						else
							alert(la('loginError4'),'danger');
					}
					else if($p==str_rot13($pass)){
						$d=1;
						alert(la('repeated2'),'danger');
					}
					else {
						$code_f=$codes[0].'::'.$codes[2].':'.$codes[3];
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'", login="'.str_rot13($login).'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert(la('resetSuccess').'<br><a href="'.$location.'/">'.la('main').'</a><br><a href="'.$location.'/profile/">'.la('profile').'</a>','success');
					}
				}
			}
			if($d==1 || !isset($_POST['login'])) {
				if($codes[1]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=37&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input(la('loginS'),'login',0,1,$_POST['login'],la('loginS'));
						a2input(la('pass'),'val',1,1,NULL,la('pass'));
						echo	'<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">'.la('ready').'</button>
							</div>
						</div>
					</form>';
				}
				else
					alert(la('exposed'),'danger');
			}
		}
		else if($_GET['d']==38){//erase email+pas
			if(isset($_POST['email']) && isset($_POST['val'])){
				if(validEmail($_POST['email'])){
					que("SELECT id FROM ".$users." WHERE email='".strtolower(correct($_POST['email']))."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0){
						$d=1;
						if($rowd['id']==$_GET['i'])
							alert(la('resetError1'),'danger');
						else
							alert(la('loginError7'),'danger');
					}
					que("SELECT id FROM ".$users." WHERE val='".correct(str_rot13($_POST['val']))."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0 && $rowd['id']==$_GET['i']){
						$d=1;
						alert(la('repeated2'),'danger');
					}
				}
				else {
					$d=1;
					alert(la('loginError8'),'danger');
				}
				if($d==0){
					$pass=$_POST['val'];
					if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
						$d=1;
						alert(la('loginError2'),'danger');
					}
					for($i=0;$i<=count($paslist);$i++)
						if($paslist[$i]==$pass && isset($pass)) $er=1;
					for($i=1;$i<=strlen($pass);$i++)
						if($pass[$i]!=$pass[0]) $er=2;
					if($er!=2 || $er==1){
						$d=1;
						alert(la('loginError6'),'danger');
					}
					if($d==0){
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':';
						que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'", email="'.$_POST['email'].'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert(la('resetSuccess2'),'success');
					}
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=38&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input(la('new1'),'email',2,1,$_POST['email'],'E-mail');
						a2input(la('new2'),'val',1,1,NULL,la('pass'));
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">'.la('ready').'</button>
							</div>
						</div>
					</form>';
				}
				else
					alert(la('exposed'),'danger');
			}
		}
		else if($_GET['d']==39){//erase pas
			if(isset($_POST['val'])){
				que('SELECT val FROM '.$users.' WHERE id="'.$_GET['i'].'"');
				$row=mysql_fetch_array($res);
				$u=mysql_num_rows($res);
				$pass=$_POST['val'];
				$d=0;
				if(!validExtLat($pass) || strlen($pass) < 6 || strlen($pass) > 40){
					$d=1;
					alert(la('loginError2'),'danger');
				}
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					alert(la('loginError6'),'danger');
				}
				$pass=correct($pass);
				if($d==0){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($p==str_rot13($pass)){
						$d=1;
						alert(la('repeated2'),'danger');
					}
					else {
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].'::';
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert(la('resetSucces3').'<br><a href="'.$location.'/">'.la('main').'</a><br><a href="'.$location.'/profile/">'.la('profile').'</a>','success');
					}
				}
			}
			if($d==1 || !isset($_POST['val'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input(la('new2'),'val',1,1,NULL,la('pass'));
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">'.la('ready').'</button>
							</div>
						</div>
					</form>';
				}
				else
					alert(la('exposed'),'danger');
			}
		}
		else if($_GET['d']==40){//forgot pass
			if(isset($_POST['email'])){
				if(validEmail($_POST['email'])){
					que("SELECT id FROM ".$users." WHERE email='".strtolower(correct($_POST['email']))."'");
					$u=mysql_num_rows($res);
					if($u==0){
						$d=1;
						alert(la('resetError1'),'danger');
					}
					else if($d==0){
						$code=substr(md5(microtime()),rand(0,26),5);
						$codes=preg_split('/:/',$row['conf_c']);
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
						que('SELECT id FROM '.$users.' WHERE email="'.$_POST['email'].'"');
						$rowd=mysql_fetch_array($res);
						$message=la('resetPassS1').' '._NAME_.' ('.$domain.'). '.la('resetPassS2').':'.$location.'register/conf.php?d=39&i='.$rowd['id'].'&c='.$code.' . '.la('resetPassS3');
						mail($_POST['email'],la('resetPassS4').' - '._NAME_,$message,'', "Content-Type: text/html; charset='utf-8'");
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'" WHERE id="'.$rowd['id'].'"');
						alert(la('resetPassS5'),'warning');
					}
				}
				else {
					$d=1;
					alert(la('loginError8'),'danger');
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=40" method="post">';
						a2input(la('email'),'email',0,1,$_POST['email'],la('email'));
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">'.la('ready').'</button>
							</div>
						</div>
					</form>';
				}
				else
					alert(la('exposed'),'danger');
			}
		}
		else {//confirm email
			que("SELECT conf,r_date,conf_c FROM ".$users." WHERE id='".$_GET['i']."'");
			$row=mysql_fetch_array($res);
			if($row['conf']!=1 && $codes[0]==$_GET['c']){
				$code_f=':'.$codes[1].':'.$codes[2].':'.$codes[3];
				que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'" WHERE id="'.$_GET['i'].'"');
				alert(la('confirmed1').' <a href="'.$location.'">'.la('here').'</a><br>'.la('confirmed2').' <a href="'.$location.'profile/">'.la('here').'</a>','success');
			}
			else
				alert(la('exposed'),'danger');
		}
	}
	else
		alert(la('exposed'),'danger');
}
function p($locations,$users='users',$domain='mambo.in.ua', $email='max@patii.uk', $name='MAMBO SHOP', $mail1=NULL, $mail2=NULL, $mail3=NULL){
	$us=$users;
	global $location,$row,$res,$id,$users,$u,$paslist;
	$location=$locations;
	$users=$us;
	echo '<script>function redir(where) {window.location.href = where;}</script>';
	$hesh=replaceRegLat($_COOKIE['hesh']);
	que('SELECT * FROM '.$users.' WHERE hesh="'.$hesh.'"');
	$id2=replaceNum($_GET['id']);
	if(_ID_!=$id2){
		que('SELECT * FROM '.$users.' WHERE id="'.$id2.'"');
		$u2=mysql_num_rows($res);//if get[id] exist
	}
	if($_GET['tab']==2){ 
		$but2=' class="active"';
		$tab2=' active in';
	}
	else {
		$but1=' class="active"';
		$tab1=' active in';
	}
	if(strlen($id2)>0){
		if($id2==_ID_){//if get[id]==loggined user
			?> <ul class="nav nav-tabs" style="margin: 0 -15px;">
				<li<?=$but1?>><a data-toggle="tab" href="#tab1" aria-expanded="true"><?=la('profile')?></a></li>
				<li<?=$but2?>><a data-toggle="tab" href="#tab2" aria-expanded="false"><?=la('security')?></a></li>
				<li><a onclick="redir('<?=$location?>profile/?d=all')"><?=la('users')?></a></li> <?php
				?> <li><a onclick="redir('<?=$location?>profile/out.php')"><?=la('logOut')?></a></li>
			</ul>
			<div class="tab-content">
				<div id="tab1" class="tab-pane fade<?=$tab1?>">
					<?php
					que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
					$row=mysql_fetch_array($res);
					if(isset($_POST['submit_1'])){
						if(isset($_POST['login']) && str_rot13($row['login'])!=$_POST['login']){
							que("SELECT id FROM ".$users." WHERE login='".str_rot13($_POST['login'])."'");
							$row2=mysql_fetch_array($res);
							$u=mysql_num_rows($res);
							if($u!=0){
								$d=1;
								alert(la('loginError4'),'danger');
							}
							else if(preg_match("/^[a-zA-Z0-9+-_]{3,60}$/",$_POST['login'])){
								alert(la('loginChanged'),'success');
								$code=substr(md5(microtime()),rand(0,26),5);
								if($mail2==NULL)
									$mail2=la('email21').' '.$name.' ('.$domain.') '.la('email22').': '.$location.'register/conf.php?d=37&i='.$row['id'].'&c='.$code.' .';
								mail($row['email'],la('email23')." - ".$name,$mail2,"", 'Content-Type: text/html; charset="utf-8"');
								que("SELECT conf_c FROM ".$users." WHERE id='"._ID_."'");
								$row3=mysql_fetch_array($res);
								$code=substr(md5(microtime()),rand(0,26),5);
								$codes=preg_split('/:/',$row3['conf_c']);
								$code_f=$codes[0].':'.$code.':'.$codes[2].':'.$codes[3];
								que('UPDATE '.$users.' SET conf_c="'.$code_f.'", login="'.str_rot13($_POST['login']).'" WHERE id="'._ID_.'"');
							}
							else
								alert(la('loginError1'),'danger');
						}
						if(isset($_POST['email']) && $row['email']!=$_POST['email']){
							if(validEmail($_POST['email'])){
								alert(la('emailChange'),'success');
								if($_POST['email']!='test@t_es.t'){
									$code=substr(md5(microtime()),rand(0,26),5);
									$code2=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$code2.':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.' SET conf=0, conf_c="'.$code_f.'", email="'.$_POST['email'].'" WHERE id="'._ID_.'"');
									if($mail1==NULL)
										$mail=a('emailChange2').' '.$name.' ('.$domain.'). '.la('emailChange3').' - ';
									mail($row['email'],la('emailChange4')." - ".$name,$mail1.$location.'register/conf.php?i='.$id.'&d=38&c='.$code,"", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else
								alert(la('emailChange4').' "name@domain.com"','danger');
						}
						if(isset($_POST['phone']) && $_POST['phone']!='' && $_POST['phone']!=$row['phone']){
							if(preg_match('/^\+[0-9]{0,20}$/', $_POST['phone'])){
								que('UPDATE '.$users.' SET phone="'.$_POST['phone'].'" WHERE id="'._ID_.'"');
								alert(la('phoneAdded'),'success');
							}
							else
								alert(la('phoneError'),'danger');
						}
						if($_FILES['avatar']['size']>0){
							switch($_FILES['avatar']['type']){
								case "image/jpeg":$src2="1";break;
								case "image/jpg":$src2="1";break;
								case "image/gif":$src2="1";break;
								case "image/png":$src2="1";break;
								case "image/tiff":$src2="1";break;
							}
							if(isset($src2)){
								if($_FILES['avatar']['size']>1024*1024*3)
									alert(la('avaError').'. <a target="_blank" href="https://kraken.io/web-interface">'.la('useResizer') .'</a>','danger');
								else {
									unlink('../images/p/'.str_rot13($row['login']).'.jpg');
									unlink('../images/p/'.str_rot13($row['login']).'.gif');
									unlink('../images/p/'.str_rot13($row['login']).'.png');
									unlink('../images/p/'.str_rot13($row['login']).'.tiff');
									move_uploaded_file($_FILES['avatar']['tmp_name'],'../images/p/'.str_rot13(_LOGIN_).'.'.pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
									alert(la('avaChanged'),'success');
									$src2=NULL;
								}
							}
							else
								alert(la('formats1'),'danger');
						}
						if($_FILES['backg']['size']>0){
							switch($_FILES['backg']['type']){
								case "image/jpeg":$src2="1";break;
								case "image/jpg":$src2="1";break;
								case "image/gif":$src2="1";break;
								case "image/png":$src2="1";break;
								case "image/tiff":$src2="1";break;
							}
							if(isset($src2)){
								if($_FILES['backg']['size']>1024*1024*3)
									alert(la('backError').'. <a target="_blank" href="https://kraken.io/web-interface">'.la('useResizer') .'</a>','danger');
								else {
									unlink('../images/p/b_'.str_rot13($row['login']).'.jpg');
									unlink('../images/p/b_'.str_rot13($row['login']).'.gif');
									unlink('../images/p/b_'.str_rot13($row['login']).'.png');
									unlink('../images/p/b_'.str_rot13($row['login']).'.tiff');
									move_uploaded_file($_FILES['backg']['tmp_name'],'../images/p/b_'.str_rot13(_LOGIN_).'.'.pathinfo($_FILES['backg']['name'], PATHINFO_EXTENSION));
									alert(la('backChanged'),'success');
								}
							}
							else
								alert(la('formats2'),'danger');
						}
						a_link('facebook');
						a_link('youtube');
						a_link('twitter');
						a_link('instagram');
						a_link('pinterest');
						que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
						$row=mysql_fetch_array($res);
						if($_POST['u_name']!=$row['u_name']){
							if(validForbit($_POST['u_name']) && strlen($_POST['u_name'])<30){
								que('UPDATE '.$users.' SET u_name="'.$_POST['u_name'].'" WHERE id="'._ID_.'"');
								alert(la('namChang'),'success');
							}
							else
								alert(la('enterValidName'),'danger');
						}
						if($_POST['u_surname']!=$row['u_surname']){
							if(validForbit($_POST['u_surname']) && strlen($_POST['u_surname'])<30){
								que('UPDATE '.$users.' SET u_surname="'.$_POST['u_surname'].'" WHERE id="'._ID_.'"');
								alert(la('surChang'),'success');
							}
							else
								alert(la('enterSur'),'danger');
						}
						if($_POST['city']!=$row['city']){
							if(validForbit($_POST['city']) && strlen($_POST['city'])<65){
								que('UPDATE '.$users.' SET city="'.$_POST['city'].'" WHERE id="'._ID_.'"');
								alert(la('addChang'),'success');
							}
							else
								alert(la('enterAdd'),'danger');
						}
						if($_POST['u_date']!=$row['u_date']){
							if(!isset($_POST['u_date']) || !preg_match("/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/", date('Y-m-d',strtotime($_POST['u_date']))) || strlen($_POST['u_date'])!=10)
								alert(la('enterBir'),'danger');
							else {
								que('UPDATE '.$users.' SET u_date="'.date('Y-m-d',strtotime($_POST['u_date'])).'" WHERE id="'._ID_.'"');
								alert(la('birChang'),'success');
							}
						}
						if($_POST['about']!=$row['about']){
							if(!isset($_POST['about']) || !validLight($_POST['about']) || strlen($_POST['about'])>255)
								alert(la('forbitCh').' : %, \, *, @, #, ^, <, >, &, {, }, |, \, /, [, ]. '.la('maxStLen'),'danger');
							else {
								que('UPDATE '.$users.' SET about="'.$_POST['about'].'" WHERE id="'._ID_.'"');
								alert(la('aboChang'),'success');
							}
						}
					}
					que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
					$row=mysql_fetch_array($res);
					?><div class="row">
	    	<div style="width: 100vw;overflow: hidden;padding-bottom: 25%;position: relative;background-color:#fff;background-image:url(<?=getAva(_LOGIN_,1,'https://s8.hostingkartinok.com/uploads/images/2018/04/a6dbabae92235fd3da34949d2ad32de2.jpg')?>);background-size:cover;background-position: center;"></div>
						<div class="l col-xs-3" style="margin-left: 5vw;height: 25vw;margin-top: -20vw;overflow: hidden;border: 10px solid #fff;background:#fff;border-radius: 100vw;background-image:url(<?=getAva(_LOGIN_)?>);background-size:auto 100%;background-position: center;"></div>
						<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;"><?php echo getName(_ID_); ?></div>
					</div>
					<br><form class="form-horizontal" action="index.php?id=<?=$row['id']?>" enctype="multipart/form-data" method="post"> <?php
						a2input(la('userName'),'u_name',0,0,$row['u_name'],la('userName'));
						a2input(la('uSurname'),'u_surname',0,0,$row['u_surname'],la('uSurname'));
						?><div class="form-group">
							<label class="control-label col-sm-2" for="a2u_date"><?=la('birtText')?>:</label>
							<div class="col-sm-9">
								<input class="form-control" id="a2u_date" type="date" name="u_date" value="<?=$row['u_date']?>" min="1950-01-01" max="<?=date("Y")?>-01-01" pattern="[^\\\$\^\&\?\*\{\}\'\[\]]"<?php if(isset($row['u_date'])) echo ' requiered';?>>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2about"><?=la('aboutYou')?>:</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" maxlength="255" id="a2about" name="about" placeholder="<?=la('aboutYou')?>"><?=$row['about']?></textarea>
							</div>
						</div> <?php
						a2input(la('addressT'),'city',0,0,$row['city'],la('addressT'));
						a2input(la('loginS'),'login',0,1,str_rot13($row['login']),la('loginS'));
						a2input(la('phoneNum'),'phone',0,0,$row['phone'],la('pnoneExp'));
						socialm('facebook');
						socialm('youtube');
						socialm('twitter');
						socialm('instagram');
						socialm('pinterest');
						?>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2av"><?=la('changeAv')?>:</label>
							<div class="col-sm-9">
								<input id="a2av" type="file" accept="image/*" name="avatar">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2backg"><?=la('changeBg')?>:</label>
							<div class="col-sm-9">
								<input id="a2backg" type="file" accept="image/*" name="backg">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" name="submit_1" class="btn btn-goldi"><?=la('saveChan')?></button>
							</div>
						</div>
					</form>
				</div>
				<div id="tab2" class="tab-pane fade<?=$tab2?>">
					<form method="post" action="index.php?id=<?=_ID_?>&tab=2" class="form-horizontal">
						<?php
						que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
						$row=mysql_fetch_array($res);
						if(isset($_POST['submit_2'])){
							if(strlen($_POST['pass1'])>1 && strlen($_POST['pass2'])>1 && strlen($_POST['pass3'])>1){
								if($_POST['pass1']!=str_rot13($row['val'])){
									$e=1;
									alert(la('prevPasE'),'danger');
								}
								if($_POST['pass2']!=$_POST['pass3']){
									$e=1;
									alert(la('newPassE'),'danger');
								}
								if($_POST['pass1']==$_POST['pass2']){
									$e=1;
									alert(la('prevUNew'),'danger');
								}
								if(!preg_match("/^[a-zA-Z0-9\-_]{6,40}$/",$_POST['pass2'])){
									$e=1;
									alert(la('loginError2'),'danger');
								}
								for($i=0;$i<=count($paslist);$i++)
									if($paslist[$i]==$_POST['pass2'] && isset($_POST['pass2']))
										$er=1;
								for($i=1;$i<=strlen($_POST['pass2']);$i++)
									if($_POST['pass2'][$i]!=$_POST['pass2'][0])
										$er=2;
								if($er!=2 || $er==1){
									$e=1;
									alert(la('loginError6'),'danger');
								}
								if($e!=1){
									$pas=str_rot13($_POST['pass2']);
									$code=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.' SET conf_c="'.$code_f.'", val="'.$pas.'" WHERE id="'._ID_.'"');
									alert(la('pasChanS'),'success');
									if($mail3==NULL)
										$mail3=la('pasChaT1').' '.$name.' ('.$domain.'). '.la('pasChaT2').' - ';
									mail($row['email'],la('pasChang')." - Mambo Shop",$mail3.$location.'register/conf.php?d=39&i='._ID_.'&c='.$code,"", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else
								alert(la('pasInstr'),'danger');
							if($_POST['vis']!=$row['vis'] && $_POST['vis']!=NULL)
								que('UPDATE '.$users.' SET vis="'.$_POST['vis'].'" WHERE id='._ID_);
						}
						que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
						$row=mysql_fetch_array($res);
						?><div class="page-header col-sm-offset-2">
							<h4><?=la('pasChang')?></h4>
						</div><?php
						a2input(la('prevPasE'),'pass1',0,0,NULL,la('prevPasE'));
						a2input(la('new2'),'pass2',0,0,NULL,la('new2'));
						a2input(la('repPrevP'),'pass3',0,0,NULL,la('repPrevP'));
						?> <div class="page-header col-sm-offset-2">
							<h4><?=la('pVisibil')?></h4>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v1"><?=la('toEveryo')?></label>
							<div class="col-sm-9">
								<input id="a2v1" type="radio" value="0" name="vis"
									<?php if(!isset($row['vis']) || $row['vis']==0) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v2"><?=la('toLogInU')?></label>
							<div class="col-sm-9">
								<input id="a2v2" type="radio" value="1" name="vis"
									<?php if($row['vis']==1) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v3"><?=la('toNowbod')?></label>
							<div class="col-sm-9">
								<input id="a2v3" type="radio" value="2" name="vis"
									<?php if($row['vis']==2) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" name="submit_2" class="btn btn-goldi"><?=la('save')?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php
		}
		else if($u2){//showwing other's profile
			que('SELECT * FROM '.$users.' WHERE id="'.$id2.'"');
			$row=mysql_fetch_array($res);
			if($row['vis']==0 || ($row['vis']==1 && _ID_==-1)){
				if(_ID_!=-1){
					?>
					<ul class="nav nav-tabs" style="margin: 0 -15px;">
						<li><a href="<?=$location?>profile/?id=<?=_ID_?>"><?=la('profile')?></a></li>
						<li><a href="<?=$location?>profile/?d=all"><?=la('users')?></a></li>
					</ul>
					<?php
				}?>
				<div class="row">
					<div style="width: 100vw;overflow: hidden;padding-bottom: 25%;position: relative;background-color:#fff;background-image:url(<?=getAva($row['login'],1,'https://s8.hostingkartinok.com/uploads/images/2018/04/a6dbabae92235fd3da34949d2ad32de2.jpg')?>);background-size:cover;background-position: center;"></div>
					<div class="l col-xs-3" style="margin-left: 5vw;height: 25vw;margin-top: -20vw;overflow: hidden;border: 10px solid #fff;background:#fff;border-radius: 100vw;background-image:url(<?=getAva($row['login'])?>);background-size:auto 100%;background-position: center;"></div>
						<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;"><?php echo getName($row['id']); ?></div>
				</div>
				<div class="form-horizontal">
				<?php
					op2(la('aboutYou'),'about');
					op2(la('birText2'),'u_date');
					op2(la('addressT'),'city');
					op2(la('email'),'email');
					op2(la('phoneNum'),'phone');
					op2('facebook');
					op2('youtube');
					op2('twitter');
					op2('instagram');
					op2('pinterest');
			}
			else if($row['vis']==1)
				alert(la('logInTVi').'. <a href="'.$location.'login/">'.la('logInTe2').'</a>','danger');
			else
				alert(la('private').'!','danger');
		}
		else err();
	}
	else if($_GET['d']=='all'){
		$q='SELECT id,login,email,about,phone,u_date,facebook,youtube,twitter,pinterest,city FROM '.$users;
		que($q);
		$u=mysql_num_rows($res);
		$q.=' WHERE vis';
		if(_ID_!=-1){ ?>
			<ul class="nav nav-tabs" style="margin: 0 -15px;">
				<li><a onclick="redir('<?=$location?>profile/?id='+<?=$row['id']?>)"><?=la('profile')?></a></li>
				<li class="active"><a><?=la('users')?></a></li>
				<li><a onclick="redir('<?=$location?>profile/out.php')"><?=la('logOut')?></a></li>
			</ul> <?php
			$q.='!=2';
		}
		else
			$q.='=0';
		$ras=mysql_query($q);
		?><div class="page-header col-sm-12">
			<h2><?=la('users')?></h2>
			<h4><?=la('usersCou')?>: <?=$u?> <?=la('usersTe1')?>.<?php
			if(_ID_==-1)
				echo la('usersTe2');
			?></h4>
			<div class="r">
				<a href="index.php?d=all&view=1" class="hideble btn btn-goldi<?php
						if($_GET['view']!=2)
							echo ' active'; ?>
					">
					<span class="	glyphicon glyphicon-th-large"></span>
				</a>
				<a href="index.php?d=all&view=2" class="hideble btn btn-goldi<?php
						if($_GET['view']==2)
							echo ' active'; ?>
					">
					<span class="glyphicon glyphicon-th-list"></span>
				</a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row"><?php
				while($raw=mysql_fetch_array($ras)){
					?><div class="disp-fir col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<a class="thumbnail" href="<?=$location?>profile/?id=<?=$raw['id']?>">
							<div style="position: relative; padding-bottom: 100%; overflow: hidden;">
								<img style="position: absolute; top: 0; left: 0; width: 100%; min-height: 100%;" src="<?=getAva($raw['login'])?>" alt="<?=$raw['id']?>">
							</div>
							<div class="caption text-center">
								<h3><?=getName($raw['id'])?></h3>
							</div>
						</a>
					</div>
					<div class="disp-sec col-xs-12">
						<a class="thumbnail l" style="width:100%;position:relative;" href="<?=$location.'profile/?id='.$raw['id']?>">
							<div class="col-xs-2 l" style="border-radius: 100vh; position: relative; padding-bottom: 16.66667%; overflow: hidden;">
								<img style="padding: 0; position: absolute; top: 0; left: 0; width: 100%; min-height: 100%;" src="<?=getAva($raw['login'])?>" alt="<?=$raw['id']?>">
							</div>
							<div class="col-xs-10 l"><?php
								echo '<h3>'.getName($raw['id']).'</h3>
								<p>'.$raw['email'].'</p>';
								if(isset($raw['about']))
									echo '<p>'.$raw['about'].'</p>';
								if(isset($raw['phone']))
									echo '<p>'.$raw['phone'].'</p>';
								if(isset($raw['u_date']))
									echo '<p>'.$raw['u_date'].'</p>';
								if(isset($raw['facebook']))
									echo '<p>'.$raw['facebook'].'</p>';
								if(isset($raw['youtube']))
									echo '<p>'.$raw['youtube'].'</p>';
								if(isset($raw['twitter']))
									echo '<p>'.$raw['twitter'].'</p>';
								if(isset($raw['pinterest']))
									echo '<p>'.$raw['pinterest'].'</p>';
								if(isset($raw['city']))
									echo '<p>'.$raw['city'].'</p>';
							?></div>
						</a>
					</div><?php
				}
			?></div>
		</div><?php
		if(!isset($_GET['view']))
			$_GET['view']=1;
		?><script>
			$(window).resize( function(){
				if($(window).width()<"900"){
					$('.disp-sec').hide();
					$('.disp-fir').show();
					$('.hideble').hide();
				}
				if($(window).width()>"900" && <?=$_GET['view']?>==2){
					$('.disp-sec').show();
					$('.disp-fir').hide();
					$('.hideble').show();
				}
			})
			if(<?=$_GET['view']?>==2)
				$('.disp-fir').hide();
			else
				$('.disp-sec').hide();
			if($(window).width()<"900")
				$('.hideble').hide();
		</script><?php
	}
	else if($_GET['d']!='all' && $buf!=10 && !isset($_GET['id']) && $_GET['lang']!=-1){
		if(_ID_!=-1)
			header("Location: ".$location."profile/?id="._ID_);
		else
			alert('<a href="'.$location.'login">'.la('logInTe2').'</a><br><a href="'.$location.'register">'.la('register').'</a>','info');
	}
	else if($_GET['lang']!=-1)
		err();
}
?>