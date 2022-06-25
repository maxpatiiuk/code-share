<!DOCTYPE html>
<html>
<head>

	<title>Code share</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <?php

	$l = 0;
	define('LINK', 'https:/mambo.in.ua/map/code/');
	define('FILE', 'https:/mambo.in.ua/map/code/files/');
	define('FILES', 'files/');
	$mysqli = new mysqli('localhost', 'maxxxxxdlp', 'mmaaxx221133');
	$mysqli->select_db('mambo_zzz_com_ua');

	/*

	TODO

	Soon:
	Sharing of pages
	Moving of categories
	photo compressor
	optimize2

	Later:
	User profiles
	Different versions of same file
	Syntax highlighting

	Done:
	Edit
	change arrow on hover
	blocks equal height
	register
	optimize
	debug
	debug2
	comment
	password change
	clean
	clean2
	delete > disable + confirm
	Adding links
	Adding youtube video

	*/


	//setting POST values if not existing
	/*if(strlen($_COOKIE['width'])>1 && !isset($_POST['width']))
		$_POST['width']=$_COOKIE['width'];
	if(strlen($_COOKIE['height'])>1 && !isset($_POST['height']))
		$_POST['height']=$_COOKIE['height'];*/

	//if want to logOut
	if($_GET['a'] == 'logOut') {
		setcookie('user_id');
		setcookie('code_hash');
		$l = 0;
		$_COOKIE['code_hash'] = null;
		$_COOKIE['user_id'] = null;
	}

	//change password
	if(isset($_POST['passwordSubmitted']) && strlen($_POST['password']) > 1 && $_POST['password'] < 25 && is_numeric($_COOKIE['user_id']) && $_COOKIE['user_id'] > 1)
		$mysqli->query('UPDATE code SET ext="' . htmlspecialchars($_POST['password']) . '" WHERE parrent=0 AND id="' . $_COOKIE['user_id'] . '"');

	//fetch all users
	$res = $mysqli->query('SELECT name,ext FROM code WHERE parrent=0');
	while($row = $res->fetch_row())
		$users[] = $row;

	//if register form submitted
	if(isset($_POST['registerSubmitted']) && strlen($_POST['login']) < 256 && strlen($_POST['login']) > 1 && strlen($_POST['password']) > 1 && strlen($_POST['password']) < 25) {
		$l = 1;
		$ras = $mysqli->query('SELECT id FROM code WHERE parrent=0 AND login="' . htmlspecialchars($_POST['login']) . '"');
		if($ras->num_rows)
			echo '<script>alert("This login is already takken")</script>';
		else {
			$ras = $name->query('INSERT INTO code(parrent) VALUES(0,"' . htmlspecialchars($_POST['login']) . '","' . htmlspecialchars($_POST['password']) . '")');
			setcookie('user_id', $mysqli->insert_id, time() + 9999);
			setcookie('code_hash', md5('qwe' . $_POST['login']), time() + 9999);
		}
	} //if login form submitted
	else if(isset($_POST['submit'])) {
		foreach($users as $u) {
			if($_POST['login'] == $u[0] && $_POST['password'] == $u[1]) {
				$l = 1;
				$ras = $mysqli->query('SELECT id FROM code WHERE parrent=0 AND name="' . $_POST['login'] . '"');
				$raw = $ras->fetch_assoc();
				setcookie('user_id', $raw['id'], time() + 9999);
				setcookie('code_hash', md5(/*$_POST['height'].*/
					'qwe' . $_POST['login']/*.$_POST['width']*/), time() + 9999);
				/*setcookie('width',$_POST['width'],time()+9999);
				setcookie('height',$_POST['height'],time()+9999);*/
				break;
			}
		}
	} //if is loginned
	else if(strlen($_COOKIE['code_hash']) > 5) {
		$was = 0;
		/*if($_POST['height']==NULL)
			$_POST['height']=$_COOKIE['height'];
		if($_POST['width']==NULL)
			$_POST['width']=$_COOKIE['width'];*/
		foreach($users as $u) {
			if($_COOKIE['code_hash'] == md5(/*$_POST['height'].*/
					'qwe' . $u[0]/*.$_POST['width']*/) || $_COOKIE['code_hash'] == md5(/*$_POST['width'].*/
					'qwe'/*.$u[0].$_POST['height']*/)) {
				$was = 1;
				break;
			}
		}
		if($was)
			$l = 1;
		else {
			$l = 0;
			setcookie('code_hash');
			setcookie('user_id');
			/*setcookie('width');
			setcookie('height');*/
		}
	} //else not loginned
	else
		$l = 0;

	//helper functions for formatting inputs
	function pre($name)
	{
		echo '<div class="form-group">
			<label class="control-label col-sm-2" title="' . ucfirst($name) . '" for="' . $name . '">' . ucfirst($name) . ':</label>
			<div class="col-sm-10">';
	}

	function past()
	{
		echo '</div></div>';
	}

	//if want to add
	if($l && $_GET['a'] == 'add' && is_numeric($_GET['id'])) {
		$wasAdd = true; ?>
		<div class="container no">
			<form action="index.php?r=created" method="post" enctype="multipart/form-data">
				<?php pre('name'); ?>
				<input type="text" name="name" class="form-control" placeholder="Name" id="name">
				<?php past();
				pre('content'); ?>
				<textarea class="form-control" name="content" placeholder="Content" id="content"></textarea>
				<?php past();
				pre('file'); ?>
				<input type="file" class="form-control" name="img" id="file">
				<?php past(); ?>
				<input type="hidden" name="id" value="<?= $_GET['id'] ?>">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add" class="form-control btn btn-success">
					</div>
				</div>
			</form>
		</div> <?php
	}

	//if want to edit
	if($l && is_numeric($_GET['e'])) {
		$wasEdit = true;
		$res = $mysqli->query('SELECT name,content,ext FROM `code` WHERE id="' . $_GET['e'] . '"');
		$row = $res->fetch_assoc(); ?>
		<div class="container no">
			<form action="index.php?r=edited" method="post" enctype="multipart/form-data">
				<?php pre('name'); ?>
				<input type="text" name="name" class="form-control" placeholder="Name" id="name" value="<?= $row['name'] ?>">
				<?php past();
				pre('content'); ?>
				<textarea class="form-control" name="content" placeholder="Content" id="content"><?= $row['content'] ?></textarea>
				<?php past();
				echo '<div class="col-sm-10 col-sm-offset-2">';
				if(@getimagesize(FILES . 'file_' . $_GET['e'] . '.' . $row['ext']))
					echo '<a target="_blank" href="file_' . $_GET['e'] . '.' . $row['ext'] . '"><img class="preview" src="' . FILES . 'file_' . $_GET['e'] . '.' . $row['ext'] . '"></a><br>';
				if(strlen($row['ext']) > 0 && file_exists(FILES . 'file_' . $_GET['e'] . '.' . $row['ext']))
					echo '<a href="' . FILES . 'file_' . $_GET['e'] . '.' . $row['ext'] . '" download>file_' . $_GET['e'] . '.' . $row['ext'] . '</a><br>';
				echo '</div>';
				pre('file'); ?>
				<input type="file" class="form-control" name="img" id="file">
				<?php past(); ?>
				<input type="hidden" name="id" value="<?= $_GET['e'] ?>">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Edit" class="btn btn-success">
						<a href="index.php" class="btn btn-warning">Cancel</a>
						<a href="index.php?d=<?= $_GET['e'] ?>" class="btn btn-danger ">Delete</a>
					</div>
				</div>
			</form>
		</div> <?php
	} //else show blocks
	else {

		//deleting by id
		function del($id, $real = 0)
		{
			global $mysqli;
			if($real != 1)
				$real = 0;
			$res = $mysqli->query('SELECT ext,parrent FROM code WHERE parrent!=0 AND id="' . $id . '"');
			$row = $res->fetch_assoc();
			$arr = array(
				array("id" => $id, "parrent" => $row['parrent'], "ext" => $row['ext']),
			);
			$res = $mysqli->query('SELECT id,parrent,ext FROM code WHERE parrent!=0 AND id!="' . $id . '"');
			$row = $res->fetch_assoc();
			$was = 1;
			$was2 = 0;
			$bRes = $res;

			//recursevly deleting all childs
			while($was) {
				$was = 0;
				while($row = $res->fetch_assoc()) {
					foreach($arr as $a) {
						if($a['id'] == $row['parrent']) {
							$was = 1;
							$arr[] = $row;
							break;
						}
					}
				}
				$res = $bRes;
			}
			if($real) {
				foreach($arr as $a) {
					if($a["ext"] != null)
						unlink(FILES . 'file_' . ($a['id'] - 900000) . '.' . $a['ext']);
					$mysqli->query('DELETE FROM code WHERE parrent!=0 AND id=' . $a['id']);
				}
			} else {
				$message = "\nID\tParrent\tExt";
				foreach($arr as $a) {
					$mysqli->query('UPDATE code SET id=id+900000 WHERE id=' . $a['id']);
					$message .= "\n" . $a['id'] . "\t" . $a['parrent'] . "\t" . $a['ext'];
				}
				mail('maxxxxxdlp@gmail.com', 'Code share: Confirm deletion', 'Please confirm deletion of folowing post by clicking on this link (' . LINK . '?d=' . (900000 + $id) . '&real=1) : ' . $message);
			}
		}

		//if delete button clicked
		if($l && is_numeric($_GET['d']))
			del($_GET['d'], $_GET['real']);

		//return part of path
		function line($str1, $str2)
		{
			return ' / <span onclick="showPage(' . $str1 . ')">' . $str2 . '</span>';
		}

		//if create post form submitted
		if($_GET['r'] == 'created' && strlen($_POST['name']) > 0 && strlen($_POST['id']) > 0) {

			//if post will have content
			if(isset($_POST['content'])) {
				$buf1 = ',content';
				$buf2 = ',"' . htmlspecialchars($_POST['content']) . '"';
			} else {
				$buf1 = null;
				$buf2 = ',""';
			}

			//if post will have file
			if($_FILES['img']['size'] > 0) {
				$buf3 = ',ext';
				$buf4 = ',"' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION) . '"';
			} else {
				$buf3 = null;
				$buf4 = ',""';
			}

			//getting id of new post
			$res = $mysqli->query('SELECT (MAX(id)+1) AS id FROM `code` WHERE id<900000');
			$row = $res->fetch_assoc();

			//inserting data
			$mysqli->query('INSERT INTO code VALUES(' . $row['id'] . ',"' . $_POST['name'] . '","' . $_POST['id'] . '"' . $buf2
				. $buf4 . ')');


			//if isset user_id, set him as post creator
			if(is_numeric($_COOKIE['user_id'])) {
				$ras = $mysqli->query('SELECT content FROM code WHERE parrent=0 AND id=' . $_COOKIE['user_id']);
				$raw = $ras->fetch_row();
				$mysqli->query('UPDATE code SET content="' . $raw[0] . ':' . $row['id'] . '" WHERE parrent=0 AND id=' . $_COOKIE['user_id']);
			}

			//Delete file with same name if exist
			unlink(FILES . 'file_' . $row['id'] . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

			//if file was uploaded
			if($_FILES['img']['size'] > 0) {

				//if size less than 3mb, save file
				if($_FILES['img']['size'] < 1024 * 1024 * 3)
					move_uploaded_file($_FILES['img']['tmp_name'], FILES . 'file_' . $row['id'] . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
				else
					echo '<script>alert(\'File size is too big. Max size: 3mb\')</script>';


			}
		}

		//if edit post form submitted
		if($_GET['r'] == 'edited' && is_numeric($_POST['id']) && strlen($_POST['name']) > 0) {

			//if file was uploaded
			if($_FILES['img']['size'] > 0) {

				//if size less than 3mb, save file
				if($_FILES['img']['size'] < 1024 * 1024 * 3) {
					$bufSql = ', ext="' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION) . '"';

					//Delete file with same name if exist
					$ras = $mysqli->query('SELECT ext FROM `code` WHERE id="' . $_POST['id'] . '"');
					$raw = $ras->fetch_assoc();
					if(strlen($raw['ext']) > 1)
						unlink(FILES . 'file_' . $_POST['id'] . '.' . $raw['ext']);

					move_uploaded_file($_FILES['img']['tmp_name'], FILES . 'file_' . $_POST['id'] . '.' . pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
				} else {
					$bufSql = null;
					echo '<script>alert(\'File size is too big. Max size: 3mb\')</script>';
				}
			}

			//inserting data
			$mysqli->query('UPDATE `code` SET name="' . htmlspecialchars($_POST['name']) . '", content="' . htmlspecialchars($_POST['content']) . '"' . $bufSql . ' WHERE id=' . $_POST['id']);
		}

		//select all visible posts
		//$res=$mysqli->query('SELECT * FROM code WHERE parrent!=0');

		//if loginned, select all id
		//if($l){
		$res = $mysqli->query('SELECT * FROM code WHERE parrent!=0 AND id<900000 ORDER BY id');
		$arr[] = -1;
		while($row = $res->fetch_assoc()) {
			$data[$row['id']] = $row;
			$arr[] = $row['id'];
		}
		//}

		//else
		/*else {
			$res=$mysqli->query('SELECT DISTINCT parrent FROM code WHERE parrent!=0');
			while($row=$res->fetch_assoc())
				$arr[]=$row['parrent'];
			$res=$mysqli->query('SELECT DISTINCT id FROM code WHERE parrent!=0 AND (content!="" OR ext!="")');
			while($row=$res->fetch_assoc())
				$arr[]=$row['id'];
			$res=$mysqli->query('SELECT * FROM code WHERE parrent!=0');
			while($row=$res->fetch_assoc())
				$data[$row['id']]=$row;
		}*/

		//deleting duplicates from array
		$arr = array_unique($arr);

		//creating line fro main page
		$data[-1]['line'] = substr(line(-1, 'Головна'), 3);

		//coping names and contents into $users
		$res = $mysqli->query('SELECT name,content FROM code WHERE parrent=0');
		while($row = $res->fetch_row())
			$users[] = $row;

		function hasChilds($id)
		{
			global $arr;
			foreach($arr as $d)
				if($d['parrent'] == $id)
					return true;
			return false;
		}

		function text2url($value, $showimg = 1, $protocols = array('http', 'mail', 'https', 'twitter'), array $attributes = array('target' => '_blank'))
		{
			$attr = '';
			foreach($attributes as $key => $val)
				$attr = ' ' . $key . '="' . htmlentities($val) . '"';
			$links = array();
			$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function($match) use (&$links) {
				return '<' . array_push($links, $match[1]) . '>';
			}, $value);
			foreach((array)$protocols as $protocol) {
				switch($protocol) {
					case 'http':
					case 'https':
						$value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
							function($match) use ($protocol, &$links, $attr, $showimg) {
								if($match[1]) {
									$protocol = $match[1];
									$link = $match[2] ?: $match[3];
									if($showimg == 1) {
										if(strpos($link, 'youtube.com') > 0 || strpos($link, 'youtu.be') > 0) {
											$link = '<iframe width="500" height="294" src="https://www.youtube.com/embed/' . end(explode('=', $link)) . '?modestbranding=1" frameborder="0" allowfullscreen></iframe>';
											return '<' . array_push($links, $link) . '></a>';
										}
										if(strpos($link, '.png') > 0 || strpos($link, '.jpg') > 0 || strpos($link, '.jpeg') > 0 || strpos($link, '.gif') > 0 || strpos($link, '.bmp') > 0) {
											return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\"><img src=\"$protocol://$link\" class=\"htmlimg\">") . '></a>';
										}
									}
									return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\">$link</a>") . '>';
								}
							}, $value);
						break;
					case 'mail':
						$value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function($match) use (&$links, $attr) {
							return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>';
						}, $value);
						break;
					case 'twitter':
						$value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function($match) use (&$links, $attr) {
							return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\" class=\"htmllink\">{$match[0]}</a>") . '>';
						}, $value);
						break;
					default:
						$value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function($match) use ($protocol, &$links, $attr) {
							return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>';
						}, $value);
						break;
				}
			}
			return preg_replace_callback('/<(\d+)>/', function($match) use (&$links) {
				return $links[$match[1] - 1];
			}, $value);
		}

		/*
		//replace links with <a> tag/*
		function make_links_blank($text){
			return preg_replace(array('/(?(?=<a[^>]*>.+<\/a>)(?:<a[^>]*>.+<\/a>)|([^="\']?)((?:https?|ftp|bf2|):\/\/[^<> \n\r]+)
						)/iex','/<a([^>]*)target="?[^"\']+"?/i','/<a([^>]+)>/i','/(^|\s)(www.[^<> \n\r]+)/iex','/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)
					(\\.[A-Za-z0-9-]+)*)/iex'),
				array("stripslashes((strlen('\\2')>0?'\\1<a href=\"\\2\">\\2</a>\\3':'\\0'))",'<a\\1','<a\\1 target="_blank">',"stripslashes((strlen('\\2')>0?'\\1<a href=\"http://\\2\">\\2</a>\\3':'\\0'))","stripslashes((strlen('\\2')>0?'<a href=\"mailto:\\0\">\\0</a>':'\\0'))"),$text);
		}

		//replace links to youtube video with iframe
		function makeIframes($str){
			$regex[0]='/<a href="((http|https)(:\/\/))?(www.)?youtu.?be(.com)?\/?(watch\?v=)?/';
			$replaceWith[0]='<iframe type="text/html" width="720" height="405"
			src="https://www.youtube.com/embed/';
			$regex[1]='/" target="_blank">((http|https)(:\/\/))?(www.)?youtu.?be(.com)?\/?(watch\?v=)?[A-Za-z0-9_\-]*.*<\/a>/';
			$replaceWith[1]='" frameborder="0" allowfullscreen></iframe>';
			$result=preg_replace($regex,$replaceWith,$str);
			return $result;
		}
		*/

		//creating content for block by id
		function cont($id)
		{
			global $data, $arr, $l, $users; ?>
			<div class="container" <?php
			if($id != -1)
				echo ' style="display: none"'; ?> id="page_<?= $id ?>">
				<div class="row">
					<div class="container-fluid">
						<ul class="nav navbar-nav">
							<li class="link"><?= $data[$id]['line'] ?></li>
						</ul>
						<ul class="nav navbar-nav navbar-right"> <?php

							//show login link if not loggined
							if($l)
								echo '<li><a href="?a=logOut">Log out</a></li>
														<li onClick="showPage(\'newPas\')"><a>New pas</a></li>';
							else
								echo '<li onClick="showPage(\'logIn\')"><a>Log in</a></li>'; ?>

						</ul>
					</div> <?php

					//echo var_dump($data[$id]);

					//find creator for this page
					$was = 0;
					foreach($users as $c) {
						$buf = explode(':', $c[1]);
						if(in_array($id, $buf)) {
							$was = 1;
							$creator_name = $c[0];
							break;
						}
					}

					//if file is image
					$buf1 = @getimagesize(FILES . 'file_' . $id . '.' . $data[$id]['ext']);

					//if file exist
					$buf2 = strlen($data[$id]['ext']) > 0 && file_exists(FILES . 'file_' . $id . '.' . $data[$id]['ext']);

					//if content exist
					$buf3 = strlen($data[$id]['content']) > 0;

					//displaying information
					if($buf1)
						echo '<a target="_blank" href="' . FILES . 'file_' . $id . '.' . $data[$id]['ext'] . '"><img class="preview" src="' . FILES . 'file_' . $id . '.' . $data[$id]['ext'] . '"></a><br>';
					if($buf2)
						echo '<a href="' . FILES . 'file_' . $id . '.' . $data[$id]['ext'] . '" download>file_' . $id . '.' . $data[$id]['ext'] . '</a><br>';
					if($buf3)
						echo '<pre>' ./*makeIframes(make_links_blank*/
							text2url($data[$id]['content'])/*)*/ . '</pre><br>';

					$was2 = 0;
					$i = 0;

					//cycle throw all childs
					foreach($data as $key => $d) {
						if($d['parrent'] != $id)
							continue;

						$was2 = 1;
						$i++;

						//updating line
						$data[$key]['line'] = $data[$d['parrent']]['line'] . line($key, $d['name']);
						/*if($key==82)
							echo var_dump($data);
						echo var_dump($key);
						echo var_dump($d['parrent']);
						echo var_dump($data[$d['parrent']]['line']);
						echo var_dump(line($key,$d['name']));
						echo var_dump($d['name']);
						echo var_dump($data[$key]);*/

						//displaying content
						echo '<div class="button';

						//if emty add empty class
						if(!$l && !in_array($key, $arr))
							echo ' empty';

						echo '"';

						//adding id into atribute
						if(in_array($key, $arr))
							echo ' data-key="' . $key . '"';

						echo '>';
						echo '<h2>' . $d['name'] . '</h2>';
						if($l)
							echo '<a href="?d=' . $key . '" class="btn btn-danger btn-xs removeLink">X</a>
														<a href="?e=' . $key . '" class="btn btn-info btn-xs editLink">E</a>';
						echo '</div>';
					}

					//if loginned, and page has content or file and has creator, than display it
					if($was && !$was2 && ($buf1 || $buf2 || $buf3))
						echo '<p>Code shared by ' . $creator_name . '</p>';

					if($l)
						echo '<a href="index.php?a=add&id=' . $id . '" class="button addLink text-center"><h2>Add</h2></a>';

					//calculating size for blocks
					if(100 / ($i + 1) < 25)
						$buf = 25;
					else
						$buf = 100 / ($i + 1); ?>

					<script>
						//setting size for ech child
						$(<?='"#page_' . $id . ' .button"'?>).css('width',<?="'calc(" . ($buf) . "% - 30px)'"?>);
					</script>

				</div>
			</div> <?php
		}

	} ?>
</head>

<body> <?php //creating all containers
foreach($arr as $val)
	cont($val);
?>

<!-- login container -->
<div class="container" id="page_logIn" style="display: none"><br>
	<form class="form-horizontal" method="post">
		<input type="text" name="login" placeholder="Login" class="form-control">
		<input type="password" name="password" placeholder="Password" class="form-control"><br>
		<input type="submit" name="submit" value="Log in" class="btn btn-info">
		<button type="button" class="btn btn-info" onclick="showPage('register')">Register</button>
		<button type="button" class="btn btn-info" onclick="showPage('-1')">Return</button>
	</form>
</div>

<!-- register container -->
<div class="container" id="page_register" style="display: none"><br>
	<form class="form-horizontal" method="post">
		<input type="text" name="login" placeholder="Login. Max length = 255" class="form-control">
		<input type="password" name="password" placeholder="Password. Max length = 24" class="form-control"><br>
		<input type="submit" name="registerSubmitted" value="Register" class="btn btn-info">
		<button type="button" class="btn btn-info" onclick="showPage('register')">Login</button>
		<button type="button" class="btn btn-info" onclick="showPage('-1')">Return</button>
	</form>
</div>

<!-- newPas container -->
<div class="container" id="page_newPas" style="display: none"><br>
	<form class="form-horizontal" method="post">
		<input type="password" name="password" placeholder="Password" class="form-control"><br>
		<input type="submit" name="passwordSubmitted" value="Register" class="btn btn-info">
		<button type="button" class="btn btn-info" onclick="showPage('-1')">Return</button>
	</form>
</div>
<script>

	//which block to change on click
	$('.button:not(.empty)').bind("click", function(e) {
		var target = $(e.target);
		if( target.is('a') )
			window.location.href(target.attr('href'));
		else {
			showPage($(this).attr('data-key'))
		}
	});

	//changing block
	function showPage(id) {
		if( id == 'no' ){
			$('.container:not(.no)').hide();
			$('.container.no').show();
		}
		else {
			$('.container:not(.no)').hide();
			$('#page_' + id).css('display', 'block');
		}
	}

	/*show edid|add page if needed*/ <?php
	if($wasAdd || $wasEdit)
		echo 'showPage(\'no\');'; ?>
</script>
</body>
</html>