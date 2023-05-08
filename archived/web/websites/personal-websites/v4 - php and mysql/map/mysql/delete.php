<!-- add.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<title>Видалити клієнта</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<header></header>
		<div class="cont">
			<h1>Видалити клієнта</h1><br>
			<?php
				$mysql_login='MYSQL_LOGIN';
				$mysql_host='MYSQL_HOST';
				$mysql_pass='MYSQL_PASSWORD';
				$mysql_db='MYSQL_DB';
				$db=mysql_connect($mysql_host,$mysql_login,$mysql_pass);
				mysql_select_db($mysql_db,$db);
				
				if(isset($_GET["id"])){
					mysql_query("DELETE FROM base where id='".$_GET['id']."'") or die(mysql_error());
					echo '<br><p>Клієнта Видалено!</p><br><a href="list.php">Переглянути всіх клієнтів</a>
						<br><a href="index.php">На головну</a>';
				}
				else if(isset($_POST["Id"]) || isset($_POST["Name"]) || isset($_POST["SurName"]) || isset($_POST["Contacts"]) || isset($_POST["Sale"]) || isset($_POST["Products"])){
						$q="DELETE FROM base where ";
						if(isset($_POST["Nom"]))
							$q.="id='".$_POST['Nom']."'";
						else if(isset($_POST["Name"]))
							$q.="Name='".$_POST['Name']."'";
						else if(isset($_POST["SurName"]))
							$q.="SurName='".$_POST['SurName']."'";
						else if(isset($_POST["Contacts"]))
							$q.="Contacts='".$_POST['Contacts']."'";
						else if(isset($_POST["Sale"]))
							$q.="Sale='".$_POST['Sale']."'";
						else
							$q.="Products='".$_POST['Products']."'";
						mysql_query($q) or die(mysql_error());
						echo '<br><p>Клієнта видалено!</p><br><a href="list.php">Переглянути всіх клієнтів</a>
							<br><a href="index.php">На головну</a>';
					}
				else {
					?>
					<p>Вкажіть дані клієнта якого потрібно видалити (вкажіть одне або декілька полів)</p>
					<form action="delete.php" method="post">
						ID: <input type="text" name="Nom"></a><br>
						Ім'я: <input type="text" name="Name"></a><br>
						Прізвище: <input type="text" name="SurName"></a><br>
						Контакти: <input type="text" name="Contacts"></a><br>
						Знижка: <input type="text" name="Sale"></a><br>
						Продукція: <input type="text" name="Products"></a><br>
						<input type="submit" value="Видалити">
					</form>
					<?php
				}
			?>
		</div>
		<footer></footer>
	</body>
</html>