<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			require_once '../functions/main.php';
			head(0,0,'Адміністування',1);
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
			if($u!=1)
				$err=1;
		}
		else
			$err=1;
		if($err==1)
			echo '<div class="alert alert-danger">Доступ заборонений</div>';
		else if(isset($_GET['a'])){
			$a=$_GET['a'];
			if($a=='addPost'){
				?><br><form action="<?=LINK?>adm/?r=created" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4link">Посилання на пост:</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><?=LINK.'p/'?></span>
								<input id="a4link" name="postLink" type="text" class="form-control" required placeholder="Вкажіть посилання для цього посту">
								<span class="input-group-addon">/</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4name">Назва посту:</label>
						<div class="col-sm-9">
							<input id="a4name" class="form-control" name="postName" required placeholder="Назва сторінки">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4category">Категорія:</label>
						<div class="col-sm-9">
							<input id="a4name" class="form-control" name="postCategory" placeholder="Категорія">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Контент посту:</label>
						<div class="col-sm-9">
							<div class="addableContentContainer">
								<div class="addableContentDiv">
									<textarea class="form-control" name="postContent_1" required placeholder="Текст"></textarea>
									<button onclick="$(this).closest('.addableContentDiv').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
								<br><hr><br></div>
							</div>
							<div class="btn-group">
								<h4>Додати:</h4>
								<button id="addPar" type="button" class="btn btn-success btn-sm">Текст</button>
								<button id="addImg" type="button" class="btn btn-success btn-sm">Зображення</button>
								<button id="addVid" type="button" class="btn btn-success btn-sm">Відео Youtube</button>
								<button id="addAud" type="button" class="btn btn-success btn-sm">Аудіо</button>
								<button id="addFil" type="button" class="btn btn-success btn-sm">Файл</button>
							</div>
							<script>
								function incrementLastContentId() {
									$('#lastContentId').val( function(i, oldval) {
											return ++oldval;
									});
								}
								$('#addPar').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv"><textarea class=\"form-control\" name=\"postContent_'+buf+'\" required placeholder=\"Текст\"></textarea><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><hr><br></div>')
								});
								$('#addImg').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv">Виберіть зображення: <input id=\"a2av\" type=\"file\" accept=\"image/*\" name=\"img_'+buf+'\"><br>Розташування зображення:<br><input value="1" type=\"radio\" id=\"l_'+buf+'\" name=\"imgAlign_'+buf+'\" checked><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"l_'+buf+'\">Ліворуч</label><input value="2" type=\"radio\" id=\"c_'+buf+'\" name=\"imgAlign_'+buf+'\"><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"c_'+buf+'\">Посередині</label><input value="3" type=\"radio\" id=\"r_'+buf+'\" name=\"imgAlign_'+buf+'\"><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"r_'+buf+'\">Праворуч</label><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addVid').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv">Вкажіть адресу відео: <input class="form-control" id=\"a2vi\" type=\"text\" name=\"vid_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addAud').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv">Виберіть аудіо файл: <input id=\"a2au\" type=\"file\" accept=\"audio/*\" name=\"aud_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addFil').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv">Виберіть файл (максимальний розмір: 6мб): <input id=\"a2fl\" type=\"file\" name=\"fil_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
							</script>
						</div>
					</div>
					<div class="btn-group">
						<input type="hidden" id="lastContentId" name="lastContentId" value="1">
						<a style="color:#fff;" href="<?=LINK?>adm" class="btn btn-danger">Скасувати</a>
						<button type="submit" class="btn btn-primary">Створити пост</button>
					</div>
				</form>
				<?php
			}
			else if($a=='editPost' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
				$id=$_GET['id'];
				function prr($res){
					return preg_replace('/</','&lt;',$res);
				}
				que('SELECT * FROM '._POSTS_.' WHERE id="'.$id.'"');
				$row=mysql_fetch_array($res);
				$path=$row['link'];
				$a = array('/&#60;/','/&#62;/','/&#34;/','/&#32;/','/\\\\\|\\/<p>/','/<br>/');
				$b = array('<','>','"',"'",'','');
				$c=preg_replace($a,$b,$row['content']);
				$cId=1;
				$isrc = '../p/'.$path.'/img_';
				$fsrc = LINK.'p/'.$path.'/fil_';
				$asrc = LINK.'p/'.$path.'/aud_';
				for($i=0;$i<=strlen($c);){
					if(substr($c,$i,7)=="\|/</p>")
						break;
					if(substr($c,$i,9)=='\|/<img="'){
						$src=substr($c,$i+9,strrpos(substr($c,$i+9,15),'"c="'));
						rename('../p/'.$path.'/'.$src,$isrc.$cId.substr($src,strrpos($src,'.')));
						$i+=9+strlen($src)+4;
						$finalContent.='<div class="addableContentDiv"><input type="hidden" name="realImgId_'.$cId.'" value="'.$cId.'"><img class="escImg" src="'.$isrc.$cId.'.'.substr($src,strrpos($src,'.')+1).'"><br>Завантажити інше зображення: <input id="a2av" type="file" accept="image/*" name="img_'.$cId.'"><br>Розташування зображення:<br><input value="1" type="radio" id="l_'.$cId.'" name="imgAlign_'.$cId.'" ';
						if(substr($c, $i,1)=="l")
							$finalContent.='checked';
						$finalContent.='><label style="margin: 0 10px 0 0" class="l btn btn-success" for="l_'.$cId.'">Ліворуч</label><input value="2" type="radio" id="c_'.$cId.'" name="imgAlign_'.$cId.'"';
						if(substr($c, $i,9)=="centerImg")
							$finalContent.='checked';
						$finalContent.='><label style="margin: 0 10px 0 0" class="l btn btn-success" for="c_'.$cId.'">Посередині</label><input value="3" type="radio" id="r_'.$cId.'" name="imgAlign_'.$cId.'"';
						if(substr($c, $i,1)=="r")
							$finalContent.='checked';
						$finalContent.='><label style="margin: 0 10px 0 0" class="l btn btn-success" for="r_'.$cId.'">Праворуч</label><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>';
						$cId++;
						$i+=strpos(substr($c,$i,20),'"img>')+5;
					}
					else if(substr($c,$i,9)=='\|/<vid="'){
						$link=substr($c,$i+9,strpos(substr($c,$i+9,20),'"vid>'));
						$i+=9+strlen($link)+5;
						$finalContent.='<div class="addableContentDiv"><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$link.'?rel=0" frameborder="0" allowfullscreen></iframe><br>Вкажіть адресу відео:<br><input class="form-control" value="https://www.youtube.com/watch?v='.$link.'" id="a2vi" type="text" name="vid_'.$cId.'"><button onclick="$(this).closest(".addableContentDiv").remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>';
						$cId++;
					}
					else if(substr($c,$i,9)=='\|/<aud="'){
						$src=substr($c,$i+9,strrpos(substr($c,$i+9,15),'"aud>'));
						$type2=substr($src,strrpos($src,'.'));
						rename('../p/'.$path.'/'.$src,$asrc.$cId.$type2);
						$i+=9+strlen($src)+5;
						$finalContent.='<div class="addableContentDiv"><audio controls><source type="audio/';
						if($type2=='.mp3')
							$finalContent.='mpeg';
						else
							$finalContent.=substr($type2,'1');
						$finalContent.='" src="'.$asrc.$cId.$type2.'"></audio><input type="hidden" name="realAudId_'.$cId.'" value="'.$imgId.'"><br>Виберіть аудіо файл:<br><input id="a2au" type="file" accept="audio/*" name="aud_'.$cId.'"><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>';
						$i+=strlen($aud);
						$cId++;
					}	
					else if(substr($c,$i,9)=='\|/<fil="'){
						$fil=substr($c,$i+9,strrpos(substr($c,$i+9,15),'",fil"'));
						$finalContent.='<div class="addableContentDiv"><a href="'.LINK.'p/'.$path.'/'.$fil.'" target="_blank" download>Завантажити файл ('.$fil.')</a><input type="hidden" name="realFilId_'.$cId.'" value="'.$cId.'"><input type="hidden" name="fileName_'.$cId.'" value="'.$fil.'"><br>Виберіть файл:<br><input id="a2au" type="file" name="fil_'.$cId.'"><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>';
						$i+=9+2*strlen($fil)+6+5;
						$cId++;
					}
					else {
						if($i+7>=strlen($c) || substr($c, $i,7)=="\|/</p>")
							break;
						$finalContent.='<div class="addableContentDiv"><textarea class="form-control" name="postContent_'.$cId.'" required placeholder="Текст">'.substr($c, $i,strpos(substr($c, $i),'\|/<')).'</textarea><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><hr><br></div>';
						if(strpos(substr($c, $i),'\|/<')===0);
							$i++;
						$i+=strpos(substr($c, $i),'\|/<');
						$cId++;
						if($i+7>=strlen($c) || substr($c, $i,7)=="\|/</p>")
							break;
					}
				}
				if($type==2 && $row['creator_name']!=_ID_)
					echo '<br><div class="alert">Ви можете самостійно виправити пост учня, залишити коментарь в відповідне поле і відправити на перездачу або вказати оцінку та натиснути "Опублікувати"</div><br>';
				?><br><form action="<?=LINK?>adm/?r=edited&id=<?=$id?>" enctype="multipart/form-data" class="overflowHiddenDivParrent" method="post">
					<?php if($row['editor_name']!=_ID_ && $type!=2){
						if(strlen($row['coment'])>1 && $type!=2)
							echo '<div class="form-group">
									<label class="control-label col-sm-2" for="a2comment">Коментарь від вчителя до вашого посту:</label>
									<div class="col-sm-9">
										<textarea id="a2comment" readonly class="form-control">'.$row['coment'].'</textarea>
									</div>
								</div>';
						if(preg_match('/^1[0-2]*$|^[1-9]$/',$row['points']))
						echo '<div class="form-group">
							<label class="control-label col-sm-2" for="a2points">Оцінка учню:</label>
								<div class="col-sm-9">
									<input class="form-control" id="a2points" readonly value="'.$row['points'].'">
								</div>
							</div>';
					}
					else if($type==2 && $row['creator_name']!=_ID_){
						echo '<div class="form-group">
							<label class="control-label col-sm-2" for="a2coment">Коментарь учню до посту:</label>
							<div class="col-sm-9">
								<textarea id="a2coment" name="postcoment" class="form-control">'.$row['coment'].'</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="a2points">Оцінка учню:</label>
							<div class="col-sm-9">
								<select class="form-control" name="points" id="a2points">';
									for($i=1;$i<=12;$i++){
										echo '<option value="'.$i.'"';
										if($row['points']==$i || (($row['points']<1 || $row['points']>12) && $i==12))
											echo ' selected';
										echo '>'.$i.'</option>';
									}
								echo '</select>
							</div>
						</div>';
					} ?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a2link">Посилання на пост:</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><?=LINK.'p/'?></span>
								<input id="a2link" name="postLink" type="text" class="form-control" required value="<?=$row['link']?>" placeholder="Вкажіть посилання для цього посту">
								<span class="input-group-addon">/</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a3name">Назва посту:</label>
						<div class="col-sm-9">
							<input id="a3name" class="form-control" name="postName" required value="<?=$row['name']?>" placeholder="Назва сторінки">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4category">Категорія:</label>
						<div class="col-sm-9">
							<input id="a4name" class="form-control" name="postCategory" value="<?=$row['category']?>" placeholder="Категорія">
						</div>
					</div>
					<?php
						$ras=mysql_query('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"');
						$raw=mysql_fetch_array($ras);
						if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
							$creator_name=$raw['u_name'].' '.$raw['u_surname'];
						else
							$creator_name=str_rot13($raw['login']);
						$ras=mysql_query('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$row['editor_name'].'"');
						$raw=mysql_fetch_array($ras);
						if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
							$editor_name=$raw['u_name'].' '.$raw['u_surname'];
						else
							$editor_name=str_rot13($raw['login']);
						echo '<div class="form-group">
							<label class="control-label col-sm-2">Ім\'я того, хто створив:</label>
							<div class="col-sm-9">'.$creator_name.'</div><br>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Дата створення:</label>
							<div class="col-sm-9">'.$row['date'].'</div><br>
						</div>';
						if(strlen($editor_name)>0)
							echo '<div class="form-group">
						<label class="control-label col-sm-2">Ім\'я того, хто редагував:</label>
								<div class="col-sm-9">'.$editor_name.'</div><br>
							</div>';
						if(strlen($row['edit_date'])>0)
							echo '<div class="form-group">
										<label class="control-label col-sm-2">Дата останього редагування:</label>
										<div class="col-sm-9">'.$row['edit_date'].'</div><br>
							</div>';
					?><div class="form-group">
						<label class="control-label col-sm-2">Контент посту:</label>
						<div class="col-sm-9">
							<div class="addableContentContainer">
								<?=$finalContent?>
							</div>
							<div class="btn-group">
								<h4>Додати:</h4>
								<button id="addPar" type="button" class="btn btn-success btn-sm">Текст</button>
								<button id="addImg" type="button" class="btn btn-success btn-sm">Зображення</button>
								<button id="addVid" type="button" class="btn btn-success btn-sm">Відео Youtube</button>
								<button id="addAud" type="button" class="btn btn-success btn-sm">Аудіо</button>
								<button id="addFil" type="button" class="btn btn-success btn-sm">Файл</button>
							</div>
							<script>
								function incrementLastContentId() {
									$('#rLastContentId').val( function(i, oldval) {
											return ++oldval;
									});
								}
								$('#addPar').click( function() {
									incrementLastContentId();
									var buf=$('#rLastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv"><textarea class=\"form-control\" name=\"postContent_'+buf+'\" required placeholder=\"Текст\"></textarea><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><hr><br></div>')
								});
								$('#addImg').click( function() {
									incrementLastContentId();
									var buf=$('#rLastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv"><input type="hidden" name="realImgId_'+buf+'" value="'+buf+'">Виберіть зображення: <input id=\"a2av\" type=\"file\" accept=\"image/*\" name=\"img_'+buf+'\"><br>Розташування зображення:<br><input value="1" type=\"radio\" id=\"l_'+buf+'\" name=\"imgAlign_'+buf+'\" checked><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"l_'+buf+'\">Ліворуч</label><input value="2" type=\"radio\" id=\"c_'+buf+'\" name=\"imgAlign_'+buf+'\"><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"c_'+buf+'\">Посередині</label><input value="3" type=\"radio\" id=\"r_'+buf+'\" name=\"imgAlign_'+buf+'\"><label style="margin: 0 10px 0 0" class="l btn btn-success" for=\"r_'+buf+'\">Праворуч</label><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addVid').click( function() {
									incrementLastContentId();
									var buf=$('#rLastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv">Вкажіть адресу відео: <input class="form-control" id=\"a2vi\" type=\"text\" name=\"vid_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addAud').click( function() {
									incrementLastContentId();
									var buf=$('#rLastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv"><input type="hidden" name="realAudId_'+buf+'" value="'+buf+'">Виберіть аудіо файл: <input id=\"a2au\" type=\"file\" accept=\"audio/*\" name=\"aud_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
								$('#addFil').click( function() {
									incrementLastContentId();
									var buf=$('#rLastContentId').val();
									$('.addableContentContainer').append('<div class="addableContentDiv"><input type="hidden" name="realFilId_'+buf+'" value="'+buf+'">Виберіть файл (максимальний розмір: 6мб): <input id=\"a2fl\" type=\"file\" name=\"fil_'+buf+'\"><br><button onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button><br><br><hr><br></div>')
								});
							</script>
						</div>
					</div>
					<div class="btn-group">
						<input type="hidden" id="rLastContentId" name="rLastContentId" value="<?=$cId?>">
						<a style="color:#fff;" target="_blank" href="<?=LINK.'p/'.$row['link']?>/" class="btn btn-success">Переглянути пост</a>
						<a style="color:#fff;" href="<?=LINK?>adm?r=deleted&id=<?=$id?>" class="btn btn-danger">Видалити пост</a>
						<a style="color:#fff;" href="<?=LINK?>adm" class="btn btn-danger">Скасувати зміни</a><?php
						if($type==2 && $row['creator_name']!=$id)
							echo '<button type="submit" name="notApr" class="btn btn-warning">Відправити на перездачу</button><button type="submit" class="btn btn-primary">Опублікувати</button>';
						else
							echo '<button type="submit" class="btn btn-primary">Зберегти зміни</button>';
					?></div>
				</form>
				<?php
			}
		}
		else {
			echo '<div style="padding:10px;overflow:hidden">';#Статистика
				que("SELECT id FROM "._USERS_);
				$u=mysql_num_rows($res);
				que("SELECT id FROM "._POSTS_);
				$u1=mysql_num_rows($res);
				que("SELECT id FROM "._POSTS_." WHERE creator_name='".$id."'");
				$u2=mysql_num_rows($res);
				echo '<div class="alert">На сайті зареєстровано '.$u.' користувачів<br>Загальна кількість постів на сайті: '.$u1.'<br>Кількість постів, які ви створили: '.$u2.'<br>Натисніть на рядок, щоб редагувати пост<br>Натисніть на клавішу "Додати пост" щоб додати новий пост</div>';
				if($_GET['r']=='deleted' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
					que('SELECT link FROM '._POSTS_.' WHERE id="'.$_GET['id'].'"');
					$row=mysql_fetch_array($res);
					array_map('unlink', glob('../p/'.$row['link'].'/*.*'));
					rmdir('../p/'.$row['link'].'/');
					que('DELETE FROM '._POSTS_.' WHERE link="'.$row['link'].'"');
					echo '<div class="alert alert-success">Пост успішно видалено</div>';
				}
				if($_GET['r']=='created'){
					if(isset($_POST['postName']) && isset($_POST['postLink']))
						que('SELECT link FROM '._POSTS_.' WHERE name="'.$_POST['postName'].'" AND link="'.$_POST['postLink'].'"');
					$u=mysql_num_rows($res);
					if($u==0){
						que('SELECT link FROM '._POSTS_);
						while($row=mysql_fetch_array($res))
							if($row['link']==$_POST['postLink'])
								$clear=1;
						if($clear){
							for($buf=rand()%1000,$u=1;$u!=0;$buf=rand()%1000){
								que('SELECT link FROM '._POSTS_.' WHERE link="'.$_POST['postLink'].$buf.'"');
								$u=mysql_num_rows($res);
							}
							$_POST['postLink'].=$buf;
							echo '<div class="alert alert-warning">Вказаний адрес посту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагування посту</div>';
						}
						$lastContentId=$_POST['lastContentId'];
						$path=$_POST['postLink'];
						mkdir('../p/'.$path.'/');
						copy('../p/NO_DELETE/index.php','../p/'.$path.'/index.php');
						$content.='\\\\|/<p>';
						$cId=1;
						for($i=1;$i<=$lastContentId;$i++){
							if(isset($_POST['postContent_'.$i])){
								$content.=$_POST['postContent_'.$i];
								$cId++;
								while(isset($_POST['postContent_'.($i+1)])){
									$i++;
									$content.=$_POST['postContent_'.$i];
								}
							}
							else if($_FILES['img_'.$i]['size']>0){
								if(preg_match('/image\//',$_FILES['img_'.$i]['type']) && $_FILES['img_'.$i]["size"]<10*1024*1024){
									move_uploaded_file($_FILES['img_'.$i]['tmp_name'],'../p/'.$path.'/img_'.$cId.'.'.pathinfo($_FILES['img_'.$i]['name'],PATHINFO_EXTENSION));
									$content.='\\\\|/<img="img_'.$cId.'.'.pathinfo($_FILES['img_'.$i]['name'],PATHINFO_EXTENSION).'"c="';
									if($_POST['imgAlign_'.$i]==1)
										$content.='l';
									else if($_POST['imgAlign_'.$i]==3)
										$content.='r';
									else
										$content.='centerImg';
									$content.='"img>';
									$cId++;
								}
								else
									echo '<div class="alert alert-danger">Зображення повині бути в одному з цих форматів: jpg, gif, png або tiff та займати менше 10 мб</div>';
							}
							else if($_POST['vid_'.$i]){
								if(preg_match('/v=[A-Za-z0-9_\-]{11}/',$_POST['vid_'.$i])){
									$content.='\\\\|/<vid="'.substr($_POST['vid_'.$i],strrpos($_POST['vid_'.$i],'v=')+2,11) .'"vid>';
									$cId++;
								}
								else
									echo '<div class="alert alert-danger">Вжатіь правильне посиланння на Youtube відео ("'.$_POST['vid_'.$i].'" не є правильним)</div>';
							}
							else if($_FILES['aud_'.$i]['size']>0){
								$a=array('.mp3','.ogg','.wav');
								$f=strtolower(strrchr($_FILES['aud_'.$i]['name'],'.'));
								if(in_array($f,$a) && $_FILES['aud_'.$i]["size"]<10*1024*1024){
									move_uploaded_file($_FILES['aud_'.$i]['tmp_name'],'../p/'.$path.'/aud_'.$cId.'.'.pathinfo($_FILES['aud_'.$i]['name'],PATHINFO_EXTENSION));
									$content.='\\\\|/<aud="aud_'.$cId.'.'.pathinfo($_FILES['aud_'.$i]['name'],PATHINFO_EXTENSION).'"aud>';
									$cId++;
								}
								else
									echo '<div class="alert alert-danger">Аудіо файли повині займати менше ніж 10 мб та бути в одному з цих форматів: mp3, ogg або wav</div>';
							}
							else if($_FILES['fil_'.$i]['size']>0){
								if($_FILES['fil_'.$i]['size']>10*1024*1024)
									echo '<div class="alert alert-danger">Файли повині займати менше ніж 10 мб</div>';
								else {
									$f='fil_'.$cId.'.'.pathinfo($_FILES['fil_'.$i]['name'],PATHINFO_EXTENSION);
									move_uploaded_file($_FILES['fil_'.$i]['tmp_name'],'../p/'.$path.'/'.$f);
									$content.='\\\\|/<fil="'.$f.'",fil"'.$f.'"fil>';
									$cId++;
								}
							}
						}
						$content.='\\\\|/</p>';
						que('SELECT id FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
						$row=mysql_fetch_array($res);
						$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
						$dt->setTimestamp(time());
						$a = array('/</','/>/','/"/',"/'/");
						$b = array('&#60;','&#62;','&#34;','&#32;');
						$checked=($type==2)?1:0;
						$que='INSERT INTO '._POSTS_.' (link,name,content,date,creator_name,checked,unixTime';
						if(isset($_POST['postCategory']))
							$que.=',category';
						$que.=') values("'.$path.'","'.$_POST['postName'].'","'.preg_replace($a,$b,nl2br($content,false)).'","'.$dt->format('d.m.Y в H:i').'","'.$row['id'].'","'.$checked.'"';
						$que.=',"'.time().'"';
						if(isset($_POST['postCategory']))
							$que.=',"'.$_POST['postCategory'].'"';
						$que.=');';
						que($que);
						echo '<div class="alert alert-success">Пост успішно додано</div>';
					}
				}
				if($_GET['r']=='edited' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
					que('SELECT link,creator_name,content FROM '._POSTS_.' WHERE id="'.$_GET['id'].'"');
					while($row=mysql_fetch_array($res))
						if($row['link']==$_POST['postLink'])
							$unclear=1;
					if($clear){
						for($buf=rand()%1000,$u=1;$u!=0;$buf=rand()%1000){
							que('SELECT link FROM '._POSTS_.' WHERE link="'.$_POST['postLink'].$buf.'"');
							$u=mysql_num_rows($res);
						}
						$_POST['postLink'].=$buf;
						echo '<div class="alert alert-warning">Вказаний адрес посту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагування посту</div>';
					}
					$content.='\\\\|/<p>';
					$path=$_POST['postLink'];
					$psrc='../p/'.$path.'/img_';
					$asrc='../p/'.$path.'/aud_';
					$fsrc='../p/'.$path.'/fil_';
					$cId=1;
					for($i=1;$i<=$_POST['rLastContentId'];$i++,$was=0){
						if(isset($_POST['postContent_'.$i])){
							$was=1;
							$content.=$_POST['postContent_'.$i];
							$cId++;
							while(isset($_POST['postContent_'.($i+1)])){
								$cId++;
								$i++;
								$content.=$_POST['postContent_'.$i];
							}
						}
						else if(isset($_POST['imgAlign_'.$i])){
							$was=1;
							if($_FILES['img_'.$i]['size']>0){
								if(preg_match('/image\//',$_FILES['img_'.$i]['type']) && $_FILES['img_'.$i]["size"]<10*1024*1024){
									move_uploaded_file($_FILES['img_'.$i]['tmp_name'],'../p/'.$path.'/img_'.$cId.'.'.pathinfo($_FILES['img_'.$i]['name'],PATHINFO_EXTENSION));
									$content.='\\\\|/<img="img_'.$cId.'.'.pathinfo($_FILES['img_'.$i]['name'],PATHINFO_EXTENSION).'"c="';
									if($_POST['imgAlign_'.$i]==1)
										$content.='l';
									else if($_POST['imgAlign_'.$i]==3)
										$content.='r';
									else
										$content.='centerImg';
									$content.='"img>';
									$cId++;
								}
								else
									echo '<div class="alert alert-danger">Зображення повині бути в одному з цих форматів: jpg, gif, png або tiff та займати менше 10 мб</div>';
							}
							else {
								if (@getimagesize($psrc.$i.'.jpg'))
									$src2='jpg';
								else if (@getimagesize($psrc.$i.'.jpeg'))
									$src2='jpeg';
								else if (@getimagesize($psrc.$i.'.png'))
									$src2='png';
								else if (@getimagesize($psrc.$i.'.tiff'))
									$src2='tiff';
								else if (@getimagesize($psrc.$i.'.gif'))
									$src2='gif';
								rename($psrc.$i.'.'.$src2,$psrc.$cId.'.'.$src2);
								$content.='\\\\|/<img="img_'.$cId.'.'.$src2.'"c="';
								if($_POST['imgAlign_'.$i]==1)
									$content.='l';
								else if($_POST['imgAlign_'.$i]==3)
									$content.='r';
								else
									$content.='centerImg';
								$content.='"img>';
								$cId++;
							}
						}
						else if($_POST['vid_'.$i]){
							$was=1;
							if(preg_match('/v=[A-Za-z0-9_\-]{11}/',$_POST['vid_'.$i])){
								$content.='\\\\|/<vid="'.substr($_POST['vid_'.$i],strrpos($_POST['vid_'.$i],'v=')+2,11) .'"vid>';
								$cId++;
							}
							else
								echo '<div class="alert alert-danger">Вжатіь правильне посиланння на Youtube відео ("'.$_POST['vid_'.$i].'" не є правильним)</div>';
						}
						else if(isset($_POST['realAudId_'.$i])){
							$was=1;
							if($_FILES['aud_'.$i]['size']>0){
								$a=array('.mp3','.ogg','.wav');
								$f=strtolower(strrchr($_FILES['aud_'.$i]['name'],'.'));
								if(in_array($f,$a) && $_FILES['aud_'.$i]["size"]<10*1024*1024){
									move_uploaded_file($_FILES['aud_'.$i]['tmp_name'],'../p/'.$path.'/aud_'.$cId.'.'.pathinfo($_FILES['aud_'.$i]['name'],PATHINFO_EXTENSION));
									$content.='\\\\|/<aud="aud_'.$cId.'.'.pathinfo($_FILES['aud_'.$i]['name'],PATHINFO_EXTENSION).'"aud>';
									$cId++;
								}
								else
									echo '<div class="alert alert-danger">Аудіо файли повині займати менше ніж 10 мб та бути в одному з цих форматів: mp3, ogg або wav</div>';
							}
							else {
								if(file_exists($asrc.$i.'.mp3'))
									$src3='.mp3';
								else if(file_exists($asrc.$i.'.wav'))
									$src3='.wav';
								else if(file_exists($asrc.$i.'.ogg'))
									$src3='.ogg';
								rename($asrc.$i.$src3,$asrc.$cId.$src3);
								$content.='\\\\|/<aud="aud_'.$cId.$src3.'"aud>';
								$cId++;
							}
						}
						else if(isset($_POST['realFilId_'.$i])){
							$was=1;
							if($_FILES['fil_'.$i]['size']>0){
								if($_FILES['fil_'.$i]['size']>10*1024*1024)
									echo '<div class="alert alert-danger">Файли повині займати менше ніж 10 мб</div>';
								else {
									$f='fil_'.$cId.'.'.pathinfo($_FILES['fil_'.$i]['name'],PATHINFO_EXTENSION);
									move_uploaded_file($_FILES['fil_'.$i]['tmp_name'],'../p/'.$path.'/'.$f);
									$content.='\\\\|/<fil="'.$f.'",fil"'.$f.'"fil>';
									$cId++;
								}
							}
							else if(isset($_POST['fileName_'.$i])){
								$src4=substr($_POST['fileName_'.$i],strpos($_POST['fileName_'.$i],'.')+1);
								$cId++;
								$content.='\\\\|/<fil="fil_'.$i.'.'.$src4.'",fil"fil_'.$i.'.'.$src4.'"fil>';
							}

						}
						else if(!$was){
							unlink($isrc.$i.'.jpg');
							unlink($isrc.$i.'.png');
							unlink($isrc.$i.'.gif');
							unlink($isrc.$i.'.tiff');
							unlink($isrc.$i.'.ico');
							unlink($asrc.$i.'.wav');
							unlink($asrc.$i.'.mp3');
							unlink($asrc.$i.'.ogg');
							$src=NULL;
							$src=substr($old_cont,strpos($old_cont,'<fil="fil_'.$i)+strlen($i)+10,strpos(substr($old_cont,strpos($old_cont,'<fil="fil_'.$i)+strlen($i)+10),'"'));
							unlink($fsrc.$i.$src);
						}
					}
					$content.='\\\\|/</p>';
					if($type==2 && $row['creator_name']!=$id){
						if(isset($_POST['notApr']))
							$checked=-1;
						else
							$buf=1;
					}
					else if($type==2)
						$buf=1;
					else
						$checked=0;
					if($buf==1){
						$checked=1;
						if(preg_match('/^1[0-2]*$|^[1-9]$/',$_POST['points']))
							$mark=$_POST['points'];
						else
							$mark=0;
					}
					else
						$mark=0;
					que('SELECT link FROM '._POSTS_.' WHERE id="'.$_GET['id'].'"');
					$row=mysql_fetch_array($res);
					rename('../p/'.$row['link'],'../p/'.$_POST['postLink']);
					que('SELECT id FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
					$row=mysql_fetch_array($res);
					que('UPDATE '._POSTS_.' SET editor_name="'.$row['id'].'" WHERE id="'.$_GET['id'].'"');
					$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
					$dt->setTimestamp(time());
					$a = array('/</','/>/','/"/',"/'/");
					$b = array('&#60;','&#62;','&#34;','&#32;');
					if($type!=2)
						$_POST['postcoment']==0;
					$que='UPDATE '._POSTS_.' SET link="'.$path.'", name="'.$_POST['postName'].'", content="'.preg_replace($a,$b,nl2br($content,false)).'", edit_date="'.$dt->format('d.m.Y в H:i').'", editor_name="'.$g_id.'", coment="'.$_POST['postcoment'].'", checked="'.$checked.'"';
					if($mark!=0)
						$que.=', points="'.$mark.'"';
					if(isset($_POST['postCategory']))
						$que.=', category="'.$_POST['postCategory'].'"';
					que($que.' WHERE id="'.$_GET['id'].'"');
					echo '<div class="alert alert-success">Пост успішно змінено</div>';
				}
				que('SELECT * FROM '._POSTS_);
				$u=mysql_num_rows($res);
				?>
				<table id="tableCond" class="table table-striped">
					<thead>
						<tr>
							<th class="hidden-xs">Посилання</th>
							<th>Назва</th>
							<th class="hidden-xs">Дата створення</th>
							<th>Автор</th>
							<th>Статус</th>
							<th>Оцінка</th>
							<th>Дії</th>
						</tr>
					</thead>
					<tbody>
						<script>
							if($(window).width()<768){
								$('#tableCond').addClass('table-condensed');
							}
						</script><?php
						while($row=mysql_fetch_array($res)){
							$ras=mysql_query('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"');
							$raw=mysql_fetch_array($ras);
							if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
								$creator_name=$raw['u_name'].' '.$raw['u_surname'];
							else
								$creator_name=str_rot13($raw['login']);
							echo '<tr';
							if($type==2 || $row['creator_name']==$id)
								echo ' style="cursor: pointer" onclick="window.document.location=\''.LINK.'adm/?a=editPost&id='.$row['id'].'\'"';
							echo '>
								<td class="hidden-xs">'.$row['link'].'</td>
								<td>'.$row['name'].'</td>
								<td class="hidden-xs">'.$row['date'].'</td>
								<td>'.$creator_name.'</td>';
								if($row['checked']==-1)
									echo '<td class="text-danger">Перездати</td>';
								else if($row['checked']==0)
									echo '<td class="text-warning">Надіслано</td>';
								else if($row['checked']==1)
									echo '<td class="text-success">Здано</td>';
								echo '</td>
								<td>'.$row['points'].'</td>';
								if($row['creator_name']==$id || $type==2)
									echo '<td> <i class="glyphicon glyphicon-pencil"></i> </td>';
								else
									echo '<td></td>';
							echo '</tr>';
						}
					echo '</tbody>
				</table>
				<a href="'.LINK.'adm/?a=addPost" style="color:#fff" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Додати пост</a>';
				if($type==2)
					echo ' <a href="slider.php" class="btn btn-success" style="color:#fff">Редагувати слайдер</a>';
			echo '</div>';
		}
		down();?>
		<script>function redir(where) {window.location.href = where;}</script>
	</body>
</html>