<!DOCTYPE html>
<html>
	<head>
		<?php
		global $res,$row;
		require_once 'main.php';
		que('SELECT * FROM '._POSTS_.' WHERE link="'.preg_replace('/["\*\$\^\']/', '', $dir).'"');
		$pRow=mysql_fetch_array($res);
		head(0,1,$pRow['name'],1);
		?>
	</head>
	<body>
		<?php top(1);
		$cr=$pRow['creator_name'];
		if(_ID_!=$cr){
			if(!$pRow['views'])
				$pRow['views']=0;
			que('UPDATE '._POSTS_.' SET views="'.($pRow['views']+1).'" WHERE id="'.$pRow['id'].'"');
		}
		if($url==1)
			$url='p/m';
		else
			$url='p';
		$a = array('/\\\\\\|\\//','/&#60;/','/&#62;/','/&#34;/','/&#32;/','/<img="/','/"c="/','/"img>/','/<vid="/','/"vid>/','/<aud="/','/mp3",fil"/','/ogg",fil"/','/wav",fil"/','/mp3"fil>/','/ogg"fil>/','/wav"fil>/','/\.mp3/','/"aud>/','/\.ogg/','/\.wav/','/<fil="/','/",fil"/','/"fil>/','/mp23/','/og2g/','/wa2v/');
		$b = array('','<','>','"',"'",'<img src="'.LINK.$url.'/'.$pRow['link'].'/','" class="','">','<div align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/','?rel=0&amp;controls=0" frameborder="0" allowfullscreen></iframe></div>','<br><br><audio style="width:-webkit-fill-available;"controls><source src="'.LINK.$url.'/'.$pRow['link'].'/','mp23",fil"','og2g",fil"','wa2v",fil"','mp23"fil>','og2g"fil>','wa2v"fil>','.mp3" type="audio/mpeg"','></audio>','.ogg" type="audio/ogg"','.wav" type="audio/wav"','<br><a href="'.LINK.$url.'/'.$pRow['link'].'/','" download> Завантажити файл(',') </a><br>','mp3','ogg','wav');
		$content=preg_replace($a,$b,$pRow['content']);
		if($type==2)
			echo '<a style="color:#fff" class="btn btn-success" href="'.LINK.'adm/materials.php?a=editPost&id='.$pRow['id'].'">Редагувати пост</a><a style="color:#fff" class="btn btn-danger" href="'.LINK.'adm/materials.php?tab=5&r=deleted&id='.$pRow['id'].'">Видалити пост</a><br>';
		que('SELECT login,u_name,u_surname FROM '._USERS_.' WHERE id="'.$cr.'"');
		$row=mysql_fetch_array($res);
		if(strlen($row['u_name'])>1 && strlen($row['u_surname'])>1)
			$creator_name=$row['u_name'].' '.$row['u_surname'];
		else
			$creator_name=str_rot13($row['login']);
		$lsrc=LINK.'images/p/'.str_rot13($row['login']).'.';
		if (@getimagesize($lsrc.'jpg'))
			$srr=$lsrc.'jpg';
		else if (@getimagesize($lsrc.'png'))
			$srr=$lsrc.'png';
		else if (@getimagesize($lsrc.'tiff'))
			$srr=$lsrc.'tiff';
		else if (@getimagesize($lsrc.'gif'))
			$srr=$lsrc.'gif';
		else
			$srr="https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";
		echo '<h1>'.htmlspecialchars_decode($pRow['name']).'</h1>';
		if(strlen($pRow['category'])>1)
			echo '<p>Категорія: '.$pRow['category'].'</p>';
		echo '<hr> '.$content.'
		</div><br><hr>
		<a href="'.LINK.'profile/?id='.$cr.'">
			<div class="chip">
  		<img class="l" src="'.$srr.'">
  		'.$creator_name.' / '.$pRow['date'].'
			</div>
		</a>
		<p class="text-right">Перегляди: '.$pRow['views'].'</p>';
		echo '</div>';
		down();?>
	</body>
<html>