<!-- profile -->
<!DOCTYPE html>
<html>
<head>
	<?php
	include '../functions/main.php';
	head('Профіль','Ввійдіть в свій акаунт MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси та інші.','Вхід mambo shop, mambo shop акаунт, mambo shop вхід, profile',0,1,0,1);
	?>
	<style>
		.colors div {
			display: inline;
		}
		.colors input {
			display: none !important;
		}
		div:first-child span {
			background: #000;
		}
		input[type="radio"]:checked + label span {
			border: 5px solid #CC3300;
		}
		input[type="radio"] + label span {
			border: 5px solid #ccc;
			display: inline-block;
			width: 2vw;
			height: 2vw;
			margin: 0 0 0.4vw 0;
			vertical-align: middle;
			cursor: pointer;
			-moz-border-radius: 50%;
			border-radius: 50%;
		}
		.colors div:last-child span {
			background: #fff;
		}
	</style>
</head>
<body>
	<?php menu();?>
	<?php c('profile')?>
		<?php
		function is_em($mail) {
			$user = '[a-zA-Z0-9_\-\.\+\^!#\&*+\/\=\?`\|\{\}~\']+';
			$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+';
			return preg_match("/^$user@$domain$/", $mail);
		}
		function a_link($name){
			global $id, $row;
			if(isset($_POST[$name]) && $_POST[$name]!=$row[$name]){
				if(preg_match('/^[a-zA-Z0-9_:#\/\?\&\.]{5,255}$/', $_POST[$name])){
					echo '<br>'.ucfirst($name).' акаунт успішно додано';
					que('UPDATE users SET '.$name.'="'.$_POST[$name].'" WHERE id="'.$id.'"');
				}
				else echo '<br>Вкажтіть правильне посилання на ваший '.ucfirst($name).' акаунт';
			}
		}
		function err(){
			global $id,$u;
			echo '<br>Користувача не знайдено!<br> <a href="'._LOCATION_.'">Повернутися на головну</a><br>.';
			if($u)
				echo '<a href="'._LOCATION_.'profile/?id='.$id.'">Перейти в свій акаунт</a>';
			else 
				echo '<a href="'._LOCATION_.'login">Ввійти в акаунт</a><br>
			<a href="'._LOCATION_.'register">Реєстрація</a>';
		}
		$hesh=preg_replace('/[^A-Za-z0-9\-]/', '', $_COOKIE['hesh']);
		que('SELECT * FROM users WHERE hesh="'.$hesh.'"');
		$row=mysql_fetch_array($res);
		$id=$row['id'];
		$u=$is_log=mysql_num_rows($res);//u = is logined
		$id2=preg_replace('/[^0-9]/', '', $_GET['id']);
		que('SELECT * FROM users WHERE id="'.$id2.'"');
		$row2=mysql_fetch_array($res);
		$u2=mysql_num_rows($res);// does this profile exist
		if(isset($_GET['id']) && preg_match('/^[0-9]{1,6}$/', $_GET['id'])){
			if($u){
				if($_GET['id']==$id){
					?>
					<div class="tabs">
						<button id="b1" class="b cur" onclick="openC('a1', 'b1')">Профіль</button>
						<button id="b2" class="b" onclick="openC('a2', 'b2')">Безпека</button>
						<button id="b3" class="b" onclick="openC('a3', 'b3')">Додатково</button>
						<button onclick="redir('<?=_LOCATION_?>profile/?d=all')">Користувачі</button>
						<button onclick="redir('<?=_LOCATION_?>profile/out.php')">Вихід</button>
					</div>
					<div id="a1" class="tab_c">
						<?php
						que('SELECT * FROM users WHERE hesh="'.$hesh.'"');
						$row=mysql_fetch_array($res);
						if (isset($_POST['login']) && str_rot13($row['login'])!=$_POST['login']){
							que("SELECT id FROM users WHERE login='".str_rot13($_POST['login'])."'");
							$row2=mysql_fetch_array($res);
							$u=mysql_num_rows($res);
							if($u!=0){
								$d=1;
								echo '<br>Логін зайнятий! Спробуйте інший';
							}
							else if(preg_match("/^[a-zA-Z0-9+-_]{3,60}$/",$_POST['login'])){
								echo '<br>Логін успішно змінений.';
								$code=substr(md5(microtime()),rand(0,26),5);
								$message="Ім'я вашого акаунту в MAMBO SHOP (shop.mambo.zzz.com.ua) змінено. Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть за цим посиланням щоб змінити логін на попередній та захистити свій акаунт: "._LOCATION_."register/conf.php?d=37&i=".$row['id']."&c=".$code." .";
								echo var_dump(rename('../images/p/'.str_rot13($row['login']).'.'.$src,'../images/p/'.$_POST['login'].'.'.$src));
								mail($row['email'],"Зміна логіну - Mambo Shop",$message,"From: max@patii.uk", 'Content-Type: text/html; charset="utf-8"');
								que("SELECT conf_c FROM users WHERE id='".$id."'");
								$row=mysql_fetch_array($res);
								$codes=preg_split('/:/',$row['conf_c']);
								$code_f=$codes[0].':'.$code.':'.$codes[2].':'.$codes[3];
								que('UPDATE users SET conf_c="'.$code_f.'", login="'.str_rot13($_POST['login']).'" WHERE id="'.$id.'"');
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
									que('UPDATE users SET conf=0, conf_c="'.$code_f.'", email="'.$_POST['email'].'" WHERE id="'.$id.'"');
									$message='Зміна пошти в MAMBO SHOP (shop.mambo.zzz.com.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити пошту на попередню та захистити свій акаунт:'._LOCATION_.'register/conf.php?i='.$id.'&d=38&c='.$code;
									echo $message;
									mail($row['email'],"Зміна пошти - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
									$message='Підтвердження пошти - MAMBO SHOP (shop.mambo.zzz.com.ua). Для підтвердження пошти, перейдіть по цьому посиланню - '._LOCATION_.'register/conf.php?i='.$id.'&c='.$code2;
									mail($_POST['email'],"Підтвердження пошти - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else echo '<br>Пошта повина містити лише латинські букви, цифри та бути в форматі "name@domain.com"';
						}
						if(isset($_POST['phone']) && $_POST['phone']!='' && $_POST['phone']!=$row['phone']){
							if(preg_match('/^\+[0-9]{0,20}$/', $_POST['phone'])){
								que('UPDATE users SET phone="'.$_POST['phone'].'" WHERE id="'.$id.'"');
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
									que('UPDATE users SET img="'.$t.'" WHERE id="'.$id.'"');
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
							que('SELECT * FROM users WHERE hesh="'.$hesh.'"');
							$row=mysql_fetch_array($res);
							if (isset($_REQUEST['use_ip']) && ($_POST['ip1']!=$row['ip1'] || $_POST['ip2']!=$row['ip2'])){
								if($_POST['ip1']==$_POST['ip2']) echo '<br>IP адреси не повині співпадати';
								else {
									if((isset($_POST['ip1']) && preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_POST['ip1'])) || (isset($_POST['ip2']) && preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_POST['ip2']))){
										if(strlen($_POST['ip1'])>1 && strlen($_POST['ip2'])<1){
											que('UPDATE users SET ip1="'.$_POST['ip1'].'" WHERE id="'.$id.'"');
											echo '<br>IP адресу №1 успішно додано';
										}
										else if(strlen($_POST['ip2'])>1 && strlen($_POST['ip1'])<1){
											que('UPDATE users SET ip1="'.$_POST['ip2'].'" WHERE id="'.$id.'"');
											echo '<br>IP адресу успішно додано';
										}
										else {
											que('UPDATE users SET ip1="'.$_POST['ip1'].'", ip2="'.$_POST['ip2'].'" WHERE id="'.$id.'"');
											echo '<br>IP адреси №1 та №2 успішно додано';
										}
									}
									else echo '<br>Введіть IP адреси, які будуть допущені для входу в ваший акаунт (в форматі 255.255.255.255)';
								}
							}
							if(!isset($_REQUEST['use_ip'])){
								que('UPDATE users SET ip1="", ip2="" WHERE id="'.$id.'"');
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
									que('UPDATE users SET conf_c="'.$code_f.'", val="'.$pas.'" WHERE id="'.$id.'"');
									echo '<br>Пароль успішно змінено';
									$message='Зміна паролю в MAMBO SHOP (shop.mambo.zzz.com.ua). Якщо це зробили ви, хвилюватиcя не потрібно. В іншому випадку, перейдіть по цьому посиланню щоб змінити логін на попередній та захистити свій акаунт:'._LOCATION_.'register/conf.php?d=39&i='.$id.'&c='.$code;
									mail($row['email'],"Зміна паролю - Mambo Shop",$message,"From: max@patii.uk", "Content-Type: text/html; charset='utf-8'");
								}
							}
							else if(strlen($_POST['pass1'])>1 || strlen($_POST['pass2'])>1 || strlen($_POST['pass3'])>1) echo '<br>Щоб змінити пароль, потрібно вказати попередній пароль та новий два рази';
							echo var_dump($_POST['vis']);
							echo var_dump($row['vis']);
							if($_POST['vis']!=$row['vis'] && $_POST['vis']!=NULL){
								que('UPDATE users SET vis="'.$_POST['vis'].'" WHERE id='.$id);
							}
							/*if($row['d_in']!=$_POST['d_in']){
								switch ($_POST['d_in']) {
									case 1:
										if(isset($_POST['']))
										que('UPDATE users SET d_in="1" WHERE id="'.$id.'"');
										echo '<br>Двійний вхід вимкнуто';
									case 2:
										que('UPDATE users SET d_in="2" WHERE id="'.$id.'"');
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
							que('SELECT * FROM users WHERE hesh="'.$hesh.'"');
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
			que('SELECT id FROM users');
			$u=mysql_num_rows($res);
			$q='SELECT img,login,id FROM users WHERE vis';
			if($is_log){
				echo '<div class="tabs">
						<button onclick="redir(\''._LOCATION_.'profile/\')">Профіль</button>
						<button class="cur" onclick="redir(\''._LOCATION_.'profile/?d=all\')">Користувачі</button>
						<button onclick="redir(\''._LOCATION_.'profile/out.php\')">Вихід</button>
					</div>';
				$q.='!=2';
			}
			else $q.='=0';
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
				else $srr=_LOCATION_.'images/p/'.str_rot13($row['login']).'.'.$src2;
				echo '<a class="title l" href="'._LOCATION_.'profile/?id='.$row['id'].'">
					<img class="l_f" src="'.$srr.'">
					<p>'.str_rot13($row['login']).'</p>
				</a>';
			}
		}
		if($buf==10){//$is_log
			que('SELECT img,login,email,phone,facebook,youtube,twiter,instagram,vk,vis FROM users WHERE id="'.$_GET['id'].'"');
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
				else $srr=_LOCATION_.'images/p/'.str_rot13($row['login']).'.'.$src2;
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
				echo 'Виконайте вхід в ваший акаунт, щоб побачити цей профіль. <a href="'._LOCATION_.'login/">Вхід</a>';
			else
				echo 'Цей профіль приватний!';
			echo '<div>';
		}
		else if($_GET['d']!='all' && $buf!=10 && !isset($_GET['id'])){
			if($u){
				header("Location: "._LOCATION_."profile/?id=".$row['id']);
			}
			else {
				echo '<p class="title"><a href="'._LOCATION_.'login">Ввійти в акаунт</a><br>
				<a href="'._LOCATION_.'register">Реєстрація</a></p>';
			}
		}
		?>
	<?php c(1)?>
	<script>
		function redir(where) {
			window.location.href = where;
		}
	</script>
</body>
</html>