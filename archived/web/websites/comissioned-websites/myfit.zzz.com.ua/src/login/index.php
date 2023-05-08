<!-- Register -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			require_once '../functions/main.php';
			require_once _API_;
			head('Вхід','вхід, вхід в mambo shop, Вхід mambo shop, mambo shop акаунт, mambo shop вхід, login','Ввійдіть в свій акаунт MAMBO SHOP, щоб отримати доступ до безліч можливостей: автозаповнення даних для оплати, сповіщення про акції, песональні знижки, конкурси, відгуки та інші',0,0);
		?>
	</head>
	<body>
		<?php top(0,1);
		echo '<div class="clearContainer1"><div class="container">';
			l(LINK,_USERS_,_DOMAIN_);
		echo '</div></div>';  ?>
	</body>
</html>