<!-- test_php -->
<!DOCTYPE html">
<html>
	<head>
		<title>test_php/index.php</title>
		<style>
			font {
				opacity: 0;
			}
			.l {
				float: left;
			}
			.r {
				float: right;
			}
			form {
				position: relative;
				background: #fff;
				height: 200px;
				width: 300px;
				padding: 10px;
			}
			body {
				background: #ccc;
			}
			.ba, .bb {
				width: 100%;
				height: 42%;
			}
			.ba {
				border-bottom: 3px solid #000;
			}
			.bb {
				padding-top: 10px;
			}
			.func {
				display: none;
			}
		</style>
	</head>
	<body>
		<?php
			$b1a=$_POST['b1a'];//b1a       b2a
			$b2a=$_POST['b2a'];//b1b       b2b
			$b1b=$_POST['b1b'];
			$b2b=$_POST['b2b'];
			if(strlen($_POST['b1a'])<1 || $b1a=='x'){
				$x=($b1b*$b2a)/$b2b;
			}
			else if (strlen($b1b)<1 || $b1b=='x'){
				$x=($b1a*$b2b)/$b2a;
			}
			else if (strlen($b2a)<1 || $b2a=='x'){
				$x=($b1a*$b2b)/$b1b;
			}
			else if (strlen($b2b)<1 || $b2b=='x'){
				$x=($b1b*$b2a)/$b1a;
			}
			echo "x=$x";
		?>
		<form class="r" action="d3_12.php" id="form" method="post">
			<div class="ba">
			<input class="l" value="<?=$_POST['b1a']?>" tabindex="1" name="b1a" size="5" type="text">
			<input class="r" value="<?=$_POST['b2a']?>" tabindex="3" name="b2a" size="5" type="text">
			</div>
			<div class="bb">
			<input class="l" value="<?=$_POST['b1b']?>" tabindex="2" name="b1b" size="5" type="text">
			<input class="r" value="<?=$_POST['b2b']?>" tabindex="4" name="b2b" size="5" type="text">
			</div>
			<input type="submit">
		</form>
	</body>
</html>