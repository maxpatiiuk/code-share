<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include 'main.php';
			head('Замовити тренування');
			que('SELECT value FROM '._MV_.' WHERE name="tPage'.$n.'"');
			$row=mysql_fetch_array($res);
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1)?>
		<div class="clearContainer1">
			<div class="container userStyles"><?php
				if(_TYPE_==2)
					echo '<a class="btn btn-goldi" href="'.LINK.'adm/editt.php?n='.$n.'">Редагувати</a>';
				echo htmlspecialchars_decode($row['value']);
				//.'<br><br><a href="http://dolgie-leta.ru/sections/proper_nutrition/food_ration/" target="_blank">Онлайн калькулятор раціону харчування</a>' ?>
			</div>
			<?=footer()?>
		</div>
	</body>
</html>