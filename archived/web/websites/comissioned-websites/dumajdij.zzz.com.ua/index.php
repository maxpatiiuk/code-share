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
		if(isset($about)){ ?><div style="height: auto;padding: 5%;margin: 0 auto;overflow: hidden;word-wrap: break-word;color: #555;">
			<div class="hidden-xs col-sm-6 tb l text-right">
				<h2 style="color: #27c;">Про нас</h2>
				<h1 style="color: #fe5;">Комунікативний клуб "3D" для підлітків та їх батьків</h1>
			</div>
			<div class="visible-xs col-xs-12 tb l">
				<h2 style="color: #27c;">Про нас</h2>
				<h1 style="color: #fe5;">Комунікативний клуб "3D" для підлітків та їх батьків</h1>
			</div>
			<div class="col-xs-12 col-sm-6 tb r"><?=$about?></div>
		</div><?php }
		echo '<div class="row">
			<div class="col-xs-12 col-md-9">';
				if($type==2){
					echo '<div class="btn-group">
						<a href="'.LINK.'adm/" class="btn btn-success" style="color:#fff">Редагувати пости</a>
						<a href="'.LINK.'adm/?a=addPost" class="btn btn-success" style="color:#fff">Додати пост</a>
						<a href="'.LINK.'adm/slider.php" class="btn btn-success" style="color:#fff">Редагувати слайдер</a>
						<a href="'.LINK.'adm/stats.php" class="btn btn-success" style="color:#fff">Статистика сайту</a>
					</div>';
				}
				que('SELECT * FROM '._POSTS_.' WHERE add2mainp="1" ORDER BY unixTime+0 DESC');
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
							<img class="l" src="';
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
								echo 'https://s8.hostingkartinok.com/uploads/images/2018/01/4bc130e60b8422eb9f7f287f4dce46a7.png';
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
				} ?>
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