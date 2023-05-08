<!-- Shop -->
<!DOCTYPE html>
<html lang="uk">
	<head> <?php
			define('LINK','http://test.mambo.zzz.com.ua/');
			mysql_connect('MYSQL_HOST','MYSQL_USER','MYSQL_PASSWORD');
			mysql_select_db('MYSQL_DATABASE');
			$res=mysql_query('INSERT INTO `log`(domain,directory,eTime,ip,userID,type,val) VALUES("'.LINK.'","https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'","'.date('H:i:s d:m:y').'","'.$_SERVER['REMOTE_ADDR'].'","-1","0","User visited page")');
			$buf.='Спрощена версія - Mambo Shop - український магазин ігрових акаунтів та ключів. Minecraft, CS GO, GTA 5, Battlefield 1'; ?>
			<meta charset="utf-8">
			<meta name="keywords" content="<?=$buf?>">
			<meta name="description" content="<?=$buf?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?=$buf?></title>
			<style>
				body {
					margin: 0;
					font-family: arial;
					background: #222;
				}
				a {
					color: #874;
				}
				a:visited {
					color: #988;
				}
				a:hover {
					color: #985;
				}
				body>a {
					width: 98%;
					display: block;
					padding: 1vw;
				}
				body>a:nth-child(odd) {
					background: #111;
				}
				a span:fisrt-child {
					float: left;
				}
				a span:last-child {
					float: right;
				}
				footer {
					background: #111;
					padding: 1vw;
					color: #aaa;
				}
				div {
					padding: 0 1vw;
					color: #aaa;
				}
			</style>
	</head>
	<body> <?php
			if(!isset($_GET['id']) || $_GET['id']<1 || $_GET['id']>9999){
				$res=mysql_query('SELECT id,name,price FROM `products_t` WHERE vis=1 ORDER BY id+0,views+0');
				$u=mysql_num_rows($res);
				while($row=mysql_fetch_array($res)){
					echo '<a href="index.php?id='.$row['id'].'">
						<span>'.$row['name'].'</span>
						<span>'.$row['price'].'&#8372;</span>
					</a>';
				}
				$buf=NULL;
			}
			else {
				$res=mysql_query('SELECT o1,o2,o3,parameters,name,price,link,b_link FROM `products_t` WHERE id="'.$_GET['id'].'" AND vis="1"');
				$row=mysql_fetch_array($res);
				$buf='p/'.$row['link'].'/';
				if(mysql_num_rows($res)!=1)
					header('Location: '.LINK.'light/');
				$link='https://www.oplata.info/asp2/pay_wm.asp?id_d='.$row['b_link'].'&id_po=0&ai=600788&curr=WMU&lang=ru-RU&failpage='.urlencode(LINK.'light/?id='.$row['id']);
				echo '<a href="'.LINK.'light/">На головну</a>
				<div>
					<h1>'.$row['name'].'</h1>
					<a href="'.$link.'">Купити ('.$row['price'].' грн)</a>
					<p>'.htmlspecialchars_decode($row['o1']).'</p>
					<p>'.htmlspecialchars_decode($row['o2']).'</p>
					<p>'.htmlspecialchars_decode($row['o3']).'</p>
				</div>';
			} ?><br><br>
		<footer>
			&copy;MAMBO <?=date("Y")?><br>
			<a href="<?=LINK.$buf?>">Повернутися до повноцінної версії</a>
		</footer>
	</body>
</html>