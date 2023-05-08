<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php
			require_once dirname(__FILE__).'/functions/main.php';
			head(1);
		?>
	</head>
	<body>
		<?php top();
		if($_GET['a']=='d3' && isset($_POST['content']) && isset($_POST['date'])){
			que('SELECT content FROM '._POSTS_.' WHERE name="d3"');
			$row=mysql_fetch_array($res);
			$buf=explode('^>',$row['content']);
			$buf3=NULL;
			for($i=0;$buf[$i]!=NULL;$i++){
				$buf2=explode('>^',$buf[$i]);
				if($buf2[0]==$_POST['date'])
					$buf4=true;
				if(strtotime($buf2[0])>time())
					$buf3.=$buf[$i].'^>';
				if($buf2[0]==$_POST['date'] && $buf2[1]==_ID_ && $buf2[2]==$_POST['content']){
					$exit=1;
					break;
				}
			}
			if($exit!=1){
				if(preg_match('/\d{4}\-\d\d\-\d\d/',$_POST['date'])){
					if(_ID_!=-1){
						if(strtotime($_POST['date'])>time()){
							echo '<div class="alert alert-success">Домашнє успішно додано';
							if($buf4!==true){
								echo '. Вам нараховано +1 бал, за те, що ви перші завантажили домашнє завдання на цей день!';
								que('UPDATE '._USERS_.' SET points=points+1 WHERE id="'._ID_.'"');
							}
							echo '</div>';
							que('UPDATE '._POSTS_.' SET content="'.$buf3.$_POST['date'].'>^'._ID_.'>^'.$_POST['content'].'" WHERE link="d3"');
						}
						else
							echo '<div class="alert alert-danger">Не можна задати домашнє на той самий день</div>';
					}
					else
						echo '<div class="alert alert-danger">Ввійдіть в акаунт</div>';
				}
				else
					echo '<div class="alert alert-danger">Неправильно вказана дата</div>';
			}
		}
		que('SELECT * FROM '._SLIDER_);
		$u=mysql_num_rows($res);
		if($u>0){
			$psrc=LINK.'images/slider/img_';?>
			<div id="myCarousel_2" class="carousel slide" style="height:30vw;overflow:hidden" data-ride="carousel">
				<ol class="carousel-indicators"><?php
					for($i=0;$i<$u;$i++){
						echo '<li data-target="#myCarousel_2" data-slide-to="'.$i.'"';
						if($i==0)
							echo ' class="active"';
						echo '></li>';
					}?>
				</ol>
				<div class="carousel-inner"><?php
					$i=0;
			 	while($row=mysql_fetch_array($res)){
						if (@getimagesize($psrc.$row['id'].'.jpg'))
							$sliderSrc='jpg';
						else if (@getimagesize($psrc.$row['id'].'.png'))
							$sliderSrc='png';
						else if (@getimagesize($psrc.$row['id'].'.tiff'))
							$sliderSrc='tiff';
						else if (@getimagesize($psrc.$row['id'].'.gif'))
							$sliderSrc='gif';
			 		echo '<div class="item';
			 		if($i==0)
			 			echo ' active';
			 		echo '"><img src="'.LINK.'images/slider/img_'.$row['id'].'.'.$sliderSrc.'"';
			 		if(strlen($row['text'])>0)
			 			echo ' alt="'.$row['text'].'"><div class="carousel-caption hidden-xs"><h3>'.$row['text'].'</h3></div></div>';
			 		else echo '></div>';
			 		$i++;
			 	}?>
			 </div>
				<a class="left carousel-control" href="#myCarousel_2" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel_2" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				</a>
			</div><?php
		}
		echo '<div class="row">
			<div class="col-xs-12 col-md-9">';
				if((isset($type) && $type!=3) || _ID_!=-1){
					echo '<div class="btn-group">';
						if((isset($type) && $type!=3)){
							echo '<a href="'.LINK.'adm/" class="btn btn-success" style="color:#fff">Пости';
							if($type==2){
								que('SELECT id FROM '._POSTS_.' WHERE type="0" AND checked="0"');
								$u=mysql_num_rows($res);
								if($u>0)
									echo ' <span class="badge">'.$u.'</span>';
							}
							echo '</a><a href="'.LINK.'adm/?a=addPost" class="btn btn-success" style="color:#fff">Додати пост</a>
							<a href="'.LINK.'adm/d3.php" class="btn btn-success" style="color:#fff">Додати ДЗ</a>
							<a href="'.LINK.'adm/materials.php" class="btn btn-success" style="color:#fff">Матеріали';
							if($type==2){
								que('SELECT id FROM '._POSTS_.' WHERE type="1" AND checked="0"');
								$u=mysql_num_rows($res);
								if($u>0)
									echo ' <span class="badge">'.$u.'</span>';
							}
							echo '</a>
							<a href="'.LINK.'adm/tests.php" class="btn btn-success" style="color:#fff">Тести';
							if($type==2){
								que('SELECT id FROM '._POSTS_.' WHERE type="2" AND checked="0"');
								$u=mysql_num_rows($res);
								if($u>0)
									echo ' <span class="badge">'.$u.'</span>';
							}
							echo '</a> ';
							if($type==2)
								echo '</a><a href="'.LINK.'adm/slider.php" class="btn btn-success" style="color:#fff">Слайдер</a>';
						}
						if(_ID_!=-1){
							que('SELECT class FROM '._USERS_.' WHERE id="'._ID_.'"');
							$row=mysql_fetch_array($res);
							$i=5; ?>
							<form method="get" style="display: inline;">
								<select id="type" style="padding:7px 13px; margin-left:10px;">
									<option value="-1" <?php if($_GET['type']==-1 || !is_numeric($_GET['type']) || !isset($_GET['type']) || $_GET['type']==NULL) echo 'selected'; ?>>Todo el contenido</option>
									<option value="0" <?php if($_GET['type']!=NULL && $_GET['type']==0) echo 'selected'; ?>>Artículos</option>
									<option value="1" <?php if($_GET['type']==1) echo 'selected'; ?>>Materiales</option>
									<option value="2" <?php if($_GET['type']==2) echo 'selected'; ?>>Pruebas</option>
								</select>
								<select id="class" style="padding:7px 13px; margin-left:10px;">
									<option value="0" <?php
										if($row['class']==0 || !isset($row['class']) || !is_numeric($row['class']) || $row['class']>12 || $row['class']<=0 || !isset($_GET['class']) || !is_numeric($_GET['class']) || $_GET['class']<=0 || $_GET['class']>=12){
											echo 'selected';
											$buf=34;
											} ?>
											>Todos grados</option> <?php
									while($i<12){
										echo '<option value="'.$i.'"';
										if($_GET['class']==$i || ($row['class']==$i && $buf!=34)){
											echo ' selected';
											$buf=34;
										}
										echo '>'.$i.' grado</option>';
										$i++;
									}
									?>
								</select>
								<select id="category" style="padding:7px 13px; margin-left:10px;">
									<option value="0" <?php if($_GET['category']==0 && !is_numeric($_GET['category'])) echo 'selected'; ?>>Todas las categorias</option> <?php
									que('SELECT id,category FROM '._POSTS_);
									$arr=NULL;
									while($row = mysql_fetch_array($res))
										$arr[$row['id']] = $row['category'];
									$result=array_unique($arr);
									if(is_numeric($_GET['category']) && $_GET['category']>0 && $_GET['category']<=100000){
										que('SELECT category FROM '._POSTS_.' WHERE id="'.$_GET['category'].'"');
										$row=mysql_fetch_array($res);
										$buf=$row['category'];
									}
									else
										$buf=NULL;
									foreach ($result as $key => $val){
										if(strlen($val)>0){
											echo '<option value="'.$key.'"';
											if($buf==$val)
												echo 'selected';
											echo '>'.$val.'</option>';
										}
									}
									$arr=NULL;
									?>
								</select>
								<input type="hidden" name="page" value="<?=$_GET['page']?>">
							</form>
							<script>
								classVal=$('#class').val();
								categoryVal=$('#category').val();
								typeVal=$('#type').val();
								pageVal=$('input[name="page"]').val()+"";
								if(pageVal<1 || pageVal>1000){
									pageVal=1;
									$('input[name="page]').val(1);
								}
								$('#class').change(function(){
									buf=$('#class').val();
									buf2=window.location.href.split('?')[0]+'?class='+buf;
									if(buf!=classVal){
										if(categoryVal!=0)
											buf2+="&category="+categoryVal;
										if(typeVal!=-1)
											buf2+="&type="+typeVal;
										if(pageVal!=1)
											buf2+="&page="+pageVal;
										window.location.href = buf2;
									}
								});
								$('#category').change(function(){
									buf=$('#category').val();
									buf2=window.location.href.split('?')[0]+'?category='+buf;
									if(buf!=categoryVal){
										if(classVal!=0)
											buf2+="&class="+classVal;
										if(typeVal!=-1)
											buf2+="&type="+typeVal;
										if(pageVal!=1)
											buf2+="&page="+pageVal;
										window.location.href = buf2;
									}
								});
								$('#type').change(function(){
									buf=$('#type').val();
									buf2=window.location.href.split('?')[0]+'?type='+buf;
									if(buf!=typeVal){
										if(categoryVal!=0)
											buf2+="&category="+categoryVal;
										if(classVal!=0)
											buf2+="&class="+classVal;
										if(pageVal!=1)
											buf2+="&page="+pageVal;
										window.location.href = buf2;
									}
								});
							</script>
							<?php
						}
					echo '</div>';
				}
				$que.='SELECT * FROM '._POSTS_.' WHERE checked="1"';
				if(!isset($_GET['page']) || !preg_match('/^[0-9]*$/',$_GET['page']))
					$p=1;
				else
					$p=$_GET['page'];
				$link='http://' . $_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'], 2)[0].'?';
				if(is_numeric($_GET['category']) && $_GET['category']>0 && $_GET['category']<=100000){
					que('SELECT category FROM '._POSTS_.' WHERE id="'.$_GET['category'].'"');
					$row=mysql_fetch_array($res);
					if(mysql_num_rows($res)>0)
						$que.=' AND category="'.$row['category'].'"';
					$link.='category='.$_GET['category'].'&';
				}
				if(is_numeric($_GET['type']) && $_GET['type']>=0 && $_GET['type']<=2){
					$que.=' AND type="'.$_GET['type'].'"';
					$link.='type='.$_GET['type'].'&';
				}
				if(is_numeric($_GET['class']) && $_GET['class']>=5 && $_GET['class']<=11)
					$link.='class='.$_GET['class'].'&';
				que($que.' ORDER BY unixTime+0 DESC');
				$u=mysql_num_rows($res);
				if($u<10)
					$p=1;
				$a = array('/\\\\\\|\\//','/&#60;/','/&#62;/','/&#34;/','/&#32;/','/<\?=LINK\?>/','/<br>/','/\\\\n/','/'.PHP_EOL.'/');
				$b = array('','<','>','"',"'",LINK,' ',' ',' ');
				for($ii=1;$row=mysql_fetch_array($res);$ii++){
					if($ii<=($p-1)*10 || $ii>$p*10)
						continue;
					$src=NULL;
					if($row['type']==1)
						$url='p/m';
					else if($row['type']==2)
						$url='p/t';
					else
						$url='p';
					if(is_numeric($_GET['class']) && $_GET['class']>0 && $_GET['class']<=12){
						if($row['type']!=2){
							que('SELECT class FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"',2);
							$raw=mysql_fetch_array($ras);
							if($raw['class']!=$_GET['class']){
								$u--;
								continue;
							}
						}
						else {
							$c=preg_replace('/\\\\\|\/</','<',htmlspecialchars_decode(preg_replace('/<br>/','',$row['content'])));
							$test = new DOMDocument('1.0');
							$test->preserveWhiteSpace = FALSE;
							$test->loadXML($c);
							$test->formatOutput = TRUE;
							$c=simplexml_import_dom($test);
							if($c->g!=$_GET['class']){
								$u--;
								continue;
							}
						}
					}
					$content=substr(strip_tags(preg_replace($a,$b,$row['content'])),0,512);
					$ras=mysql_query('SELECT login,u_name,u_surname,class FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"');
					$raw=mysql_fetch_array($ras);
					$creatorClass=$raw['class'];
					if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
						$creator_name=$raw['u_name'].' '.$raw['u_surname'];
					else
						$creator_name=str_rot13($raw['login']);
					echo '<div class="posts a'.$creatorClass.'" category="'.$row['category'].'">
						<a href="'.LINK.$url.'/'.$row['link'].'/">
							<img class="l" src="';
							for($src=NULL,$i=0;$i<100;$i++){
								if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.jpg')){
									$src='jpg';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.jpeg')){
									$src='jpeg';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.jfjf')){
									$src='jfjf';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.bmp')){
									$src='bmp';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.png')){
									$src='png';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.tiff')){
									$src='tiff';
									break;
								}
								else if (@getimagesize(LINK.$url.'/'.$row['link'].'/img_'.$i.'.gif')){
									$src='gif';
									break;
								}
							}
							if(isset($src))
								echo LINK.$url.'/'.$row['link'].'/img_'.$i.'.'.$src;
							else
								echo 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
							echo '">
							<h2 class="hidden-xs hidden-sm">'.$row['name'].'</h2>
							<h4 class="visible-xs visible-sm">'.$row['name'].'</h4>
						</a>
						<div>
							<img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
							<p>'.$row['date'].', '.$creator_name;
							if(strlen($row['category'])>1)
								echo ', Категорія: '.$row['category'];
							echo '</p>
						</div>
						<p style="overflow:hidden">'.$content;
						if(strlen($row['content'])>512)
							echo '...';
						echo '</p>
					</div>';
				}
				if($u>10){
					echo '<div class="text-center">
						<ul class="pagination pagination-lg">';
							for($i=1;$i<1+$u/10;$i++){
								echo '<li';
								if($i==$p)
									echo ' class="active"><a href="#';
								else
									echo '><a href="'.$link.'page='.$i;
								echo '">'.$i.'</a></li>';
						}
						echo '</ul>
					</div>';
				}
				?>
			</div>
			<div class="col-xs-12 col-md-3 sidebar">
				<div class="visible-xs visible-sm"><br><br></div>
				<!--<div>
					<h3 style="padding:0 10px;">Таблиця успішності</h3>
					<hr>
					<?php /*que('SELECT creator_name,points FROM '._POSTS_.' WHERE points IS NOT NULL AND checked=1');
					if(mysql_num_rows($res)>0){
						while($row=mysql_fetch_array($res)){
							$w=NULL;
							foreach($arr as $name => $val){
								if($row['creator_name']==$name){
									$arr[$name]+=$row['points'];
									$w=1;
									break;
								}
							}
							if($w==NULL)
								$arr[$row['creator_name']]=$row['points'];
						}
						arsort($arr);
						$i=0;
						foreach($arr as $name => $val){
							$i++;
							$que='SELECT login,u_name,u_surname,points FROM '._USERS_.' WHERE id="'.$name.'" AND type<>2 AND vis';
							if(isset($_COOKIE['hesh']))
								$que.='<>2';
							else
								$que.='=0';
							que($que);
							$row=mysql_fetch_array($res);
							if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
								$creator_name=$row['u_name'].' '.$row['u_surname'];
							else
								$creator_name=str_rot13($row['login']);
							echo '<div style="display:flow-root">
								<p class="l">'.$i.'. '.$creator_name.'</p>
								<p class="r">'.($val+$row['points']).'</p>
							</div>';
						}
					}
					else
						echo '<h4>Недостатньо інформації</h4>';
					*/?>
				</div>-->
				<br><br>
				<div>
					<h3 style="padding:0 10px;">Домашнє завдання</h3>
					<hr><?php
					que('SELECT content FROM '._POSTS_.' WHERE name="d3"');
					$row=mysql_fetch_array($res);
					$buf=explode('^>',$row['content']);
					for($i=0;$buf[$i]!=NULL;$i++){
						$buf2=explode('>^',$buf[$i]);
						que('SELECT u_name,u_surname,login FROM '._USERS_.' WHERE id="'.$buf2[1].'"');
						$row=mysql_fetch_array($res);
						if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
							$creator_name=$row['u_name'].' '.$row['u_surname'];
						else
							$creator_name=str_rot13($row['login']);
						echo '<div style="display:flow-root">
							<p>'.$buf2[2].'</p>
							<p class="l">'.date('d.m.Y', strtotime($buf2[0])).'</p>
							<p class="r" style="color:#999;">'.$creator_name.'</p>
						</div>';
					}
					?></div>
			</div>
		</div>
		<?php down();?>
	</body>
<html>