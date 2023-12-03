<!-- Shop -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include 'functions/main.php';
			head('','Головна, магазин в гостях у мамбо, магазин в гостях у mambo');
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top()?>
		<div class="row" id="mainPageBlock">
			<div class="col-xs-12">
				<div id="mainFullSizeImg"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 content">
				<script>
					$('#menu').css('background','none');
					$('#menu').css('transition','0.5s');
					$(window).scroll(function() {
						var scroll = $(window).scrollTop();
						if (scroll >= $('#mainPageBlock').height()-$('#menu').height())
							$('#menu').css('background','#000');
						else if (scroll >= $('#mainPageBlock').height()/6)
							$('#menu').css('background','rgba(0,0,0,0.8)');
						else
							$('#menu').css('background','none');
					});
				</script>
				<div class="row posts">
					<div class="col-xs-12 col-sm-9 col-sm-push-3">
						<?php $que='SELECT id,name,price,link,vis,views,unixTime,parameters FROM '._PRODUCTS_.' WHERE vis=1';
							if(!validNum($_POST['priceFirst']))
								$_POST['priceFirst']=NULL;
							if(!validNum($_POST['priceSecond']))
								$_POST['priceSecond']=NULL;
							if($_POST['priceFirst']>$_POST['priceSecond']){
								$buf=$_POST['priceFirst'];
								$_POST['priceFirst']=$_POST['priceSecond'];
								$_POST['priceSecond']=$buf;
							}
							if(validNum($_POST['priceFirst']))
								$que.=' AND price>='.$_POST['priceFirst'].'';
							if(validNum($_POST['priceSecond']))
								$que.=' AND price<='.$_POST['priceSecond'].'';
							$que.=' ORDER BY ';
							if($_POST['sort']==1)
								$que.="views+0 DESC,id+0";
							else if($_POST['sort']==2)
								$que.="price+0,id+0";
							else if($_POST['sort']==3)
								$que.="price+0 DESC,id+0";
							else if($_POST['sort']==4)
								$que.="unixTime+0 DESC,id+0";
							else
								$que.="id+0,views+0";
							que($que);
							$u=mysql_num_rows($res);
							if(isset($_POST['submitS'])){
								?><script>
									function scrollTo(){
										window.scroll(0,document.documentElement.clientHeight*0.95);
									}
									scrollTo();
								</script><?php
							}
							if($u==0)
								echo '<div class="alert alert-danger">За даними фільтрами товарів не знайдено!</div>';
							else {
								echo '<div class="row">';
								$ty=array("(Акаунт)","(Gift Link)","(Key)","(Фото ключа)");
								$gk=array("(Steam)","(Mojang)","(Social Club)","(Origin)","(Uplay)");
								while($row=mysql_fetch_array($res)){
									$pr=explode(':',$row['parameters']);
									echo '<a href="p/'.$row['link'].'" class="post col-xs-6 col-sm-4 col-md-3">
										<div class="postImg">
											<img src="'.getAva(1,LINK.'p/'.$row['link'].'/img0.',LINK.'images/def.png').'" alt="'.$row['name'].'">
										</div>
										<div class="postName">';
										if(strlen($row['name'])+strlen($ty[$pr[3]])<40){
											$bufName=true;
											$row['name'].=' '.$ty[$pr[3]-1];
										}
										if(strlen($row['name'])+strlen($gk[$pr[5]])<40){
											if($bufName!==true)
												$row['name'].=' ';
											$row['name'].=$gk[$pr[5]-1];
										}
										echo $row['name'].'</div>
										<div class="postPrice">'.$row['price'].'&#8372;</div>
									</a>';
								}
								echo '</div>';
							}
						?>
					</div>
					<div class="col-xs-12 col-sm-3 col-sm-pull-9"> <?php
						if(_TYPE_==2)
							echo '<a href="/adm/" type="button" class="btn btn-goldi">Адміністрування</a>'; ?>
						<h2 class="customizedH">Сортування</h2>
						<form method="post">
							<select class="form-control" name="sort" >
								<option value="0"<?php if($_POST['sort']=="0") echo ' selected'; ?>>По рейтингу</option>
								<option value="1"<?php if($_POST['sort']=="1") echo ' selected'; ?>>По популярності</option>
								<option value="2"<?php if($_POST['sort']=="2") echo ' selected'; ?>>По ціні &#9650;</option>
								<option value="3"<?php if($_POST['sort']=="3") echo ' selected'; ?>>По ціні &#9660;</option>
								<option value="4"<?php if($_POST['sort']=="4") echo ' selected'; ?>>Новинки</option>
							</select>
							<h3 class="customizedH">Ціна:</h3>
							<input class="form-control l" value="<?=$_POST['priceFirst']?>" name="priceFirst" placeholder="Мін.">
							<input class="form-control l" value="<?=$_POST['priceSecond']?>" name="priceSecond" placeholder="Макс.">
							<input class="btn btn-goldi r" type="submit" value="Сортувати" name="submitS" style="margin-bottom:10px;">
						</form>
					</div>
				</div>
				<div class="row grey">
					<div class="col-xs-12 col-sm-offset-2 col-sm-8">
						<div class="row">
							<h2 class="customizedH">ПРО НАС</h2>
							<h1>Запрошуємо в MAMBO SHOP</h1>
							<div class="text col-xs-12 col-sm-6">
								Ми дуже раді представити вам MAMBO SHOP - український магазни ігрових ключів та акаунтів. Ми представляємо вам широкий вибір товарів для Steam, Origin, Social Club, Mojang та багато інших ігрових площадок
								<a id="textLink">...Читати далі</a>
								<div class="textH"><br>
									Працюючи з 2015 року ми отримали багато досвіду, роблячи все, щоб процедура оплати стала ще простішою а ціни ще нищими.<br><br>

									Багато українських геймерів та ютуберів надають перевагу саме нам. Їхня кількість досягла 5000!<br><br>
					 
									Всі покупки проходять через сервіс Oplata.info, який використовує сертифікати захисту, щоб ваші дані були в безпеці. Він зберігає всі ваші купівлі в одному місці та дає постійний доступ до них. Саме тому ви можете бути впевненими, що жоден шахрай не отримає доступ до вашої цінної інформації<br><br>

									Дякуємо всім за численні відгуки. Це для нас великий стимул рости та покращуватися далі.<br><br>
								</div>
							</div>
							<div class="col-xs-6 hidden-xs aboutUsImages aboutUsImagesH">
								<img class="aboutImgH aboutImg1" src="https://s8.hostingkartinok.com/uploads/images/2018/01/a34105360cce83d0494960c820cb5a1e.png" alt="Steam">
								<img class="aboutImgH aboutImg2" src="https://s8.hostingkartinok.com/uploads/images/2018/01/0c7ddf0c82ead5647abee63f8bfc457d.png" alt="Origin">
								<img class="aboutImgH aboutImg3" src="https://s8.hostingkartinok.com/uploads/images/2018/01/d6f9d08497233ab92cc27c792873500b.png" alt="Social Club">
								<img class="aboutImgH aboutImg4" src="https://s8.hostingkartinok.com/uploads/images/2018/01/581e8fa8443a5b7b767ee3240118ede1.png" alt="Mojang">
						</div>
						</div>
					</div>
				</div>
				<script>
					$('#textLink').click(function(){
						$('#textLink').remove();
						$('.textH').removeClass('textH');
						$('.text').addClass('textV');
						$('.aboutImgH').removeClass('aboutImgH').addClass('aboutImgV');
						$('.aboutUsImagesH').removeClass('aboutUsImagesH').addClass('aboutUsImagesV');
					})
				</script>
				<div class="row">
					<div class="col-xs-12 col-sm-offset-2 col-sm-8">
						<h2 class="customizedH">FAQ</h2>
						<div class="panel-group" id="accordion">
							<?php function accordion($head,$body,$mark=NULL){
								static $i=1;
								echo '<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a ';
											if(isset($mark))
												echo 'id="'.$mark.'"';
											echo 'data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" aria-expanded="false" class="collapsed">'.$head.'</a>
										</h4>
									</div>
									<div id="collapse'.$i.'" class="panel-collapse collapse" aria-expanded="true">
										<div class="panel-body">'.$body.'</div>
									</div>
								</div>';
								$i++;
							}
							accordion('Як купити гру?','Перейдіть на головну сторінку сайту > Виберіть товар, що вас зацікавив, натиснувши на нього > натисніть на клавішу "Купити" > Виберіть спосіб оплати, валюту. Вкажіть адресу вашої електронної пошти та промо-код на знижку при наявності. Заповніть додаткові поля (посилання на Steam профіль та ін.) при потребі. Проведіть оплату вибраним способом. Після оплати натисніть на "Перейти на сайт продавця". На даній сторінці будуть знаходитися ключ/логін:пароль/фото/посилання, яке ви купили, назву товару та інша інформація. Якщо після проведення платежу вас автоматично не надішле на сторінку для отримання товару, можна зайти безпосередньо через сайт <a href="https://www.oplata.info/info/">oplata.info</a> або відкити лист, що прийшов на пошту');
							accordion('Що таке розділ "Переписка" і де його знайти?','Розділ "Переписка" знаходиться в вашому акаунті <a href="https://www.oplata.info/info/">oplata.info</a>, на сторінці інформації про кожен товар. Саме сюди потрібно писати продавцеві про отримання подарунку, бонусу, допомоги чи наприклад заміни товару при несправності. Зауважте, що писати продавцеві потрібно російською мовою (більшість продавців не знають українську мову).');
							accordion('Не працює акаунт/ключ/посилання','При несправності акауну/ключа/посилання зайдіть на сторінку опису цього товару. Прочитайте інструкцію (для того, щоб взнати про умови та можливість заміни/повернення грошей). Після цього зайдіть в розділ "Переписка" на сайті <a href="https://www.oplata.info/info/">oplata.info</a> (дивіться вище як це зробити). Напишіть продавцеві про несправність і ви отримаєте новий товар або повернення грошей');
							accordion('Не співпадає ціна в магазині та oplata.info','Ціна товару оновлюється кожного дня в 5:30 та залежить від продавця і курсу гривні до рубля. Якщо ціна в магазині та на сайті oplata.info не співпвдвє то повідомте нам про це (дивіться нижче як це зробити)');
							accordion('Як звязатися з нами?','Ви можете написати нам в розділі <a href="#contactsLink">"Контактів"</a>, на email - <a href="'._EMAIL_.'">"'._EMAIL_.'"</a> . Окрім цього, загляньте розділ <a href="#contactsLink">"Контакти"</a>');
							accordion('Чи будуть відбуватися конкурси і розіграши?','Всі конкурси відбуваються на офіційному каналі магазину <a href="https://youtube.patii.uk">"В гостях у MAMBO"</a>');
							accordion('Правила','Адміністрація ніколи не просить дані від вашого акаунту.<br>Незнання правил не звільняє від відповідальності.<br>Заборонено використовувати аватарки, які порушують закони України або країни, в якій ви проживаєте.<br>Використання вад, помилок, проблем та недоробок сайту для обходу захисту або отримання вигоди, без попередження адміністрації за 2 тижі до цього заборонено.<br>Заборонено використовувати аватарки та слова (включно в назві акаунту), які несть в собі оманливий або образливий характер.<br>Заборонено рекламувати сторонні ресурси, пз, канали або веб сайти шляхом вказання їхньої назви в назвах акаунту, описі, аватарці, фоновому зображені або через коментарі.<br>Ми не гарантуємо заміну несправного товару, при порушені правил з вашої сторони.<br>Магазин залишає за собою повне право змінити правила без сповіщення про це користувачів.<br>Наший магазин не купує ключі/товари, а перенапрямлює клієнтів на провірених партнерів.<br>Заміна неробочого товару діє не на всі товари. Читайте опис товару.<br>Порушення правил карається за розглядом адміністрації, або відповідно до закону України, або країни в якій ви перебуваєте (стосується не всіх правопорушень).','rules');
							?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-offset-2 col-sm-8">
						<div class="col-xs-12 col-lg-6" style="padding-left: 7px;" id="feedback">
							<a id="feedbackLink"></a>
							<h2 class="customizedH">ВІДГУКИ</h2>
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
								else if(!validLight($_POST['userCommentText']))
									header('Location: '.LINK.'?comment=danger');
								else {
									que('SELECT comments FROM '._PRODUCTS_.' WHERE id=0');
									$row=mysql_fetch_array($res);
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
								<div class="col-xs-10" style="padding-right: 0;">
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
								else if($i>=_COMMENTS_){
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
						<div class="col-xs-12 col-lg-6" style="padding-right: 0;" id="contacts">
							<a id="contactsLink"></a>
							<h2 class="customizedH">КОНТАКТИ</h2>
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
										@mail('max@patii.uk','New message from '.$_POST['fname'],'Name: '.$_POST['fname']."\n".'From: '.$_POST['femail']."\n".'Content: '.$_POST['fsubject'],$headers);
									}
								}
							?>
							<div class="row">
								<div class="col-xs-12 col-sm-8 contactsL">
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
											<textarea class="form-control" id="fsubject" name="fsubject" placeholder="Текст повідомлення" required style="height:200px"><?php if($wrongdata) echo $_POST['fsubject']; ?></textarea>
										</div>
										<input type="submit" name="submitC" class="btn btn-goldi" value="Надіслати">
									</form>
								</div>
								<div class="col-xs-12 col-sm-4 contactsR">
									<h3>E-mail:</h3>
									<p>max@patii.uk</p>
									<a href="mailto:max@patii.uk" rel="author">Написати повідомлення</a>
									<h4>Ми в соцмережах:</h4>
									<div style="margin-left: -10px;"> <?php
										sml('https://youtube.patii.uk','https://s8.hostingkartinok.com/uploads/images/2018/01/4b64ece7d5e7bce7ade03ef1b1d576e7.png');
										sml('https://www.youtube.com/channel/UCCrYADQvPZG8Vdw_Rl7bMNA','https://s8.hostingkartinok.com/uploads/images/2018/01/c849b942064afefe743aadb61c576bbb.png');
										sml('https://facebook.patii.uk','https://s8.hostingkartinok.com/uploads/images/2018/01/09b625bc498d366d91ca874ed5595822.png');
										sml('https://twitter.patii.uk','https://s8.hostingkartinok.com/uploads/images/2018/01/0a2038d48cfce07ab41479f8372f13c1.png');
										sml('https://instagram.patii.uk/','https://s8.hostingkartinok.com/uploads/images/2018/01/f1ec15166b4fc0c1729ab9c73204906c.png');
										sml('https://vk.patii.uk','https://s8.hostingkartinok.com/uploads/images/2018/01/189c7d233d0e6edf49cdd0ef711a8046.png'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php footer(1)?>
	</body>
</html>