<!-- Profile -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			require_once '../functions/main.php';
			require_once _API_;
			head('Профіль','Профіль, особистий кабінет в mambo shop, акаунт mambo shop, mambo shop акаунт, mambo shop мій профіль, profile','Ввійдіть в свій акаунт MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси, відгуки та інші',0,0);
		?>
	</head>
	<body>
		<?php top(0,1);
		echo '<div class="clearContainer1"><div class="container-fluid">';
			p(LINK,_USERS_,_DOMAIN_,_EMAIL_,_NAME_);
		echo '</div></div>';  ?>
	</body>
</html>