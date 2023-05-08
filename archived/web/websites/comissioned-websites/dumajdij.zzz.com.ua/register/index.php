<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			require_once _API_;
			head(0, 0, 'Реєстрація', 'Реєстрація, register, Створити акаунт, Реєстрація в Комунікативний клуб "3D", Членство в Комунікативний клуб "3D"',1);
		?>
	</head>
	<body>
		<?php top();
		r(_USERS_, LINK, _DOMAIN_,'Дякуємо за реєстрацією в Комунікативному клубі "3D" ('.LINK.'). Для підтвердження пошти, перейдіть по цьому посиланню - ',_EMAIL_, 'Комунікативний клуб "3D"');
		down();?>
	</body>
<html>