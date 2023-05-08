<!DOCTYPE html>
<html lang="en">
<head>
	<title>done</title>
	<link href="https://mambo.in.ua/map/data/bootstrap4/bootstrap.min.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<style>
		.row {
			padding-top: 20px;
		}
	</style>
</head>
<body>

	<?php

	session_start();


	class Account {


		private function account_exist($login, $hash) {

			return $login == explode("\n", file_get_contents('users/' . $hash))[0];
		}

		public function register() {

			if(!Helper::is_password_secure($_POST['password']))
				return 'Password is not secure enough';

			if(!preg_match('/^[A-Za-z0-9_\-]{3,60}$/', $_POST['login']))
				return 'Login is not valid (/^[A-Za-z0-9_\-]{3,60}$/)';

			$hash = md5($_POST['password']);
			$_SESSION['hash'] = $hash;

			if($this->account_exist($_POST['login'], $hash))
				return 'User with this username is already registered';

			file_put_contents("users/" . $hash, $_POST['login'] . "\n\n" . $_SERVER['REMOTE_ADDR']);

			if(strlen($_SESSION['hash']) < 10)
				return 'Session failed to initialize';

			$_SESSION['hash'] = $hash;
			return '';

		}

		public function login() {

			//validation
			if(!Helper::is_password_secure($_POST['password']) || !preg_match('/^[A-Za-z0-9_\-]{3,60}$/', $_POST['login']))
				return 'Login/Password is invalid';

			$hash = md5($_POST['password']);

			if(!$this->account_exist($_POST['login'], $hash))
				return 'Login/Password is invalid';

			$data = split("\n", file_get_contents('users/' . $hash));
			$data[2] = $_SERVER['REMOTE_ADDR'];
			file_put_contents('users/' . $hash, implode("\n", $data));
			$_SESSION['hash'] = md5($_POST['password']);
			return '';

		}

		public function user_profile() {

			$hash = $_SESSION['hash'];
			$data = explode("\n", file_get_contents('users/' . $hash));
			$login = $data[0];
			$email = $data[1];
			$ip = $data[2];

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
						$hash = md5($_POST['password']);
						rename("users/" . $_SESSION['hash'], "users/" . $hash);
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

				if($changeData) {
					$data = $login . "\n" . $email . "\n" . $ip;
					file_put_contents('users/' . $hash, $data);
				}

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
		}

	}


	class Helper {

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

	}


	?>

	<div class="container">
		<div class="row">

			<?php

			$account = new Account();

			if($_GET['action'] === 'register')
				$account->showRegisterForm();

			else if($_GET['action'] === 'login')
				$account->showLoginForm();

			else if($_GET['action'] === 'signout')
				$account->display($account->signOut());

			else if($_GET['action'] == 'profile')
				$account->user_profile();

			else if(isset($_POST['registerSubmit']))
				$account->display($account->register());

			else if(isset($_POST['loginSubmit']))
				$account->display($account->login());

			else if(isset($_SESSION['hash']) && $_GET['action'] != 'profile')
				$account->show_profile_link();

			else
				$account->showMenu();

			session_write_close();

			?>

		</div>
	</div>
</body>
</html>