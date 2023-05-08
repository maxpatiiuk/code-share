<!-- add.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<title>Список клієнтів</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<header></header>
		<div class="cont">
			<h1>Список клієнтів</h1><br>
			<p>Щоб видалити клієнта, натисніть на потрібний рядок</p><br>
			<table>
				<tr>
					<th>id</th>
					<th>Name</th>
					<th>SurName</th>
					<th>Contancts</th>
					<th>Sale</th>
					<th>Products</th>
				</tr>
				<?php
				$mysql_login='MYSQL_LOGIN';
				$mysql_host='MYSQL_HOST';
				$mysql_pass='MYSQL_PASSWORD';
				$mysql_db='MYSQL_DB';
				mysql_connect($mysql_host,$mysql_login,$mysql_pass);
				mysql_select_db($mysql_db);

				if($_GET['id'])
					mysql_query('ALTER TABLE base AUTO_INCREMENT=0;') or die(mysql_error());
				$query = "SELECT * FROM base";
				$res = mysql_query($query) or die(mysql_error());
				while ($row=mysql_fetch_array($res))
				{
					global $ii;
					$ii++;
					$id=$row['id'];
					$name=$row['Name'];
					$surname=$row['SurName'];
					$contacts=$row['Contacts'];
					$sale=$row['Sale'];
					$products=$row['Products'];	
					echo '<tr>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$id.'</a></td>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$name.'</a></td>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$surname.'</a></td>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$contacts.'</a></td>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$sale.'</a></td>
							<td><a href="http://mambo.in.ua/mysql/delete.php?id='.$id.'">'.$products.'</a></td>
						</a></tr>';
				}
				if($ii<=0)
					echo '<tr>
							<td>В</td>
							<td>Базі</td>
							<td>Даних</td>
							<td>Нема</td>
							<td>Жодного</td>
							<td>Клієнта</td>
						</a></tr>';
			?>
			</table><br>
			<a href="add.php">Додати новго клієнта</a><br>
			<a href="list.php?do=1">Скинути рахунок id</a><br>
			<a href="index.php">На головну</a>
		</div>
		<footer></footer>
	</body>
</html>