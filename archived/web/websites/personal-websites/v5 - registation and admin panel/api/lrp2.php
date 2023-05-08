<?php
#function is_em($mail) {
#function o($domain='mambo.in.ua'){
#function l($location,$users,$domain="mambo.in.ua"){
#function r($users, $location, $domain="mambo.in.ua", $rules_url="http://shop.mambo.in.ua/faq/?t=rules"){
#function co($users, $location,$i,$c,$de){
#function p($location,$users='users',$domain="mambo.in.ua"){
function is_em($m) {
	return preg_match("/^[A-Za-z0-9_\-]{3,20}@[A-Za-z0-9\-_]{3,10}(\.[A-Za-z0-9\-_]{2,6}){1,5}$/", $m);
}
function o($domain='mambo.in.ua'){
	setcookie("hesh", NULL, -1, "/", $domain);
	header("Location: {$_SERVER['HTTP_REFERER']}");
	echo '<div class="alert alert-success">Ви успішно вийшли!<br>Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, натисніть <a href="'.$_SERVER['HTTP_REFERER'].'">сюди</a></div>';
}
function l($location,$users="users",$domain="mambo.in.ua"){
	global $row,$res;
	echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
	$d=1;
	if(isset($_POST["login"]) && isset($_POST["pass"])) {
		$login=str_rot13(preg_replace('/[^@-Za-z0-9\.+-_\-]/', '', $_POST['login']));
		$pas=str_rot13(preg_replace('/[^A-Za-z0-9+-_\-]/', '', $_POST['pass']));
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
				if($r.success==false) echo '<div class="alert alert-danger">Пройдіть перевірку на робота (капчу)</div>';
				else $i=0;
			}
			else echo '<div class="alert alert-danger">Пройдіть перевірку на робота (капчу)</div>';
		}
		else if ($u1==1 || $u2==1){
			$ip=$_SERVER['REMOTE_ADDR'];
			echo '<div class="alert alert-success">Ви успішно ввійшли!</div>';
			if($row['ip']!=$ip && $ip==$row['r_ip'])
				echo '<div class="alert alert-danger">У ваший акаунт входили о '.$row['date'].' (секунда:хвилина:година день:місяць:рік) з даної ip адреси: '.$row['ip'].'</div>';
			else {
				echo '<div class="alert alert-warning">Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, натисніть <a href="'.$location.'">сюди</a></div>';
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
			echo '</p>';
			que("UPDATE ".$users." SET ip='".$ip."', hesh='".$hesh."', date='".date('H:i:s d:m:y')."' WHERE id='".$id."'");
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain);
			$is_loggined=1;
			$i=0;
		}
		else {
			echo '<div class="alert alert-danger">Неправильний логін/пароль</div>';
			$is_loggined=0;
			setcookie("hesh", NULL, -1, "/", $domain); 
			$i=$_POST['i']+1;
		}
	}
	else if(isset($_COOKIE['hesh'])){
		echo '<script>window.history.go(-2);</script>';
	}
	if(!$is_loggined){
		?>
		<br><form class="form-horizontal" method="post" action="<?=$location?>login/">
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2login">Логін:</label>
				<div class="col-sm-9">
					<input class="form-control" id="a2login" value="<?=$_POST['login']?>" name="login" type="text" autocomplete="on" maxlenght="20" required="required" placeholder="Логін/Пошта" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2pas">Пароль:</label>
				<div class="col-sm-9">
					<input id="a2pas" class="form-control" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
				</div>
			</div>
			<?php if($i>2)
			echo '<div class="form-group">
				<label class="control-label col-sm-2" for="a2email">Капча:</label>
				<div class="col-sm-9">
					<div class="g-recaptcha" data-sitekey="6LfnjSIUAAAAANkRfSYdlIGK4H4sveFTjeOIdysV"></div>
				</div>
			</div>';
			?>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9 btn-group">
					<button type="submit" class="btn btn-primary">Вхід</button>
					<a href="<?=$location?>register/" class="btn btn-default">Реєестрація</a>
					<a href="<?=$location?>register/conf.php?d=40" class="btn btn-default">Забули пароль?</a>
				</div>
			</div>
			<input type="hidden" name="link" value="<?=$link?>">
			<input type="hidden" name="i" value="<?=$i?>">
		</form>
		<?php
	}
}
function r($users="users", $location, $domain="mambo.in.ua", $rules_url="http://shop.mambo.in.ua/faq/?t=rules", $mail=NULL, $email=NULL, $name=NULL){
	global $row,$res;
	if($email==NULL)
		$email='max@patii.uk';
	if($name==NULL)
		$name='УАС';
	if($mail==NULL)
		$mail='Дякуємо за реєстрацією в офіційному сайті MAMBO (mambo.in.ua). Для підтвердження пошти, перейдіть по цьому посиланню - ';
	if(!isset($_POST['login']) && !isset($_POST['pass']) && !isset($_POST['login']) && !isset($_POST['d_pass']) && !isset($_POST['email'])){
		$d=1;
	}
	else {
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		$d=0;
		if(!preg_match("/^[a-z@-Z0-9+-_]{3,20}$/",$login)){
			$d=1;
			echo '<div class="alert alert-danger">Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри</div>';
		}
		if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
			$d=1;
			echo '<div class="alert alert-danger">Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри</div>';
		}
		if($pass!=$_POST['d_pass']){
			$d=1;
			echo '<div class="alert alert-danger">Паролі не збігаються!</div>';
		}
		que("SELECT id FROM ".$users." WHERE login='".mysql_real_escape_string($login)."'");
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u!=0){
			$d=1;
			echo '<div class="alert alert-danger">Логін зайнятий! Спробуйте інший</div>';
		}
		if($login==$pass){
			echo '<div class="alert alert-danger">Логін/пароль не повині співпадати</div>';
			$d=1;
		}
		$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
		for($i=0;$i<=count($paslist);$i++)
			if($paslist[$i]==$pass && isset($pass)) $er=1;
		for($i=1;$i<=strlen($pass);$i++)
			if($pass[$i]!=$pass[0]) $er=2;
		if($er!=2 || $er==1){
			$d=1;
			echo '<div class="alert alert-danger">Пароль надто простий!</div>';
		}
		if(is_em($_POST['email'])){
			que("SELECT id FROM ".$users." WHERE email='".mysql_real_escape_string($_POST['email'])."'");
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			if($u!=0){
				$d=1;
				echo '<div class="alert alert-danger">Електронна адреса зайнята! Спробуйте ввести іншу</div>';
			}
		}
		else {
			$d=1;
			echo '<div class="alert alert-danger">Введіть правильну електронну адресу</div>';
		}
		que('SELECT id FROM '.$users.' WHERE r_ip="'.$_POST['ip'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u>5){
			$d=1;
			echo '<div class="alert alert-danger">З даної ip адреси зареєстровано забагато акаунтів</div>';
		}
		if($d==0){
			$login=str_rot13($login);
			$pas=str_rot13($pass);
			$hesh=md5($login).md5('Ag5l').md5($pas);
			$code=substr(md5(microtime()),rand(0,26),5);
			setcookie("hesh", $hesh, time()+60*60*24*2, "/", $domain); 
			echo '<div class="alert alert-success">Ви успішно створили акаунт!<br>Залишився останій крок: підтвердіть свою електронну адресу, перейшовши по посиланню, яке ви отримаєте в листі</div>';
			$is_loggined=1;
			$code_f=$code.':::';
			que("INSERT INTO ".$users." VALUES ('', '".$login."', '".$pas."', '".$_POST['ip']."','0', '".date('H:i:s d:m:y')."', '".date('H:i:s d:m:y')."', '".strtolower($_POST['email'])."', '".$_POST['ip']."','','".(date('z')+10)."', '1','".$code_f."','".$hesh."','1','','','','','','','','','','','','','')");
			que('SELECT id FROM '.$users.' WHERE login="'.$login.'"');
			$row=mysql_fetch_array($res);
			$message=$mail.LINK.'register/conf.php?i='.$row['id'].'&c='.$code;
			mail($_POST['email'],"Підтвердження пошти - ".$name,$message,"Content-Type: text/html; charset='utf-8'","From: ".$email);
		}
	}
	if($d==1){
		?>
		<br><form class="form-horizontal" method="post" action="<?=$location?>register/">
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2email">Логін:</label>
				<div class="col-sm-9">
					<input class="form-control" id="a2email" name="login" type="text" value="<?=$_POST['login']?>" autocomplete="on" maxlenght="20" required="required" placeholder="Логін" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2pas">Пароль:</label>
				<div class="col-sm-9">          
					<input id="a2pas" class="form-control" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2d_pas">Повторити пароль:</label>
				<div class="col-sm-9">          
					<input id="a2d_pas" class="form-control" name="d_pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Повторіть пароль">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="a2email">Пошта:</label>
				<div class="col-sm-9">
					<input id="a2email" class="form-control" name="email" type="email" value="<?=$_POST['email']?>" autocomplete="on" maxlenght="30" required="required" placeholder="E-mail">
				</div>
			</div>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9">
					<div class="checkbox">
						<label><input type="checkbox" name="rules" required> Я погоджуюся з <a href="<?=$rules_url?>">правилами</a></label>
					</div>
				</div>
			</div>
			<div class="form-group">        
				<div class="col-sm-offset-2 col-sm-9">
					<button type="submit" class="btn btn-primary">Реєестрація</button>
					<a href="<?=$location?>login/" class="btn btn-default">Вхід</a>
				</div>
			</div>
			<input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			<input type="hidden" name="link" value="<?=$link?>">
		</form>
		<?php
	}
}
function co($users, $location,$i,$c,$de){
	global $row,$res;
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
					echo '<div class="alert alert-danger">Логін може містити тільки букви латинського алфавіту та цифри</div>';
				}
				else if(strlen($login) < 3 or strlen($login) > 20){
					$d=1;
					echo '<div class="alert alert-danger">Логін повинен бути в межах від 3 до 20 символів</div>';
				}
				if(!preg_match("/^[a-zA-Z0-9+-_]+$/",$pass)){
					$d=1;
					echo '<div class="alert alert-danger">Пароль може містити тільки букви латинського алфавіту та цифри</div>';
				}
				else if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					echo '<div class="alert alert-danger">Пароль повинен бути в межах від 6 до 40 символів</div>';
				}
				if($d!=1){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($u2!=0){
						$d=1;
						if(str_rot13($l)==$login)
							echo '<div class="alert alert-danger">Цей логін вже виористовується в вашому акаунті</div>';
						else
							echo '<div class="alert alert-danger">Логін зайнятий! Спробуйте інший</div>';
					}
					if($p==str_rot13($pass)){
						$d=1;
						echo '<div class="alert alert-danger">Цей пароль вже виористовується в вашому акаунті</div>';
					}
				}
				if($login==$pass){
					echo '<div class="alert alert-danger">Логін/пароль не повині співпадати</div>';
					$d=1;
				}
				$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					echo '<div class="alert alert-danger">Пароль надто простий!</div>';
				}
				if($d==0){
					$code_f=$codes[0].'::'.$codes[2].':'.$codes[3];
					que('UPDATE '.$users.' SET conf_c="'.$code_f.'", login="'.str_rot13($login).'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
					echo '<div class="alert alert-success">Логін та пароль успішно змінені<br><a href="'.$location.'/">Головна</a><br><a href="'.$location.'/profile/">Профіль</a></div>';
				}
			}
			if($d==1 || !isset($_POST['login'])) {
				if($codes[1]==$_GET['c'])
					echo '<br><form class="form-horizontal" action="conf.php?d=37&i='.$_GET['i'].'&c='.$code.'" method="post">
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2login">Логін:</label>
							<div class="col-sm-9">
								<input class="form-control" id="a2login" type="text" name="login" required value="'.$_POST['login'].'" placeholder="Логін">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2pa">Пароль:</label>
							<div class="col-sm-9">
								<input id="a2pa" class="form-control" name="val" required placeholder="Пароль">
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-primary">Готово</button>
							</div>
						</div>
					</form>';
				else
					echo '<div class="alert alert-danger">Посилання використано або неробоче</div>';
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
							echo "<div class=\"alert alert-danger\">Ця електронна адреса вже прив'язана до вашого акаунту! Спробуйте ввести іншу</div>";
						else
							echo '<div class="alert alert-danger">Електронна адреса зайнята! Спробуйте ввести іншу</div>';
					}
					que("SELECT id FROM ".$users." WHERE val='".mysql_real_escape_string(str_rot13($_POST['val']))."'");
					$rowd=mysql_fetch_array($res);
					$u=mysql_num_rows($res);
					if($u!=0 && $rowd['id']==$_GET['i']){
						$d=1;
						echo "<div class=\"alert alert-danger\">Цей пароль вже використовується в вашому акаунті! Спробуйте інший</div>";
					}
				}
				else {
					$d=1;
					echo '<div class="alert alert-danger">Введіть правильну електронну адресу</div>';
				}
				if($d==0){
					$pass=$_POST['val'];
					if(!preg_match("/^[a-zA-Z0-9+-_\-]{6,40}$/",$pass)){
						$d=1;
						echo '<div class="alert alert-danger">Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри</div>';
					}
					$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
					for($i=0;$i<=count($paslist);$i++)
						if($paslist[$i]==$pass && isset($pass)) $er=1;
					for($i=1;$i<=strlen($pass);$i++)
						if($pass[$i]!=$pass[0]) $er=2;
					if($er!=2 || $er==1){
						$d=1;
						echo '<div class="alert alert-danger">Пароль надто простий!</div>';
					}
					if($d==0){
						$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':';
						que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'", email="'.$_POST['email'].'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						echo '<div class="alert alert-success">Пошта та пароль успішно змінені</div>';
					}
				}
			}
			if($d==1 || !isset($_POST['email'])) {
				if($codes[3]==$_GET['c'])
					echo '<br><form class="form-horizontal" action="conf.php?d=38&i='.$_GET['i'].'&c='.$code.'" method="post">
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2ema">Нова пошта:</label>
							<div class="col-sm-9">
								<input class="form-control" id="a2ema" type="text" name="email" required value="'.$_POST['email'].'" placeholder="Пароль">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2pass">Новий пароль:</label>
							<div class="col-sm-9">
								<input id="a2pass" class="form-control" name="val" required placeholder="Пароль">
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-primary">Готово</button>
							</div>
						</div>
					</form>';
				else
					echo '<div class="alert alert-danger">Посилання використано або неробоче</div>';
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
					echo '<div class="alert alert-danger">Пароль може містити тільки букви латинського алфавіту та цифри</div>';
				}
				else if(strlen($pass) < 6 or strlen($pass) > 40){
					$d=1;
					echo '<div class="alert alert-danger">Пароль повинен бути в межах від 6 до 40 символів</div>';
				}
				if($d!=1){
					que("SELECT id FROM ".$users." WHERE login='".str_rot13($login)."'");
					$row2=mysql_fetch_array($res);
					$u2=mysql_num_rows($res);
					if($p==str_rot13($pass)){
						$d=1;
						echo '<div class="alert alert-danger">Цей пароль вже виористовується в вашому акаунті</div>';
					}
				}
				$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
				for($i=0;$i<=count($paslist);$i++)
					if($paslist[$i]==$pass && isset($pass)) $er=1;
				for($i=1;$i<=strlen($pass);$i++)
					if($pass[$i]!=$pass[0]) $er=2;
				if($er!=2 || $er==1){
					$d=1;
					echo '<div class="alert alert-danger">Пароль надто простий!</div>';
				}
				if($d==0){
					$code_f=$codes[0].':'.$codes[1].':'.$codes[2].'::';
					que('UPDATE '.$users.' SET conf_c="'.$code_f.'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
					echo '<div class="alert alert-success">Пароль успішно скинуто<br><a href="'.$location.'/">Головна</a><br><a href="'.$location.'/profile/">Профіль</a></div>';
				}
			}
			if($d==1 || !isset($_POST['val'])) {
				if($codes[3]==$_GET['c'])
					echo '<br><form class="form-horizontal" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'" method="post">
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2pasw">Новий пароль:</label>
							<div class="col-sm-9">
								<input id="a2pasw" class="form-control" name="val" required placeholder="Пароль">
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-primary">Готово</button>
							</div>
						</div>
					</form>';
				else
					echo '<div class="alert alert-danger">Посилання використано або неробоче</div>';
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
						echo "<div class=\"alert alert-danger\">Ця електронна адреса не прив'язана до жодного акаунту</div>";
					}
				}
				else {
					$d=1;
					echo '<div class="alert alert-danger">Введіть правильну електронну адресу!</div>';
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
					echo '<br><form class="form-horizontal" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'" method="post">
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2mail">Пошта:</label>
							<div class="col-sm-9">
								<input id="a2mail" class="form-control" name="val" value="'.$_POST['email'].'" required autocomplete placeholder="Пошта">
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-primary">Готово</button>
							</div>
						</div>
					</form>';
				else
					echo '<div class="alert alert-danger">Посилання використано або неробоче</div>';
			}
		}
		else {
			que("SELECT conf,r_date,conf_c FROM ".$users." WHERE id='".$_GET['i']."'");
			$row=mysql_fetch_array($res);
			if($row['conf']!=1 && $codes[0]==$_GET['c']){
				$code_f=':'.$codes[1].':'.$codes[2].':'.$codes[3];
				que('UPDATE '.$users.' SET conf=1, conf_c="'.$code_f.'" WHERE id="'.$_GET['i'].'"');
				echo '<div class="alert alert-success">Пошта успішно підтверджена. Дякуємо!<br>Щоб перейти на головну сторінку, натисніть <a href="'.$location.'">сюди</a><br>Щоб перети в ваший профіль, натисніть <a href="'.$location.'profile/">сюди</a></div>';
			}
			else echo '<div class="alert alert-danger">Посилання використано або неробоче.</div>';
		}
	}
	else echo '<div class="alert alert-danger">Посилання використано або неробоче</div>';
}

function p($location,$users='users',$domain="mambo.in.ua", $email=NULL, $name=NULL, $mail1=NULL, $mail2=NULL, $mail3=NULL){
	$us=$users;
	global $row,$res,$id,$users;
	$users=$us;
	if($email==NULL)
		$email='max@patii.uk';
	if($name==NULL)
		$name='УАС';
	function err(){
		global $id,$u;
		echo '<div class="alert alert-danger">Користувача не знайдено!<br> <a href="'.$location.'">Повернутися на головну</a></div>.';
		if($u)
			echo '<div class="alert alert-info"><a href="'.$location.'profile/?id='.$id.'">Перейти в свій акаунт</a></div>';
		else 
			echo '<div class="alert alert-info"><a href="'.$location.'login">Ввійти в акаунт</a><br>
		<a href="'.$location.'register">Реєстрація</a></div>';
	}
	echo '<script>function redir(where) {window.location.href = where;}</script>';
	$hesh=preg_replace('/[^a-z0-9]/', '', $_COOKIE['hesh']);
	que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
	$row=mysql_fetch_array($res);
	$id=$row['id'];
		$u=$is_log=mysql_num_rows($res);//u = is logined
		$id2=preg_replace('/[^0-9]/', '', $_GET['id']);
		que('SELECT * FROM '.$users.'  WHERE id="'.$id2.'"');
		$row2=mysql_fetch_array($res);
		$u2=mysql_num_rows($res);// does this profile exist
		if($_GET['tab']==2){
			$but2=" class=\"active\"";
			$tab2=" active in";
		}
		else{
			$but1=" class=\"active\"";
			$tab1=" active in";
		}
		if(isset($_GET['id']) && preg_match('/^[0-9]{1,6}$/', $_GET['id'])){
			if($u){
				if($_GET['id']==$id){
					?>
					<ul class="nav nav-tabs">
						<li<?=$but1?>><a data-toggle="tab" href="#tab1" aria-expanded="true">Профіль</a></li>
						<li<?=$but2?>><a data-toggle="tab" href="#tab2" aria-expanded="false">Безпека</a></li>
						<li><a onclick="redir('<?=$location?>profile/?d=all')">Користувачі</a></li><?php
						if($row['type']>1) echo '<li><a onclick="redir(\''.$location.'adm/\')">Адміністрування</a></li>';
						?><li><a onclick="redir('<?=$location?>profile/out.php')">Вихід</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade<?=$tab1?>">
							<?php
							que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
							$row=mysql_fetch_array($res);
							if(isset($_POST['submit_1'])){
								if (isset($_POST['login']) && str_rot13($row['login'])!=$_POST['login']){
									que("SELECT id FROM ".$users."  WHERE login='".str_rot13($_POST['login'])."'");
									$row2=mysql_fetch_array($res);
									$u=mysql_num_rows($res);
									if($u!=0){
										$d=1;
										echo '<div class="alert alert-danger">Логін зайнятий! Спробуйте інший</div>';
									}
									else if(preg_match("/^[a-zA-Z0-9+-_]{3,60}$/",$_POST['login'])){
										echo '<div class="alert alert-success">Логін успішно змінений</div>';
										$code=substr(md5(microtime()),rand(0,26),5);
										$message="Ім'я вашого акаунту в MAMBO SHOP (shop.mambo.in.ua) змінено. Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть за цим посиланням щоб змінити логін на попередній та захистити свій акаунт: ".$location."register/conf.php?d=37&i=".$row['id']."&c=".$code." .";
										mail($row['email'],"Зміна логіну - ".$name,$message,"From: max@patii.uk", 'Content-Type: text/html; charset="utf-8"');
										que("SELECT conf_c FROM ".$users."  WHERE id='".$id."'");
										$row3=mysql_fetch_array($res);
										$code=substr(md5(microtime()),rand(0,26),5);
										$codes=preg_split('/:/',$row3['conf_c']);
										$code_f=$codes[0].':'.$code.':'.$codes[2].':'.$codes[3];
										que('UPDATE '.$users.'  SET conf_c="'.$code_f.'", login="'.str_rot13($_POST['login']).'" WHERE id="'.$id.'"');
									}
									else echo '<div class="alert alert-danger">Логін повинен бути в межах від 3 до 20 символів і містити лише латинські букви та цифри</div>';
								}
								if (isset($_POST['email']) && $row['email']!=$_POST['email']){
									if(is_em($_POST['email'])){
										echo '<div class="alert alert-success">Пошта успішно змінена. Щоб підтвердити пошту, потрібно перейти по посиланню яке ви отримали в листі на вказану ел. пошту</div>';
										if($_POST['email']!='test@t_est'){
											$code=substr(md5(microtime()),rand(0,26),5);
											$code2=substr(md5(microtime()),rand(0,26),5);
											$codes=preg_split('/:/',$row['conf_c']);
											$code_f=$code2.':'.$codes[1].':'.$codes[2].':'.$code;
											que('UPDATE '.$users.'  SET conf=0, conf_c="'.$code_f.'", email="'.$_POST['email'].'" WHERE id="'.$id.'"');
											if($mail1==NULL)
												$mail='Зміна пошти в MAMBO SHOP (shop.mambo.in.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити пошту на попередню та захистити свій акаунт - ';
											mail($row['email'],"Зміна пошти - ".$name,$mail1.$location.'register/conf.php?i='.$id.'&d=38&c='.$code,"From: ".$email, "Content-Type: text/html; charset='utf-8'");
											if($mail2==NULL)
												$mai2='Підтвердження пошти - MAMBO SHOP (shop.mambo.in.ua). Для підтвердження пошти, перейдіть по цьому посиланню - ';
											mail($_POST['email'],"Підтвердження пошти - ".$name,$mail2.$location.'register/conf.php?i='.$id.'&c='.$code2,"From: ".$email, "Content-Type: text/html; charset='utf-8'");
										}
									}
									else echo '<div class="alert alert-danger">Пошта повина містити лише латинські букви, цифри та бути в форматі "name@domain.com"</div>';
								}
								if(isset($_POST['phone']) && $_POST['phone']!='' && $_POST['phone']!=$row['phone']){
									if(preg_match('/^\+[0-9]{0,20}$/', $_POST['phone'])){
										que('UPDATE '.$users.'  SET phone="'.$_POST['phone'].'" WHERE id="'.$id.'"');
										echo '<div class="alert alert-success">Телефон успішно додано!</div>';
									}
									else echo '<div class="alert alert-danger">Номер телефону повинен бути в міжнародному форматі (+380501234567)</div>';
								}
								if($_FILES['avatar']['size']>0){
									switch($_FILES['avatar']['type']){
										case "image/jpeg":$src2="jpg";$t=1;break;
										case "image/gif":$src2="gif";$t=2;break;
										case "image/png":$src2="png";$t=3;break;
										case "image/tiff":$src2="tiff";$t=4;break;
									}
									if(isset($src2)){
										if($_FILES['avatar']['size']>1024*1024*3)
											echo '<div class="alert alert-danger">Аватарка повина бути меншою за 3 мб. <a target="_blank" href="http://optimizilla.com/ru/">Скористайтеся сервісом стисненя зображень</a></div>';
										else {
											unlink('../images/p/'.str_rot13($row['login']).'.jpg');
											unlink('../images/p/'.str_rot13($row['login']).'.gif');
											unlink('../images/p/'.str_rot13($row['login']).'.png');
											unlink('../images/p/'.str_rot13($row['login']).'.tiff');
											move_uploaded_file($_FILES['avatar']['tmp_name'],'../images/p/'.str_rot13($row['login']).'.'.$src2);
											echo "<div class=\"alert alert-success\">Ваша аватарка успішно змінена. Оновіть сторінку</div>";
											que('UPDATE '.$users.'  SET img="'.$t.'" WHERE id="'.$id.'"');
										}
									}
									else
										echo "<div class=\"alert alert-danger\">Аватарка повина бути в форматі jpg, giff, png або tiff</div></div>";
								}
								if($_FILES['backg']['size']>0){
									switch($_FILES['backg']['type']){
										case "image/jpeg":$src2="jpg";$t=1;break;
										case "image/gif":$src2="gif";$t=2;break;
										case "image/png":$src2="png";$t=3;break;
										case "image/tiff":$src2="tiff";$t=4;break;
									}
									if(isset($src2)){
										if($_FILES['backg']['size']>1024*1024*3)
											echo '<div class="alert alert-danger">Фонове зображення повино бути меншим за 3 мб. <a target="_blank" href="http://optimizilla.com/ru/">Скористайтеся сервісом стисненя зображень</a></div>';
										else {
											unlink('../images/p/b_'.str_rot13($row['login']).'.jpg');
											unlink('../images/p/b_'.str_rot13($row['login']).'.gif');
											unlink('../images/p/b_'.str_rot13($row['login']).'.png');
											unlink('../images/p/b_'.str_rot13($row['login']).'.tiff');
											move_uploaded_file($_FILES['backg']['tmp_name'],'../images/p/b_'.str_rot13($row['login']).'.'.$src2);
											echo "<div class=\"alert alert-success\">Фонове зображення успішно змінено. Оновіть сторінку</div>";
											que('UPDATE '.$users.'  SET backg="'.$t.'" WHERE id="'.$id.'"');
										}
									}
									else
										echo "<div class=\"alert alert-danger\">Фонове зображення повино бути в форматі jpg, giff, png або tiff</div></div>";
								}
								function a_link($names){
									global $id, $row, $users;
									if(isset($_POST[$names]) && $_POST[$names]!=$row[$names]){
										if(preg_match('/^[a-zA-Z0-9_:#\/\?\&\.]{9,255}$/', $_POST[$names])){
											echo '<div class="alert alert-success">'.ucfirst($names).' акаунт успішно додано</div>';
											que('UPDATE '.$users.'  SET '.$names.'="'.$_POST[$names].'" WHERE id="'.$id.'"');
										}
										else echo '<div class="alert alert-danger">Вкажтіть правильне посилання на ваший '.ucfirst($names).' акаунт</div>';
									}
								}
								a_link('facebook');
								a_link('youtube');
								a_link('twiter');
								a_link('instagram');
								a_link('vk');
								que('SELECT * FROM '.$users.' WHERE id="'.$id.'"');
								$row=mysql_fetch_array($res);
								if($_POST['u_name']!=$row['u_name']){
									if(preg_match("/^[^!-@\[-`{-~]{0,30}$/", $_POST['u_name']) && strlen($_POST['u_name'])>3 && strlen($_POST['u_name'])<30){
										que('UPDATE '.$users.' SET u_name="'.$_POST['u_name'].'" WHERE id="'.$id.'"');
										echo '<div class="alert alert-success">Ім\'я успішно змінено</div>';
									}
									else
										echo '<div class="alert alert-danger">Введіть правильне ім\'я</div>';
								}
								if($_POST['u_surname']!=$row['u_surname']){
									if(preg_match("/^[^!-@\[-`{-~]{0,30}$/", $_POST['u_surname']) && strlen($_POST['u_surname'])>3 && strlen($_POST['u_surname'])<30){
										que('UPDATE '.$users.' SET u_surname="'.$_POST['u_surname'].'" WHERE id="'.$id.'"');
										echo '<div class="alert alert-success">Прізвище успішно змінено</div>';
									}
									else
										echo '<div class="alert alert-danger">Введіть правильне прізвище</div>';
								}
								if($_POST['city']!=$row['city']){
									if(preg_match("/^[^!-+:-@\[-`{-~]{0,65}$/", $_POST['city']) && strlen($_POST['city'])<65){
											que('UPDATE '.$users.' SET city="'.$_POST['city'].'" WHERE id="'.$id.'"');
											echo '<div class="alert alert-success">Місце проживання успішно змінено</div>';
										}
											else
										echo '<div class="alert alert-danger">Введіть правильне місце проживання</div>';
								}
								if($_POST['edu']!=$row['edu']){
									if(preg_match("/^[^!-+:-@\[-`{-~]{0,65}$/", $_POST['edu']) && strlen($_POST['edu'])<65){
											que('UPDATE '.$users.' SET edu="'.$_POST['edu'].'" WHERE id="'.$id.'"');
											echo '<div class="alert alert-success">Навчальний заклад успішно змінено</div>';
										}
											else
										echo '<div class="alert alert-danger">Тільки наступні символи допустимі в назві навчального закладу: А-Я, а-я, 0-9, A-Z, a-z</div>';
								}
								if($_POST['u_date']!=$row['u_date']){
									if(!isset($_POST['u_date']) || !preg_match("/^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$/", date('Y-m-d',strtotime($_POST['u_date']))) || strlen($_POST['u_date'])!=10)
										echo '<div class="alert alert-danger">'.$_POST['u_date'].' Введіть правильну дату народження в форматі: мм/дд/рррр</div>';
									else if($_POST['u_date']!=$row['u_date']){
										que('UPDATE '.$users.' SET u_date="'.date('Y-m-d',strtotime($_POST['u_date'])).'" WHERE id="'.$id.'"');
										echo '<div class="alert alert-success">Дату народження успішно змінено</div>';
									}
								}
								if($_POST['about']!=$row['about']){
									if(!isset($_POST['about']) || !preg_match("/^[^#-'<>\[-`\{-~]{0,255}$/", $_POST['about']) || strlen($_POST['about'])<0 || strlen($_POST['about'])>255)
										echo '<div class="alert alert-danger">Наступні символи недопустимі в полі "про себе" : \, <, >, $, ^, &, *, {, }, [, ]. Максимальна довжина : 255 символів</div>';
									else if($_POST['about']!=$row['about']){
										que('UPDATE '.$users.' SET about="'.$_POST['about'].'" WHERE id="'.$id.'"');
										echo '<div class="alert alert-success">Поле "про себе" успішно змінено</div>';
									}
								}
							}
							que('SELECT * FROM '.$users.' WHERE id="'.$id.'"');
							$row=mysql_fetch_array($res);
							switch($row['backg']){
								case 1:$src2="jpg";break;
								case 2:$src2="gif";break;
								case 3:$src2="png";break;
								case 4:$src2="tiff";break;
								default:$src2="https://image.ibb.co/nEKv7Q/wallpaper_722590cp.jpg";break;
							}
							if(strlen($src2)>10) $srr=$src2;
							else $srr=$location.'images/p/b_'.str_rot13($row['login']).'.'.$src2;
							?><div class="row">
								<div style="min-width: 100vw;overflow: hidden;padding-bottom: 39%;position: relative;height: 25vw;">
									<img src="<?=$srr?>" style="position: absolute;width: 100%;">
								</div>
								<div>
									<div><?php
										switch($row['img']){
											case 1:$src2="jpg";break;
											case 2:$src2="gif";break;
											case 3:$src2="png";break;
											case 4:$src2="tiff";break;
											default:$src2="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";break;
										}
										if(strlen($src2)>10) $srr=$src2;
										else $srr=$location.'images/p/'.str_rot13($row['login']).'.'.$src2;
										?><div class="l col-xs-3" style="position: relative;margin-left: 5vw;padding-bottom: 25%;overflow: hidden;margin-top: -20vw;">
											<img style="position: absolute;background:#fff;top: 0;left: 0;border-radius: 100vw;width: 100%;height: 100%;border: 10px solid #fff;" src="<?=$srr?>">
										</div>
										<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;"><?php
											if(isset($row['u_name']) || isset($row['u_surname']))
												echo $row['u_name'].' '.$row['u_surname'];
											else
												echo str_rot13($row['login']);
										?></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<br><form class="form-horizontal" action="index.php?id=<?=$row['id']?>" enctype="multipart/form-data" method="post">
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2u_name">Ім'я:</label>
											<div class="col-sm-9">
												<input class="form-control" id="a2u_name" type="text" name="u_name" value="<?=$row['u_name']?>" placeholder="Ім'я" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2u_surname">Прізвище:</label>
											<div class="col-sm-9">
												<input class="form-control" id="a2u_surname" type="text" name="u_surname" value="<?=$row['u_surname']?>" placeholder="Прізвище" required>
											</div>
										</div>
										<div class="form-group">
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
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2city">Місце проживання:</label>
											<div class="col-sm-9">
												<input class="form-control" id="a2city" type="text" name="city" value="<?=str_rot13($row['city'])?>" maxlength="65" placeholder="Країна, Область або Місто">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2edu">Навчальний заклад:</label>
											<div class="col-sm-9">
												<input class="form-control" id="a2edu" type="text" name="edu" value="<?=str_rot13($row['edu'])?>" maxlength="65" placeholder="Навчальний заклад">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2login">Логін:</label>
											<div class="col-sm-9">
												<input class="form-control" id="a2login" type="text" name="login" required="required" value="<?=str_rot13($row['login'])?>" placeholder="Логін">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2em">Пошта:</label>
											<div class="col-sm-9">
												<input id="a2em" class="form-control" name="email" required="required" value="<?=$row['email']?>" placeholder="Пошта">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="a2ph">Номер телефону (напр.: +380501234567):</label>
											<div class="col-sm-9">
												<input id="a2ph" class="form-control" type="phone" name="phone" value="<?=$row['phone']?>" placeholder="Номер телефону">
											</div>
										</div>
										<?php
										function socialm($name){
											global $row;
											echo '<div class="form-group">
												<label class="control-label col-sm-2" for="a2'.strtolower($name).'">'.ucfirst($name).':</label>
												<div class="col-sm-9">
													<input id="a2'.strtolower($name).'" class="form-control" type="text" name="'.strtolower($name).'" value="'.$row[$name].'" placeholder="'.ucfirst($name).'">
												</div>
											</div>';
										}
										socialm('facebook');
										socialm('youtube');
										socialm('twiter');
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
												<button type="submit" name="submit_1" class="btn btn-primary">Зберегти зміни</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div id="tab2" class="tab-pane fade<?=$tab2?>">
							<form method="post" action="index.php?id=<?=$row['id']?>&tab=2" class="form-horizontal">
								<?php
								que('SELECT * FROM '.$users.'  WHERE hesh="'.$hesh.'"');
								$row=mysql_fetch_array($res);
								if(isset($_POST['submit_2'])){
									if(strlen($_POST['pass1'])>1 && strlen($_POST['pass2'])>1 && strlen($_POST['pass3'])>1){
										if($_POST['pass1']!=str_rot13($row['val'])){
											$e=1;
											echo '<div class="alert alert-danger">Попередній пароль є неправильним</div>';
										}
										if($_POST['pass2']!=$_POST['pass3']){
											$e=1;
											echo '<div class="alert alert-danger">Нові паролі не співпадають</div>';
										}
										if($_POST['pass1']==$_POST['pass2']){
											$e=1;
											echo '<div class="alert alert-danger">Попередній пароль та новий не повинен співпадати</div>';
										}
										if(!preg_match("/^[a-zA-Z0-9+-_]{6,40}$/",$_POST['pass2'])){
											$e=1;
											echo '<div class="alert alert-danger">Пароль повинен бути в межах від 6 до 40 символів і містити лише латинські букви та цифри';
										}
										$paslist=array('123456','1234567','12345678','123456789','1234567890','0123456','qwerty','passwd','password','123123','321321','12341234','google');
										for($i=0;$i<=count($paslist);$i++)
											if($paslist[$i]==$_POST['pass2'] && isset($_POST['pass2']))
												$er=1;
										for($i=1;$i<=strlen($_POST['pass2']);$i++)
											if($_POST['pass2'][$i]!=$_POST['pass2'][0])
												$er=2;
										if($er!=2 || $er==1){
											$e=1;
											echo '<div class="alert alert-danger">Пароль надто простий!</div>';
										}
										if($e!=1){
											$pas=str_rot13($_POST['pass2']);
											$code=substr(md5(microtime()),rand(0,26),5);
											$codes=preg_split('/:/',$row['conf_c']);
											$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$code;
											que('UPDATE '.$users.'  SET conf_c="'.$code_f.'", val="'.$pas.'" WHERE id="'.$id.'"');
											echo '<div class="alert alert-success">Пароль успішно змінено</div>';
											if($mail3==NULL)
												$mail3='Зміна паролю в MAMBO SHOP (shop.mambo.in.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити логін на попередній та захистити свій акаунт - ';
											mail($row['email'],"Зміна паролю - Mambo Shop",$mail3.$location.'register/conf.php?d=39&i='.$id.'&c='.$code,"From: ".$email, "Content-Type: text/html; charset='utf-8'");
										}
									}
									else if(strlen($_POST['pass1'])>1 || strlen($_POST['pass2'])>1 || strlen($_POST['pass3'])>1) echo '<div class="alert alert-danger">Щоб змінити пароль, потрібно вказати попередній пароль та новий два рази</div>';
									if($_POST['vis']!=$row['vis'] && $_POST['vis']!=NULL){
										que('UPDATE '.$users.'  SET vis="'.$_POST['vis'].'" WHERE id='.$id);
									}
								}
								que('SELECT * FROM '.$users.'  WHERE id="'.$id.'"');
								$row=mysql_fetch_array($res);
								?><div class="page-header col-sm-offset-2">
								  <h4>Зміна паролю</h4>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="a2ppas">Попередній пароль:</label>
									<div class="col-sm-9">
										<input id="a2ppas" class="form-control" name="pass1" placeholder="Попередній пароль">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="a2npas">Новий пароль:</label>
									<div class="col-sm-9">
										<input id="a2npas" class="form-control" name="pass2" placeholder="Новий пароль">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="a2npas">Повторити новий пароль:</label>
									<div class="col-sm-9">
										<input id="a2npas" class="form-control" name="pass3" placeholder="Повторити новий пароль">
									</div>
								</div>
								<div class="page-header col-sm-offset-2">
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
										<button type="submit" name="submit_2" class="btn btn-primary">Зберегти зміни</button>
									</div>
								</div>
							</form>
						</div>
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
			$q='SELECT img,login,id,phone,u_name,u_surname,about FROM '.$users.'  WHERE vis';
			if($is_log){
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
			echo '<div class="page-header col-sm-12">
				<h2>Користувачі</h2>
				<h4>Загальна кількість зареєстованих користувачів: '.$u.'. В таблиці представленні ті з них, які відкрили видимість свого профілю.';
			if(!$is_log)
				echo ' Ввійдіть в свій акаунт, щоб подачити більше користувачів, отримати сповіщення про знижки та доступ до багатьох корисних можливостей';
			echo '</h4>
				<div class="r">
					<a href="index.php?d=all&view=1" type="button" class="hideble btn btn-default';
						if($_GET['view']!=2)
							echo ' active';
						echo '">
						<span class="	glyphicon glyphicon-th-large"></span>
					</a>
					<a href="index.php?d=all&view=2" type="button" class="hideble btn btn-default';
						if($_GET['view']==2)
							echo ' active';
						echo '">
						<span class="glyphicon glyphicon-th-list"></span>
					</a>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">';
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
				echo '<div class="disp-fir col-xs-12 col-sm-6 col-md-6 col-lg-3">
					<a class="thumbnail" href="'.$location.'profile/?id='.$row['id'].'">
						<div style="position: relative; padding-bottom: 100%; overflow: hidden;">
							<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="'.$srr.'" alt="'.$row['id'].'">
						</div>
						<div class="caption text-center">
							<h3>'.str_rot13($row['login']).'</h3>
						</div>
					</a>
				</div>
				<div class="disp-sec col-xs-12">
					<a class="thumbnail l" style="width:100%;position:relative;" href="'.$location.'profile/?id='.$row['id'].'">
						<div class="col-xs-2 l" style="border-radius: 100vh; position: relative; padding-bottom: 16.66667%; overflow: hidden;">
							<img style="padding: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="'.$srr.'" alt="'.$row['id'].'">
						</div>
						<div class="col-xs-10 l">';
							if(isset($row['u_name']) || isset($row['u_surname']))
								echo '<h3>'.$row['u_name'].' '.$row['u_surname'].'</h3>';
							else
								echo '<h3>'.str_rot13($row['login']).'</h3>';
							if(isset($row['phone']))
								echo '<p>'.$row['phone'].'</p>';
							if(isset($row['about']))
								echo '<p>'.$row['about'].'</p>';
						echo '</div>
					</a>
				</div>';
			}
			echo "</div>
			</div>";
			if(!isset($_GET['view']))
				$_GET['view']=1;
			?>
			<script>
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
		if($buf==10){//$is_log
			que('SELECT * FROM '.$users.'  WHERE id="'.$_GET['id'].'"');
			$row=mysql_fetch_array($res);
			if($row['vis']==0 || ($row['vis']==1 && $is_log==1)){
				switch($row['backg']){
					case 1:$src2="jpg";break;
					case 2:$src2="gif";break;
					case 3:$src2="png";break;
					case 4:$src2="tiff";break;
					default:$src2="https://image.ibb.co/nEKv7Q/wallpaper_722590cp.jpg";break;
				}
				if(strlen($src2)>10) $srr=$src2;
				else $srr=$location.'images/p/b_'.str_rot13($row['login']).'.'.$src2;
				echo '<div class="row">
					<div style="min-width: 100vw;overflow: hidden;padding-bottom: 39%;position: relative;height: 25vw;">
						<img src="'.$srr.'" style="position: absolute;width: 100%;">
					</div>
					<div>
						<div>';
				switch($row['img']){
					case 1:$src2="jpg";break;
					case 2:$src2="gif";break;
					case 3:$src2="png";break;
					case 4:$src2="tiff";break;
					default:$src2="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";break;
				}
				if(strlen($src2)>10) $srr=$src2;
				else $srr=$location.'images/p/'.str_rot13($row['login']).'.'.$src2;
				echo '<div class="l col-xs-3" style="position: relative;margin-left: 5vw;padding-bottom: 25%;overflow: hidden;margin-top: -20vw;">
								<img style="position: absolute;background:#fff;top: 0;left: 0;border-radius: 100vw;width: 100%;height: 100%;border: 10px solid #fff;" src="'.$srr.'">
							</div>
							<div class="l col-xs-7" style="color: #fff;font-size: 4vw;margin-top: -7vw;">';
								if(isset($row['u_name']) || isset($row['u_surname']))
									echo $row['u_name'].' '.$row['u_surname'];
								else
									echo str_rot13($row['login']);
							echo '</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">';
					function op2($name,$secname=NULL){
						if(!$secname)
							$secname=$name;
						global $row;
						if($row[$secname]!=NULL){
							echo '<div class="form-group">
							<label class="control-label col-sm-3" for="a2'.strtolower($secname).'">'.ucfirst($name).':</label>
							<div class="col-sm-9">';
								if($secname!='about')
									echo '<input class="form-control" id="a2'.strtolower($secname).'"t type="text" value="'.$row[$secname].'" readonly>';
								else
									echo '<textarea class="form-control" rows="5" maxlength="255" id="a2about" readonly>'.$row[$secname].'</textarea>';
								echo '</div>
							</div>';
						}
				}
				op2('Про себе','about');
				op2('Дата народження','u_date');
				op2('Місце проживання','city');
				op2('Навчальний заклад','edu');
				op2('Пошта','email');
				op2('Номер телефону','phone');
				op2('facebook');
				op2('youtube');
				op2('twiter');
				op2('instagram');
				op2('vk');
				echo '</div>';
			}
			else if($row['vis']==1)
				echo '<div class="alert alert-danger">Виконайте вхід в ваший акаунт, щоб побачити цей профіль. <a href="'.$location.'login/">Вхід</a></div>';
			else
				echo '<div class="alert alert-danger">Цей профіль приватний!</div>';
		}
		else if($_GET['d']!='all' && $buf!=10 && !isset($_GET['id'])){
			if($u){
				header("Location: ".$location."profile/?id=".$row['id']);
			}
			else {
				echo '<div class="alert alert-info"><p class="title"><a href="'.$location.'login">Ввійти в акаунт</a><br>
				<a href="'.$location.'register">Реєстрація</a></p></div>';
			}
		}
	}
	?>