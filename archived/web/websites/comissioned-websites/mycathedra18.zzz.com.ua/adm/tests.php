<!DOCTYPE html>
<html>
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
			if($a=='addTest'){
				?><br><form action="<?=LINK?>adm/tests.php?r=created" enctype="multipart/form-data" method="post">
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4link">Посилання на тест:</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><?=LINK.'p/t/'?></span>
								<input id="a4link" name="postLink" type="text" class="form-control" required placeholder="Вкажіть посилання для цього тесту">
								<span class="input-group-addon">/</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4name">Назва тесту:</label>
						<div class="col-sm-9">
							<input id="a4name" class="form-control" name="postName" required placeholder="Назва тесту">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4class">Клас:</label>
						<div class="col-sm-9">
							<select class="form-control" name="postClass" id="a4class" required>
								<option value="0">Всі класи</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="-1">Випусники</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4category">Категорія:</label>
						<div class="col-sm-9">
							<input id="a4category" class="form-control" name="postCategory" placeholder="Категорія">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Запитання:</label>
						<div class="col-sm-9">
							<div class="addableContentContainer">
								<div class="addableContentDiv">
									<div class="input-group">
										<div class="input-group-addon">1.</div>
										<input type="text" class="form-control" name="postContent_1" required placeholder="Запитання">
										<label class="input-group-addon">
											<button style="padding: 0px 6px;" onclick="$(this).closest('.addableContentDiv').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
										</label>
									</div>
									<div class="questions">
										<div class="input-group">
											<label class="input-group-addon">
												<input type="checkbox" class="l" name="test_1_select_1" value="1">
											</label>
											<input type="text" class="r form-control" name="test_1_question_1" placeholder="Відповідь">
											<label class="input-group-addon">
												<button style="padding: 0px 6px;" onclick="$(this).closest('.input-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
											</label>
										</div>
									</div>
									<button onclick="addEl($(this).closest('.addableContentDiv'),1);" type="button" class="l btn btn-success btn-sm">Додати варіант</button>
									<br><hr><br>
								</div>
							</div>
							<div class="form-group">
								<button id="addQue" type="button" class="btn btn-success btn-sm">Додати запитання</button>
							</div>
							<script>
								function incrementLastContentId() {
									$('#lastContentId').val( function(i, oldval) {
											return ++oldval;
									});
								}
								$('#addQue').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append(`<div class="addableContentDiv">
										<div class="input-group">
											<div class="input-group-addon">`+buf+`.</div>
											<input type="text" class="form-control" name="postContent_`+buf+`" required placeholder="Запитання">
											<label class="input-group-addon">
												<button style="padding: 0px 6px;" onclick="$(this).closest('.addableContentDiv').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
											</label>
										</div>
										<div class="questions">
											<div class="input-group">
												<label class="input-group-addon">
													<input type="checkbox" class="l" name="test_`+buf+`_select_1" value="1">
												</label>
												<input type="text" class="r form-control" name="test_`+buf+`_question_1" placeholder="Відповідь">
												<label class="input-group-addon">
													<button style="padding: 0px 6px;" onclick="$(this).closest('.input-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
												</label>
											</div>
										</div>
          <br>
          <button onclick="addEl($(this).closest('.addableContentDiv'),`+buf+`);" type="button" class="l btn btn-success btn-sm">Додати варіант</button>
          <br><hr><br>
         </div>`);
								});
								function addEl(closest,buf){
									var name=$(closest).find('.questions .input-group:last-child label:first-child input').attr('name');
									name=name.substring(name.lastIndexOf('_')+1);
									if(isNaN(name))
										name=1;
									else
										name++;
									$(closest).find('.questions').append('<div class="input-group"><label class="input-group-addon"><input type="checkbox" class="l" name="test_'+buf+'_select_'+name+'"></label><input type="text" class="r form-control" name="test_'+buf+'_question_'+name+'" placeholder="Відповідь"><label class="input-group-addon"><button style="padding: 0px 6px;" onclick="$(this).closest(\'.input-group\').remove();" type="button" class="r btn btn-danger btn-xs">X</button></label></div>');
								}
							</script>
						</div>
					</div>
					<div class="btn-group">
						<input type="hidden" id="lastContentId" name="lastContentId" value="1">
						<a style="color:#fff;" href="<?=LINK?>adm/tests.php" class="btn btn-danger">Скасувати</a>
						<button type="submit" class="btn btn-primary">Створити тест</button>
					</div>
				</form>
				<?php
			}
			else if($a=='editTest' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
				$id=$_GET['id'];
				que('SELECT * FROM '._POSTS_.' WHERE id="'.$id.'"');
				$row=mysql_fetch_array($res);
				$path=$row['link'];
				$c=preg_replace('/\\\\\|\/</','<',htmlspecialchars_decode(preg_replace('/<br>/','',$row['content'])));
				$cId=1;
				$test = new DOMDocument('1.0');
				$test->preserveWhiteSpace = FALSE;
				$test->loadXML($c);
				$test->formatOutput = TRUE;
				$c=simplexml_import_dom($test);
				if($type==2 && $row['creator_name']!=_ID_)
					echo '<br><div class="alert">Ви можете самостійно виправити тест учня, залишити коментарь в відповідне поле і відправити на перездачу або вказати оцінку та натиснути "Опублікувати"</div><br>';
				?><br><form action="<?=LINK?>adm/tests.php?r=edited&id=<?=$id?>" enctype="multipart/form-data" method="post">
					<?php if($row['editor_name']!=_ID_ && $type!=2){
						if(strlen($row['coment'])>1 && $type!=2)
							echo '<div class="form-group">
									<label class="control-label col-sm-2" for="a2comment">Коментарь від вчителя до вашого тесту:</label>
									<div class="col-sm-9">
										<textarea id="a2comment" readonly class="form-control">'.$row['coment'].'</textarea>
									</div>
								</div>';
						if(preg_match('/^1[0-2]*$|^[1-9]$/',$row['points']))
							echo '<div class="form-group">
								<label class="control-label col-sm-2" for="a2points">Оцінка:</label>
									<div class="col-sm-9">
										<input class="form-control" id="a2points" readonly value="'.$row['points'].'">
									</div>
								</div>';
					}
					else if($type==2 && $row['creator_name']!=_ID_){
						echo '<div class="form-group">
							<label class="control-label col-sm-2" for="a2coment">Коментарь учню до тесту:</label>
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
						<label class="control-label col-sm-2" for="a2link">Посилання на тест:</label>
						<div class="col-sm-9">
							<div class="input-group">
								<span class="input-group-addon"><?=LINK.'p/t/'?></span>
								<input id="a2link" name="postLink" type="text" class="form-control" required value="<?=$row['link']?>" placeholder="Вкажіть посилання для цього тесту">
								<span class="input-group-addon">/</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a3name">Назва тесту:</label>
						<div class="col-sm-9">
							<input id="a3name" class="form-control" name="postName" required value="<?=$row['name']?>" placeholder="Назва тест">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4category">Категорія:</label>
						<div class="col-sm-9">
							<input id="a4category" class="form-control" name="postCategory" value="<?=$row['category']?>" placeholder="Категорія">
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
					?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4class">Клас:</label>
						<div class="col-sm-9">
							<select class="form-control" name="postClass" id="a4class" required>
								<option value="0" <?php if($row['class']==0) echo 'selected';?>>Всі класи</option>
								<option value="1" <?php if($row['class']==1) echo 'selected';?>>1</option>
								<option value="2" <?php if($row['class']==2) echo 'selected';?>>2</option>
								<option value="3" <?php if($row['class']==3) echo 'selected';?>>3</option>
								<option value="4" <?php if($row['class']==4) echo 'selected';?>>4</option>
								<option value="5" <?php if($row['class']==5) echo 'selected';?>>5</option>
								<option value="6" <?php if($row['class']==6) echo 'selected';?>>6</option>
								<option value="7" <?php if($row['class']==7) echo 'selected';?>>7</option>
								<option value="8" <?php if($row['class']==8) echo 'selected';?>>8</option>
								<option value="9" <?php if($row['class']==9) echo 'selected';?>>9</option>
								<option value="10" <?php if($row['class']==10) echo 'selected';?>>10</option>
								<option value="11" <?php if($row['class']==11) echo 'selected';?>>11</option>
								<option value="-1" <?php if($row['class']==-1) echo 'selected';?>>Випусники</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Запитання:</label>
						<div class="col-sm-9">
							<div class="addableContentContainer">
								<?php
									$i=1;
									foreach ($c->t as $test) {
										echo '<div class="addableContentDiv">
											<div class="input-group">
												<div class="input-group-addon">'.$i.'.</div>
												<input type="text" class="form-control" value="'.$test->q.'" name="postContent_'.$i.'" required placeholder="Запитання">
												<label class="input-group-addon">
													<button style="padding: 0px 6px;" onclick="$(this).closest(\'.addableContentDiv\').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
												</label>
											</div>
											<div class="questions">';
												$ii=1;
												foreach ($test->v as $var) {
													echo '<div class="input-group">
														<label class="input-group-addon">
															<input type="checkbox" class="l" name="test_'.$i.'_select_'.$ii.'" ';
																if($var->c==1) echo 'checked ';
															echo 'value="1">
														</label>
														<input type="text" class="r form-control" name="test_'.$i.'_question_'.$ii.'" placeholder="Відповідь" value="'.$var->d.'">
														<label class="input-group-addon">
															<button style="padding: 0px 6px;" onclick="$(this).closest(\'.input-group\').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
														</label>
													</div>';
													$ii++;
												}
											echo '</div>
											<button onclick="addEl($(this).closest(\'.addableContentDiv\'),'.$i.');" type="button" class="l btn btn-success btn-sm">Додати варіант</button>
											<br><hr><br>
										</div>';
										$i++;
									}
								?>
							</div>
							<div class="form-group">
								<button id="addQue" type="button" class="btn btn-success btn-sm">Додати запитання</button>
							</div>
							<script>
								function incrementLastContentId() {
									$('#lastContentId').val( function(i, oldval) {
											return ++oldval;
									});
								}
								$('#addQue').click( function() {
									incrementLastContentId();
									var buf=$('#lastContentId').val();
									$('.addableContentContainer').append(`<div class="addableContentDiv">
										<div class="input-group">
											<div class="input-group-addon">`+buf+`.</div>
											<input type="text" class="form-control" name="postContent_`+buf+`" required placeholder="Запитання">
											<label class="input-group-addon">
												<button style="padding: 0px 6px;" onclick="$(this).closest('.addableContentDiv').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
											</label>
										</div>
										<div class="questions">
											<div class="input-group">
												<label class="input-group-addon">
													<input type="checkbox" class="l" name="test_`+buf+`_select_1" value="1">
												</label>
												<input type="text" class="r form-control" name="test_`+buf+`_question_1" placeholder="Відповідь">
												<label class="input-group-addon">
													<button style="padding: 0px 6px;" onclick="$(this).closest('.input-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
												</label>
											</div>
										</div>
          <br>
          <button onclick="addEl($(this).closest('.addableContentDiv'),`+buf+`);" type="button" class="l btn btn-success btn-sm">Додати варіант</button>
          <br><hr><br>
         </div>`);
								});
								function addEl(closest,buf){
									var name=$(closest).find('.questions .input-group:last-child label:first-child input').attr('name');
									name=name.substring(name.lastIndexOf('_')+1);
									if(isNaN(name))
										name=1;
									else
										name++;
									$(closest).find('.questions').append('<div class="input-group"><label class="input-group-addon"><input type="checkbox" class="l" name="test_'+buf+'_select_'+name+'"></label><input type="text" class="r form-control" name="test_'+buf+'_question_'+name+'" placeholder="Відповідь"><label class="input-group-addon"><button style="padding: 0px 6px;" onclick="$(this).closest(\'.input-group\').remove();" type="button" class="r btn btn-danger btn-xs">X</button></label></div>');
								}
							</script>
						</div>
					</div>
					<div class="btn-group">
						<input type="hidden" id="lastContentId" name="lastContentId" value="1">
						<a style="color:#fff;" target="_blank" href="<?=LINK.'p/t/'.$row['link']?>/" class="btn btn-success">Переглянути тест</a>
						<a style="color:#fff;" href="<?=LINK?>adm/tests.php?r=deleted&id=<?=$id?>" class="btn btn-danger">Видалити тест</a>
						<a style="color:#fff;" href="<?=LINK?>adm/tests.php" class="btn btn-danger">Скасувати зміни</a><?php
						if($type==2 && $row['creator_name']!=$id)
							echo '<button type="submit" name="notApr" class="btn btn-warning">Відправити на перездачу</button><button type="submit" class="btn btn-primary">Опублікувати</button>';
						else
							echo '<button type="submit" class="btn btn-primary">Зберегти зміни</button>'; ?>
					</div>
				</form>
				<?php
			}
		}
		else {
			echo '<div style="padding:10px;overflow:hidden">';#Статистика
				que('SELECT id FROM '._USERS_);
				$u=mysql_num_rows($res);
				que('SELECT id FROM '._POSTS_.' WHERE type="1" OR type="2"');
				$u1=mysql_num_rows($res);
				que('SELECT id FROM '._POSTS_.' WHERE (type="1" OR type="2") AND creator_name="'.$id.'"');
				$u2=mysql_num_rows($res);
				echo '<div class="alert">На сайті зареєстровано '.$u.' користувачів<br>Загальна кількість тестів: '.$u1.'<br>Кількість тестів, які ви створили: '.$u2.'<br>Натисніть на рядок, щоб редагувати тест<br>Натисніть на клавішу "Додати тест" щоб додати новий тест</div>';
				if($_GET['r']=='deleted' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
					que('SELECT link FROM '._POSTS_.' WHERE id="'.$_GET['id'].'"');
					$row=mysql_fetch_array($res);
					array_map('unlink', glob('../p/t/'.$row['link'].'/*.*'));
					rmdir('../p/t/'.$row['link'].'/');
					que('DELETE FROM '._POSTS_.' WHERE link="'.$row['link'].'"');
					echo '<div class="alert alert-success">Тест успішно видалено</div>';
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
							echo '<div class="alert alert-warning">Вказаний адрес тесту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагування тесту</div>';
						}
						$lastContentId=$_POST['lastContentId'];
						$path=$_POST['postLink'];
						mkdir('../p/t/'.$path.'/');
						copy('../p/t/NO_DELETE/index.php','../p/t/'.$path.'/index.php');
						$cId=1;
						$content='\\\\|/<test>\\\\|/<g>'.$_POST['postClass'].'\\\\|/</g>';
						for($i=1;$i<=$lastContentId;$i++){
							if(isset($_POST['postContent_'.$i]) && isset($_POST['test_'.$i.'_question_1'])){
								$content.='\\\\|/<t>\\\\|/<q>'.$_POST['postContent_'.$i].'\\\\|/</q>';
								$cId++;
								for($ii=1;$ii<30;$ii++)
									if(isset($_POST['test_'.$i.'_question_'.$ii]))
										$content.='\\\\|/<v>\\\\|/<c>'.((empty($_POST['test_'.$i.'_select_'.$ii]))?0:1).'\\\\|/</c>\\\\|/<d>'.$_POST['test_'.$i.'_question_'.$ii].'\\\\|/</d>\\\\|/</v>';
								$content.='\\\\|/</t>';
							}
						}
						$content.='\\\\|/</test>';
						que('SELECT id FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
						$row=mysql_fetch_array($res);
						$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
						$dt->setTimestamp(time());
						$a = array('/</','/>/','/"/',"/'/");
						$b = array('&#60;','&#62;','&#34;','&#32;');
						$checked=/*($type==2)?1:0*/1;
						$que='INSERT INTO '._POSTS_.' (link,name,content,date,creator_name,checked,unixTime,type,class';
						if(isset($_POST['postCategory']))
							$que.=',category';
						$que.=') values("'.$path.'","'.$_POST['postName'].'","'.preg_replace($a,$b,nl2br($content,false)).'","'.$dt->format('d.m.Y в H:i').'","'.$row['id'].'","'.$checked.'"';
						$que.=',"'.time().'","2","'.$_POST['postClass'].'"';
						if(isset($_POST['postCategory']))
							$que.=',"'.$_POST['postCategory'].'"';
						$que.=');';
						que($que);
						echo '<div class="alert alert-success">Тест успішно додано</div>';
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
						echo '<div class="alert alert-warning">Вказаний адрес тесту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагування тесту</div>';
					}
					$lastContentId=$_POST['lastContentId'];
					echo var_dump($lastContentId);
					$path=$_POST['postLink'];
					mkdir('../p/t/'.$path.'/');
					copy('../p/t/NO_DELETE/index.php','../p/t/'.$path.'/index.php');
					$cId=1;
					$content='\\\\|/<test>\\\\|/<g>'.$_POST['postClass'].'\\\\|/</g>';
					for($i=1;$i<=$lastContentId+5;$i++){
						echo var_dump($i);
						if(isset($_POST['postContent_'.$i]) && isset($_POST['test_'.$i.'_question_1'])){
							$content.='\\\\|/<t>\\\\|/<q>'.$_POST['postContent_'.$i].'\\\\|/</q>';
							$cId++;
							for($ii=1;$ii<30;$ii++)
								if(isset($_POST['test_'.$i.'_question_'.$ii]))
									$content.='\\\\|/<v>\\\\|/<c>'.((empty($_POST['test_'.$i.'_select_'.$ii]))?0:1).'\\\\|/</c>\\\\|/<d>'.$_POST['test_'.$i.'_question_'.$ii].'\\\\|/</d>\\\\|/</v>';
							$content.='\\\\|/</t>';
						}
					}
					$content.='\\\\|/</test>';
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
					if($checked == 1)
						$checked == 0;
					que('SELECT link FROM '._POSTS_.' WHERE id="'.$_GET['id'].'"');
					$row=mysql_fetch_array($res);
					rename('../p/t/'.$row['link'],'../p/t/'.$_POST['postLink']);
					que('SELECT id FROM '._USERS_.' WHERE hesh="'.$_COOKIE['hesh'].'"');
					$row=mysql_fetch_array($res);
					que('UPDATE '._POSTS_.' SET editor_name="'.$row['id'].'" WHERE id="'.$_GET['id'].'"');
					$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
					$dt->setTimestamp(time());
					$a = array('/</','/>/','/"/',"/'/");
					$b = array('&#60;','&#62;','&#34;','&#32;');
					if($type!=2)
						$_POST['postcoment']==0;
					$que='UPDATE '._POSTS_.' SET link="'.$path.'", name="'.$_POST['postName'].'", content="'.preg_replace($a,$b,nl2br($content,false)).'", edit_date="'.$dt->format('d.m.Y в H:i').'", editor_name="'.$g_id.'", coment="'.$_POST['postcoment'].'", checked="'.$checked.'", class="'.$_POST['postClass'].'"';
					if($mark!=0)
						$que.=', points="'.$mark.'"';
					if(isset($_POST['postCategory']))
						$que.=', category="'.$_POST['postCategory'].'", type="2"';
					que($que.' WHERE id="'.$_GET['id'].'"');
					echo '<div class="alert alert-success">Тест успішно змінено</div>';
				}
				que('SELECT * FROM '._POSTS_.' WHERE checked!=2 AND type=2');
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
								echo ' style="cursor: pointer" onclick="window.document.location=\''.LINK.'adm/tests.php?a=editTest&id='.$row['id'].'\'"';
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
				<a href="'.LINK.'adm/tests.php?a=addTest" style="color:#fff" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Додати тест</a>';
				if($type==2)
					echo ' <a href="slider.php" class="btn btn-success" style="color:#fff">Редагувати слайдер</a>';
			echo '</div>';
		}
		down();?>
		<script>function redir(where) {window.location.href = where;}</script>
	</body>
<html>