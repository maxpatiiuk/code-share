<!-- index.php -->
<!DOCTYPE html">
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://mambo.in.ua/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<style>
			body {
				margin: 15px;
				background-color: #ccc;
				font-family: monospace;
			}
			td {
				width: 4vw;
				height: 4vw;
				text-align: center;
			}
			.cg {
				background: #3c1;
			}
			.cr {
				background: #c13;
			}
			.cy {
				background: #ee1;
			}
			.cw {
				background: #fff;
			}
			.cb {
				background: #13d;
			}
			.cp {
				background: #d1b;
			}
			.cl {
				background: #000;
			}
			.co {
				background: #d81;
			}
		</style>
	</head>
	<body>
		<?php
		if(isset($_POST['subBut']) && $_FILES["file"]["size"]>0){
			if($_FILES["file"]["size"]>1024*1024*10)
				echo '<div class="alert alert-danger">File should be smaller that 10 mb. Upload another file</div><br>';
			else if(pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION)!=='txt')
				echo '<div class="alert alert-danger">Uploaded file should be txt file</div><br>';
			else {
				move_uploaded_file($_FILES["file"]["tmp_name"],'tmpFile.txt');
				$file=fopen('tmpFile.txt','r');
				echo '<table>
					<tbody>';
				while(!feof($file)){
					$line=fgets($file);
					echo '<tr>';
					for($i=0;$i<strlen($line);$i++){
						echo '<td';
						if(strpos('grywbplot',$line[$i])===false)
							echo '>'.$line[$i];
						else
							echo ' class="c'.$line[$i].'">';
						echo '</td>';
					}
					echo '</tr>';
				}
				echo '</tbody>
				</table><br><br><br>';
				unlink('tmpFile.txt');
			}
		}
		if(isset($_POST['subBut']) && strlen($_POST["text"])>0){
			echo '<table>
				<tbody>';
				$line=preg_replace('/$\R?^/m','',preg_split('/$\R?^/m',$_POST["text"].substr($_POST["text"],-1)));
				for($ii=0;isset($line[$ii]);$ii++){
					echo '<tr>';
					if(isset($line[$ii+1]))
						$line[$ii+1]=substr($line[$ii+1],0,-1);
					for($i=0;$i<strlen($line[$ii]);$i++){
						echo '<td';
						if(strpos('grywbplot',$line[$ii][$i])===false)
							echo '>'.$line[$ii][$i];
						else
							echo ' class="c'.$line[$ii][$i].'">';
						echo '</td>';
					}
					echo '</tr>';
				}
			echo '</tbody>
			</table><br><br><br>';
		} ?>
		<form class="form-horizontal" enctype="multipart/form-data" method="post">
			<input type="file" name="file" accept=".txt"><br>
			<textarea style="height: 500px;" class="form-control" name="text"><?=$_POST['text']?></textarea><br>
			<input type="submit" name="subBut" class="btn btn-success">
		</form>
		<script>
			for(i=0;i<$('.ct').length;i++)
				$('.ct').eq(i).css('background','#'+Math.floor(Math.random()*16777215).toString(16));
		</script>
		<pre>g	green
r	red
y	yellow
w	white
b	blue
p	pink
l	black
o	orange
t	random</pre>
	</body>
</html>