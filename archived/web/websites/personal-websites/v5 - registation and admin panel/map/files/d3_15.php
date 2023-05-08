<!DOCTYPE html>
<html>
	<head>
		<script src="jq321.js"></script>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<?php if($_POST['max']==NULL)
				$max=5;
			else $max=$_POST['max'];
			if($_POST['count']==NULL)
				$count=10;
			else $count=$_POST['count'];
			if($_POST['limit']==NULL)
				$limit=100;
			else $limit=$_POST['limit']; ?>
		<form method="post" action="d3_15.php">
			<input type="text" name="max" value="<?=$max?>" placeholder="5"> 
			<input type="text" name="count" value="<?=$count?>" placeholder="10"> 
			<input type="text" name="limit" value="<?=$limit?>" placeholder="100"> 
			<input type="submit" class="btn" value="Go"> 
			<a href="d3_15.php">Reload</a>
		</form>
		<table class="table  table-striped table-hover">
			<thead>
				<tr>
					<?php for($i=0;$i<$count;$i++)
					echo "<th>$i</th>";?>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=0;$i<$max;$i++){
						echo '<tr>';
						for($ii=$iii=0;$ii<$limit;$ii++)
							$a[$i][rand()%$count]++;
						for($ii=1;$ii<$count;$ii++){
							if($a[$i][$ii]>$a[$i][$iii])
								$iii=$ii;
							if($a[$i][$ii]<$a[$i][$iii])
								$buf=$ii;
						}
						for($ii=0;$ii<$count;$ii++){
							echo "<th";
							if($ii==$iii)
								echo ' class="success"';
							else if($a[$i][$ii]==0)
								echo ' class="error"';
							else if($ii==$buf)
								echo ' class="warning"';
							echo ">".$a[$i][$ii]."</th>";
						}
						echo '</tr>';
					}
					for($i=0;$i<$max;$i++){
						for($ii=0;$ii<$count;$ii++)
							$a[$max][$ii]+=$a[$i][$ii];
					}
					for($i=0,$buffer=1;$i<$count;$i++){
						if($a[$max][$i]>$a[$max][$buff])
							$buff=$i;
						if($a[$max][$i]<$a[$max][$buffer])
							$buffer=$i;
					}
					echo '<tr>';
					for($i=0;$i<$count;$i++){
							echo "<th";
							if($i==$buff)
								echo ' class="success"';
							else if($a[$max][$i]==0)
								echo ' class="error"';
							else if($i==$buffer)
								echo ' class="warning"';
							echo ">".$a[$max][$i]."</th>";
					}
					echo '</tr><tr>';
					for($i=0;$i<$count;$i++){
							echo "<th";
							if($i==$buff)
								echo ' class="success"';
							else if($a[$max][$i]==0)
								echo ' class="error"';
							else if($i==$buffer)
								echo ' class="warning"';
							echo ">".$a[$max][$i]/$max."</th>";
					}
				?>
			</tbody>
		</table>
	</body>
</html>