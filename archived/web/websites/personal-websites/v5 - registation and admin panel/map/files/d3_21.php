<!-- index.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://mambo.in.ua/bootstrap/js/bootstrap.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>
	<body>
		<?php
			if(isset($_POST['inp'])){
				$inp=strrev($_POST['inp']);
				if(strlen($inp)%2){
					$np=1;
					$inp.='0';
				}
				for(;$i<strlen($inp)/2;$i+=2){
					$buf=$inp[$i]+$inp[$i+1];
					$sec=$inp[$i+1];
					if($inp[$i]+$inp[$i+1]>10){
						$buf/=10;
						$sec/=10;
					}
					$r.=$buf.'+'.$sec+$buf;
					if($i+2<strlen($inp)/2)
						$r.='-';
				}
				if($np==1)
					$r.='-';
			}
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<form action="d3_21.php" method="post">
						<input type="input" name="inp">
						<button class="btn btn-primary">Go</button>
					</form>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<textarea><?=$r?></textarea>
				</div>
			</div>
		</div>
	</body>
</html>