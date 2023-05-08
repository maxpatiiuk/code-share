<!DOCTYPE html>
<html>
	<head>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<?php
		$name=$_POST['name'];
		$fir=$_POST['fir'];
		$sec=$_POST['sec'];
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
	</head>
	
	<body>
		<?php
		class Field_calculate { const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/'; const PARENTHESIS_DEPTH = 10; public function calculate($input){ if(strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null){ $input = str_replace(',', '.', $input); $input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input); $i = 0; while(strpos($input, '(') || strpos($input, ')')){ $input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input); $i++; if($i > self::PARENTHESIS_DEPTH){ break; } } if(preg_match(self::PATTERN, $input, $match)){ return $this->compute($match[0]); } return 0; } return $input; } private function compute($input){ $compute = create_function('', 'return '.$input.';'); return 0 + $compute(); } private function callback($input){ if(is_numeric($input[1])){ return $input[1]; } elseif(preg_match(self::PATTERN, $input[1], $match)){ return $this->compute($match[0]); } return 0; } }
			if(isset($_POST['name'][0])){
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 table-responsive">
					<table class="table table-striped table-hover table-condensed main">
						<thead>
							<tr>
								<th>x</th>
								<?php for($i=0;isset($name[$i]);$i++)
									echo '<th>'.$name[$i].'</th>'; ?>
							</tr>
						</thead>
						<tbody>
							<?php $calc = new Field_calculate();
							for ($i=$fir;$i<=$sec;$i++){
								echo '<tr><th>'.$i.'</th>';
								for($ii=0;isset($name[$ii]);$ii++){
									$res[$ii][$i]=$calc->calculate(preg_replace("/x/", "$i",$name[$ii]));
									echo '<td>'.$res[$ii][$i].'</td>';
								}
								echo '</tr>';
							} ?>
						</tbody>
					</table>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
					<div class="row">
						<?php for($i=0;isset($name[$i]);$i++)
							diagram($res[$i],400,500);
						} ?>
					</div>
					<div class="row">
						<form id="form" method="post" accept="d3_14.php">
							First:<input type="text" name="fir" value="<?=$_POST['fir']?>"><br>
							Last:<input type="text" name="sec" value="<?=$_POST['sec']?>"><br>
							<button type="button" class="btn" onclick="gen()">One more function</button><br>
							<br>0. <input type="text" name="name[]" value="<?=$_POST['name'][0]?>">
							<div id="add"></div>
							<br><input type="submit" class="btn btn-primary" value="Generate">
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			i=1;
			function gen(){
				$('#add').append('<br>'+i+'. <input type="text" name="name[]">');
				i++;
			}
		</script>
	</body>
</html>