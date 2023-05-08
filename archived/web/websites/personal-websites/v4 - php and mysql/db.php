<?
$mysql_login='MYSQL_LOGIN';
$mysql_host='MYSQL_HOST';
$mysql_pass='MYSQL_PASSWORD';
$mysql_db='MYSQL_DB';
mysql_connect($mysql_host,$mysql_login,$mysql_pass);
mysql_select_db($mysql_db);



if (isset($_GET['idlink'])){
	$idlink=$_GET['idlink'];
	if ($idlink>0)
	$query = "SELECT `link` FROM `menu` WHERE `id`='$idlink'";
	$res = mysql_query($query) or die(mysql_error());
	while ($row=mysql_fetch_array($res)){
		$link_selekt=$row['link'];
	}	
	print "I selekted ".$link_selekt." with ID:".$idlink."";
}
	$query = "SELECT * FROM menu WHERE 1=1";
	$res = mysql_query($query) or die(mysql_error());
	while ($row=mysql_fetch_array($res))
	{
		$id=$row['id'];
		$name=$row['name'];
		$link=$row['link'];
		?>
		<div>
			<a href="?idlink=<?=$id?>"><?=$name?></a>
		</div>	
		<?
	}
?>