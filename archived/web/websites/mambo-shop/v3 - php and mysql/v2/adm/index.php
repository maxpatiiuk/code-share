<!-- adm -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			$dir=basename(dirname(__FILE__));
			head('','','',1,1,0,1);
		?>
	</head>
	<body>
		<?php /*if($_POST['rust']==50){
			que('SELECT name,id,url FROM products ORDER BY buffffffer=0');
			while ($rowd=mysql_fetch_array($res)){
				que('UPDATE products SET id="'.$_POST[$row['name']].'" WHERE url="'.$rowd['url'].'"');
			}
		}
		else {
			que('SELECT name,id,url FROM products ORDER BY buffffffer=0');
			echo '<form id="login" action="index.php" method="post">';
			while ($row=mysql_fetch_array($res)){
				echo '<br>'.$row['url'].' : <input class="f_i_t" name="'.$row['url'].'" value="'.$row['id'].'"><br>';
			}
			echo '<input type="submit">
			</form>';
		}*/menu();
		c('profile');
		/*que('SELECT id,conf FROM users');
		while ($row=mysql_fetch_array($res)){
			$i=date('z')-$row['conf'];
			echo '<br><br>ID: '.$row['id'].'; Conf:'.$row['conf'].'; $i: '.$i.';';
			if($i>20 && $row['conf']!=1) echo '<font color="red"> deleted?</font>';
			if($i>20 && $row['conf']!=1 && date('z')<364 && date('z')>21)
				que('DELETE FROM users WHERE id="'.$row['id'].'"');
		}
		echo $i.'<br>';*/
		que('SELECT * FROM users WHERE type="10" AND hesh="'.$_COOKIE['hesh'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u==1){
			?>
				<div class="tabs">
					<button id="b1" class="b cur" onclick="openC('a1', 'b1')">Edit products</button>
					<button id="b2" class="b" onclick="openC('a2', 'b2')">Edit shop</button>
					<button id="b3" class="b" onclick="openC('a3', 'b3')">Edit profiles</button>
					<button id="b4" class="b" onclick="openC('a4', 'b4')">Settings</button>
					<button id="b5" class="b" onclick="redir('<?=_LOCATION_.'profile/?id='.$row['id']?>')">Profile</button>
					<button id="b6" class="b" onclick="openC('a6', 'b6')">Statistic</button>
					<button id="b7" class="b" onclick="redir('<?=_LOCATION_.'profile/out.php'?>')">Out</button>
				</div>
				<div id="a1" class="tab_c">
					<?php
						if($_GET['p_n']=="add"){//htmlentities()
							que("INSERT INTO products SET name='".$_POST["name"]."', id='".$_POST['id']."', price='".$_POST["price"]."', url='".$_POST["url"]."', b_link='".$_POST["b_link"]."', s1='".$_POST["s1"]."', s2='".$_POST["s2"]."', s3='".$_POST["s3"]."', s4='".$_POST["s4"]."', o1='".preg_replace('/\'/','&#39;',preg_replace('/"/','&#34;',$_POST["o1"]))."', o2='".preg_replace('/\'/','&#39;',preg_replace('/"/','&#34;',$_POST["o2"]))."', o3='".preg_replace('/\'/','&#39;',preg_replace('/"/','&#34;',$_POST["o3"]))."', yt='".$_POST["yt"]."', key_='".$_POST["key_"]."', vis='".$_POST["vis"]."', par='".$_POST["par"]."', date='".time()."'");
							mkdir('../'.$_POST["url"]);
							copy('../minecraft/index.php','../'.$_POST["url"].'/index.php');
							echo 'Ready<br><a href="'._LOCATION_.'adm/">Next</a>';
						}
						else if(isset($_GET['p_d'])){
							que('SELECT name FROM products WHERE buf="'.$_GET['p_d'].'"');
							$row=mysql_fetch_array($res);
							echo 'Are you sure?<br>'.$row['name'].'<br><a href="'._LOCATION_.'adm/?p_dl='.$_GET['p_d'].'">Yes</a><br><a href="'._LOCATION_.'adm/">No</a>';
						}
						else if(isset($_GET['p_dl'])){
							que('DELETE FROM products WHERE buf="'.$_GET['p_dl'].'"');
							echo 'Deleted<br><a href="'._LOCATION_.'adm/">Next</a>';
						}
						else if(isset($_GET['p_v'])){
							if($_GET['p_v']=='sort'){
								echo '<form action="'._LOCATION_.'adm/?p_v=sorted" method="post">';
								que("SELECT buf,vis,name,id FROM products ORDER BY id+0");
								while ($row=mysql_fetch_array($res)){
									echo '<div';
									if($row['vis']==0)
										echo ' class="dark"';
									echo '>
										<input type="text" name="'.$row['buf'].'" value="'.$row['id'].'"> '.$row['name'].'</div>';
								}
								echo '<br><input type="submit"></form>';
							}
							else if($_GET['p_v']=='sorted'){
								que("SELECT buf FROM products ORDER BY id+0");
								echo var_dump(mysql_num_rows($res)).'<br>';
								while ($row=mysql_fetch_array($res)){
									echo var_dump($_POST[$row['buf']]).'<br>';
									echo var_dump($row['buf']).'<br>';
									que("UPDATE products SET id='".$_POST[$row['buf']]."' WHERE buf='".$row['buf']."'",2);
								}
								echo 'Ready<br><a href="'._LOCATION_.'adm/">Next</a>';
							}
							else if($_GET['p_v']=='new'){
								function e_v($name){
									echo ucfirst($name).':<input type="text" style="width:60vw" name="'.$name.'"><br>';	
								}
								echo '<a href="http://mambo.zzz.com.ua/map/files/d3_13.php">Генератор опису</a><br><form action="index.php?p_n=add" method="post"><br>';
								e_v('id');
								e_v('name');
								e_v('price');
								e_v('url');
								e_v('b_link');
								e_v('s1');
								e_v('s2');
								e_v('s3');
								e_v('s4');
								e_v('o1');
								e_v('o2');
								e_v('o3');
								e_v('yt');
								e_v('key_');
								echo 'vis=0 ==""';
								e_v('vis');
								e_v('par');
								echo '<input type="submit" value="Add">
								</form>';
							}
							else if(isset($_POST['buf'])){
								que("UPDATE products SET name='".$_POST["name"]."', id='".$_POST['id']."', price='".$_POST["price"]."', url='".$_POST["url"]."', b_link='".$_POST["b_link"]."', s1='".$_POST["s1"]."', s2='".$_POST["s2"]."', s3='".$_POST["s3"]."', s4='".$_POST["s4"]."', o1='".preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $_POST['o1']))."', o2='".preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $_POST['o2']))."', o3='".preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $_POST['o3']))."', yt='".$_POST["yt"]."', key_='".$_POST["key_"]."', vis='".$_POST["vis"]."', par='".$_POST["par"]."' WHERE buf='".$_POST["buf"]."'");
								echo var_dump($_POST['vis']);
								echo 'Ready<br><a href="'._LOCATION_.'adm/">Next</a>';
							}
							else {
								que('SELECT * FROM products WHERE buf="'.$_GET['p_v'].'"');
								$row=mysql_fetch_array($res);
								function e_p($name){
									global $row;
									$str=preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $row[$name]));
									echo ucfirst($name).':<input type="text" style="width:60vw" name="'.$name.'" value="'.$str.'"><br>';	
								}
								echo '<form action="index.php?p_v='.$row['buf'].'" method="post"><input type="hidden" name="buf" value="'.$row['buf'].'">
									BUF: '.$row['buf'].'<br>';
								e_p('id');
								e_p('name');
								e_p('price');
								e_p('url');
								e_p('b_link');
								e_p('s1');
								e_p('s2');
								e_p('s3');
								e_p('s4');
								e_p('o1');
								e_p('o2');
								e_p('o3');
								e_p('yt');
								e_p('key_');
								echo 'vis=0 ==""';
								e_p('vis');
								e_p('par');
								echo '<a href="'._LOCATION_.'adm/?p_d='.$row['buf'].'">Delete</a><input type="submit" value="Edit">
								</form>';
							}
						}
						else {
						echo '<a href="'._LOCATION_.'adm/?p_v=new">Add new product</a><br><a href="'._LOCATION_.'adm/?p_v=sort">Change order</a><br><div class="format">';
						que('SELECT id,name,price,s1,buf FROM products ORDER BY id ASC');
						while ($row=mysql_fetch_array($res)){
							echo '<a href="'._LOCATION_.'adm/?p_v='.$row["buf"].'" class="pro l">
								<div>
									<p class="p_p l">'.$row["price"].'</p>
									<p class="l">&#8372</p>
								</div>
								<img class="l" src="'.$row["s1"].'" alt="'.$row["name"].'">
								<p class="p_n l">'.$row["name"].'</p>
							</a>';
						}
						echo '</div>';
						}
					?>
				</div>
				<div id="a2" style="display:none" class="tab_c">
					<?php

					?>
				</div>
				<div id="a3" style="display:none" class="tab_c">
					<?php
						
					?>
				</div>
				<div id="a4" style="display:none" class="tab_c">
					<?php
						
					?>
				</div>
				<div id="a6" style="display:none" class="tab_c">
					<?php
						que("SELECT vis,name,pop FROM products ORDER BY pop+0 DESC");
						while ($row=mysql_fetch_array($res)){
							global $iii;
							$iii+=$row['pop'];
							echo '<div';
							if($row['vis']==0)
								echo ' class="dark"';
							echo '>
								'.$row['pop'].' : '.$row['name'].'</div>';
						}
						echo '<br>';
						que("SELECT id FROM products");
						$u=mysql_num_rows($res);
						que("SELECT id FROM products WHERE vis=0");
						$u2=mysql_num_rows($res);
						echo 'На сайті є '.$u.' товарів, які переглянуті '.$iii.' разів. Серед них, '.$u2.' товарів є прихованими<br>';
						que("SELECT id FROM users");
						$u=mysql_num_rows($res);
						que("SELECT id FROM users WHERE conf=1");
						$u2=mysql_num_rows($res);
						que("SELECT id FROM users WHERE type=10");
						$u3=mysql_num_rows($res);
						echo 'На сайті зареєстровано '.$u.' користувачів, серед них, '.$u2.' підтвердили пошту і '.$u3.' є адміністраторами<br>';
					?>
				</div>
			<?php
		}
		else echo 'Access denied';
		c(1);?>
		<script>
			function redir(where) {
				window.location.href = where;
			}
		</script>
	</body>
</html>