<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include 'functions/main.php';
			head();
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(1)?>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-2 col-sm-8">
				<div class="row"><br> <?php
					if(_TYPE_==2)
						echo '<div class="col-xs-12">
							<a class="btn btn-goldi" href="'.LINK.'adm/">Товари</a>
							<a class="btn btn-goldi" href="'.LINK.'adm/stats.php">Інформація</a>
						</div><br>';
					que('SELECT name'._LANGUAGE_.',price'._LANGUAGE_.',unixTime FROM '._PRODUCTS_.' WHERE vis=1 ORDER BY id+0');
					while($row=mysql_fetch_array($res)){
						echo '<a href="p/a'.$row['unixTime'].'" class="post col-xs-6 col-sm-4 col-md-3">
							<div class="postImg">
								<img src="'.getAva(1,LINK.'p/a'.$row['unixTime'].'/i1.').'" alt="'.$row['name'._LANGUAGE_].'">
							</div>
							<div class="postName">'.$row['name'._LANGUAGE_].'</div>
							<div class="postPrice">'.$row['price'._LANGUAGE_].getCurency().'</div>
						</a>';
					} ?>
				</div>
			</div>
		</div>
		<?php footer(1)?>
	</body>
</html>