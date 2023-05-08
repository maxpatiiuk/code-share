<!DOCTYPE html>
<html>
	<head>
		<title>(0DE</title>
		<style>
		* {
			padding: 0;
			margin: 0;
			text-decoration: none;
			border: none;
			outline: none;
		}
		body {
			background: #ccc;
			color: #444;
			overflow: hidden;
			height: 100vh;
			width: 100vw;
		}
		input[type="text"] {
			width: 98vw;
		}
		h1 {
			height: 3vh;
			padding-left: 0.1vw;
			font-family: monospace;
		}
		h1:hover {
			-webkit-animation: rainbow 5s 999999999 linear;
		}
		@-webkit-keyframes rainbow {
			25% {
				color: #f00;
			}
			50% {
				color: #ff0;
			}
			75% {
				color: #0f0;
			}
			100% {
				color: #00f;
			}
		}
		textarea {
			width: 100vw;
			height: 50vh;
		}
		#program {
			width: 100vw;
			height: 47vh;
			background: #fff;
			overflow: auto;
		}
		[type="submit"] {
			padding: 10px;
			height: 3vh;
			line-height: 1.5vh;
			position: absolute;
			right: 0;
			top: 0;
		}
		[type="submit"]:hover {
			background: #4363ff;
			color: #fff;
		}
		</style>
	</head>
	<body>
		<h1>(0DE</h1>
		<?php 
		if(isset($_POST['code'])){
			$code=explode('\n',$_POST['code']);
			/*$result.=*/
			for($i=0;$code[$i]!=NULL;$i++){
				$c=$code[$i];
				if($c[0]=='w' && $c[1]=='('){
					if($c[strlen($c)]==')')
						$result.=substr($c,2,strlen($c)-4);
					else echo 'WARNING : '.$i.' : '.strlen($c).' : Expected ")" instead of "'.$c[strlen($c)].'"';
				}
				$result.='<br>';
			}
		}
		?>
		<form id="code" method="post" action="d3_11.php">
			<textarea name="code" rows="10" cols="50"><?=$_POST['code']?></textarea>
			<input type="submit" value="COMPILE">
		</form>
		<pre id="program" readonly><?=$result?></pre>
	</body>
</html>