<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../functions/main.php';
			head();
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(1);
		if(_TYPE_==2){
			if($_GET['a']=='add'){ ?>
				1 - UA<br>2 - RU<br>
				<form method="post" action="?r=added" class="form-horizontal" enctype="multipart/form-data"> <?php
					a2input('Назва1','name1',0,1);
					a2input('Назва2','name2',0,1);
					a2input('Опис1 1','o01',3,1);
					a2input('Опис1 2','o02',3,1); ?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4file">Фото:</label>
						<div class="col-sm-9">
							<input id="a2file" type="file" name="img">
						</div>
					</div>
					<div class="form-group">
						<input type="submit" value="Додати" class="col-sm-offset-2 btn btn-success">
						<a href="options.php" class="btn btn-warning">Скасувати зміни</a>
					</div>
				</form> <?php
			}
			else if($_GET['a']=='edit' && is_numeric($_GET['id'])){
				que('SELECT name1,name2,price1,o01,o02 FROM '._PRODUCTS_.' WHERE unixTime='.$_GET['id']);
				$row=mysql_fetch_assoc($res); ?>
				1 - UA<br>2 - RU<br>
				<form method="post" action="?r=edited&id=<?=$_GET['id']?>" class="form-horizontal" enctype="multipart/form-data"> <?php
					a2input('Назва 1','name1',0,1,$row['name1']);
					a2input('Назва 2','name2',0,1,$row['name2']);
					a2input('Опис1 1','o01',3,1,$row['o01']);
					a2input('Опис1 2','o02',3,1,$row['o02']); ?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4file">Фото:</label>
						<div class="col-sm-9">
							<input id="a2file" type="file" name="img">
							<img src="../images/f<?=$_GET['id'].'.'.$row['price1']?>" alt="Img preview" style="max-width:300px">
						</div>
					</div>
					<div class="form-group">
						<input type="submit" value="Зберегти зміни" class="btn btn-success col-sm-offset-2"> 
						<a href="?d=<?=$_GET['id']?>" class="btn btn-danger">Видалити</a> 
						<a href="options.php" class="btn btn-warning">Скасувати зміни</a>
					</div>
				</form> <?php
			}
			else {
				if(is_numeric($_GET['d'])){
					que('SELECT price1 FROM '._PRODUCTS.' WHERE unixTime='.$_GET['d']);
					$row=mysql_fetch_assoc($res);
					unlink('../images/f'.$_GET['d'].'.'.$row['price1']);
					que('DELETE FROM '._PRODUCTS_.' WHERE unixTime='.$_GET['d']);
					alert('Видалено успішно','success');
				}
				if($_GET['r']=='added'){
					$time=time();
					if($_FILES['img']['size']>0){
						if(strpos($_FILES['img']['type'],'image')!==FALSE){
							if($_FILES['img']['size']<1024*1024*3)
								move_uploaded_file($_FILES['img']['tmp_name'],'../images/f'.$time.'.'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
							else
								alert('Зображення надто велике','danger');
						}
						else
							alert('Невідоме розширення зображення','danger');
					}
					que('INSERT INTO '._PRODUCTS_.'(id,name1,name2,price1,unixTime,o01,o02) VALUES(-1,"'.$_POST['name1'].'","'.$_POST['name2'].'","'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION).'",'.$time.',"'.$_POST['o01'].'","'.$_POST['o02'].'")');
					alert('Додано!','success');
				}
				if($_GET['r']=='edited' && is_numeric($_GET['id'])){
					que('SELECT price1 FROM '._PRODUCTS_.' WHERE unixTime='.$_GET['id']);
					$row=mysql_fetch_assoc($res);
					if($_FILES['img']['size']>0){
						if(strpos($_FILES['img']['type'],'image')!==FALSE){
							if($_FILES['img']['size']<1024*1024*3){
								unlink('../images/f'.$_GET['id'].'.'.$row['price1']);
								$e=pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
								move_uploaded_file($_FILES['img']['tmp_name'],'../images/f'.$_GET['id'].'.'.$e);
							}
							else
								alert('Зображення надто велике','danger');
						}
						else
							alert('Невідоме розширення зображення','danger');
					}
					if(!$e)
						$e=$row['price1'];
					que('UPDATE '._PRODUCTS_.' SET name1="'.$_POST['name1'].'",name1="'.$_POST['name1'].'",price1="'.$e.'",o01="'.$_POST['o01'].'",o02="'.$_POST['o02'].'" WHERE id=-1 AND unixTime='.$_GET['id']);
					alert('Змінено!','success');
				}
				que('SELECT unixTime,name1 FROM '._PRODUCTS_.' WHERE id=-1');
				while($row=mysql_fetch_assoc($res)){ ?>
					<a href="?a=edit&id=<?=$row['unixTime']?>" class="show"><?=$row['name1']?></a> <?php
				}
				echo '<br><a href="?a=add" class="btn btn-success">Додати</a>';
			}
		}
		else
			alert('Доступ заборонено','danger');
		footer(1) ?>
	</body>
</html>