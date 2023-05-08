<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head();
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(1)?>
		<div class="row">
			<div class="col-xs-12 col-sm-offset-2 col-sm-8">
				<div class="row grey">
					<h2 class="customizedH"><?=la('aboutUs')?></h2>
					<h1><?=la('welcome')?> <?=_NAME_?></h1>
					<div class="text col-xs-12 col-sm-6"><?=la('aboutUsText')?></div>
					<div class="col-xs-12 col-sm-6 containerForContainers">
						<div class="containerForImg" style="background-image:url(<?=getAva(1,LINK.'images/aboutUsImg1.')?>"></div>
						<div class="containerForImg" style="background-image:url(<?=getAva(1,LINK.'images/aboutUsImg2.')?>"></div>
						<div class="containerForImg" style="background-image:url(<?=getAva(1,LINK.'images/aboutUsImg3.')?>"></div>
						<div class="containerForImg" style="background-image:url(<?=getAva(1,LINK.'images/aboutUsImg4.')?>"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-lg-6" id="feedback">
						<a id="feedbackLink"></a>
						<h2 class="customizedH"><?=la('feedback')?></h2> <?php
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
								header('Location: '.LINK.'about/?comment=error');
							else if(!validLight($_POST['userCommentText']))
								header('Location: '.LINK.'about/?comment=danger');
							else {
								que('SELECT comments FROM '._PRODUCTS_.' WHERE id=0');
								$row=mysql_fetch_array($res);
								$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
								$dt->setTimestamp(time());
								$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
								que('UPDATE '._PRODUCTS_.' SET comments="'.$row['comments'].'" WHERE id=0');
								header('Location: '.LINK.'about/?comment=success');
							}
						} ?>
						<form action="index.php#feedbackLink" method="post" class="comment row">
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
							if($i>_COMMENTS_){ ?>
								</div>
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
					<div class="col-xs-12 col-lg-6" id="contacts">
						<a id="contactsLink"></a>
						<h2 class="customizedH"><?=la('contacts')?></h2>
						<?php
							if(strlen($_POST['fsubject'])>0 && strlen($_POST['fname'])>0 && strlen($_POST['femail'])>0){
								if(!validEmail($_POST['femail'])){
									alert(la('enterValidEmail'),'danger');
									$wrongdata=1;
								}
								else if(isInjected($_POST['fname']) || !validLight($_POST['fname'])){
									alert(la('enterValidName'),'danger');
									$wrongdata=1;
								}
								else if(isInjected($_POST['fsubject'])){
									alert(la('enterValidMessage'),'danger');
									$wrongdata=1;
								}
								else {	
									echo '<div class="alert alert-success"></div>';
									$headers = 'From: '.$_POST['femail']."\r\n".'Reply-To: '.$_POST['femail']."\r\n".'X-Mailer: PHP/'.phpversion();
									@mail(_EMAIL_,'New message from '.$_POST['fname'],'Name: '.$_POST['fname']."\n".'From: '.$_POST['femail']."\n".'Content: '.$_POST['fsubject'],$headers);
								}
							}
						?>
						<div class="row">
							<div class="col-xs-12 col-sm-8 contactsL">
								<form method="post" action="index.php#contactsLink">
									<div class="form-group">
										<label class="control-label" for="fname"><?=la('yourName')?></label>
										<input class="form-control" type="text" id="fname" name="fname" required>
									</div>
									<div class="form-group">
										<label class="control-label" for="femail"><?=la('yourEmail')?></label>
										<input class="form-control" type="email" id="femail" name="femail" required>
									</div>
									<div class="form-group">
										<label class="control-label" for="fsubject"><?=la('message')?></label>
										<textarea class="form-control" id="fsubject" name="fsubject" required style="height:200px"></textarea>
									</div>
									<input type="submit" name="submitC" class="btn btn-goldi" value="<?=la('sendMessage')?>">
								</form>
							</div>
							<div class="col-xs-12 col-sm-4 contactsR">
								<h3>E-mail:</h3>
								<p><?=_EMAIL_?></p>
								<a href="mailto:<?=_EMAIL_?>" rel="author"><?=la('writeMessage')?></a>
								<h4><?=la('socialM')?>:</h4>
								<div style="margin-left: -10px;"> <?php
									sml(_FBLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/09b625bc498d366d91ca874ed5595822.png');
									sml(_TWLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/0a2038d48cfce07ab41479f8372f13c1.png');
									sml(_INLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/f1ec15166b4fc0c1729ab9c73204906c.png');
									sml(_VKLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/189c7d233d0e6edf49cdd0ef711a8046.png'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php footer(1)?>
	</body>
</html>