<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			require_once '../functions/main.php';
			head(0,0,'Слайдер',1);
			global $row,$res;
		?>
	</head>
	<body>
		<?php top();
		if(preg_match('/[a-z0-9]/', $_COOKIE['hesh'])){
			que('SELECT id,type FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
			$row=mysql_fetch_array($res);
			$u=mysql_num_rows($res);
			$id=$row['id'];
			$g_id=$row['id'];
			$type=$row['type'];
			if($u!=1 || $type!=2)
				$err=1;
		}
		else
			$err=1;
		if($err==1)
			echo '<div class="alert alert-danger">Доступ заборонений</div>';
		?>
		<div style="padding:10px;overflow:hidden">
			<a href="<?=LINK?>" class="btn btn-success" style="color:#fff">На головну</a>
			<a href="<?=LINK?>adm/" class="btn btn-success" style="color:#fff">Редагувати пости</a><?php
			$psrc='../images/slider/img_';
			if($_GET['s']=='edited' && isset($_POST['lastSlideId'])){
				que('DELETE FROM '._SLIDER_);
				for($i=0;$i<$_POST['lastSlideId']+1;$i++){
					if(!isset($_POST['sliderLoadImgId_'.$i])){
						unlink($psrc.$i.'.jpg');
						unlink($psrc.$i.'.gif');
						unlink($psrc.$i.'.png');
						unlink($psrc.$i.'.tiff');
						continue;
					}
					if($_FILES['sImg_'.$i]['size']>0){
						switch($_FILES['sImg_'.$i]['type']){
							case "image/jpeg":$src2="jpg";$t=1;break;
							case "image/gif":$src2="gif";$t=2;break;
							case "image/png":$src2="png";$t=3;break;
							case "image/tiff":$src2="tiff";$t=4;break;
						}
						if(isset($src2)){
							unlink($psrc.$i.'.jpg');
							unlink($psrc.$i.'.gif');
							unlink($psrc.$i.'.png');
							unlink($psrc.$i.'.tiff');
							move_uploaded_file($_FILES['sImg_'.$i]['tmp_name'],$psrc.$i.'.'.$src2);
						}
						else
							echo "<div class=\"alert alert-danger\">Зображення повино бути в форматі jpg, giff, png або tiff</div></div>";
					}
					if(isset($_POST['sliderText_'.$i]))
						que('INSERT INTO '._SLIDER_.' values("'.$i.'","'.$_POST['sliderText_'.$i].'")');
					else
						que('INSERT INTO '._SLIDER_.'(id) values("'.$i.'")');
				}
				$_POST['lastSlideId']=NULL;
			}
			que('SELECT MAX(id) FROM '._SLIDER_);
			$u=mysql_fetch_array($res);
			if(!isset($u['MAX(id)']))
				$u['MAX(id)']=100;
			que('SELECT * FROM '._SLIDER_);
			?>
				<form action="<?=LINK?>adm/slider.php?s=edited" enctype="multipart/form-data" method="post">
					<table class="table table-striped">
						<thead>
							<tr>
								<th colspan="2">Зображення</th>
								<th>Текст</th>
								<th style="text-align:right">Видалити</th>
							</tr>
						</thead>
						<tbody id="sliderTableBody"><?php
						while($row=mysql_fetch_array($res)){
							if (@getimagesize($psrc.$row['id'].'.jpg'))
								$sliderSrc='jpg';
							else if (@getimagesize($psrc.$row['id'].'.png'))
								$sliderSrc='png';
							else if (@getimagesize($psrc.$row['id'].'.tiff'))
								$sliderSrc='tiff';
							else if (@getimagesize($psrc.$row['id'].'.gif'))
								$sliderSrc='gif';
							echo '<tr class="addableSliderImg"><td><input name="sliderLoadImgId_'.$row['id'].'" class="sliderLoadImgId" type="hidden" value="'.$row['id'].'"><img style="max-width:15vw;max-height:15vh" src="'.LINK.'images/slider/img_'.$row['id'].'.'.$sliderSrc.'"></td><td><input type="file" accept="image/*" name="sImg_'.$row['id'].'"></td><td><input type="text" value="'.$row['text'].'" name="sliderText_'.$row['id'].'"></td><td><button onclick="$(this).closest(\'.addableSliderImg\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></td></tr>';
						}
					?></tbody>
					</table>
					<input id="lastSlideId" value="<?=$u['MAX(id)']?>" type="hidden" name="lastSlideId">
					<div class="btn-group">
						<button id="addSlide" type="button" class="btn btn-success">Додати слайд</button>
						<a style="color:#fff;" href="<?=LINK?>adm?tab=3" class="btn btn-danger">Скасувати зміни</a>
						<button type="submit" class="btn btn-primary">Зберегти зміни</button>
					</div>
				</form>
				<script>
					function incrementLastSlideId() {
						$('#lastSlideId').val( function(i, oldval) {
								return ++oldval;
						});
					}
					$('#addSlide').click( function() {
						incrementLastSlideId();
						var buf=$('#lastSlideId').val();
						$('#sliderTableBody').append('<tr class="addableSliderImg"><td><input name="sliderLoadImgId_'+buf+'" class="sliderLoadImgId" type="hidden" value="'+buf+'"></td><td><input type="file" accept="image/*" name="sImg_'+buf+'"></td><td><input type="text" name="sliderText_'+buf+'"></td><td><button onclick="$(this).closest(\'.addableSliderImg\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></td></tr>');
					});
				</script>
			</div><?php
		echo '</div>';
		down();?>
		<script>function redir(where) {window.location.href = where;}</script>
	</body>
</html>