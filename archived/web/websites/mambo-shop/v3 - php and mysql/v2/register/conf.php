<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			head('','','',0,0,0,1);
		?>
	</head>
	<body>
		<?php menu();
		c();
		echo '<div class="oh">';
		function is_em( $mail ) {
			return preg_match("/^[a-zA-Z0-9\-_\.\+]{3,30}@[a-zA-Z0-9\-_\.\+]{1,15}\.[a-zA-Z0-9\-_\.\+]{1,30}$/", $mail);
		}
		if((isset($_GET['i']) && strlen($_GET['c'])==5 && preg_match('/[0-9]/', $_GET['i'].$_GET['c'])) || $_GET['d']==40){
			$code=$_GET['c'];
			que("SELECT login,val,conf_c FROM users WHERE id='".$_GET['i']."'");
			$row=mysql_fetch_array($res);
			$l=$row['login'];
			$p=$row['val'];
			$codes=preg_split('/:/',$row['conf_c']);
			$code_f=$codes[0].':'.$codes[1].':'.$codes[2].':'.$codes[3];
			if($_GET['d']==37){													//1
				if(isset($_POST['login']) && isset($_POST['val'])){
					que('SELECT login,val FROM users WHERE id="'.$_GET['i'].'"');
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
						que("SELECT id FROM users WHERE login='".str_rot13($login)."'");
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
						que('UPDATE users SET conf_c="'.$code_f.'", login="'.str_rot13($login).'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						echo '<p class="title">Логін та пароль успішно змінені<br><a href="'._LOCATION_.'">Головна</a><br><a href="'._LOCATION_.'profile/">Профіль</a></p>';
					}
				}
				if($d==1 || !isset($_POST['login'])) {
					if($codes[1]==$_GET['c']){
						echo '<form id="login" method="post" action="conf.php?d=37&i='.$_GET['i'].'&c='.$code.'">
								Логін:<input type="text" name="login" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br>
								Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br>
								<input type="submit" value="Готово">
							</form>';
					}
					else echo '<p class="title">Посилання використано або неробоче</p>';
				}
			}
			else if($_GET['d']==38){
				if(isset($_POST['email']) && isset($_POST['val'])){
					if(is_em($_POST['email'])){
						que("SELECT id FROM users WHERE email='".mysql_real_escape_string($_POST['email'])."'");
						$rowd=mysql_fetch_array($res);
						$u=mysql_num_rows($res);
						if($u!=0){
							$d=1;
							if($rowd['id']==$_GET['i'])
								echo "<br>Ця електронна адреса вже прив'язана до вашого акаунту! Спробуйте ввести іншу";
							else
								echo '<br>Електронна адреса зайнята! Спробуйте ввести іншу';
						}
						que("SELECT id FROM users WHERE val='".mysql_real_escape_string(str_rot13($_POST['val']))."'");
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
							que('UPDATE users SET conf=1, conf_c="'.$code_f.'", email="'.$_POST['email'].'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
							echo '<p class="title">Пошта та пароль успішно змінені<br><a href="'._LOCATION_.'">Головна</a><br><a href="'._LOCATION_.'profile/">Профіль</a></p>';
						}
					}
				}
				if($d==1 || !isset($_POST['email'])) {
					if($codes[3]==$_GET['c']){
						echo '<form id="login" method="post" action="conf.php?d=38&i='.$_GET['i'].'&c='.$code.'">
								Пошта:<input type="text" name="email" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br>
								Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br>
								<input type="submit" value="Готово">
							</form>';
					}
					else echo '<p class="title">Посилання використано або неробоче</p>';
				}
			}
			else if($_GET['d']==39){													//1
				if(isset($_POST['val'])){
					que('SELECT val FROM users WHERE id="'.$_GET['i'].'"');
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
						que("SELECT id FROM users WHERE login='".str_rot13($login)."'");
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
						que('UPDATE users SET conf_c="'.$code_f.'", val="'.str_rot13($pass).'" WHERE id="'.$_GET['i'].'"');
						echo '<p class="title">Пароль успішно скинуто<br><a href="'._LOCATION_.'">Головна</a><br><a href="'._LOCATION_.'profile/">Профіль</a></p>';
					}
				}
				if($d==1 || !isset($_POST['val'])) {
					if($codes[3]==$_GET['c']){
						echo '<form id="login" method="post" action="conf.php?d=39&i='.$_GET['i'].'&c='.$code.'">
								Пароль:<input type="text" name="val" class="f_i_t" required="required" autocomplete="off" placeholder="Пароль"><br>
								<input type="submit" value="Готово">
							</form>';
					}
					else echo '<p class="title">Посилання використано або неробоче</p>';
				}
			}
			else if($_GET['d']==40){
				if(isset($_POST['email'])){
					if(is_em($_POST['email'])){
						que("SELECT id FROM users WHERE email='".mysql_real_escape_string($_POST['email'])."'");
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
						que('SELECT id FROM users WHERE email="'.$_POST['email'].'"');
						$rowd=mysql_fetch_array($res);
						$message='Відновлення паролю в MAMBO SHOP (shop.mambo.zzz.com.ua). Якщо це зробили ви, перейдіть по посиланню, щоб завершити процес:'._LOCATION_.'register/conf.php?d=39&i='.$rowd['id'].'&c='.$code.' . В іншому випадку нічого робити не потрібно';
						mail($_POST['email'],"Відновлення паролю - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
						que('UPDATE users SET conf_c="'.$code_f.'" WHERE id="'.$rowd['id'].'"');
						echo '<p class="title">На вказану пошту прийшло повідомлення для відновленення паролю</p>';
					}
				}
				if($d==1 || !isset($_POST['email'])) {
					if($codes[3]==$_GET['c']){
						echo '<form id="login" method="post" action="conf.php?d=40">
								Пошта:<input type="text" name="email" value="'.$_POST['email'].'" class="f_i_t" required="required" autocomplete="on" placeholder="Логін"><br>
								<input type="submit" value="Готово">
							</form>';
					}
					else echo '<p class="title">Посилання використано або неробоче</p>';
				}
			}
			else {
				que("SELECT conf,r_date,conf_c FROM users WHERE id='".$_GET['i']."'");
				$row=mysql_fetch_array($res);
				if($row['conf']!=1 && $codes[0]==$_GET['c']){
					$code_f=':'.$codes[1].':'.$codes[2].':'.$codes[3];
					que('UPDATE users SET conf=1, conf_c="'.$code_f.'" WHERE id="'.$_GET['i'].'"');
					echo '<p class="title">Пошта успішно підтверджена. Дякуємо!<br>Щоб перейти на головну сторінку, натисніть <a href="'._LOCATION_.'">сюди</a><br>Щоб перети в ваший профіль, натисніть <a href="'._LOCATION_.'profile/">сюди</a></p>';
				}
				else echo '<p class="title">Посилання використано або неробоче</p>';
			}
		}
		else echo '<p class="title">Посилання використано або неробоче.</p>';
		echo '</div>';
		c(1);?>
	</body>
</html>