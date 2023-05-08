<!DOCTYPE html>
<html>
	<head>
		<style>
			th {
				text-align: center;
			}
		</style>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>
	<body>
		<table class="table table-striped table-hover">
		<?php
			for($i=0;$i<14;$i++){
				for($iii=0;$iii<20;$iii++){
					$a[$i][$iii]=gen().gen();
				}
			}
			function gen(){
				$ii=rand()%16;
				if($ii==10) $ii=A;
				if($ii==11) $ii=B;
				if($ii==12) $ii=C;
				if($ii==13) $ii=D;
				if($ii==14) $ii=E;
				if($ii==15) $ii=F;
				return $ii;
			}
			for($i=0;$i<14;$i++){
				echo '<tr>';
				for($iii=0;$iii<20;$iii++){
					echo '<th';
					if($a[$i][$iii][0]==$a[$i][$iii][1] || $a[$i][($iii-1)][1]==$a[$i][$iii][0] || $a[$i][$iii][1]==$a[$i][($iii+1)][0] || $a[$i-1][$iii][1]==$a[$i][$iii][1] || $a[$i][$iii][1]==$a[$i+1][$iii][1] || $a[$i-1][$iii][0]==$a[$i][$iii][0] || $a[$i][$iii][0]==$a[$i+1][$iii][0])
						echo ' class="success"';
					echo '>'.$a[$i][$iii][0].$a[$i][$iii][1].'</th>';
				}
				echo '</tr>';
			}
		?>
		</table>
		<div></div>
		<script>
			$('div').html($('.success').length);
		</script>
	</body>
</html>