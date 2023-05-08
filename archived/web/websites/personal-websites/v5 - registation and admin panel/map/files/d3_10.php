<!DOCTYPE html>
<html>
	<head>
		<style>
			.text, .atr {
				width: 45vw;
			}
			.tabs, .bold {
				width: 5vw;
			}
		</style>
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>
	<body>
		<?php if(isset($_POST['line'])){
			$code=NULL;
			for($i=0;$i<300;$i++){
				if($_POST['line'][$i][0]==NULL && $_POST['line'][$i][1]==NULL && $_POST['line'][$i][2]==NULL && $_POST['line'][$i][3]==NULL)
					continue;
				else if(preg_match('/^[0-9]$/',$_POST['line'][$i][2]) || $_POST['line'][$i][2]==NULL)
					$code.="\t\t\ta('".$_POST['line'][$i][0]."','".$_POST['line'][$i][1]."','".$_POST['line'][$i][2]."','".$_POST['line'][$i][3]."');\n";
				else {
					if($i!=0)
						$code.="\t\techo \"</div>\";\n";
					$code.="\t\techo '<div class=\"".$_POST['line'][$i][2]."\">';\n";
					$divs=1;
				}
			}
			if($divs)
				$code.=" echo '\t\t</div>\n';";
			setcookie('code', $code, time()+60*60*24*4, "/");
		}
		?>
		<div id="res"><button class="cbtn btn">Copy</button>
		<textarea class="ctextarea" style="width: 90vw;height:auto"><?=htmlentities($code)?></textarea>
		<br><br><?=htmlentities($_COOKIE['code'])?><br><br>
		</div>
		<form action="d3_10.php" method="post">
			<input type="text" name="line[0][0]" class="text"><input type="text" name="line[0][1]" class="atr"><input type="text" name="line[0][2]" class="tabs"><input type="text" name="line[0][3]" class="bold"><br>
			<div id="lines"></div>
			<button type="button" class="btn" onclick="$('#res').toggle()">Hide output</button>
			<button type="button" onclick="gen()" class="btn">New line</button>
			<input type="submit" value="Generate" class="btn btn-primary">
		</form>
		<script>
		i=1;
		function gen(){
			$('#lines').append('<input type="text" name="line['+i+'][0]" class="text"><input type="text" name="line['+i+'][1]" class="atr"><input type="text" name="line['+i+'][2]" class="tabs"><input type="text" name="line['+i+'][3]" class="bold"><br>');
			i=i+1;
		}
		document.querySelector('.cbtn').addEventListener('click', function(event) {
			var copyTextarea = document.querySelector('.ctextarea');
			copyTextarea.select();
			var successful = document.execCommand('copy');
		});
		</script>
	</body>
</html>