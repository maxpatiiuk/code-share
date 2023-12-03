<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			# Count number of views, unles it's an internal IP
			if($_SERVER['REMOTE_ADDR']!="--ip-was--here--")
				que("UPDATE products SET pop=pop+1 WHERE url = '".$dir."';");
			que("SELECT * FROM products WHERE url = '".$dir."';");
			$row = mysql_fetch_array($res);
			head($row['name'],strip_tags($row['name']).', '.strip_tags($row['o1']),$row['name'].', '.$row['key_'],0,1,1,1);
			echo '<meta property="og:url" content="'._LOCATION_.$row['url'].'/">
			<meta property="fb:admins" content="maxpatiiuk">';
		?>
	</head>
	<body>
		<?php
			$str=str_replace("." ,"%2E", str_replace("/" ,"%2F", str_replace(":" ,"%3A", _LOCATION_.$dir.'/')));
			$link='https://www.oplata.info/asp2/pay_wm.asp?id_d='.$row['b_link'].'&id_po=0&cart_uid=&ai=600788&ae=&curr=WMU&lang=ru-RU&failpage='.$str;
			menu();
			c('prod');
			?>
					<div>
						<h1><?=$row['name']?></h1>
						<div class="c_bord">
							<iframe class="l" src="https://www.youtube.com/embed/<?=$row['yt']?>" frameborder="0" allowfullscreen></iframe>
							<div class="images l">
								<div>
									<img class="l" alt="<?=$row['name']?>" src="<?=$row['s1']?>" />
									<img class="img2 r" alt="<?=$row['name']?>" src="<?=$row['s2']?>" />
									<img class="l" alt="<?=$row['name']?>" src="<?=$row['s3']?>" />
								</div>
								<div>
									<a class="c_b l" href="<?=$link?>">КУПИТИ</a>
									<a class="c_p l an"><p class="l"><?=$row['price']?></p><p class="l"> грн</p></a>
									<img class="img4 r" alt="<?=$row['name']?>" src="<?=$row['s4']?>" />
								</div>
							</div>
						</div>
						<div class="tabs">
							<button onclick="openC('a1','b1')">Опис</button>
							<button onclick="openC('a2','b2')">Інструкція</button>
							<button onclick="openC('a3','b3')">Системні вимоги</button>
						</div>
						<div id="a1" class="tab_c l"><?=$row['o1']?></div>
						<div id="a2" class="tab_c l" style="display:none"><?=$row['o2']?></div>
						<div id="a3" class="tab_c l" style="display:none"><?=$row['o3']?></div>
						<div class="com r">
							<div class="fb-comments" data-href="<?=_LOCATION_.$row['url']?>" data-colorscheme="dark" data-width="auto" data-numposts="20"></div>
						</div>
					</div>
		<?php c(1)?>
	</body>
</html>