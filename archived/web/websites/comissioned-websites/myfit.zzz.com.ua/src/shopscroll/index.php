<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head();
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body><?php
		que('SELECT name,value FROM '._MV_.' WHERE name LIKE "h%"');
		for($i=1;$i<=14;$i++){
			$row=mysql_fetch_assoc($res);
			$name=$row['name'];
			$$name=nl2br($row['value']);
		} ?>
		<?php top(0,1,2) ?>
		<div class="clearContainer1 middle">
			<div class="container"> <?php
				if(_TYPE_==2)
					echo '<div>
						<a class="btn btn-goldi" href="'.LINK.'adm/stats.php">Інформація</a>
					</div>';
				for($i=0;$i<5;$i++){
					$n1='h'.($i*2+4);
					$n2='h'.($i*2+4+1);
							echo '<div class="element">
								<div class="imageContainer">
									<div style="background-image:url('.getAva(0,LINK.'images/shop'.($i+1).'_.').')"></div>
								</div>
								<h3>'.$$n1.'</h3>
								<p>'.$$n2.'</p>
								<a href="/t/p'.($i+1).'/">Детальніше</a>
							</div>';
				} ?>
			</div>
		</div>
	</body>
</html>