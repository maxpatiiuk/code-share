<!-- index.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<style>
			body {
				margin: 15px;
				background-color: #ccc;
				font-family: monospace;
			}
		</style>
	</head>
	<body>
		<?php
		echo '<pre>';
		if(isset($_POST['subBut']) && strlen($_POST["text"])>0){
			$text=preg_replace('/[^A-Z!0-9\r\n ]/','',strtoupper($_POST["text"]));
			for($ii=0;isset($text[$ii]);$ii++){
				if(preg_match('/[\r\n]/',$text[$ii])){
					echo $l1.'<br>'.$l2.'<br>'.$l3.'<br>'.$l4.'<br>'.$l5;
					$l1=$l2=$l3=$l4=$l5=NULL;
				}
				else if($text[$ii]==' '){
					$l1.='     ';
					$l2.='     ';
					$l3.='     ';
					$l4.='     ';
					$l5.='     ';
				}
				else {
					switch($text[$ii]){
						case 'A':
							$l1.=' AAA ';
							$l2.='A   A';
							$l3.='AAAAA';
							$l4.='A   A';
							$l5.='A   A';
							break;
						case 'B':
							$l1.='BBBB ';
							$l2.='B   B';
							$l3.='BBBB ';
							$l4.='B   B';
							$l5.='BBBB ';
							break;
						case 'C':
							$l1.=' CCCC';
							$l2.='C    ';
							$l3.='C    ';
							$l4.='C    ';
							$l5.=' CCCC';
							break;
						case 'D':
							$l1.='DDDD ';
							$l2.='D   D';
							$l3.='D   D';
							$l4.='D   D';
							$l5.='DDDD ';
							break;
						case 'E':
							$l1.='EEEEE';
							$l2.='E    ';
							$l3.='EEEEE';
							$l4.='E    ';
							$l5.='EEEEE';
							break;
						case 'F':
							$l1.='FFFFF';
							$l2.='F    ';
							$l3.='FFFFF';
							$l4.='F    ';
							$l5.='F    ';
							break;
						case 'G':
							$l1.=' GGGG';
							$l2.='G    ';
							$l3.='G  GG';
							$l4.='G   G';
							$l5.=' GGG ';
							break;
						case 'H':
							$l1.='H   H';
							$l2.='H   H';
							$l3.='HHHHH';
							$l4.='H   H';
							$l5.='H   H';
							break;
						case 'I':
							$l1.='I';
							$l2.='I';
							$l3.='I';
							$l4.='I';
							$l5.='I';
							break;
						case 'J':
							$l1.='JJJJJ';
							$l2.='    J';
							$l3.='    J';
							$l4.=' J  J';
							$l5.='  JJ ';
							break;
						case 'K':
							$l1.='K   K';
							$l2.='K  K ';
							$l3.='KKK  ';
							$l4.='K  K ';
							$l5.='K   K';
							break;
						case 'L':
							$l1.='L    ';
							$l2.='L    ';
							$l3.='L    ';
							$l4.='L    ';
							$l5.='LLLLL';
							break;
						case 'M':
							$l1.='M   M';
							$l2.='MM MM';
							$l3.='M M M';
							$l4.='M   M';
							$l5.='M   M';
							break;
						case 'N':
							$l1.='N   N';
							$l2.='NN  N';
							$l3.='N N N';
							$l4.='N  NN';
							$l5.='N   N';
							break;
						case 'O':
							$l1.=' OOO ';
							$l2.='O   O';
							$l3.='O   O';
							$l4.='O   O';
							$l5.=' OOO ';
							break;
						case 'P':
							$l1.='PPPP ';
							$l2.='P   P';
							$l3.='PPPP ';
							$l4.='P    ';
							$l5.='P    ';
							break;
						case 'Q':
							$l1.=' QQQ ';
							$l2.='Q   Q';
							$l3.='Q   Q';
							$l4.='Q QQ ';
							$l5.='QQQ Q';
							break;
						case 'R':
							$l1.='RRRR ';
							$l2.='R   R';
							$l3.='RRRR ';
							$l4.='R  R ';
							$l5.='R   R';
							break;
						case 'S':
							$l1.='SSSSS';
							$l2.='S    ';
							$l3.='SSSSS';
							$l4.='    S';
							$l5.='SSSSS';
							break;
						case 'T':
							$l1.='TTTTT';
							$l2.='  T  ';
							$l3.='  T  ';
							$l4.='  T  ';
							$l5.='  T  ';
							break;
						case 'U':
							$l1.='U   U';
							$l2.='U   U';
							$l3.='U   U';
							$l4.='U   U';
							$l5.='UUUUU';
							break;
						case 'V':
							$l1.='V   V';
							$l2.='V   V';
							$l3.=' V V ';
							$l4.=' V V ';
							$l5.='  V  ';
							break;
						case 'W':
							$l1.='W   W';
							$l2.='W   W';
							$l3.='W W W';
							$l4.='W W W';
							$l5.='WW WW';
							break;
						case 'X':
							$l1.='X   X';
							$l2.=' X X ';
							$l3.='  X  ';
							$l4.=' X X ';
							$l5.='X   X';
							break;
						case 'Y':
							$l1.='Y   Y';
							$l2.=' Y Y ';
							$l3.='  Y  ';
							$l4.='  Y  ';
							$l5.='  Y  ';
							break;
						case 'Z':
							$l1.='ZZZZZ';
							$l2.='   Z ';
							$l3.='  Z  ';
							$l4.=' Z   ';
							$l5.='ZZZZZ';
							break;
						case '1':
							$l1.='1';
							$l2.='1';
							$l3.='1';
							$l4.='1';
							$l5.='1';
							break;
						case '2':
							$l1.=' 222 ';
							$l2.='2   2';
							$l3.='   2 ';
							$l4.='  2  ';
							$l5.='22222';
							break;
						case '3':
							$l1.='3333 ';
							$l2.='    3';
							$l3.='3333 ';
							$l4.='    3';
							$l5.='3333 ';
							break;
						case '4':
							$l1.='4   4';
							$l2.='4   4';
							$l3.='44444';
							$l4.='    4';
							$l5.='    4';
							break;
						case '5':
							$l1.='55555';
							$l2.='5    ';
							$l3.='55555';
							$l4.='    5';
							$l5.='55555';
							break;
						case '6':
							$l1.='66666';
							$l2.='6    ';
							$l3.='66666';
							$l4.='6   6';
							$l5.='66666';
							break;
						case '7':
							$l1.='77777';
							$l2.='    7';
							$l3.='   7 ';
							$l4.=' 7   ';
							$l5.='7    ';
							break;
						case '8':
							$l1.='88888';
							$l2.='8   8';
							$l3.='88888';
							$l4.='8   8';
							$l5.='88888';
							break;
						case '9':
							$l1.='99999';
							$l2.='9   9';
							$l3.='99999';
							$l4.='    9';
							$l5.='99999';
							break;
						case '0':
							$l1.='00000';
							$l2.='0   0';
							$l3.='0   0';
							$l4.='0   0';
							$l5.='00000';
							break;
					}
				$l1.='     ';
				$l2.='     ';
				$l3.='     ';
				$l4.='     ';
				$l5.='     ';
				}
			}
			echo $l1.'<br>'.$l2.'<br>'.$l3.'<br>'.$l4.'<br>'.$l5.'</pre><br><br><br>';
		} ?>
		<form class="form-horizontal" method="post">
			<textarea style="height: 500px;" class="form-control" name="text"><?=$_POST['text']?></textarea><br>
			<input type="submit" name="subBut" class="btn btn-success">
		</form>
	</body>
</html>