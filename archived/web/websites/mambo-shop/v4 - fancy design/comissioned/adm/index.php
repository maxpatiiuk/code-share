<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			head(NULL,NULL,'Адміністування',1);
			global $row,$res;
		?>
		<link href="<?=LINK?>css/style.css" rel="stylesheet" type="text/css">
		<style>
			.productImg img {
				width: 100%;
				max-width: unset;
			}
			img.special {
				width: 32px;
				height: 32px;
				margin: 0 5px;
			}
			table input {
				margin: 0 auto !important;
				display: block;
			}
		</style>
	</head>
	<body>
		<?php top(1);
		function uploadImg($name,$where,$id=NULL,$del=1){
			if($del)
				array_map('unlink', glob($where.$name.'.*'));
			if($_FILES[$name]['size']>0){
				if(strpos($_FILES[$name]['type'],'image')!==FALSE){
					if($_FILES[$name]['size']<1024*1024*10){
						if(!$id)
							$id=$name;
						move_uploaded_file($_FILES[$name]['tmp_name'],$where.$id.'.'.pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
						return 1;
					}
					else 
						alert('Зображення надто велике. Максимальний розмір - 10 мб','danger');
				}
				else
					alert('Завантажити можна лише зображення','danger');
			}
			return 0;
		}
		if(_TYPE_!=2)
			alert('Доступ заборонений','danger');
		else if(isset($_GET['a'])){
			$a=$_GET['a'];
			if($a=='addProduct'){
				?><br><form action="<?=LINK?>adm/?r=created" enctype="multipart/form-data" method="post"><?php
					a2input('Назва1','name1');
					a2input('Назва2','name2');
					a2input('Назва3','name3');
					a2input('Назва4','name4');
					a2input('Ціна1','price1');
					a2input('Ціна2','price2');
					a2input('Ціна3','price3');
					a2input('Ціна4','price4');
					a2input('Опис1 1','o01',3);
					a2input('Опис1 2','o02',3);
					a2input('Опис1 3','o03',3);
					a2input('Опис1 4','o04',3);
					a2input('Опис2 1','o11',3);
					a2input('Опис2 2','o12',3);
					a2input('Опис2 3','o13',3);
					a2input('Опис2 4','o14',3);
					a2input('Категорія1','cat1');
					a2input('Категорія2','cat2');
					a2input('Категорія3','cat3');
					a2input('Категорія4','cat4');
					?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4add2menu">Добавити товар в меню сайту:</label>
						<div class="col-sm-9">
							<input type="checkbox" name="add2menu" id="a4add2menu" checked>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4add2mainp">Добавити товар на головну сторінку сайту:</label>
						<div class="col-sm-9">
							<input type="checkbox" name="add2mainp" id="a4add2mainp" checked >
						</div>
					</div> <?php
					for($i=1;$i<4;$i++)
						echo '<div class="form-group uploadImage" style="clear: both">
							<label class="control-label col-sm-2" title="'.$i.'" for="a2i'.$i.'">I'.$i.':</label>
							<div class="col-sm-9">
								<input id="a2i'.$i.'" type="file" accept="image/*" name="i'.$i.'">
								<button onclick="$(this).closest(\'.form-group\').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
							</div>
						</div>'; ?>
						<div class="appendableDiv"></div>
						<div class="form-group">
							<div class="col-sm-9 col-xs-offset-2">
								<button type="button" class="btn btn-goldi" onclick="addImg()">Додати зображення</button>
								<input type="hidden" id="lastImg" name="lastImg" value="3">
							</div>
						</div>
						<script>
							function addImg(){
								last=$('.uploadImage label').last().attr('title');
								if(isNaN(last))
									last=0;
								last++;
								$('.appendableDiv').append(`<div class="form-group uploadImage" style="clear: both">
									<label class="control-label col-sm-2" title="`+last+`" for="a2i`+last+`">I`+last+`:</label>
									<div class="col-sm-9">
										<input id="a2i`+last+`" type="file" accept="image/*" name="i`+last+`">
										<button onclick="$(this).closest('.form-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
									</div>
								</div>`);
								$('#lastImg').val(last);
							}
						</script>
					<div style="clear:both"></div>
					<div class="btn-group">
						<a style="color:#fff;" href="<?=LINK?>adm" class="btn btn-goldi">Скасувати</a>
						<button type="submit" class="btn btn-goldi">Створити продукт</button>
					</div>
				</form>
				<?php
			}
			else if($a=='editProduct' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
				que('SELECT * FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$row=mysql_fetch_array($res);
				?><br><form action="<?=LINK?>adm/?r=edited&id=<?=$_GET['id']?>" enctype="multipart/form-data" method="post"><?php
					a2input('Name1','name1',0,0,$row['name1']);
					a2input('Name2','name2',0,0,$row['name2']);
					a2input('Name3','name3',0,0,$row['name3']);
					a2input('Name4','name4',0,0,$row['name4']);
					a2input('Price1','price1',0,0,$row['price1']);
					a2input('Price2','price2',0,0,$row['price2']);
					a2input('Price3','price3',0,0,$row['price3']);
					a2input('Price4','price4',0,0,$row['price4']);
					a2input('Опис1 1','o01',3,0,$row['o01']);
					a2input('Опис1 2','o02',3,0,$row['o02']);
					a2input('Опис1 3','o03',3,0,$row['o03']);
					a2input('Опис1 4','o04',3,0,$row['o04']);
					a2input('Опис2 1','o11',3,0,$row['o11']);
					a2input('Опис2 2','o12',3,0,$row['o12']);
					a2input('Опис2 3','o13',3,0,$row['o13']);
					a2input('Опис2 4','o14',3,0,$row['o14']);
					a2input('Категорія1','cat1',0,0,$row['cat1']);
					a2input('Категорія2','cat2',0,0,$row['cat2']);
					a2input('Категорія3','cat3',0,0,$row['cat3']);
					a2input('Категорія4','cat4',0,0,$row['cat4']);
					?>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4add2menu">Добавити товар в меню сайту:</label>
						<div class="col-sm-9">
							<input type="checkbox" name="add2menu" id="a4add2menu" <?php if($row['add2menu']) echo 'checked';?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a4add2mainp">Добавити товар на головну сторінку сайту:</label>
						<div class="col-sm-9">
							<input type="checkbox" name="add2mainp" id="a4add2mainp" <?php if($row['add2mainp']) echo 'checked';?>>
						</div>
					</div> <?php
					for($i=1;1;$i++){
						$src=getAva(0,LINK.'p/a'.$row['unixTime'].'/i'.$i.'.',0);
						if($src===0)
							break; ?>
						<div class="form-group uploadImage">
							<label class="control-label col-sm-2" title="<?=$i?>" for="a2i<?=$i?>">I<?=$i?>:</label>
							<div class="col-sm-9">
								<input id="a2i<?=$i?>" type="file" accept="image/*" name="i<?=$i?>">
								<img src="<?=$src?>" alt="img<?=$i?>" style="width: 30%;max-height:300px;">
								<button onclick="$(this).closest('.form-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
							</div>
						</div>  <?php
					} ?>
					<div class="appendableDiv"></div>
					<div class="form-group" style="clear: both">
						<div class="col-sm-9 col-xs-offset-2">
							<button type="button" class="btn btn-goldi" onclick="addImg()">Додати зображення</button>
							<input type="hidden" id="lastImg" name="lastImg" value="<?=$i?>">
						</div>
					</div>
					<div style="clear:both"></div>
					<div class="btn-group">
						<a style="color:#fff;" href="<?=LINK?>adm" class="btn btn-goldi">Скасувати</a>
						<a style="color:#fff;" href="<?=LINK?>adm/?r=deleted&id=<?=$_GET['id']?>" class="btn btn-goldi">Видалити товар</a>
						<a style="color:#fff;" target="_blank" href="<?=LINK?>p/a<?=$row['unixTime']?>/" class="btn btn-goldi">Переглянути</a>
						<button type="submit" class="btn btn-goldi">Зберегти зміни</button>
					</div>
					<script>
						function addImg(){
							last=$('.uploadImage label').last().attr('title');
							if(isNaN(last))
								last=0;
							last++;
							$('.appendableDiv').append(`<div class="form-group uploadImage" style="clear: both">
								<label class="control-label col-sm-2" title="`+last+`" for="a2i`+last+`">I`+last+`:</label>
								<div class="col-sm-9">
									<input id="a2i`+last+`" type="file" accept="image/*" name="i`+last+`">
									<button onclick="$(this).closest('.form-group').remove();" type="button" class="r btn btn-danger btn-xs">X</button>
								</div>
							</div>`);
							if(last>$('#lastImg').val())
								$('#lastImg').val(last);
						}
					</script>
				</form>
				<?php
			}
		}
		else {
			$u=0;
			$res=NULL;
			if($_GET['r']=='deleted' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
				que('SELECT unixTime FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$row=mysql_fetch_array($res);
				array_map('unlink', glob('../p/a'.$row['unixTime'].'/*.*'));
				rmdir('../p/a'.$row['unixTime'].'/');
				que('DELETE FROM '._PRODUCTS_.' WHERE unixTime="'.$row['unixTime'].'"');
				alert('Продукт успішно видалено','success');
			}
			if($_GET['r']=='created'){
				if(isset($_POST['name1']) && isset($_POST['o01']))
					que('SELECT name1 FROM '._PRODUCTS_.' WHERE name1="'.$_POST['name1'].'" AND o01="'.$_POST['o01'].'"');
				$u=mysql_num_rows($res);
				if($u==0){
					$path='a'.time();
					mkdir('../p/'.$path.'/');
					copy('../p/NO_DELETE/index.php','../p/'.$path.'/index.php');
					for($i=1,$realId=1;$i<=$_POST['lastImg'];$i++)
						if(uploadImg('i'.$i,'../p/'.$path.'/','i'.$realId,0))
							$realId++;
					if($_POST['add2menu']!='on')
						$_POST['add2menu']=0;
					else
						$_POST['add2menu']=1;
					if($_POST['add2mainp']!='on')
						$_POST['add2mainp']=0;
					else
						$_POST['add2mainp']=1;
					que('SELECT MAX(id) AS idd FROM '._PRODUCTS_);
					$row=mysql_fetch_array($res);
					$id=$row['idd']+1;
					que('INSERT INTO '._PRODUCTS_.' (id,name1,name2,name3,name4,price1,price2,price3,price4,o01,o02,o03,o04,o11,o12,o13,o14,unixTime,add2mainp,add2menu,cat1,cat2,cat3,cat4) values("'.$id.'","'.$_POST['name1'].'","'.$_POST['name2'].'","'.$_POST['name3'].'","'.$_POST['name4'].'","'.$_POST['price1'].'","'.$_POST['price2'].'","'.$_POST['price3'].'","'.$_POST['price4'].'","'.htmlspecialchars($_POST['o01']).'","'.htmlspecialchars($_POST['o02']).'","'.htmlspecialchars($_POST['o03']).'","'.htmlspecialchars($_POST['o04']).'","'.htmlspecialchars($_POST['o11']).'","'.htmlspecialchars($_POST['o12']).'","'.htmlspecialchars($_POST['o13']).'","'.htmlspecialchars($_POST['o14']).'","'.time().'","'.$_POST['add2mainp'].'","'.$_POST['add2menu'].'","'.$_POST['cat1'].'","'.$_POST['cat2'].'","'.$_POST['cat3'].'","'.$_POST['cat4'].'")');
					alert('Продукт успішно додано','success');
				}
			}
			else if($_GET['r']=='edited' && preg_match('/^[0-9]*$/',$_GET['id'])){
				que('SELECT unixTime FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$row=mysql_fetch_array($res);
				$path='a'.$row['unixTime'];
				for($i=1,$realId=1;$i<=$_POST['lastImg'];$i++){
					if(uploadImg('i'.$i,'../p/'.$path.'/','i'.$realId))
						$realId++;
				}
				if($_POST['add2menu']!='on')
					$_POST['add2menu']=0;
				else
					$_POST['add2menu']=1;
				if($_POST['add2mainp']!='on')
					$_POST['add2mainp']=0;
				else
					$_POST['add2mainp']=1;
				que('UPDATE '._PRODUCTS_.' SET name1="'.$_POST['name1'].'",name2="'.$_POST['name2'].'",name3="'.$_POST['name3'].'",name4="'.$_POST['name4'].'",price1="'.$_POST['price1'].'",price2="'.$_POST['price2'].'",price3="'.$_POST['price3'].'",price4="'.$_POST['price4'].'",o01="'.htmlspecialchars($_POST['o01']).'",o02="'.htmlspecialchars($_POST['o02']).'",o03="'.htmlspecialchars($_POST['o03']).'",o04="'.htmlspecialchars($_POST['o04']).'",o11="'.htmlspecialchars($_POST['o11']).'",o12="'.htmlspecialchars($_POST['o12']).'",o13="'.htmlspecialchars($_POST['o13']).'",o14="'.htmlspecialchars($_POST['o14']).'",add2mainp="'.$_POST['add2mainp'].'",add2menu="'.$_POST['add2menu'].'",cat1="'.$_POST['cat1'].'",cat2="'.$_POST['cat2'].'",cat3="'.$_POST['cat3'].'",cat4="'.$_POST['cat4'].'" WHERE keyVal="'.$_GET['id'].'"');
				alert('Продукт успішно змінено','success');
			} ?>
			<br><br><a href="index.php?a=addProduct">Додати товар</a> <?php
			que('SELECT * FROM '._PRODUCTS_.' WHERE id!=0 ORDER BY id+0'); ?>
			<div class="row"> <?php
				while($row=mysql_fetch_array($res)){
					echo '<a href="index.php?a=editProduct&id='.$row['keyVal'].'" class="product col-xs-6 col-sm-4 col-md-3">
						<div class="postImg">
							<img src="'.getAva(1,LINK.'p/a'.$row['unixTime'].'/i1.').'" alt="'.$row['name1'].'">
						</div>
						<div class="name">'.$row['name1'].'</div>
						<div class="productPrice">'.$row['price1'].getCurency().'</div>
					</a>';
				} ?>
			</div> <?php
		}
		footer(1);?>
	</body>
</html>