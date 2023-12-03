<?php

def('HASH','your md5-hashed password here');

session_start();
$sql = new sql('MYSQL_HOST', 'MYSQL_LOGIN', 'MYSQL_PASSWORD', 'MYSQL_DATABASE', content::$tables,
	'?', false);

if($_GET['mode'] == "shop_data_send") {
	content::shop_save();
	exit();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<title>Table</title>
	<style>
		#menu {
			min-height: 100vh;
			height: 100%;
			background: #000;
			padding: 30px;
			font-size: 25px;
		}

		@media (max-width: 768px) {
			#menu {
				height: auto;
				min-height: auto;
			}
		}

		.menu_item {
			text-align: center;
			font-size: 1.1rem;
			margin: 20px 0;
			padding: 10px;
			display: block;
			color: #aaa !important;
			text-decoration: none !important;
		}

		.menu_item:hover, .menu_item.active {
			color: #fff !important;
		}

		.menu_item.active {
			cursor: default;
		}


		/* salary */

		#horizontal_menu a.menu_items {
			color: #aaa;
			text-decoration: none;
			margin: 15px;
			font-size: 1.1rem;
		}

		#horizontal_menu a.menu_items.active, #horizontal_menu a.menu_items:hover {
			color: #000;
		}

		#horizontal_menu a.menu_items.active {
			cursor: default;
		}


		/*shop*/

		.last_worker_of_category {
			border-right: 3px solid #bbb !important;
		}

		.tiny_field {
			width: 100%;
			display: block;
		}

		.shop_table label {
			margin: 0;
			width: 100%;
		}

		.shop_table input {
			width: 100%;
			display: block;
			line-height: 48px;
			margin-top: -14px;
			margin-bottom: -14px;
			padding: 0;
			background: transparent;
			color: inherit;
		}


		/*tagsify*/
		.tagsly {
			position: relative;
		}

		.tagsly span.tag {
			position: relative;
			padding-right: 20px;
		}

		.tagsly span.tag a {
			position: absolute;
			top: -5px;
			text-decoration: none;
		}

		.tagsly input[type=text].tag-textbox {
			border: none;
			outline: none;
		}

		.tagsly input[type=text].tag-textbox:disabled {
			display: none
		}

		.tagsly ul.suggest {
			background: #fff;
			position: absolute;
			margin: 0;
			padding: 0;
			list-style: none;
			border: 1px solid #ccc;
			z-index: 5;
			display: none;
		}

		.tagsly ul.suggest li {
			padding: 5px;
			cursor: pointer;
		}

		.tagsly ul.suggest li.active, .tagsly ul.suggest li:hover {
			background: #ccc;
		}

	</style>
</head>
<body>
	<?php

	date_default_timezone_set("Europe/Kiev");


	class sql {

		private $connection;
		private $tableNamesA;
		private $tableNamesB;
		private $specialSymbol;

		function __construct($host, $login, $password, $dbname, $tableNames, $specialSymbol = '?', $createTables = false) {

			$this->connection = new \mysqli($host, $login, $password, $dbname);

			if($this->connection->connect_error)
				die('Connection failed: ' . $this->connection->connect_error);
			if(!is_array($tableNames))
				die('Invalid table names');

			$this->specialSymbol = $specialSymbol;
			$this->tableNamesA = [];
			$this->tableNamesB = [];

			$defaultTableData = null;
			if($createTables) {
				$defaultTableData = [];
				$defaultTableData["users"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dusers` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(40) NOT NULL , `hash` VARCHAR(64) NOT NULL , `email` VARCHAR(254) NOT NULL , `register_date` INT(10) NOT NULL , `birth_date` INT(10) NOT NULL , `u_name` VARCHAR(40) NOT NULL , `u_surname` VARCHAR(40) NOT NULL , `u_city` VARCHAR(60) NOT NULL , `u_edu` VARCHAR(70) NOT NULL , `u_sm` VARCHAR(600) NOT NULL , `u_about` TEXT NOT NULL , `u_ava` VARCHAR(20) NOT NULL , `u_phone` VARCHAR(200) NOT NULL, `u_last_online` INT(10) NOT NULL, `type` INT(10) NOT NULL , `parameters` VARCHAR(200) NOT NULL , `register_ip` VARCHAR(15) NOT NULL , `banned_ips` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
				$defaultTableData["posts"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dposts` (
				`id` INT(16) NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(100) NOT NULL,
				`content` TEXT NOT NULL,
				`type` INT(2) NOT NULL DEFAULT '0',
				`keywords` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
				$defaultTableData["products"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dproducts` (
				`id` INT(10) DEFAULT NULL,
				`name` VARCHAR(60) DEFAULT NULL,
				`price` VARCHAR(5) DEFAULT NULL,
				`link` VARCHAR(20) DEFAULT NULL,
				`b_link` VARCHAR(10) DEFAULT NULL,
				`o1` TEXT,
				`o2` TEXT,
				`o3` TEXT,
				`yt` VARCHAR(15) DEFAULT NULL,
				`keywords` VARCHAR(255) DEFAULT NULL,
				`vis` BIT(1) NOT NULL DEFAULT b'1',
				`keyval` INT(3) NOT NULL AUTO_INCREMENT,
				`views` INT(6) NOT NULL DEFAULT '0',
				`buys` INT(6) NOT NULL DEFAULT '0',
				`unixtime` VARCHAR(15) DEFAULT NULL,
				`comments` TEXT,
				`parameters` VARCHAR(100) NOT NULL DEFAULT '01111100:1:1:1:0:0:0:0',
				PRIMARY KEY (`keyval`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
				$defaultTableData["mv"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv` (
				`name` VARCHAR(256) NOT NULL,
				`value` TEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
				$defaultTableData["mv2"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv2` (
				`name` VARCHAR(256) NOT NULL,
				`value` MEDIUMTEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
				$defaultTableData["logins"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlogins` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`domain` VARCHAR(30) NOT NULL,
				`user` INT(10) NOT NULL,
				`ip` VARCHAR(15) NOT NULL,
				`time` INT(10) NOT NULL,
				`type` INT(10) NOT NULL,
				`info` VARCHAR(60) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
				$defaultTableData["log"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlog` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`domain` VARCHAR(50) NOT NULL,
				`directory` VARCHAR(50) NOT NULL,
				`etime` VARCHAR(20) NOT NULL,
				`ip` VARCHAR(16) NOT NULL,
				`userid` INT(5) NOT NULL DEFAULT '-1',
				`type` INT(11) NOT NULL,
				`val` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			}

			foreach($tableNames as $d) {
				$this->tableNamesA[] = '/`?' . $d[0] . '`?/';
				$this->tableNamesB[] = '`' . $d[1] . '`';
				if($createTables && is_array($defaultTableData) && array_key_exists($d[2], $defaultTableData) && strlen
					($defaultTableData[$d[2]]))
					$this->a(preg_replace(['/mydbname/', '/`?' . $d[0] . '`?/'], [$dbname, $d[1]], $defaultTableData[$d[2]]));
			}

		}

		function a($query) {

			if(!is_string($query))
				die(var_dump($query) . " is not a string. Debug info:<br>" . helper::debug_info());
			if(strlen($query) < 1)
				return null;

			$query = preg_replace($this->tableNamesA, $this->tableNamesB, $query);

			$args = func_get_args();
			array_shift($args);
			$numberOfArgs = count($args);

			if(substr_count($query, $this->specialSymbol) != $numberOfArgs)
				die('Number of paramethers (' . substr_count($query, $this->specialSymbol) . ') != number of ' . $this->specialSymbol . " in query (" . $numberOfArgs . ")(" . $query . "). Debug info:<br>" . helper::debug_info());

			//var_dump($numberOfArgs);
			if($numberOfArgs == 0)
				return $this->connection->query($query);

			$stmt = $this->connection->prepare($query);
			if($stmt === false)
				trigger_error('Wrong SQL: ' . $query . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error . "<br>Debug info:<br>" . helper::debug_info(), E_USER_ERROR);
			//$stmt->bind_param();

			$a_params = [];
			$argsTypes = '';
			$a_params[] = &$argsTypes;

			for($i = 0; $i < $numberOfArgs; $i++) {

				switch(gettype($args[$i])) {
					case 'integer':
						$argsTypes .= 'i';
						break;
					case 'double':
						$argsTypes .= 'd';
						break;
					case 'string':
						$argsTypes .= 's';
						break;
					default:
						$argsTypes .= 's';
						$args[$i] = (string)$args[$i];
						break;
				}

				$a_params[] = &$args[$i];

			}

			//var_dump($a_params);
			call_user_func_array([$stmt, 'bind_param'], $a_params);
			$stmt->execute();
			return $stmt->get_result();
		}

		function disconect() {

			$this->connection->close();
		}

		function getlastid() {

			return $this->connection->insert_id;
		}

		function count($result) {

			return $result->num_rows;
		}

		function c($query) {

			$res = call_user_func_array([$this, 'a'], func_get_args());

			if(is_bool($res))
				return $res;

			return $res->fetch_row()[0];
		}

		function r($query) {

			return call_user_func_array([$this, 'a'], func_get_args())->fetch_assoc();
		}

		function res2data($res) {

			if(is_bool($res))
				return $res;

			$data = [];
			while($row = $this->fetch($res))
				$data[] = $row;

			return $data;

		}

		static function fetch(\mysqli_result $res) {

			return $res->fetch_array(MYSQLI_ASSOC);
		}
	}


	class helper {

		public static $js_chart_border_colors = "
					'rgba(86,206,255,1)',
					'rgba(162,235,54,1)',
					'rgba(86,255,206,1)',
					'rgba(235,54,162,1)',
					'rgba(54,162,235,1)',
					'rgba(192,192,75,1)',
					'rgba(162,54,235,1)',
					'rgba(255,206,86,1)',
					'rgba(75,192,192,1)',
					'rgba(99,255,132,1)',
					'rgba(206,255,86,1)',
					'rgba(255,99,132,1)',
					'rgba(153,255,102,1)',
					'rgba(64,159,255,1',
					'rgba(235,162,54,1)',
					'rgba(64,255,159,1)',
					'rgba(99,132,255,1)',
					'rgba(153,102,255,1)',
					'rgba(192,192,75,1)',
					'rgba(192,75,192,1)',
					'rgba(255,132,99,1)',
					'rgba(255,86,206,1)',
					'rgba(255,102,153,1)',
					'rgba(132,99,255,1)',
					'rgba(159,64,255,1)',
					'rgba(255,64,159,1)',
					'rgba(102,255,153,1)',
					'rgba(54,235,162,1)',
					'rgba(255,153,102,1)',
					'rgba(75,192,192,1)',
					'rgba(255,159,64,1)',
					'rgba(159,255,64,1)',
					'rgba(192,75,192,1)',
					'rgba(132,255,99,1)',
					'rgba(102,153,255,1)',
					'rgba(206,86,255,1)',";
		public static $js_chart_main_colors = "
					'rgba(86,206,255,0.2)',
					'rgba(162,235,54,0.2)',
					'rgba(86,255,206,0.2)',
					'rgba(235,54,162,0.2)',
					'rgba(54,162,235,0.2)',
					'rgba(192,192,75,0.2)',
					'rgba(162,54,235,0.2)',
					'rgba(255,206,86,0.2)',
					'rgba(75,192,192,0.2)',
					'rgba(99,255,132,0.2)',
					'rgba(206,255,86,0.2)',
					'rgba(255,99,132,0.2)',
					'rgba(153,255,102,0.2)',
					'rgba(64,159,255,1',
					'rgba(235,162,54,0.2)',
					'rgba(64,255,159,0.2)',
					'rgba(99,132,255,0.2)',
					'rgba(153,102,255,0.2)',
					'rgba(192,192,75,0.2)',
					'rgba(192,75,192,0.2)',
					'rgba(255,132,99,0.2)',
					'rgba(255,86,206,0.2)',
					'rgba(255,102,153,0.2)',
					'rgba(132,99,255,0.2)',
					'rgba(159,64,255,0.2)',
					'rgba(255,64,159,0.2)',
					'rgba(102,255,153,0.2)',
					'rgba(54,235,162,0.2)',
					'rgba(255,153,102,0.2)',
					'rgba(75,192,192,0.2)',
					'rgba(255,159,64,0.2)',
					'rgba(159,255,64,0.2)',
					'rgba(192,75,192,0.2)',
					'rgba(132,255,99,0.2)',
					'rgba(102,153,255,0.2)',
					'rgba(206,86,255,0.2)',";
		public static $separator = DIRECTORY_SEPARATOR;
		public static $day_names = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
		public static $month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
		private static $month_names_alt = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];

		public static function jsfy_array($array, $key = null) {

			if(!is_array($array))
				return false;

			$result = '';

			if($key !== null)
				foreach($array as $value)
					$result .= '"' . $value[$key] . '",';
			else
				foreach($array as $value)
					$result .= '"' . $value . '",';

			return $result;
		}

		public static function mayor_error($key) {

			\MainController::actionHeader();
			self::alert(\Errors::get($key, 2), 'danger');
			\sessionManager::destroy_session();
			die;
		}

		public static function alert($text, $type) {


			if(is_array($text)) {
				$extra = 'title="' . $text[1] . '"';
				$text = $text[0];
			}
			else
				$extra = ''; ?>
			<div class="alert alert-<?= $type ?>" <?= $extra ?>><?= $text ?></div> <?php
		}

		public static function root($path = '') {

			return ROOT . preg_replace('/[\/\\\\]{1}/m', self::$separator, $path);
		}

		public static function safeGet($key, array &$array, $default = '') {

			if(is_array($array) && array_key_exists($key, $array))
				return $array[$key];
			elseif($default === 'error')
				die('NO KEY ' . $key . ' IN ARRAY ' . $array . self::debug_info());
			else
				return $default;
		}

		public static function debug_info() {

			$e = new \Exception();
			return '<br><br>Php version => ' . phpversion() . '<br>
			Time => ' . time() . '<br><br>'
				. preg_replace(['/#/', '/\.php\(/', '/\): /'], ['<br>#', '.php(<b>', '</b>): '], $e->getTraceAsString());
		}

		public static function get_user_ip() {

			if(self::$user_ip != 0)
				return self::$user_ip;

			if(isset($_SERVER['HTTP_CLIENT_IP']))
				self::$user_ip = $_SERVER['HTTP_CLIENT_IP'];
			elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				self::$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			elseif(isset($_SERVER['HTTP_X_FORWARDED']))
				self::$user_ip = $_SERVER['HTTP_X_FORWARDED'];
			elseif(isset($_SERVER['HTTP_FORWARDED_FOR']))
				self::$user_ip = $_SERVER['HTTP_FORWARDED_FOR'];
			elseif(isset($_SERVER['HTTP_FORWARDED']))
				self::$user_ip = $_SERVER['HTTP_FORWARDED'];
			elseif(isset($_SERVER['REMOTE_ADDR']))
				self::$user_ip = $_SERVER['REMOTE_ADDR'];
			else
				self::$user_ip = 'UNKNOWN';

			return self::$user_ip;
		}

		public static function str_replace_first_ref($search, $replace, &$subject, $reverse = false) {

			$subject = self::str_replace_first($search, $replace, $subject, $reverse);
		}

		public static function str_replace_first($search, $replace, $subject, $reverse = false) {

			if($reverse)
				$pos = strrpos($subject, $search);
			else
				$pos = strpos($subject, $search);
			if($pos !== false)
				return substr_replace($subject, $replace, $pos, strlen($replace));
			return $subject;
		}

		public static function week_to_lang($week_day, $fix = true) {

			if($fix)
				return self::$day_names[($week_day + 6) % 7];
			else
				return self::$day_names[$week_day];
		}

		public static function month_to_lang($month_number, $use_alt = false) {

			if($use_alt)
				$return_arr = &self::$month_names_alt;
			else
				$return_arr = &self::$month_names;

			if($month_number === false)
				return $return_arr[$month_number];
			else
				return $return_arr[$month_number];
		}

	}


	final class content {


		//parameters

		public static $link = 'http://max.patii.uk/project/one_c/';
		public static $tables = [
			['categories', 'w_categories'],
			['workers', 'w_workers'],
			['shop', 'w_shop'],
			['salary', 'w_salary'],
		];


		//public

		public static function is_logged_in() {

			if(isset($_SESSION) && array_key_exists('hash', $_SESSION) && $_SESSION['hash'] === HASH)
				return true;
			else
				return false;
		}

		public static function login_validation() {

			if(isset($_POST) && array_key_exists('submit', $_POST) && md5($_POST['password']) === HASH) {
				$_SESSION['hash'] = md5($_POST['password']);
				self::show_website();
			}
			else { ?>
				<div class="alert alert-danger">Неправильний пароль.</div> <?php
				self::login();
			}
		}

		public static function show_website() {

			if(!array_key_exists('d', $_GET))
				$_GET['d'] = 'money'; ?>

			<div class="container-fluid">
				<div class="row">
					<div id="menu" class="col-md-3 col-lg-2">
						<a class="menu_item <?php if($_GET['d'] == 'categories') echo 'active'; ?>" href="<?= self::$link ?>?d=categories">Categories</a>
						<a class="menu_item <?php if($_GET['d'] == 'workers') echo 'active'; ?>" href="<?= self::$link ?>?d=workers">Employees</a>
						<a class="menu_item <?php if($_GET['d'] == 'money') echo 'active'; ?>" href="<?= self::$link ?>?d=money">Revenue</a>
						<a class="menu_item <?php if($_GET['d'] == 'shop') echo 'active'; ?>" href="<?= self::$link ?>?d=shop">Shop</a>
						<a class="menu_item <?php if($_GET['d'] == 'logout') echo 'active'; ?>" href="<?= self::$link ?>?d=logout">Log out</a>
					</div>
					<div class="col-md-9 col-lg-10"> <?php

						if($_GET['d'] == 'categories')
							self::show_categories();
						elseif($_GET['d'] == 'workers')
							self::show_workers();
						elseif($_GET['d'] == 'money')
							self::show_money();
						elseif($_GET['d'] == 'shop')
							self::show_shop();
						else
							self::logout();

						?>

					</div>
				</div>
			</div> <?php

		}

		private static function show_categories() {

			global $sql;

			if(array_key_exists('a', $_GET)) {

				if($_GET['a'] == 'add_category') { ?>
					<form action="?d=categories&r=category_created" method="post" class="mt-4">

						<input type="text" class="form-control" name="category_name" placeholder="Department name" required>


						<div class="custom-control custom-checkbox mt-4 mb-4">
							<input type="checkbox" class="custom-control-input" id="show_category_checkbox" name="show_category" checked>
							<label class="custom-control-label" for="show_category_checkbox">Show department</label>
						</div>

						<div class="btn-group">

							<input type="submit" name="submit" value="Add" class="btn btn-success">
							<a href="?d=categories" class="btn btn-danger">Cancel</a>

						</div>

					</form> <?php
				}

				if($_GET['a'] == 'confirm_delete' && array_key_exists('category_id', $_GET) && is_numeric($_GET['category_id']) && $_GET['category_id'] > 0) { ?>

					<div class="alert alert-warning">Are you sure you want to delete this department? This will lead to the deletion of all its employees
					</div> <?php
					$c_data = $sql->res2data($sql->a('SELECT `name` FROM `workers` WHERE `id_category` = ?', $_GET['category_id']));
					if(count($c_data) > 0) { ?>
						<p>This action will delete following employees:<br> <?php
							foreach($c_data as $worker)
								echo $worker['name'] . '<br>'; ?>
						</p> <?php
					} ?>
					<a class="btn btn-danger" href="?d=categories&r=category_deleted&category_id=<?= $_GET['category_id'] ?>">Yes, delete</a>
					<a class="btn btn-primary" href="?d=categories">No, cancel</a>

					<?php
				}

			}
			else {

				if(array_key_exists('r', $_GET)) {

					if($_GET['r'] == 'category_created' && array_key_exists('submit', $_POST) && array_key_exists('category_name', $_POST) && strlen($_POST['category_name']) > 0) {
						$sql->a('INSERT INTO `categories`(`name`,`active`) VALUES(?,?)', $_POST['category_name'], ($_POST['show_category'] != "") ? "1" : "0");
						helper::alert('Department created', 'success');
					}
					if($_GET['r'] == 'category_deleted' && array_key_exists('category_id', $_GET) && is_numeric($_GET['category_id']) && $_GET['category_id'] > 0) {
						$sql->a('DELETE FROM `salary` WHERE `id_worker` IN (SELECT `id` FROM `workers` WHERE `id_category` = ?)', $_GET['category_id']);

						$sql->a('DELETE FROM `workers` WHERE `id_category` = ?', $_GET['category_id']);

						$sql->a('DELETE FROM `categories` WHERE `id` = ?', $_GET['category_id']);

						helper::alert('Department deleted!', 'success');
					}
					if($_GET['r'] == 'edited' && array_key_exists('ids', $_POST) && strlen($_POST['ids']) > 0) {
						$list_of_id = explode(',', $_POST['ids']);

						foreach($list_of_id as $id)
							if(array_key_exists('category_name_' . $id, $_POST) && strlen($_POST['category_name_' . $id]) > 0)
								$sql->a('UPDATE `categories` SET `name`=?, `active`=? WHERE `id`=?', $_POST['category_name_' . $id], ($_POST['category_visibility_' . $id] != '') ? 1 : 0, (int)$id);
						helper::alert('Changes saved!', 'success');
					}

				}

				$categories = $sql->res2data($sql->a('SELECT * FROM `categories` ORDER BY `active` = 1 DESC')); ?>

				<form method="post" action="?d=categories&r=edited">

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Department name</th>
								<th>Show department</th>
								<th>Delete department</th>
							</tr>
						</thead>

						<tbody> <?php

							$list_of_id = [];
							foreach($categories as $category) {
								$list_of_id[] = $category['id']; ?>
								<tr>
									<td>
										<input type="text" placeholder="Category name" class="form-control" name="category_name_<?= $category['id'] ?>" value="<?= $category['name'] ?>" required>
									</td>
									<td>
										<input type="checkbox" name="category_visibility_<?= $category['id'] ?>" <?php if($category['active'] != 0) echo 'checked' ?>>
									</td>
									<td>
										<a class="btn btn-danger btn-sm" href="?d=categories&a=confirm_delete&category_id=<?= $category['id'] ?>">x</a>
									</td>
								</tr> <?php
							} ?>
						</tbody>

					</table>

					<div class="btn-group">
						<input type="hidden" name="ids" value="<?= implode(',', $list_of_id) ?>">
						<input type="submit" class="btn btn-primary" name="submit" value="Save changes">
						<a href="?d=categories&a=add_category" class="btn btn-success">Add department</a>
					</div>

				</form>

				<?php

			}
		}

		private static function show_workers() {

			global $sql;

			if(array_key_exists('a', $_GET)) {

				if($_GET['a'] == 'add_worker') {
					$categories = $sql->res2data($sql->a('SELECT `name`,`id` FROM `categories`'));
					?>
					<form action="?d=workers&r=worker_created" method="post" class="mt-4">

						<input type="text" class="form-control mt-4" name="worker_name" placeholder="Employee name" required>

						<select name="id_category" class="form-control mt-4" required> <?php
							foreach($categories as $category) { ?>
								<option value="<?= $category['id'] ?>"><?= $category['name'] ?></option> <?php
							} ?>
						</select>

						<input type="number" step="0.01" class="form-control mt-4" name="percent_salary" placeholder="Employee salary percentage" required>

						<input type="number" step="0.01" class="form-control mt-4" name="base_income" placeholder="Base selary">

						<div class="custom-control custom-checkbox mt-4 mb-4">
							<input type="checkbox" class="custom-control-input" id="show_worker_checkbox" name="show_worker" checked>
							<label class="custom-control-label" for="show_worker_checkbox">Show employee</label>
						</div>

						<div class="btn-group">

							<input type="submit" name="submit" value="Add" class="btn btn-success">
							<a href="?d=workers" class="btn btn-danger">Cancel changes</a>

						</div>

					</form> <?php
				}

				if($_GET['a'] == 'confirm_delete' && array_key_exists('worker_id', $_GET) && is_numeric($_GET['worker_id']) && $_GET['worker_id'] > 0) { ?>

					<div class="alert alert-warning">Are you sure that you want to delete this employee? This will delete all of his data records.
					</div> <?php
					$count = $sql->c('SELECT COUNT(`id`) FROM `salary` WHERE `id_worker` = ?', $_GET['worker_id']);
					if($count) { ?>
						<p>Amount of data records connected to this employee: <?= $count ?></p><br> <?php
					} ?>
					<a class="btn btn-danger" href="?d=workers&r=worker_deleted&worker_id=<?= $_GET['worker_id'] ?>">Yes, delete</a>
					<a class="btn btn-primary" href="?d=categories">No, cancel</a>

					<?php
				}

			}
			else {

				if(array_key_exists('r', $_GET)) {

					if($_GET['r'] == 'worker_created' && array_key_exists('submit', $_POST) && array_key_exists('worker_name', $_POST) && strlen($_POST['worker_name']) > 0 && array_key_exists('id_category', $_POST) && is_numeric($_POST['id_category']) && $_POST['id_category'] > 1 && array_key_exists('percent_salary', $_POST) && is_numeric($_POST['percent_salary'])) {
						$sql->a('INSERT INTO `workers`(`name`,`id_category`,`percent`,`active`,`base_income`) VALUES(?,?,?,?,?)', $_POST['worker_name'], $_POST['id_category'], $_POST['percent_salary'], ($_POST['show_worker'] != "") ? "1" : "0", $_POST['base_income']);
						helper::alert('Employee created', 'success');
					}
					if($_GET['r'] == 'worker_deleted' && array_key_exists('worker_id', $_GET) && is_numeric($_GET['worker_id']) && $_GET['worker_id'] > 0) {
						$sql->a('DELETE FROM `salary` WHERE `id_worker` = ?', $_GET['worker_id']);

						$sql->a('DELETE FROM `workers` WHERE `id` = ?', $_GET['worker_id']);

						helper::alert('Employee deleted!', 'success');
					}
					if($_GET['r'] == 'edited' && array_key_exists('ids', $_POST) && strlen($_POST['ids']) > 0) {
						$list_of_id = explode(',', $_POST['ids']);

						foreach($list_of_id as $id)
							if(array_key_exists('worker_name_' . $id, $_POST) && strlen($_POST['worker_name_' . $id]) > 0 && array_key_exists('id_category_' . $id, $_POST) && is_numeric($_POST['id_category_' . $id]) && $_POST['id_category_' . $id] > 1 && array_key_exists('percent_salary_' . $id, $_POST) && is_numeric($_POST['percent_salary_' . $id]))
								$sql->a('UPDATE `workers` SET `name`=?, `id_category`=?, `percent`=?, `active`=?, `base_income`=? WHERE `id`=?', $_POST['worker_name_' . $id], $_POST['id_category_' . $id], $_POST['percent_salary_' . $id], ($_POST['worker_visibility_' . $id] != '') ? 1 : 0, $_POST['base_income_' . $id], (int)$id);

						helper::alert('Changes saved!', 'success');
					}

				}

				$workers = $sql->res2data($sql->a('SELECT * FROM `workers` ORDER BY `active` = 1 DESC')); ?>

				<form method="post" action="?d=workers&r=edited">

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Employee name</th>
								<th>Department</th>
								<th>Salary percentage</th>
								<th>Base salary</th>
								<th>Show employee</th>
								<th>Delete</th>
							</tr>
						</thead>

						<tbody> <?php

							$list_of_id = [];
							$categories = $sql->res2data($sql->a('SELECT `name`,`id` FROM `categories`'));
							foreach($workers as $worker) {
								$list_of_id[] = $worker['id']; ?>
								<tr>
									<td>
										<input type="text" placeholder="Ім'я продавця" class="form-control" name="worker_name_<?= $worker['id'] ?>" value="<?= $worker['name'] ?>">
									</td>
									<td>
										<select name="id_category_<?= $worker['id'] ?>" class="form-control" required> <?php
											foreach($categories as $category) { ?>
												<option value="<?= $category['id'] ?>" <?php if($category['id'] == $worker['id_category']) echo 'selected'; ?>><?= $category['name'] ?></option> <?php
											} ?>
										</select>
									</td>
									<td>
										<input type="number" step="0.01" class="form-control" name="percent_salary_<?= $worker['id'] ?>" placeholder="Відсоток зарплати" value="<?= $worker['percent'] ?>" required>
									</td>
									<td>
										<input type="number" step="0.01" class="form-control" name="base_income_<?= $worker['id'] ?>" placeholder="Базова зарплата" value="<?= $worker['base_income'] ?>">
									</td>
									<td>
										<input type="checkbox" name="worker_visibility_<?= $worker['id'] ?>" <?php if($worker['active'] != 0) echo 'checked' ?>>
									</td>
									<td>
										<a class="btn btn-danger btn-sm" href="?d=workers&a=confirm_delete&worker_id=<?= $worker['id'] ?>">x</a>
									</td>
								</tr> <?php
							} ?>
						</tbody>

					</table>

					<div class="btn-group">
						<input type="hidden" name="ids" value="<?= implode(',', $list_of_id) ?>">
						<input type="submit" class="btn btn-primary" name="submit" value="Save changes">
						<a href="?d=workers&a=add_worker" class="btn btn-success">Add employee</a>
					</div>

				</form>

				<?php

			}
		}

		private static function show_money() {

			global $sql;

			if(!array_key_exists('m', $_GET))
				$_GET['m'] = '7'; ?>

			<div class="row mt-4"> <?php

				if(!array_key_exists('date', $_GET) || !is_numeric($_GET['date']) || $_GET['date'] < 0)
					$_GET['date'] = strtotime("midnight", $_SERVER['REQUEST_TIME']);

				$year = date('Y', $_GET['date']);

				if(array_key_exists('category', $_POST))
					$_GET['category'] = $_POST['category'];

				if(!array_key_exists('category', $_GET) || $_GET['category'] == 'all' || !is_numeric($_GET['category']) || $_GET['category'] < 0) {
					$category_url = '';
					$category_sql = '';
				}
				else {
					$category_url = '&category=' . $_GET['category'];
					$category_sql = 'AND c.id = ' . $_GET['category'];
				}

				$categories = $sql->res2data($sql->a('SELECT `name`,`id` FROM `categories` WHERE `active` = 1'));
				$workers = $sql->res2data($sql->a('SELECT w.*,0.00 as "sum_profit",0.00 as "sum_cost" FROM workers w INNER JOIN categories c ON c.id = w.id_category WHERE w.active = 1 AND c.active = 1 ' . $category_sql . ' ORDER BY w.id ASC'));

				$count_workers = count($workers);

				$active_menus = [];
				if($_GET['m'] == '7')
					$active_menus['7'] = true;
				elseif($_GET['m'] == '30')
					$active_menus['30'] = true;
				elseif($_GET['m'] == '365')
					$active_menus['365'] = true;
				elseif($_GET['m'] == 'all')
					$active_menus['all'] = true;

				if($active_menus['7'])
					$days_shown = 7;
				elseif($active_menus['30'])
					$days_shown = date('t', $_GET['date']);
				elseif($active_menus['365'])
					$days_shown = 365 + date('L', $_GET['date']);
				else
					$days_shown = false;

				if(array_key_exists('show', $_GET) && $days_shown) {
					if($_GET['show'] == "previous")
						$_GET['date'] = $_GET['date'] - $days_shown * 86400;
					if($_GET['show'] == "next")
						$_GET['date'] = $_GET['date'] + $days_shown * 86400;
				} ?>

				<script>
					let backgroundColor = [<?=helper::$js_chart_main_colors?>];
					let borderColor = [<?=helper::$js_chart_border_colors?>];
				</script>

				<div class="col-sm-12 col-md-4 col-lg-2">

					<div id="horizontal_menu" class="mb-4">
						<p>Вигляд:</p>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=7&date=<?= $_GET['date'] . $category_url ?>" class="menu_items <?= $active_menus['7'] ? "active" : "" ?>">7</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=30&date=<?= $_GET['date'] . $category_url ?>" class="menu_items <?= $active_menus['30'] ? "active" : "" ?>">30</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=365&date=<?= $_GET['date'] . $category_url ?>" class="menu_items <?= $active_menus['365'] ? "active" : "" ?>">365</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=all&date=<?= $_GET['date'] . $category_url ?>" class="menu_items <?= $active_menus['all'] ? "active" : "" ?>">*</a>
					</div>

					<form method="post" action="?d=<?= $_GET['d'] ?>&m=<?= $_GET['m'] ?>&date=<?= $_GET['date'] ?>">
						<p>Department:</p>
						<select class="form-control mb-2" name="category" onchange="this.form.submit()">
							<option value="all" <?php if(!array_key_exists('category', $_GET) || !is_numeric($_GET['category']) && $_GET['category'] <= 0) echo 'selected'; ?>>
								All departments
							</option><?php
							foreach($categories as $category) { ?>
								<option value="<?= $category['id'] ?>" <? if($_GET['category'] == $category['id']) echo 'selected'; ?>><?= $category['name'] ?></option> <?php
							} ?>
						</select>

					</form> <?php

					if($days_shown) { ?>
						<p>Dates</p>
						<a href="?d=<?= $_GET['d'] ?>&m=<?= $_GET['m'] ?>&date=<?= $_GET['date'] . $category_url ?>&show=previous" class="btn btn-info float-left">&lt;&lt;</a>
						<a href="?d=<?= $_GET['d'] ?>&m=<?= $_GET['m'] ?>&date=<?= $_GET['date'] . $category_url ?>&show=next" class="btn btn-info float-right">&gt;&gt;</a> <?php
					} ?>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-10"> <?php

					if($_GET['m'] == 7) {

						$week = date('W', $_GET['date']);
						$day_of_week = date('N', $_GET['date']) - 1;
						if(date('d-m-Y', $_GET['date']) == date('d-m-Y', time()))
							$is_today = true;
						else
							$is_today = false;
						$first_day_of_week = $_GET['date'] - $day_of_week * 86400;
						$last_day_of_week = $first_day_of_week+7*86400;

						if(array_key_exists('submit', $_POST)) {

							$keys = array_keys($_POST);
							$length = count($keys);
							$begin_id = 14;

							for($i = 0; $i < $length; $i++)
								if(preg_match('/worker_profit_/', $keys[$i])) {
									$end_id = strpos(substr($keys[$i], $begin_id), '_');

									$worker_id = substr($keys[$i], $begin_id, $end_id);
									$week_day = substr($keys[$i], $end_id + $begin_id + 1);
									$week_day_unix = $first_day_of_week+$week_day*86400;

									$profit = $_POST['worker_profit_' . $worker_id . '_' . $week_day];
									$cost = $_POST['worker_product_cost_' . $worker_id . '_' . $week_day];

									if(preg_match('/[+\-*/]/', $profit))
										eval('$profit = ' . $profit . ';');
									if(preg_match('/[+\-*/]/', $cost))
										eval('$cost = ' . $cost . ';');

									if($profit === '')
										$profit = 0;
									if($cost === '')
										$cost = 0;

									if($profit >= 0 && $cost >= 0 && $worker_id >= 0 && $week_day >= 0 && $week_day < 7) {
										/*
										if($profit == 0 && $cost == 0)
											$sql->a('DELETE FROM `salary` WHERE `id_worker` = ? AND YEAR(FROM_UNIXTIME(`date`)) = ? AND WEEK(FROM_UNIXTIME(`date`),1) = ? AND WEEKDAY(FROM_UNIXTIME(`date`)) = ?', $worker_id, $year, $week, $week_day);
										else if($sql->c('SELECT COUNT(`id`) FROM `salary` WHERE `id_worker` = ? AND YEAR(FROM_UNIXTIME(`date`)) = ? AND WEEK(FROM_UNIXTIME(`date`),1) = ? AND WEEKDAY(FROM_UNIXTIME(`date`)) = ?', $worker_id, $year, $week, $week_day) == 1)
											$sql->a('UPDATE `salary` SET `amount` = ?, `products_cost` = ? WHERE `id_worker` = ? AND YEAR(FROM_UNIXTIME(`date`)) = ? AND WEEK(FROM_UNIXTIME(`date`),1) = ? AND WEEKDAY(FROM_UNIXTIME(`date`)) = ?', $profit, $cost, $worker_id, $year, $week, $week_day);
										else {
											$sql->a('INSERT INTO `salary`(`id_worker`,`amount`,`products_cost`,`date`) VALUES(?,?,?,?)', $worker_id, $profit, $cost, $first_day_of_week + $week_day * 86400);
											//var_dump('INSERT INTO salary(id_worker,amount,products_cost,date) VALUES(?,?,?,?)', $worker_id, $profit, $cost, $first_day_of_week + $week_day * 86400);
										}
										*/
										if($profit == 0 && $cost == 0)
											$sql->a('DELETE FROM `salary` WHERE `id_worker` = ? AND `date` = ?', $worker_id, $week_day_unix);
										elseif($sql->c('SELECT COUNT(`id`) FROM `salary` WHERE `id_worker` = ? AND `date` = ?', $worker_id, $week_day_unix) == 1)
											$sql->a('UPDATE `salary` SET `amount` = ?, `products_cost` = ? WHERE `id_worker` = ? AND `date` = ?', $profit, $cost, $worker_id, $week_day_unix);
										else {
											$sql->a('INSERT INTO `salary`(`id_worker`,`amount`,`products_cost`,`date`) VALUES(?,?,?,?)', $worker_id, $profit, $cost, $week_day_unix);
											//var_dump('INSERT INTO salary(id_worker,amount,products_cost,date) VALUES(?,?,?,?)', $worker_id, $profit, $cost, $first_day_of_week + $week_day * 86400);
										}
									}
								}
						}


						//$salary = $sql->res2data($sql->a('SELECT s.id_worker,s.amount,s.products_cost,s.date FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND YEAR(FROM_UNIXTIME(s.date)) = ? AND WEEK(FROM_UNIXTIME(s.date),1) = ? ' . $category_sql . ' ORDER BY w.id ASC,s.date ASC', $year, $week));

						//var_dump('SELECT s.id_worker,s.amount,s.products_cost,s.date FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND YEAR(FROM_UNIXTIME(s.date)) = ? AND WEEK(FROM_UNIXTIME(s.date),1) = ? ' . $category_sql . ' ORDER BY w.id ASC,s.date ASC', $year, $week); ?>

						$salary = $sql->res2data($sql->a('SELECT s.id_worker,s.amount,s.products_cost,s.date FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND s.date >= ? ' . $category_sql . ' AND s.date <= ? ORDER BY w.id ASC,s.date ASC', $first_day_of_week, $last_day_of_week));

						//var_dump('SELECT s.id_worker,s.amount,s.products_cost,s.date FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND s.date >= ? ' . $category_sql . ' AND s.date <= ? ORDER BY w.id ASC,s.date ASC', $first_day_of_week, $last_day_of_week); ?>


						<form method="post" action="?d=money&m=7&date=<?= $_GET['date'] ?>&category=<?= $category_url ?>">
							<table class="table table-striped table-bordered" id="table_content">
								<thead>
									<tr>
										<th>Date</th> <?php
										for($i = 0; $i < $count_workers; $i++) {
											if($count_workers != 1 && $i + 1 != $count_workers && $workers[$i]['id_category'] != $workers[$i + 1]['id_category'])
												$workers[$i]['last_worker_of_category'] = true; ?>
											<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												<?= $workers[$i]['name'] ?>
												<input type="hidden" class="percentage form-control" value="<?= $workers[$i]['percent'] ?>">
												<input type="hidden" class="worker_id" value="<?= $workers[$i]['id'] ?>">
											</th> <?php
										} ?>
									</tr>
								</thead>

								<tbody> <?php
									for($i = 0; $i < 7; $i++) { //rows ?>
										<tr>
											<td <?php if($i == $day_of_week && $is_today) echo 'class="border border-success" title="Today"'; ?>><?= helper::week_to_lang($i, false) . ' ' . date('d.m Y', $first_day_of_week + 86400 * $i) ?></td> <?php
											for($ii = 0; $ii < $count_workers; $ii++) { // cols

												if($i == 0)
													$workers[$ii]['worker_ordering_id'] = 0;

												while(
													$workers[$ii]['worker_ordering_id'] !== null
													&&
													$workers[$ii]['worker_ordering_id'] < count($salary)
													&&
													(
														$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] < $workers[$ii]['id']
														||
														(
															$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] == $workers[$ii]['id']
															&&
															date('N', $salary[$workers[$ii]['worker_ordering_id']]['date']) - 1 < $i
														)

													)
												) {
													if(count($salary) < $workers[$ii]['worker_ordering_id'] || $salary[$workers[$ii]['worker_ordering_id']]['id_worker'] > $workers[$ii]['id'])
														$workers[$ii]['worker_ordering_id'] = null;
													$workers[$ii]['worker_ordering_id']++;
												}

												$last_worker_class = '';
												if($workers[$ii]['last_worker_of_category'])
													$last_worker_class = 'last_worker_of_category';

												if($workers[$ii]['worker_ordering_id'] !== null && array_key_exists($workers[$ii]['worker_ordering_id'], $salary) && $salary[$workers[$ii]['worker_ordering_id']]['id_worker'] == $workers[$ii]['id'] && date('N', $salary[$workers[$ii]['worker_ordering_id']]['date']) - 1 == $i) {
													$cur_profit = $salary[$workers[$ii]['worker_ordering_id']]['amount'];
													$cur_cost = $salary[$workers[$ii]['worker_ordering_id']++]['products_cost'];

													$workers[$ii]['sum_profit'] += $cur_profit;
													$workers[$ii]['sum_cost'] += $cur_cost;
													?>

													<td class="<?= $last_worker_class ?>">

														<input type="text" placeholder="Revenue" name="worker_profit_<?= $workers[$ii]['id'] ?>_<?= $i ?>" class="tiny_field profit" value="<?= $cur_profit ?>">
														<input type="text" placeholder="Products cost" name="worker_product_cost_<?= $workers[$ii]['id'] ?>_<?= $i ?>" class="tiny_field product_cost" value="<?= $cur_cost ?>">
														<input type="text" placeholder="Salary" disabled class="tiny_field salary" value="<?php if($cur_profit != null) echo round($cur_profit * $workers[$ii]['percent'] / 100, 2); ?>">
													</td> <?php
												}
												else { ?>
													<td class="data_uncover <?= $last_worker_class ?>"></td> <?php
												}

											} ?>

										</tr>
										<?php
									} ?>


								</tbody>

								<tfoot>
									<tr>
										<th></th> <?php
										for($i = 0; $i < $count_workers; $i++) { ?>
											<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												<?= $workers[$i]['name'] ?>
											</th> <?php
										} ?>
									</tr>

									<tr class="table-primary">
										<td id="sum_sqr">Weekly sum</td> <?php
										$workers_sum_profit = 0;
										$workers_sum_cost = 0;
										$workers_sum_salary = 0;
										for($ii = 0; $ii < count($workers); $ii++) {
											$workers_sum_profit += $workers[$ii]['sum_profit'];
											$workers_sum_cost += $workers[$ii]['sum_cost'];
											$workers_sum_salary += round($workers[$ii]['sum_profit'] * $workers[$ii]['percent'] / 100, 2);
											?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												Revenue: <?= $workers[$ii]['sum_profit'] ?><br>
												Products cost: <?= $workers[$ii]['sum_cost'] ?><br>
												Salary: <?= round($workers[$ii]['sum_profit'] * $workers[$ii]['percent'] / 100, 2) ?>
												<br>
											</td>
											<?php
										} ?>

									</tr>

									<script>
										$( '#sum_sqr' ).append( '<br>Revenue: <?=$workers_sum_profit?><br>Products cost:  <?=$workers_sum_cost?><br>Salary:  <?=$workers_sum_salary?>' );
									</script>
								</tfoot>
							</table>

							<input type="submit" name="submit" value="Save changes" class="btn btn-success">
						</form>

						<script>

							let num_of_cells_added = 0;
							let counter_of_cells = $( 'input[name="num_of_cells_added"]' );

							$( '.data_uncover' ).click( function() {

								let el = $( this );
								if( !el.hasClass( 'data_uncover' ) )
									return;

								let worker_index = el.index() + 1;
								let worker_th = $( '#table_content' ).children( 'thead' ).children( 'tr' ).children( 'th:nth-child(' + worker_index + ')' );

								let worker_id = worker_th.children( 'input.worker_id' ).val();
								let day_of_week = el.parent().index();
								el.html( `<input type="text" placeholder="Revenue" name="worker_profit_` + worker_id + `_` + day_of_week + `" class="tiny_field profit">
										<input type="text" placeholder="Products cost" name="worker_product_cost_` + worker_id + `_` + day_of_week + `" class="tiny_field product_cost">
										<input type="text" placeholder="Salary" disabled class="tiny_field salary">` );

								el.children( 'input.profit' ).focus();

								el.removeClass( 'data_uncover' );

								counter_of_cells.val( ++num_of_cells_added );
							} );

							$( 'td' ).on( 'input', 'input.profit', function() {
								let el = $( this );
								let profit = el.val();
								let salary = 0;

								let worker_index = el.parent().index() + 1;
								let worker_th = $( '#table_content' ).find( 'thead' ).find( 'tr' ).find( 'th:nth-child(' + worker_index + ')' );

								if( profit > 0 ){
									let percent_salary = worker_th.children( '.percentage' ).val();
									salary = profit / 100 * percent_salary;
								}

								el.parent().children( '.salary' ).val( salary.toFixed( 2 ) );

							} );

						</script> <?php
					}
					elseif($_GET['m'] == 30) {

					$month = date('n', $_GET['date']);

					$salary = $sql->res2data($sql->a('SELECT s.id_worker,SUM(s.amount) AS "amount",SUM(s.products_cost) AS "products_cost" FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND YEAR(FROM_UNIXTIME(s.date)) = ? AND MONTH(FROM_UNIXTIME(s.date)) = ? ' . $category_sql . ' GROUP BY s.id_worker ORDER BY w.id ASC', $year, $month));

					$count_salary = count($salary); ?>

						<h1 class="mb-4"><?= helper::month_to_lang($month - 1) ?> <?= $year ?></h1>

						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th></th><?php
									for($i = 0; $i < $count_workers; $i++) {
										if($count_workers != 1 && $i + 1 != $count_workers && $workers[$i]['id_category'] != $workers[$i + 1]['id_category'])
											$workers[$i]['last_worker_of_category'] = true; ?>
										<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											<?= $workers[$i]['name'] ?>
										</th> <?php
									} ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="table-active" id="sum_profit">Revenue</td> <?php
									$sum_profit = 0;

									for($i = 0, $ii = 0; $ii < $count_workers; $i++, $ii++) {

										if($salary[$i]['id_worker'] != $workers[$ii]['id']) {
											$i--; ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												0
											</td> <?php
										}
										else { ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												<?= $salary[$i]['amount'] ?>
											</td> <?php
											$sum_profit += $salary[$i]['amount'];
											$workers[$ii]['amount'] += $salary[$i]['amount'];
											$workers[$ii]['clean_profit'] += $salary[$i]['amount'];
										}

									} ?>
									<script>
										$( '#sum_profit' ).append( " (<?=$sum_profit?>)" );
									</script>
								</tr>

								<tr>
									<td class="table-active" id="sum_cost">Products cost</td> <?php
									$sum_cost = 0;

									for($i = 0, $ii = 0; $ii < $count_workers; $i++, $ii++) {

										if($salary[$i]['id_worker'] != $workers[$ii]['id']) {
											$i--; ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												0
											</td> <?php
										}
										else { ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												<?= $salary[$i]['products_cost'] ?>
											</td> <?php
											$sum_cost += $salary[$i]['products_cost'];
											$workers[$ii]['clean_profit'] -= $salary[$i]['products_cost'];
										}

									} ?>
									<script>
										$( '#sum_cost' ).append( " (<?=$sum_cost?>)" );
									</script>
								</tr>

								<tr>
									<td class="table-active" id="sum_salary">Salary</td> <?php
									$sum_salary = 0;

									for($i = 0, $ii = 0; $ii < $count_workers; $i++, $ii++) {

										if($salary[$i]['id_worker'] != $workers[$ii]['id']) {
											$i--; ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												0
											</td> <?php
										}
										else {
											$sum_salary += round($salary[$i]['amount'] * $workers[$ii]['percent'] / 100, 2) + $workers[$ii]['base_income']; ?>
											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
												<?= round($salary[$i]['amount'] * $workers[$ii]['percent'] / 100, 2) + $workers[$ii]['base_income'] ?>
											</td> <?php
										}

									} ?>
									<script>
										$( '#sum_salary' ).append( " (<?=$sum_salary?>)" );
									</script>
								</tr>
							</tbody>
						</table>

						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
						<canvas id="month_chart" width="1000" height="300"></canvas>
						<canvas id="month_chart2" width="1000" height="300"></canvas>
						<script>
							let ctx = document.getElementById( 'month_chart' ).getContext( '2d' );
							let myChart = new Chart( ctx, {
								type : 'bar',
								data : {
									labels : [<?=helper::jsfy_array($workers, 'name')?>],
									datasets : [{
										label : 'Revenue',
										data : [<?=helper::jsfy_array($workers, 'amount')?>],
										backgroundColor : backgroundColor,
										borderColor : borderColor,
										borderWidth : 1,
									}],
								},
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
							let ctx2 = document.getElementById( 'month_chart2' ).getContext( '2d' );
							let myChart2 = new Chart( ctx2, {
								type : 'bar',
								data : {
									labels : [<?=helper::jsfy_array($workers, 'name')?>],
									datasets : [{
										label : 'Profit',
										data : [<?=helper::jsfy_array($workers, 'clean_profit')?>],
										backgroundColor : backgroundColor,
										borderColor : borderColor,
										borderWidth : 1,
									}],
								},
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
						</script> <?php

					}
					elseif($_GET['m'] == 365) {

					$year = date('Y', $_GET['date']);
					$month = date('m', $_GET['date']) - 1;

					$salary = $sql->res2data($sql->a('SELECT s.id_worker,SUM(s.amount) AS "amount",SUM(s.products_cost) AS "products_cost", 0 AS "sum_profit", 0 AS "sum_products_cost", 0 AS "sum_salaries", MONTH(FROM_UNIXTIME(s.date)) AS "month" FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 AND YEAR(FROM_UNIXTIME(s.date)) = ? ' . $category_sql . ' GROUP BY s.id_worker, month ORDER BY w.id ASC,month ASC', $year));

					$count_salary = count($salary); ?>

						<h1 class="mb-4"><?= $year ?></h1>

						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th></th><?php
									for($i = 0; $i < $count_workers; $i++) {
										if($count_workers != 1 && $i + 1 != $count_workers && $workers[$i]['id_category'] != $workers[$i + 1]['id_category'])
											$workers[$i]['last_worker_of_category'] = true; ?>
										<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											<?= $workers[$i]['name'] ?>
										</th> <?php
									} ?>
								</tr>
							</thead>
							<tbody> <?php

								for($i = 0; $i < 12; $i++) { ?>

									<tr>
										<th class="table-active"><?= helper::month_to_lang($i) ?></th> <?php

										for($ii = 0; $ii < $count_workers; $ii++) {

											// if($ii > $month) {
											// 	echo '<td></td>';
											// 	break;
											// }

											if($i == 0)
												$workers[$ii]['worker_ordering_id'] = 0;

											while(
												$workers[$ii]['worker_ordering_id'] !== null
												&&
												$workers[$ii]['worker_ordering_id'] < count($salary)
												&&
												(
													$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] != $workers[$ii]['id']
													||
													(
														$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] == $workers[$ii]['id']
														&&
														$salary[$workers[$ii]['worker_ordering_id']]['month'] - 1 < $i
													)

												)
											) {
												$workers[$ii]['worker_ordering_id']++;
												if(count($salary) < $workers[$ii]['worker_ordering_id'] || $salary[$i]['id_worker'] > $workers[$ii]['id'])
													$workers[$ii]['worker_ordering_id'] = null;
											} ?>

											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>> <?php
												if(array_key_exists($workers[$ii]['worker_ordering_id'], $salary) && $salary[$workers[$ii]['worker_ordering_id']]['month'] - 1 == $i) { ?>
													Revenue: <?= $salary[$workers[$ii]['worker_ordering_id']]['amount'] ?>
													<br>													Products cost: <?= $salary[$workers[$ii]['worker_ordering_id']]['products_cost'] ?>
													<br>													Salary: <?php

													$workers[$ii]['sum_profit'] += $salary[$workers[$ii]['worker_ordering_id']]['amount'];
													$workers[$ii]['sum_products_cost'] += $salary[$workers[$ii]['worker_ordering_id']]['products_cost'];
													$temp_salary = round($salary[$workers[$ii]['worker_ordering_id']]['amount'] * $workers[$ii]['percent'] / 100 + $workers[$ii]['base_income'], 2);
													if($temp_salary > 0) {
														echo $temp_salary;
														$workers[$ii]['sum_salaries'] += $temp_salary;
													}
												} ?>
											</td> <?php
										} ?>
									</tr> <?php
								} ?>

								<tr>
									<th></th><?php
									for($i = 0; $i < $count_workers; $i++) { ?>
										<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											<?= $workers[$i]['name'] ?>
										</th> <?php
									} ?>
								</tr>

								<tr class="table-primary">
									<th id="sum_sqr">Yearly</th> <?php
									$workers_sum_profit = 0;
									$workers_sum_cost = 0;
									$workers_sum_salary = 0;

									$workers_salary_array = [];
									$workers_difference_array = [];

									for($ii = 0; $ii < $count_workers; $ii++) {
										$workers_sum_profit += $workers[$ii]['sum_profit'];
										$workers_sum_cost += $workers[$ii]['sum_products_cost'];
										$workers_sum_salary += $workers[$ii]['sum_salaries'];

										$workers[$ii]['clean_revenue'] = $workers[$ii]['sum_profit'] - $workers[$ii]['sum_products_cost'];

										$workers_salary_array[] = $workers[$ii]['sum_profit'];
										$workers_difference_array[] = $workers[$ii]['clean_revenue']; ?>
										<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											Revenue: <?= $workers[$ii]['sum_profit'] ?><br>
											Products cost: <?= $workers[$ii]['sum_products_cost'] ?><br>
											Salary: <?= $workers[$ii]['sum_salaries'] ?>
										</td> <?php

									} ?>
								</tr>
							</tbody>
						</table>

						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
						<canvas id="year_chart" width="1000" height="300"></canvas>
						<canvas id="year_chart2" width="1000" height="300"></canvas>
						<script>
							$( '#sum_sqr' ).append( '<br>Revenue: <?=$workers_sum_profit?><br>Products cost:  <?=$workers_sum_cost?><br>Salary:  <?=$workers_sum_salary?>' );
							let months = [<?=helper::jsfy_array(helper::month_to_lang(false))?>];

							$( 'th' ).click( function() {
								let el = $( this );

								if( el.parent().parent().is( 'thead' ) ){
									let worker_name = el.text().trim();
									let worker_order = el.index() + 1;//2-i
									let worker_profit_cells = $( 'tbody tr td:nth-child(' + worker_order + ')' );
									let profit_data = [];
									let clean_profit_data = [];
									let i = 0;
									let buf;

									worker_profit_cells.each( function( key, cell ) {
										profit_data[i] = $( cell ).html();

										buf = profit_data[i].split( '<br>' );

										profit_data[i] = buf[0].trim();
										profit_data[i] = parseFloat( profit_data[i].substr( 9 ) );
										if( isNaN( profit_data[i] ) )
											profit_data[i] = 0;

										if( buf.length > 1 ){
											clean_profit_data[i] = buf[1].trim();
											clean_profit_data[i] = profit_data[i] - parseFloat( clean_profit_data[i].substr( 8 ) );
											if( isNaN( clean_profit_data[i] ) )
												clean_profit_data[i] = 0;
										}
										else
											clean_profit_data[i] = 0;

										i++;
									} );

									chart_data.labels = months;
									chart2_data.labels = months;

									chart_data.datasets = [{
										label : worker_name + ' (Revenue)',
										data : profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];
									chart2_data.datasets = [{
										label : worker_name + ' (Profit)',
										data : clean_profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];

									window.chart.update();
									window.chart2.update();

								}
								elseif( el.parent().parent().is( 'tbody' ) && el.parent().index() + 1 != 13 ){
									let month = el.text().trim();
									let month_number = el.parent().index() + 1;//1-12 + 14
									let profit_cells = el.parent().find( 'th:not(:first-child),td:not(:first-child)' );
									let profit_data = [];
									let i = 0;
									let workers = $( 'thead tr th:not(:first-child)' );
									let workers_names = [];
									let clean_profit_data = [];
									let buf;

									if( month_number === 14 )
										month = '2018';

									workers.each( function( key, cell ) {
										workers_names.push( $( cell ).text().trim() );
									} );

									profit_cells.each( function( key, cell ) {
										profit_data[i] = $( cell ).html();

										buf = profit_data[i].split( '<br>' );

										profit_data[i] = buf[0].trim();
										profit_data[i] = parseFloat( profit_data[i].substr( 9 ) );
										if( isNaN( profit_data[i] ) )
											profit_data[i] = 0;

										if( buf.length > 1 ){
											clean_profit_data[i] = buf[1].trim();
											clean_profit_data[i] = profit_data[i] - parseFloat( clean_profit_data[i].substr( 8 ) );
											if( isNaN( clean_profit_data[i] ) )
												clean_profit_data[i] = 0;
										}
										else
											clean_profit_data[i] = 0;

										i++;
									} );

									chart_data.labels = workers_names;
									chart2_data.labels = workers_names;

									chart_data.datasets = [{
										label : month + ' (Revenue)',
										data : profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];
									chart2_data.datasets = [{
										label : month + ' (Profit)',
										data : clean_profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];

									window.chart.update();
									window.chart2.update();
								}
							} );

							let ctx = document.getElementById( 'year_chart' ).getContext( '2d' );
							let ctx2 = document.getElementById( 'year_chart2' ).getContext( '2d' );
							let chart_data = {
								labels : [<?=helper::jsfy_array($workers, 'name')?>],
								datasets : [{
									label : 'Revenue',
									data : <?=json_encode($workers_salary_array)?>,
									backgroundColor : backgroundColor,
									borderColor : borderColor,
									borderWidth : 1,
								}],
							};
							let chart2_data = {
								labels : [<?=helper::jsfy_array($workers, 'name')?>],
								datasets : [{
									label : 'Profit',
									data : <?=json_encode($workers_difference_array)?>,
									backgroundColor : backgroundColor,
									borderColor : borderColor,
									borderWidth : 1,
								}],
							};
							window.chart = new Chart( ctx, {
								type : 'bar',
								data : chart_data,
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
							window.chart2 = new Chart( ctx2, {
								type : 'bar',
								data : chart2_data,
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
						</script> <?php

					}
					else {


					$salary = $sql->res2data($sql->a('SELECT s.id_worker,SUM(s.amount) AS "amount",SUM(s.products_cost) AS "products_cost", 0 AS "sum_profit", 0 AS "sum_products_cost", 0 AS "sum_salaries", YEAR(FROM_UNIXTIME(s.date)) AS "year" FROM salary s INNER JOIN workers w ON s.id_worker = w.id INNER JOIN categories c ON w.id_category = c.id WHERE w.active = 1 AND c.active = 1 ' . $category_sql . ' GROUP BY s.id_worker, year ORDER BY w.id ASC,year ASC'));

					$min_year = 10000;
					$max_year = 0;
					$years = [];

					foreach($salary as $row) {
						if($row['year'] < $min_year)
							$min_year = $row['year'];
						if($row['year'] > $max_year)
							$max_year = $row['year'];
					}
					$years_count = $max_year - $min_year;

					for($i = 0; $i <= $years_count; $i++)
						$years[] = $min_year + $i;

					$count_salary = count($salary);

					$work_months_by_year_array = $sql->res2data($sql->a('SELECT `worker_id`,COUNT("month_of_work") AS "month_of_work",`year` FROM (SELECT DISTINCT `w`.`id` AS "worker_id",MONTH(FROM_UNIXTIME(`s`.`date`)) AS "month_of_work",YEAR(FROM_UNIXTIME(`s`.`date`)) AS "year" FROM `w_salary` `s` INNER JOIN `w_workers` `w` ON `w`.`id` = `s`.`id_worker`) `d` GROUP BY `worker_id`,`year`')); ?>

						<h1 class="mb-4">All years</h1>

						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th></th><?php
									for($i = 0; $i < $count_workers; $i++) {
										if($count_workers != 1 && $i + 1 != $count_workers && $workers[$i]['id_category'] != $workers[$i + 1]['id_category'])
											$workers[$i]['last_worker_of_category'] = true; ?>
										<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											<?= $workers[$i]['name'] ?>
										</th> <?php
									} ?>
								</tr>
							</thead>
							<tbody> <?php

								for($i = 0; $i <= $years_count; $i++) { ?>
									<tr>
										<th class="table-active"><?= $min_year + $i ?></th> <?php

										for($ii = 0; $ii < $count_workers; $ii++) {


											if($i == 0) {
												foreach($work_months_by_year_array as $work_months_by_year)
													if($work_months_by_year['worker_id'] == $workers[$ii]['id'])
														$workers[$ii]['working_months'][$work_months_by_year['year']] = $work_months_by_year['month_of_work'];

												$workers[$ii]['worker_ordering_id'] = 0;
											}

											while(
												$workers[$ii]['worker_ordering_id'] !== null
												&&
												$workers[$ii]['worker_ordering_id'] < $count_salary
												&&
												(
													$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] != $workers[$ii]['id']
													||
													(
														$salary[$workers[$ii]['worker_ordering_id']]['id_worker'] == $workers[$ii]['id']
														&&
														$salary[$workers[$ii]['worker_ordering_id']]['year'] - $min_year < $i
													)

												)
											) {
												$workers[$ii]['worker_ordering_id']++;
												/*if($count_salary < $workers[$ii]['worker_ordering_id'] || $salary[$i]['id_worker'] > $workers[$ii]['id'])
													$workers[$ii]['worker_ordering_id'] = null;*/
											} ?>


											<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>> <?php

												if(array_key_exists($workers[$ii]['worker_ordering_id'], $salary) && $salary[$workers[$ii]['worker_ordering_id']]['year'] == $min_year + $i) { ?>
													Revenue: <?= number_format($salary[$workers[$ii]['worker_ordering_id']]['amount'], 2, '.', ' ') ?>
													<br>                                                    Products cost: <?= number_format($salary[$workers[$ii]['worker_ordering_id']]['products_cost'], 2, '.', ' ') ?>
													<br>                                                    Salary: <?php

													$workers[$ii]['sum_profit'] += $salary[$workers[$ii]['worker_ordering_id']]['amount'];
													$workers[$ii]['sum_products_cost'] += $salary[$workers[$ii]['worker_ordering_id']]['products_cost'];

													$base_yearly_income = $workers[$ii]['working_months'][$years[$i]] * $workers[$ii]['base_income'];

													$temp_salary = round($salary[$workers[$ii]['worker_ordering_id']]['amount'] * $workers[$ii]['percent'] / 100 + $base_yearly_income, 2);
													//if($temp_salary > 0) {
													echo number_format($temp_salary, 2, '.', ' ');
													$workers[$ii]['sum_salaries'] += $temp_salary;
													//}
												} ?>
											</td> <?php
										} ?>
									</tr> <?php
								} ?>

								<tr>
									<th></th><?php
									for($i = 0; $i < $count_workers; $i++) {
										if($count_workers != 1 && $i + 1 != $count_workers && $workers[$i]['id_category'] != $workers[$i + 1]['id_category'])
											$workers[$i]['last_worker_of_category'] = true; ?>
										<th <?php if($workers[$i]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											<?= $workers[$i]['name'] ?>
										</th> <?php
									} ?>
								</tr>

								<tr class="table-primary">
									<th id="sum_sqr">All years</th> <?php
									$workers_sum_profit = 0;
									$workers_sum_cost = 0;
									$workers_sum_salary = 0;
									$workers_profit_each = [];
									$profit_difference_each = [];

									for($ii = 0; $ii < $count_workers; $ii++) {
										$workers_sum_profit += $workers[$ii]['sum_profit'];
										$workers_sum_cost += $workers[$ii]['sum_products_cost'];
										$workers_sum_salary += $workers[$ii]['sum_salaries'];

										$workers_profit_each[] = $workers[$ii]['sum_profit'];
										$profit_difference_each[] = $workers[$ii]['sum_profit'] - $workers[$ii]['sum_products_cost'];

										$workers[$ii]['clean_revenue'] = $workers[$ii]['sum_profit'] - $workers[$ii]['sum_products_cost']; ?>
										<td <?php if($workers[$ii]['last_worker_of_category']) echo 'class="last_worker_of_category"'; ?>>
											Revenue: <?= number_format($workers[$ii]['sum_profit'], 2, '.', ' ') ?><br>
											Products cost: <?= number_format($workers[$ii]['sum_products_cost'], 2, '.', ' ') ?>
											<br>
											Зарплата: <?= number_format($workers[$ii]['sum_salaries'], 2, '.', ' ') ?>
										</td> <?php

									} ?>
								</tr>
							</tbody>
						</table>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
						<canvas id="all_time_chart" width="1000" height="300"></canvas>
						<canvas id="all_time_chart2" width="1000" height="300"></canvas>
						<script>
							$( '#sum_sqr' ).append( '<br>Revenue: <?=number_format($workers_sum_profit,2,'.',' ')?><br>Products cost:  <?=number_format($workers_sum_cost,2,'.',' ')?><br>Salary:  <?=number_format($workers_sum_salary,2,'.',' ')?>' );

							let years = [<?=helper::jsfy_array($years)?>];

							$( 'th' ).click( function() {
								let el = $( this );

								if( el.parent().parent().is( 'thead' ) ){//clicked on worker
									let worker_name = el.text().trim();
									let worker_order = el.index() + 1;//2-i
									let worker_profit_cells = $( 'tbody tr:not(:last-child()) td:nth-child(' + worker_order + ')' );
									let profit_data = [];
									let i = 0;
									let clean_profit_data = [];
									let buf;

									worker_profit_cells.each( function( key, cell ) {
										profit_data[i] = $( cell ).html();

										buf = profit_data[i].split( '<br>' );

										profit_data[i] = buf[0].trim();
										profit_data[i] = profit_data[i].substr( 9 );
										profit_data[i] = profit_data[i].replace(/\s/g,'');
										profit_data[i] = parseFloat( profit_data[i] );
										if( isNaN( profit_data[i] ) )
											profit_data[i] = 0;

										if( buf.length > 1 ){
											clean_profit_data[i] = buf[1].trim();
											clean_profit_data[i] = clean_profit_data[i].substr( 8 );
											clean_profit_data[i] = clean_profit_data[i].replace(/\s/g,'');
											clean_profit_data[i] = profit_data[i] - parseFloat( clean_profit_data[i] );
											if( isNaN( clean_profit_data[i] ) )
												clean_profit_data[i] = 0;
										}
										else
											clean_profit_data[i] = 0;

										i++;
									} );

									chart_data.labels = years;
									chart2_data.labels = years;

									chart_data.datasets = [{
										label : worker_name,
										data : profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];
									chart2_data.datasets = [{
										label : worker_name,
										data : clean_profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];

									window.chart.update();
									window.chart2.update();

								}
								elseif( el.parent().parent().is( 'tbody' ) && el.parent().is( ':not(:nth-last-child(2))' ) ){//clicked on year
									let year = el.text().trim();
									let year_number = el.parent().index() + 1;//1-12 + 14
									let profit_cells = el.parent().find( 'td:not(:first-child),th:not(:first-child)' );
									let profit_data = [];
									let i = 0;
									let workers = $( 'thead tr th:not(:first-child)' );
									let workers_names = [];
									let clean_profit_data = [];
									let buf;

									if( el.parent().is( ':last-child' ) )
										year = 'All years';

									workers.each( function( key, cell ) {
										workers_names.push( $( cell ).text().trim() );
									} );

									profit_cells.each( function( key, cell ) {
										profit_data[i] = $( cell ).html();

										buf = profit_data[i].split( '<br>' );

										profit_data[i] = buf[0].trim();
										profit_data[i] = profit_data[i].substr( 9 );
										profit_data[i] = profit_data[i].replace(/\s/g,'');
										profit_data[i] = parseFloat( profit_data[i] );
										if( isNaN( profit_data[i] ) )
											profit_data[i] = 0;

										if( buf.length > 1 ){
											clean_profit_data[i] = buf[1].trim();
											clean_profit_data[i] = clean_profit_data[i].substr( 8 );
											clean_profit_data[i] = clean_profit_data[i].replace(' ','');
											clean_profit_data[i] = profit_data[i] - parseFloat( clean_profit_data[i] );
											if( isNaN( clean_profit_data[i] ) )
												clean_profit_data[i] = 0;
										}
										else
											clean_profit_data[i] = 0;

										i++;
									} );

									chart_data.labels = workers_names;
									chart2_data.labels = workers_names;

									chart_data.datasets = [{
										label : year + ' (Revenue)',
										data : profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];
									chart2_data.datasets = [{
										label : year + ' (Profit)',
										data : clean_profit_data,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
									}];

									window.chart.update();
									window.chart2.update();
								}
							} );

							let ctx = document.getElementById( 'all_time_chart' ).getContext( '2d' );
							let ctx2 = document.getElementById( 'all_time_chart2' ).getContext( '2d' );
							let chart_data = {
								labels : [<?=helper::jsfy_array($workers, 'name')?>],
								datasets : [{
									label : 'Revenue',
									data : [<?=helper::jsfy_array($workers_profit_each)?>],
									backgroundColor : backgroundColor,
									borderColor : borderColor,
									borderWidth : 1,
								}],
							};
							let chart2_data = {
								labels : [<?=helper::jsfy_array($workers, 'name')?>],
								datasets : [{
									label : 'Profit',
									data : [<?=helper::jsfy_array($profit_difference_each)?>],
									backgroundColor : backgroundColor,
									borderColor : borderColor,
									borderWidth : 1,
								}],
							};
							window.chart = new Chart( ctx, {
								type : 'bar',
								data : chart_data,
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
							window.chart2 = new Chart( ctx2, {
								type : 'bar',
								data : chart2_data,
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
						</script> <?php

					} ?>
				</div>
			</div> <?php

		}

		private static function show_shop() {

			global $sql;

			if(!array_key_exists('m', $_GET))
				$_GET['m'] = '7'; ?>

			<div class="row mt-4"> <?php


				if(!array_key_exists('date', $_GET) || !is_numeric($_GET['date']) || !$_GET['date'] > 0)
					$_GET['date'] = (int)($_SERVER['REQUEST_TIME'] / 86400);

				$unix_day = $_GET['date'];
				$unix_date = $unix_day * 86400;
				$unix_day_today = (int)(time() / 86400);

				$active_menus = [];
				if($_GET['m'] == '7')
					$active_menus['7'] = true;
				elseif($_GET['m'] == '30')
					$active_menus['30'] = true;
				elseif($_GET['m'] == '365')
					$active_menus['365'] = true;
				elseif($_GET['m'] == 'all')
					$active_menus['all'] = true;

				$next_unix_day = 0;
				$prev_unix_day = 0;
				if($active_menus['7']) {
					$days_shown = 7;
					$next_unix_day = $unix_day + 7;
					$prev_unix_day = $unix_day - 7;
				}
				elseif($active_menus['30']) {
					$days_shown = date('t', $unix_date);
					$current_day_of_month = (int)date('d', $unix_date);

					$next_unix_day = (int)(strtotime('+1 month', $unix_date) / 86400);
					$prev_unix_day = (int)(strtotime('-1 month', $unix_date) / 86400);
				}
				elseif($active_menus['365']) {
					$days_shown = 365 + date('L', $unix_date);

					$next_unix_day = (int)(strtotime('+1 year', $unix_date) / 86400);
					$prev_unix_day = (int)(strtotime('-1 year', $unix_date) / 86400);
				}
				else
					$days_shown = false;


				if($_GET['m'] == 7) {
					$unix_day += (7 - date('N', $unix_date));
					$unix_date = $unix_day * 86400;
				}


				$shop_category_id = $sql->c('SELECT `id` FROM `categories` WHERE `name` LIKE \'%Socksy%\'');//12


				$t_shop_sellers = $sql->res2data($sql->a('SELECT `id`,`name`,`active` FROM `workers` WHERE `id_category` = ?', $shop_category_id));
				$all_shop_sellers = [];
				$active_shop_sellers = [];

				$labels = [];
				$data_chart_1 = [];
				$data_chart_2 = [];

				foreach($t_shop_sellers as $data)
					$all_shop_sellers[$data['id']] = $data['name'];
				foreach($t_shop_sellers as $data)
					if($data['active'])
						$active_shop_sellers[$data['id']] = $data['name'];

				if($_GET['m'] != 30) { ?>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script> <?php
				} ?>

				<script>
					let backgroundColor = [<?=helper::$js_chart_main_colors?>];
					let borderColor = [<?=helper::$js_chart_border_colors?>];
				</script>

				<div class="col-sm-12 col-md-4 col-lg-2">

					<div id="horizontal_menu" class="mb-4">
						<p>View:</p>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=7&date=<?= $_GET['date'] ?>" class="menu_items <?= $active_menus['7'] ? "active" : "" ?>">7</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=30&date=<?= $_GET['date'] ?>" class="menu_items <?= $active_menus['30'] ? "active" : "" ?>">30</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=365&date=<?= $_GET['date'] ?>" class="menu_items <?= $active_menus['365'] ? "active" : "" ?>">365</a>
						<a href="<?= content::$link ?>?d=<?= $_GET['d'] ?>&m=all&date=<?= $_GET['date'] ?>" class="menu_items <?= $active_menus['all'] ? "active" : "" ?>">*</a>
					</div> <?php

					if($days_shown) { ?>
						<div>
						<p>Date</p>
						<a href="?d=<?= $_GET['d'] ?>&m=<?= $_GET['m'] ?>&date=<?= $prev_unix_day ?>" class="btn btn-info float-left">&lt;&lt;</a>
						<a href="?d=<?= $_GET['d'] ?>&m=<?= $_GET['m'] ?>&date=<?= $next_unix_day ?>" class="btn btn-info float-right">&gt;&gt;</a>
						</div><?php
					} ?>

					<div class="pt-4 mb-2" style="clear:both">
						<button id="save_changes" class="btn btn-success">Save changes</button>
						<span class="btn btn-info" id="saved_alert" style="display:none!important">Saved!</span>
					</div>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-10">

					<table class="table shop_table table-striped table-bordered">
						<thead>

							<tr> <?php
								if($_GET['m'] != 30) { ?>
									<th>Day</th> <?php
								} ?>
								<th>Employees</th>
								<th>Cash</th>
								<th>Credit card</th>
								<th>Sum</th>
								<th>Withdrawn</th>
								<th>Products cost</th>
							</tr>

						</thead>
						<tbody> <?php

							if($_GET['m'] == 7) {


								$days_to_show = 7;

								$week_amount_sum = 0;
								$week_terminal_sum = 0;
								$week_sum_sum = 0;
								$week_out_sum = 0;
								$week_products_cost_sum = 0;

								$graph_revenue = [];
								$graph_difference = [];

								$data = $sql->res2data($sql->a('SELECT `id`,`worker_ids`,`amount`,`terminal`,`out`,`date`,`products_cost` FROM `shop` WHERE (`date`+' . $days_to_show . ') > ? AND `date` < ? ORDER BY `date` ASC', $unix_day, $unix_day));

								for($i = $days_to_show - 1; $i >= 0; $i--)
									if(!array_key_exists($days_to_show - 1 - $i, $data) || $data[$days_to_show - 1 - $i]['date'] != $unix_day - $i)
										array_splice($data, $days_to_show - 1 - $i, 0, [['id' => -1, 'worker_ids' => '', 'amount' => 0, 'terminal' => 0, 'out' => 0, 'date' => $unix_day - $i, 'products_cost' => 0]]);

								$sql->a('DELETE FROM `shop` WHERE `worker_ids` = \'\' AND `amount` = 0.00 AND `terminal` = 0.00 AND `out` = 0.00 AND `products_cost` = 0.00');
								$sql->a('UPDATE `w_shop` SET `worker_ids` = REPLACE(TRIM(\',\' FROM `worker_ids`),\',,\',\',\')');

							foreach($data as $row) {


								$unix_time = $row['date'] * 86400;
								$day_name = helper::week_to_lang(date('w', $unix_time)) . ', ' . date('d', $unix_time) . ' ' . helper::month_to_lang(date('n', $unix_time) - 1) . ' ' . date('Y', $unix_time);

								if($row['date'] == $unix_day_today)
									$tr_class = 'class="table-success"';
								elseif(date('w', $unix_time) == '0')
									$tr_class = 'class="bg-light" style="color: #ccc;"';
								elseif($row['id'] == -1 && $unix_day_today > $row['date'])
									$tr_class = 'class="table-warning"';
								else
									$tr_class = '';


								$sellers = explode(',', $row['worker_ids']);
								$sellers_names = '';
								foreach($sellers as $seller_id)
									$sellers_names .= $all_shop_sellers[$seller_id] . ', ';

								if($sellers_names !== '')
									$sellers_names = substr($sellers_names, 0, -2);


								if($row['amount'] == 0)
									$amount = '';
								else
									$amount = number_format($row['amount'], 2, '.', false);
								$week_amount_sum += $row['amount'];

								if($row['terminal'] == 0)
									$terminal = '';
								else
									$terminal = number_format($row['terminal'], 2, '.', false);
								$week_terminal_sum += $row['terminal'];

								if($row['amount'] + $row['terminal'] == 0)
									$sum = '';
								else
									$sum = number_format($row['amount'] + $row['terminal'], 2, '.', false);
								$week_sum_sum += $row['amount'] + $row['terminal'];

								if($row['out'] == 0)
									$out = '';
								else
									$out = number_format($row['out'], 2, '.', false);
								$week_out_sum += $row['out'];

								if($row['products_cost'] == 0)
									$products_cost = '';
								else
									$products_cost = number_format($row['products_cost'], 2, '.', false);
								$week_products_cost_sum += $row['products_cost'];

								$graph_revenue[] = $row['amount'] + $row['terminal'];
								$graph_difference[] = $row['amount'] + $row['terminal'] - $row['products_cost']; ?>

								<tr <?= $tr_class ?> data-modified="0" data-id="<?= $row['id'] ?>" data-unix_day="<?= $row['date'] ?>">
									<th class="table-active"><?= $day_name ?></th>
									<td class="sellers_names">
										<label><input type="text" class="border-0 tags" value="<?= $sellers_names ?>"></label>
									</td>
									<td class="amount">
										<label><input type="text" class="border-0" value="<?= $amount ?>"></label>
									</td>
									<td class="terminal">
										<label><input type="text" class="border-0" value="<?= $terminal ?>"></label>
									</td>
									<td class="sum">
										<label><input type="text" class="border-0" value="<?= $sum ?>" disabled></label>
									</td>
									<td class="out">
										<label><input type="text" class="border-0" value="<?= $out ?>"></label>
									</td>
									<td class="products_cost">
										<label><input type="text" class="border-0" value="<?= $products_cost ?>"></label>
									</td>
								</tr> <?php

							} ?>

								<tr>
									<th>Сума</th>
									<th></th>
									<th><?= number_format($week_amount_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_terminal_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_sum_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_out_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_products_cost_sum, 2, '.', ' ') ?></th>
								</tr> <?php


							$labels = json_encode(helper::$day_names);
							$data_chart_1 = json_encode($graph_revenue);
							$data_chart_2 = json_encode($graph_difference); ?>


								<script>
									<?php echo <<<'EOD'
	!function(t){t.fn.tagsly=function(e){var i,a=[13,188],n=[8];e&&e.suggestions&&(i=e.suggestions);var s,o,l=e&&e.suggestOnFocus;e&&e.maxItems&&(s=e.maxItems),e&&e.maxItemSize&&(o=e.maxItemSize);var r="";e&&e.placeholder&&(r=e.placeholder);var c=t("<div/>",{class:"tagsly"}),f=t("<input/>",{type:"text",class:"tag-textbox"});f.prop("placeholder",r),o&&f.prop("maxlength",o);var v=t("<ul/>",{class:"suggest"}),p=this,h=0;function u(){var e=f.val();if(""!=e&&!(s&&h>=s)){var i=t("<span/>",{class:"tag",text:e,tabindex:"-1"}),a=t("<a/>",{text:"x",href:"#",tabindex:"-1"});a.click(function(){d(i)}),i.append(a),f.before(i),f.val(""),p.val(function(t,i){return i+(i?",":"")+e}),v.hide(),v.offset({left:f.position().left}),h++,s&&h>=s&&(f.prop("disabled",!0),f.prop("placeholder",""))}}function d(t){t.find("a").remove();var e=t.text();t.remove(),f.focus();var i=p.val().split(",");(i=i.map(function(t){return t.trim()})).splice(i.indexOf(e),1),p.val(i.join(",")),v.hide(),v.offset({left:f.position().left}),h--,s&&h<s&&(f.prop("disabled",!1),f.prop("placeholder",r))}f.focus(function(t){l&&g()}),f.focusout(function(t){u(),v.hide()}),f.keydown(function(t){return-1!=a.indexOf(t.which)?(u(),!1):-1!=n.indexOf(t.which)&&""==f.val()?(d(f.prev()),!1):38==t.which?((e=v.find("li.active")).length>0?(i=e.prev(),e.removeClass("active")):i=v.children().last(),i.addClass("active"),f.val(i.text()),!1):40==t.which?((e=v.find("li.active")).length>0?(i=e.next(),e.removeClass("active")):i=v.children().first(),i.addClass("active"),f.val(i.text()),!1):void(27==t.which&&v.hide());var e,i}),f.on("input",g);var x=0;function g(){if(i){var e=new Date;i(f.val(),function(i){x<e&&(!function(e){v.show(),v.empty();for(var i=0;i<e.length;i++){var a=t("<li/>",{text:e[i]});a.mousedown(function(e){f.val(t(this).text()),u(),setTimeout(function(){f.focus()},0)}),v.append(a)}}(i),x=e)})}}this.wrap(c),this.parent().append(f),this.parent().append(v),this.parent().click(function(){f.focus()}),this.hide();var m=this.val();if(m.length>0){this.val(""),m=m.split(",");for(var w=0;w<m.length;w++)f.val(m[w]),u()}return this}}(jQuery);
EOD;
									?>

									$( function() {

										let tbody = $( 'tbody' );
										let tr = tbody.find( '> tr' );
										let sellers_numeric = JSON.parse( '<?=json_encode(array_values($active_shop_sellers))?>' );
										let sellers = JSON.parse( '<?=json_encode(array_flip($active_shop_sellers))?>' );
										let saved_alert = $( '#saved_alert' );

										$.each( $( '.tags' ), function( k, el ) {
											$( el ).tagsly( {
												suggestions : function( input, cb ) {
													cb( sellers_numeric );
												},
												placeholder : '',
												maxItems : 10,
												suggestOnFocus : true,
											} );
										} );

										$( '#save_changes' ).click( function() {

											let data_to_send = [];

											$.each( tr, function( k, el ) {

												el = $( el );

												if( el.attr( 'data-modified' ) === '0' )
													return true;

												let seller_ids = [];
												let seller_names = [];

												$.each( el.find( '.tag' ), function( k, el ) {
													let t_name = $( el ).text();
													t_name = t_name.substring( 0, t_name.length - 1 );
													seller_names.push( t_name );
												} );

												seller_names = [...new Set( seller_names )];

												$.each( seller_names, function( k, el ) {
													seller_ids.push( sellers[el] );
												} );


												data_to_send.push( [el.attr( 'data-id' ), el.attr( 'data-unix_day' ), seller_ids.join(), el.find( '.amount input' ).val(), el.find( '.terminal input' ).val(), el.find( '.out input' ).val(), el.find( '.products_cost input' ).val()] );

											} );

											$.ajax( {
												method : 'POST',
												url : '<?=content::$link . '?mode=shop_data_send'?>',
												data : { 'data' : JSON.stringify( data_to_send ) },
												dataType : 'json',
											} ).done( function( json_data ) {

												$.each( json_data, function( data, id ) {
													let el = tbody.find( '> tr[data-unix_day="' + data + '"]' );
													if( typeof el !== 'undefined' )
														$( el ).attr( 'data-id', id );
												} );

												$.each( tr, function( k, el ) {
													$( el ).attr( 'data-modified', 0 );
												} );

												saved_alert.show();
												setTimeout( function() {
													saved_alert.hide();
												}, 1000 );
											} )
											.fail( function( xhr, ajaxOptions, thrownError ) {
												alert( 'Error saving changes!<br>' + xhr + ajaxOptions + thrownError );
												console.log( xhr );
												console.log( ajaxOptions );
												console.log( thrownError );
											} );

										} );

										tr.click( function() {
											$( this ).attr( 'data-modified', '1' ).removeClass( 'table-warning' );
										} );

										$( '.amount input, .terminal input, .out input, .products_cost input' ).focusout( function() {

											let el = $( this );
											let val = el.val();
											let new_val;

											if( /[+*\-/]/.exec( val ) == null )
												return true;

											new_val = eval( val );

											if( typeof new_val == 'undefined' )
												return true;

											el.val( parseFloat( new_val ).toFixed( 2 ) );
											calculate_sum( el );

										} );


										$( '.amount input, .terminal input' ).on( 'input', function() {
											calculate_sum( $( this ) );
										} );

										function calculate_sum( input ) {
											let td = input.parent().parent();
											let tr = td.parent();
											let val = input.val();

											let amount = 0;
											let terminal = 0;

											if( td.hasClass( 'amount' ) ){
												amount = val;
												terminal = tr.find( '.terminal input' ).val();
											}
											else {
												amount = tr.find( '.amount input' ).val();
												terminal = val;
											}

											if( amount === '' )
												amount = 0;
											if( terminal === '' )
												terminal = 0;

											let sum = parseFloat( parseFloat( amount ) + parseFloat( terminal ) ).toFixed( 2 );
											tr.find( '.sum input' ).val( sum );


										}


									} );


								</script> <?php

							}


							elseif($_GET['m'] == 30){

							$month_name = helper::month_to_lang(date('n', $unix_date) - 1, false) . ' ' . date('Y', $unix_date);
							$last_day_of_month = $days_shown - date('d', $unix_date) + $unix_day; ?>

								<h1><?= $month_name ?></h1> <?php

								$row = $sql->r('SELECT GROUP_CONCAT(worker_ids SEPARATOR \',\') AS `worker_ids`,SUM(amount) AS `amount`,SUM(terminal) AS `terminal`,SUM(`out`) AS `out`,SUM(products_cost) as `products_cost` FROM shop WHERE (`date`+' . $days_shown . ') > ? AND `date` < ?', $last_day_of_month, $last_day_of_month);
								//var_dump($days_shown, $last_day_of_month);

								if(!is_array($row))
									$row = ['worker_ids' => '', 'amount' => 0, 'terminal' => 0, 'out' => 0, 'products_cost' => 0];

								$row['date'] = $unix_day;

								if(date('m.Y', $row['date'] * 86400) === date('m.Y'))
									$tr_class = 'class="table-success"';
								else
									$tr_class = '';


								$sellers = trim($row['worker_ids'], ',');
								$sellers = preg_replace(['/,,/', '/,,/'], [',', ','], $sellers);
								$sellers = explode(',', $sellers);
								$sellers = array_unique($sellers);

								$sellers_names = '';
								foreach($sellers as $seller_id)
									$sellers_names .= $all_shop_sellers[$seller_id] . ', ';

								if($sellers_names !== '')
									$sellers_names = substr($sellers_names, 0, -2);


								$amount = number_format($row['amount'], 2, '.', ' ');
								$terminal = number_format($row['terminal'], 2, '.', ' ');
								$sum = number_format($row['amount'] + $row['terminal'], 2, '.', ' ');
								$out = number_format($row['out'], 2, '.', ' ');
								$products_cost = number_format($row['products_cost'], 2, '.', ' '); ?>

								<tr <?= $tr_class ?>>
									<td><?= $sellers_names ?></td>
									<td><?= $amount ?></td>
									<td><?= $terminal ?></td>
									<td><?= $sum ?></td>
									<td><?= $out ?></td>
									<td><?= $products_cost ?></td>
								</tr> <?php

							}


							elseif($_GET['m'] == 365) {

								$year = date('Y', $unix_date);

								$week_amount_sum = 0;
								$week_terminal_sum = 0;
								$week_sum_sum = 0;
								$week_out_sum = 0;
								$week_products_cost_sum = 0;

								$graph_revenue = [];
								$graph_difference = []; ?>

								<h1><?= $year ?></h1> <?php

								$data = $sql->res2data($sql->a('SELECT GROUP_CONCAT(`worker_ids` SEPARATOR \',\') AS `worker_ids`,SUM(`amount`) AS `amount`,SUM(`terminal`) AS `terminal`,SUM(`out`) AS `out`,SUM(`products_cost`) AS `products_cost`,MONTH(FROM_UNIXTIME(`date`*86400))-1 AS `month` FROM `shop` WHERE YEAR(FROM_UNIXTIME(`date`*86400)) = ? GROUP BY MONTH(FROM_UNIXTIME(`date`*86400))', $year));

							for($i = 0;
							    $i < 12;
							    $i++) {

								if($data[$i]['month'] != $i)
									array_splice($data, $i, 0, [['worker_ids' => '', 'amount' => 0, 'terminal' => 0, 'out' => 0, 'products_cost' => 0, 'month' => $i]]);

								if($data[$i]['month'] == date('m') - 1)
									$tr_class = 'class="table-success"';
								else
									$tr_class = '';


								$sellers = trim($data[$i]['worker_ids'], ',');
								$sellers = preg_replace(['/,,/', '/,,/'], [',', ','], $sellers);
								$sellers = explode(',', $sellers);
								$sellers = array_unique($sellers);

								$sellers_names = '';
								foreach($sellers as $seller_id)
									$sellers_names .= $all_shop_sellers[$seller_id] . ', ';

								if($sellers_names !== '')
									$sellers_names = substr($sellers_names, 0, -2);


								$month_name = helper::month_to_lang($data[$i]['month'], false);
								$amount = number_format($data[$i]['amount'], 2, '.', ' ');
								$terminal = number_format($data[$i]['terminal'], 2, '.', ' ');
								$sum = number_format($data[$i]['amount'] + $data[$i]['terminal'], 2, '.', ' ');
								$out = number_format($data[$i]['out'], 2, '.', ' ');
								$products_cost = number_format($data[$i]['products_cost'], 2, '.', ' ');

								$week_amount_sum += $data[$i]['amount'];
								$week_terminal_sum += $data[$i]['terminal'];
								$week_sum_sum += $data[$i]['amount'] + $data[$i]['terminal'];
								$week_out_sum += $data[$i]['out'];
								$week_products_cost_sum += $data[$i]['product_cost'];

								$graph_revenue[] = $data[$i]['amount'] + $data[$i]['terminal'];
								$graph_difference[] = $data[$i]['amount'] + $data[$i]['terminal'] - $data[$i]['products_cost']; ?>

								<tr <?= $tr_class ?>>
									<th class="table-active"><?= $month_name ?></th>
									<td><?= $sellers_names ?></td>
									<td><?= $amount ?></td>
									<td><?= $terminal ?></td>
									<td><?= $sum ?></td>
									<td><?= $out ?></td>
									<td><?= $products_cost ?></td>
								</tr> <?php

							}




								$labels = json_encode(helper::$month_names);
								$data_chart_1 = json_encode($graph_revenue);
								$data_chart_2 = json_encode($graph_difference); ?>


								<tr>
									<th>Sum</th>
									<th></th>
									<th><?= number_format($week_amount_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_terminal_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_sum_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_out_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_products_cost_sum, 2, '.', ' ') ?></th>
								</tr> <?php


							}


							elseif($_GET['m'] == 'all') {

								$year = date('Y', $unix_date);
								$years_list = [];

								$week_amount_sum = 0;
								$week_terminal_sum = 0;
								$week_sum_sum = 0;
								$week_out_sum = 0;
								$week_products_cost_sum = 0;

								$graph_revenue = [];
								$graph_difference = []; ?>

								<h1>All years</h1> <?php


								$data = $sql->res2data($sql->a('SELECT GROUP_CONCAT(`worker_ids` SEPARATOR \',\') AS `worker_ids`,SUM(`amount`) AS `amount`,SUM(`terminal`) AS `terminal`,SUM(`out`) AS `out`,SUM(`products_cost`) AS `products_cost`,YEAR(FROM_UNIXTIME(`date`*86400)) AS `year` FROM `shop` GROUP BY YEAR(FROM_UNIXTIME(`date`*86400)) ORDER BY `date` ASC'));

								if(count($data) > 0)
									$first_year = $data[0]['year'];
								else
									$first_year = 0;

							for($i = 0;
							    $i < count($data);
							    $i++) {
								if($data[$i]['year'] != $first_year + $i)
									array_splice($data, $i, 0, [['worker_ids' => '', 'amount' => 0, 'terminal' => 0, 'out' => 0, 'products_cost' => 0, 'year' => $first_year + $i]]);

								if($data[$i]['year'] == $year)
									$tr_class = 'class="table-success"';
								else
									$tr_class = '';

								$sellers = trim($data[$i]['worker_ids'], ',');
								$sellers = preg_replace(['/,,/', '/,,/'], [',', ','], $sellers);
								$sellers = explode(',', $sellers);
								$sellers = array_unique($sellers);

								$sellers_names = '';
								foreach($sellers as $seller_id)
									$sellers_names .= $all_shop_sellers[$seller_id] . ', ';

								if($sellers_names !== '')
									$sellers_names = substr($sellers_names, 0, -2);

								$year_name = $data[$i]['year'];
								$amount = number_format($data[$i]['amount'], 2, '.', ' ');
								$terminal = number_format($data[$i]['terminal'], 2, '.', ' ');
								$sum = number_format($data[$i]['amount'] + $data[$i]['terminal'], 2, '.', ' ');
								$out = number_format($data[$i]['out'], 2, '.', ' ');
								$products_cost = number_format($data[$i]['products_cost'], 2, '.', ' ');

								$week_amount_sum += $data[$i]['amount'];
								$week_terminal_sum += $data[$i]['terminal'];
								$week_sum_sum += $data[$i]['amount'] + $data[$i]['terminal'];
								$week_out_sum += $data[$i]['out'];
								$week_products_cost_sum += $data[$i]['product_cost'];

								$years_list[] = $year_name;
								$graph_revenue[] = $data[$i]['amount'] + $data[$i]['terminal'];
								$graph_difference[] = $data[$i]['amount'] + $data[$i]['terminal'] - $data[$i]['products_cost']; ?>

								<tr <?= $tr_class ?>>
									<th class="table-active"><?= $year_name ?></th>
									<td><?= $sellers_names ?></td>
									<td><?= $amount ?></td>
									<td><?= $terminal ?></td>
									<td><?= $sum ?></td>
									<td><?= $out ?></td>
									<td><?= $products_cost ?></td>
								</tr> <?php
							}


								$labels = json_encode($years_list);
								$data_chart_1 = json_encode($graph_revenue);
								$data_chart_2 = json_encode($graph_difference); ?>


								<tr>
									<th>Sum</th>
									<th></th>
									<th><?= number_format($week_amount_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_terminal_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_sum_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_out_sum, 2, '.', ' ') ?></th>
									<th><?= number_format($week_products_cost_sum, 2, '.', ' ') ?></th>
								</tr> <?php


							} ?>

						</tbody>
					</table> <?php

					if($_GET['m'] != 30) { ?>
						<canvas id="chart" width="1000" height="300" class="mt-4 mb-4"></canvas>
						<canvas id="chart2" width="1000" height="300" class="mb-4"></canvas>
						<script>


							let ctx = document.getElementById( 'chart' ).getContext( '2d' );
							let myChart = new Chart( ctx, {
								type : 'bar',
								data : {
									labels : <?=$labels?>,
									datasets : [{
										label : 'Revenue',
										data : <?=$data_chart_1?>,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
										borderWidth : 1,
									}],
								},
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );
							let ctx2 = document.getElementById( 'chart2' ).getContext( '2d' );
							let myChart2 = new Chart( ctx2, {
								type : 'bar',
								data : {
									labels : <?=$labels?>,
									datasets : [{
										label : 'Profit',
										data : <?=$data_chart_2?>,
										backgroundColor : backgroundColor,
										borderColor : borderColor,
										borderWidth : 1,
									}],
								},
								options : {
									scales : {
										yAxes : [{
											ticks : {
												beginAtZero : true,
											},
										}],
									},
								},
							} );</script><?php
					}
					?>


				</div>
			</div> <?php
		}


		//private

		public static function logout() {

			unset($_SESSION['hash']);
			unset($_SESSION['mode']);
			session_destroy();
			header("Location: " . self::$link);
		}

		public static function login() { ?>
			<div class="container">
				<div class="row">
					<div class="col">

						<form method="post" class="form-horizontal">
							<input type="password" placeholder="Пароль" name="password" class="form-control mt-4 mb-4">
							<input type="submit" class="btn btn-outline-dark" name="submit" value="Вхід">
							<a href="?mode=shop_input">Магазин</a>
						</form>

					</div>
				</div>
			</div> <?php

		}

		public static function shop_input() {

			global $sql;

			$_SESSION['mode'] = "shop_input";

			$shop_category_id = $sql->c('SELECT `id` FROM `categories` WHERE `name` LIKE \'%Socksy%\'');//12


			$t_shop_sellers = $sql->res2data($sql->a('SELECT `id`,`name` FROM `workers` WHERE `id_category` = ? AND `active` = 1', $shop_category_id));
			$shop_sellers = [];

			foreach($t_shop_sellers as $data)
				$shop_sellers[$data['id']] = $data['name'];


			$days_to_show = 7;

			$unix_now = time();
			$days_since_unix = (int)($unix_now / 86400);
			$original_days_since_unix = $days_since_unix;
			$days_since_unix += (7 - date('N', $unix_now));
			$unix_now = $days_since_unix * 86400;
			$data = $sql->res2data($sql->a('SELECT `id`,`worker_ids`,`amount`,`terminal`,`out`,`date` FROM `shop` WHERE (`date`+' . $days_to_show . ') > ? ORDER BY `date` ASC', $days_since_unix));

			for($i = $days_to_show - 1; $i >= 0; $i--)
				if(!array_key_exists($days_to_show - 1 - $i, $data) || $data[$days_to_show - 1 - $i]['date'] != $days_since_unix - $i)
					array_splice($data, $days_to_show - 1 - $i, 0, [['id' => -1, 'worker_ids' => 0, 'amount' => 0, 'terminal' => 0, 'out' => 0, 'date' => $days_since_unix - $i]]); ?>


			<div class="container-fluid">
				<div class="row">
					<div class="col">

						<div class="mt-2 mb-2">
							<a class="btn btn-danger" href="<?= self::$link ?>?d=logout">Log out</a>
							<button id="save_changes" class="btn btn-success">Save changes</button>
							<span class="btn btn-info" id="saved_alert" style="display:none!important">Saved!</span>
						</div>


						<table class="table shop_table table-striped table-bordered">
							<thead>

								<tr>
									<th>Day</th>
									<th>Sellers</th>
									<th>Cash</th>
									<th>Credit card</th>
									<th>Sum</th>
									<th>Withdrawn</th>
								</tr>

							</thead>
							<tbody> <?php

								foreach($data as $row) {


									$unix_time = $row['date'] * 86400;
									$day_name = helper::week_to_lang(date('w', $unix_time)) . ', ' . date('d', $unix_time) . ' ' . helper::month_to_lang(date('n', $unix_time) - 1) . ' ' . date('Y', $unix_time);

									if($row['date'] == $original_days_since_unix)
										$tr_class = 'class="table-success"';
									elseif(date('w', $unix_time) == '0')
										$tr_class = 'class="bg-light" style="color: #ccc;"';
									elseif($row['id'] == -1 && $original_days_since_unix > $row['date'])
										$tr_class = 'class="table-warning"';
									else
										$tr_class = '';


									$sellers = explode(',', $row['worker_ids']);
									$sellers_names = '';
									foreach($sellers as $seller_id)
										$sellers_names .= $shop_sellers[$seller_id] . ', ';

									if($sellers_names !== '')
										$sellers_names = substr($sellers_names, 0, -2);


									if($row['amount'] == 0)
										$amount = '';
									else
										$amount = number_format($row['amount'], 2, '.', false);
									if($row['terminal'] == 0)
										$terminal = '';
									else
										$terminal = number_format($row['terminal'], 2, '.', false);
									if($row['amount'] + $row['terminal'] == 0)
										$sum = '';
									else
										$sum = number_format($row['amount'] + $row['terminal'], 2, '.', false);
									if($row['out'] == 0)
										$out = '';
									else
										$out = number_format($row['out'], 2, '.', false);
									if($row['products_cost'] == 0)
										$products_cost = '';
									else
										$products_cost = number_format($row['products_cost'], 2, '.', false); ?>

									<tr <?= $tr_class ?> data-modified="0" data-id="<?= $row['id'] ?>" data-unix_day="<?= $row['date'] ?>">
										<th><?= $day_name ?></th>
										<td class="sellers_names">
											<label><input type="text" class="border-0 tags" value="<?= $sellers_names ?>"></label>
										</td>
										<td class="amount">
											<label><input type="text" class="border-0" value="<?= $amount ?>"></label>
										</td>
										<td class="terminal">
											<label><input type="text" class="border-0" value="<?= $terminal ?>"></label>
										</td>
										<td class="sum">
											<label><input type="text" class="border-0" value="<?= $sum ?>" disabled></label>
										</td>
										<td class="out">
											<label><input type="text" class="border-0" value="<?= $out ?>"></label>
										</td>
									</tr> <?php

								} ?>

							</tbody>
						</table>

						<script>
							<?php echo <<<'EOD'
!function(t){t.fn.tagsly=function(e){var i,a=[13,188],n=[8];e&&e.suggestions&&(i=e.suggestions);var s,o,l=e&&e.suggestOnFocus;e&&e.maxItems&&(s=e.maxItems),e&&e.maxItemSize&&(o=e.maxItemSize);var r="";e&&e.placeholder&&(r=e.placeholder);var c=t("<div/>",{class:"tagsly"}),f=t("<input/>",{type:"text",class:"tag-textbox"});f.prop("placeholder",r),o&&f.prop("maxlength",o);var v=t("<ul/>",{class:"suggest"}),p=this,h=0;function u(){var e=f.val();if(""!=e&&!(s&&h>=s)){var i=t("<span/>",{class:"tag",text:e,tabindex:"-1"}),a=t("<a/>",{text:"x",href:"#",tabindex:"-1"});a.click(function(){d(i)}),i.append(a),f.before(i),f.val(""),p.val(function(t,i){return i+(i?",":"")+e}),v.hide(),v.offset({left:f.position().left}),h++,s&&h>=s&&(f.prop("disabled",!0),f.prop("placeholder",""))}}function d(t){t.find("a").remove();var e=t.text();t.remove(),f.focus();var i=p.val().split(",");(i=i.map(function(t){return t.trim()})).splice(i.indexOf(e),1),p.val(i.join(",")),v.hide(),v.offset({left:f.position().left}),h--,s&&h<s&&(f.prop("disabled",!1),f.prop("placeholder",r))}f.focus(function(t){l&&g()}),f.focusout(function(t){u(),v.hide()}),f.keydown(function(t){return-1!=a.indexOf(t.which)?(u(),!1):-1!=n.indexOf(t.which)&&""==f.val()?(d(f.prev()),!1):38==t.which?((e=v.find("li.active")).length>0?(i=e.prev(),e.removeClass("active")):i=v.children().last(),i.addClass("active"),f.val(i.text()),!1):40==t.which?((e=v.find("li.active")).length>0?(i=e.next(),e.removeClass("active")):i=v.children().first(),i.addClass("active"),f.val(i.text()),!1):void(27==t.which&&v.hide());var e,i}),f.on("input",g);var x=0;function g(){if(i){var e=new Date;i(f.val(),function(i){x<e&&(!function(e){v.show(),v.empty();for(var i=0;i<e.length;i++){var a=t("<li/>",{text:e[i]});a.mousedown(function(e){f.val(t(this).text()),u(),setTimeout(function(){f.focus()},0)}),v.append(a)}}(i),x=e)})}}this.wrap(c),this.parent().append(f),this.parent().append(v),this.parent().click(function(){f.focus()}),this.hide();var m=this.val();if(m.length>0){this.val(""),m=m.split(",");for(var w=0;w<m.length;w++)f.val(m[w]),u()}return this}}(jQuery);
EOD;
							?>

							$( function() {

								let tbody = $( 'tbody' );
								let tr = tbody.find( '> tr' );
								let sellers_numeric = JSON.parse( '<?=json_encode(array_values($shop_sellers))?>' );
								let sellers = JSON.parse( '<?=json_encode(array_flip($shop_sellers))?>' );
								let saved_alert = $( '#saved_alert' );

								$.each( $( '.tags' ), function( k, el ) {
									$( el ).tagsly( {
										suggestions : function( input, cb ) {
											cb( sellers_numeric );
										},
										placeholder : '',
										maxItems : 10,
										suggestOnFocus : true,
									} );
								} );

								$( '#save_changes' ).click( function() {

									let data_to_send = [];

									$.each( tr, function( k, el ) {

										el = $( el );

										if( el.attr( 'data-modified' ) === '0' )
											return true;

										let seller_ids = [];
										let seller_names = [];

										$.each( el.find( '.tag' ), function( k, el ) {
											let t_name = $( el ).text();
											t_name = t_name.substring( 0, t_name.length - 1 );
											seller_names.push( t_name );
										} );

										seller_names = [...new Set( seller_names )];

										$.each( seller_names, function( k, el ) {
											seller_ids.push( sellers[el] );
										} );


										data_to_send.push( [el.attr( 'data-id' ), el.attr( 'data-unix_day' ), seller_ids.join(), el.find( '.amount input' ).val(), el.find( '.terminal input' ).val(), el.find( '.out input' ).val()] );

									} );

									$.ajax( {
										method : 'POST',
										url : '<?=content::$link . '?mode=shop_data_send'?>',
										data : { 'data' : JSON.stringify( data_to_send ) },
										dataType : 'json',
									} ).done( function( json_data ) {

										$.each( json_data, function( data, id ) {
											let el = tbody.find( '> tr[data-unix_day="' + data + '"]' );
											if( typeof el !== 'undefined' )
												$( el ).attr( 'data-id', id );
										} );

										$.each( tr, function( k, el ) {
											$( el ).attr( 'data-modified', 0 );
										} );

										saved_alert.show();
										setTimeout( function() {
											saved_alert.hide();
										}, 1000 );
									} )
									.fail( function( xhr, ajaxOptions, thrownError ) {
										alert( 'Error saving changes!<br>' + xhr + ajaxOptions + thrownError );
										console.log( xhr );
										console.log( ajaxOptions );
										console.log( thrownError );
									} );

								} );

								tr.click( function() {
									$( this ).attr( 'data-modified', '1' ).removeClass( 'table-warning' );
								} );

								$( '.amount input, .terminal input, .out input, .products_cost input' ).focusout( function() {

									let el = $( this );
									let val = el.val();
									let new_val;

									if( /[+*\-/]/.exec( val ) == null )
										return true;

									new_val = eval( val );

									if( typeof new_val == 'undefined' )
										return true;

									el.val( parseFloat( new_val ).toFixed( 2 ) );
									calculate_sum( el );

								} );

								$( '.amount input, .terminal input' ).on( 'input', function() {
									calculate_sum( $( this ) );
								} );

								function calculate_sum( input ) {
									let td = input.parent().parent();
									let tr = td.parent();
									let val = input.val();

									let amount = 0;
									let terminal = 0;

									if( td.hasClass( 'amount' ) ){
										amount = val;
										terminal = tr.find( '.terminal input' ).val();
									}
									else {
										amount = tr.find( '.amount input' ).val();
										terminal = val;
									}


									if( amount === '' )
										amount = 0;
									if( terminal === '' )
										terminal = 0;

									let sum = parseFloat( parseFloat( amount ) + parseFloat( terminal ) ).toFixed( 2 );
									tr.find( '.sum input' ).val( sum );


								}

							} );

						</script>


					</div>
				</div>
			</div> <?php
		}

		public static function shop_save() {

			global $sql;

			try {

				if(!array_key_exists('data', $_POST))
					throw new Exception();

				$data = json_decode($_POST['data']);
				$unix_days = [];
				$inserted_data = [];

				$is_admin = array_key_exists('hash', $_SESSION) && array_key_exists(0, $data) && array_key_exists(6, $data[0]);

				foreach($data as $row) {

					$id = $row[0];
					$date = $row[1];
					$worker_ids = $row[2];
					$amount = $row[3];
					$terminal = $row[4];
					$out = $row[5];

					if(preg_match('/[+\-*\/]/', $amount))
						eval('$amount = ' . $amount . ';');
					if(preg_match('/[+\-*\/]/', $terminal))
						eval('$terminal = ' . $terminal . ';');
					if(preg_match('/[+\-*\/]/', $out))
						eval('$out = ' . $out . ';');

					if(!is_numeric($amount))
						$amount = 0;
					if(!is_numeric($terminal))
						$terminal = 0;
					if(!is_numeric($out))
						$out = 0;

					if($is_admin)
						$products_cost = $row[6];
					else
						$products_cost = 0;

					if($id == -1) {
						$sql->a('INSERT INTO `shop`(`worker_ids`,`amount`,`terminal`,`out`,`date`,`products_cost`) VALUES(?,?,?,?,?,?)', $worker_ids, $amount, $terminal, $out, $date, $products_cost);
						$inserted_data[$date] = $sql->c('SELECT LAST_INSERT_ID();');
					}
					else
						$sql->a('UPDATE `shop` SET `worker_ids`=?, `amount`=?, `terminal`=?, `out`=?, `date`=?, `products_cost`=? WHERE `id`=?', $worker_ids, $amount, $terminal, $out, $date, $products_cost, $id);

				}

				echo json_encode($inserted_data);

			}
			catch(Exception $e) {
			}

		}

	}


	if(array_key_exists('d', $_GET) && $_GET['d'] == 'logout') {
		content::logout();
		content::login();
	}
	elseif($_SESSION['mode'] == "shop" || $_GET['mode'] == "shop_input" || $_GET['mode'])
		content::shop_input();

	elseif(content::is_logged_in())
		content::show_website();

	elseif(array_key_exists('password', $_POST))
		content::login_validation();

	else
		content::login();

	/*

	BOTH:
	+ LEFTOVERS


	PRIVATE:
	remove sum from all???
	remove workers from all???
	solve 10sec bug


	PUBLIC:

	 * */

	?>
</body>
</html>