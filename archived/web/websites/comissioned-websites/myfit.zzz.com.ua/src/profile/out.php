<!-- Profile -->
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
		<?php top(0,1);
		echo '<div class="clearContainer1"><div class="container">';
			o(_DOMAIN_);
		echo '</div></div>';  ?>
	</body>
</html>