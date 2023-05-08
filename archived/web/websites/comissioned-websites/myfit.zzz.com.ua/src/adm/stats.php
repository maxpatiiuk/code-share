<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			head(NULL,NULL,'Адміністування',1);
			global $row,$res;
		?>
	</head>
	<body>
		<?php top(0,1);
		echo '<div class="clearContainer1"><div class="container">';
		function uploadImg($name,$name2=0){
			global $extentions;
			foreach($extentions as $e)
				unlink(LINK.'images/gif.'.$e);
			if(!$name2)
				$name2=$name;
			if($_FILES[$name]['size']>0){
				if(strpos($_FILES[$name]['type'],'image')!==FALSE){
					if($_FILES[$name]['size']<1024*1024*10){
						foreach (array('jpeg','png','JPG','jfjf','jpg','tiff','gif','bmp','gif') as $val)
							unlink('../images/'.$name2.'.'.$val);
						move_uploaded_file($_FILES[$name]['tmp_name'],'../images/'.$name2.'.'.pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
					}
					else
						alert('Зображення надто велике','danger');
				}
				else
					alert('Невідомий формат зображення','danger');
			}
		}
		$statsArray=array(
			array('Логотип сайту','logo','2','Рекомендований розмір: 600x374'),
			array('Фон блоків','bb','2','Рекомендований розмір: 1920x1080'),
			array('Пошукові системи'),
			array('Теги','keywords1','0','Пошукові запити за якими вас будуть шукати. Вводити через кому'),
			array('Контакти'),
			array('Facebook','fblink'),
			array('Twiter','twlink'),
			array('Instagram','inlink'),
			array('Pinterest','pilink'),
			array(' '),
			array('Телефон 1','tel11'),
			array('Телефон 2','tel21'),
			array('Email1','email1'),
			array('Адреса/вулиця','adress1'),
			array('Банер Спорт Релакс','srn','2','Рекомендований розмір: 600x300'),
			array('Головна сторінка'),
			array('Велике фото','bg','2','Фото першого блоку. Рекомендований розмір: 1920x1080'),
			array('Стиснуте фото','sb','2','Фото першого блоку, для малих екранів. Рекомендований розмір: 900x1193'),
			array(' '),
			array('Мотивуючий вираз 1','q1'),
			array('Мотивуючий вираз 2','q2'),
			array('Мотивуючий вираз 3','q3'),
			array('Мотивуючий вираз 4','q4'),
			array('Товари'),
			array('Заголовок 1','h4'),
			array('Опис 1','h5','1'),
			array('Фото 1','shop1_','2','Рекомендований розмір: 214x114'),
			array(' '),
			array('Заголовок 2','h6'),
			array('Опис 2','h7','1'),
			array('Фото 2','shop2_','2','Рекомендований розмір: 214x114'),
			array(' '),
			array('Заголовок 3','h8'),
			array('Опис 3','h9','1'),
			array('Фото 3','shop3_','2','Рекомендований розмір: 214x114'),
			array(' '),
			array('Заголовок 4','h10'),
			array('Опис 4','h11','1'),
			array('Фото 4','shop4_','2','Рекомендований розмір: 214x114'),
			array(' '),
			array('Заголовок 5','h12'),
			array('Опис 5','h13','1'),
			array('Фото 5','shop5_','2','Рекомендований розмір: 214x114'),
			array(' '),
			array(' '),
			array('Фото','ph1','2'),
			array('Заголовок','h2'),
		);
		if(_TYPE_!=2)
			alert('Доступ заборонений','danger');
		else {
			if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submitF'])){
				que('UPDATE '._PRODUCTS_.' SET o11="'.$_POST['about1'].'" WHERE id=0');
				que('UPDATE '._MV_.' SET value="'.$_POST['title1'].'" WHERE name="title1"');
				foreach ($statsArray as $stats){
					if($stats[2]==2)
						uploadImg($stats[1]);
					else if($stats[1]!=NULL)
						que('UPDATE '._MV_.' SET value="'.htmlspecialchars($_POST[$stats[1]]).'" WHERE name="'.htmlspecialchars($stats[1]).'"');
				}
			}
			echo '<form method="post" class="form-horizontal" enctype="multipart/form-data">
				<h2>Основне</h2>';
				que('SELECT value FROM '._MV_.' WHERE name="title1"');
				$row=mysql_fetch_array($res);
				a2input('Назва магазину','title1',0,1,$row['value']);
				que('SELECT value FROM '._MV_.' WHERE name="title2"');
				$row=mysql_fetch_array($res);
				que('SELECT o11,o12 FROM '._PRODUCTS_.' WHERE id=0');
				$row=mysql_fetch_array($res);
				a2input('Про '._NAME_,'about1',3,0,$row['o11']);
				function a2photo($text,$nane){
					echo '<div class="form-group">
						<label class="control-label col-sm-2" for="a2'.$nane.'">'.$text.':</label>
						<div class="col-sm-10">
							<input id="'.$nane.'" type="file" accept="image/*" name="'.$nane.'">
						</div>
					</div>';
				}
				foreach ($statsArray as $stats) {
					if($stats[0]==' ')
						echo '<br><br>';
					else if($stats[1]==NULL && $stats[0]!=NULL)
						echo '<h2>'.$stats[0].'</h2>';
					else if($stats[2]==2)
						a2photo($stats[0],$stats[1]);
					else {
						que('SELECT value FROM '._MV_.' WHERE name="'.$stats[1].'"');
						$row=mysql_fetch_array($res);
						if($stats[2]==1)
							$buf=3;
						else
							$buf=0;
						a2input($stats[0],$stats[1],$buf,0,$row['value']);
					}
					if($stats[3]!=NULL)
						echo '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">'.$stats[3].'</div></div>';
				}
				echo '<div class="col-sm-offset-2"><input type="submit" name="submitF" id="submitF" class="btn btn-goldi" value="Зберегти зміни"></div>
			</form>';
		} ?>
	</div>
	<?php footer() ?>
	</div>
	</body>
</html>