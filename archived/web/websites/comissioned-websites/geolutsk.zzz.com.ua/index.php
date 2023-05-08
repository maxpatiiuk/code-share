<!-- index.php -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once dirname(__FILE__) . '/functions/main.php';
			head(1);
		?>
	</head>
	<body>
		<?php top();
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
					echo '<div class="btn-group">
						<a href="'.LINK.'adm/materials.php" class="btn btn-success" style="color:#fff">';
						if($type==2){
							que('SELECT id FROM '._POSTS_.' WHERE type="1" AND checked="0"');
							$u=mysql_num_rows($res);
							echo 'Матеріали';
							if($u>0)
								echo ' <span class="badge">'.$u.'</span>';
						}
						else
							echo 'Редагувати мої матеріали';
						echo '</a>
						<a href="'.LINK.'adm/materials.php?a=addPost" class="btn btn-success" style="color:#fff">Додати матеріал</a>
						<a href="'.LINK.'adm/tests.php" class="btn btn-success" style="color:#fff">Тести';
						if($type==2){
							que('SELECT id FROM '._POSTS_.' WHERE type="2" AND checked="0"');
							$u=mysql_num_rows($res);
							if($u>0)
								echo ' <span class="badge">'.$u.'</span>';
						}
						echo '</a>
						<a href="'.LINK.'adm/stats.php" class="btn btn-success" style="color:#fff">Налаштуваня</a>';
						if($type==2)
							echo '</a><a href="'.LINK.'adm/slider.php" class="btn btn-success" style="color:#fff">Слайдер</a>';
						if(_ID_!=-1){
							que('SELECT class FROM '._USERS_.' WHERE id="'._ID_.'"');
							$row=mysql_fetch_array($res);
							$i=6; ?>
							<form method="get" style="display: inline">
								<select id="class" style="padding:7px 13px; margin-left:10px;">
									<option value="0" <?php
										if($row['class']==0 || !isset($row['class']) || !is_numeric($row['class']) || $row['class']>12 || $row['class']<=0 || !isset($_GET['class']) || !is_numeric($_GET['class']) || $_GET['class']<=0 || $_GET['class']>=12){
											echo 'selected';
											$buf=34;
											} ?>
											>Всі класи</option> <?php
									while($i<12){
										echo '<option value="'.$i.'"';
										if($_GET['class']==$i || ($row['class']==$i && $buf!=34)){
											echo ' selected';
											$buf=34;
										}
										echo '>'.$i.' клас</option>';
										$i++;
									}
									?>
								</select>
								<select id="category" style="padding:7px 13px; margin-left:10px;">
									<option value="0" <?php if($_GET['category']==0 && !is_numeric($_GET['category'])) echo 'selected'; ?>>Всі категорії</option> <?php
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
				if(is_numeric($_GET['category']) && $_GET['category']>0 && $_GET['category']<=10000){
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
					else
						$url='p';
					if(is_numeric($_GET['class']) && $_GET['class']>0 && $_GET['class']<=12){
						que('SELECT class FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"',2);
						$raw=mysql_fetch_array($ras);
						if($raw['class']!=$_GET['class'])
							continue;
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
			<div class="col-xs-12 col-md-3">
				<div class="visible-xs visible-sm"><br><br></div>
				<h2 style="color: #27c;padding-top: 30px">Контакти</h2>
				<hr>
				<?php if(_TEL1_!=NULL || _TEL2_!=NULL) echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">Телефон:</h3>';
				if(_TEL1_!=NULL) echo '<p>'._TEL1_.'</p>';
				if(_TEL2_!=NULL) echo '<p>'._TEL2_.'</p>';
				echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">E-mail:</h3><p>'._EMAIL_.'</p><a color: #27c; href="mailto:'._EMAIL_.'">Написати повідомлення</a>';
				if(_ADDRESS_!=NULL) echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">Адреса:</h3><p>'._ADDRESS_.'</p>';
				socialML();
			?></div>
		<?php down();?>
	</body>
<html>