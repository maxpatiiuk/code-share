<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			head();
				if($_GET['f']=='shop' || $_GET['f']=='shop.mambo.zzz.com.ua')
					$f=NULL;
				else {
					$f=$_GET['f'].'/';
				}
		?>
	</head>
	<body>
		<?php menu();?>
		<?php c()?>
			<h1 class="title">Вихід</h1>
			<?php
				setcookie("hesh", "deleted", -10, "/"); 
				header("Location: "._LOCATION_.$f);
				echo '<div class="content r">
						<p class="title">Ви успішно вийшли!<br>Зараз відбудеться перенаправленя на іншу сторінку. Якщо ні, нажміть <a href="'._LOCATION_.$f.'">сюди</a>
						</p>				
					</div>';
			?>
		<?php c(1)?>
		<?php down();?>
	</body>
</html>