<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head(la('help'),la('help'));
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1)?>
		<div class="clearContainer1">
			<div class="container">
				<div class="panel-group" id="accordion"> <?php
					if(_TYPE_==2)
						echo '<a class="btn btn-goldi" href="'.LINK.'adm/faq.php">Редагувати</a>';
					function accordion($head,$body,$mark=NULL){
						static $i=1;
						echo '<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a ';
										if(isset($mark))
											echo 'id="'.$mark.'" ';
									echo 'data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" aria-expanded="false" class="collapsed">'.$head.'</a>
								</h4>
							</div>
							<div id="collapse'.$i.'" class="panel-collapse collapse" aria-expanded="true">
								<div class="panel-body">'.$body.'</div>
							</div>
						</div>';
						$i++;
					}
					que('SELECT o0'._LANGUAGE_.' FROM '._PRODUCTS_.' WHERE id="0"');
					$row=mysql_fetch_array($res);
					$buf=explode('<^',$row['o0'._LANGUAGE_]);
					foreach ($buf as $buf2) {
						$buf3=explode('^<',$buf2);
						if(strlen($buf3[0])>0 && strlen($buf3[1])>0)
							accordion($buf3[0],$buf3[1]);
					} ?>
				</div>
			</div>
			<?=footer()?>
		</div>
	</body>
</html>