<?php
global $paslist,$file;
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
	$str='Користувача не знайдено!<br><a href=\"'.$location.'\">Повернутися на головну</a><br><a href=\"'.$location;
	if(_ID_!=-1)
		$str.='profile/?id='._ID_.'\">Перейти в свій акаунт';
	else 
		$str.='login\">Ввійти в акаунт</a><br><a href=\"'.$location.'register\">Реєстрація';
	$str.='</a></div>';
	alert($str,'danger');
}
function a_link($names){
	global $row, $users;
	if(isset($_POST[$names]) && $_POST[$names]!=$row[$names]){
		if(preg_match('/^[a-zA-Z0-9_:#\/\?\&\.]{9,255}$/', $_POST[$names])){
			alert(''.ucfirst($names).' акаунт успішно додано','success');
			que('UPDATE '.$users.' SET '.$names.'="'.$_POST[$names].'" WHERE id="'._ID_.'"');
		}
		else
			alert('Вкажтіть правильне посилання на ваший '.ucfirst($names).' акаунт','danger');
	}
}
function socialm($name){
	global $row;
	a2input(ucfirst($name),strtolower($name),0,0,$row[$name],ucfirst($name));
}
function o($domain='mambo.in.ua'){
	setcookie("hesh", NULL, -1, "/", $domain);
	header("Location: {$_SERVER['HTTP_REFERER']}");
	alert('Ви успішно вийшли!<br>Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, натисніть <a href="'.$_SERVER['HTTP_REFERER'].'">сюди</a>','success');
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
					alert('Пройдіть перевірку на робота (капчу)','danger');
				else $i=0;
			}
			else
				alert('Пройдіть перевірку на робота (капчу)','danger');
		}
		else if ($u1==1 || $u2==1){
			$ip=$_SERVER['REMOTE_ADDR'];
			if($row['ip']!=$ip && $ip!=$row['r_ip'])
				que("UPDATE ".$users." SET prev_ip='".$ip."' WHERE id='".$id."'");
			alert('Ви успішно ввійшли!','success');
			$que="UPDATE ".$users." SET ip='".$ip."', hesh='".$hesh."', date='".date('H:i:s d:m:y')."'";
			if(isset($_POST['screenRes']))
				$que.=", screen_resul='".correct($_POST['screenRes'])."'";
			$que.=" WHERE id='".$id."'";
			que($que);
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
			$is_loggined=1;
			$i=0;
			if($row['ip']!=$ip && $ip==$row['r_ip'])
				alert('У ваший акаунт входили о '.$row['date'].' (секунда:хвилина:година день:місяць:рік) з даної ip адреси: '.$row['ip'],'danger');
			else {
				alert('Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, натисніть <a href=\"'.$location.'\">сюди</a>','warning');
				header('Location: '.$location.'');
			}
			echo '</p>';
		}
		else {
			alert('Неправильний логін/пароль','danger');
			$is_loggined=0;
			setcookie("hesh", NULL, -1, "/", $domain); 
			$i=$_POST['i']+1;
		}
	}
	else if(_ID_!=-1)
		header("Location: {$_SERVER['HTTP_REFERER']}");
	if(!$is_loggined){
		?><br><form class="form-horizontal" method="post" action="<?=$location?>login/"><?php
			a2input('Логін','login',0,1,$_POST['login'],'Логін/Пошта','maxlenght="20" autofocus');
			a2input('Пароль','pass',1,1,NULL,'Пароль','autocomplete="off" maxlenght="40"');
			if($i>2)
				echo '<div class="form-group">
					<label class="control-label col-sm-2" for="a2email">Капча:</label>
					<div class="col-sm-9">
						<div class="g-recaptcha" data-sitekey="6LfnjSIUAAAAANkRfSYdlIGK4H4sveFTjeOIdysV"></div>
					</div>
				</div>';
			?>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9 btn-group">
					<button type="submit" class="btn btn-goldi">Вхід</button>
					<a href="<?=$location?>register/" class="btn btn-goldi">Реєестрація</a>
					<a href="<?=$location?>register/conf.php?d=40" class="btn btn-goldi">Забули пароль?</a>
				</div>
			</div>
			<input type="hidden" name="link" value="<?=$link?>">
			<input type="hidden" id="screenRes" name="screenRes" value="0">
			<script>
				$('#screenRes').val(window.screen.availWidth+"X"+window.screen.availHeight);
			</script>
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
		$mail='Дякуємо за реєстрацією в офіційному сайті MAMBO (mambo.in.ua). Для підтвердження пошти, перейдіть по цьому посиланню - ';
	if(!isset($_POST['login']) && !isset($_POST['pass']) && !isset($_POST['login']) && !isset($_POST['d_pass']) && !isset($_POST['email']))
		$d=1;
	else {
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$d=0;
		if(!preg_match("/^[a-z@-Z0-9_]{3,20}$/",$login)){
			$d=1;
			alert('Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри','danger');
		}
		if(!preg_match("/^[a-zA-Z0-9_\-]{6,40}$/",$pass)){
			$d=1;
			alert('Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри','danger');
		}
		if($pass!=$_POST['d_pass']){
			$d=1;
			alert('Паролі не збігаються!','danger');
		}
		$login=correct($login);
		$pass=correct($pass);
		que("SELECT id FROM ".$users." WHERE login='".$login."'");
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u!=0){
			$d=1;
			alert('Логін зайнятий! Спробуйте інший','danger');
		}
		if($login==$pass){
			$d=1;
			alert('Логін/пароль не повині співпадати','danger');
		}
		for($i=0;$i<=count($paslist);$i++)
			if($paslist[$i]==$pass && isset($pass)) $er=1;
		for($i=1;$i<=strlen($pass);$i++)
			if($pass[$i]!=$pass[0]) $er=2;
		if($er!=2 || $er==1){
			$d=1;
			alert('Пароль надто простий!','danger');
		}
		$email=strtolower(correct($_POST['email']));
		if(validEmail($email)){
			que("SELECT id FROM ".$users." WHERE email='".$email."'");
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			if($u!=0){
				$d=1;
				alert('Електронна адреса зайнята! Спробуйте ввести іншу','danger');
			}
		}
		else {
			$d=1;
			alert('Введіть правильну електронну адресу','danger');
		}
		que('SELECT id FROM '.$users.' WHERE r_ip="'.$_SERVER['REMOTE_ADDR'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u>5){
			$d=1;
			alert('З даної ip адреси зареєстровано забагато акаунтів','danger');
		}
		if($d==0){
			$login=str_rot13($login);
			$pas=str_rot13($pass);
			$hesh=md5($login).md5('Ag5l').md5($pas);
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
			alert('Ви успішно створили акаунт!','success');
			que("INSERT INTO ".$users."(login,val,ip,r_date,email,hesh) VALUES ('".$login."','".$pas."','".$_SERVER['REMOTE_ADDR']."','".date('H:i:s d:m:y')."','".$email."','".$hesh."')");
		}
	}
	if($d==1){
		?>
		<br><form class="form-horizontal" method="post" action="<?=$location?>register/"><?php
			a2input('Логін','login',0,1,$_POST['login'],'Логін','maxlenght="20" autofocus');
			a2input('Пароль','pass',1,1,NULL,'Пароль','autocomplete="off" maxlenght="40"');
			a2input('Повторити пароль','d_pass',1,1,NULL,'Повторити пароль','autocomplete="off" maxlenght="40"');
			a2input('Пошта','email',2,1,$_POST['email'],'E-mail','maxlenght="30"');
			?>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9">
					<button type="submit" class="btn btn-goldi">Реєестрація</button>
					<a href="<?=$location?>login/" class="btn btn-goldi">Вхід</a>
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
				if(!preg_match("/^[a-zA-Z0-9-_]+$/",$login)){
					$d=1;
					alert('Логін може містити тільки букви латинського алфавіту та цифри','danger');
				}
				if(strlen($login) < 3 or strlen($login) > 20){
					$d=1;
					alert('Логін повинен бути в межах від 3 до 20 символів','danger');
				}
				if(!validExtLat($pass)){
					$d=1;
					alert('Пароль може містити тільки букви латинського алфавіту та цифри','danger');
				}
				if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					alert('Пароль повинен бути в межах від 6 до 40 символів','danger');
				}
				if($login==$pass){
					$d=1;
					alert('Логін/пароль не повині співпадати','danger');
				}
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					alert('Пароль надто простий!','danger');
				}
				if($d==0){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13(correct($login))."'");
					$u=mysql_num_rows($res);
					if($u!=0){
						$d=1;
						if(str_rot13($l)==$login)
							alert('Цей логін вже використовується в вашому акаунті','danger');
						else
							alert('Логін зайнятий! Спробуйте інший','danger');
					}
					else if($p==str_rot13($pass)){
						$d=1;
						alert('Цей пароль вже використовується в вашому акаунті','danger');
					}
					else {
						$code_f=$codes[0].'::'.$codes[2].':'.$codes[3];
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'", prev_pas=val, login="'.str_rot13($login).'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert('Логін та пароль успішно змінені<br><a href="'.$location.'/">Головна</a><br><a href="'.$location.'/profile/">Профіль</a>','success');
					}
				}
			}
			if($d==1 || !isset($_POST['login'])) {
				if($codes[1]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=37&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input('Логін','login',0,1,$_POST['login'],'Логін');
						a2input('Пароль','val',1,1,NULL,'Пароль');
						echo	'<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">Готово</button>
							</div>
						</div>
					</form>';
				}
				else
					alert('Посилання використано або неробоче','danger');
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
							alert('Ця електронна адреса вже прив\'язана до вашого акаунту! Спробуйте ввести іншу','danger');
						else
							alert('Електронна адреса зайнята! Спробуйте ввести іншу','danger');
					}
					que("SELECT id FROM ".$users." WHERE val='".correct(str_rot13($_POST['val']))."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0 && $rowd['id']==$_GET['i']){
						$d=1;
						alert('Цей пароль вже використовується в вашому акаунті! Спробуйте інший','danger');
					}
				}
				else {
					$d=1;
					alert('Введіть правильну електронну адресу','danger');
				}
				if($d==0){
					$pass=$_POST['val'];
					if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
						$d=1;
						alert('Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри','danger');
					}
					for($i=0;$i<=count($paslist);$i++)
						if($paslist[$i]==$pass && isset($pass)) $er=1;
					for($i=1;$i<=strlen($pass);$i++)
						if($pass[$i]!=$pass[0]) $er=2;
					if($er!=2 || $er==1){
						$d=1;
						alert('Пароль надто простий!','danger');
					}
					if($d==0){
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':';
						que('UPDATE '.$users.' SET conf=1, prev_pas=val, conf_c="'.$code_f.'", email="'.$_POST['email'].'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert('Пошта та пароль успішно змінені','success');
					}
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=38&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input('Нова пошта','email',2,1,$_POST['email'],'E-mail');
						a2input('Нова пароль','val',1,1,NULL,'Пароль');
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">Готово</button>
							</div>
						</div>
					</form>';
				}
				else
					alert('Посилання використано або неробоче','danger');
			}
		}
		else if($_GET['d']==39){//erase pas
			if(isset($_POST['val'])){
				que('SELECT val FROM '.$users.' WHERE id="'.$_GET['i'].'"');
				$row=mysql_fetch_array($res);
				$u=mysql_num_rows($res);
				$pass=$_POST['val'];
				$d=0;
				if(!validExtLat($pass)){
					$d=1;
					alert('Пароль може містити тільки букви латинського алфавіту та цифри','danger');
				}
				else if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					alert('Пароль повинен бути в межах від 6 до 40 символів','danger');
				}
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					alert('Пароль надто простий!','danger');
				}
				$pass=correct($pass);
				if($d==0){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($p==str_rot13($pass)){
						$d=1;
						alert('Цей пароль вже використовується в вашому акаунті','danger');
					}
					else {
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].'::';
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'", prev_pas=val, val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						alert('Пароль успішно скинуто<br><a href="'.$location.'/">Головна</a><br><a href="'.$location.'/profile/">Профіль</a>','success');
					}
				}
			}
			if($d==1 || !isset($_POST['val'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'" method="post">';
						a2input('Новий пароль','val',1,1,NULL,'Пароль');
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">Готово</button>
							</div>
						</div>
					</form>';
				}
				else
					alert('Посилання використано або неробоче','danger');
			}
		}
		else if($_GET['d']==40){//forgot pass
			if(isset($_POST['email'])){
				if(validEmail($_POST['email'])){
					que("SELECT id FROM ".$users." WHERE email='".strtolower(correct($_POST['email']))."'");
					$u=mysql_num_rows($res);
					if($u==0){
						$d=1;
						alert('Ця електронна адреса не прив\'язана до жодного акаунту','danger');
					}
					else if($d==0){
						$code=substr(md5(microtime()),rand(0,26),5);
						$codes=preg_split('/:/',$row['conf_c']);
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
						que('SELECT id FROM '.$users.' WHERE email="'.$_POST['email'].'"');
						$rowd=mysql_fetch_array($res);
						$message='Відновлення паролю в '._NAME_.' ('.$domain.'). Якщо це зробили ви, перейдіть по посиланню, щоб завершити процес:'.$location.'register/conf.php?d=39&i='.$rowd['id'].'&c='.$code.' . В іншому випадку нічого робити не потрібно';
						mail($_POST['email'],'Відновлення паролю - '._NAME_,$message,'', "Content-Type: text/html; charset='utf-8'");
						que('UPDATE '.$users.' SET conf_c="'.$code_f.'" WHERE id="'.$rowd['id'].'"');
						alert('На вказану пошту прийшло повідомлення для відновленення паролю','warning');
					}
				}
				else {
					$d=1;
					alert('Введіть правильну електронну адресу','danger');
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c']){
					echo '<br><form class="form-horizontal" action="conf.php?d=40" method="post">';
						a2input('Пошта','email',0,1,$_POST['email'],'Пошта');
						echo '<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-goldi">Готово</button>
							</div>
						</div>
					</form>';
				}
				else
					alert('Посилання використано або неробоче','danger');
			}
		}
		else {//confirm email
			que("SELECT conf,r_date,conf_c FROM ".$users." WHERE id='".$_GET['i']."'");
			$row=mysql_fetch_array($res);
			if($row['conf']!=1 && $codes[0]==$_GET['c']){
				$code_f=':'.$codes[1].':'.$codes[2].':'.$codes[3];
				que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'" WHERE id="'.$_GET['i'].'"');
				alert('Пошта успішно підтверджена. Дякуємо!<br>Щоб перейти на головну сторінку, натисніть <a href="'.$location.'">сюди</a><br>Щоб перети в ваший профіль, натисніть <a href="'.$location.'profile/">сюди</a>','success');
			}
			else
				alert('Посилання використано або неробоче.','danger');
		}
	}
	else
		alert('Посилання використано або неробоче','danger');
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
			?> <ul class="nav nav-tabs">
				<li<?=$but1?>><a data-toggle="tab" href="#tab1" aria-expanded="true">Профіль</a></li>
				<li<?=$but2?>><a data-toggle="tab" href="#tab2" aria-expanded="false">Безпека</a></li>
				<li><a onclick="redir('<?=$location?>profile/?d=all')">Користувачі</a></li> <?php
				if($row['type']>1) echo '<li><a onclick="redir(\''.$location.'adm/\')">Адміністрування</a></li>';
				?> <li><a onclick="redir('<?=$location?>profile/out.php')">Вихід</a></li>
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
								alert('Логін зайнятий! Спробуйте інший','danger');
							}
							else if(preg_match("/^[a-zA-Z0-9+-_]{3,60}$/",$_POST['login'])){
								alert('Логін успішно змінений','success');
								$code=substr(md5(microtime()),rand(0,26),5);
								if($mail2==NULL)
									$mail2='Ім\'я вашого акаунту в '.$name.' ('.$domain.') змінено. Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть за цим посиланням щоб змінити логін на попередній та захистити свій акаунт: '.$location.'register/conf.php?d=37&i='.$row['id'].'&c='.$code.' .';
								mail($row['email'],"Зміна логіну - ".$name,$mail2,"", 'Content-Type: text/html; charset="utf-8"');
								que("SELECT conf_c FROM ".$users." WHERE id='"._ID_."'");
								$row3=mysql_fetch_array($res);
								$code=substr(md5(microtime()),rand(0,26),5);
								$codes=preg_split('/:/',$row3['conf_c']);
								$code_f=$codes[0].':'.$code.':'.$codes[2].':'.$codes[3];
								que('UPDATE '.$users.' SET conf_c="'.$code_f.'", login="'.str_rot13($_POST['login']).'" WHERE id="'._ID_.'"');
							}
							else
								alert('Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри','danger');
						}
						if(isset($_POST['email']) && $row['email']!=$_POST['email']){
							if(validEmail($_POST['email'])){
								alert('Пошта успішно змінена. Щоб підтвердити пошту, потрібно перейти по посиланню яке ви отримали в листі на вказану ел. пошту','success');
								if($_POST['email']!='test@t_es.t'){
									$code=substr(md5(microtime()),rand(0,26),5);
									$code2=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$code2.':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.' SET conf=0, conf_c="'.$code_f.'", email="'.$_POST['email'].'" WHERE id="'._ID_.'"');
									if($mail1==NULL)
										$mail='Зміна пошти в '.$name.' ('.$domain.'). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити пошту на попередню та захистити свій акаунт - ';
									mail($row['email'],"Зміна пошти - ".$name,$mail1.$location.'register/conf.php?i='.$id.'&d=38&c='.$code,"", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else
								alert('Пошта повина містити лише латинські букви, цифри та бути в форматі "name@domain.com"','danger');
						}
						if(isset($_POST['phone']) && $_POST['phone']!='' && $_POST['phone']!=$row['phone']){
							if(preg_match('/^\+[0-9]{0,20}$/', $_POST['phone'])){
								que('UPDATE '.$users.' SET phone="'.$_POST['phone'].'" WHERE id="'._ID_.'"');
								alert('Телефон успішно додано!','success');
							}
							else
								alert('Номер телефону повинен бути в міжнародному форматі (+380501234567)','danger');
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
									alert('Аватарка повина бути меншою за 3 мб. <a target="_blank" href="https://kraken.io/web-interface">Скористайтеся сервісом стисненя зображень</a>','danger');
								else {
									unlink('../images/p/'.str_rot13($row['login']).'.jpg');
									unlink('../images/p/'.str_rot13($row['login']).'.gif');
									unlink('../images/p/'.str_rot13($row['login']).'.png');
									unlink('../images/p/'.str_rot13($row['login']).'.tiff');
									move_uploaded_file($_FILES['avatar']['tmp_name'],'../images/p/'.str_rot13(_LOGIN_).'.'.pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
									alert('Ваша аватарка успішно змінена. Оновіть сторінку','success');
									$src2=NULL;
								}
							}
							else
								alert('Аватарка повина бути в форматі jpg, giff, png або tiff','danger');
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
									alert('Фонове зображення повино бути меншим за 3 мб. <a target="_blank" href="https://kraken.io/web-interface">Скористайтеся сервісом стисненя зображень</a>','danger');
								else {
									unlink('../images/p/b_'.str_rot13($row['login']).'.jpg');
									unlink('../images/p/b_'.str_rot13($row['login']).'.gif');
									unlink('../images/p/b_'.str_rot13($row['login']).'.png');
									unlink('../images/p/b_'.str_rot13($row['login']).'.tiff');
									move_uploaded_file($_FILES['backg']['tmp_name'],'../images/p/b_'.str_rot13(_LOGIN_).'.'.pathinfo($_FILES['backg']['name'], PATHINFO_EXTENSION));
									alert('Фонове зображення успішно змінено. Оновіть сторінку','success');
								}
							}
							else
								alert('Фонове зображення повино бути в форматі jpg, giff, png або tiff','danger');
						}
						a_link('facebook');
						a_link('youtube');
						a_link('twitter');
						a_link('instagram');
						a_link('vk');
						que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
						$row=mysql_fetch_array($res);
						if($_POST['u_name']!=$row['u_name']){
							if(validForbit($_POST['u_name']) && strlen($_POST['u_name'])<30){
								que('UPDATE '.$users.' SET u_name="'.$_POST['u_name'].'" WHERE id="'._ID_.'"');
								alert('Ім\'я успішно змінено','success');
							}
							else
								alert('Введіть правильне ім\'я','danger');
						}
						if($_POST['u_surname']!=$row['u_surname']){
							if(validForbit($_POST['u_surname']) && strlen($_POST['u_surname'])<30){
								que('UPDATE '.$users.' SET u_surname="'.$_POST['u_surname'].'" WHERE id="'._ID_.'"');
								alert('Прізвище успішно змінено','success');
							}
							else
								alert('Введіть правильне прізвище','danger');
						}
						if($_POST['city']!=$row['city']){
							if(validForbit($_POST['city']) && strlen($_POST['city'])<65){
								que('UPDATE '.$users.' SET city="'.$_POST['city'].'" WHERE id="'._ID_.'"');
								alert('Місце проживання успішно змінено','success');
							}
							else
								alert('Введіть правильне місце проживання','danger');
						}
						if($_POST['edu']!=$row['edu']){
							if(validForbit($_POST['edu']) && strlen($_POST['edu'])<65){
								que('UPDATE '.$users.' SET edu="'.$_POST['edu'].'" WHERE id="'._ID_.'"');
								alert('Навчальний заклад успішно змінено','success');
							}
							else
								alert('Введіть правильний навчальний заклад','danger');
						}
						if($_POST['u_date']!=$row['u_date']){
							if(!isset($_POST['u_date']) || !preg_match("/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/", date('Y-m-d',strtotime($_POST['u_date']))) || strlen($_POST['u_date'])!=10)
								alert('Введіть правильну дату народження в форматі: мм/дд/рррр','danger');
							else {
								que('UPDATE '.$users.' SET u_date="'.date('Y-m-d',strtotime($_POST['u_date'])).'" WHERE id="'._ID_.'"');
								alert('Дату народження успішно змінено','success');
							}
						}
						if($_POST['about']!=$row['about']){
							if(!isset($_POST['about']) || !validLight($_POST['about']) || strlen($_POST['about'])>255)
								alert('Наступні символи недопустимі в полі "про себе" : %, \, *, @, #, ^, <, >, &, {, }, |, \, /, [, ]. Максимальна довжина : 255 символів','danger');
							else {
								que('UPDATE '.$users.' SET about="'.$_POST['about'].'" WHERE id="'._ID_.'"');
								alert('Поле "про себе" успішно змінено','success');
							}
						}
					}
					que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
					$row=mysql_fetch_array($res);
					?><div class="row">
	    	<div style="width: 100vw;overflow: hidden;padding-bottom: 39%;position: relative;height: 25vw;background-color:#fff;background-image:url(<?=getAva(_LOGIN_,1,'https://s8.hostingkartinok.com/uploads/images/2018/01/da87051aceec85e7fb7f4157c55e98ef.png')?>);background-size:cover;background-position: center;"></div>
						<div class="l col-xs-3" style="margin-left: 5vw;height: 25vw;margin-top: -20vw;overflow: hidden;border: 10px solid #fff;background:#fff;border-radius: 100vw;background-image:url(<?=getAva(_LOGIN_)?>);background-size:auto 100%;background-position: center;"></div>
						<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;"><?php echo getName(_ID_); ?></div>
					</div>
					<br><form class="form-horizontal" action="index.php?id=<?=$row['id']?>" enctype="multipart/form-data" method="post"> <?php
						a2input("Ім'я",'u_name',0,0,$row['u_name'],"Ім'я");
						a2input('Прізвище','u_surname',0,0,$row['u_surname'],'Прізвище');
						?><div class="form-group">
							<label class="control-label col-sm-2" for="a2u_date">Дата народження (мм/дд/рррр):</label>
							<div class="col-sm-9">
								<input class="form-control" id="a2u_date" type="date" name="u_date" value="<?=$row['u_date']?>" placeholder="мм/дд/рррр" min="1950-01-01" max="<?=date("Y")?>-01-01" pattern="[^\\\$\^\&\?\*\{\}\'\[\]]"<?php if(isset($row['u_date'])) echo ' requiered';?>>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2about">Про себе:</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" maxlength="255" id="a2about" name="about" placeholder="Про себе"><?=$row['about']?></textarea>
							</div>
						</div> <?php
						a2input('Місце проживання','city',0,0,$row['city'],'Місце проживання');
						a2input('Навчальний заклад','edu',0,0,$row['edu'],'Навчальний заклад');
						a2input('Логін','login',0,1,str_rot13($row['login']),'Логін');
						a2input('Номер телефону','phone',0,0,$row['phone'],'наприклад: +380501234567');
						socialm('facebook');
						socialm('youtube');
						socialm('twitter');
						socialm('instagram');
						socialm('vk');
						?>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2av">Змінити аватарку:</label>
							<div class="col-sm-9">
								<input id="a2av" type="file" accept="image/*" name="avatar">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2backg">Змінити фонове зображення:</label>
							<div class="col-sm-9">
								<input id="a2backg" type="file" accept="image/*" name="backg">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" name="submit_1" class="btn btn-goldi">Зберегти зміни</button>
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
									alert('Попередній пароль є неправильним','danger');
								}
								if($_POST['pass2']!=$_POST['pass3']){
									$e=1;
									alert('Нові паролі не співпадають','danger');
								}
								if($_POST['pass1']==$_POST['pass2']){
									$e=1;
									alert('Попередній пароль та новий не повинен співпадати','danger');
								}
								if(!preg_match("/^[a-zA-Z0-9\-_]{6,40}$/",$_POST['pass2'])){
									$e=1;
									alert('Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри','danger');
								}
								for($i=0;$i<=count($paslist);$i++)
									if($paslist[$i]==$_POST['pass2'] && isset($_POST['pass2']))
										$er=1;
								for($i=1;$i<=strlen($_POST['pass2']);$i++)
									if($_POST['pass2'][$i]!=$_POST['pass2'][0])
										$er=2;
								if($er!=2 || $er==1){
									$e=1;
									alert('Пароль надто простий!','danger');
								}
								if($e!=1){
									$pas=str_rot13($_POST['pass2']);
									$code=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.' SET conf_c="'.$code_f.'", prev_pas=val, val="'.$pas.'" WHERE id="'._ID_.'"');
									alert('Пароль успішно змінено','success');
									if($mail3==NULL)
										$mail3='Зміна паролю в '.$name.' ('.$domain.'). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити логін на попередній та захистити свій акаунт - ';
									mail($row['email'],"Зміна паролю - Mambo Shop",$mail3.$location.'register/conf.php?d=39&i='._ID_.'&c='.$code,"", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else
								alert('Щоб змінити пароль, потрібно вказати попередній пароль та новий два рази','danger');
							if($_POST['vis']!=$row['vis'] && $_POST['vis']!=NULL)
								que('UPDATE '.$users.' SET vis="'.$_POST['vis'].'" WHERE id='._ID_);
						}
						que('SELECT * FROM '.$users.' WHERE id="'._ID_.'"');
						$row=mysql_fetch_array($res);
						?><div class="page-header col-sm-offset-2">
							<h4>Зміна паролю</h4>
						</div><?php
						a2input('Попередній пароль','pass1',0,0,NULL,'Попередній пароль');
						a2input('Новий пароль','pass2',0,0,NULL,'Новий пароль');
						a2input('Повторити новий пароль','pass3',0,0,NULL,'Повторити новий пароль');
						?> <div class="page-header col-sm-offset-2">
							<h4>Видимість профілю</h4>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v1">Всім</label>
							<div class="col-sm-9">
								<input id="a2v1" type="radio" value="0" name="vis"
									<?php if(!isset($row['vis']) || $row['vis']==0) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v2">Тим, хто ввійшов в акаунт</label>
							<div class="col-sm-9">
								<input id="a2v2" type="radio" value="1" name="vis"
									<?php if($row['vis']==1) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2v3">Нікому</label>
							<div class="col-sm-9">
								<input id="a2v3" type="radio" value="2" name="vis"
									<?php if($row['vis']==2) echo ' checked';
										?> >
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" name="submit_2" class="btn btn-goldi">Зберегти зміни</button>
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
					<ul class="nav nav-tabs">
						<li><a href="<?=$location?>profile/?id=<?=_ID_?>">Профіль</a></li>
						<li><a href="<?=$location?>profile/?d=all">Користувачі</a></li>
					</ul>
					<?php
				}?>
				<div class="row">
					<div style="width: 100vw;overflow: hidden;padding-bottom: 39%;position: relative;height: 25vw;background-color:#fff;background-image:url(<?=getAva(_LOGIN_,1,'https://s8.hostingkartinok.com/uploads/images/2018/01/da87051aceec85e7fb7f4157c55e98ef.png')?>);background-size:cover;background-position: center;"></div>
					<div class="l col-xs-3" style="margin-left: 5vw;height: 25vw;margin-top: -20vw;overflow: hidden;border: 10px solid #fff;background:#fff;border-radius: 100vw;background-image:url(<?=getAva(_LOGIN_)?>);background-size:auto 100%;background-position: center;"></div>
						<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;"><?php echo getName(_ID_); ?></div>
				</div>
				<div class="form-horizontal">
				<?php
					op2('Про себе','about');
					op2('Дата народження','u_date');
					op2('Місце проживання','city');
					op2('Навчальний заклад','edu');
					op2('Пошта','email');
					op2('Номер телефону','phone');
					op2('facebook');
					op2('youtube');
					op2('twitter');
					op2('instagram');
					op2('vk');
			}
			else if($row['vis']==1)
				alert('Виконайте вхід в ваший акаунт, щоб побачити цей профіль. <a href="'.$location.'login/">Вхід</a>','danger');
			else
				alert('Цей профіль приватний!','danger');
		}
		else err();
	}
	else if($_GET['d']=='all'){
		$q='SELECT * FROM '.$users;
		que($q);
		$u=mysql_num_rows($res);
		$q.=' WHERE vis';
		if(_ID_!=-1){
			?>
			<ul class="nav nav-tabs">
				<li><a onclick="redir('<?=$location?>profile/?id='+<?=$row['id']?>)">Профіль</a></li>
				<li class="active"><a>Користувачі</a></li>
				<li><a onclick="redir('<?=$location?>profile/out.php')">Вихід</a></li>
			</ul>
			<?php
			$q.='!=2';
		}
		else
			$q.='=0';
		que($q);
		?><div class="page-header col-sm-12">
			<h2>Користувачі</h2>
			<h4>Загальна кількість зареєстованих користувачів: <?=$u?> В таблиці представленні ті з них, які відкрили видимість свого профілю.<?php
			if(!$is_log)
				?> Ввійдіть в свій акаунт, щоб подачити більше користувачів, отримати сповіщення про знижки та доступ до багатьох корисних можливостей<?php
			?></h4>
			<div class="r">
				<a href="index.php?d=all&view=1" class="hideble btn btn-goldi<?php
					if($_GET['view']!=2)
						?> active<?php
					?>">
					<span class="	glyphicon glyphicon-th-large"></span>
				</a>
				<a href="index.php?d=all&view=2" class="hideble btn btn-goldi<?php
					if($_GET['view']==2)
						?> active<?php
					?>">
					<span class="glyphicon glyphicon-th-list"></span>
				</a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row"><?php
				while($row=mysql_fetch_array($res)){
					?><div class="disp-fir col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<a class="thumbnail" href="<?=$location?>profile/?id=<?=$row['id']?>">
							<div style="position: relative; padding-bottom: 100%; overflow: hidden;">
								<img style="position: absolute; top: 0; left: 0; width: 100%; min-height: 100%;" src="<?=getAva($row['login'])?>" alt="<?=$row['id']?>">
							</div>
							<div class="caption text-center">
								<h3><?=getName($row['id'])?></h3>
							</div>
						</a>
					</div>
					<div class="disp-sec col-xs-12">
						<a class="thumbnail l" style="width:100%;position:relative;" href="<?=$location.'profile/?id='.$row['id']?>">
							<div class="col-xs-2 l" style="border-radius: 100vh; position: relative; padding-bottom: 16.66667%; overflow: hidden;">
								<img style="padding: 0; position: absolute; top: 0; left: 0; width: 100%; min-height: 100%;" src="<?=getAva($row['login'])?>" alt="<?=$row['id']?>">
							</div>
							<div class="col-xs-10 l"><?php
								echo '<h3>'.getName($row['id']).'</h3>
								<p>'.$row['email'].'</p>';
								if(isset($row['about']))
									echo '<p>'.$row['about'].'</p>';
								if(isset($row['phone']))
									echo '<p>'.$row['phone'].'</p>';
								if(isset($row['u_date']))
									echo '<p>'.$row['u_date'].'</p>';
								if(isset($row['facebook']))
									echo '<p>'.$row['facebook'].'</p>';
								if(isset($row['youtube']))
									echo '<p>'.$row['youtube'].'</p>';
								if(isset($row['city']))
									echo '<p>'.$row['city'].'</p>';
								if(isset($row['edu']))
									echo '<p>'.$row['edu'].'</p>';
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
	else if($_GET['d']!='all' && $buf!=10 && !isset($_GET['id'])){
		if(_ID_!=-1)
			header("Location: ".$location."profile/?id="._ID_);
		else
			alert('<a href="'.$location.'login">Ввійти в акаунт</a><br><a href="'.$location.'register">Реєстрація</a>','info');
	}
	else err();
}
?>