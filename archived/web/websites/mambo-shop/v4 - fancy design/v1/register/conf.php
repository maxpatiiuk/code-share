<!-- Register -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			require_once '../functions/main.php';
			require_once _API_;
			head();
		?>
	</head>
	<body>
		<?php top(1);
		co(_USERS_,LINK,$_GET['i'],$_GET['c'],$_GET['d']);
		footer(1); ?>
	</body>
</html>