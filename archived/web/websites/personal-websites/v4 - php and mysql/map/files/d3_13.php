<!DOCTYPE html>
<html>
	<head>
		<style>
		* {
			padding: 0;
			margin: 0;
			text-decoration: none;
			border: none;
			outline: none;
		}
		.col {
			width: 32vw;
			min-height: 96vh;
			float: left;
		}
		textarea {
			max-width: 31.5vw;
			width: 31.5vw;
			height: 10vh;
		}
		body {
			background: #ccc;
			color: #444;
			padding: 1vh 1vw;
		}
		</style>
	</head>
	<body>
		<?php
		function f(){
			global $q1;
			if($_POST['plat']==0)
				$q1.=" Steam";
			if($_POST['plat']==1)
				$q1.=" Uplay";
			if($_POST['plat']==2)
				$q1.=" Origin";
			if($_POST['plat']==3)
				$q1.=" Social Club";
			if($_POST['plat']==4)
				$q1.=$_POST['platf'];
			if($_POST['plat']==5)
				$q1.=" Mojang";
		}
		if(isset($_POST['game'])){
			$q1="Після оплати, ви моментально отримуєте <b>";
			if($_POST['type']==0){
				$q1.="акаунт ";
				f();
				$q1.=" з грою ".$_POST['game']."</b>. Також на акаунті можуть бути й інші ігри, які йдуть в якості бонусу";
			}
			if($_POST['type']==1){
				$q1.="ключ для активації ".$_POST['game']." в ваший акаунт ";
				f();
				$q1.='</b>';
			}
			if($_POST['type']==2){
				$q1.="посилання для активації ".$_POST['game']." в ваший акаунт ";
				f();
				$q1.='</b>';
			}
			if($_POST['desc'])
				$q1.='<br><br>'.$_POST['desc'];
			if($_POST['q1'])
				$q1.='<br><br>'.$_POST['q1'];
			if($_POST['main'])
				$q2="<b>Важлива інформація</b><br>".$_POST['main'].'<br><br>';
			if($_POST['type']==1 && $_POST['plat']==0)
				$q2.="<b>Інструкція</b><br>1. Завантажити Steam і зареєструваися в ньому / Відкрити Steam і ввійти в свій акаунт<br>2. Перейти в розділ \"Бібліотека\" і в лівому верхньому куту вибрати пункт \"Добавити гру\", потім \"Активувати в Steam\"<br>3. Ввести ключ<br>4. Після активації гра появиться в списку ігор, і Ви зможете завантажити її з Steam";
			else if($_POST['type']==0 && $_POST['plat']==5 && preg_match('/inecraft/',$_POST['game']))
				$q2.="<b>Інструкція</b><br>Для гри вам потрібно завантажити офіційний або пірацький лаунчер (TLauncher)<br>Завантажити офіційний лаунчер -<a href='https://launcher.mojang.com/download/MinecraftInstaller.msi'><b> нажміть сюди</b></a><br>При вході в офіційний лацнчер введіть дані (логін і пароль) який ви отримали після купівлі.<br>Приємної гри!";
			else if($_POST['type']==0 && $_POST['plat']==3)
				$q2.="<b>Інструкція</b><br>1. Знімайте прорцес купівлі та оплати на відео!<br>2. Заходимо в профіль <a href =&#34;https://ru.socialclub.rockstargames.com/activate&#34; target=&#34;_blank&#34;>Social Club</a><br>3. Змініть дані для входу (пошту, пароль, та інші)<br>4. Завантажити лаунчер GTA V і авторизуватися в лаунчері в свій акаунт";
			else if($_POST['inst'])
				$q2.="<b>Інструкція</b><br>".$_POST['inst'];
			if($_POST['q2'])
				$q2.='<br><br>'.$_POST['q2'];
			if($_POST['m1'] || $_POST['m2'] || $_POST['m3'] || $_POST['m4'] || $_POST['m5']){
				$q3="<b>Мінімальні системні вимоги</b>";
				if($_POST['m1'])
					$q3.='<br>ОС: '.$_POST['m1'];
				if($_POST['m2'])
					$q3.='<br>Процесор: '.$_POST['m2'];
				if($_POST['m3'])
					$q3.='<br>Відеокарта: '.$_POST['m3'];
				if($_POST['m4'])
					$q3.='<br>ОЗУ: '.$_POST['m4'].'ГБ';
				if($_POST['m5'])
					$q3.='<br>Вільного місця на диску: '.$_POST['m5'].' гб';
			}
			if($_POST['r1'] || $_POST['r2'] || $_POST['r3'] || $_POST['r4'] || $_POST['r5']){
				$q3.="<br><br><b>Рекомендовані системні вимоги</b>";
				if($_POST['r1'])
					$q3.='<br>ОС: '.$_POST['r1'];
				if($_POST['r2'])
					$q3.='<br>Процесор: '.$_POST['r2'];
				if($_POST['r3'])
					$q3.='<br>Відеокарта: '.$_POST['r3'];
				if($_POST['r4'])
					$q3.='<br>ОЗУ: '.$_POST['r4'].'ГБ';
				if($_POST['r5'])
					$q3.='<br>Вільного місця на диску: '.$_POST['r5'].' гб';
			}
			if($_POST['q3'])
				$q3.='<br><br>'.$_POST['q3'];
			$pat=array('/"/','/\'/','/</','/>/');
			$rep=array('&#34;','&#39;','&#60;','&#62;');
			echo '<div class="col">'.preg_replace($pat,$rep,$q1).'</div><div class="col">'.preg_replace($pat,$rep,$q2).'</div><div class="col">'.preg_replace($pat,$rep,$q3).'</div>';
		}
		else {
			?>
			<form method="post">
				<div class="col">
					<h2>Опис</h2><br>
					<label><input type="radio" value="0" name="type">Акаунт</label>
					<label><input type="radio" value="1" name="type">Ключ</label>
					<label><input type="radio" value="2" name="type">Посилання</label><br>
					<label><input type="radio" value="0" name="plat">Steam</label>
					<label><input type="radio" value="1" name="plat">Uplay</label>
					<label><input type="radio" value="2" name="plat">Origin</label>
					<label><input type="radio" value="3" name="plat">Social Club</label>
					<input type="radio" value="4" name="plat"><input type="text" name="platf" placeholder="назва платформи"><br>
					<label><input type="radio" value="5" name="plat">Mojang</label>
					<input type="text" name="game" placeholder="Назва гри"><br>
					Опис гри:<br>
					<textarea name="desc"></textarea><br>
					Додатково?<br>
					<textarea name="q1"></textarea>
				</div>
				<div class="col">
					<h2>Інструкція</h2><br>
					Важлива інформація:<br>
					<textarea name="main"><br></textarea><br>
					Інструкція:<br>
					<textarea name="inst"><br></textarea><br>
					Додатково?<br>
					<textarea name="q2"></textarea>
				</div>
				<div class="col">
					<h2>Системні вимоги</h2><br>
					Мінімальні системні вимоги:<br>
					ОС: <input type="text" name="m1"><br>
					Процесор: <input type="text" name="m2"><br>
					Відеокарта: <input type="text" name="m3"><br>
					ОЗУ: <input type="text" name="m4"> гб<br>
					Вільного місця на диску: <input type="text" name="m5"> гб<br>
					Рекомендовані системні вимоги:<br>
					ОС: <input type="text" name="r1"><br>
					Процесор: <input type="text" name="r2"><br>
					Відеокарта: <input type="text" name="r3"><br>
					ОЗУ: <input type="text" name="r4"> гб<br>
					Вільного місця на диску: <input type="text" name="r5"> гб<br>
					Додатково?<br>
					<textarea name="q3"></textarea>
				</div>
				<input type="submit" name="generate">
			</form>
		<?php } ?>
	</body>
</html>