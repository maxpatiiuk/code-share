<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
	<?php
	require_once dirname(__FILE__) . '/functions/main.php';
	head(1);
	?>
</head>
<body>
	<?php top();
	que('SELECT * FROM ' . _SLIDER_);
	$u = mysql_num_rows($res);
	if($u > 0) {
		$psrc = LINK . 'images/slider/img_'; ?>
		<div id="myCarousel_2" class="carousel slide" style="height:30vw;overflow:hidden" data-ride="carousel">
		<ol class="carousel-indicators"><?php
			for($i = 0; $i < $u; $i++) {
				echo '<li data-target="#myCarousel_2" data-slide-to="' . $i . '"';
				if($i == 0)
					echo ' class="active"';
				echo '></li>';
			} ?>
		</ol>
		<div class="carousel-inner"><?php
			$i = 0;
			while($row = mysql_fetch_array($res)) {
				if(@getimagesize($psrc . $row['id'] . '.jpg'))
					$sliderSrc = 'jpg';
				else if(@getimagesize($psrc . $row['id'] . '.png'))
					$sliderSrc = 'png';
				else if(@getimagesize($psrc . $row['id'] . '.tiff'))
					$sliderSrc = 'tiff';
				else if(@getimagesize($psrc . $row['id'] . '.gif'))
					$sliderSrc = 'gif';
				echo '<div class="item';
				if($i == 0)
					echo ' active';
				echo '"><img src="' . LINK . 'images/slider/img_' . $row['id'] . '.' . $sliderSrc . '"';
				if(strlen($row['text']) > 0)
					echo ' alt="' . $row['text'] . '"><div class="carousel-caption hidden-xs"><h3>' . $row['text'] . '</h3></div></div>';
				else echo '></div>';
				$i++;
			} ?>
		</div>
		<a class="left carousel-control" href="#myCarousel_2" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel_2" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
		</div><?php
	}
	echo '<div class="row">
			<div class="col-xs-12 col-md-9">';
	if($type == 1 || $type == 2) {
		echo '<div class="btn-group">
						<a href="' . LINK . 'adm/materials.php" class="btn btn-success" style="color:#fff">Матеріали';
		/*que('SELECT id FROM ' . _POSTS_ . ' WHERE type="1" AND checked="0"');
		$u = mysql_num_rows($res);
		if($u > 0)
			echo ' <span class="badge">' . $u . '</span>';*/
		echo '</a>
						<a href="' . LINK . 'adm/materials.php?a=addPost" class="btn btn-success" style="color:#fff">Додати матеріал</a>
						<a href="' . LINK . 'adm/tests.php" class="btn btn-success" style="color:#fff">Тести';
		/*que('SELECT id FROM ' . _POSTS_ . ' WHERE type="2" AND checked="0"');
		$u = mysql_num_rows($res);
		if($u > 0)
			echo ' <span class="badge">' . $u . '</span>';*/
		echo '</a>';
		if($type==2){
			echo '<a href="' . LINK . 'adm/stats.php" class="btn btn-success" style="color:#fff">Налаштування</a>';
			echo '<a href="' . LINK . 'adm/slider.php" class="btn btn-success" style="color:#fff">Слайдер</a>';
		}
		echo '</div>';
	}

	//SETTINGS
	$a = array('/\\\\\\|\\//', '/&#60;/', '/&#62;/', '/&#34;/', '/&#32;/', '/<\?=LINK\?>/', '/<br>/', '/\\\\n/', '/' . PHP_EOL . '/');
	$b = array('', '<', '>', '"', "'", LINK, ' ', ' ', ' ');


	//FUNCTIONS
	function to_class($class) {

		if($class == 0)
			return 'Всі класи';
		else if($class == -1)
			return 'Випусники';
		else
			return $class;
	}

	function displayPost($data) {

		global $a, $b;

		if(!array_key_exists('id', $data) || !is_numeric($data['id']))
			return false;

		$src = null;

		if($data['type'] == 2)
			$url = 'p/t';
		else
			$url = 'p/m';

		$content = substr(strip_tags(preg_replace($a, $b, $data['content'])), 0, 512);

		$creator_name = getName($data['creator_name']);

		$finding = strpos($data['content'], 'img_');
		if($finding === false)
			$image = _DEAFULT_AVA_;
		else {
			$sub_source = substr($data['content'], $finding, 20);
			$src = substr($sub_source, 0, stripos($sub_source, '&#34;'));
			$image = LINK . $url . '/' . $data['link'] . '/' . $src;

			if(strlen($src) < 1)
				$image = _DEAFULT_AVA_;
		}

		echo '<div class="posts">
			<a href="' . LINK . $url . '/' . $data['link'] . '/">
				<img class="l" src="' . $image . '">
				<h2 class="hidden-xs hidden-sm">' . $data['name'] . '</h2>
				<h4 class="visible-xs visible-sm">' . $data['name'] . '</h4>
			</a>
			<div>
				<img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
				<p>' . $data['date'] . ', ' . $creator_name;
		if(strlen($data['category']))
			echo ', Категорія: ' . $data['category'];
		if(strlen($data['class']))
			echo ', Класс: ' . to_class($data['class']);
		echo '</p>
			</div>
			<p style="overflow:hidden">' . $content;
		if(strlen($data['content']) > 512)
			echo '...';
		echo '</p>
		</div>';
		return true;
	}

	function showBack($author = false, $class = false) {

		if(!$author)
			echo '<a class="btn btn-success" style="color:#fff" href="' . LINK . '">На головну</a>';
		else if(!$class && $class !== 0)
			echo '<a class="btn btn-success" style="color:#fff" href="' . LINK . '?author=' . $author . '">Повернутися назад</a>';
		else
			echo '<a class="btn btn-success" style="color:#fff" href="' . LINK . '?author=' . $author . '&class=' . $class . '">Повернутися назад</a>';
	}

	function showCategories($author, $class) {

		global $res;
		echo '<div class="row" style="padding:15px;margin:0"><h1>Категорії</h1>';
		que('SELECT DISTINCT id,category FROM ' . _POSTS_ . ' WHERE category IN (SELECT DISTINCT category FROM ' . _POSTS_ . ' WHERE checked=1 AND creator_name="' . $author . '" AND class="' . $class . '") GROUP BY category');
		while($row = mysql_fetch_assoc($res))
			echo '<a href="' . LINK . '?author=' . $author . '&class=' . $class . '&category=' . $row['id'] . '" class="col-xs-12 text-center category">' . $row['category'] . '</a>';
		echo '</div>';
	}

	function showClasses($author) {

		global $res;
		que('SELECT id,login,email,u_name,u_surname,u_date,facebook,youtube,instagram,twiter,vk,about,edu,city,phone FROM ' . _USERS_ . ' WHERE id=' . $author);
		$row = mysql_fetch_assoc($res);


		$data = '';
		$data .= '<div class="row" style="padding:15px;margin:0">';

		$lsrc = LINK . 'images/p/' . str_rot13($row['login']) . '.';
		if(@getimagesize($lsrc . 'jpg'))
			$srr = $lsrc . 'jpg';
		else if(@getimagesize($lsrc . 'png'))
			$srr = $lsrc . 'png';
		else if(@getimagesize($lsrc . 'tiff'))
			$srr = $lsrc . 'tiff';
		else if(@getimagesize($lsrc . 'gif'))
			$srr = $lsrc . 'gif';
		else
			$srr = "https://s8.hostingkartinok.com/uploads/images/2017/05/9dd1775eb98d5be16bbf04579c3e9ab4.png";
		if(strlen($row['u_name']) > 1 && strlen($row['u_surname']) > 1)
			$creator_name = $row['u_name'] . ' ' . $row['u_surname'];
		else
			$creator_name = str_rot13($row['login']);


		$data .= '<div class="col-xs-12 thumbnail">
			<a href="' . LINK . 'profile/?id=' . $row['id'] . '" class="col-xs-2 l" style="border-radius: 100vh; position: relative; padding-bottom: 16.66667%; overflow: hidden;">
				<img style="padding: 0; position: absolute; top: 0; left: 0; width: 100%; min-height: 100%;" src="' . $srr . '" alt="' . $row['id'] . '">
			</a>
			<div class="col-xs-10 l">';
		$data .= '<a style="width:100%;position:relative;" href="' . LINK . 'profile/?id=' . $row['id'] . '"><h3>' . $creator_name . '</h3></a>
									<p>Email: ' . $row['email'] . '</p>';
		if(strlen($row['about']))
			$data .= '<p>Про мене: ' . $row['about'] . '</p>';
		if(strlen($row['phone']))
			$data .= '<p>Номер телефону: ' . $row['phone'] . '</p>';
		if(strlen($row['u_date']))
			$data .= '<p>Дата народження: ' . $row['u_date'] . '</p>';
		if(strlen($row['facebook']) || strlen($row['youtube']) || strlen($row['twiter']) || strlen($row['instagram']) || strlen($row['vk'])) {
			$data .= '<p>Соц мережі:';
			if(strlen($row['facebook']))
				$data .= ' <a href="' . $row['facebook'] . '" target="_blank">Facebook</a>';
			if(strlen($row['youtube']))
				$data .= ' <a href="' . $row['youtube'] . '" target="_blank">Youtube</a>';
			if(strlen($row['twiter']))
				$data .= ' <a href="' . $row['twiter'] . '" target="_blank">Twiter</a>';
			if(strlen($row['instagram']))
				$data .= ' <a href="' . $row['instagram'] . '" target="_blank">Instagram</a>';
			if(strlen($row['vk']))
				$data .= ' <a href="' . $row['vk'] . '" target="_blank">Vk</a>';
			$data .= '</p>';
		}
		if(strlen($row['city']))
			$data .= '<p>Місце проживання: ' . $row['city'] . '</p>';
		if(strlen($row['edu']))
			$data .= '<p>Навчальний заклад: ' . $row['edu'] . '</p>';
		$data .= '</div>
							</a>
						</div>';

		$data .= '<h1>Класи</h1>';
		que('SELECT DISTINCT class FROM ' . _POSTS_ . ' WHERE checked="1" AND creator_name="' . $author . '"');
		if(mysql_num_rows($res) == 0)
			$data.='<p>Цей вчитель ще не виклав свої матеріали в жоден з класів</p>';
		while($row = mysql_fetch_assoc($res))
			$data .= '<a href="' . LINK . '?author=' . $author . '&class=' . $row['class'] . '" class="col-xs-12 text-center category">' . to_class($row['class']) . '</a>';
		$data .= '</div>';


		echo $data;
	}

	function showAuthors() {

		global $res;
		echo '<div class="row" style="padding:15px;margin:0"><h1>Вчителі</h1>';
		que('SELECT id,login,u_name,u_surname FROM ' . _USERS_.' WHERE type!=2');// . ' WHERE id IN ( SELECT DISTINCT creator_name FROM ' . _POSTS_ . ' WHERE checked="1")'
		while($row = mysql_fetch_assoc($res))
			echo '<a href="' . LINK . '?author=' . $row['id'] . '" class="col-xs-12 text-center category">' . getNameLocal($row['login'], $row['u_name'], $row['u_surname']) . '</a>';
		echo '</div>';
	}


	//DISPLAY POSTS WITH FILTERS
	if(is_numeric($_GET['author']) && $_GET['author'] >= 0 && $_GET['author'] <= 100000) {
		$selectedAuthor = true;
		$author = $_GET['author'];
		$authorQuery = ' creator_name="' . $author . '"';

		if(is_numeric($_GET['class']) && $_GET['class'] >= -1 && $_GET['class'] <= 100000) {
			$selectedClass = true;
			$class = $_GET['class'];
			$classQuery = ' AND class="' . $class . '"';

			if(is_numeric($_GET['category']) && $_GET['category'] >= 0 && $_GET['category'] <= 100000) {
				$selectedCategory = true;
				que('SELECT category FROM ' . _POSTS_ . ' WHERE id=' . $_GET['category'] . ' LIMIT 1');
				$row = mysql_fetch_assoc($res);
				$category = $row['category'];
				$categoryQuery = ' AND category="' . $category . '"';
			}
		}

		que('SELECT id,link,name,content,type,unixTime,creator_name,category,class FROM ' . _POSTS_ . ' WHERE checked=1 AND ' . $authorQuery . $classQuery . $categoryQuery . ' ORDER BY unixTime+0 DESC', 2);

		if($selectedCategory)
			showBack($author, $class);
		else if($selectedClass) {
			showBack($author);
			showCategories($author, $class);
		}
		else if($selectedAuthor) {
			showBack();
			showClasses($author);
		}

		while($row = mysql_fetch_assoc($ras))
			displayPost($row);
	}
	//DISPLAY ALL NEWS
	else {
		showAuthors();
		que('SELECT id,link,name,type,content,unixTime,creator_name,category,class FROM ' . _POSTS_ . ' WHERE checked=1 AND add2mainp=1 ORDER BY unixTime+0 DESC', 2);
		while($row = mysql_fetch_assoc($ras))
			displayPost($row);
	}


	/*if(is_numeric($_GET['category']) && $_GET['category'] > 0 && $_GET['category'] <= 100000) {
		que('SELECT category FROM ' . _POSTS_ . ' WHERE id="' . $_GET['category'] . '"');
		$row = mysql_fetch_array($res);
		$buf = $row['category'];
		if(isset($_GET['subcategory'])) {
			que('SELECT subcategory FROM ' . _POSTS_ . ' WHERE id="' . $_GET['subcategory'] . '"');
			$row = mysql_fetch_array($res);
			$buf2 = $row['subcategory'];
			echo '<div class="row" style="padding:15px;margin:0;"><h1>' . $buf2 . '</h1></div>';
			que('SELECT * FROM ' . _POSTS_ . ' WHERE checked="1" AND category="' . $buf . '" AND subcategory="' . $buf2 . '"');
			while($row = mysql_fetch_array($res)) {
				$src = null;
				if($row['type'] == 1)
					$url = 'p/m';
				else if($row['type'] == 2)
					$url = 'p/t';
				else
					$url = 'p';
				if(is_numeric($_GET['class']) && $_GET['class'] > 0 && $_GET['class'] <= 12) {
					que('SELECT class FROM ' . _USERS_ . ' WHERE id="' . $row['creator_name'] . '"', 2);
					$raw = mysql_fetch_array($ras);
					if($raw['class'] != $_GET['class'])
						continue;
				}
				$content = substr(strip_tags(preg_replace($a, $b, $row['content'])), 0, 512);
				$ras = mysql_query('SELECT login,u_name,u_surname,class FROM ' . _USERS_ . ' WHERE id="' . $row['creator_name'] . '"');
				$raw = mysql_fetch_array($ras);
				$creatorClass = $raw['class'];
				if(strlen($raw['u_name']) > 1 && strlen($raw['u_surname']) > 1)
					$creator_name = $raw['u_name'] . ' ' . $raw['u_surname'];
				else
					$creator_name = str_rot13($raw['login']);
				echo '<div class="posts a' . $creatorClass . '" subcategory="' . $row['subcategory'] . '">
								<a href="' . LINK . $url . '/' . $row['link'] . '/">
									<img class="l" src="';
				for($src = null, $i = 0; $i < 100; $i++) {
					if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpg')) {
						$src = 'jpg';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpeg')) {
						$src = 'jpeg';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jfjf')) {
						$src = 'jfjf';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.bmp')) {
						$src = 'bmp';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.png')) {
						$src = 'png';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.tiff')) {
						$src = 'tiff';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.gif')) {
						$src = 'gif';
						break;
					}
				}
				if(isset($src))
					echo LINK . $url . '/' . $row['link'] . '/img_' . $i . '.' . $src;
				else
					echo 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
				echo '">
									<h2 class="hidden-xs hidden-sm">' . $row['name'] . '</h2>
									<h4 class="visible-xs visible-sm">' . $row['name'] . '</h4>
								</a>
								<div>
									<img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
									<p>' . $row['date'] . ', ' . $creator_name;
				if(strlen($row['subcategory']) > 1)
					echo ', Під категорія: ' . $row['subcategory'];
				echo '</p>
								</div>
								<p style="overflow:hidden">' . $content;
				if(strlen($row['content']) > 512)
					echo '...';
				echo '</p>
							</div>';
			}
		}
		else {
			echo '<div class="row" style="padding:15px;margin:0;">
							<h1>' . $buf . '</h1>';
			que('SELECT id,subcategory FROM ' . _POSTS_ . ' WHERE category="' . $buf . '"');
			$arr = null;
			while($row = mysql_fetch_array($res))
				$arr[$row['id']] = $row['subcategory'];
			$result = array_unique($arr);
			foreach($result as $key => $val)
				if(strlen($val) > 1)
					echo '<a href="' . LINK . '?category=' . $_GET['category'] . '&subcategory=' . $key . '" class="col-xs-12 text-center category" href="">' . $val . '</a>';
			echo '</div>';
			que('SELECT * FROM ' . _POSTS_ . ' WHERE checked="1" AND category="' . $buf . '"');
			while($row = mysql_fetch_array($res)) {
				$src = null;
				if($row['type'] == 1)
					$url = 'p/m';
				else if($row['type'] == 2)
					$url = 'p/t';
				else
					$url = 'p';
				if(is_numeric($_GET['class']) && $_GET['class'] > 0 && $_GET['class'] <= 12) {
					que('SELECT class FROM ' . _USERS_ . ' WHERE id="' . $row['creator_name'] . '"', 2);
					$raw = mysql_fetch_array($ras);
					if($raw['class'] != $_GET['class'])
						continue;
				}
				$content = substr(strip_tags(preg_replace($a, $b, $row['content'])), 0, 512);
				$ras = mysql_query('SELECT login,u_name,u_surname,class FROM ' . _USERS_ . ' WHERE id="' . $row['creator_name'] . '"');
				$raw = mysql_fetch_array($ras);
				$creatorClass = $raw['class'];
				if(strlen($raw['u_name']) > 1 && strlen($raw['u_surname']) > 1)
					$creator_name = $raw['u_name'] . ' ' . $raw['u_surname'];
				else
					$creator_name = str_rot13($raw['login']);
				echo '<div class="posts a' . $creatorClass . '" subcategory="' . $row['subcategory'] . '">
								<a href="' . LINK . $url . '/' . $row['link'] . '/">
									<img class="l" src="';
				for($src = null, $i = 0; $i < 100; $i++) {
					if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpg')) {
						$src = 'jpg';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpeg')) {
						$src = 'jpeg';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jfjf')) {
						$src = 'jfjf';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.bmp')) {
						$src = 'bmp';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.png')) {
						$src = 'png';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.tiff')) {
						$src = 'tiff';
						break;
					}
					else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.gif')) {
						$src = 'gif';
						break;
					}
				}
				if(isset($src))
					echo LINK . $url . '/' . $row['link'] . '/img_' . $i . '.' . $src;
				else
					echo 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
				echo '">
									<h2 class="hidden-xs hidden-sm">' . $row['name'] . '</h2>
									<h4 class="visible-xs visible-sm">' . $row['name'] . '</h4>
								</a>
								<div>
									<img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
									<p>' . $row['date'] . ', ' . $creator_name;
				if(strlen($row['subcategory']) > 1)
					echo ', Під категорія: ' . $row['subcategory'];
				echo '</p>
								</div>
								<p style="overflow:hidden">' . $content;
				if(strlen($row['content']) > 512)
					echo '...';
				echo '</p>
							</div>';
			}
		}
	}
	else { ?>
	<div class="row" style="padding:15px;margin:0;">
		<h1>Предмети</h1><?php
		que('SELECT id FROM ' . _USERS_ . ' u WHERE u.id IN (SELECT DISTINCT creator_name FROM ' . _POSTS_ . ')');
		while($row = mysql_fetch_array($res)) {
			$name = getName($row['id']);
			if(strlen($name) > 1)
				echo '<a href="' . LINK . '?category=' . $row['id'] . '" class="col-xs-12 text-center category">' . $name . '</a>';
		}
		?>
	</div> <?php
	que('SELECT * FROM ' . _POSTS_ . ' WHERE checked=1 AND add2mainp=1 ORDER BY unixTime+0 DESC');
	$u = mysql_num_rows($res);
	if($u < 10)
		$p = 1;
	$a = array('/\\\\\\|\\//', '/&#60;/', '/&#62;/', '/&#34;/', '/&#32;/', '/<\?=LINK\?>/', '/<br>/', '/\\\\n/', '/' . PHP_EOL . '/');
	$b = array('', '<', '>', '"', "'", LINK, ' ', ' ', ' ');
	for($ii = 1; $row = mysql_fetch_array($res); $ii++) {
		if($ii <= ($p - 1) * 10 || $ii > $p * 10)
			continue;
		$src = null;
		if($row['type'] == 1)
			$url = 'p/m';
		else if($row['type'] == 2)
			$url = 'p/t';
		else
			$url = 'p';
		$content = substr(strip_tags(preg_replace($a, $b, $row['content'])), 0, 512);
		$ras = mysql_query('SELECT login,u_name,u_surname,class FROM ' . _USERS_ . ' WHERE id="' . $row['creator_name'] . '"');
		$raw = mysql_fetch_array($ras);
		$creatorClass = $raw['class'];
		if(strlen($raw['u_name']) > 1 && strlen($raw['u_surname']) > 1)
			$creator_name = $raw['u_name'] . ' ' . $raw['u_surname'];
		else
			$creator_name = str_rot13($raw['login']);
		echo '<div class="posts a' . $creatorClass . '" category="' . $row['category'] . '">
							<a href="' . LINK . $url . '/' . $row['link'] . '/">
								<img class="l" src="';
		for($src = null, $i = 0; $i < 100; $i++) {
			if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpg')) {
				$src = 'jpg';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jpeg')) {
				$src = 'jpeg';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.jfjf')) {
				$src = 'jfjf';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.bmp')) {
				$src = 'bmp';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.png')) {
				$src = 'png';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.tiff')) {
				$src = 'tiff';
				break;
			}
			else if(@getimagesize(LINK . $url . '/' . $row['link'] . '/img_' . $i . '.gif')) {
				$src = 'gif';
				break;
			}
		}
		if(isset($src))
			echo LINK . $url . '/' . $row['link'] . '/img_' . $i . '.' . $src;
		else
			echo 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
		echo '">
								<h2 class="hidden-xs hidden-sm">' . $row['name'] . '</h2>
								<h4 class="visible-xs visible-sm">' . $row['name'] . '</h4>
							</a>
							<div>
								<img class="l" src="http://s8.hostingkartinok.com/uploads/images/2016/12/5a330a5976d9636190e23594b9644909.png">
								<p>' . $row['date'] . ', ' . $creator_name;
		if(strlen($row['category']) > 1)
			echo ', Категорія: ' . $row['category'];
		echo '</p>
							</div>
							<p style="overflow:hidden">' . $content;
		if(strlen($row['content']) > 512)
			echo '...';
		echo '</p>
						</div>';
	}
	}*/
	?>
	</div>
	<div class="col-xs-12 col-md-3">
		<div class="visible-xs visible-sm"><br><br></div>
		<h2 style="color: #27c;padding-top: 30px">Контакти</h2>
		<hr>
		<?php if(_TEL1_ != null || _TEL2_ != null) echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">Телефон:</h3>';
		if(_TEL1_ != null) echo '<p>' . _TEL1_ . '</p>';
		if(_TEL2_ != null) echo '<p>' . _TEL2_ . '</p>';
		echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">E-mail:</h3><p>' . _EMAIL_ . '</p><a color: #27c; href="mailto:' . _EMAIL_ . '">Написати повідомлення</a>';
		if(_ADDRESS_ != null) echo '<h3	style="font-size: 21px;padding: 10px 0 5px 0;">Адреса:</h3><p>' . _ADDRESS_ . '</p>';
		socialML();
		?></div>
	<?php down(); ?>
</body>
<html>