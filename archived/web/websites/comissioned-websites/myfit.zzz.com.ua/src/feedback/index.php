<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head('Перевтілення','Перевтілення',_ABOUT_);
			que('SELECT value FROM '._MV_.' WHERE name="feedPage"');
			$row=mysql_fetch_array($res);
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1,4)?>
		<div class="clearContainer1">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 userStyles"><?php
						if(_TYPE_==2)
							echo '<a class="btn btn-goldi" href="'.LINK.'adm/feedback.php">Редагувати</a>';
						echo htmlspecialchars_decode($row['value'])?>
					</div>
				</div>
			</div>
			<?=footer()?>
		</div>
	</body>
</html>
<?/*
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head(la('feedback'),la('feedback'));
			if(is_numeric($_GET['d']) && strlen($_GET['d'])>0 && strlen($_GET['s'])>0 && strlen($_GET['m'])>4 && ($_GET['d']==_ID_ || _TYPE_==2)){
				que('SELECT comments FROM '._PRODUCTS_.' WHERE id="0"',2);
				$raw=mysql_fetch_array($ras);
				$comments=preg_replace('/'.$_GET['d'].'\^>.{'.$_GET['s'].'}\^>'.preg_replace('/\./','\.',$_GET['m']).'>?\^?/','',$raw['comments']);
				que('UPDATE '._PRODUCTS_.' SET comments="'.$comments.'" WHERE id="0"',2);
			}
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(1) ?>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-2 col-sm-8" id="feedback">
				<div class="row">
					<div class="col-xs-12 col-sm-6"> <?php
						if($_GET['comment']=="error")
							alert(la('commentError1'),'danger');
						else if($_GET['comment']=="danger")
							alert(la('commentError2'),'danger');
						else if($_GET['comment']=="success")
							alert(la('commentSuccess'),'success');
						else if(isset($_POST['userCommentText']) && isset($_POST['submitF'])){
							if(_ID_!=-1)
								$buf=_ID_;
							else
								$buf=0;
							if(isInjected($_POST['userCommentText']))
								header('Location: '.LINK.'feedback/?comment=error');
							else if(!validLight($_POST['userCommentText']))
								header('Location: '.LINK.'feedback/?comment=danger');
							else {
								que('SELECT comments FROM '._PRODUCTS_.' WHERE id=0');
								$row=mysql_fetch_array($res);
								$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
								$dt->setTimestamp(time());
								$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
								que('UPDATE '._PRODUCTS_.' SET comments="'.$row['comments'].'" WHERE id=0');
								header('Location: '.LINK.'feedback/?comment=success');
							}
						} ?>
						<form action="index.php" method="post" class="comment row">
								<div class="col-xs-2" style="position:relative;">
									<img class="commentImg" src="<?php
										if(_ID_!=-1 && _SRC_!=_DEAFULT_AVA_)
											echo _SRC_;
										else
											echo _DEAFULT_AVA_.'" style="filter:invert(40%)';
									?>">
								</div>
							<div class="col-xs-10" style="padding-right: 0;">
								<p><?php
									if(_ID_==-1)
										echo la('anonim');
									else
										echo _U_NAME_;
								?></p>
								<textarea name="userCommentText" class="form-control userCommentText"></textarea>
								<input type="submit" name="submitF" class="btn btn-goldi r" value="<?=la('sendMessage')?>">
							</div>
						</form>
						<?php que('SELECT comments FROM '._PRODUCTS_.' WHERE id=0');
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
								if($srr==NULL || $buf[0]==0){
									echo '<div class="comment row">
										<div class="col-xs-2" style="position:relative;">
											<img class="commentImg" src="'._DEAFULT_AVA_.'" style="filter:invert(40%)">
										</div>
										<div class="col-xs-10">
											<p>'.la('anonim').'
												<span>, '.$buf[2].'</span>';
											if(_TYPE_==2 || _ID_==$buf[0])
												echo '<a href="index.php?d='.$buf[0].'&m='.htmlentities($buf[2]).'&s='.strlen($buf[1]).'" class="r btn btn-danger btn-xs">X</a>';
											echo '</p>
											<p class="commentText">'.$buf[1].'</p>
										</div>
									</div>';
								}
								else {
									echo '<div class="comment row">
										<a href="'.LINK.'profile/?id='.$buf[0].'" class="col-xs-2" style="position:relative;">
											<img class="commentImg" src="'.$srr;
												if($srr==_DEAFULT_AVA_)
													echo '" style="filter:invert(40%)';
											echo '">
										</a>
										<div class="col-xs-10">
											<p>
												<a href="'.LINK.'profile/?id='.$buf[0].'">'.$creator_name.'</a>
												<span>, '.$buf[2].'</span>';
											if(_TYPE_==2 || _ID_==$buf[0])
												echo '<a href="index.php?d='.$buf[0].'&m='.htmlentities($buf[2]).'&s='.strlen($buf[1]).'" class="r btn btn-danger btn-xs">X</a>';
											echo '</p>
											<p class="commentText">'.$buf[1].'</p>
										</div>
									</div>';
								}
								unset($creator_name,$srr,$buf[0],$buf[1],$raw['login']);
							}
							if($i>_COMMENTS_){ ?>
								</div>
								<button class="btn btn-goldi displayComments"><?=la('showMore')?></button>
								<script>
									$('.displayComments').click(function(){
										$(this).remove();
										$('.commentsH').removeClass('commentsH');
									})
								</script><?php
							}
						?>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="row"> <?php
							que('SELECT limed FROM '._PRODUCTS_.' WHERE id=0');
							$row=mysql_fetch_array($res);
							$buf=explode('^',$row['limed']);
							foreach ($buf as $lime) {
								if(strlen($lime)<1)
									continue;
								echo '<div class="review col-xs-6">
									<div class="row" style="margin:0">
										<div class="aspectContainer">';
											if(preg_match('/[A-Za-z0-9-_]{11}/',$lime))
												echo '<iframe src="https://www.youtube.com/embed/'.$lime.'?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
											else
												echo '<img src="'.LINK.'images\f\\'.$lime.'" alt="User review">';
										echo '</div>
									</div>
								</div>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php footer(1)?>
	</body>
</html> */