<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include 'functions/main.php';
			head();
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/jquery.fullPage.css">
		<script type="text/javascript" src="functions/jquery.fullpage.extensions.min.js"></script>
		<script type="text/javascript" src="https://raw.githubusercontent.com/alvarotrigo/fullPage.js/master/vendors/scrolloverflow.min.js"></script>
		<script type="text/javascript" src="functions/scrolloverflow.min.js"></script>
	</head>
	<body class="mainPage"><?php
		que('SELECT name,value FROM '._MV_.' WHERE name LIKE "h%"');
		for($i=1;$i<=14;$i++){
			$row=mysql_fetch_assoc($res);
			$name=$row['name'];
			$$name=nl2br($row['value']);
		} ?>
		<div id="fullpage">
			<div class="section text-center" id="mainPageBlock" style="background-image:url(<?=getAva(0,LINK.'images/bg.')?>)">
				<?php top() ?>
				<h3 class="hidden-xs hidden-sm">
					<div class="textAnimation">
					<div class="textAnimation__container">
						<ul class="textAnimation__container__list"> <?php
								que('SELECT value FROM '._MV_.' WHERE name LIKE "q%" AND LENGTH(value)>1');
								while($row = mysql_fetch_assoc($res)){
									echo '<li class="textAnimation__container__list__item"';
										if(strlen($row['value'])>55)
											echo ' style="font-size: 2vw"';
										else if(strlen($row['value'])>35)
											echo ' style="font-size: 3vw"';
									echo '>'.$row['value'].'</li>';
								} ?>
						</ul>
					</div>
					</div>
				</h3>
				<div class="arrow"></div>
			</div>
			<div class="section" id="broken">
				<?php top(0,1) ?>
				<div class="clearContainer1 middle">
					<div class="container"> <?php
						if(_TYPE_==2)
							echo '<div>
								<a class="btn btn-goldi" href="'.LINK.'adm/stats.php">Інформація</a>
								<a class="btn btn-goldi" href="'.LINK.'adm/cross1.php">Послуги 1</a>
								<a class="btn btn-goldi" href="'.LINK.'adm/cross2.php">Послуги 2</a>
							</div>';
						for($i=0;$i<5;$i++){
							$n1='h'.($i*2+4);
							$n2='h'.($i*2+4+1);
							echo '<div class="element">
								<div class="imageContainer">
									<div style="background-image:url('.getAva(0,LINK.'images/shop'.($i+1).'_.').')"></div>
								</div>
								<h3>'.$$n1.'</h3>
								<p>'.$$n2.'</p>
								<a href="/t/p'.($i+1).'/">Детальніше</a>
							</div>';
						} ?>
					</div>
				</div>
			</div>
			<div class="section" id="crosses">
				<?php top($h14,1) ?>
				<div class="clearContainer1 middle">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-6" id="tableNotAll">
								<div class="row" style="	display: table-cell;
		vertical-align: middle;">
									<style>th:nth-child(3) {
	margin-left: 108px;
	width: 9px;
}th:nth-child(2),th:nth-child(4) {
	padding-left: 10px;
}</style>
									<?php que('SELECT value FROM '._MV_.' WHERE name="cross1"'); $row=mysql_fetch_assoc($res); echo htmlspecialchars_decode($row['value']);?>
								</div>
							</div>
							<div class="col-sm-6 hidden-xs"><?php que('SELECT value FROM '._MV_.' WHERE name="cross2"'); $row=mysql_fetch_assoc($res); echo htmlspecialchars_decode($row['value']);?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="section" id="problem2">
				<?php top(0,1) ?>
				<div class="clearContainer1 specialClear middle">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-lg-4" id="feedback">
								<a id="feedbackLink"></a>
								<h2>ВІДГУКИ</h2>
								<?php 
								if($_GET['comment']=="error")
										echo '<div class="alert alert-danger">Помилка при додаванні коментаря. Спробуйте не використовувати латинські букви</div>';
								else if($_GET['comment']=="danger")
										echo '<div class="alert alert-danger">Помилка при додаванні коментаря. Спробуйте не використовувати спеціальні символи</div>';
								else if($_GET['comment']=="success")
										echo '<div class="alert alert-success">Коментарь успішно додано. Дякуємо!</div>';
								else if(isset($_POST['userCommentText']) && isset($_POST['submitF'])){
									if(_ID_!=-1)
										$buf=_ID_;
									else
										$buf=0;
									if(isInjected($_POST['userCommentText']))
										header('Location: '.LINK.'?comment=error');
									else if(validLight($_POST['userCommentText'])===0)
										header('Location: '.LINK.'?comment=danger');
									else {
										que('SELECT comments FROM '._PRODUCTS_.' WHERE id=0');
										$row=mysql_fetch_array($res,MYSQL_ASSOC);
										$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
										$dt->setTimestamp(time());
										$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
										que('UPDATE '._PRODUCTS_.' SET comments="'.$row['comments'].'" WHERE id=0');
										header('Location: '.LINK.'?comment=success');
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
										echo '<div class="alert alert-info">Будьте першим, хто прокоментує наший магазин!</div>';
									else if($i>_COMMENTS_){
										echo '</div>'; ?>
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
							<div class="col-xs-12 col-lg-8" id="contacts">
								<a id="contactsLink"></a>
								<h2>КОНТАКТИ</h2>
								<?php
									if(strlen($_POST['fsubject'])>0 && strlen($_POST['fname'])>0 && strlen($_POST['femail'])>0){
										if(!validEmail($_POST['femail'])){
											echo '<div class="alert alert-danger">Вкажіть правильну email адресу</div>';
											$wrongdata=1;
										}
										else if(isInjected($_POST['fname']) || !validLight($_POST['fname'])){
											echo '<div class="alert alert-danger">Вкажіть правильне ім\'я</div>';
											$wrongdata=1;
										}
										else if(isInjected($_POST['fsubject'])){
											echo '<div class="alert alert-danger">Вкажіть правильний текст повідомлення. (захист від SQL інєкції наявний)</div>';
											$wrongdata=1;
										}
										else {	
											echo '<div class="alert alert-success">Ваше повідомлення надіслано успішно. Дякую!</div>';
											$headers = 'From: '.$_POST['femail']."\r\n".'Reply-To: '.$_POST['femail']."\r\n".'X-Mailer: PHP/'.phpversion();
											@mail(_EMAIL_,'New message from '.$_POST['fname'],'Name: '.$_POST['fname']."\n".'From: '.$_POST['femail']."\n".'Content: '.$_POST['fsubject'],$headers);
										}
									}
								?>
								<div class="row">
									<div class="col-xs-12 col-sm-5 contactsL">
										<form method="post" action="index.php#contactsLink">
											<div class="form-group">
												<label class="control-label" for="fname">Ваше ім'я</label>
												<input class="form-control" type="text" id="fname" name="fname" required placeholder="Ваше ім'я.."
														<?php if($wrongdata)
															echo ' value="'.$_POST['fname'].'"'; ?>
													>
											</div>
											<div class="form-group">
												<label class="control-label" for="femail">Ваша електронна адреса</label>
												<input class="form-control" type="email" id="femail" name="femail" required placeholder="max@patii.uk"
														<?php if($wrongdata)
															echo ' value="'.$_POST['femail'].'"'; ?>
													>
											</div>
											<div class="form-group">
												<label class="control-label" for="fsubject">Повідомлення</label>
												<textarea class="form-control" id="fsubject" name="fsubject" placeholder="Текст повідомлення" required><?php if($wrongdata) echo $_POST['fsubject']; ?></textarea>
											</div>
											<input type="submit" name="submitC" class="btn btn-goldi" value="Надіслати">
										</form>
									</div>
									<div class="col-xs-12 col-sm-7 contactsR">
										<h3>E-mail:</h3>
										<p><?=_EMAIL_?></p>
										<a href="mailto:<?=_EMAIL_?>" rel="author">Написати повідомлення</a>
										<h4>Ми в соцмережах:</h4>
										<div style="margin-left: -10px;"> <?php
											sml(_YTLINK_,'https://s8.hostingkartinok.com/uploads/images/2017/12/f6f6ea6c4f391d7c74fcf0dacf73e051.png');
											sml(_FBLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/09b625bc498d366d91ca874ed5595822.png');
											sml(_TWLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/0a2038d48cfce07ab41479f8372f13c1.png');
											sml(_INLINK_,'https://s8.hostingkartinok.com/uploads/images/2018/01/f1ec15166b4fc0c1729ab9c73204906c.png'); ?>
										</div>
										<a href="http://sportrelaxnutritions.com/" style="display: block;"><img src="<?=getAva(0,LINK.'images/srn.')?>" alt="http://sportrelaxnutritions.com/" style="width:100%"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('.section:not(:first-child)').hide();
			$(document).ready(function() {
				$('.section:not(:first-child)').show();
				$('#fullpage').fullpage({
					dragAndMove: true,
					//scrollOverflow: true,
					recordHistory: false,
					//scrollOverflow: true,
					fitToSection: true,
					//lazyLoading: true,
					responsiveWidth: 991,
					responsiveHeight: 500,
					//paddingTop: "150px",
					//parallax: true,
					anchors: ['main', 'shop', 'functions']
				});
			});
			/*$('head').append(`<style>
				@media (max-width: 992px){
					#mainPageBlock {
						background-image: url(<h?=getAva(0,LINK.'images/sb.')?>) !important;
					}
					.section {
						background-attachment: fixed !important;
					}
				}
				@media (min-width: 992px){
					.section {
						background-size: auto 100vh !important;
					}
				}
				.section {
					background: var(--bg) url(<h?=getAva(0,LINK.'images/bb.')?>) repeat top !important;
				}
				</style>`);*/
			$('.section').each(function(){
				if($(this).has('.fp-scroller'))
					$(this).css('padding-top','0')
			})
		</script>
		<?php footer(3)?>
	</body>
</html>