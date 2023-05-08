<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once 'main.php';
			if($_SERVER['REMOTE_ADDR']!="--ip--was--here--" && $_SERVER['REMOTE_ADDR']!="--ip--was--here--" && $_SERVER['REMOTE_ADDR']!="--ip--was--here--")
				que('UPDATE '._PRODUCTS_.' SET views=views+1 WHERE link = "'.$dir.'";');
			que('SELECT * FROM '._PRODUCTS_.' WHERE link = "'.$dir.'";');
			$row = mysql_fetch_array($res);
			head($row['name'],$row['name'].', '.$row['keywords'],$row['name'].', '.strip_tags($row['o1']));
			que('SELECT * FROM '._PRODUCTS_.' WHERE link = "'.$dir.'";');
			$row = mysql_fetch_array($res);
			$postID=$row['id'];
			if(isset($_GET['b'])){
				if(_ID_!=-1){
					que('SELECT email FROM '._USERS_.' WHERE id="'._ID_.'"');
					$raw=mysql_fetch_array($res);
					$bufEmail='&email='.$raw['email'];
				}
				if($_GET['b']!=-1){
					logg(LINK.'p/'.$dir,5,'Bought '.$row['name']);
					que('UPDATE '._PRODUCTS_.' SET buys=buys+1 WHERE link = "'.$dir.'";');
				}
				$link='https://www.oplata.info/asp2/pay_wm.asp?id_d='.$row['b_link'].'&id_po=0&ai=600788&curr=WMU'.$bufEmail.'&lang=ru-RU&failpage='.urlencode(LINK.$dir);
				header('Location: '.$link);
				echo '<meta http-equiv="refresh" content="0; link='.$link.'">';
			}
			$linkClean=LINK.'p/'.$row['link'];
			$linkRedir=$linkClean.'?b=1';
			$link=htmlentities($linkClean);
			$i1=getAva(1,$linkClean.'/img1.','https://s8.hostingkartinok.com/uploads/images/2018/01/da87051aceec85e7fb7f4157c55e98ef.png');
			$i2=getAva(1,$linkClean.'/img2.','https://s8.hostingkartinok.com/uploads/images/2018/01/da87051aceec85e7fb7f4157c55e98ef.png');
			$i3=getAva(1,$linkClean.'/img3.','https://s8.hostingkartinok.com/uploads/images/2018/01/da87051aceec85e7fb7f4157c55e98ef.png');
		?>
		<link rel="stylesheet" type="text/css" href="../../css/product.css">
	</head>
	<body>
		<?php top(1); ?>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-7">
						<div class="row">
							<div class="yt-container">
								<iframe class="col-xs-12 yt-content" src="https://www.youtube.com/embed/<?=$row['yt']?>" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
						<div class="images-container row">
							<img class="l col-xs-4" src="<?=$i1?>" alt="Product img">
							<img class="l col-xs-4" src="<?=$i2?>" alt="Product img">
							<img class="l col-xs-4" src="<?=$i3?>" alt="Product img">
						</div>
					</div>
					<div class="col-xs-12 col-sm-5">
						<div class="row">
							<h1 class="col-xs-12"><?=$row['name']?></h1>
						</div>
						<div class="row">
							<div class="col-xs-12 buy-container">
								<a href="<?=$linkRedir?>" class="col-xs-8 l text-center">Купити</a>
								<div class="col-xs-4 l text-center"><?=$row['price']?>грн</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<p class="l special">Поділитися:</p>
								<div class="r socialMedia">
									<a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=<?=$link?>"><img src="../../images/f.png" alt="Facebook"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?<?=$link?>"><img src="../../images/t.png" alt="Twitter"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://plus.google.com/share?url=<?=$link?>"><img src="../../images/g.png" alt="Google+"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://vk.com/share.php?url=<?=$link?>"><img src="../../images/v.png" alt="Vk"></a>
								</div>
							</div>
						</div>
						<div class="row">
							<p class="col-xs-12 special" style="line-height: 24px;"><?php
								$pr=explode(":",$row['parameters']);
								$pl=array(
									array("Windows Xp","wXP"),
									array("Windows 7","w7"),
									array("Windows 8","w8"),
									array("Windows 10","w10"),
									array("32 Bit","32b"),
									array("64 Bit","64b"),
									array("Linux","lin"),
									array("Mac Os","macX")
								);
								$gk=array(
								 array("Steam","s"),
								 array("Mojang","m"),
								 array("Social Club","rg"),
								 array("Origin","o"),
								 array("Uplay","u")
								);
								$la=array(
								 array("Англійська","us"),
								 array("Російська","r"),
								 array("Українська","uk")
								);
								$ty=array("Акаунт","Gift Link","Key","Фото ключа");
								$pe=array("Random key","Gift","Промо код","Акаунт");
								echo 'OC: ';
								for($i=0;$pr[0][$i]!=NULL;$i++)
									if($pr[0][$i])
										echo '<img src="../../images/'.$pl[$i][1].'.png" alt="'.$pl[$i][0].'" title="'.$pl[$i][0].'">';
								if(strlen($pr[1])>0 && $pr[1]!=0){
									echo '<br>Ігровий клієнт: ';
									if($pr[1]>=1 && $pr[1]<=5)
										echo '<img src="../../images/'.$gk[$pr[1]-1][1].'.png" alt="'.$gk[$pr[1]-1][0].'" title="'.$gk[$pr[1]-1][0].'">';
									else
										echo $pr[1];
								}
								if(strlen($pr[2])>0 && $pr[2]!=0){
									echo '<br>Мова: ';
									if($pr[2]>0 && $pr[2]<4)
										echo '<img src="../../images/'.$la[$pr[2]-1][1].'.png" alt="'.$la[$pr[2]-1][0].'" title="'.$la[$pr[2]-1][0].'">';
									else
										echo $pr[2];
								}
								if(strlen($pr[3])>0 && $pr[3]!=0){
									echo '<br>Тип продукту: ';
									if($pr[3]>0 && $pr[3]<4)
										echo $ty[$pr[3]-1];
									else
										echo $pr[3];
								}
								if(strlen($pr[4])>0 && $pr[4]!=0)
									echo '<br>Розробник: '.$pr[4];
								if(strlen($pr[5])>0 && $pr[5]!=0)
									echo '<br>Видавець: '.$pr[5];
								if(strlen($pr[6])>0 && $pr[6]!=0)
									echo '<br>Рік: '.$pr[6];
								if(strlen($pr[7])>0 && $pr[7]!=0){
									echo '<br>Подарунок: ';
									if($pr[7]>0 && $pr[7]<5)
										echo $ty[$pr[7]-1];
									else
										echo $pr[7];
								}
							?></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-7" style="padding: 0;">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#tab1">Опис</a></li>
							<li><a data-toggle="tab" href="#tab2">Інструкція</a></li>
							<li><a data-toggle="tab" href="#tab3">Системні вимоги</a></li>
						</ul>
						<div class="tab-content">
							<div id="tab1" class="tab-pane fade in active">
								<p><?=htmlspecialchars_decode($row['o1'])?></p>
							</div>
							<div id="tab2" class="tab-pane fade">
								<p><?=htmlspecialchars_decode($row['o2'])?></p>
							</div>
							<div id="tab3" class="tab-pane fade">
								<p><?=htmlspecialchars_decode($row['o3'])?></p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5" style="padding: 0;">
						<h2 class="customizedH">ВІДГУКИ</h2>
						<?php 
						if($_GET['comment']=="error")
								alert('Помилка при додаванні коментаря. Спробуйте не використовувати латинські букви','danger');
						else if($_GET['comment']=="danger")
								alert('Помилка при додаванні коментаря. Спробуйте не використовувати спеціальні символи','danger');
						else if($_GET['comment']=="success")
								alert('Коментарь успішно додано. Дякуємо!','success');
						else if(isset($_POST['userCommentText']) && isset($_POST['submitF'])){
							if(_ID_!=-1)
								$buf=_ID_;
							else
								$buf=0;
							if(isInjected($_POST['userCommentText']))
								header('Location: '.$linkClean.'/?comment=error');
							else if(!validLight($_POST['userCommentText']))
								header('Location: '.$linkClean.'/?comment=danger');
							else {
								que('SELECT comments FROM '._PRODUCTS_.' WHERE id="'.$postID.'"');
								$row=mysql_fetch_array($res);
								$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
								$dt->setTimestamp(time());
								$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
								que('UPDATE '._PRODUCTS_.' SET comments="'.$row['comments'].'" WHERE id="'.$postID.'"');
								header('Location: '.$linkClean);
							}
						}
						?>
						<form action="index.php#feedbackLink" method="post" class="comment row">
							<div class="col-xs-2 commentImg" style="background-image:url(<?php
								if(_ID_!=-1 && _SRC_!=_DEAFULT_AVA_)
									echo _SRC_;
								else
									echo _DEAFULT_AVA_.');filter:invert(40%';
								?>)"></div>
							<div class="col-xs-10">
								<p><?php
									if(_ID_==-1)
										echo 'Анонімус';
									else
										echo _U_NAME_;
								?></p>
								<textarea name="userCommentText" class="form-control userCommentText"></textarea>
								<input type="submit" name="submitF" class="btn btn-goldi r" value="Написати">
							</div>
						</form>
						<?php que('SELECT comments FROM '._PRODUCTS_.' WHERE id="'.$postID.'"');
						$row = mysql_fetch_array($res);
						$comments=explode('>^',$row['comments']);
						for($i=0;$comments[$i]!=NULL;$i++){
							if($i===_COMMENTS_)
								echo '<div class="commentsH">';
							$buf=explode('^>',$comments[$i]);
							if($buf[0]!='0'){
								que('SELECT login FROM '._USERS_.' WHERE id="'.$buf[0].'"');
								$raw=mysql_fetch_array($res);
								if($raw['login']!=NULL){
									$creator_name=getName($buf[0]);
									$srr=getAva($raw['login']);
								}
							}
							if($srr==NULL || $buf[0]==0)
								echo '<div class="comment row"><div class="col-xs-2 commentImg" style=\'background-image:url('._DEAFULT_AVA_.');filter:invert(40%)\'></div><div class="col-xs-10"><p>Анонімус<span>, '.$buf[2].'</span></p><p class="commentText">'.$buf[1].'</p></div></div>';
							else {
								echo '<div class="comment row"><a href="'.LINK.'profile/?id='.$buf[0].'" class="col-xs-2 commentImg" style=\'background-image:url('.$srr.')';
								if($srr==_DEAFULT_AVA_)
									echo ';filter:invert(40%)';
								echo '\'></a><div class="col-xs-10"><p><a href="'.LINK.'profile/?id='.$buf[0].'">'.$creator_name.'</a><span>, '.$buf[2].'</span></p><p class="commentText">'.$buf[1].'</p></div></div>';
							}
							unset($creator_name,$srr,$buf[0],$buf[1],$raw['login']);
						}
						if($i==0)
							alert('Будьте першим, хто прокоментує цей продукт!','info');
						else if($i>_COMMENTS_){
							?></div>
							<button class="btn btn-goldi displayComments">Показати ще</button>
							<script>
								$('.displayComments').click(function(){
									$(this).remove();
									$('.commentsH').removeClass('commentsH');
								})
							</script><?php
						}
						?>
					</div>
				</div>
				<?php footer(1); ?>
			</div>
	</body>
</html>