<!-- add.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<title>Додати нового клієнта</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<header></header>
		<div class="cont">
			<h1>Додати нового клієнта</h1><br>
			<?php
				if(isset($_POST["Name"])){
					$mysql_login='MYSQL_LOGIN';
					$mysql_host='MYSQL_HOST';
					$mysql_pass='MYSQL_PASSWORD';
					$mysql_db='MYSQL_DB';
					$db=mysql_connect($mysql_host,$mysql_login,$mysql_pass);
					mysql_select_db($mysql_db,$db);

					$name=addslashes($_POST['Name']);
					$surname=addslashes($_POST['SurName']);
					$contacts=addslashes($_POST['Contacts']);
					$sale=addslashes($_POST['Sale']);
					$products=addslashes($_POST['Products']);//1
					mysql_query("INSERT INTO base VALUES ('', '".$name."', '".$surname."', '".$contacts."', '".$sale."', '".$products."')") or die(mysql_error());
					echo '<br><p>Клієнта додано!</p><br><a href="list.php">Переглянути всіх клієнтів</a>
						<br><a href="index.php">На головну</a>';
				}
				else {?>
					<form action="add.php" method="post">
						Ім'я: <input type="text" name="Name"></a><br>
						Прізвище: <input type="text" name="SurName"></a><br>
						Контакти: <input type="text" name="Contacts"></a><br>
						Знижка: <input type="text" name="Sale"></a><br>
						Продукція: <input type="text" name="Products"></a><br>
						<input type="submit" value="Додати">
					</form>
			<?php
				}
			?>
		</div>
		<footer></footer>
	</body>
</html>