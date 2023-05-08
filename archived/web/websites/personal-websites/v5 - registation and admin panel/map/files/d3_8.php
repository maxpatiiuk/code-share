<!-- test -> index.php -->
<!DOCTYPE html">
<html>
	<head>
		<title>Just site</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<meta charset="utf_8" />
		<?php
		$transition = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['transition']);
		$width = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['width']);
		$height = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['height']);
		$radius = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['radius']);
		$border_px = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['border_px']);
		$border_col = $vall[] = preg_replace("/[^.A-Fa-f0-9]/", '', $_POST['border_col']);
		$backg = $vall[] = preg_replace("/[^.A-Fa-f0-9]/", '', $_POST['backg']);
		$width_hov = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['width_hov']);
		$height_hov = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['height_hov']);
		$radius_hov = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['radius_hov']);
		$border_px_hov = $vall[] = preg_replace("/[^.0-9]/", '', $_POST['border_px_hov']);
		$border_col_hov = $vall[] = preg_replace("/[^.A-Fa-f0-9]/", '', $_POST['border_col_hov']);
		$backg_hov = $vall[] = preg_replace("/[^.A-Fa-f0-9]/", '', $_POST['backg_hov']);

		$width=$width.$_POST['width_sel'];
		$height=$height.$_POST['height_sel'];
		$radius=$radius.$_POST['radius_sel'];
		$border_px=$border_px.$_POST['border_px_sel'];
		$width_hov=$width_hov.$_POST['width_hov_sel'];
		$height_hov=$height_hov.$_POST['height_hov_sel'];
		$radius_hov=$radius_hov.$_POST['radius_hov_sel'];
		$border_px_hov=$border_px_hov.$_POST['border_px_hov_sel'];
		?>
		<style>
			* {
				transition: <?=$transition?>s;
				margin: 0;
				padding: 0;
			}
			.body {
				padding: 300px;
			}
			.element {
				width: <?=$width?>;
				height: <?=$height?>;
				border-radius: <?=$radius?>;
				box-sizing: border-box;
				border: <?=$border_px?> solid #<?=$border_col?>;
				background: #<?=$backg?>;
			}
			.element:hover {
				width: <?=$width_hov?>;
				height: <?=$height_hov?>;
				border-radius: <?=$radius_hov?>;
				box-sizing: border-box;
				border: <?=$border_px_hov?> solid #<?=$border_col_hov?>;
				background: #<?=$backg_hov?>;
			}
			.bl {
				width: 50%;
				height: 100%;
				background: #ccc;
			}
			.left {
				float: left;
			}
			.right {
				float: right;
			}
			input[type="submit"] {
				background: #fff;
				text-decoration: none;
				border: 0;
				padding: 15px 20px;
				margin-top: 20px;
			}
		</style>
	</head>
	
	<body>
		<?php
			function forma($text, $type=0){
				static $i=0;
				echo $_POST[$text.'_sel'];
				global $vall;
				if($vall[$i]==NULL){
					if($type==0)
						$vall[$i]='400';
					if($type==1)
						$vall[$i]='333';
					if($type==2)
						$vall[$i]='1';
				}
				if($type==1)
					$val="#".$val;
				if($type==2)
					$val.='s';
				echo '<br><p>'.ucfirst($text).' : <input maxlength="20" name="'.strtolower($text).'" size="50" type="text" value="'.$vall[$i].'">';
				if($type==0) {
					echo '<select form="form" name="'.strtolower($text).'_sel" size="1"><option value="px" ';
					if($_POST[$text.'_sel']=='px' || ($_POST[$text.'_sel']!='%' && $_POST[$text.'_sel']!='em'))
						echo "selected";
					echo '>px</option><option value="%" ';
					if($_POST[$text.'_sel']=='%')
						echo "selected";
					echo '>%</option><option value="em" ';
					if($_POST[$text.'_sel']=='em')
						echo "selected";
					echo '>em</option></select>';
				}
				echo '</p>';
				$i++;
			}
		?>
		<div class="left bl">
			<div class="element"></div>
		</div>
		<div class="right bl">
			<form action="d3_8.php" id="form" method="post">
				<?php
					forma("transition","2");//_sel
					forma("width","0");
					forma("height","0");
					forma("radius","0");
					forma("border_px","0");
					forma("border_col","1");
					forma("backg","1");
					forma("width_hov","0");
					forma("height_hov","0");
					forma("radius_hov","0");
					forma("border_px_hov","0");
					forma("border_col_hov","1");
					forma("backg_hov","1");
				?>
				<input type="submit">
			</form>
		</div>
	</body>
</html>