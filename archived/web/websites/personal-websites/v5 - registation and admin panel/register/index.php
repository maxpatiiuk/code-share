<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			include '../api/lrp.php';
			head('Реєстрація','Зареєструйте власний акаунт в MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси та інші.','Реєстрація mambo shop, mambo shop зареєстуватися, mambo shop акаунт, register, Реєстрація на сайті mambo',0,0,0,1);
		?>
	</head>
	<body>
		<?php menu();
		echo '<h1 class="title">Вхід</h1><br>';
		r('users', _LOCATION_);
		c()?>
	</body>
</html>