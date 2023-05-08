<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			require_once '../functions/main.php';
			require_once _API_;
			head(0, 0, 'Реєстрація', 'Реєстрація, register, Створити акаунт, Реєстрація в Науковому блозі',1);
		?>
	</head>
	<body>
		<?php top();
		r(_USERS_, LINK, _DOMAIN_,'Дякуємо за реєстрацією в Науковому блозі ('.LINK.'). Для підтвердження пошти, перейдіть по цьому посиланню - ',_EMAIL_, 'Науковий блог');
		down();?>
	</body>
</html>