<!DOCTYPE html>
<html>
	<body>
		<?php
		if(isset($_POST['str']))
			$str=strtolower($_POST['str']);
		if(isset($_GET['str']))
			$str=strtolower(str_rot13($_GET['str']));
		if(isset($str)){
			for($i=0;$i<strlen($str);$i++){
				echo '<img style="float:left,width:100px;height:100px;" src="img/';
				if($str[$i]=='a') echo '1';
				else if($str[$i]=='b') echo '2';
				else if($str[$i]=='c') echo '3';
				else if($str[$i]=='d') echo '4';
				else if($str[$i]=='e') echo '5';
				else if($str[$i]=='f') echo '6';
				else if($str[$i]=='g') echo '7';
				else if($str[$i]=='h') echo '8';
				else if($str[$i]=='i') echo '9';
				else if($str[$i]=='j') echo '10';
				else if($str[$i]=='l') echo '12';
				else if($str[$i]=='k') echo '11';
				else if($str[$i]=='m') echo '13';
				else if($str[$i]=='n') echo '14';
				else if($str[$i]=='o') echo '15';
				else if($str[$i]=='p') echo '16';
				else if($str[$i]=='q') echo '17';
				else if($str[$i]=='r') echo '18';
				else if($str[$i]=='s') echo '19';
				else if($str[$i]=='t') echo '20';
				else if($str[$i]=='u') echo '21';
				else if($str[$i]=='v') echo '22';
				else if($str[$i]=='w') echo '23';
				else if($str[$i]=='x') echo '24';
				else if($str[$i]=='y') echo '25';
				else if($str[$i]=='z') echo '26';
				else echo '27';
				echo '.png">';
			}
			echo 'http://mambo.in.ua/map/shuft/index.php?str='.str_rot13($str);
			if(isset($_POST['i']) && $_POST['i']==2){
				echo $str;
			}
		}
		else {
			echo '<form method="post" action="index.php">
				<input type="text" name="str">
				<input type="submit">
			</form>';
		}
		?>
		<img src="sh.jpg" width="500px">
	</body>
</html>