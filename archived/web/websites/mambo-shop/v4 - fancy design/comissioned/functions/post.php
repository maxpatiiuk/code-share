<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once 'main.php';
			que('SELECT * FROM '._PRODUCTS_.' WHERE unixTime = "'.preg_replace('/[^0-9]/','',$dir).'";');
			$row = mysql_fetch_array($res);
			head($row['name'._LANGUAGE_],$row['name'._LANGUAGE_].', '.$row['o0'._LANGUAGE_],$row['name'._LANGUAGE_].', '.strip_tags($row['o0'._LANGUAGE_]));
			que('SELECT * FROM '._PRODUCTS_.' WHERE unixTime = "'.preg_replace('/[^0-9]/','',$dir).'";');
			$row = mysql_fetch_array($res);
			$path='a'.$row['unixTime'];
			$postID=$row['id'];
			$linkClean=LINK.'p/'.$path;
			$linkRedir=$linkClean.'?b=1';
			$link=htmlentities($linkClean);
			if(isset($_GET['b'])){
				if(_ID_!=-1){
					que('SELECT email FROM '._USERS_.' WHERE id="'._ID_.'"');
					$raw=mysql_fetch_array($res);
					$bufEmail='&email='.$raw['email'];
				}
				header('Location: '.LINK.'p/'.$path.'?a=add');
				echo '<meta http-equiv="refresh" content="0; link='.LINK.'p/'.$path.'?a=add">';
			}
		?>
		<link rel="stylesheet" type="text/css" href="../../css/product.css">
	</head>
	<body>
		<?php top(1); ?>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-7">
						<div class="row" style="margin:0">
							<div id="myCarousel" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators"> <?php
									for($i=1;1;$i++){
										if(!getAva(0,LINK.'p/'.$path.'/i'.$i.'.',0))
											break; ?>
										<li data-target="#myCarousel" data-slide-to="<?=$i?>"<?php
											if($i==1)
												echo 'class="active"'; ?>
										></li> <?php
									} ?>
								</ol>
								<div class="carousel-inner"> <?php
									for($ii=1;$ii<$i;$ii++){
										echo '<div class="item';
										if($ii==1)
											echo ' active';
										echo '">
											<img src="'.getAva(0,LINK.'p/'.$path.'/i'.$ii.'.').'" alt="Img №'.$ii.'">
										</div>';
									} ?>
								</div>
								<a class="left carousel-control" href="#myCarousel" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#myCarousel" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-5 extraSpace">
						<div class="row">
							<h1 class="col-xs-12"><?=$row['name'._LANGUAGE_]?>
							</h1>
						</div>
						<div class="row">
							<div class="col-xs-12 buy-container">
								<a href="<?=$linkRedir?>" class="col-xs-8 l text-center"><?=la('buy')?></a>
								<div class="col-xs-4 l text-center"><?=$row['price'._LANGUAGE_].getCurency(0)?></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<p class="l special"><?=la('share')?>:</p>
								<div class="r socialMedia">
									<a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=<?=$link?>"><img src="../../images/f.png" alt="Facebook"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?<?=$link?>"><img src="../../images/t.png" alt="Twitter"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://plus.google.com/share?url=<?=$link?>"><img src="../../images/g.png" alt="Google+"></a>
									<a target="_blank" rel="noopener noreferrer" href="https://vk.com/share.php?url=<?=$link?>"><img src="../../images/v.png" alt="Vk"></a>
								</div>
							</div>
						</div>
						<div class="row">
							<p class="col-xs-12" style="line-height: 24px;"><?=$row['o0'._LANGUAGE_]?></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-7" style="font-size: 17px;padding-top: 20px;"><?=$row['o1'._LANGUAGE_]?></div>
					<div class="col-xs-12 col-sm-5">
						<h2 class="customizedH"><?=la('feedback')?></h2>
						<?php 
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
								header('Location: '.LINK.'p/'.$path.'/?comment=error');
							else if(!validLight($_POST['userCommentText']))
								header('Location: '.LINK.'p/'.$path.'/?comment=danger');
							else {
								que('SELECT comments FROM '._PRODUCTS_.' WHERE id="'.$postID.'"');
								$row=mysql_fetch_array($res);
								$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
								$dt->setTimestamp(time());
								$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
								que('UPDATE '._PRODUCTS_.' SET comments="'.$row['comments'].'" WHERE id="'.$postID.'"');
								header('Location: '.$linkClean.'?comment=success');
							}
						}
						?>
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
								<textarea name="userCommentText" class="form-control userCommentText" required></textarea>
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
								echo '<div class="comment row">
									<div class="col-xs-2" style="position:relative;">
										<img class="commentImg" src="'._DEAFULT_AVA_.'" style="filter:invert(40%)">
									</div>
									<div class="col-xs-10">
										<p>'.la('anonim').'
											<span>, '.$buf[2].'</span>
										</p>
										<p class="commentText">'.$buf[1].'</p>
									</div>
								</div>';
							else {
								echo '<div class="comment row">
								<a href="'.LINK.'profile/?id='.$buf[0].'" class="col-xs-2" style="position:relative;">
									<img class="commentImg" src="'.$srr;
								if($srr==_DEAFULT_AVA_)
									echo '" style="filter:invert(40%)';
								echo '"></a><div class="col-xs-10"><p><a href="'.LINK.'profile/?id='.$buf[0].'">'.$creator_name.'</a><span>, '.$buf[2].'</span></p><p class="commentText">'.$buf[1].'</p></div></div>';
							}
							unset($creator_name,$srr,$buf[0],$buf[1],$raw['login']);
						}
						if($i>_COMMENTS_){
							?></div>
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
				</div>
			</div>
			<?php footer(1); ?>
	</body>
</html>