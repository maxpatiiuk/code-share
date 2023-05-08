<!DOCTYPE html>
<html>
	<head>
		<title>D3_6</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
			for($i=0;$i<=20;$i++){
				if($_POST['p'.$i])
					$a[$i]=$_POST['p'.$i];
			}
			function diagram($var, $width, $height){
				$el=count($var)-1;
				static $id;
				$id++;
				$w=$width*0.95;
				$h=$height*0.92;
				$d=$h/(max($var)+0.003*$h);
				echo $d;
				echo '
					<style>
						.diagram'.$id.' {
							width: '.$width.'px;
							height: '.$height.'px;
							background: #ccc;
						}
						.cont'.$id.' {
							width: '.$w.'px;
							height: '.$h.'px;
						}
						.cont'.$id.', .num'.$id.' {
							float:right;
						}
						.cont'.$id.' div {
							background: #0a0;
							display: inline-block;
							border-left: 5px solid #ccc;
							box-sizing: border-box;
						}
						.num'.$id.' div {
							display: inline-block;
							text-align:center;
							border-left: 5px solid #ccc;
							box-sizing: border-box;
							height:16px;
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
							for($i=0;$i<=$el;$i++){
								echo '<div style="width:'.($w/($el+1)).'px">'.$i.'</div>';
							}
					echo '</div>
					</div>
				';
			}
			diagram($a,500,200);
		?>
		<form style="float:right;" action="d3_6.php" method="post">
			<?php for($i=0;$i<=20;$i++) echo '<input type="text" value="'.$_POST['p'.$i].'" name="p'.$i.'" size="5" maxlenght="5"><br>';?>
			<input type="submit" value="Send">
		</form>
	</body>
</html>