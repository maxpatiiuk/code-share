<!DOCTYPE html>
<html>
	<head>
		<?php
		global $res,$row;
		require_once 'main.php';
		que('SELECT * FROM '._POSTS_.' WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
		$pRow=mysql_fetch_array($res);
		head(0,1,$pRow['name'],1);
		function isInjected($str){ return preg_match('/(union|select|delete|insert|alter|drop)/',strtolower($str)); }
		function validLight($str){ return preg_match('/^[^%\*@#\^<>&\{\}\|\\\\\/\[\]]{1,500}$/',$str); }
		?>
		<style>
			.commentImg {
				border-radius: 100vw;
				background-repeat: no-repeat;
				background-size: 100% 100%;
				padding-top: 8.33333333%;
				overflow: hidden;
				background-size: auto 100%;
				background-position: center;
			}
			.comment {
				padding-top: 10px;
			}
			.commentsH {
				display: none;
			}
		</style>
	</head>
	<body>
		<?php top(1);
		$cr=$pRow['creator_name'];
		if(_ID_!=$cr){
			if(!$pRow['views'])
				$pRow['views']=0;
			que('UPDATE '._POSTS_.' SET views="'.($pRow['views']+1).'" WHERE id="'.$pRow['id'].'"');
		}
		$a = array('/\\\\\\|\\//','/&#60;/','/&#62;/','/&#34;/','/&#32;/','/<img="/','/"c="/','/"img>/','/<vid="/','/"vid>/','/<aud="/','/mp3",fil"/','/ogg",fil"/','/wav",fil"/','/mp3"fil>/','/ogg"fil>/','/wav"fil>/','/\.mp3/','/"aud>/','/\.ogg/','/\.wav/','/<fil="/','/",fil"/','/"fil>/','/mp23/','/og2g/','/wa2v/');
		$b = array('','<','>','"',"'",'<img src="'.LINK.'p/'.$pRow['link'].'/','" class="','">','<div align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/','?rel=0&amp;controls=0" frameborder="0" allowfullscreen></iframe></div>','<br><br><audio style="width:-webkit-fill-available;"controls><source src="'.LINK.'p/'.$pRow['link'].'/','mp23",fil"','og2g",fil"','wa2v",fil"','mp23"fil>','og2g"fil>','wa2v"fil>','.mp3" type="audio/mpeg"','></audio>','.ogg" type="audio/ogg"','.wav" type="audio/wav"','<br><a href="'.LINK.'p/'.$pRow['link'].'/','" download> Завантажити файл(',') </a><br>','mp3','ogg','wav');
		$content=preg_replace($a,$b,$pRow['content']);
		if($type>3)
			echo '<a style="color:#fff" class="btn btn-success" href="'.LINK.'adm/?a=editPost&id='.$pRow['id'].'">Редагувати пост</a><a style="color:#fff" class="btn btn-danger" href="'.LINK.'adm/?tab=5&r=deleted&id='.$pRow['id'].'">Видалити пост</a><br>';
		que('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$cr.'"');
		$row=mysql_fetch_array($res);
		if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
			$creator_name=$row['u_name'].' '.$row['u_surname'];
		else
			$creator_name=str_rot13($row['login']);
		$srr=getAva($row['login']);
		echo '<h1>'.$pRow['name'].'</h1><p>Категорія: '.$pRow['category'].'</p><hr> '.$content.'
		</div><br><hr>
		<a style="display: block;height: 50px;"href="'.LINK.'profile/?id='.$cr.'">
			<div class="chip">
  		<img class="l" src="'.$srr.'">
  		'.$creator_name.' / '.$pRow['date'].'
			</div>
		</a>
		<p class="text-right">Перегляди: '.$pRow['views'].'</p>
		<br><hr>';?>

		<div id="feedback">
			<a id="feedbackLink"></a>
			<h2 class="customizedH">Коментарі</h2>
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
					que('SELECT comments FROM '._POSTS_.' WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
					$row=mysql_fetch_array($res);
					$dt = new DateTime("now", new DateTimeZone('Europe/Kiev'));
					$dt->setTimestamp(time());
					$row['comments']=$buf.'^>'.$_POST['userCommentText'].'^>'.$dt->format('d.m.Y в H:i').'>^'.$row['comments'];
					que('UPDATE '._POSTS_.' SET comments="'.$row['comments'].'" WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
					header('Location: '."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'?comment=success');
				}
			}
			?>
			<form action="index.php#feedbackLink" method="post" class="comment row">
				<div class="col-xs-2 commentImg" style="background-image:url(<?php
					if(_ID_!=-1 && getAva($row['login'])!=_DEAFULT_AVA_)
						echo getAva($row['login']);
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
			<?php que('SELECT comments FROM '._POSTS_.' WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
				$row = mysql_fetch_array($res);
				$comments=explode('>^',$row['comments']);
				for($i=0;$comments[$i]!=NULL;$i++){
					if($i===5)
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
					echo '<div class="alert alert-info">Будьте першим, хто прокоментує цей пост!</div>';
				else if($i>=5){
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
		<?php echo '</div>';
		down();?>
	</body>
<html>