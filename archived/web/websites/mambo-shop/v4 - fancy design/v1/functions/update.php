<? function getPrice($bLink){
	$link='https://www.oplata.info/asp2/pay_wm.asp?id_d='.$bLink.'&id_po=0&ai=600788&curr=WMU&lang=ru-RU';
	$html = file_get_html($link);
	$dom=$html->find('div.goods_price');
	$price=round(preg_replace('/[^0-9.]/','',substr($dom[0],strpos($dom[0],'>'+1),strpos($dom[0],'<span>'))));
	return $price;
}
require_once 'simple_html_dom.php';
require_once 'main.php';
$id=$_GET['id'];
$a=$_GET['a'];
if(isset($a)){
	if($a=='price'){
		if($id){
			que('SELECT b_link FROM '._PRODUCTS_.' WHERE id="'.$id.'"');
			$row=mysql_fetch_array($res);
			if($u==1){
				$price=getPrice($row['b_link']);
				que('UPDATE '._PRODUCTS_.' SET b_link="'.$price.'" WHERE id="'.$id.'"');
			}
		}
		else {
			que('SELECT b_link,id FROM '._PRODUCTS_.' WHERE id!=0 AND id IS NOT NULL AND b_link IS NOT NULL'	);
			while($row=mysql_fetch_array($res)){
				$price=getPrice($row['b_link']);
				echo $price;
				echo $row['id'];
				que('UPDATE '._PRODUCTS_.' SET price="'.$price.'" WHERE id="'.$row['id'].'"');
			}
		}
	}
} ?>