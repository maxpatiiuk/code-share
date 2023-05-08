<!DOCTYPE html>
<html>
	<head>
		<?php
			require_once '../functions/main.php';
			require_once '../functions/update.php';
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
		if(_TYPE_!=2)
			alert('Доступ заборонений','danger');
		else if(isset($_GET['a'])){
			$a=$_GET['a'];
			if($a=='addProduct'){
				?><br><form action="<?=LINK?>adm/?r=created" enctype="multipart/form-data" method="post">
					<a href="<?=_MAMBO_?>map/files/d3_13.php" target="_blank">Generate description</a><?php
					que('SELECT MAX(id) AS idd FROM '._PRODUCTS_);
					$row=mysql_fetch_array($res);
					a2input('ID','id',0,0,$row['idd']+1);
					a2input('Link','link');
					a2input('Oplata info Id','oil');
					a2input('Name','name');
					a2input('Keywords','kw');
					a2input('Youtube video','yt'); ?>
					<div class="form-group">
							<label class="control-label col-sm-2">Parameters:</label>
							<div class="col-sm-9">
								<table>
									<tbody><?php
										$pl=array(
											array("Windows Xp","wXP"),
											array("Windows 7","w7"),
											array("Windows 8","w8"),
											array("Windows 10","w10"),
											array("32 Bit","32b"),
											array("64 Bit","64b"),
											array("Linux","lin"),
											array("Mac Os","macX")
										);
										echo '<tr>';
											for($i=0;$pl[$i][0]!=NULL;$i++)
												echo '<th><label for="a2'.$pl[$i][1].'"><img class="special" src="'.LINK.'images/'.$pl[$i][1].'.png" alt="'.$pl[$i][0].'" title="'.$pl[$i][0].'"></label></th>';
										echo '</tr>
										<tr>';
											for($i=0;$pl[$i][0]!=NULL;$i++)
												echo '<th><input id="a2'.$pl[$i][1].'" name="'.$pl[$i][1].'" type="checkbox"></th>';
										echo '</tr>'; ?>
									</tbody>
								</table>
							</div>
						</div>
					<div class="form-group">
							<label class="control-label col-sm-2">Platform:</label>
							<div class="col-sm-9">
								<select name="platform" class="form-control">
									<option value="0">Nothing</option>
									<option value="1" selected>Steam</option>
									<option value="2">Mojang</option>
									<option value="3">Social Club</option>
									<option value="4">Origin</option>
									<option value="5">Uplay</option>
								</select><input type="text" class="form-control" name="customPlatform">
							</div>
						</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Language:</label>
						<div class="col-sm-9">
							<select name="language" class="form-control">
								<option value="0">Nothing</option>
								<option value="1" selected>English</option>
								<option value="2">Russian</option>
								<option value="3">Ukrainian</option>
							</select>
							<input type="text" class="form-control" name="customLanguage">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Product type:</label>
						<div class="col-sm-9">
							<select name="productType" class="form-control">
								<option value="0">Nothing</option>
								<option value="1">Acc</option>
								<option value="2">Gift link</option>
								<option value="3" selected>Key</option>
								<option value="4">Photo of key</option>
							</select>
							<input type="text" class="form-control" name="customProductType">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Developer:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="developer">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Publisher:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="publisher">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Year of relyse:</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="yearOfRelyse" value="2000" max="2100">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Gift:</label>
						<div class="col-sm-9">
							<select name="gift" class="form-control">
								<option value="0">Nothink</option>
								<option value="1">Random key</option>
								<option value="2">Gift</option>
								<option value="3">PromoCode</option>
								<option value="4">Account</option>
							</select>
							<input type="text" class="form-control" name="customGift">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a2i0">I0:</label>
						<div class="col-sm-9">
							<input id="a2i0" type="file" accept="image/*" name="i0">
						</div>
					</div>
					<div class="form-group" style="clear: both">
						<label class="control-label col-sm-2" for="a2i1">I1:</label>
						<div class="col-sm-9">
							<input id="a2i1" type="file" accept="image/*" name="i1">
						</div>
					</div>
					<div class="form-group" style="clear: both">
						<label class="control-label col-sm-2" for="a2i2">I2:</label>
						<div class="col-sm-9">
							<input id="a2i2" type="file" accept="image/*" name="i2">
						</div>
					</div>
					<div class="form-group" style="clear: both">
						<label class="control-label col-sm-2" for="a2i3">I3:</label>
						<div class="col-sm-9">
							<input id="a2i3" type="file" accept="image/*" name="i3">
						</div>
					</div>
					<div style="clear:both"></div><?php
					a2input('Game description','desc',3);
					a2input('Additional for o1','q1',3);
					a2input('Important information','main',3);
					a2input('Instruction','inst',3);
					a2input('Additional for o2','q2',3);
					a2input('Processor min','m2');
					a2input('Videocard min','m3');
					a2input('RAM min','m4');
					a2input('Free memory','m5');
					a2input('Processor','r2');
					a2input('Videocard','r3');
					a2input('RAM','r4');
					a2input('Additional for o3','q3',3); ?>
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
				?><br><form action="<?=LINK?>adm/?r=edited&id=<?=$_GET['id']?>" enctype="multipart/form-data" method="post">
					<a href="<?=_MAMBO_?>map/files/d3_13.php" target="_blank">Generate description</a><?php
					a2input('ID','id',0,1,$row['id']);
					a2input('Link','link',0,1,$row['link']);
					a2input('Oplata info Id','oil',0,1,$row['b_link']);
					a2input('Name','name',0,1,$row['name']);
					a2input('Keywords','kw',0,1,$row['keywords']);
					a2input('Youtube video','yt',0,1,$row['yt']);
					$par=explode(':',$row['parameters']);?>
					<div class="form-group">
							<label class="control-label col-sm-2">Parameters:</label>
							<div class="col-sm-9">
								<table>
									<tbody><?php
										$pl=array(
											array("Windows Xp","wXP"),
											array("Windows 7","w7"),
											array("Windows 8","w8"),
											array("Windows 10","w10"),
											array("32 Bit","32b"),
											array("64 Bit","64b"),
											array("Linux","lin"),
											array("Mac Os","macX")
										);
										echo '<tr>';
											for($i=0;$pl[$i][0]!=NULL;$i++)
												echo '<th><label for="a2'.$pl[$i][1].'"><img class="special" src="'.LINK.'images/'.$pl[$i][1].'.png" alt="'.$pl[$i][0].'" title="'.$pl[$i][0].'"></label></th>';
										echo '</tr>
										<tr>';
											for($i=0;$pl[$i][0]!=NULL;$i++){
												echo '<th><input id="a2'.$pl[$i][1].'" name="'.$pl[$i][1].'" type="checkbox"';
												if($par[0][$i]==1)
													echo ' checked';
												echo '></th>';
											}
										echo '</tr>'; ?>
									</tbody>
								</table>
							</div>
						</div>
					<div class="form-group">
							<label class="control-label col-sm-2">Platform:</label>
							<div class="col-sm-9">
								<select name="platform" class="form-control">
									<option value="0"<?php if($par[1]==0 || !isset($par[1])) echo ' selected'; ?>>Nothing</option>
									<option value="1"<?php if($par[1]==1 && strlen($par[1])<2) echo ' selected'; ?>>Steam</option>
									<option value="2"<?php if($par[1]==2 && strlen($par[1])<2) echo ' selected'; ?>>Mojang</option>
									<option value="3"<?php if($par[1]==3 && strlen($par[1])<2) echo ' selected'; ?>>Social Club</option>
									<option value="4"<?php if($par[1]==4 && strlen($par[1])<2) echo ' selected'; ?>>Origin</option>
									<option value="5"<?php if($par[1]==5 && strlen($par[1])<2) echo ' selected'; ?>>Uplay</option>
								</select><input type="text" class="form-control" name="customPlatform"<?php if(strlen($par[1])>1) echo ' value="'.$par[1].'"'; ?>>
							</div>
						</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Language:</label>
						<div class="col-sm-9">
							<select name="language" class="form-control">
								<option value="0"<?php if($par[2]==0 || !isset($par[2])) echo ' selected'; ?>>Nothing</option>
								<option value="1"<?php if($par[2]==1 && strlen($par[2])<2) echo ' selected'; ?>>English</option>
								<option value="2"<?php if($par[2]==2 && strlen($par[2])<2) echo ' selected'; ?>>Russian</option>
								<option value="3"<?php if($par[2]==3 && strlen($par[2])<2) echo ' selected'; ?>>Ukrainian</option>
							</select>
							<input type="text" class="form-control" name="customLanguage"<?php if(strlen($par[2])>1) echo ' value="'.$par[2].'"'; ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Product type:</label>
						<div class="col-sm-9">
							<select name="productType" class="form-control">
								<option value="0"<?php if($par[3]==0 || !isset($par[3])) echo ' selected'; ?>>Nothing</option>
								<option value="1"<?php if($par[3]==1 && strlen($par[3])<2) echo ' selected'; ?>>Acc</option>
								<option value="2"<?php if($par[3]==2 && strlen($par[3])<2) echo ' selected'; ?>>Gift link</option>
								<option value="3"<?php if($par[3]==3 && strlen($par[3])<2) echo ' selected'; ?>>Key</option>
								<option value="4"<?php if($par[3]==4 && strlen($par[3])<2) echo ' selected'; ?>>Photo of key</option>
							</select>
							<input type="text" class="form-control" name="customProductType"<?php if(strlen($par[3])>1) echo ' value="'.$par[3].'"'; ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Developer:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="developer"<?php if(strlen($par[4])>1) echo ' value="'.$par[4].'"'; ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Publisher:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="publisher"<?php if(strlen($par[5])>1) echo ' value="'.$par[5].'"'; ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Year of relyse:</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="yearOfRelyse" max="2100" value="<?php if(strlen($par[6])>1) echo $par[6]; else echo '2000'; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Gift:</label>
						<div class="col-sm-9">
							<select name="gift" class="form-control">
								<option value="0"<?php if($par[8]==0 || !isset($par[8])) echo ' selected'; ?>>Nothink</option>
								<option value="1"<?php if($par[8]==1 && strlen($par[8])<2) echo ' selected'; ?>>Random key</option>
								<option value="2"<?php if($par[8]==2 && strlen($par[8])<2) echo ' selected'; ?>>Gift</option>
								<option value="3"<?php if($par[8]==3 && strlen($par[8])<2) echo ' selected'; ?>>PromoCode</option>
								<option value="4"<?php if($par[8]==4 && strlen($par[8])<2) echo ' selected'; ?>>Account</option>
							</select>
							<input type="text" class="form-control" name="customGift">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a2i0">I0:</label>
						<div class="col-sm-9">
							<input id="a2i0" type="file" accept="image/*" name="i0"><?php
							$src=getAva(0,LINK.'p/'.$row['link'].'/img0.',NULL);
							if(isset($src))
								echo '<img src="'.$src.'" alt="img0" style="width: 30%;max-height:300px;">'; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="a2i1" style="clear: both">I1:</label>
						<div class="col-sm-9">
							<input id="a2i1" type="file" accept="image/*" name="i1"><?php
							$src=getAva(0,LINK.'p/'.$row['link'].'/img1.',NULL);
							if(isset($src))
								echo '<img src="'.$src.'" alt="img1" style="width: 30%;max-height:300px;">'; ?>
						</div>
					</div>
					<div class="form-group" style="clear: both">
						<label class="control-label col-sm-2" for="a2i2">I2:</label>
						<div class="col-sm-9">
							<input id="a2i2" type="file" accept="image/*" name="i2"><?php
							$src=getAva(0,LINK.'p/'.$row['link'].'/img2.',NULL);
							if(isset($src))
								echo '<img src="'.$src.'" alt="img2" style="width: 30%;max-height:300px;">'; ?>
						</div>
					</div>
					<div class="form-group" style="clear: both">
						<label class="control-label col-sm-2" for="a2i3">I3:</label>
						<div class="col-sm-9">
							<input id="a2i3" type="file" accept="image/*" name="i3"><?php
							$src=getAva(0,LINK.'p/'.$row['link'].'/img3.',NULL);
							if(isset($src))
								echo '<img src="'.$src.'" alt="img3" style="width: 30%;max-height:300px;">'; ?>
						</div>
					</div>
					<div style="clear:both"></div><?php
					a2input('O1','o1',3,0,htmlspecialchars(preg_replace('/<[\/]?br[ ]?[\/]?>/',"\n",preg_replace("/\n<[\/]?br[ ]?[\/]?>/","\n",preg_replace("/<[\/]?br[ ]?[\/]?>\n/","\n",htmlspecialchars_decode($row['o1']))))));
					a2input('O2','o2',3,0,htmlspecialchars(preg_replace('/<[\/]?br[ ]?[\/]?>/',"\n",preg_replace("/\n<[\/]?br[ ]?[\/]?>/","\n",preg_replace("/<[\/]?br[ ]?[\/]?>\n/","\n",htmlspecialchars_decode($row['o2']))))));
					a2input('O3','o3',3,0,htmlspecialchars(preg_replace('/<[\/]?br[ ]?[\/]?>/',"\n",preg_replace("/\n<[\/]?br[ ]?[\/]?>/","\n",preg_replace("/<[\/]?br[ ]?[\/]?>\n/","\n",htmlspecialchars_decode($row['o3'])))))); ?>
					<div class="btn-group">
						<a style="color:#fff;" href="<?=LINK?>adm" class="btn btn-goldi">Скасувати</a>
						<a style="color:#fff;" href="<?=LINK?>adm/?r=deleted&id=<?=$_GET['id']?>" class="btn btn-goldi">Видалити товар</a>
						<a style="color:#fff;" target="_blank" href="<?=LINK?>p/<?=$row['link']?>/" class="btn btn-goldi">Переглянути</a>
						<button type="submit" class="btn btn-goldi">Зберегти зміни</button>
					</div>
				</form>
				<?php
			}
		}
		else {
			if($_GET['r']=='deleted' && preg_match('/^[0-9]{1,}$/',$_GET['id'])){
				que('SELECT link FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$row=mysql_fetch_array($res);
				array_map('unlink', glob('../p/'.$row['link'].'/*.*'));
				rmdir('../p/'.$row['link'].'/');
				que('DELETE FROM '._PRODUCTS_.' WHERE link="'.$row['link'].'"');
				alert('Продукт успішно видалено','success');
			}
			if($_GET['r']=='created'){
				if(isset($_POST['name']) && isset($_POST['link']))
					que('SELECT link FROM '._PRODUCTS_.' WHERE name="'.$_POST['name'].'" AND link="'.$_POST['link'].'"');
				$u=mysql_num_rows($res);
				if($u==0){
					que('SELECT link FROM '._PRODUCTS_);
					while($row=mysql_fetch_array($res))
						if($row['link']==$_POST['link'])
							$clear=1;
					if($clear){
						for($buf=rand()%1000,$u=1;$u!=0;$buf=rand()%1000){
							que('SELECT link FROM '._PRODUCTS_.' WHERE link="'.$_POST['link'].$buf.'"');
							$u=mysql_num_rows($res);
						}
						$_POST['link'].=$buf;
						alert('Вказаний адрес продукту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагуванняпродукту','warning');
					}
					$path=$_POST['link'];
					mkdir('../p/'.$path.'/');
					copy('../p/NO_DELETE/index.php','../p/'.$path.'/index.php');
					$pl=array("wXP","w7","w8","w10","32b","64b","lin","macX");
					foreach ($pl as $pl)
						$par.=($_POST[$pl]=='on'?1:0);
					$par.=':';
					if(strlen($_POST['customPlatform'])>0)
						$par.=$_POST['customPlatform'].':';
					else if(strlen($_POST['platform'])>0)
						$par.=$_POST['platform'].':';
					else
						$par.='0:';
					if(strlen($_POST['customLanguage'])>0)
						$par.=$_POST['customLanguage'].':';
					else if(strlen($_POST['language'])>0)
						$par.=$_POST['language'].':';
					else
						$par.='0:';
					if(strlen($_POST['customProductType'])>0)
						$par.=$_POST['customProductType'].':';
					else if(strlen($_POST['productType'])>0)
						$par.=$_POST['productType'].':';
					else
						$par.='0:';
					if(strlen($_POST['developer'])>0)
						$par.=$_POST['developer'].':';
					else
						$par.='0:';
					if(strlen($_POST['publisher'])>0)
						$par.=$_POST['publisher'].':';
					else
						$par.='0:';
					if(strlen($_POST['yearOfRelyse'])>0)
						$par.=$_POST['yearOfRelyse'].':';
					else
						$par.='0:';
					if(strlen($_POST['customGift'])>0)
						$par.=$_POST['customGift'];
					else if(strlen($_POST['gift'])>0)
						$par.=$_POST['gift'];
					else
						$par.='0';
					if($_FILES['i0']['size']>0){
						switch($_FILES['i0']['type']){
							case "image/jpeg":$src2="1";break;
							case "image/jpg":$src2="1";break;
							case "image/gif":$src2="1";break;
							case "image/png":$src2="1";break;
							case "image/tiff":$src2="1";break;
							case "image/bmp":$src2="1";break;
							case "image/jfjf":$src2="1";break;
						}
						if(isset($src2)){
							if($_FILES['i0']['size']<1024*1024*3){
								move_uploaded_file($_FILES['i0']['tmp_name'],'../p/'.$path.'/img0.'.pathinfo($_FILES['i0']['name'], PATHINFO_EXTENSION));
								$src2=NULL;
							}
							else
								alert('Image is too big','danger');
						}
						else
							alert('Invalid image extension','danger');
					}
					if($_FILES['i1']['size']>0){
						switch($_FILES['i1']['type']){
							case "image/jpeg":$src2="1";break;
							case "image/jpg":$src2="1";break;
							case "image/gif":$src2="1";break;
							case "image/png":$src2="1";break;
							case "image/tiff":$src2="1";break;
							case "image/bmp":$src2="1";break;
							case "image/jfjf":$src2="1";break;
						}
						if(isset($src2)){
							if($_FILES['i1']['size']<1024*1024*3){
								move_uploaded_file($_FILES['i1']['tmp_name'],'../p/'.$path.'/img1.'.pathinfo($_FILES['i1']['name'], PATHINFO_EXTENSION));
								$src2=NULL;
							}
							else
								alert('Image is too big','danger');
						}
						else
							alert('Invalid image extension','danger');
					}
					if($_FILES['i2']['size']>0){
						switch($_FILES['i2']['type']){
							case "image/jpeg":$src2="1";break;
							case "image/jpg":$src2="1";break;
							case "image/gif":$src2="1";break;
							case "image/png":$src2="1";break;
							case "image/tiff":$src2="1";break;
							case "image/bmp":$src2="1";break;
							case "image/jfjf":$src2="1";break;
						}
						if(isset($src2)){
							if($_FILES['i2']['size']<1024*1024*3){
								move_uploaded_file($_FILES['i2']['tmp_name'],'../p/'.$path.'/img2.'.pathinfo($_FILES['i2']['name'], PATHINFO_EXTENSION));
								$src2=NULL;
							}
							else
								alert('Image is too big','danger');
						}
						else
							alert('Invalid image extension','danger');
					}
					if($_FILES['i3']['size']>0){
						switch($_FILES['i3']['type']){
							case "image/jpeg":$src2="1";break;
							case "image/jpg":$src2="1";break;
							case "image/gif":$src2="1";break;
							case "image/png":$src2="1";break;
							case "image/tiff":$src2="1";break;
							case "image/bmp":$src2="1";break;
							case "image/jfjf":$src2="1";break;
						}
						if(isset($src2)){
							if($_FILES['i3']['size']<1024*1024*3){
								move_uploaded_file($_FILES['i3']['tmp_name'],'../p/'.$path.'/img3.'.pathinfo($_FILES['i3']['name'], PATHINFO_EXTENSION));
								$src2=NULL;
							}
							else
								alert('Image is too big','danger');
						}
						else
							alert('Invalid image extension','danger');
					}
					if(strlen($_POST['customProductType'])>0)
						$q1.="Після оплати, ви моментально отримуєте <b>".$_POST['customProductType']." для ".$_POST['name'].'</b>';
					else if(strlen($_POST['productType'])>0 && $_POST['productType']!=0 && strlen($_POST['platform'])>0 && $_POST['platform']!=0){
						$gk=array("Steam","Mojang","Social Club","Origin","Uplay");
						if(strlen($_POST['customPlatform'])>1)
							$buf=$_POST['customPlatform'];
						else
							$buf=$gk[$_POST['platform']-1];
						$q1.="Після оплати, ви моментально отримуєте <b>";
						if($_POST['productType']==1)
							$q1.="акаунт ".$buf." з грою ".$_POST['name']."</b>. Також на акаунті можуть бути й інші ігри, які йдуть в якості бонусу";
						else if($_POST['productType']==2)
							$q1.="посилання для активації ".$_POST['name']." в ваший акаунт ".$buf.'</b>';
						else if($_POST['productType']==3)
							$q1.="ключ для активації ".$_POST['name']." в ваший акаунт ".$buf.'</b>';
						else if($_POST['productType']==4)
							$q1.="фотографію з ключем для активації ".$_POST['name']." в ваший акаунт ".$buf.'</b>';
					}
					if($_POST['gift']!=0){
						$q1.='<br><br>Якщо після оплати залишити позитивний відгук на сайті oplata.info, та написчати продавцю в розділ "переписка", ви отримаєте ';
						$pe=array("Random key","Gift","Промо код","Акаунт");
						if($_POST['gift']==1)
							$q1.='радкомний ключ';
						else if($_POST['gift']==2)
							$q1.='Gift';
						else if($_POST['gift']==3)
							$q1.='промо код';
						else if($_POST['gift']==4)
							$q1.='акаунт';
					}
					if($_POST['desc'])
						$q1.='<br><br>'.preg_replace("/\n/",'<br>',$_POST['desc']);
					if($_POST['q1'])
						$q1.='<br><br>'.preg_replace("/\n/",'<br>',$_POST['q1']);
					if($_POST['main'])
						$q2="<b>Важлива інформація</b><br>".preg_replace("/\n/",'<br>',$_POST['main']).'<br><br>';
					$q2.="<b>Інструкція</b><br>";
					if($_POST['productType']==3 && $_POST['platform']==1)
						$q2.="1. Завантажити Steam і зареєструваися в ньому / Відкрити Steam і ввійти в свій акаунт<br>2. Перейти в розділ \"Бібліотека\" і в лівому верхньому куту вибрати пункт \"Добавити гру\", потім \"Активувати в Steam\"<br>3. Ввести ключ<br>4. Після активації гра появиться в списку ігор, і Ви зможете завантажити її з Steam";
					else if($_POST['productType']==1 && $_POST['platform']==4 && preg_match('/inecraft/',$_POST['name']))
						$q2.="Для гри вам потрібно завантажити офіційний або пірацький лаунчер (TLauncher)<br>Завантажити офіційний лаунчер - <a href='https://launcher.mojang.com/download/MinecraftInstaller.msi'><b> нажміть сюди</b></a><br>При вході в офіційний лацнчер введіть дані (логін і пароль) який ви отримали після купівлі.<br>Приємної гри!";
					else if($_POST['productType']==1 && $_POST['platform']==3)
						$q2.="1. Знімайте прорцес купівлі та оплати на відео!<br>2. Заходимо в профіль <a href =&#34;https://ru.socialclub.rockstargames.com/activate&#34; target=&#34;_blank&#34;>Social Club</a><br>3. Змініть дані для входу (пошту, пароль, та інші)<br>4. Завантажити лаунчер GTA V і авторизуватися в лаунчері в свій акаунт";
					else if($_POST['inst'])
						$q2.=preg_replace("/\n/",'<br>',$_POST['inst']);
					if($_POST['q2'])
						$q2.='<br><br>'.preg_replace("/\n/",'<br>',$_POST['q2']);
					if($_POST['m2'] || $_POST['m3'] || $_POST['m4'] || $_POST['m5']){
						$q3="<b>Мінімальні системні вимоги</b>";
						if($_POST['m2'])
							$q3.='<br>Процесор: '.$_POST['m2'];
						if($_POST['m3'])
							$q3.='<br>Відеокарта: '.$_POST['m3'];
						if($_POST['m4'])
							$q3.='<br>ОЗУ: '.$_POST['m4'].' гб';
						if($_POST['m5'])
							$q3.='<br>Вільного місця на диску: '.$_POST['m5'].' гб';
					}
					if($_POST['r2'] || $_POST['r3'] || $_POST['r4'] || $_POST['m5']){
						$q3.="<br><br><b>Рекомендовані системні вимоги</b>";
						if($_POST['r2'])
							$q3.='<br>Процесор: '.$_POST['r2'];
						if($_POST['r3'])
							$q3.='<br>Відеокарта: '.$_POST['r3'];
						if($_POST['r4'])
							$q3.='<br>ОЗУ: '.$_POST['r4'].' гб';
						if($_POST['m5'])
							$q3.='<br>Вільного місця на диску: '.$_POST['m5'].' гб';
					}
					if($_POST['q3'])
						$q3.='<br><br>'.$_POST['q3'];
					que('INSERT INTO '._PRODUCTS_.' (id,name,price,link,b_link,o1,o2,o3,yt,keywords,unixTime,parameters) values("'.$_POST['id'].'","'.$_POST['name'].'","'.getPrice($_POST['oil']).'","'.$path.'","'.$_POST['oil'].'","'.htmlspecialchars($q1).'","'.htmlspecialchars($q2).'","'.htmlspecialchars($q3).'","'.$_POST['yt'].'","'.$_POST['kw'].'","'.time().'","'.$par.'")');
					alert('Продукт успішно додано','success');
				}
			}
			else if($_GET['r']=='edited' && preg_match('/^[0-9]*$/',$_GET['id'])){
				que('SELECT link FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$path=$_POST['link'];
				while($row=mysql_fetch_array($res))
					if($row['link']==$path)
						$unclear=1;
				if($clear){
					for($buf=rand()%1000,$u=1;$u!=0;$buf=rand()%1000){
						que('SELECT link FROM '._PRODUCTS_.' WHERE link="'.$path.$buf.'"');
						$u=mysql_num_rows($res);
					}
					$path.=$buf;
					alert('Вказаний адрес продукту зайнятий. Систама автоматично вибрала рандомний адрес. Ви можете його змінити через меню редагування продукту','warning');
				}
				$pl=array("wXP","w7","w8","w10","32b","64b","lin","macX");
				foreach ($pl as $pl)
					$par.=($_POST[$pl]=='on'?1:0);
				$par.=':';
				if(strlen($_POST['customPlatform'])>0)
					$par.=$_POST['customPlatform'].':';
				else if(strlen($_POST['platform'])>0)
					$par.=$_POST['platform'].':';
				else
					$par.='0:';
				if(strlen($_POST['customLanguage'])>0)
					$par.=$_POST['customLanguage'].':';
				else if(strlen($_POST['language'])>0)
					$par.=$_POST['language'].':';
				else
					$par.='0:';
				if(strlen($_POST['customProductType'])>0)
					$par.=$_POST['customProductType'].':';
				else if(strlen($_POST['productType'])>0)
					$par.=$_POST['productType'].':';
				else
					$par.='0:';
				if(strlen($_POST['developer'])>0)
					$par.=$_POST['developer'].':';
				else
					$par.='0:';
				if(strlen($_POST['publisher'])>0)
					$par.=$_POST['publisher'].':';
				else
					$par.='0:';
				if(strlen($_POST['yearOfRelyse'])>0)
					$par.=$_POST['yearOfRelyse'].':';
				else
					$par.='0:';
				if(strlen($_POST['customGift'])>0)
					$par.=$_POST['customGift'];
				else if(strlen($_POST['gift'])>0)
					$par.=$_POST['gift'];
				else
					$par.='0';
				if($_FILES['i0']['size']>0){
					switch($_FILES['i0']['type']){
						case "image/jpeg":$src2="1";break;
						case "image/jpg":$src2="1";break;
						case "image/gif":$src2="1";break;
						case "image/png":$src2="1";break;
						case "image/tiff":$src2="1";break;
						case "image/bmp":$src2="1";break;
						case "image/jfjf":$src2="1";break;
					}
					if(isset($src2)){
						if($_FILES['i0']['size']<1024*1024*3){
							array_map('unlink', glob('../p/'.$path.'/img0.*'));
							move_uploaded_file($_FILES['i0']['tmp_name'],'../p/'.$path.'/img0.'.pathinfo($_FILES['i0']['name'], PATHINFO_EXTENSION));
							$src2=NULL;
						}
						else
							alert('Image is too big','danger');
					}
					else
						alert('Invalid image extension','danger');
				}
				if($_FILES['i1']['size']>0){
					switch($_FILES['i1']['type']){
						case "image/jpeg":$src2="1";break;
						case "image/jpg":$src2="1";break;
						case "image/gif":$src2="1";break;
						case "image/png":$src2="1";break;
						case "image/tiff":$src2="1";break;
						case "image/bmp":$src2="1";break;
						case "image/jfjf":$src2="1";break;
					}
					if(isset($src2)){
						if($_FILES['i1']['size']<1024*1024*3){
							array_map('unlink', glob('../p/'.$path.'/img1.*'));
							move_uploaded_file($_FILES['i1']['tmp_name'],'../p/'.$path.'/img1.'.pathinfo($_FILES['i1']['name'], PATHINFO_EXTENSION));
							$src2=NULL;
						}
						else
							alert('Image is too big','danger');
					}
					else
						alert('Invalid image extension','danger');
				}
				if($_FILES['i2']['size']>0){
					switch($_FILES['i2']['type']){
						case "image/jpeg":$src2="1";break;
						case "image/jpg":$src2="1";break;
						case "image/gif":$src2="1";break;
						case "image/png":$src2="1";break;
						case "image/tiff":$src2="1";break;
						case "image/bmp":$src2="1";break;
						case "image/jfjf":$src2="1";break;
					}
					if(isset($src2)){
						if($_FILES['i2']['size']<1024*1024*3){
							array_map('unlink', glob('../p/'.$path.'/img2.*'));
							move_uploaded_file($_FILES['i2']['tmp_name'],'../p/'.$path.'/img2.'.pathinfo($_FILES['i2']['name'], PATHINFO_EXTENSION));
							$src2=NULL;
						}
						else
							alert('Image is too big','danger');
					}
					else
						alert('Invalid image extension','danger');
				}
				if($_FILES['i3']['size']>0){
					switch($_FILES['i3']['type']){
						case "image/jpeg":$src2="1";break;
						case "image/jpg":$src2="1";break;
						case "image/gif":$src2="1";break;
						case "image/png":$src2="1";break;
						case "image/tiff":$src2="1";break;
						case "image/bmp":$src2="1";break;
						case "image/jfjf":$src2="1";break;
					}
					if(isset($src2)){
						if($_FILES['i3']['size']<1024*1024*3){
							array_map('unlink', glob('../p/'.$path.'/img2.*'));
							move_uploaded_file($_FILES['i3']['tmp_name'],'../p/'.$path.'/img3.'.pathinfo($_FILES['i3']['name'], PATHINFO_EXTENSION));
							$src2=NULL;
						}
						else
							alert('Image is too big','danger');
					}
					else
						alert('Invalid image extension','danger');
				}
				que('SELECT link FROM '._PRODUCTS_.' WHERE keyVal="'.$_GET['id'].'"');
				$row=mysql_fetch_array($res);
				rename('../p/'.$row['link'],'../p/'.$path);
				que('UPDATE '._PRODUCTS_.' SET id="'.$_POST['id'].'",name="'.$_POST['name'].'",price="'.getPrice($_POST['oil']).'",link="'.$path.'",b_link="'.$_POST['oil'].'",o1="'.preg_replace("/\n/",'<br>',htmlspecialchars($_POST['o1'])).'",o2="'.preg_replace("/\n/",'<br>',htmlspecialchars($_POST['o2'])).'",o3="'.preg_replace("/\n/",'<br>',htmlspecialchars($_POST['o3'])).'",yt="'.$_POST['yt'].'",keywords="'.$_POST['kw'].'",unixTime="'.time().'",parameters="'.$par.'" WHERE keyVal="'.$_GET['id'].'"');
				alert('Продукт успішно змінено','success');
			} ?>
			<br><br><a href="index.php?a=addProduct">Add product</a> <?php
			que('SELECT * FROM '._PRODUCTS_.' WHERE id!=0 ORDER BY id+0,views+0'); ?>
			<div class="row"> <?php
				while($row=mysql_fetch_array($res)){
					echo '<a href="index.php?a=editProduct&id='.$row['keyVal'].'" class="product col-xs-6 col-sm-4 col-md-3">
						<div class="productImg">
							<img src="'.getAva(1,LINK.'p/'.$row['link'].'/img0.',LINK.'images/def.png').'" alt="'.$row['name'].'">
						</div>
						<div class="name">'.$row['name'].'</div>
						<div class="productPrice">'.$row['price'].'&#8372;</div>
					</a>';
				} ?>
			</div> <?php
		}
		footer(1);?>
	</body>
</html>