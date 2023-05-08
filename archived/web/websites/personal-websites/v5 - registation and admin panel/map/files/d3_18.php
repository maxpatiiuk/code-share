<!DOCTYPE html>
<html>
	<head>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>
	<body>
		<table class="table table-condensed">
			<thead>
				<tr>
					<?php echo '<th>#</th>'; 
					if($_POST['rows']>0)
						$rows=$_POST['rows'];
					else
						$rows=20;
					if($_POST['cols']>0)
						$cols=$_POST['cols'];
					else
						$cols=1001;
					if($_POST['value']>0)
						$value=$_POST['value'];
					else
						$value=2;
					for($i=0;$i<$cols;$i++)
						echo '<th>'.$i.'</th>'; ?>
				</tr>
			</thead>
			<tbody>
				<?php for($i=0;$i<$cols;$i++)
				$a[$i]=pow($value,$i);
				for($ii=0;$ii<$rows;$ii++){
					echo '<tr><th>'.($ii+1).'</th>';
					for($i=0;$i<$cols;$i++){
						$n=substr(number_format($a[$i],0,'',''),$ii,1);
						if($n==0)
							echo '<th style="color: #F00;">';
						else if($n==1)
							echo '<th style="color: #F90;">';
						else if($n==2)
							echo '<th style="color: #FE0;">';
						else if($n==3)
							echo '<th style="color: #8F0;">';
						else if($n==4)
							echo '<th style="color: #0CF;">';
						else if($n==5)
							echo '<th style="color: #01F;">';
						else if($n==6)
							echo '<th style="color: #F0F;">';
						else if($n==7)
							echo '<th style="color: #90F;">';
						else if($n==8)
							echo '<th style="color6: #000;">';
						else if($n==9)
							echo '<th style="color: #0A5;">';
						echo $n.'</th>';
					}
					echo '</tr>';
				} ?>
			</tbody>
		</table><br>
		<form method="post" action="d3_18.php">
			<input name="rows" placeholder="20" value="<?=$_POST['rows']?>">
			<span class="help-inline">rows</span>
			<input name="cols" placeholder="1001" value="<?=$_POST['cols']?>">
			<span class="help-inline">cols</span>
			<input name="value" placeholder="2" value="<?=$_POST['value']?>">
			<span class="help-inline">value</span>
			<input type="submit" class="btn btn-primary btn-large"  value="GO">
		</form><br>
		<input id="calcul" type="text" placeholder="10">
		<button id="calculat" class="btn btn-info btn-sm">Calculate</button>
		<span id="result" class="inline"></span>
		<script>
			$('#calculat').click( function(){
				$('#result').html(Math.trunc($('#calcul').val()/10*3+1));
			});
		</script>
	</body>
</html>