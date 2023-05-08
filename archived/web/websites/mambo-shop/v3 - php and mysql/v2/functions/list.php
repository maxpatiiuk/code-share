<?php
	function products($nom){
		global $res;
		$que="SELECT vis,id,url,price,s1,name FROM products WHERE vis=1 ORDER BY ";
		if($nom==1)
			$que.="id+0,pop+0";
		if($nom==2)
			$que.="pop+0 DESC,id+0";
		if($nom==3)
			$que.="price+0,id+0";
		if($nom==4)
			$que.="price+0 DESC,id+0";
		if($nom==5)
			$que.="date+0 DESC,id+0";
		que($que);
		echo '<div class="format"><!--'.$que.'-->';
		while ($row=mysql_fetch_array($res)){
			echo '<a href="'.$row["url"].'/" class="pro l">
					<div>
						<p class="p_p l">'.$row["price"].'</p>
						<p class="l">&#8372</p>
					</div>
					<img class="l" src="'.$row["s1"].'" alt="'.$row["name"].'">
					<p class="p_n l">'.$row["name"].'</p>
				</a>
			';
		}
		echo '</div>';
	}
?>