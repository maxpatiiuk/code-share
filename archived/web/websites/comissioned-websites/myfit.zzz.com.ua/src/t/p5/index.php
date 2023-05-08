<!DOCTYPE html>
<html lang="uk">
	<head>
		<?php
			$file='https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			include '../../functions/main.php';
			head('Замовити книгу');
		?>
		<link href="<?=LINK?>css/others.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php top(0,1,3)?>
		<div class="clearContainer1">
			<div class="container">
				<div class="row">
					<div class="col-xs-12"><?php
						if(is_numeric($_GET['view'])){ ?>
							<div class="btn-group" style="padding-left: 15px;padding-bottom: 15px;"><?php
								if(_TYPE_==2)
									echo '<a href="'.LINK.'adm/books.php?action=edit&id='.$_GET['view'].'" class="btn btn-goldi">Редагувати</a>'; ?>
							</div> <?php
							que('SELECT id,name1,price1,o01,comments,limed FROM '._PRODUCTS_.' WHERE cat=-1 AND keyVal='.$_GET['view']);
							$row=mysql_fetch_assoc($res);
							echo '<div class="row books booksView">
								<div class="col-xs-12 col-sm-6">
									<div class="imageContainer" style="background-image:url('.LINK.'images/t/i'.$_GET['view'].'.'.$row['comments'].'")">
										<span class="price">'.$row['price1'].' грн</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6">
									<h2 class="text-center">'.$row['name1'].'</h2><br>
												<span><i>Автор: '.$row['limed'].'</i></span>
									<div id="appendableBuyForm"></div>
									<p class="text-justify">'.$row['o01'].'</p>
									<a class="buyButton" id="buyButton">Замовити</a>
								</div>'; ?>
								<script>
									$('#buyButton').click(function(){
										$(`<form method="post" id="orderForm" action="?order=<?=$_GET['view']?>">
													<input type="email" name="email" required class="form-control" placeholder="E-mail">
													<button type="submit" class="btn btn-goldi">Замовити</button>
											</form><br>`).insertAfter(this);
										$(this).remove();
									})
								</script>
								<?php
						}
						else {
							if(is_numeric($_GET['order'])){
								que('SELECT name1,price1 FROM '._PRODUCTS_.' WHERE cat=-1 AND  keyVal="'.$_GET['order'].'"');
								$row = mysql_fetch_assoc($res);
								mail(/*_EMAIL_*/'max@patii.uk','Нове замовлення',"Нове замовлення в ".LINK."!\nE-mail: ".$_POST['email']."\nКнига: ".$row['name1']."\nЦіна книги: ".$row['price1']);
								alert('Замовлення успішно надіслано. Очікуйте повідомлення на електронну пошту найблищим часом','success');
							}
							if(_TYPE_==2)
							 echo '<a href="'.LINK.'adm/books.php" class="btn btn-goldi">Редагувати</a>'; ?>
							<div class="row"> <?php
								que('SELECT keyVal AS id,name1,price1,comments,o02,limed FROM '._PRODUCTS_.' WHERE cat=-1');
								while($row=mysql_fetch_assoc($res)){
									echo '<div class="col-xs-12 col-sm-6 col-md-4 books">
										<div class="row">
											<a href="?view='.$row['id'].'" class="col-xs-4 imageContainer" style="background-image:url('.LINK.'images/t/i'.$row['id'].'.'.$row['comments'].')"></a>
											<div class="col-xs-8">
												<a href="?view='.$row['id'].'"><h2>'.$row['name1'].'</h2></a>
												<span><i>Автор: '.$row['limed'].'</i></span>
												<p>'.$row['o02'].'</p>
											</div>
											<div class="price2">'.$row['price1'].' грн</div>
										</div>
									</div>';
								}
							} ?>
						</div>
				</div>
			</div>
		</div>
	</body>
</html>