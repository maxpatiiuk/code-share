<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once 'main.php';
			# Count number of views, unless it's an internal IP
			if($_SERVER['REMOTE_ADDR']!="--ip-was-here--")
				que("UPDATE posts SET pop=pop+1 WHERE id='".$dir."'");
			que("SELECT * FROM posts WHERE id='".$dir."'");
			$row = mysql_fetch_array($res);
			head($row['name'],$row['text'],$row['keyw'],0,0,3);
		?>
	</head>
	<body>
		<?php menu('post');
		echo '<div class="l">
			<h1 class="ar">'.$row['name'].'</h1>
			<div>
				<br><img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
				<p>'.$row['time'].'</p>
			</div>
			<img src="'.$row['src'].'">
			<p>'.$row['text'].'</p>
		</div><div class="r">'.menu_2().'</div>';
		c() ?>
	</body>
</html>