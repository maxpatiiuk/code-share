<!-- ASCII Encode -->
<!DOCTYPE html">
<html>
	<head>
		<?php
		$lang = $_GET['lang'];
		include "../../data.php";
		if($lang=="ua"){
			include "../head_ua.php";
			top_ua(9);
			$l=0;
		}
		else {
			include "../head_en.php";
			top_en(9);
			$l=1;
		}
		head("../");
		include "script.php";
		?>
		
	</head>
	
	<body>
		<div class="content">
			<center>
			<form name="form1" method="post" action="script.php">
				<textarea name="textarea" cols="40" rows="10"></textarea>
				<input class="but" type="button" value="<?=$cont[7][$l]?>" /> 
				<input class="but" type="reset" value="<?=$cont[8][$l]?>" /> 
			</form>
			<?php
			/*
			<form name="formCyrToLat"> 
				<textarea name="txtBoxCyr" rows="16" cols="64"></textarea> 
				<input class="button default" type="button" name="RusLat" value="<?=$cont[7][$l]?>" onclick="RusLatTranliter();" /> 
				<input class="button default" type="reset" name="Reset" value="<?=$cont[8][$l]?>" /> 
				<b><?=$cont[9][$l]?></b>
				<textarea name="txtBoxLat" rows="16" cols="64" id="Textarea1"></textarea>
			</form>


			<form method="post" action="script.php">
				<h1><?=$cont[6][$l]?></h1>
				<textarea class="content" name="transfer"></textarea>
				<input class="button default" type="button" onclick="save();" name="RusLat" value="<?=$cont[7][$l]?>" /> 
				<input class="button default" type="reset" name="Reset" value="<?=$cont[8][$l]?>" /> 
			</form>
			*/
			?>
			</center>
		</div>
	</body>
</html>