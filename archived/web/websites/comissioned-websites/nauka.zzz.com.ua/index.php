<!-- index.php -->
<!DOCTYPE html>
<html lang="uk">
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
			<div id="myCarousel_2" class="carousel slide" style="height:40vw;overflow:hidden" data-ride="carousel">
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
				if(isset($type)){
					echo '<div class="btn-group">
						<a href="'.LINK.'adm/" class="btn btn-success" style="color:#fff">';
						if($type==2){
							que('SELECT id FROM '._POSTS_.' WHERE checked="0"');
							$u=mysql_num_rows($res);
							if($u>0)
								echo 'Перевірити пости <span class="badge">'.$u.'</span>';
							else
								echo 'Редагувати пости';
						}
						else
							echo 'Редагувати мої пости';
						echo '</a><a href="'.LINK.'adm/?a=addPost" class="btn btn-success" style="color:#fff">Додати пост</a>';
						if($type==2)
							echo '<a href="'.LINK.'adm/slider.php" class="btn btn-success" style="color:#fff">Редагувати слайдер</a>';
						echo '</div>';
				}
				que('SELECT * FROM '._POSTS_.' WHERE checked="1" ORDER BY unixTime+0 DESC');
				while($row=mysql_fetch_array($res)){
					$a = array('/\\\\\\|\\//','/&#60;/','/&#62;/','/&#34;/','/&#32;/','/<\?=LINK\?>/','/<br>/','/\\\\n/','/'.PHP_EOL.'/');
					$b = array('','<','>','"',"'",LINK,' ',' ',' ');
					$content=substr(strip_tags(preg_replace($a,$b,$row['content'])),0,512);
					$ras=mysql_query('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$row['creator_name'].'"');
					$raw=mysql_fetch_array($ras);
					if(strlen($raw['u_name'])>1 && strlen($raw['u_surname'])>1)
						$creator_name=$raw['u_name'].' '.$raw['u_surname'];
					else
						$creator_name=str_rot13($raw['login']);
					echo '<div class="posts">
						<a href="'.LINK.'p/'.$row['link'].'/">
							<img alt="'.$row['name'].'" class="l" src="';
							for($src=NULL,$i=0;$i<100;$i++){
								if (@getimagesize(LINK.'p/'.$row['link'].'/img_'.$i.'.jpg')){
									$src='jpg';
									break;
								}
								else if (@getimagesize(LINK.'p/'.$row['link'].'/img_'.$i.'.png')){
									$src='png';
									break;
								}
								else if (@getimagesize(LINK.'p/'.$row['link'].'/img_'.$i.'.tiff')){
									$src='tiff';
									break;
								}
								else if (@getimagesize(LINK.'p/'.$row['link'].'/img_'.$i.'.gif')){
									$src='gif';
									break;
								}
							}
							if(isset($src))
								echo LINK.'p/'.$row['link'].'/img_'.$i.'.'.$src;
							else
								echo 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
							echo '">
							<h2 class="hidden-xs hidden-sm">'.$row['name'].'</h2>
							<h4 class="visible-xs visible-sm">'.$row['name'].'</h4>
						</a>
						<div>
							<img alt="Creation date: " class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
							<p>'.$row['date'].', '.$creator_name.', Категорія: '.$row['category'].'</p>
						</div>
						<p style="overflow:hidden">'.$content;
						if(strlen($row['content'])>512)
							echo '...';
						echo '</p>
					</div>';
				} ?>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="visible-xs visible-sm"><br><br></div>
				<h3 style="padding:0 10px;">Таблиця успішності</h3>
				<hr>
				<?php que('SELECT creator_name,points FROM '._POSTS_.' WHERE points IS NOT NULL AND checked=1');
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
						$que='SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$name.'" AND type<>2 AND vis';
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
						echo '<div class="row">
							<h4 class="l">
								'.$i.'. '.$creator_name.'
							</h4>
							<h4 class="r" style="padding-right: 30px;">
								'.$val.'
							</h4>
						</div>';
					}
				}
				else
					echo '<h4>Недостатньо інформації</h4>';
				?>
			</div>
		</div>
		<?php down();?>
	</body>
</html>