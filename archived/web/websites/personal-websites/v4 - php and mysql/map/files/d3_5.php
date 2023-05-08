<!DOCTYPE html>
<html>
	<head>
		<title>D3_5</title>
		<meta charset="utf-8">
		<link href="d3_5.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="content">
			<h1>Виставка картин</h1>
			<div class="cont">
				<?php
					function c($src,$p){
						echo '
							<div class="photo">
								<img src="'.$src.'" alt="'.$p.'"></img>
								<p>'.$p.'</p>
							</div>';
					};
					c("https://s8.hostingkartinok.com/uploads/images/2017/04/0fb98fa70f89f552a618fd86770bea40.jpg","Крик");
					c("https://s8.hostingkartinok.com/uploads/images/2017/04/0e833cd3376de30c94ac0c910cd35cbc.jpg","Дівчина з перлинною");
					c("https://s8.hostingkartinok.com/uploads/images/2017/04/cadb892f3db1fc088adee942569c4357.jpg","Мона Ліза");
					c("https://s8.hostingkartinok.com/uploads/images/2017/04/52e0540cc5fab503fedcb55391dfae26.jpg","Дівчина на кулі");
				?>
			</div>
		</div>
	</body>
</html>