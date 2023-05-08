<!DOCTYPE html>
<html>
	<head>
		<style>
			* {
				border: none;
				margin: 0;
				padding: 0;
				outline: none;
				background: #ccc;
				color: #aaa;
			}
			p {
				position: absolute;
				bottom: 0;
				right: 0;
			}
		</style>
	</head>
	<body>
		<?php if($_POST['t']=='secret-password') echo '<p>secret-message</p>';
		else echo '<form action="d3_10.php" method="post" enctype="multipart/form-data">
			<input type="text" name="t">
			<input type="submit" value=".">
		</form>'; ?>
	</body>
</html>