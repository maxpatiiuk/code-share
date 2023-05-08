<!-- login -->
<!DOCTYPE html>
<html>
	<head>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<?php
			$link=$_GET['l'];
			if($link=='shop')
				 $link='';
			include '../functions/main.php';
			head('Вхід','Ввійдіть в свій акаунт MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси та інші.','Вхід mambo shop, mambo shop акаунт, mambo shop вхід, login',0,0,0,1);
		?>
	</head>
	<body>
		<?php menu();?>
		<?php c('profile')?>
			<h1 class="title">Вхід</h1>
			<?php
				$d=1;
				if(isset($_POST["login"]) && isset($_POST["pass"])) {
					$login=str_rot13(preg_replace('/[^@-Za-z0-9\.+-_\-]/', '', $_POST['login']));
					$pas=str_rot13(preg_replace('/[^A-Za-z0-9+-_\-]/', '', $_POST['pass']));
					$hesh=md5($login).md5('Ag5l').md5($pas);
					que("SELECT r_ip,date,ip,id,ip1,ip2 FROM users WHERE login='".$login."' AND val='".$pas."'");
					$row=mysql_fetch_array($res);
					$u1=mysql_num_rows($res);
					if($u1!=1){
						$hesh=md5(str_rot13(strtolower($login))).md5('Ag5l').md5($pas);
						que("SELECT r_ip,date,ip,id,ip1,ip2 FROM users WHERE email='".str_rot13(strtolower($login))."' AND val='".$pas."'");
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
									echo 'Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, нажміть <a href="'._LOCATION_.'">сюди</a><br>';
									header("Location: "._LOCATION_.$link);
								}
								echo '</p>';
								que("UPDATE users SET ip='".$ip."', hesh='".$hesh."', date='".date('H:i:s d:m:y')."' WHERE id='".$id."'");
								setcookie("hesh", $hesh, time()+60*60*24*2, "/"); 
								$is_loggined=1;
								$i=0;
							}
						}
						else {
							echo '<div class="war">Неправильний логін/пароль</div>';
							$is_loggined=0;
							setcookie("hesh", "", time()-60*60*24*2, "/"); 
							$i=$_POST['i']+1;
						}
					}
				}
				if(!$is_loggined){
					?>
						<form id="login" method="post" action="<?=_LOCATION_?>login/">
							<input class="f_i_t" name="login" type="text" autocomplete="on" maxlenght="20" required="required" placeholder="Логін/Пошта" autofocus>
							<input class="f_i_t" name="pass" type="password" autocomplete="off" maxlenght="40" required="required" placeholder="Пароль">
							<input type="hidden" name="link" value="<?=$link?>">
							<input type="hidden" name="i" value="<?=$i?>">
							<?php
							if($i>2) echo '<div class="g-recaptcha" data-sitekey="6LfnjSIUAAAAANkRfSYdlIGK4H4sveFTjeOIdysV"></div>';
							?>
							<a class="but l" href="<?=_LOCATION_?>register/">Реєстрація</a>
							<a class="but l" href="<?=_LOCATION_?>register/conf.php?d=40">Забули пароль?</a>
							<input class="but l" type="submit" value="Вхід">
						</form>
					<?php
				}
			?>
		<?php c(1)?>
	</body>
</html>