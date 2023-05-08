<?php
#function is_em($mail) {
#function l($link,$location,$users,$domain="mambo.in.ua"){
#function r($users, $location, $domain="mambo.in.ua", $rules_url="http://shop.mambo.in.ua/faq/?t=rules"){
#function co($users, $location,$i,$c,$de){
#function p($location,$users='users',$domain="mambo.in.ua"){
function is_em($m) {
	return preg_match("/^[A-Za-z0-9_\-]{3,20}@[A-Za-z0-9\-_]{3,10}(\.[A-Za-z0-9\-_]{2,6}){1,5}$/", $m);
}
function o($domain='mambo.in.ua'){
	setcookie("hesh", "deleted", time()-60*60*24*2, "/", $domain);
	header("Location: {$_SERVER['HTTP_REFERER']}");
	echo '<p class="title">Ви успішно вийшли!<br>Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, нажміть <a href="'.$_SERVER['HTTP_REFERER'].'">сюди</a>
			</p>';
}
function l($location,$users="users",$domain="mambo.in.ua"){
	echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
	include $location.'/functions/main.php';
	$d=1;
	if(isset($_POST["login"]) && isset($_POST["pass"])) {
		$login=str_rot13(preg_replace('/[^@-Za-z0-9\.+-_\-]/', '', $_POST['login']));
		$pas=str_rot13(preg_replace('/[^A-Za-z0-9+-_\-]/', '', $_POST['pass']));
		$hesh=md5($login).md5('Ag5l').md5($pas);
		$res = mysql_query("SELECT r_ip,date,ip,id,ip1,ip2 FROM ".$users." WHERE login='".$login."' AND val='".$pas."'") or die(mysql_error());
		$row=mysql_fetch_array($res);
		$u1=mysql_num_rows($res);
		if($u1!=1){
			$hesh=md5(str_rot13(strtolower($login))).md5('Ag5l').md5($pas);
			$res = mysql_query("SELECT r_ip,date,ip,id,ip1,ip2 FROM ".$users." WHERE email='".str_rot13(strtolower($login))."' AND val='".$pas."'") or die(mysql_error());
			$row=mysql_fetch_array($res);
			$u2=mysql_num_rows($res);
		}
		$i=$_POST['i'];
		$id=$row['id'];
		if($i>2){
			if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
				$r=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfnjSIUAAAAAMA1uDkemjvaiSlzB39R8KijOsZa&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
				if($r.success==false) echo '<br>Пройдіть перевірку на робота (капчу)';
				else $i=0;
			}
			else echo '<br>Пройдіть перевірку на робота (капчу)';
		}
		if($i<3){
			if ($u1==1 || $u2==1){
				if(strlen($row['ip2'])>10 && strlen($row['ip1'])>10 && $row['r_ip']!=$_SERVER['REMOTE_ADDR']){
					if($row['ip1']!=$_SERVER['REMOTE_ADDR'] && $row['ip2']!=$_SERVER['REMOTE_ADDR'])
						$q=1;
				}
				else if($row['ip1']!=$_SERVER['REMOTE_ADDR'] && strlen($row['ip1'])>10 && $row['r_ip']!=$_SERVER['REMOTE_ADDR'])
					$q=1;
				if($q==1)
					echo '<br>Доступ в акаунт заборонений через налаштування безпеки';
				else {
					$ip=$_SERVER['REMOTE_ADDR'];
					echo '<p class="title">Ви успішно ввійшли!<br>'.var_dump($row['date']);
					if($row['ip']!=$ip && $ip==$row['r_ip'])
						echo '<br>У ваший акаунт входили о '.$row['date'].' (секунда:хвилина:година день:місяць:рік) з даної ip адреси: '.$row['ip'];
					else {
						echo 'Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, нажміть <a href="'.$location.'">сюди</a><br>';
						header("Location: {$_SERVER['HTTP_REFERER']}");
					}
					echo '</p>';
					que("UPDATE ".$users." SET ip='".$ip."', hesh='".$hesh."', date='".date('H:i:s d:m:y')."' WHERE id='".$id."'");
					setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
					$is_loggined=1;
					$i=0;
				}
			}
			else {
				echo '<div class="war">Неправильний логін/пароль</div>';
				$is_loggined=0;
				setcookie("hesh", "", time()-60*60*24*2, "/", $domain); 
				$i=$_POST['i']+1;
			}
		}
	}
	else if(isset($_COOKIE['hesh'])){
		header("Location: ".$location);
	}
	if(!$is_loggined){
		?>
		<form id="login" method="post" action="<?=$location?>login/">
			<input class="f_i_t" name="login" type="text" autocomplete="on" maxlenght="20" required="required" placeholder="Логін/Пошта" autofocus>
			<input class="f_i_t" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
			<input type="hidden" name="link" value="<?=$link?>">
			<input type="hidden" name="i" value="<?=$i?>">
			<?php
			if($i>2) echo '<div class="g-recaptcha" data-sitekey="6LfnjSIUAAAAANkRfSYdlIGK4H4sveFTjeOIdysV"></div>';
			?>
			<a class="but l" href="<?=$location?>register/">Реєстрація</a>
			<a class="but l" href="<?=$location?>register/conf.php?d=40">Забули пароль?</a>
			<input class="but l" type="submit" value="Вхід">
		</form>
		<?php
	}
}
function r($users="users", $location, $domain="mambo.in.ua", $rules_url="http://shop.mambo.in.ua/faq/?t=rules", $confirm_location=NULL){
	if($confirm_location==NULL)
		$confirm_location=$location;
	if(!isset($_POST['login']) && !isset($_POST['pass']) && !isset($_POST['login']) && !isset($_POST['d_pass']) && !isset($_POST['email'])){
		$d=1;
	}
	else {
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$d=0;
		if(!preg_match("/^[a-z@-Z0-9+-_]{3,20}$/",$login)){
			$d=1;
			echo '<br>Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри';
		}
		if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
			$d=1;
			echo '<br>Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри';
		}
		if($pass!=$_POST['d_pass']){
			$d=1;
			echo '<br>Паролі не збігаються!';
		}
		que("SELECT id FROM ".$users." WHERE login='".mysql_real_escape_string($login)."'");
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u!=0){
			$d=1;
			echo '<br>Логін зайнятий! Спробуйте інший';
		}
		if($login==$pass){
			echo '<br>Логін/пароль не повині співпадати';
			$d=1;
		}
		$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
		for($i=0;$i<=count($paslist);$i++)
			if($paslist[$i]==$pass && isset($pass)) $er=1;
		for($i=1;$i<=count($pass);$i++)
			if($pass[$i]!=$pass[0]) $er=2;
		if($er!=2 || $er==1){
			$d=1;
			echo '<br>Пароль надто простий!';
		}
		if(is_em($_POST['email'])){
			que("SELECT id FROM ".$users." WHERE email='".mysql_real_escape_string($_POST['email'])."'");
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			if($u!=0){
				$d=1;
				echo '<br>Електронна адреса зайнята! Спробуйте ввести іншу';
			}
		}
		else {
			$d=1;
			echo '<br>Введіть правильну електронну адресу';
		}
		que('SELECT id FROM '.$users.' WHERE r_ip="'.$_POST['ip'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u>5){
			$d=1;
			echo '<br>З даної ip адреси зареєстровано забагато акаунтів';
		}
		if($d==0){
			$login=str_rot13($login);
			$pas=str_rot13($pass);
			$hesh=md5($login).md5('Ag5l').md5($pas);
			$code=substr(md5(microtime()),rand(0,26),5);
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain); 
			echo '<p class="title">Ви успішно створили акаунт!<br>Залишився останій крок: підтвердіть свою електронну адресу, перейшовши по посиланню, яке ви отримаєте в листі</p>';
			$is_loggined=1;
			$code_f=$code.':::';
			que("INSERT INTO ".$users." VALUES ('', '".$login."', '".$pas."', '".$_POST['ip']."','0', '".date('H:i:s d:m:y')."', '".date('H:i:s d:m:y')."', '".strtolower($_POST['email'])."', '".$_POST['ip']."','','".(date('z')+10)."', '1','".$code_f."','".$hesh."','1','','','','','','','','','','')");
			que('SELECT id FROM '.$users.' WHERE login="'.$login.'"');
			$row=mysql_fetch_array($res);
			$message='Дякуємо за реєстрацією в офіційному сайті MAMBO (mambo.in.ua). Для підтвердження пошти, перейдіть по цьому посиланню - '.$confirm_location.'register/conf.php?i='.$row['id'].'&c='.$code;
			mail($_POST['email'],"Підтвердження пошти - Mambo Shop",$message,"Content-Type: text/html; charset='utf-8'","From: max@patii.uk");
		}
	}
	if($d==1){
		?>
		<form id="login" method="post" action="<?=$location?>register/">
			<input class="f_i_t" name="login" type="text" value="<?=$_POST['login']?>" autocomplete="on" maxlenght="20" required="required" placeholder="Логін" autofocus>
			<input class="f_i_t" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
			<input class="f_i_t" name="d_pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Повторити пароль">
			<input class="f_i_t" name="email" type="text"  value="<?=$_POST['email']?>"autocomplete="on" maxlenght="30" required="required" placeholder="E-mail">
			<input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			<input type="hidden" name="link" value="<?=$link?>">
			<br>Ви ознайомлені з <a class="f-l-link" href="<?=$rules_url?>">правилами?</a><br>
			<a href="<?=$location?>login/" class="but l">Вхід</a>
			<input class="but l" type="submit" value="Реєстрація">
		</form>
		<?php
	}
}
function co($users, $location,$i,$c,$de){
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
		if($_GET['d']==37){
			if(isset($_POST['login']) && isset($_POST['val'])){
				que('SELECT login,val FROM '.$users.' WHERE id="'.$_GET['i'].'"');
				$row=mysql_fetch_array($res);
				$u=mysql_num_rows($res);
				$login=$_POST['login'];
				$pass=$_POST['val'];
				$d=0;
				if(!preg_match("/^[a-zA-Z0-9+-_]+$/",$login)){
					$d=1;
					echo '<br>Логін може містити тільки букви латинського алфавіту та цифри';
				}
				else if(strlen($login) < 3 or strlen($login) > 20){
					$d=1;
					echo '<br>Логін повинен бути в межах від 3 до 20 символів';
				}
				if(!preg_match("/^[a-zA-Z0-9+-_]+$/",$pass)){
					$d=1;
					echo '<br>Пароль може містити тільки букви латинського алфавіту та цифри';
				}
				else if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					echo '<br>Пароль повинен бути в межах від 6 до 40 символів';
				}
				if($d!=1){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($u2!=0){
						$d=1;
						if(str_rot13($l)==$login)
							echo '<br>Цей логін вже виористовується в вашому акаунті';
						else
							echo '<br>Логін зайнятий! Спробуйте інший';
					}
					if($p==str_rot13($pass)){
						$d=1;
						echo '<br>Цей пароль вже виористовується в вашому акаунті';
					}
				}
				if($login==$pass){
					echo '<br>Логін/пароль не повині співпадати';
					$d=1;
				}
				$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=count($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					echo '<br>Пароль надто простий!';
				}
				if($d==0){
					$code_f=$codes[0].'::'.$codes[2].':'.$codes[3];
					que('UPDATE '.$users.' SET conf_c="'.$code_f.'", login="'.str_rot13($login).'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
					echo '<p class="title">Логін та пароль успішно змінені<br><a href="'.$location.'">Головна</a><br><a href="'.$location.'profile/">Профіль</a></p>';
				}
			}
			if($d==1 || !isset($_POST['login'])) {
				if($codes[1]==$_GET['c'])
					echo '<form id="login" method="post" action="conf.php?d=37&i='.$_GET['i'].'&c='.$code.'">Логін:<input type="text" name="login" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br>Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br><input type="submit" value="Готово"></form>';
				else
					echo '<p class="title">Посилання використано або неробоче</p>';
			}
		}
		else if($_GET['d']==38){
			if(isset($_POST['email']) && isset($_POST['val'])){
				if(is_em($_POST['email'])){
					que("SELECT id FROM ".$users." WHERE email='".mysql_real_escape_string($_POST['email'])."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0){
						$d=1;
						if($rowd['id']==$_GET['i'])
							echo "<br>Ця електронна адреса вже прив'язана до вашого акаунту! Спробуйте ввести іншу";
						else
							echo '<br>Електронна адреса зайнята! Спробуйте ввести іншу';
					}
					que("SELECT id FROM ".$users." WHERE val='".mysql_real_escape_string(str_rot13($_POST['val']))."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0 && $rowd['id']==$_GET['i']){
						$d=1;
						echo "<br>Цей пароль вже використовується в вашому акаунті! Спробуйте інший";
					}
				}
				else {
					$d=1;
					echo '<br>Введіть правильну електронну адресу';
				}
				if($d==0){
					$pass=$_POST['val'];
					if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
						$d=1;
						echo '<br>Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри';
					}
					$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
					for($i=0;$i<=count($paslist);$i++)
						if($paslist[$i]==$pass && isset($pass)) $er=1;
					for($i=1;$i<=count($pass);$i++)
						if($pass[$i]!=$pass[0]) $er=2;
					if($er!=2 || $er==1){
						$d=1;
						echo '<br>Пароль надто простий!';
					}
					if($d==0){
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':';
						que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'", email="'.$_POST['email'].'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						echo '<p class="title">Пошта та пароль успішно змінені<br><a href="'.$location.'">Головна</a><br><a href="'.$location.'profile/">Профіль</a></p>';
					}
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c'])
					echo '<form id="login" method="post" action="conf.php?d=38&i='.$_GET['i'].'&c='.$code.'">Пошта:<input type="text" name="email" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br>Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br><input type="submit" value="Готово"></form>';
				else
					echo '<p class="title">Посилання використано або неробоче</p>';
			}
		}
		else if($_GET['d']==39){
			if(isset($_POST['val'])){
				que('SELECT val FROM '.$users.' WHERE id="'.$_GET['i'].'"');
				$row=mysql_fetch_array($res);
				$u=mysql_num_rows($res);
				$pass=$_POST['val'];
				$d=0;
				if(!preg_match("/^[a-zA-Z0-9+-_]+$/",$pass)){
					$d=1;
					echo '<br>Пароль може містити тільки букви латинського алфавіту та цифри';
				}
				else if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					echo '<br>Пароль повинен бути в межах від 6 до 40 символів';
				}
				if($d!=1){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($p==str_rot13($pass)){
						$d=1;
						echo '<br>Цей пароль вже виористовується в вашому акаунті';
					}
				}
				$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=count($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					echo '<br>Пароль надто простий!';
				}
				if($d==0){
					$code_f=$codes[0].':'.$codes[1].':'.$codes[2].'::';
					que('UPDATE '.$users.' SET conf_c="'.$code_f.'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
					echo '<p class="title">Пароль успішно скинуто<br><a href="'.$location.'">Головна</a><br><a href="'.$location.'profile/">Профіль</a></p>';
				}
			}
			if($d==1 || !isset($_POST['val'])) {
				if($codes[3]==$_GET['c'])
					echo '<form id="login" method="post" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'">Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br><input type="submit" value="Готово"></form>';
				else
					echo '<p class="title">Посилання використано або неробоче</p>';
			}
		}
		else if($_GET['d']==40){
			if(isset($_POST['email'])){
				if(is_em($_POST['email'])){
					que("SELECT id FROM ".$users." WHERE email='".mysql_real_escape_string($_POST['email'])."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u==0){
						$d=1;
						echo "<br>Ця електронна адреса не прив'язана до жодного акаунту";
					}
				}
				else {
					$d=1;
					echo '<br>Введіть правильну електронну адресу';
				}
				if($d==0){
					$code=substr(md5(microtime()),rand(0,26),5);
					$codes=preg_split('/:/',$row['conf_c']);
					$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
					echo $code_f.$rowd['id'];
					que('SELECT id FROM '.$users.' WHERE email="'.$_POST['email'].'"');
					$rowd=mysql_fetch_array($res);
					$message='Відновлення паролю в MAMBO SHOP (shop.mambo.in.ua). Якщо це зробили ви, перейдіть по посиланню, щоб завершити процес:'.$location.'register/conf.php?d=39&i='.$rowd['id'].'&c='.$code.' . В іншому випадку нічого робити не потрібно';
					mail($_POST['email'],"Відновлення паролю - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
					que('UPDATE '.$users.' SET conf_c="'.$code_f.'" WHERE id="'.$rowd['id'].'"');
					echo '<p class="title">На вказану пошту прийшло повідомлення для відновленення паролю</p>';
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c'])
					echo '<form id="login" method="post" action="conf.php?d=40">Пошта:<input type="text" name="email" value="'.$_POST['email'].'" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br><input type="submit" value="Готово"></form>';
				else
					echo '<p class="title">Посилання використано або неробоче</p>';
			}
		}
		else {
			que("SELECT conf,r_date,conf_c FROM ".$users." WHERE id='".$_GET['i']."'");
			$row=mysql_fetch_array($res);
			if($row['conf']!=1 && $codes[0]==$_GET['c']){
				$code_f=':'.$codes[1].':'.$codes[2].':'.$codes[3];
				que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'" WHERE id="'.$_GET['i'].'"');
				echo '<p class="title">Пошта успішно підтверджена. Дякуємо!<br>Щоб перейти на головну сторінку, натисніть <a href="'.$location.'">сюди</a><br>Щоб перети в ваший профіль, натисніть <a href="'.$location.'profile/">сюди</a></p>';
			}
			else echo '<p class="title">Посилання використано або неробоче</p>';
		}
	}
	else echo '<p class="title">Посилання використано або неробоче.</p>';
}
function p($location,$users='users',$domain="mambo.in.ua"){
	function a_link($name){
		global $id, $row;
		if(isset($_POST[$name]) && $_POST[$name]!=$row[$name]){
			if(preg_match('/^[a-zA-Z0-9_:#\/\?\&\.]{5,255}$/', $_POST[$name])){
				echo '<br>'.ucfirst($name).' акаунт успішно додано';
				que('UPDATE '.$users.'  SET '.$name.'="'.$_POST[$name].'" WHERE id="'.$id.'"');
			}
			else echo '<br>Вкажтіть правильне посилання на ваший '.ucfirst($name).' акаунт';
		}
	}
	function err(){
		global $id,$u;
		echo '<br>Користувача не знайдено!<br> <a href="'.$location.'">Повернутися на головну</a><br>.';
		if($u)
			echo '<a href="'.$location.'profile/?id='.$id.'">Перейти в свій акаунт</a>';
		else 
			echo '<a href="'.$location.'login">Ввійти в акаунт</a><br>
		<a href="'.$location.'register">Реєстрація</a>';
	}
	$hesh=preg_replace('/[^a-z0-9]/', '', $_COOKIE['hesh']);
	$res = mysql_query('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
	$row=mysql_fetch_array($res);
	$id=$row['id'];
		$u=$is_log=mysql_num_rows($res);//u = is logined
		$id2=preg_replace('/[^0-9]/', '', $_GET['id']);
		$res = mysql_query('SELECT * FROM '.$users.'  WHERE id="'.$id2.'"');
		$row2=mysql_fetch_array($res);
		$u2=mysql_num_rows($res);// does this profile exist
		if(isset($_GET['id']) && preg_match('/^[0-9]{1,6}$/', $_GET['id'])){
			if($u){
				if($_GET['id']==$id){
					?>
					<script>function redir(where) {window.location.href = where;}</script>
					<div class="tabs">
						<button id="b1" class="b cur" onclick="openC('a1', 'b1')">Профіль</button>
						<button id="b2" class="b" onclick="openC('a2', 'b2')">Безпека</button>
						<button id="b3" class="b" onclick="openC('a3', 'b3')">Додатково</button>
						<button onclick="redir('<?=$location?>profile/?d=all')">Користувачі</button>
						<button onclick="redir('<?=$location?>profile/out.php')">Вихід</button>
					</div>
					<div id="a1" class="tab_c">
						<?php
						que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
						$row=mysql_fetch_array($res);
						if (isset($_POST['login']) && str_rot13($row['login'])!=$_POST['login']){
							que("SELECT id FROM ".$users."  WHERE login='".str_rot13($_POST['login'])."'");
							$row2=mysql_fetch_array($res);
							$u=mysql_num_rows($res);
							if($u!=0){
								$d=1;
								echo '<br>Логін зайнятий! Спробуйте інший';
							}
							else if(preg_match("/^[a-zA-Z0-9+-_]{3,60}$/",$_POST['login'])){
								echo '<br>Логін успішно змінений.';
								$code=substr(md5(microtime()),rand(0,26),5);
								$message="Ім'я вашого акаунту в MAMBO SHOP (shop.mambo.in.ua) змінено. Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть за цим посиланням щоб змінити логін на попередній та захистити свій акаунт: ".$location."register/conf.php?d=37&i=".$row['id']."&c=".$code." .";
								echo var_dump(rename('../images/p/'.str_rot13($row['login']).'.'.$src,'../images/p/'.$_POST['login'].'.'.$src));
								mail($row['email'],"Зміна логіну - Mambo Shop",$message,"From: max@patii.uk", 'Content-Type: text/html; charset="utf-8"');
								que("SELECT conf_c FROM ".$users."  WHERE id='".$id."'");
								$row=mysql_fetch_array($res);
								$codes=preg_split('/:/',$row['conf_c']);
								$code_f=$codes[0].':'.$code.':'.$codes[2].':'.$codes[3];
								que('UPDATE '.$users.'  SET conf_c="'.$code_f.'", login="'.str_rot13($_POST['login']).'" WHERE id="'.$id.'"');
							}
							else echo '<br>Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри';
						}
						if (isset($_POST['email']) && $row['email']!=$_POST['email']){
							if(is_em($_POST['email'])){
								echo '<br>Пошта успішно змінена. Вам потрібно підтвердити її протягом 10 днів або ваший акаунт буде видалено (згідно з правилами магазину). Щоб підтвердити пошту, потрібно перейти по посиланню яке ви отримали в листі на вказану ел. пошту';
								if($_POST['email']!='test@t_est'){
									$code=substr(md5(microtime()),rand(0,26),5);
									$code2=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$code2.':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.'  SET conf=0, conf_c="'.$code_f.'", email="'.$_POST['email'].'" WHERE id="'.$id.'"');
									$message='Зміна пошти в MAMBO SHOP (shop.mambo.in.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити пошту на попередню та захистити свій акаунт:'.$location.'register/conf.php?i='.$id.'&d=38&c='.$code;
									echo $message;
									mail($row['email'],"Зміна пошти - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
									$message='Підтвердження пошти - MAMBO SHOP (shop.mambo.in.ua). Для підтвердження пошти, перейдіть по цьому посиланню - '.$location.'register/conf.php?i='.$id.'&c='.$code2;
									mail($_POST['email'],"Підтвердження пошти - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else echo '<br>Пошта повина містити лише латинські букви, цифри та бути в форматі "name@domain.com"';
						}
						if(isset($_POST['phone']) && $_POST['phone']!='' && $_POST['phone']!=$row['phone']){
							if(preg_match('/^\+[0-9]{0,20}$/', $_POST['phone'])){
								que('UPDATE '.$users.'  SET phone="'.$_POST['phone'].'" WHERE id="'.$id.'"');
								echo '<br>Телефон успішно додано!';
							}
							else echo '<br>Номер телефону повинен бути в міжнародному форматі (+380501234567)';
						}
						if($_FILES['file']['size']>0){
							switch($_FILES['file']['type']){
								case "image/jpeg":$src2="jpg";$t=1;break;
								case "image/gif":$src2="gif";$t=2;break;
								case "image/png":$src2="png";$t=3;break;
								case "image/tiff":$src2="tiff";$t=4;break;
							}
							if(isset($src2)){
								if($_FILES['file']['size']>1024*1024*3)
									echo '<br>Зображеня повино бути меншим за 3 мб. <a target="_blank" href="http://optimizilla.com/ru/">Скористайтеся сервісом стисненя зображень</a>';
								else {
									unlink('../images/p/'.str_rot13($row['login']).'.'.$src);
									move_uploaded_file($_FILES['file']['tmp_name'],'../images/p/'.str_rot13($row['login']).'.'.$src2);
									echo "<br>Ваша аватарка успішно змінена.";
									if($row['img']==0) echo " Обновіть сторінку";
									que('UPDATE '.$users.'  SET img="'.$t.'" WHERE id="'.$id.'"');
								}
							}
							else echo "<br>Зображення повино бути в форматі jpg, giff, png або tiff";
						}
						a_link('facebook');
						a_link('youtube');
						a_link('twiter');
						a_link('instagram');
						a_link('vk');
						/*profile start page*/	?>
						<img class="l_f l prof_img" src="<?=$srr?>">
						<form id="login" action="index.php?id=<?=$row['id']?>" enctype="multipart/form-data" method="post">
							Логін: <input class="f_i_t" type="text" name="login" required="required" value="<?=str_rot13($row['login'])?>" placeholder="Логін"><br>
							Пошта: <input class="f_i_t" type="text" name="email" required="required" value="<?=$row['email']?>" placeholder="Пошта"><br>
							Номер телефону (напр.: +380501234567): <input  class="f_i_t" type="text" name="phone" value="<?=$row['phone']?>" placeholder="Номер телефону"><br>
							Facebook: <input class="f_i_t" type="text" name="facebook" value="<?=$row['facebook']?>" placeholder="Facebook"><br>
							Youtube: <input class="f_i_t" type="text" name="youtube" value="<?=$row['youtube']?>" placeholder="Youtube"><br>
							Twiter: <input class="f_i_t" type="text" name="twiter" value="<?=$row['twiter']?>" placeholder="Twiter"><br>
							Instagram: <input class="f_i_t" type="text" name="instagram" value="<?=$row['instagram']?>" placeholder="Instagram"><br>
							Vk: <input class="f_i_t" type="text" name="vk" value="<?=$row['vk']?>" placeholder="Vk"><br>
							Змінити аватарку: <input type="file" accept="image/*" name="file"><br>
							<input type="submit" value="Зберегти зміни">
						</form>
					</div>
					<div id="a2" style="display:none" class="tab_c">
						<form method="post" id="login" action="index.php?id=<?=$row['id']?>">
							<?php
							que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
							$row=mysql_fetch_array($res);
							if (isset($_REQUEST['use_ip']) && ($_POST['ip1']!=$row['ip1'] || $_POST['ip2']!=$row['ip2'])){
								if($_POST['ip1']==$_POST['ip2']) echo '<br>IP адреси не повині співпадати';
								else {
									if((isset($_POST['ip1']) && preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_POST['ip1'])) || (isset($_POST['ip2']) && preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_POST['ip2']))){
										if(strlen($_POST['ip1'])>1 && strlen($_POST['ip2'])<1){
											que('UPDATE '.$users.'  SET ip1="'.$_POST['ip1'].'" WHERE id="'.$id.'"');
											echo '<br>IP адресу №1 успішно додано';
										}
										else if(strlen($_POST['ip2'])>1 && strlen($_POST['ip1'])<1){
											que('UPDATE '.$users.'  SET ip1="'.$_POST['ip2'].'" WHERE id="'.$id.'"');
											echo '<br>IP адресу успішно додано';
										}
										else {
											que('UPDATE '.$users.'  SET ip1="'.$_POST['ip1'].'", ip2="'.$_POST['ip2'].'" WHERE id="'.$id.'"');
											echo '<br>IP адреси №1 та №2 успішно додано';
										}
									}
									else echo '<br>Введіть IP адреси, які будуть допущені для входу в ваший акаунт (в форматі 255.255.255.255)';
								}
							}
							if(!isset($_REQUEST['use_ip'])){
								que('UPDATE '.$users.'  SET ip1="", ip2="" WHERE id="'.$id.'"');
							}
							if(strlen($_POST['pass1'])>1 && strlen($_POST['pass2'])>1 && strlen($_POST['pass3'])>1){
								if($_POST['pass1']!=str_rot13($row['val'])){
									$e=1;
									echo '<br>Попередній пароль є неправильним';
								}
								if($_POST['pass2']!=$_POST['pass3']){
									$e=1;
									echo '<br>Нові паролі не співпадають';
								}
								if($_POST['pass1']==$_POST['pass2']){
									$e=1;
									echo '<br>Попередній пароль та новий не повинен співпадати';
								}
								if(!preg_match("/^[a-zA-Z0-9+-_]{6,40}$/",$_POST['pass2'])){
									$e=1;
									echo '<br>Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри';
								}
								$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
								for($i=0;$i<=count($paslist);$i++)
									if($paslist[$i]==$_POST['pass2'] && isset($_POST['pass2'])) $er=1;
								for($i=1;$i<=count($_POST['pass2']);$i++)
									if($_POST['pass2'][$i]!=$_POST['pass2'][0]) $er=2;
								if($er!=2 || $er==1){
									$e=1;
									echo '<br>Пароль надто простий!';
								}
								if($e!=1){
									$pas=str_rot13($_POST['pass2']);
									$code=substr(md5(microtime()),rand(0,26),5);
									$codes=preg_split('/:/',$row['conf_c']);
									$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
									que('UPDATE '.$users.'  SET conf_c="'.$code_f.'", val="'.$pas.'" WHERE id="'.$id.'"');
									echo '<br>Пароль успішно змінено';
									$message='Зміна паролю в MAMBO SHOP (shop.mambo.in.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити логін на попередній та захистити свій акаунт:'.$location.'register/conf.php?d=39&i='.$id.'&c='.$code;
									mail($row['email'],"Зміна паролю - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else if(strlen($_POST['pass1'])>1 || strlen($_POST['pass2'])>1 || strlen($_POST['pass3'])>1) echo '<br>Щоб змінити пароль, потрібно вказати попередній пароль та новий два рази';
							echo var_dump($_POST['vis']);
							echo var_dump($row['vis']);
							if($_POST['vis']!=$row['vis'] && $_POST['vis']!=NULL){
								que('UPDATE '.$users.'  SET vis="'.$_POST['vis'].'" WHERE id='.$id);
							}
							/*if($row['d_in']!=$_POST['d_in']){
								switch ($_POST['d_in']) {
									case 1:
										if(isset($_POST['']))
										que('UPDATE '.$users.'  SET d_in="1" WHERE id="'.$id.'"');
										echo '<br>Двійний вхід вимкнуто';
									case 2:
										que('UPDATE '.$users.'  SET d_in="2" WHERE id="'.$id.'"');
										echo '<br>Двійний вхід через пошту активовано. При вході в акаунт, ви будете отриивати посилання по якому потрібно буде перейте для завереня входу';
										break;
									case 3:
										if(!isset($_POST['pass4']) && $_POST['d_in']==3){
											echo '<br>Введіть другий пароль';
										}
										if(isset($_POST['pass4'])){

										}
										break;
								}
							}*/
							echo '<br><h2>Вхід по IP</h2>
							<br>При включені, входити в акаунт можна буде тільки з введених IP адрес та з ip адреси, яка використовувалась при реєстрації акаунту ('.$row['r_ip'].')<br>
							<label><input type="checkbox" name="use_ip"';
								if(isset($row['ip1']) && $row['ip1']!=0) echo ' checked';
								echo '>Активувати</label>
								<br>Введіть дозволені IP адреси (максимум 2)<br>
								<input type="text" class="f_i_t" name="ip1" placeholder="IP №1. Ваший IP: '.$_SERVER['REMOTE_ADDR'].'"';
								if(isset($row['ip1']) && $row['ip1']!=0) echo 'value="'.$row['ip1'].'"';
								echo '>
								<input type="text" class="f_i_t" name="ip2" placeholder="IP №2. Ваший IP: '.$_SERVER['REMOTE_ADDR'].'"';
								if(isset($row['ip2']) && $row['ip2']!=0) echo 'value="'.$row['ip2'].'"';
								echo '><br>
								<h2>Зміна паролю</h2>
								<br>Попередній пароль<br>
								<input type="text" class="f_i_t" name="pass1" placeholder="Попередній пароль">
								<br>Новий пароль<br>
								<input type="text" class="f_i_t" name="pass2" placeholder="Новий пароль">
								<br>Повторити новий пароль<br>
							<input type="text" class="f_i_t" name="pass3" placeholder="Повторити новий пароль">';/*
							<br><h2>Двійний вхід в акаунт</h2><br>
							<label><input type="radio" name="d_in"';
							if(!isset($row['d_in']) || $row['d_in']==1 || $row['d_in']==0) echo ' checked';
							echo '>Вимкнуто</label><br>
							<label><input type="radio" name="d_in"';
							if($row['d_in']==2) echo ' checked';
							echo '>Підтвердженя входу через пошту</label><br>
							<label><input type="radio" name="d_in"';
							if($row['d_in']==3) echo ' checked';
							echo '>Другий пароль</label><br>
							<input type="text" name="pass4" placeholder="Другий пароль"><br>
							<label><input type="radio" name="d_in"';
							if(preg_match('/^(\w{5}:?)+$/', $row['d_in'])) echo ' checked';
							echo '>Генерувати коди доступу</label><br>';
							if(preg_match('/^(\w{5}:?)+$/', $row['d_in'])){
								$a=preg_split('/[\s:]+/', $row['d_in']);
								echo 'Ваші коди доступу:<br>';
								foreach($a as $a){
									echo $a.'<br>';
								}
							}*/
							echo '<br><h2>Видимість профілю</h2><br>
							<label><input type="radio" value="0" name="vis"';
								if(!isset($row['vis']) || $row['vis']==0) echo ' checked';
								echo '>Всім</label><br>
								<label><input type="radio" value="1" name="vis"';
									if($row['vis']==1) echo ' checked';
									echo '>Тим, хто ввійшов в акаунт</label><br>
									<label><input type="radio" value="2" name="vis"';
										if($row['vis']==2) echo ' checked';
										echo '>Нікому</label>';
										?>
										<br><input type="submit" value="Зберегти зміни">
									</form>
								</div>
								<div id="a3" style="display:none" class="tab_c">
									<form id="login" method="post" action="index.php?id=<?=$row['id']?>">
										<?php
										que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
										$row=mysql_fetch_array($res);
										if($_POST['display_footer']!='on')
											setcookie('display_footer',1,time()+60*60*24*20,'/');
										else
											setcookie('display_footer',2,time()+60*60*24*20,'/');
										if($_POST['back']!=$_COOKIE['back'] || !isset($_COOKIE['back'])){
											setcookie('back',strval($_POST['back']),time()+60*60*24*2,'/');
										}
										echo '<label><input type="checkbox" name="display_footer"';
										if($_COOKIE['display_footer']!=1) echo ' checked';
										echo '>Показувати футер (блок в нижній частині меню з даними про авторські права)</label><br>';
							/*<label><input type="checkbox" name="news"';
							if(isset($row['news']) && $row['news']=='1') echo ' checked';
							echo '>Підписатися на новини</label><br>';*/
							echo '<br>Виберіть колір сайту:
							<div class="colors">
								<div>
									<input type="radio" id="radio01" value="1" name="back"';
									if($_COOKIE['display_footer']!=1) echo ' checked';
									echo '>
									<label for="radio01"><span></span>&nbsp;</label>
								</div>
								<div>
									<input type="radio" id="radio02" value="2" name="back"';
									if($_COOKIE['back']==2) echo ' checked';
									echo '>
									<label for="radio02"><span></span>&nbsp;</label>
								</div>
							</div>
							<br>Мова:
							<select name="lang" disabled="disabled" size="1">
								<option selected="selected" value="українська">українська</option>
							</select><br>
							<input type="submit" value="Зберегти зміни">';
							?>
						</form>
					</div>
					<?php
				}
				else if($u2) $buf=10;
				else err();
			}
			else if($u2) $buf=10;
			else err();
		}
		else if($_GET['d']=='all'){
			que('SELECT id FROM '.$users.' ');
			$u=mysql_num_rows($res);
			$q='SELECT img,login,id FROM '.$users.'  WHERE vis';
			if($is_log){
				echo '<div class="tabs">
				<button onclick="redir(\''.$location.'profile/\')">Профіль</button>
				<button class="cur" onclick="redir(\''.$location.'profile/?d=all\')">Користувачі</button>
				<button onclick="redir(\''.$location.'profile/out.php\')">Вихід</button>
			</div>';
			$q.='!=2';
			}
			else
				$q.='=0';
			que($q);
			echo '<h1 class="title">Користувачі</h1>
			<p class="title">Загальна кількість зареєстованих користувачів: '.$u.'. В таблиці представленні ті з них, які відкрили видимість свого профілю.';
			if(!$is_log)
				echo ' Ввійдіть в свій акаунт, щоб подачити більше користувачів, отримати сповіщення про знижки та доступ до багатьох корисних можливостей';
			echo '</p>';
			while ($row=mysql_fetch_array($res)){
				switch($row['img']){
					case 1:$src2="jpg";break;
					case 2:$src2="gif";break;
					case 3:$src2="png";break;
					case 4:$src2="tiff";break;
					default:$src2="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";break;
				}
				if(strlen($src2)>10) $srr=$src2;
				else $srr=$location.'images/p/'.str_rot13($row['login']).'.'.$src2;
				echo '<a class="title l" href="'.$location.'profile/?id='.$row['id'].'">
				<img class="l_f" src="'.$srr.'">
				<p>'.str_rot13($row['login']).'</p>
			</a>';
		}
	}
		if($buf==10){//$is_log
			que('SELECT img,login,email,phone,facebook,youtube,twiter,instagram,vk,vis FROM '.$users.'  WHERE id="'.$_GET['id'].'"');
			$row=mysql_fetch_array($res);
			echo '<div class="title" id="login">';
			if($row['vis']==0 || ($row['vis']==1 && $is_log==1)){
				switch($row['img']){
					case 1:$src2="jpg";break;
					case 2:$src2="gif";break;
					case 3:$src2="png";break;
					case 4:$src2="tiff";break;
					default:$src2="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";break;
				}
				if(strlen($src2)>10) $srr=$src2;
				else $srr=$location.'images/p/'.str_rot13($row['login']).'.'.$src2;
				echo '<img class="l_f l prof_img" src="'.$srr.'">
				Логін:<a>'.str_rot13($row['login']).'</a><br>
				Пошта:<a>'.$row['email'].'</a><br>
				Номер телефону:<a>'.$row['phone'].'</a><br>
				Facebook:<a>'.$row['facebook'].'</a><br>
				Youtube:<a>'.$row['youtube'].'</a><br>
				Twiter:<a>'.$row['twiter'].'</a><br>
				Instagram:<a>'.$row['instagram'].'</a><br>
				Vk:<a>'.$row['vk'].'</a><br>';
			}
			else if($row['vis']==1)
				echo 'Виконайте вхід в ваший акаунт, щоб побачити цей профіль. <a href="'.$location.'login/">Вхід</a>';
			else
				echo 'Цей профіль приватний!';
			echo '<div>';
		}
		else if($_GET['d']!='all' && $buf!=10 && !isset($_GET['id'])){
			if($u){
				header("Location: ".$location."profile/?id=".$row['id']);
			}
			else {
				echo '<p class="title"><a href="'.$location.'login">Ввійти в акаунт</a><br>
				<a href="'.$location.'register">Реєстрація</a></p>';
			}
		}
	}
	?>