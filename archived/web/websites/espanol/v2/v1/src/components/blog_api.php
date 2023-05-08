<?php


class Account {


	private function account_exist($login, $hash) {

		global $sql;
		return $sql->c('SELECT COUNT(login) FROM dsusers WHERE login = ? AND hash = ?', $login, $hash) == 1;
	}

	public function register() {

		global $sql;

		if(!Helper::is_password_secure($_POST['password']))
			return 'Password is not secure enough';

		if(!preg_match('/^[A-Za-z0-9_\-]{3,60}$/', $_POST['login']))
			return 'Login is not valid (/^[A-Za-z0-9_\-]{3,60}$/)';

		$hash = md5($_POST['password']);
		$_SESSION['hash'] = $hash;

		if($this->account_exist($_POST['login'], $hash))
			return 'User with this username is already registered';

		$sql->a('INSERT INTO dsusers(login,hash,ip) VALUES(?,?,?)', $_POST['login'], $hash, helper::get_user_ip());

		if(strlen($_SESSION['hash']) < 10)
			return 'Session failed to initialize';

		$_SESSION['hash'] = $hash;
		return '';

	}

	public function login() {

		global $sql;

		//validation
		if(!Helper::is_password_secure($_POST['password']) || !preg_match('/^[A-Za-z0-9_\-]{3,60}$/', $_POST['login']))
			return 'Login/Password is invalid';

		$hash = md5($_POST['password']);

		if(!$this->account_exist($_POST['login'], $hash))
			return 'Login/Password is invalid';

		$sql->a('UPDATE dsusers SET ip = ? WHERE hash = ?', helper::get_user_ip(), $hash);
		$_SESSION['hash'] = md5($_POST['password']);
		return '';

	}

	public function user_profile() {

		global $sql;

		$hash = $_SESSION['hash'];
		$data = $sql->res2data($sql->a('SELECT login,email,ip FROM dsusers WHERE hash=?', $hash))[0];
		$login = $data['login'];
		$email = $data['email'];
		$ip = $data['ip'];

		if(isset($_POST['profileSubmit'])) {

			echo '<div class="col">';
			$changeData = false;

			if(strlen($_POST['login']) > 0 && $login != $_POST['login']) {

				if(!preg_match('/^[A-Za-z0-9_\-]{3,60}$/', $_POST['login']))
					Helper::error('Login is not valid (/^[A-Za-z0-9_\-]{3,60}$/)');
				else {
					$login = $_POST['login'];
					$changeData = true;
					Helper::success('Login was changed successfully');
				}

			}

			if(strlen($_POST['password']) > 0 && $hash != md5($_POST['password'])) {

				if(!Helper::is_password_secure($_POST['password']))
					Helper::error('Password is not secure enough');
				else {
					$old_hash = $hash;
					$hash = md5($_POST['password']);
					$sql->a('UPDATE dsusers SET hash = ? WHERE hash = ?', $hash, $old_hash);
					$_SESSION['hash'] = $hash;
					Helper::success('Password was changed successfully');
				}

			}

			if(strlen($_POST['email']) > 0 && $email != $_POST['email']) {

				if(!Helper::valid_email($_POST['email']))
					Helper::error('Email is not valid');
				else {
					$email = $_POST['email'];
					$changeData = true;
					Helper::success('Email was changed successfully');
				}

			}

			if($changeData)
				$sql->a('UPDATE dsusers SET login = ?, email = ?, ip = ? WHERE hash = ?', $login, $email, $ip, $hash);

			echo '</div>';

		}

		?>

		<div class="col">

			<h1>User data</h1>
			<p>
				User login: <?= $login ?><br>
				User hash: <?= $hash ?><br>
				User email: <?= $email ?><br>
				User ip: <?= $ip ?>
			</p>

		</div>
		<div class="col">

			<h1>Change information</h1>
			<form method="post">

				<input type="text" name="login" placeholder="login" value="<?= $login ?>" class="form-control"><br>
				<input type="email" name="email" placeholder="email" value="<?= $email ?>" class="form-control"><br>
				<input type="password" name="password" placeholder="password" class="form-control"><br>
				<div class="btn-group">
					<input type="submit" name="profileSubmit" class="btn btn-outline-dark" value="Submit">
					<a class="btn btn-dark" href="index.php?action=profile">Cancel</a>
					<a class="btn btn-dark" href="index.php">To home</a>
					<a href="index.php?action=signout" class="btn btn-dark">Sing Out</a>
				</div>

			</form>

		</div> <?php
	}

	public function showMenu() { ?>
		<div class="btn-group">
			<a href="index.php?action=register" class="btn btn-outline-dark">Register</a>
			<a href="index.php?action=login" class="btn btn-outline-dark">Login</a>
		</div> <?php
		Shop::show_posts();
	}

	public function showRegisterForm() { ?>
		<div class="col">
			<h1>Register</h1>
			<form method="post" action="index.php">

				<input type="text" name="login" placeholder="login" class="form-control"><br>
				<input type="password" name="password" placeholder="password" class="form-control"><br>
				<div class="btn-group">
					<input type="submit" name="registerSubmit" class="btn btn-outline-dark" value="Register">
					<a class="btn btn-dark" href="index.php">Back</a>
				</div>

			</form>

		</div> <?php
	}

	public function showLoginForm() { ?>
		<div class="col">
			<h1>Login</h1>
			<form method="post" action="index.php">

				<input type="text" name="login" placeholder="login" class="form-control"><br>
				<input type="password" name="password" placeholder="password" class="form-control"><br>
				<div class="btn-group">
					<input type="submit" name="loginSubmit" class="btn btn-outline-dark" value="Submit">
					<a class="btn btn-dark" href="index.php">Back</a>
				</div>

			</form>

		</div>
	<?php }

	public function signOut() {

		unset($_SESSION['hash']);
		session_destroy();
		return null;
	}

	public function display($data) {

		echo '<p>' . $data . '</p>' . $this->toHome();
	}

	private function toHome() { ?>
		<a href="index.php" class="btn btn-outline-dark">To home</a> <?php
	}

	public function show_profile_link() { ?>
		<a href="index.php?action=profile" class="btn btn-outline-dark">Profile</a> <?php
		Shop::show_posts();
	}

}


class Helper {

	public static $separator = DIRECTORY_SEPARATOR;
	public static $user_ip = 0;

	public static function get_user_ip() {

		if(self::$user_ip != 0)
			return self::$user_ip;

		if(isset($_SERVER['HTTP_CLIENT_IP']))
			self::$user_ip = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			self::$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			self::$user_ip = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			self::$user_ip = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			self::$user_ip = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			self::$user_ip = $_SERVER['REMOTE_ADDR'];
		else
			self::$user_ip = 'UNKNOWN';

		return self::$user_ip;
	}

	public static function is_password_secure($password) {

		//length > 9 = secure
		if(strlen($password) > 9)
			return true;

		//check for 11111
		$first_letter = $password[0];
		for($i = 1; $i < strlen($password); $i++)
			if($first_letter != $password[$i])
				break;
		if($i > strlen($password) * 0.75)
			return false;

		//check for acceding, descending or following numbers
		$count = 0;
		$max_count = 0;
		for($i = 0; $i < strlen($password); $i++) {
			if($count == 0 && is_numeric($password[$i]))
				$count = 1;
			else if($count != 0 && $password[$i] - $password[$i - 1] >= -1 && $password[$i] - $password[$i - 1] <= 1)
				$count++;
			else if($count > $max_count)
				$max_count = $count;
		}
		if($count > $max_count)
			$max_count = $count;
		if($max_count > strlen($password) * 0.75)
			return false;

		//check for common passwords
		$common_passwords = array('123456', 'Password', '12345678', 'qwerty', '12345', '123456789', 'letmein', '1234567', 'football', 'iloveyou', 'welcome', 'monkey', 'abc123', 'starwars', '123123', 'dragon', 'passw0rd', 'master', 'freedom', 'whatever', 'qazwsx', 'trustno1', '654321', 'jordan23', 'harley', 'password1', 'robert', 'matthew', 'jordan', 'asshole', 'daniel');
		if(in_array($password, $common_passwords))
			return false;

		return true;
	}

	public static function error($data) { ?>
		<div class="alert alert-danger"><?= $data ?></div> <?php
	}

	public static function success($data) { ?>
		<div class="alert alert-success"><?= $data ?></div> <?php
	}

	public static function valid_email($email) {

		return preg_match('/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})$/', $email);
	}

	public static function debug_info() {

		$e = new \Exception();
		return '<br><br>Php version => ' . phpversion() . '<br>
			Time => ' . time() . '<br><br>'
			. preg_replace(array('/#/', '/\.php\(/', '/\): /'), array('<br>#', '.php(<b>', '</b>): '), $e->getTraceAsString());
	}

	public static function alert($text, $type) { ?>
		<div class="alert alert-<?= $type ?>"><?= $text ?></div><?php
	}

}


class Post {

	private $id = 0;
	private $name = '';
	private $content = '';
	private $short_content = '';
	private $date = 0;
	private $date_edit = 0;
	private $creator_id = 0;
	private $url = '';
	private $meta_title = '';
	private $meta_description = '';

	public function __construct($id = -1) {

		global $sql;
		if($id !== -1) {
			$product_info = $sql->r('SELECT * FROM dsproducts WHERE id = ?', $id);
			$this->set_array($product_info);
		}
		else {
			$sql->a('INSERT INTO h_simple_posts() VALUES();');
			$this->id = $sql->c('SELECT LAST_INSERT_ID();');
		}

	}

	public function set_array($data) {

		foreach($data as $key => $value)
			if(isset($this->$key))
				$this->$key = $value;
	}

	public function commit() {

		global $sql;

		$sql->a('UPDATE dsproducts SET name = ?, content = ?, short_content = ?, date = ?, date_edit = ?, url = ?, meta_title = ?, meta_description = ? WHERE id = ?', $this->name, $this->content, $this->short_content, $this->date, $this->date_edit, $this->url, $this->meta_title, $this->meta_description, $this->id);
	}

	public function getId() {

		return $this->id;
	}

	public function setId($id) {

		if($id > 0)
			$this->id = $id;
	}

	public function getName() {

		return $this->name;
	}

	public function setName($name) {

		$this->name = $name;
	}

	public function getContent() {

		return $this->content;
	}

	public function setContent($content) {

		$this->content = $content;
	}

	public function getShortContent() {

		if(strlen($this->short_content) > 0)
			return $this->short_content;
		return $this->content;
	}

	public function setShortContent($short_content) {

		$this->short_content = $short_content;
	}

	public function getDate() {

		return $this->date;
	}

	public function setDate($date) {

		$this->date = $date;
	}

	public function getDateEdit() {

		return $this->date_edit;
	}

	public function setDateEdit($date_edit) {

		$this->date_edit = $date_edit;
	}

	public function getCreatorId() {

		return $this->creator_id;
	}

	public function setCreatorId($creator_id) {

		$this->creator_id = $creator_id;
	}

	public function getUrl() {

		return $this->url;
	}

	public function setUrl($url) {

		$this->url = $url;
	}

	public function getMetaTitle() {

		return $this->meta_title;
	}

	public function setMetaTitle($meta_title) {

		$this->meta_title = $meta_title;
	}

	public function getMetaDescription() {

		return $this->meta_description;
	}

	public function setMetaDescription($meta_description) {

		$this->meta_description = $meta_description;
	}

	public function delete() {

		global $sql;
		$sql->a('DELETE FROM dsproducts WHERE id = ?', $this->id);
	}


}


class Shop {

	private static function add_product_form() {

		?>
		<form action="?ready=product_added" method="post">
			<input type="text" class="form-control" placeholder="Name" name="name"><br>
			<input type="text" class="form-control" placeholder="Url" name="url"><br>
			<input type="text" class="form-control" placeholder="Meta title" name="meta_title"><br>
			<textarea class="form-control" placeholder="Meta description" name="meta_description"></textarea><br>
			<textarea class="form-control" placeholder="Description" name="content"></textarea><br>
			<textarea class="form-control" placeholder="Short description" name="short_content"></textarea><br>
			<div class="btn-group">
				<input type="submit" class="btn btn-success" value="Add product" name="submit">
				<a href="index.php" class="btn btn-outline-dark">To home</a>
			</div>
		</form> <?php
	}

	private static function edit_product_form() {

		global $sql;
		$post = new Post($_GET['product_id']); ?>
		<form action="?ready=edit_product&product_id=<?= $_GET['product_id'] ?>" method="post">
			<input type="text" class="form-control" placeholder="Name" name="name" value="<?= $post->getName() ?>"><br>
			<input type="text" class="form-control" placeholder="Url" name="url" value="<?= $post->getUrl() ?>"><br>
			<input type="text" class="form-control" placeholder="Meta title" name="meta_title" value="<?= $post->getMetaTitle() ?>"><br>
			<textarea class="form-control" placeholder="Meta description" name="meta_description"><?= $post->getMetaDescription() ?></textarea><br>
			<textarea class="form-control" placeholder="Description" name="content"><?= $post->getContent() ?></textarea><br>
			<textarea class="form-control" placeholder="Short description" name="short_content"><?= $post->getShortContent() ?></textarea><br>
			<div class="btn-group">
				<input type="submit" class="btn btn-outline-dark" value="Edit product" name="submit">
				<a href="index.php" class="btn btn-outline-dark">To home</a>
				<a href="index.php?ready=delete_product&product_id=<?= $_GET['product_id'] ?>" class="btn btn-outline-dark">Delete
					product</a>
			</div>
		</form> <?php
	}

	public static function show_post($is_logged_in) {

		global $sql;
		$_GET['product_id'] = $sql->c('SELECT id FROM dsproducts WHERE url = ?', $_GET['url']); ?>
		<a href="index.php" class="btn btn-outline-dark">To home</a> <?php
		if($is_logged_in) { ?>
			<a href="index.php?action=edit_product&product_id=<?= $_GET['product_id'] ?>" class="btn btn-outline-dark">Edit
				product</a> <?php
		}

		$product = new Post($_GET['product_id']); ?>
		<div class="product">
			<h1 class="name"><?= $product->getName() ?></h1>
			<div class="date">Date: <?= date('d.m Y', $product->getDate()) ?></div>
			<div class="date_edited">Date edited: <?= date('d.m Y', $product->getDateEdit()) ?></div>
			<div class="content"><?= $product->getContent() ?></div>
			<div class="meta_title">Meta title: <?= $product->getMetaTitle() ?></div>
			<div class="meta_title">Meta description: <?= $product->getMetaDescription() ?></div>
		</div> <?php
	}

	public static function added_post() {

		$product = new Post();

		$product->set_array($_POST);
		$product->setDate(time());

		$product->commit();

		Helper::alert('Product was successfully added!', 'success');

		self::show_post(true);
	}

	public static function edited_post() {

		$product = new Post($_GET['product_id']);

		$product->set_array($_POST);
		$product->setDateEdit(time());

		$product->commit();

		Helper::alert('Product was successfully edited!', 'success');

		self::show_post(true);
	}

	public static function deleted_post() {

		(new Post($_GET['product_id']))->delete();

		Helper::alert('Product was successfully deleted!', 'success');

		self::show_post(true);
	}

	public static function show_posts() {

		global $sql;

		if(isset($_SESSION['hash']))
			$is_logged_in = true;
		else
			$is_logged_in = false;

		echo '<div class="products">';

		if(array_key_exists('action', $_GET)) {

			if($_GET['action'] == 'add_product')
				self::add_product_form();

			if($_GET['action'] == 'edit_product' && array_key_exists('product_id', $_GET) && is_numeric($_GET['product_id']) && $_GET['product_id'] > 0)
				self::edit_product_form();

			if($_GET['action'] == 'show_product' && array_key_exists('url', $_GET) && is_numeric($_GET['url']) && $_GET['url'] > 0)
				self::show_post($is_logged_in);

		}
		else {
			if($is_logged_in) { ?>
				<a href="index.php?action=add_product" class="btn btn-outline-dark">Add product</a> <?php

				if(array_key_exists('ready', $_GET)) {
					if($_GET['ready'] == 'product_added' && array_key_exists('submit', $_POST))
						self::added_post();
					if($_GET['ready'] == 'edit_product' && array_key_exists('submit', $_POST) && array_key_exists('product_id', $_GET) && is_numeric($_GET['product_id']) && $_GET['product_id'] > 0)
						self::edited_post();
					if($_GET['ready'] == 'delete_product' && array_key_exists('product_id', $_GET) && is_numeric($_GET['product_id']) && $_GET['product_id'] > 0)
						self::deleted_post();
				}
			}

			$products = $sql->res2data($sql->a('SELECT id FROM dsproducts'));

			foreach($products as $product_id) {
				$id = $product_id['id'];
				$product = new Post($id); ?>
				<div class="product">
					<a href="index.php?action=show_product&url=<?= $product->getUrl() ?>" class="name"><?= $product->getName() ?></a>
					<div class="date">Date: <?= date('d.m Y', $product->getDate()) ?></div>
					<div class="content"><?= $product->getShortContent() ?></div>
				</div> <?php
			}
		}

	}
}