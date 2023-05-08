<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			require_once _API_;
			head(0, 0, '', '');
		?>
	</head>
	<body>
		<?php top();
		co(_USERS_,_DOMAIN_,$_GET['i'],$_GET['c'],$_GET['d']);
		down();?>
	</body>
<html>