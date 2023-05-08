<!-- register -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			head('Реєстрація','Зареєструйте власний акаунт в MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси та інші.','Реєстрація mambo shop, mambo shop зареєстуватися, mambo shop акаунт, register',0,0,0,1);
		?>
	</head>
	<body>
		<?php menu();?>
		<?php c('profile')?>
			<h1 class="title">Реєстрація</h1>
			<?php
				if(!isset($_POST['login']) && !isset($_POST['pass']) && !isset($_POST['login']) && !isset($_POST['d_pass']) && !isset($_POST['email'])){
					$d=1;
				}
				else {
					$login=$_POST['login'];
					$pass=$_POST['pass'];
					function is_em( $mail ) {
						return preg_match("/^[a-zA-Z0-9\-_\.\+]{3,30}@[a-zA-Z0-9\-_\.\+]{1,15}\.[a-zA-Z0-9\-_\.\+]{1,30}$/", $mail);
					}
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
					que("SELECT id FROM users WHERE login='".mysql_real_escape_string($login)."'");
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
						que("SELECT id FROM users WHERE email='".mysql_real_escape_string($_POST['email'])."'");
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
					que('SELECT id FROM users WHERE r_ip="'.$_POST['ip'].'"');
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
						setcookie("hesh", $hesh, time()+60*60*24, "/"); 
						echo '<p class="title">Ви успішно створили акаунт!<br>Залишився останій крок: підтвердіть свою електронну адресу, перейшовши по посиланню, яке ви отримаєте в листі</p>';
						$is_loggined=1;
						$code_f=$code.':::';
						que("INSERT INTO users VALUES ('', '".$login."', '".$pas."', '".$_POST['ip']."','0', '".date('H:i:s d:m:y')."', '".date('H:i:s d:m:y')."', '".strtolower($_POST['email'])."', '".$_POST['ip']."','','".(date('z')+10)."', '1','".$code_f."','".$hesh."','1','','','','','','','','','','')");
						que('SELECT id FROM users WHERE login="'.$login.'"');
						$row=mysql_fetch_array($res);
						$message='Дякуємо за реєстрацією в MAMBO SHOP (shop.mambo.zzz.com.ua). Для підтвердження пошти, перейдіть по цьому посиланню - '._LOCATION_.'register/conf.php?i='.$row['id'].'&c='.$code;
						mail($_POST['email'],"Підтвердження пошти - Mambo Shop",$message,"Content-Type: text/html; charset='utf-8'","From: max@patii.uk");
					}
				}
				if($d==1){
					?>
						<form id="login" method="post" action="<?=_LOCATION_?>register/">
							<input class="f_i_t" name="login" type="text" value="<?=$_POST['login']?>" autocomplete="on" maxlenght="20" required="required" placeholder="Логін" autofocus>
							<input class="f_i_t" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
							<input class="f_i_t" name="d_pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Повторити пароль">
							<input class="f_i_t" name="email" type="text"  value="<?=$_POST['email']?>"autocomplete="on" maxlenght="30" required="required" placeholder="E-mail">
							<input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
							<input type="hidden" name="link" value="<?=$link?>">
							<br>Ви ознайомлені з <a class="f-l-link" href="<?=_LOCATION_?>faq/?t=rules">правилами?</a><br>
							<a href="<?=_LOCATION_?>login/" class="but l">Вхід</a>
							<input class="but l" type="submit" value="Реєстрація">
						</form>
					<?php
				}
			?>
		<?php c(1)?>
	</body>
</html>