<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once 'main.php';
			head();
		?>
	</head>
	<body>
		<?php top(0,1); ?>
		<div class="clearContainer1">
		<div class="container">
			<div class="row">
				<img class="col-xs-4" src="<?=LINK?>images/404.png" alt="404">
				<div class="col-xs-8">
					<h1>Сторінка не знайдена (404)</h1>
					<p>
						Нажаль, ми не змогли знайти дану сторінку.
						<br>
						Адміністратори вже повідомлені про проблему і виправлять її найблищим часом...
						<br>
						Дякуємо за те, що довіряєте нам і вибачаємося за незручності!
					</p>
					<a href="<?=LINK?>">На головну</a>
				</div>
			</div>
		</div>
	</body>
</html>