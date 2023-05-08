<?php


class ErrorsController{

	public function action404($uri){

		MainController::actionHeader();
		$uri = base64_decode($uri);
		\Api\helper::log('-1', $uri); ?>

		<div class="container">
			<div class="row">
				<div class="col">
					<h1 title="<?= Language::get('404title', 1) ?>"><?= Language::get('404title') ?></h1>
					<p title="<?= Language::get('page_not_found', 2) ?>"><?= Language::get('page_not_found') ?></p>
					<a
							href="<?= Site::$link ?>"
							class="btn btn-outline-dark"
							title="<?= Language::get('main_page', 1) ?>"><?= Language::get('main_page') ?></a> <?php
					if(Site::_SHOW_CONTACTS){ ?>
						<a
								href="<?= Site::link('contacts/') ?>"
								class="btn btn-outline-dark"
								title="<?= Language::get('contact_us', 1) ?>"><?= Language::get('contact_us') ?></a> <?php
					} ?>

				</div>
			</div>
		</div> <?php

		return TRUE;
	}

	public function actionAdminNotify(){

		ob_start();
		var_dump($_POST);
		$content = ob_get_clean();

		if(array_key_exists('header', $_POST) && array_key_exists('data', $_POST))
			\Api\helper::admin_notify($_POST['header'], $content);
	}

}