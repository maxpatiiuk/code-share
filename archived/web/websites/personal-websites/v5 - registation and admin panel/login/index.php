<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			include '../api/lrp.php';
			head('Вхід','Ввійдіть в свій акаунт MAMBO, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси та інші.','Вхід mambo, mambo акаунт, mambo вхід, login',0,0,0,1);
		?>
	</head>
	<body>
		<?php menu();
		echo '<h1 class="title">Вхід</h1><br>';
		l(_LOCATION_);
		c()?>
	</body>
</html>