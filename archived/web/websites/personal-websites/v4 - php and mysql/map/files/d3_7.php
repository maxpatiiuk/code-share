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
			$b1a=$_POST['b1a'];
			$b1b=$_POST['b1b'];
			$b2a=$_POST['b2a'];
			$b2b=$_POST['b2b'];
			$b1al=$b1a.'/'.$b1b;
			$b2al=$b2a.'/'.$b2b;
			if($b1a == NULL or $b2a == NULL)
				echo '<div class="func">';
			else
				echo '<div>';
			if($b1b == NULL){
				$b1b=1;
				$b1al=$b1a;
			}
			if($b2b == NULL){
				$b2b=1;
				$b2al=$b2a;
			}
			$b1=$b1a/$b1b;
			$b2=$b2a/$b2b;
			if($b1a==$b1b)
				$b1=$b1al=$b1a;
			if($b2a==$b2b)
				$b2=$b2al=$b2a;
			$q=$b2/$b1;
			$s=($b1)/(1-$q);
			echo $b1al.' , '.$b2al.'...<br>
				q='.$b2al.' / '.$b1al.' = '.$q.'<br>
				<font>888888</font>'.$b1al.'<br>
				S=___________________ = '.$s.'<br>
				<font>888888</font>1';
			if ($q<0)
				echo '+'.ABS($q);
			else
				echo '-'.$q;
			echo '</div>';
		?>
		<form class="r" action="d3_7.php" id="form" method="post">
			<div class="ba">
			<input class="l" tabindex="1" maxlength="5" name="b1a" size="5" type="text">
			<input class="r" tabindex="3" maxlength="5" name="b2a" size="5" type="text">
			</div>
			<div class="bb">
			<input class="l" tabindex="2" maxlength="5" name="b1b" size="5" type="text">
			<input class="r" tabindex="4" maxlength="5" name="b2b" size="5" type="text">
			</div>
			<input type="submit">
		</form>
	</body>
</html>