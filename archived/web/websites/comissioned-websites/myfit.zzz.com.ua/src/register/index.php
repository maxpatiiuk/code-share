<!-- Register -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			require_once '../functions/main.php';
			require_once _API_;
			head('Реєстрація','Реєстрація, реєстрація в mambo shop, створити акаунт, створити акаунт в mambo shop, зареєстуватися, зареєстуватися в mambo shop, реєстрація mambo shop, mambo shop зареєстуватися, mambo shop акаунт, register','Зареєструйте власний акаунт в MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси, відгуки та інші',0,0);
		?>
	</head>
	<body>
		<?php top(0,1);
		echo '<div class="clearContainer1"><div class="container">';
			r(_USERS_,LINK,_DOMAIN_,'Дякуємо за реєстрацією в MAMBO SHOP ('._DOMAIN_.'). Для підтвердження пошти, перейдіть по цьому посиланню - ', _MAIL_, _NAME_);
		echo '</div></div>';?>
	</body>
</html>