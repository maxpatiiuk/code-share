<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head(la('aboutUs'),la('aboutUs'),_ABOUT_);
			que('SELECT value FROM '._MV_.' WHERE name="aboutPage"');
			$row=mysql_fetch_array($res);
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1,1)?>
		<div class="clearContainer1">
			<div class="container userStyles"><?php
				if(_TYPE_==2)
					echo '<a class="btn btn-goldi" href="'.LINK.'adm/aboutMe.php">Редагувати</a>';
				echo htmlspecialchars_decode($row['value'])?></div>
				<?=footer()?>
			</div>
		</div>
	</body>
</html>