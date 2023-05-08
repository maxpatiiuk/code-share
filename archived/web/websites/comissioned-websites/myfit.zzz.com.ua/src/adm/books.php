<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			head('Адміністування',NULL,'Адміністування',1); ?>
		<script src="https://cdn.ckeditor.com/4.9.2/full-all/ckeditor.js"></script>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1); ?>
		<div class="clearContainer1">
		<div class="container">
			<div class="row">
				<div class="col-xs-12"> <?php
					if(_TYPE_!=2){
						alert('Доступ заборонений','danger');
						exit();
					}

					//helper functions for formatting inputs
					function pre($name,$mainName){
						if(!$mainName)
							$mainName = $name;
						echo '<div class="form-group">
							<label class="control-label col-sm-2" title="'.ucfirst($mainName).'" for="'.$name.'">'.ucfirst($mainName).':</label>
							<div class="col-sm-10">';
					}
					function past(){
						echo '</div></div>';
					}

					//if want to add
					if($_GET['action']=='add'){ ?>
						<form action="?ready=created" method="post" enctype="multipart/form-data">
							<?php pre('name','Назва'); ?>
								<input type="text" name="name" class="form-control" id="name" required>
							<?php past(); pre('auth','Автор'); ?>
								<input type="text" name="auth" class="form-control" id="auth" required>
							<?php past(); pre('price','Ціна'); ?>
								<input type="number" name="price" class="form-control" id="number" required>
							<?php past(); pre('contents','Короткий опис'); ?>
								<textarea class="form-control" name="contents" id="contents" required></textarea>
							<?php past(); pre('content','Опис'); ?>
								<textarea class="form-control" name="content" id="content" required></textarea>
							<?php past(); pre('file','Фото'); ?>
								<input type="file"name="img" id="file" required>
							<?php past(); ?>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Додати" class="form-control btn">
								</div>
							</div>
						</form> <?php
					}

					//if want to edit
					else if($_GET['action']=='edit' && is_numeric($_GET['id'])){
						que('SELECT name1,o01,o02,comments,price1,limed FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
						$row = mysql_fetch_assoc($res); ?>
						<form action="?ready=edited&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
							<?php pre('name','Назва'); ?>
								<input type="text" name="name" class="form-control" id="name" value="<?=$row['name1']?>" required>
							<?php past(); pre('auth','Автор'); ?>
								<input type="text" name="auth" class="form-control" id="auth" value="<?=$row['limed']?>" required>
							<?php past(); pre('price','Ціна'); ?>
								<input type="number" name="price" class="form-control" id="number" value="<?=$row['price1']?>" required>
							<?php past(); pre('contents','Короткий опис'); ?>
								<textarea class="form-control" name="contents" id="contents" required><?=$row['o02']?></textarea>
							<?php past(); pre('content','Довгий опис'); ?>
								<textarea class="form-control" name="content" id="content" required><?=$row['o01']?></textarea>
					 	<?php past(); pre('file','Зображення'); 
								if(@getimagesize(LINK.'/images/t/i'.$_GET['id'].'.'.$row['comments']))
										echo '<img class="preview" src="'.LINK.'/images/t/i'.$_GET['id'].'.'.$row['comments'].'"><br>'; ?>
								<br><input type="file" name="img" accept="image/*" id="file">
						 <?php past(); ?>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-9">
									<input type="submit" value="Радагувати" class="btn btn-success">
									<a href="<?=LINK?>adm/books.php" class="btn btn-warning">Скасувати</a>
									<a href="<?=LINK.'adm/books.php?d='.$_GET['id']?>" class="btn btn-danger ">Видалити</a>
								</div>
							</div>
						</form> <?php
					}
					else {
						//deleting by id
						function del($id){
							que('SELECT comments FROM '._PRODUCTS_.' WHERE cat=-1 AND keyVal='.$id);
							$row = mysql_fetch_assoc($res);
							unlink(LINK.'images/t/i'.$id.'.'.$row['comments']);
							que('DELETE FROM '._PRODUCTS_.' WHERE cat=-1 AND keyVal='.$id);
							alert('Успішно видалено','success');
						}

						//if delete button clicked
						if(is_numeric($_GET['d']))
							del($_GET['d']);

						//if create post form submitted
						if($_GET['ready']=='created'){

							//inserting data
							que('INSERT INTO '._PRODUCTS_.'(name1,o01,o02,comments,cat,unixTime,price1,limed) VALUES("'.$_POST['name'].'","'.htmlspecialchars($_POST['content']).'","'.htmlspecialchars($_POST['contents']).'","'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION).'",-1,'.time().',"'.$_POST['price'].'","'.$_POST['auth'].'")');

							//saving file
							move_uploaded_file($_FILES['img']['tmp_name'],'../images/t/i'.mysql_insert_id().'.'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
						}

						//if edit post form submitted
						if($_GET['ready']=='edited' && is_numeric($_GET['id'])){

							//if file was uploaded
							if($_FILES['img']['size']>0){

								//if size less than 3mb, save file
									$bufSql=', comments="'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION).'"';

									//Delete file with same name if exist
									que('SELECT comments FROM '._PRODUCTS_.' WHERE cat=-1 AND keyVal='.$_GET['id']);
									$row = mysql_fetch_assoc($res);
									unlink('../images/t/i'.$_GET['id'].'.'.$row['comments']);

									move_uploaded_file($_FILES['img']['tmp_name'],'../images/t/i'.$_GET['id'].'.'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
							}

							//inserting data
							que('UPDATE '._PRODUCTS_.' SET name1="'.htmlspecialchars($_POST['name']).'", o01="'.htmlspecialchars($_POST['content']).'", o02="'.htmlspecialchars($_POST['contents']).'", price1="'.$_POST['price'].'", limed="'.$_POST['auth'].'"'.$bufSql.' WHERE keyVal='.$_GET['id']);
						} ?>
						
						<div><a href="?action=add" class="btn btn-goldi">Додати</a><br></div>
						<div class="row"> <?php
							que('SELECT keyVal AS id,o02,name1,price1,comments,limed FROM '._PRODUCTS_.' WHERE cat=-1');
							while($row=mysql_fetch_assoc($res)){
								echo '<div class="col-xs-12 col-sm-6 col-md-4 books">
									<div class="row">
										<div class="col-xs-4 imageContainer" style="background-image:url('.LINK.'images/t/i'.$row['id'].'.'.$row['comments'].')"></div>
										<div class="col-xs-8">
											<a href="?action=edit&id='.$row['id'].'"><h2>'.$row['name1'].'</h2></a>
											<span><i>'.$row['limed'].'</i></span>
											<p>'.$row['o02'].'</p>
											<span>'.$row['price1'].'грн</span>
										</div>
									</div>
								</div>';
							}
						echo '</div>';
					} ?>
				</div>
			</div>
		</div>
		</div>
	</body>
</html>