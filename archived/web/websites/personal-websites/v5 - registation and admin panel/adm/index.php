<!-- adm -->
<!DOCTYPE html>
<html>
	<head>
		<?php
			include '../functions/main.php';
			head('','','',1,1,0,1);
		?>
	</head>
	<body>
		<?php menu();
		que('SELECT * FROM users WHERE type="10" AND hesh="'.$_COOKIE['hesh'].'"');
		$row=mysql_fetch_array($res);
		$u=mysql_num_rows($res);
		if($u==1){
			?>
				<div class="tabs">
					<button id="b1" class="b cur" onclick="openC('a1', 'b1')">Edit posts</button>
					<button id="b2" class="b" onclick="openC('a2', 'b2')">Edit menu</button>
					<button id="b3" class="b" onclick="openC('a3', 'b3')">Statistic</button>
				</div>
				<div id="a1" class="tab_c">
					<?php
						if($_GET['p_n']=="add"){//htmlentities()
							que('INSERT INTO posts SET id="'.$_POST["id"].'", name="'.$_POST["name"].'", time="'.date('d \of F, Y').'", text="'.$_POST["text"].'", unix="'.time().'", type="'.$_POST["type"].'", src="'.$_POST["src"].'", pop="0"');
							mkdir('../posts/'.$_POST["id"].'/');
							copy('../posts/1/index.php','../posts/'.$_POST["id"].'/index.php');
							echo 'Ready<br><a href="'._LOCATION_.'adm/">Next</a>';
						}
						else if(isset($_GET['p_d'])){
							que('SELECT name FROM posts WHERE id="'.$_GET['p_d'].'"');
							$row=mysql_fetch_array($res);
							echo 'Are you sure?<br>'.$row['name'].'<br><a href="'._LOCATION_.'adm/?p_dl='.$_GET['p_d'].'">Yes</a><br><a href="'._LOCATION_.'adm/">No</a>';
						}
						else if(isset($_GET['p_dl'])){
							echo var_dump(unlink("../posts/".$_GET['p_dl']."/index.php")).'<br>';
							echo var_dump(rmdir("../posts/".$_GET['p_dl']."/")).'<br>';
							que('DELETE FROM posts WHERE id="'.$_GET['p_dl'].'"');
							echo 'Deleted<br><a href="'._LOCATION_.'adm/">Next</a>';
						}
						else if(isset($_GET['p_v'])){
							if($_GET['p_v']=='new'){
								for($u=1,$i=1;$u!=1;$i++){
									que('SELECT id FROM posts WHERE id="'.$i.'"');
									$u=mysql_num_rows($res);
								}
								function e_v($name){
									echo ucfirst($name).':<input type="text" style="width:60vw" name="'.$name.'"';
									if($name=='id')
										echo ' value="'.$i.'"';
									echo '><br>';	
								}
								echo '<form action="index.php?p_n=add" method="post"><br>';
								e_v('id');
								e_v('name');
								e_v('text');
								e_v('type');
								e_v('src');
								e_v('keyw');
								e_v('vis');
								echo '<input type="submit" value="Add">
								</form>';
							}
							else if(isset($_POST['id'])){
								que('UPDATE posts SET name="'.$_POST["name"].'", time="'.$_POST["time"].'", text="'.preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $_POST['text'])).'", unix="'.$_POST["unix"].'", type="'.$_POST["type"].'", keyw="'.$_POST['keyw'].'", src="'.$_POST["src"].'", pop="'.$_POST['pop'].'" WHERE id="'.$_POST['id'].'"');
								echo 'Ready<br><a href="'._LOCATION_.'adm/">Next</a>';
							}
							else {
								que('SELECT * FROM posts WHERE id="'.$_GET['p_v'].'"');
								$row=mysql_fetch_array($res);
								function e_p($name){
									global $row;
									$str=preg_replace('/"/' ,'&#34;', preg_replace("/'/" ,"&#39;", $row[$name]));
									echo ucfirst($name).':<input type="text" style="width:60vw" name="'.$name.'" value="'.$str.'"><br>';	
								}
								echo '<form action="index.php?p_v='.$row['id'].'" method="post"><input type="hidden" name="id" value="'.$row['id'].'">
									ID: '.$row['id'].'<br>';
								e_p('id');
								e_p('name');
								e_p('time');
								e_p('text');
								e_p('unix');
								e_p('type');
								e_p('src');
								e_p('keyw');
								e_p('pop');
								e_p('vis');
								echo '<a href="'._LOCATION_.'adm/?p_d='.$row['id'].'">Delete</a><input type="submit" value="Edit">
								</form>';
							}
						}
						else {
						echo '<a href="'._LOCATION_.'adm/?p_v=new">Add new post</a><br><div class="format">';
						que('SELECT * FROM posts ORDER BY unix+0 ASC');
						while ($row=mysql_fetch_array($res)){
							echo '<div class="posts">
								<img class="l" src="'.$row['src'].'">
								<a class="ar" href="'._LOCATION_.'adm/?p_v='.$row["id"].'">'.$row['name'].'</a>
								<div>
									<br><img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
									<p>'.$row['time'].'</p>
								</div>
								<p>'.substr($row['text'],0,256).'...</p>
							</div>';
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
						que("SELECT vis,name,pop FROM posts ORDER BY pop+0 DESC");
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
						que("SELECT id FROM posts");
						$u=mysql_num_rows($res);
						que("SELECT id FROM posts WHERE vis=0");
						$u2=mysql_num_rows($res);
						echo 'На сайті є '.$u.' постів, які прочитані '.$iii.' разів. Серед них, '.$u2.' постів є прихованими<br>';
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
		c();?>
		<script> function redir(where) { window.location.href = where; } </script>
	</body>
</html>