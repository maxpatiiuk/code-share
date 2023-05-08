<!-- Encoding -->
<!DOCTYPE html">
<html>
	<head>
		<?php
		$lang = $_GET['lang'];
		include "../data.php";
		if($lang=="ua"){
			include "../head_ua.php";
			top_ua(9);
			$l=0;
		}
		else {
			include "../head_en.php";
			top_en(9);
			$l=1;
		}
		head("../");
		?>
	</head>
	
	<body>
		<div class="content">
			<center>
				<h1><?=$cont[6][$l]?></h1>
				<a href="<?=$cont[3][0]?><?=$cont[5][0]?>" class="t-list l"><?=$cont[5][0]?></a>
			</center>
		</div>
	</body>
</html>