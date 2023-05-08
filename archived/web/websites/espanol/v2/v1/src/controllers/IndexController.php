<?php


class IndexController {

	public function actionLoginForm() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php $account->showLoginForm() ?>
			</div>
		</div> <?php
	}

	public function actionRegisterForm() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php $account->showRegisterForm() ?>
			</div>
		</div> <?php
	}

	public function actionLoginValidate() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php $account->display($account->register()); ?>
			</div>
		</div> <?php
	}

	public function actionRegisterValidate() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php $account->display($account->login()); ?>
			</div>
		</div> <?php
	}

	public function actionProfile() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php $account->user_profile(); ?>
			</div>
		</div> <?php
	}

	public function actionProduct_added() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');

		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php Shop::added_post(); ?>
			</div>
		</div> <?php
	}

	public function actionProduct_edited() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');

		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php Shop::edited_post(); ?>
			</div>
		</div> <?php
	}

	public function actionProduct_deleted() {
		MainController::actionHeader();
		error_reporting(E_ERROR);
		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');

		$account = new Account(); ?>

		<div class="container">
			<div class="row">
				<?php Shop::deleted_post(); ?>
			</div>
		</div> <?php
	}

	public function actionMain() {


		MainController::actionHeader();

		require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'blog_api.php');
		$account = new Account(); ?>

		<div class="container">
			<div class="row">

				<?php

				error_reporting(E_ERROR);


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
		</div> <?php

		return true;
	}
}