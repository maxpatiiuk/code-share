<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			require_once _API_;
			head(0, 0, 'Адміністування', 'Адміністування, Керування, Керування сайтом, Панель керування',1);
		?>
	</head>
	<body>
		<?php top();
		if(preg_match('/[a-z0-9]/', $_COOKIE['hesh'])){
			que('SELECT id,type FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
			$row=mysql_fetch_array($res);
			$id=$row['id'];
			$type=$row['type'];
			if($type!=2)
				$err=1;
		}
		else
			$err=1;
		if($err==1)
			echo '<div class="alert alert-danger">Доступ заборонений</div>';
		else {
			?><ul class="nav nav-tabs">
				<li class="active"><a href="#tab1">Статистика</a></li>
				<li><a href="slider.php">Слайдер</a></li>
				<li><a href="materials.php">Матеріали</a></li>
			</ul>
			<div class="container-fluid">
					<?php que("SELECT id FROM "._USERS_);
					$u=mysql_num_rows($res);
					que("SELECT id FROM "._USERS_);
					$u1=mysql_num_rows($res);
					echo 'На сайті зареєстровано '.$u. ' користувачів<br><br><form enctype="multipart/form-data" action="stats.php" method="post">';
					function controlInputs($name,$sn,$sec){
						global $res;
						que('SELECT value FROM '._MV_.' WHERE name="'.$sn.'"');
						$row=mysql_fetch_array($res);
						echo '<div class="form-group">
						<label class="control-label col-sm-2" for="a2'.$sn.'">'.$name.':</label>
						<div class="col-sm-9">
							<input id="a2'.$sn.'" value="'.$row['value'].'" class="form-control" name="'.$sn.'" placeholder="'.$sec.'">
						</div>
					</div>';
					}
					if($_GET['i']='edited' && isset($_POST['infEdit'])){
						$editedInfArr=array('about','tags','tel1','tel2','email','fblink','twlink','inlink','vklink');
						for($i=0;$i<=count($editedInfArr);$i++)
							que('UPDATE '._MV_.' SET value="'.htmlspecialchars($_POST[$editedInfArr[$i]]).'" WHERE name="'.$editedInfArr[$i].'"');
						if($_FILES['logo']['size']>0){
							switch($_FILES['logo']['type']){
								case "image/jpeg":$src2="jpeg";break;
								case "image/jfjf":$src2="jfjf";break;
								case "image/jpg":$src2="jpg";break;
								case "image/gif":$src2="gif";break;
								case "image/png":$src2="png";break;
								case "image/tiff":$src2="tiff";break;
								case "image/bmp":$src2="bmp";break;
								case "image/svg":$src2="svg";break;
							}
							if(isset($src2)){
								unlink('../images/logo.jpeg');
								unlink('../images/logo.jfjf');
								unlink('../images/logo.jpg');
								unlink('../images/logo.gif');
								unlink('../images/logo.png');
								unlink('../images/logo.tiff');
								unlink('../images/logo.bmp');
								unlink('../images/logo.tiff');
								unlink('../images/logo.svg');
								move_uploaded_file($_FILES['logo']['tmp_name'],'../images/logo.'.$src2);
								echo "<div class=\"alert alert-success\">Логотип успішно змінений. Оновіть сторінку</div>";
							}
							else
								echo "<div class=\"alert alert-danger\">Аватарка повина бути в форматі jpeg, jfjf, jpg, gif, png, swg, bmp або tiff</div>";
						}
					}
					controlInputs('Опис','about','Коротко опишіть вашу організацію');
					controlInputs('Адреса','address','Вкажіть адресу, вулицю, поштову адресу або місто');
					controlInputs('Номер телефону №1','tel1','Вкажіть номер телефону для контактів');
					controlInputs('Номер телефону №2','tel2','Вкажіть додатковий номер телефону для контактів');
					controlInputs('Пошта','email','Вкажіть електронну пошту для контакту користувачів з вами');
					controlInputs('Facebook','fblink','Вкажіть посилання на Facebook акаунт вашої організації');
					controlInputs('Twitter','twlink','Вкажіть посилання на Twitter акаунт вашої організації');
					controlInputs('Instagram','inlink','Вкажіть посилання на Instagram акаунт вашої організації');
					controlInputs('Vk','vklink','Вкажіть посилання на Vk акаунт вашої організації');
					?><div class="form-group">
						<label class="control-label col-sm-2" for="a2logo">Логотип:</label>
						<div class="col-sm-9">
							<input id="a2logo" type="file" accept="image/*" name="logo">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-xs-offset-2">
							<button type="submit" name="infEdit" class="btn btn-primary">Зберегти зміни</button>
						</div>
					</div>
					</form>
				</div><?php
		}
		down();?>
		<script>function redir(where) {window.location.href = where;}</script>
	</body>
<html>