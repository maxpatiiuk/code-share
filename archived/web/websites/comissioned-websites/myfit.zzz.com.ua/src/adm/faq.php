<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			head(NULL,NULL,'Адміністування',1);
			global $row,$res;
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(1,130);
		if(_TYPE_!=2)
			alert('Доступ заборонений','danger');
		else {
			$buf='SELECT o01 FROM '._PRODUCTS_.' WHERE id=0';//,o02
			if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submitF']) && isset($_POST['lastSlideId'])){
				que($buf);
				$row=mysql_fetch_array($res);
				$buf1=NULL;/*
				$buf2=NULL;
				$buf3=NULL;
				$buf4=NULL;*/
				for($i=0;$i<$_POST['lastSlideId'];$i++)//{
					if(strlen($_POST['f_'.$i.'_q_1'])>0)
						$buf1.='<^'.$_POST['f_'.$i.'_q_1'].'^<'.$_POST['f_'.$i.'_a_1'];/*
					if(strlen($_POST['f_'.$i.'_q_2'])>0)
						$buf2.='<^'.$_POST['f_'.$i.'_q_2'].'^<'.$_POST['f_'.$i.'_a_2'];
				}*/
				que('UPDATE '._PRODUCTS_.' SET o01="'.substr($buf1,2).'" WHERE id=0');//, o02="'.substr($buf2,2).'" 
			}//1 - UA<br>2 - RU<br>
			echo '
			<form method="post" class="form-horizontal fixedTextarea">
				<div id="sliderTableBody">';
					que($buf);
					$row=mysql_fetch_array($res);
					$o1=explode('<^',$row['o01']);
					//$o2=explode('<^',$row['o02']);
					for($i=0;strlen($o1[$i])>0;$i++){
						$oo1=explode('^<',$o1[$i]);
						//$oo2=explode('^<',$o2[$i]);
						echo '<div class="form-group addableSliderImg">
							<div class="control-label col-sm-2">
								Запитання '.$i.':<br>
								<button onclick="$(this).closest(\'.addableSliderImg\').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
							</div>
							<div class="col-sm-9">';/*
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-lg-3">*/ echo '
										<input type="text" class="form-control" placeholder="Запитання" name="f_'.$i.'_q_1" value="'.$oo1[0].'" required>
										<textarea class="form-control" placeholder="Відповідь" name="f_'.$i.'_a_1">'.$oo1[1].'</textarea>
									</div>';/*
									<div class="col-xs-12 visible-xs"><br></div>
									<div class="col-xs-12 col-sm-6 col-lg-3">
										<input type="text" class="form-control" placeholder="Запитання 2" name="f_'.$i.'_q_2" value="'.$oo2[0].'" required>
										<textarea class="form-control" placeholder="Відповідь 2" name="f_'.$i.'_a_2">'.$oo2[1].'</textarea>
									</div>
								</div>
							</div>*/ echo '
						</div>';
					} ?>
				</div>
				<input id="lastSlideId" value="<?=$i?>" type="hidden" name="lastSlideId">
				<div class="btn-group">
					<button id="addSlide" type="button" class="btn btn-success">Додати запитання</button>
					<a style="color:#fff;" href="<?=LINK?>adm/faq.php" class="btn btn-danger">Скасувати зміни</a>
					<input type="submit" name="submitF" id="submitF" class="btn btn-success" value="Зберегти зміни">
				</div>
			</form>
			<script>
				$('#addSlide').click( function() {
					if($('.addableSliderImg').length){
						buf=$('.addableSliderImg:last-child input').attr("name");
						buf=buf.substr(2,buf.substr(2).search('_'));
						buf++;
					}
					else
						buf=0;
					buf++;
					$('#lastSlideId').val(buf);
					buf--;
					$('#sliderTableBody').append(`<div class="form-group addableSliderImg">
						<div class="control-label col-sm-2">
							Запитання `+buf+`:<br>
							<button onclick="$(this).closest(\'.addableSliderImg\').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
						</div>
		   	<div class="col-sm-9">
   				<input type="text" class="form-control" placeholder="Запитання" name="f_`+buf+`_q_1" required>
   				<textarea class="form-control" placeholder="Відповідь" name="f_`+buf+`_a_1"></textarea>
		   	</div>
		   </div>`);/*
		   		<div class="row">
		   			<div class="col-xs-12 col-sm-6 col-lg-3">

		   			</div>
		   		</div>

		   			<div class="col-xs-12 visible-xs"><br></div>
		   			<div class="col-xs-12 col-sm-6 col-lg-3">
		   				<input type="text" class="form-control" placeholder="Запитання 2" name="f_`+buf+`_q_2" required>
		   				<textarea class="form-control" placeholder="Відповідь 2" name="f_`+buf+`_a_2"></textarea>
		   			</div>*/
				});
			</script> <?php
		}
		footer(1);?>
	</body>
</html>