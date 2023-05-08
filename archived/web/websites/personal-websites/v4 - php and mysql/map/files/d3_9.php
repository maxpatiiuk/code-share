<!-- test -> index.php2 -->
<!DOCTYPE html">
<html>
	<head>
		<title>Just site</title>
		<?php
		$fir=preg_replace("/[^0-9]/", '', $_GET['f']);
		$sec=preg_replace("/[^0-9]/", '', $_GET['s']);
		if ($fir==NULL)
			$fir=0;
		if ($sec==NULL)
			$sec=100;
		if ($fir>$sec){
			$buf=$fir;
			$fir=$sec;
			$sec=$fir;
		}
		if ($fir==$sec)
			$sec++;
		$count=$sec-$fir;
		for ($i=$fir;$i<=$sec;$i++){
			$qw3=pow(($i+1),3)-pow($i,3);
			$qw2=pow(($i+1),2)-pow($i,2);
			$qw22=pow((pow(($i+1),2)-pow($i,2)),2);
			global $a;
			$a[$i]=$qw22-$qw3;
		}
		
		
		function diagram($var, $width, $height){
		$el=count($var)-1;
		static $id;
		$id++;
		$w=$width*0.95;
		$h=$height*0.92;
		$d=$h/(max($var)+0.003*$h);
		echo '
			<style>
				.diagram'.$id.' {
					width: '.$width.'px;
					height: '.$height.'px;
					float: left;
					background: #ccc;
				}
				.cont'.$id.' {
					width: '.$w.'px;
					height: '.$h.'px;
				}
				.cont'.$id.', .num'.$id.' {
					float:right;
					background: #ccc;
				}
				.cont'.$id.' div {
					background: #0a0;
					display: inline-block;
					background: #0f0;
				}
				.num'.$id.' div {
					display: inline-block;
					text-align:center;
					border-left: 5px solid #ccc;
					box-sizing: border-box;
					height: 16px;
					width: 40px;
				}
			</style>
			<div class="diagram'.$id.'">
				<div class="text'.$id.'">
				</div>
				<div class="cont'.$id.'">';
					for($i=0;$i<=$el;$i++){
						echo '<div style="height:'.($d*$var[$i]).'px;width:'.($w/($el+1)).'px"></div>';
					}
			echo '</div>
				<div class="num'.$id.'">';
					for($i=0, $ii=0;$i<=$el;$i++){//   40/$w/$el
						$ii=$ii+($w/$el);
						if($w/$el<40 && $ii>40){
							echo '<div>'.$i.'</div>';
							$ii=0;
						}
					}
			echo '</div>
			</div>
			';
		}
		?>
		<style type="text/css">
			.column { height:400px; width:18px; }
			.column div { border:1px solid black; background:#090; width:16px; margin:-1px 0; }
			.chart { background:url(image/chart.png) no-repeat; padding:4px; }
			.height40 { height:40px; }	
			table.main th, table.main td {
				padding: 0 20px;
			}
			table.main tr:hover {
				background: #ccc;
			}
			table.main {
				width: 57.23%;
			}
			table {
				border: 1px solid #000;
			}
			.l {
				float: left;
			}
			.r {
				float: right;
			}
		</style>
	</head>
	
	<body>
		<table class="main l">
		https://drive.google.com/drive/folders/0B68msIcB_OG5LWk0ZjktMXhVbWc?usp=sharing
			<tr>
				<th>$i</th>
				<th>$i<sup>2</sup></th>
				<th>$i<sup>3</sup></th>
				<th>$i+1</th>
				<th>($i+1)<sup>2</sup></th>
				<th>($i+1)<sup>3</sup></th>
				<th>($i+1)<sup>2</sup>-$i<sup>2</sup></th>
				<th>($i+1)<sup>3</sup>-$i<sup>3</sup></th>
				<th>(($i+1)<sup>2</sup>-$i<sup>2</sup>)<sup>2</sup></th>
				<th>(($i+1)<sup>2</sup>-$i<sup>2</sup>)<sup>2</sup>-($i+1)<sup>3</sup>-$i<sup>3</sup></th>
			</tr>
			<?php
				for ($i=$fir;$i<=$sec;$i++){
					echo '<tr><td>';
					echo $i;//1
					echo '</td><td>';
					echo pow($i,2);//2
					echo '</td><td>';
					echo pow($i,3);//3
					echo '</td><td>';
					echo $i+1;//4
					echo '</td><td>';
					echo pow(($i+1),2);//5
					echo '</td><td>';
					echo pow(($i+1),3);//6
					echo '</td><td>';
					echo $qw2;//7
					echo '</td><td>';
					echo $qw3;//8
					echo '</td><td>';
					echo $qw22;//9
					echo '</td><td>';
					echo $a[$i];//10
					echo '</td></tr>';
				}
				
			?>
		</table>
		<?php diagram($a,400,500); ?>
	</body>
</html>