<!DOCTYPE html>
<html>
	<head>
		<?php
			include 'functions/main.php';
			head('','','Головна, сайт в гостях у мамбо, офіційний сайт в гостях у mambo',1);
		?>
	</head>
	<body>
		<?php menu();
		echo '<div class="l">';
		que("SELECT * FROM posts WHERE vis=1 ORDER BY unix+0");
		while ($row=mysql_fetch_array($res)){
			echo '<div class="posts">
				<img class="l" src="'.$row['src'].'">
				<a class="ar" href="'._LOCATION_.'posts/'.$row['id'].'/">'.$row['name'].'</a>
				<div>
					<br><img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
					<p>'.$row['time'].'</p>
				</div>
				<p>'.substr(preg_replace("/<[^>]+>/", " ", $row['text']),0,501	).'...</p>
			</div>';
		}
		echo '</div><div class="r">'.menu_2().'</div>';
		c()?>
	</body>
</html>