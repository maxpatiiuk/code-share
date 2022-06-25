<?php


use Api\User;use Firebase\JWT\JWT;

class PostsController {

	//public

	public static function actionAdd() {

		global $sql;

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/posts' . Data::$css_ext) . '">' .
			'<script src="' . Site::link('public/scripts/categories' . Data::$js_ext) . '"></script>');
		MainController::actionHeader();
		if(Data::$main_user == NULL) {
			\Api\Helper::redirect('login');
			return FALSE;
		}
		if(Site::$users_can_post === FALSE && !in_array(Data::$main_user->get('type'), [2, 3, 5])) {
			\Api\helper::alert(Language::get('not_allowed_to_post', 2), 'danger');
			return FALSE;
		}

		$json = Data::$main_user->get('parameters');
		$json = json_decode($json, TRUE);

		$class = \Api\helper::safeGet('class', $json, 0); ?>

		<div class="row">
			<div class="col">
				<form>

					<h1 title="<?= Language::get('add_post', 1) ?>"><?= Language::get('add_post') ?></h1> <?php

					//$class = -2;
					$category = -1;

					$res = $sql->a('SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 0 AND `name`!="todas"',$class);

					$stmt = $sql->p(FALSE, 'SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 1 AND `name`!="todas"', 0);

					$categories_data = [];
					while($row = \Api\sql::fetch($res))
						$categories_data[$class][$row['id']] = ["name" => $row['name']] + \Api\helper::reindex_array($sql->res2data($sql->b([$row['id']], 1, $stmt)), -1);

					$categories = [/*Language::get('all')*/];
					if(array_key_exists($class, $categories_data))//$class != -2) {     //or 0
						foreach($categories_data[$class] as $key => $value)
							if($key != 'name')
								$categories[] = $value['name'];

					$themes = [/*Language::get('all')*/];
					if(array_key_exists($class, $categories_data) && $category != -1)
						foreach($categories_data[$class][$category] as $key => $value)
							if($key != 'name')
								$themes[] = $value;


					if(Site::$use_classes) {
						$classes = [
							[0, Language::get('all')],
							[5, 5],
							[6, 6],
							[7, 7],
							[8, 8],
							[9, 9],
							[10, 10],
							[11, 11],
							[-1, Language::get('graduated')],
						];
						if($class == 0)
							$classes[0][2] = 1;
						elseif($class == -1)
							$classes[count($classes) - 1][2] = 1;
						elseif($class >= 5 && $class <= 11)
							$classes[$class - 4][2] = 1;

						\Api\helper::input(Language::get('class', 2), 'class', 'select', TRUE, $classes, '', Fields::get('rclass'));
					}
					\Api\helper::input(Language::get('category', 2), 'category', 'list', FALSE, $categories, '',
					Fields::get('a_category'));
					\Api\helper::input(Language::get('theme', 2), 'theme', 'list', FALSE, $themes, '', Fields::get('a_theme'));

					if(Site::$seo) {
						\Api\helper::input(Language::get('keywords', 2), 'keywords', 'text', TRUE, '', '', Fields::get('a_keywords'));
						\Api\helper::input(Language::get('description', 2), 'description', 'text', FALSE, '', '', Fields::get('a_description'));
					}

					\Api\helper::input(Language::get('name', 2), 'name', 'text', TRUE, '', '', Fields::get('a_name')); ?>

					<div class="form-group">
						<label for="a2content" title="<?= Language::get('content', 1) ?>"><?= Language::get('content') ?></label><br>
						<textarea id="a2content" name="content" <?= Fields::get_formatted('a_content') ?>></textarea>
					</div> <?php
					\Api\helper::input('other', 'class="btn-group"');
					\Api\helper::input('', '', 'a', 'btn-danger', Language::get('cancel', 2), '', '', 'href="' . Site::link('post/list/') . '"');
					\Api\helper::input('', 'submit', 'submit', 'btn-dark', Language::get('add_post', 2), '', '');
					\Api\helper::input('other', '</div>'); ?>


					<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=2fbpqp3ecggvye2jz11sgfxat3eu0kngviwvn9pa14qwrps8"></script>
					<script>

						//text["image_preview"] = "<?//=Language::get('image_preview')?>//";

						tinymce.init({
							selector: "#a2content",
							mode: "exact",
							elements: "a2content",
							tinydrive_token_provider: "../tinymce/token/",
							language_url: '<?=Site::link('public/scripts/tiny_mce/languages/es_MX.js')?>',
							language:
								"es_MX",
							content_css:
								'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css,<?=Site::link('/public/css/posts' . Data::$css_ext)?>,<?=Site::link('/public/css/main' . Data::$css_ext)?>',
                            toolbar: "undo redo | styleselect | alignleft aligncenter alignright | bold italic | indent outdent | link image",
							plugins:
								"tinydrive advlist autolink autolink autosave emoticons fullscreen image imagetools link lists media paste preview save table toc help",
						});

						btn = $("#a2submit");

						btn.closest("form").on("submit", function() {
							$("#a2content").val(tinymce.editors["a2content"].getContent());
						});

						$(function() {
							// src_to_preview("src file","preview-container");

							forming(btn, '<?=Site::link('post/add/validate')?>', '<?=Site::link('post/view/')?>');


							//$('.tox-collection__item[title="Imagen..."]').click(function(){alert(1);});

						});

						let current_class = <?=$class?>;
						let sorting_data = JSON.parse('<?=json_encode($categories_data)?>');

						let class_field = $("#a2class");
						let category_field = $("#a2category");
						let theme_field = $("#a2theme");

					</script>

				</form>
			</div>
		</div> <?php

		return TRUE;
	}

	public static function actionValidateAdd() {

		global $sql;

		[$name, $content, $keywords, $description, $theme_id, $category_id, $unix_time, $verified, $comments] = self::get_post_data();
		if($unix_time === NULL)
			return FALSE;

		$sql->a('INSERT INTO `dposts`(`name`,`keywords`,`description`,`theme_id`,`category_id`,`creator_id`,`created_unix`,`verified`,`comments`) VALUES(?,?,?,?,?,?,?,?,?)', $name, $keywords, $description, $theme_id, $category_id, Data::$main_user->get('id'), $unix_time, $verified, $comments);
		$post_id = $sql->last_insert_id();
		self::delete_extra_categories();

		[$src,$content] = PostsController::review_content($content,$post_id);
		$sql->a('UPDATE `dposts` SET `content`=?, `src`=? WHERE `id`=?',$content,$src,$post_id);

		if($verified == 0) {
			$admin_emails = $sql->res2data($sql->a('SELECT `email`,`parameters` FROM `dusers` WHERE `type` IN (2,3,5)'));
			$mail_content = mail::content(Language::get('new_post_subject'), Language::get('new_post_content') . '<a href="' . Site::link('post/edit/' . $post_id) . '">' . $name . ' ('.Site::link('post/edit/' . $post_id).')</a>');

			foreach($admin_emails as $data) {
				$parameters = json_decode($data['parameters'], TRUE);
				if(\Api\helper::safeGet('mail_subscribed', $parameters, "true") !== "false")
					mail::send(Language::get('new_post_subject'), $mail_content, Site::_EMAIL_, $data['email']);
			}
		}

		echo json_encode([
			'error'   => 0,
			'post_id' => $post_id,
		]);

		return TRUE;
	}

	private static function get_post_data() {

		global $field, $sql, $field_data;

		if(Data::$main_user == NULL) {
			echo json_encode(['error' => 1, 'msg'=>'Not logged in']);
			return FALSE;
		}
		if(Site::$users_can_post === FALSE && !in_array(Data::$main_user->get('type'), [2, 3, 5])) {
			echo json_encode(['error' => 1, 'msg'=>'Not allowed to post']);
			return FALSE;
		}

		$field_data = [
			'category' => ['a_category',1],
			'theme'    => ['a_theme',1],
			'name'     => 'a_name',
			'content'  => 'a_content',
			//'src'      => ['a_src', 1],
			'comment'  => ['a_comment', 1],
		];

		if(Site::$seo) {
			$field_data['keywords'] = 'a_keywords';
			$field_data['description'] = 'a_description';
		}

		if(Site::$use_classes)
			$field_data['class'] = 'rclass';


		$validation_results = \Api\lrp::validate_fields();
		if($validation_results['error'] !== 0) {
			echo json_encode($validation_results);
			return FALSE;
		}

		$category = trim(strip_tags($field['category']));
		$theme = trim(strip_tags($field['theme']));
		$name = trim(strip_tags($field['name']));
		$content = $field['content'];
		$unix_time = $_SERVER['REQUEST_TIME'];
		if(array_key_exists('comment', $field))
			$teacher_comment = $field['comment'];
		else
			$teacher_comment = '';

		$class = 0;
		if(Site::$use_classes && array_key_exists('class', $field))
			$class = $field['class'];

		$keywords = '';
		$description = '';
		if(Site::$seo) {
			if(array_key_exists('keywords', $field))
				$keywords = $field['keywords'];

			if(array_key_exists('description', $field))
				$description = $field['description'];
		}

		if($category=='' || $category=='*')
			$category = 'Todas';
		if($theme=='' || $theme=='*')
			$theme = 'Todas';

		$theme_id = NULL;

		$category_id = $sql->c('SELECT `id` FROM `dcategories` WHERE `name` = ? AND `class` = ? AND `type` = 0', $category, $class);

		if(!is_numeric($category_id)) {
			$sql->a('INSERT INTO `dcategories`(`name`,`class`,`type`) VALUES(?,?,0)', $category, $class);
			$category_id = $sql->last_insert_id();
			$theme_id = $sql->c('SELECT `id` FROM `dcategories` WHERE `name` = ? AND `class` = ? AND `type` = 1', $theme, $category_id);
		}
		elseif($category!='Todas')
			$theme_id = $sql->c('SELECT `id` FROM `dcategories` WHERE `name` = ? AND `class` = ? AND `type` = 1', $theme, $category_id);

		if(!is_numeric($theme_id) && $category!='Todas') {
			$sql->a('INSERT INTO `dcategories`(`name`,`class`,`type`) VALUES(?,?,1)', $theme, $category_id);
			$theme_id = $sql->last_insert_id();
		}

		$verified = 1;
		if(Site::$need_to_verify && !in_array(Data::$main_user->get('type'), [2, 3, 5]))
			$verified = 0;

		$comments = [];


//        if(!is_null($_FILES['file']) && $_FILES['file']['error'] == 0) {
//
//            /* Process image with GD library */
//            $verifyimg = getimagesize($_FILES['file']['tmp_name']);
//
//            /* Make sure the MIME type is an image */
//            $pattern = "#^(image/)[^\s\n<]+$#i";
//
//            if(preg_match($pattern, $verifyimg['mime']) && $_FILES['file']['size']<Site::$max_file_size){
//                $res = \Api\helper::upload_image(base64_encode(file_get_contents($_FILES['file']['tmp_name'])));
//				if(is_array($res)) {
//					$src = $res[0];
//					$comments['delete'][] = $res[1];
//				}
//            }
//
//        }
//		elseif(array_key_exists('src', $field) && strlen($field['src']) > 1) {
//
//			$src = $field['src'];
////			if(substr($src, 0, 4) == 'data') {
//
////				$src = upload_image_to_imgbb(substr($src,strpos($src,',')));
//
//				$res = \Api\helper::upload_image($src);
//				if(is_array($res)) {
//					$src = $res[0];
//					$comments['delete'][] = $res[1];
//				}
////				else {
////					$file_name = \Api\helper::generate_random_string(10);
////					$res2 = \Api\helper::upload_file($src, $file_name, true, false, 'public/images/posts/');
////					if(!array_key_exists('error', $res2) || $res2['error'] != 0) {
////						ob_start();
////						var_dump($res);
////						echo '<br><br>';
////						var_dump($res2);
////						echo '<br><br>';
////						var_dump(Data::$main_user->get('id'));
////						echo '<br><br>';
////						var_dump($src);
////						echo '<br><br>';
////						var_dump($_POST);
////						echo '<br><br>';
////						$content = ob_get_clean();
////						mail::send(Site::_NAME_ . ' - failed to upload image', mail::content(Site::_NAME_ . ' - failed to upload image', $content), Site::_EMAIL_, Site::_ADMIN_EMAIL_);
////						$src = '';
////					}
////					else
////						$src = Site::link('public/images/posts/') . $file_name . '.' . $res2['ext'];
////				}
////			}
////			elseif(substr($src, 0, 5) === 'http:')
////				$src = upload_image_to_imgbb($src);
////			elseif(substr($src, 0, 4) != 'http')
////				$src = 'http://' . $src;
//		}

		if(strlen($teacher_comment) > 0)
			$comments['teacher_comment'] = $teacher_comment;

		$comments = json_encode($comments);


		return [$name, $content, $keywords, $description, $theme_id, $category_id, $unix_time, $verified, $comments];
	}

	private static function delete_extra_categories() {

		global $sql;

		$sql->a('DELETE `c` FROM `dcategories` AS `c` WHERE `c`.`type` = 0 AND `c`.`name`!="todas" AND `c`.`id` NOT IN (SELECT `p`.`category_id` FROM `dposts` AS `p`)');
		$sql->a('DELETE `c` FROM `dcategories` AS `c` WHERE `c`.`type` = 1 AND `c`.`name`!="todas" AND  `c`.`id` NOT IN (SELECT `p`.`theme_id` FROM `dposts` AS `p`)');
	}

	private static function review_content($content,$post_id){

		//hosting images and removing scripts from result to prevent hacking
		$first_src = '';


		$src = '';
		if(strlen($content) > 1) {
			error_reporting(0);
			$img_id = 0;

			$dom = new DOMDocument();
			$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$xpath = new DOMXpath($dom);
			$images = $xpath->query("//img[starts-with(@src, 'data:image/')]");
			foreach($images as $image) {

				$src = $image->getAttribute('src');
				if($first_src == '')
					$first_src = $src;

				if(strpos($src,'ibb.co')==FALSE){
					$res = \Api\helper::upload_image($image->getAttribute('src'),$post_id.'_'.$img_id);
					if(is_array($res)) {
						$image->setAttribute('src', $res[0]);
						$comments['delete'][] = $res[1];
					}
				}
//				else {
//					$file_name = \Api\helper::generate_random_string(10);
//					$res2 = \Api\helper::upload_file($image->getAttribute('src'), $file_name, TRUE, FALSE, 'public/images/posts/');
//					if(!array_key_exists('error', $res2) || $res2['error'] != 0) {
//						ob_start();
//						var_dump($res);
//						echo '<br><br>';
//						var_dump($res2);
//						echo '<br><br>';
//						var_dump(Data::$main_user->get('id'));
//						echo '<br><br>';
//						var_dump($_POST);
//						echo '<br><br>';
//						$content = ob_get_clean();
//						mail::send(Site::_NAME_ . ' - failed to upload image', mail::content(Site::_NAME_ . ' - failed to upload image', $content), Site::_EMAIL_, Site::_ADMIN_EMAIL_);
//					}
//					else
//						$image->setAttribute('src', Site::link('public/images/posts/') . $file_name . '.' . $res2['ext']);
//				}
				$img_id++;
			}

			$script = $dom->getElementsByTagName('script');
			foreach($script as $item)
				$item->parentNode->removeChild($item);

			$content = trim($dom->saveHTML());

			if(Site::$development)
				error_reporting(E_ALL);

		}


		$src = $first_src;

		return [$src,$content];
	}

	public static function actionTinymceToken(){


		//require 'vendor/autoload.php';
		require_once(__DIR__ . '/../../mambo.in.ua/map/data/JWT.slim.php');

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

		$privateKey = <<<EOD
		-----BEGIN PRIVATE KEY-----
		MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCsxBZ6p+dGu9L2
		DeK71omjEH3vBfS/O0wR7iTd7OhzoKKhvpvRDQUfJYCbaEDbfaFtnAQDf7cZZgbL
		hxC90L/KFzlXtMtHP7tsnzNgjehfCDqbu5m6JgeG6EuYifImzMlGa/Fi50UgEc29
		X4NBsZQkF+s+6VbqwyOMbElO9JvwfWpDb/4SKlIn4lVifmWSdNZUta//roGMOrta
		QWKRNy8g7oSXAU0GeoI31Sj1LftMNlQJASn/4QehU5JI4gXmwMSAuw9ShlrHXkCS
		/e9lP0xjkgSa3ulEMFYx3XgArtg4zTw0HGicz7M6mj0Vn6ukN04B0by1kAazH5zh
		CbzjMDvXAgMBAAECggEAUh/QE7QWsz/7Uy1cly+vM41WX7W0FucoDOnoKnpAMR6t
		0DccOG54/cpE7RrMocmBX+om2kbukas3Fa55ndFKKdWKU4/EhXTdMhAnSwGJ8Qqn
		WXn+5EbJky5/KN6B9kGod8o972bCLDFqXFe3vBWett2L3NbskyH5lvmui1KpgdJD
		8Dox3EuuVa/aNxOCXoNa0i/eKfCesDxenggR2Z5gswMpvQG7e7IvS8M5wap2OkT/
		QC5VfXlZCkiWChu0N+/kDvoetshdlF+awGU9FtSTnPENtY29DQCXFpr/6np/itQp
		ALMfRgGXR1VV+SqCYYb9QaW8Oa27HtUxf8MjVjWUCQKBgQDc2f//XlEhIYLc2rn7
		FMzMvgJoCq9n0IO3LHz/+7Tw8H/3fvF7XfQurLk2XeTJdBxlr84WZTBGrpaKX2Eb
		xTxi2J4j+CUqCMcUnMzUh2OeBV/7ECUS8u3cAroUQnq9cjdmmTvxFPeX1ujFqNTv
		hxAKpOkCzxYF0erE8Z6LQCb8OwKBgQDIQvhhUzTBBoTxhodW/ZKHjOY+QPPi/UpG
		d1MZebUCERMw4kpwSzOCp6C65MI/Z73RFZ0q1BlqdkM+qvqKCdEiDeS/O+qsrt5w
		7mS7R6+ZSSlQKpgGf7EI7cifevbonQYJoZTO/Q9PUx8muZSgUmynTqbbDfZJYuiy
		hXLgXv7xFQKBgE9xA0rCjIBUY5Q6AWg1pS2Is6jlHw9Cy/5ZvGUAD6gTepR2TzrH
		IwyfCMhrod5tK8HQKVuY7nKeXnxLrsykeAI+VTQvEH88RRA/DtbsFINE/695sTxN
		sg3P1UtwVmJK8W6wdAVWO3Gc1oIzJtU6SiTqCP7/qrZROhe5qgQBAYT9AoGAekPI
		+UKflqmwSPVlc8rkxzVS7Pci75bM3jDD323bASQDn3jJEb4X+ND25KP9pFBmJ10W
		06siyUjizUP+KoDL2gq5ebfPExbAYBpsDZs6rk9olbUrk+wp3dWvAw9D58jWgtLP
		03/U9Q0+m5n6D9fC1nLClEL19uAYScYH2MymwfECgYA9L/8a2Ea3k6qSoRLD0VSh
		ODa31Lv4pNwPlm44zTjJr7DUCs//d/rcIsgbZjQtQDeuG3BegZ0/dO1X+vSj6mWt
		SrESWmiGDIFop9d7Lk5IMRBUlV5mAK6VslGxETGL6J0KuB2iTQ0kfYjulB+FqRFS
		BOidanu59KF9H9NU9x6Flw==
		-----END PRIVATE KEY-----
		EOD;

		// NOTE: Before you proceed with the TOKEN, verify your users session or access.

		$payload = [
			"sub" => "2fbpqp3ecggvye2jz11sgfxat3eu0kngviwvn9pa14qwrps8", // unique user id string
			"name" => "Maksym Patiiuk", // full name of user

			// Optional custom user root path
			// "https://claims.tiny.cloud/drive/root" => "/johndoe",

			"exp" => time() + 60 * 10 // 10 minute expiration
		];

		try {
			$token = JWT::encode($payload, $privateKey, 'RS256');
			http_response_code(200);
			header('Content-Type: application/json');
			echo json_encode(["token" => $token]);
		} catch (Exception $e) {
			http_response_code(500);
			header('Content-Type: application/json');
			echo $e->getMessage();
		}

	}

	public static function actionEdit() {

		global $sql;

		if(Data::$main_user == NULL) {
			\Api\Helper::redirect('login');
			return FALSE;
		}
		if(Site::$users_can_post === FALSE && !in_array(Data::$main_user->get('type'), [2, 3, 5])) {
			\Api\helper::alert(Language::get('not_allowed_to_post', 2), 'danger');
			return FALSE;
		}

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/posts' . Data::$css_ext) . '">' .
			'<script src="' . Site::link('public/scripts/categories' . Data::$js_ext) . '"></script>');
		MainController::actionHeader();

		$is_teacher = in_array(Data::$main_user->get('type'), [2, 3, 5]);

		$args = func_get_args();
		if(count($args) != 1 || !is_numeric($args[0]) || $args[0] < 0) {
			header('Location: ' . Site::$link);
			return FALSE;
		}
		$post_id = $args[0];
		$post_data = $sql->r('SELECT `p`.`name`,`p`.`content`,`p`.`keywords`,`p`.`description`,`p`.`creator_id`,`p`.`created_unix`,`p`.`src`,`p`.`comments`,`c`.`class` AS "class", `c`.`id` AS "category_id",`c`.`name` AS "category_name",`t`.`id` AS "theme_id",`t`.`name` AS "theme_name" FROM `dposts` `p` LEFT JOIN `dcategories` `c` ON `c`.`id` = `p`.`category_id` LEFT JOIN `dcategories` `t` ON `t`.`id` = `p`.`theme_id` WHERE `p`.`id` = ?', $post_id);
		if($post_data == NULL) {
			\Api\helper::alert(Language::get('post_not_found', 2), 'danger');
			return FALSE;
		}

		$comments = $post_data['comments'];
		$comments = json_decode($comments, TRUE);

		$category = $post_data['category_id'];
		$category_class = $sql->c('SELECT `class` FROM `dcategories` WHERE `id`=?', $category);
		if($post_data['category_name'] == 'Todas')
			$category=-1;

		//$json = Data::$main_user->get('parameters');
		//$json = json_decode($json, TRUE);
		//$class = \Api\helper::safeGet('class', $json, 0);
		//if($class != $category_class)
			$class = $category_class;

		$is_verifying = FALSE;
		$comment = '';
		if(Data::$main_user->get('id') != $post_data['creator_id']) {
			if(!$is_teacher) {
				\Api\helper::alert(Language::get('no_permission_to_edit', 2), 'danger');
				return FALSE;
			}
			$is_verifying = TRUE;
			$comment = \Api\helper::safeGet('teacher_comment', $comments, '');
		} ?>

		<div class="row">
			<div class="col">
				<form>

					<h1 title="<?= Language::get('edit_post', 1) ?>"><?= Language::get('edit_post') ?></h1> <?php

					//$class = -2;

					$res = $sql->a('SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 0', $class);

					$stmt = $sql->p(FALSE, 'SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 1', 0);

					$categories_data = [];
					while($row = \Api\sql::fetch($res))
						$categories_data[$class][$row['id']] = ["name" => $row['name']] + \Api\helper::reindex_array($sql->res2data($sql->b([$row['id']], 1, $stmt)), -1);


					$categories = [/*Language::get('all')*/];
					if(array_key_exists($class, $categories_data)) {//$class != -2) {     //or 0
						foreach($categories_data[$class] as $key => $value) {
							if($key == 'name')
								continue;
							if($key == $category)
								$categories[] = [$value['name'], 1];
							else
								$categories[] = $value['name'];
						}
					}

					$themes = [/*Language::get('all')*/];
					if(array_key_exists($class, $categories_data) && $category != -1) {
						foreach($categories_data[$class][$category] as $key => $value) {
							if($key == 'name')
								continue;
							if($key == $post_data['theme_id'])
								$themes[] = [$value, 1];
							else
								$themes[] = $value;
						}
					}


					if(Site::$use_classes) {
						$classes = [
							[0, Language::get('all')],
							[5, 5],
							[6, 6],
							[7, 7],
							[8, 8],
							[9, 9],
							[10, 10],
							[11, 11],
							[-1, Language::get('graduated')],
						];
						if($class == 0)
							$classes[0][2] = 1;
						elseif($class == -1)
							$classes[count($classes) - 1][2] = 1;
						elseif($class >= 5 && $class <= 11)
							$classes[$class - 4][2] = 1;

						\Api\helper::input(Language::get('class', 2), 'class', 'select', TRUE, $classes, '', Fields::get('rclass'));
					}
					\Api\helper::input(Language::get('category', 2), 'category', 'list', FALSE, $categories, '',
					Fields::get('a_category'));
					\Api\helper::input(Language::get('theme', 2), 'theme', 'list', FALSE, $themes, '', Fields::get('a_theme'));
//					\Api\helper::input(Language::get('file', 2), 'file', 'file',FALSE, '','','','class="d-block" accept="image/*"');
//					\Api\helper::input('other','id="preview-container"');
//					\Api\helper::input('', 'src', 'url', FALSE, $post_data['src'], '', Fields::get('a_src'),'class="mb-4"');
//					\Api\helper::input('other','</div>');

					if(Site::$seo) {
						\Api\helper::input(Language::get('keywords', 2), 'keywords', 'text', TRUE, $post_data['keywords'], '', Fields::get('a_keywords'));
						\Api\helper::input(Language::get('description', 2), 'description', 'text', FALSE, $post_data['description'], '', Fields::get('a_description'));
					}

					\Api\helper::input(Language::get('name', 2), 'name', 'text', TRUE, $post_data['name'], '', Fields::get('a_name'));

					if($is_verifying)
						\Api\helper::input(Language::get('comment', 2), 'comment', 'textarea', FALSE, $comment, '', Fields::get('a_comment')); ?>

					<div class="form-group">
						<label for="a2content" title="<?= Language::get('content', 1) ?>"><?= Language::get('content') ?></label><br>
						<textarea id="a2content" name="content" <?= Fields::get_formatted('a_content') ?>><?= $post_data['content'] ?></textarea>
					</div> <?php

					\Api\helper::input('other', 'class="btn-group"');
					\Api\helper::input('', '', 'a', 'btn-danger', Language::get('cancel', 2), '', '', 'href="' . Site::link('post/list/') . '"');
					\Api\helper::input('', '', 'a', 'btn-danger', Language::get('delete_post', 2), '', '', 'href="' . Site::link('post/delete/' . $post_id) . '"');
					\Api\helper::input('', '', 'a', 'btn-dark', Language::get('view_post', 2), '', '', 'href="' . Site::link('post/view/' . $post_id) . '" target="_blank"');
					\Api\helper::input('', 'submit', 'submit', 'btn-success', Language::get('edit_post', 2), '', '');
					\Api\helper::input('other', '</div>'); ?>


					<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=2fbpqp3ecggvye2jz11sgfxat3eu0kngviwvn9pa14qwrps8"></script>
					<script>

						//text["image_preview"] = "<?//=Language::get('image_preview')?>//";

						tinymce.init({
							selector: "#a2content",
							mode: "exact",
							elements: "a2content",
							tinydrive_token_provider: "../tinymce/token/",
							language_url: '<?=Site::link('public/scripts/tiny_mce/languages/es_MX.js')?>',
							language:
								"es_MX",
							content_css:
								'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css,<?=Site::link('/public/css/posts' . Data::$css_ext)?>,<?=Site::link('/public/css/main' . Data::$css_ext)?>',
                            toolbar: "undo redo | styleselect | alignleft aligncenter alignright | bold italic | indent outdent | link image",
							plugins:
								"tinydrive advlist autolink autolink autosave emoticons fullscreen image imagetools link lists media paste preview save table toc help",
						});

						btn = $("#a2submit");

						btn.closest("form").on("submit", function() {
							$("#a2content").val(tinymce.editors["a2content"].getContent());
						});

						$(function() {
							// src_to_preview("src file","preview-container");

							forming(btn, '<?=Site::link('post/edit/validate/' . $post_id)?>', '<?=Site::link('post/view/'.$post_id)?>');
						});

						let current_class = <?=$class?>;
						let sorting_data = JSON.parse('<?=json_encode($categories_data)?>');

						let class_field = $("#a2class");
						let category_field = $("#a2category");
						let theme_field = $("#a2theme");

					</script>

				</form>
			</div>
		</div> <?php

		return TRUE;
	}

	public static function actionValidateEdit() {

		global $sql, $field;

		$args = func_get_args();
		if(count($args) != 1 || !is_numeric($args[0]) || $args[0] < 0) {
			header('Location: ' . Site::$link);
			return FALSE;
		}
		$post_id = $args[0];

		[$name, $content, $keywords, $description, $theme_id, $category_id, $unix_time, $verified, $final_comments] = self::get_post_data();
		if($unix_time === NULL)
			return FALSE;

		[$src,$content] = PostsController::review_content($content,$post_id);

		$post_data = $sql->r('SELECT `p`.`name`,`p`.`content`,`p`.`keywords`,`p`.`description`,`p`.`creator_id`,`p`.`created_unix`,`p`.`src`,`p`.`comments`,`c`.`class` AS "class",`c`.`name` AS "category_name",`c`.`id` AS "category_id",`t`.`id` AS "theme_id",`t`.`name` AS "theme_name" FROM `dposts` `p` LEFT JOIN `dcategories` `c` ON `c`.`id` = `p`.`category_id` LEFT JOIN `dcategories` `t` ON `t`.`id` = `p`.`theme_id` WHERE `p`.`id` = ?', $post_id);
		if($post_data == NULL) {
			echo json_encode(['error' => 1, 'msg'=>'post_not_found']);
			return FALSE;
		}

		$comments = $post_data['comments'];
		$comments = array_merge(json_decode($comments,TRUE), json_decode($final_comments,TRUE));

		$is_teacher = in_array(Data::$main_user->get('type'), [2, 3, 5]);

		if(Data::$main_user->get('id') == $post_data['creator_id']) {
			$admin_emails = $sql->res2data($sql->a('SELECT `email`,`parameters` FROM `dusers` WHERE `type` IN (2,3,5)'));
			$mail_content = mail::content(Language::get('new_post_subject'), Language::get('new_post_content') . '<a href="' . Site::link('post/edit/' . $post_id) . '">' . $name . ' ('.Site::link('post/edit/' . $post_id).')</a>');
			foreach($admin_emails as $data) {
				$parameters = json_decode($data['parameters'], TRUE);
				if(\Api\helper::safeGet('mail_subscribed', $parameters, "true") !== "false")
					mail::send(Language::get('new_post_subject'), $mail_content, Site::_EMAIL_, $data['email']);
			}
		}
		elseif(Data::$main_user->get('id') != $post_data['creator_id']) {

			if(!$is_teacher) {
				echo json_encode(['error'=>1,'msg' => 'no_permission_to_edit']);
				return FALSE;
			}
			$comments['edit'] = [];

			$t_vars_to_check = ['name', 'keywords', 'description', 'src'];
			foreach($t_vars_to_check as $var)
				if($$var != $post_data[$var])
					$comments['edit'][$var] = $post_data[$var];

			if($field['class'] != $post_data['class'])
				$comments['edit']['class'] = $post_data['class'];
			if($category_id != $post_data['category_id'])
				$comments['edit']['category_name'] = $post_data['category_name'];
			if($theme_id != $post_data['theme_id'])
				$comments['edit']['theme_name'] = $post_data['theme_name'];
			if($content != $post_data['content'])
				$comments['edit']['content'] = \Api\helper::html2text($post_data['content']);

			$verified = 1;
			$creator = new Api\User($post_data['creator_id']);
			$parameters = $creator->get('parameters');
			$parameters = json_decode($parameters, TRUE);
			if(\Api\helper::safeGet('mail_subscribed', $parameters, "true")!=="false")
				mail::send(Language::get('post_verified_subject'), mail::content(Language::get('post_verified_subject'), Language::get('post_verified_content') . '<a href="' . Site::link('post/review/' . $post_id) . '">' . Site::link('post/review/' . $post_id) . '</a>'), Site::_EMAIL_, $creator->get('email'));

		}
		else
			unset($comments['edit']);

		$comments = json_encode($comments);

		$sql->a('UPDATE `dposts` SET `name`=?, `content`=?, `keywords`=?, `description`=?, `verified`=?, `theme_id`=?, `category_id`=?, `src`=?, `comments`=? WHERE `id`=?', $name, $content, $keywords, $description, $verified, $theme_id, $category_id, $src, $comments, $post_id);

		echo json_encode(['error' => 0,]);
		self::delete_extra_categories();
		return TRUE;

	}

	public static function actionView() {

		global $sql;

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/posts' . Data::$css_ext) . '">');
		MainController::actionHeader();

		$args = func_get_args();

		$post_id = NULL;
		$post_data = NULL;
		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_data = $sql->r('SELECT `p`.`name`,`p`.`content`,`p`.`keywords`,`p`.`description`,`p`.`creator_id`,`p`.`comments`,`p`.`created_unix`,`p`.`comments`,`c`.`class` AS "class", `c`.`id` AS "category_id",`c`.`name` AS "category_name",`t`.`id` AS "theme_id",`t`.`name` AS "theme_name" FROM `dposts` `p` LEFT JOIN `dcategories` `c` ON `c`.`id` = `p`.`category_id` LEFT JOIN `dcategories` `t` ON `t`.`id` = `p`.`theme_id` WHERE `p`.`id` = ?', $post_id);
		}

		if($post_data == NULL) {
			\Api\helper::alert(Language::get('post_not_found', 2), 'danger');
			return FALSE;
		}


		if(Site::$seo)
			\Api\helper::set_seo([$post_data['name'], $post_data['keywords'], $post_data['description']], 2);
		else
			\Api\helper::set_seo($post_data['name']);

		//post_displaying
		if(Data::$main_user != NULL && ($post_data['creator_id'] == Data::$main_user->get('id') || in_array(Data::$main_user->get('type'), [2, 3, 5]))) { ?>
			<div class="btn-group">
				<a href="<?= Site::link('post/edit/' . $post_id) ?>" class="btn btn-outline-dark" title="<?= Language::get('edit', 1) ?>"><?= Language::get('edit') ?></a>
			</div> <?php
		}

		$is_owner = FALSE;

		if(Data::$main_user != NULL && Data::$main_user->get('id') == $post_data['creator_id']) {
			$is_owner = TRUE;
			$creator = Data::$main_user;
		}
		else
			$creator = new User($post_data['creator_id']);

		$link_part_1 = '';
		$link_part_2 = '';
		$parameters = $creator->get('parameters');
		$parameters = json_decode($parameters, TRUE);

		$visibility = \Api\helper::safeGet('visibility', $parameters, -1);
		if($is_owner || $visibility == -1 || ($visibility == 1 && Data::$main_user != NULL)) {
			$link_part_1 = '<a href="' . Site::link('author/@' . $creator->get('login')) . '">';
			$link_part_2 = '</a>';
		}

		$a_class = '';
		if(Site::$use_classes) {
			if($post_data['class'] == 0)
				$a_class = Language::get('all').Language::get('classes');
			elseif($post_data['class'] == -1)
				$a_class = Language::get('graduated');
			else
				$a_class = $post_data['class'].' '.Language::get('class');
			$a_class = Language::get('class'). ': <a href="' . Site::link('class/' . $post_data['class']) . '">' .
			$a_class . '</a>, ';
		}

		if($post_data['category_name']!='Todas')
			$a_category = Language::get('category') . ': <a href="' . Site::link('class/' . $post_data['class'] . '/category/' . $post_data['category_id']) . '">' . $post_data['category_name'] . '</a>, ';
		else
			$a_category = '';

		if($post_data['theme_name']!=NULL && $post_data['theme_name']!='Todas')
			$a_theme = Language::get('theme') . ': <a href="' . Site::link('class/' . $post_data['class'] . '/category/' . $post_data['category_id'] . '/theme/' . $post_data['theme_id']) . '">' . $post_data['theme_name'] . '</a>, ';
		else
			$a_theme='';

		$a_info = $a_class . $a_category . $a_theme;
		$a_info = substr($a_info,0,-2); ?>



		<h1><?= $post_data['name'] ?></h1>

		<hr> <?php

/*		if(strlen($post_data['src'])) { */?><!--
			<img class="post_esc zoomable" src="<?/*= $post_data['src'] */?>" alt="<?/*= $post_data['name'] */?>"> --><?php
/*		} */?>

		<div class="content"><?= $post_data['content'] ?></div>

		<hr>
		<div class="row">
			<div class="col-12 col-md-6 mb-4 mb-md-0">
				<?= Language::get('created_by') . ' ' . $link_part_1 . $creator->get_full_name() . $link_part_2 . ' ' . Language::get('created_on') . ' ' . \Api\helper::format_date($post_data['created_unix'], 'friendlify') ?>
			</div>
			<div class="col-12 col-md-6 text-md-right">
				<?=$a_info?>
			</div>
		</div> <?php


		$comments = json_decode($post_data['comments'], TRUE);

		if(is_array($comments))
			$user_comments = \Api\helper::safeGet('user_comments', $comments, '');
		else
			$user_comments = '';

		$user_comments = explode('~', $user_comments);
		$user_can_post = (Site::$allow_anonymous_comments || Data::$main_user !== NULL);

		$comments_count = count($user_comments);

		if($comments_count == 1 && $user_comments[0] == '') {
			unset($user_comments[0]);
			$comments_count = 0;
		}

		if(Site::$comments > 0 && ($comments_count > 0 || $user_can_post)) { ?>

			<hr>

			<div class="row">
				<div class="col-12" id="main_comments_container"> <?php

					if(Data::$main_user !== NULL) {
						$logged_in_id = Data::$main_user->get('id');
						$can_edit_comments = in_array(Data::$main_user->get('type'), [2, 3, 5]);
					}
					else {
						$logged_in_id = -1;
						$can_edit_comments = FALSE;
					}

					if($comments_count > 0) {

						if($comments_count % 4 == 0) {

							$closed_div = TRUE;

							$users = [];
							$users_ids = [];

							for($i = 0;$i < $comments_count;) {

								$level = $user_comments[$i];
//								if($level == 1) {
//
//								}

								$user_id = $user_comments[$i + 1];

								$formatted_user_name = '';

								if($user_id == -1) {
									$user_name = Language::get('anonymous');
									$ava = Site::_DEFAULT_AVA_;
									$ava_class = '';
								}

								else {
									if(!in_array($user_id, $users_ids)) {
										$users_ids[] = $user_id;
										$users[$user_id] = new User($user_id);
									}

									$user_type = $users[$user_id]->get('type');

									if($user_type == 7)
										$user_name = Language::get('user_deleted');
									elseif($user_type == 6)
										$user_name = Language::get('user_banned');
									else {
										$user_name = $users[$user_id]->get_full_name();
										$formatted_user_name = '<a href="' . Site::$link . 'profile/@' . $users[$user_id]->get('login') . '">' . $user_name . '</a>';
									}

									$ava = $users[$user_id]->get_u_ava();
									if($ava != Site::_DEFAULT_AVA_)
										$ava_class = 'class="dark_mode_invert" ';
									else
										$ava_class = '';
								}

								if($formatted_user_name == '')
									$formatted_user_name = $user_name;

								$comment_text = str_replace(['`q', '`t'], ['`', '~'], $user_comments[$i + 3]);

								if($level == 0)
									$class = 'mb-4';
								else
									$class = 'mb-2';?>

								<div class="row <?=$class?>">
								<div class="user_image col-3 col-sm-2 col-md-1">
									<div <?=$ava_class?> style="background-image:url(<?= $ava ?>)"></div>
								</div>

								<div class="col-9 col-sm-10 col-md-11"<?php
									if($user_id !== -1)
										echo ' data-user_name="' . $user_name . '"';
									if($user_can_post)
										echo ' data-user_id="' . $user_id . '" data-unix_time="' . $user_comments[$i + 2] . '" data-level="'.$level.'"'; ?>>

											<span><?= $formatted_user_name ?>, <?= \Api\helper::format_date($user_comments[$i + 2], 'friendlify') ?><?php
												if($user_can_post) { ?>,
													<a href="?reply" class="reply_link" title="<?= Language::get('reply', 1) ?>"><?= Language::get('reply') ?></a><?php
												}
												if($user_id == $logged_in_id || $can_edit_comments) { ?>,
													<a href="?delete" class="delete_link" title="<?= Language::get('delete', 1) ?>"><?= Language::get('delete') ?></a> <?php
												}

												?>
											</span>

										<p><?= $comment_text ?></p> <?php

									$next_is_parent = (!array_key_exists($i + 4, $user_comments) || $user_comments[$i + 4] == 0);

									if($level == 1)
										echo '</div></div>';
									if($closed_div == FALSE && $next_is_parent)
										echo '</div></div>';
									if($level == 0 && $next_is_parent) {
										$closed_div = TRUE;
										echo '</div></div>';
									}
									elseif($level == 0 && !$next_is_parent)
										$closed_div = FALSE;

								$i += 4;
							}

						}
						else
							\Api\helper::admin_notify('invalid_comments', json_encode($post_data) . json_encode($user_comments));

					}

					if($user_can_post) {

						if(Data::$main_user === NULL)
							$ava = Site::_DEFAULT_AVA_;
						else
							$ava = Data::$main_user->get_u_ava();

						$is_default_ava = $ava == Site::_DEFAULT_AVA_;
						$ava_class = 'dark_mode_invert';
						if($is_default_ava)
						    $ava_class = '';?>

						<div class="row new_comment_container">
							<div class="user_image col-3 col-sm-2 col-md-1">
								<div class="<?=$ava_class?>" style="background-image:url(<?= $ava ?>)"></div>
							</div>

							<div class="col-9 col-sm-10 col-md-11 textarea_container"><?php

								\Api\helper::input('', '', 'textarea', TRUE, '', '', Fields::get('a_comment'), 'class="comment_content"');

								\Api\helper::input('', '', 'submit', 'btn-dark', Language::get('post_comment', 2), '', '', 'class="mt-2 float-right send_comment btn-outline-dark op-0" disabled'); ?>


							</div>
						</div>

						<script>

							$(function() {

								let reply_box_html = $(".new_comment_container").html();
								let owner_user_name = '<?=(Data::$main_user == NULL) ? '' : Data::$main_user->get_full_name()?>';
								let main_comments_container = $("#main_comments_container");
								let main_textarea = $(".comment_content");


								$(".reply_link").click(function(e) {
									reply_link_click(e);
								});

								function reply_link_click(e) {
									e.preventDefault();

									let container = $(e.target).parent().parent();

									if( container.hasClass("replying") )
										return true;
									container.addClass("replying");
									container.append(`<div class="row mb-2">` + reply_box_html + `</div>`);


									let parent_id = container.attr("data-user_id");
									let unix_time = container.attr("data-unix_time");
									let parent_level = container.attr("data-level");

									if( typeof parent_id === "undefined" || typeof unix_time === "undefined" )
										return true;

									let parameters = [1, parent_id, unix_time, parent_level];


									let textarea = container.find("textarea");
									container.on("input propertychange", textarea, function(e) {
										textarea_changed(e.target);
									});
									textarea.enter_key(function() {
										send_comment($(this).parent(), parameters);
									}, "ctrl");

									let parent_user_name = container.attr("data-user_name");
									if( typeof parent_user_name !== "undefined" && owner_user_name !== "" && owner_user_name !== parent_user_name ){

										textarea.text(parent_user_name + ", ");

										textarea_changed(textarea);
									}

									container.find(".send_comment").click(function() {
										send_comment($(this).parent(), parameters);
									});
								}


								$(".textarea_container").on("input propertychange", ".comment_content", function(e) {
									textarea_changed(e.target);
								});

								function textarea_changed(el) {
									el = $(el);

									if( el.val().length === 0 )
										el.parent().find(".btn").addClass("btn-outline-dark btn-disabled op-0").removeClass("op-1").prop("disabled", true);
									else
										el.parent().find(".btn").removeClass("btn-outline-dark btn-disabled op-0").addClass("op-1").prop("disabled", false);
								}


								main_textarea.enter_key(function() {
									send_comment($(this).parent());
								}, "ctrl");

								$(".send_comment").click(function() {
									send_comment($(this).parent());
								});

								function send_comment(parent, parameters = undefined) {

									let textarea = parent.find("textarea");

									let comment = textarea.val();

									let data;
									if( typeof parameters !== "undefined" )
										data = {
											"comment": comment,
											"level": parameters[0],
											"user_id": parameters[1],
											"unix_time": parameters[2],
											"parent_level": parameters[3],
										};
									else
										data = {
											"comment": comment,
											"level": 0,
										};

									if( comment.length !== 0 )
										$.ajax(
											{
												type: "POST",
												url: '<?=Site::link('post/' . $post_id . '/comment/add/')?>',
												data: data,
											},
										)
											.done(function(msg) {
												msg = JSON.parse(msg);
												if( msg.error !== 0 && msg.error !== "0" ){
													alert(text["error_while_getting_data"]);
													mail_error("Unable to comment. Ajax failed", [msg, data]);
												}

												else {

													textarea.val("");
													textarea_changed(textarea);

													if( data["level"] === 0 ){//if no parent and new 0
														main_comments_container.prepend(msg["comment_html"]);

														main_comments_container.find(".row:first-child .reply_link").click(function(e) {
															reply_link_click(e);
														});
														main_comments_container.find(".row:first-child .delete_link").click(function(e){
															delete_link_click(e);
														});

														main_comments_container.removeClass("replying");
													}

													else if(data["parent_level"] === "1" || data["parent_level"] === 1){//if parent = 1 and new = 1
														let reply_box = parent.parent();
														let closest_parent_comment = reply_box.parent();
														let oldest_parent_comment = closest_parent_comment.parent().parent();//find oldest parent
														reply_box.remove();//remove reply box

														oldest_parent_comment.append(msg["comment_html"]);//insert reply

														oldest_parent_comment.find(".row:last-child .reply_link").click(function(e) {//attack reply_link listener
															reply_link_click(e);
														});

														oldest_parent_comment.find(".row:first-child .delete_link").click(function(e){
															delete_link_click(e);
														});

														closest_parent_comment.removeClass("replying");
													}

													else {//if parent = 0 and new = 1
														let reply_box = parent.parent();
														let comment_parent = reply_box.parent();//find oldest parent
														reply_box.remove();//remove reply box

														comment_parent.append(msg["comment_html"]);//insert reply

														comment_parent.find(".row:last-child .reply_link").click(function(e) {//attack reply_link listener
															reply_link_click(e);
														});

														comment_parent.find(".row:first-child .delete_link").click(function(e){
															delete_link_click(e);
														});

														comment_parent.removeClass("replying");
													}

												}
											})
											.fail(function(xhr, ajaxOptions, thrownError) {
												alert("Виникла помилка при додаванні коментаря. Спробуйте пізніше");
												mail_error("Unable to add comment. Ajax failed", [xhr, ajaxOptions, thrownError]);
											});

								}

								$(".delete_link").click(function(e){
									delete_link_click(e);
								});

								function delete_link_click(e){
									e.preventDefault();

									let comment_parent = $(e.target).parent().parent();

									let data = {
										"user_id": comment_parent.attr("data-user_id"),
										"unix_time": comment_parent.attr("data-unix_time"),
										"level": comment_parent.attr("data-level"),
									};

									$.ajax({
										type: "POST",
										url: '<?=Site::link('post/' . $post_id . '/comment/delete/')?>',
										data: data,
										})
										.done(function(msg) {
											msg = JSON.parse(msg);
											if( msg.error !== 0 && msg.error !== "0" ){
												alert(text["error_while_getting_data"]);
												mail_error("Unable to comment. Ajax failed", [msg, data]);
											}

											else {

												comment_parent.hide().addClass("deleted_comments");

												let comment_header = comment_parent.parent();
												comment_header.append("<div class=\"col-9 col-sm-10 col-md-11\"><textarea class=\"d-none op-0\" disabled>"+msg["restore_info"]+'</textarea><?=Language::get('commented_deleted_1')?><a href="restore_comment" class="restore_comment"><?=Language::get('commented_deleted_2')?></a></div>');

												comment_header.find(".restore_comment").click(function(e){
													e.preventDefault();
													restore_comment(e);
												});

											}
										})
										.fail(function(xhr, ajaxOptions, thrownError) {
											alert("Виникла помилка при видалені коментаря. Спробуйте пізніше");
											mail_error("Unable to delete comment. Ajax failed", [xhr, ajaxOptions, thrownError]);
										});
								}

								function restore_comment(e){
									let container = $(e.target).parent();
									let restore_info = container.find("textarea").val();
									let hidden_container = container.parent().find(".deleted_comments");

									container.remove();

									hidden_container.show();
									hidden_container.removeClass("deleted_container");

									let data = {"restore_info":restore_info};

									$.ajax({
										type: "POST",
										url: '<?=Site::link('post/' . $post_id . '/comment/restore/')?>',
										data: data,
										})
										.fail(function(xhr, ajaxOptions, thrownError) {
											alert("Виникла помилка при відновленні коментаря");
											mail_error("Unable to recover comment. Ajax failed", [xhr, ajaxOptions, thrownError]);
										});
								}


							});

						</script><?php

					} ?>

				</div>
			</div> <?php

		}


		return TRUE;
	}

	public static function actionCommentAdd() {

		global $sql;

		if(Site::$comments == 0) {
			echo json_encode(['error' => 1, 'msg' => 'commenting_prohibited']);
			return FALSE;
		}

		if(!Site::$allow_anonymous_comments && Data::$main_user == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'not_logged_in']);
			return FALSE;
		}

		if(!array_key_exists('comment', $_POST) || !array_key_exists('level', $_POST) || !is_numeric($_POST['level']) || !in_array($_POST['level'], [0, 1])) {
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment ($_POST)']);
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_comments = NULL;
		$unix_time = $_SERVER['REQUEST_TIME'];
		$level = $_POST['level'];

		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_comments = $sql->r('SELECT `comments` FROM `dposts` WHERE `id` = ?', $post_id);
		}

		if($post_comments == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'post_not_found']);
			return FALSE;
		}

		if(array_key_exists('comments', $post_comments) && strlen($post_comments['comments']) > 0)
			$comments = json_decode($post_comments['comments'], TRUE);
		else {
			$post_comments = '';
			$comments = '';
		}


		if(is_array($comments))
			$user_comments = \Api\helper::safeGet('user_comments', $comments, '');
		else
			$user_comments = '';

		$user_comments = explode('~', $user_comments);

		$comments_count = count($user_comments);

		if($comments_count == 1 && $user_comments[0] == '') {
			unset($user_comments[0]);
			$comments_count = 0;
		}

		if($comments_count % 4 !== 0) {
			\Api\helper::admin_notify('invalid_comments', json_encode($user_comments) . json_encode($post_comments) . json_encode($_POST) . json_encode($args));

			echo json_encode(['error' => 1, 'msg' => 'invalid_comment (c%4!==0)']);
			return FALSE;
		}

		$comment_text = trim($_POST['comment']);

		if(!is_string($comment_text) || strlen($comment_text) == 0) {
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment (no comment text)']);
			return FALSE;
		}

		$comment_text = str_replace(['`', '~'], ['`q', '`t'], $comment_text);

		if(Data::$main_user === NULL){
			$user_id = -1;
			$user_name = Language::get('anonymous');
		}
		else {
			$user_id = Data::$main_user->get('id');
			$user_name = Data::$main_user->get_full_name();
		}

		if(Data::$main_user == NULL || !in_array(Data::$main_user->get('type'),[2,3,5])) {
			$admin_emails = $sql->res2data($sql->a('SELECT `email`,`parameters` FROM `dusers` WHERE `type` IN (2,3,5)'));
			$mail_content = mail::content(Language::get('new_comment'), Language::get('new_comment') . '<br><br>Comment creator name: '.$user_name.'<br>Used id: '.$user_id.'<br>Time of posting: '.\Api\helper::format_date($unix_time,'friendlify').'<br>Comment text: '.$comment_text.'<br><br><a href="' . Site::link('post/view/' . $post_id) . '">'.Language::get('view_post').'</a>');
			foreach($admin_emails as $data) {
				$parameters = json_decode($data['parameters'], TRUE);
				if(\Api\helper::safeGet('mail_subscribed', $parameters, "false") !== "false")
					mail::send(Language::get('new_comment'), $mail_content, Site::_EMAIL_, $data['email']);
			}
		}


		if($level == 1) {
			if(!array_key_exists('user_id', $_POST) || !array_key_exists('unix_time', $_POST) || !array_key_exists('parent_level', $_POST)) {
				echo json_encode(['error' => 1, 'msg' => 'invalid_comment (no user_id || unix_time || parent_level)']);
				return FALSE;
			}

			$parent_user_id = $_POST['user_id'];
			$parent_unix_time = $_POST['unix_time'];
			$parent_level = $_POST['parent_level'];
			$parent_comment_position = FALSE;

			for($i = 0; $i < $comments_count;) {

				if($user_comments[$i] == $parent_level && $user_comments[$i + 1] == $parent_user_id && $user_comments[$i + 2] == $parent_unix_time) {
					$parent_comment_position = $i;
					break;
				}

				$i += 4;
			}

			if($parent_comment_position === FALSE) {
				echo json_encode(['error' => 1, 'msg' => 'invalid_comment(father not found)']);
				return FALSE;
			}

			$last_parent_reply = $parent_comment_position;

			for(; $last_parent_reply < $comments_count;) {

				if($user_comments[$last_parent_reply] == 0) {
					$last_parent_reply += 4;
					break;
				}

				$last_parent_reply += 4;

			}

			$user_ids = [$user_id];

			for($i = $parent_comment_position;$i<$last_parent_reply;$i+=4){
				if($user_comments[$i+1] != -1)
					$user_ids[] = $user_comments[$i+1];
			}

			$user_ids = array_unique($user_ids);
			$user_ids = array_slice($user_ids,1);

			if(count($user_ids) > 0){
				$t_data = $sql->res2data($sql->a('SELECT parameters,email FROM dusers WHERE id IN ('.implode($user_ids,',').') AND type NOT IN (2,3,5)'));
				$mail_content = mail::content(Language::get('new_comment'), Language::get('new_comment') . '<br><br>Comment creator name: '.$user_name.'<br>Time of posting: '.\Api\helper::format_date($unix_time,'friendlify').'<br>Comment text: '.$comment_text.'<br><br><a href="' . Site::link('post/view/' . $post_id) . '">'.Language::get('view_post').'</a>');

				foreach($t_data as $t_data_row){
					$parameters = json_decode($t_data_row['parameters'], TRUE);
					if(\Api\helper::safeGet('mail_subscribed', $parameters, "false") !== "false")
						mail::send(Language::get('new_comment'), $mail_content, Site::_EMAIL_, $t_data_row['email']);
				}
			}

			array_splice($user_comments, $last_parent_reply, 0, [1, $user_id, $unix_time, $comment_text]);

		}
		else
			$user_comments = array_merge([0, $user_id, $unix_time, $comment_text], $user_comments);

		$user_comments = implode('~', $user_comments);

		if(is_array($comments))
			$comments['user_comments'] = $user_comments;
		else {
			$comments = [];
			$comments['user_comments'] = $user_comments;
		}
		$post_comments = json_encode($comments);


		$sql->a('UPDATE `dposts` SET `comments`=? WHERE `id`=?', $post_comments, $post_id);


		$formatted_user_name = '';

		if($user_id == -1) {
			$user_name = Language::get('anonymous');
			$ava = Site::_DEFAULT_AVA_;
		}

		else {
			$user_type = Data::$main_user->get('type');

			if($user_type == 7)
				$user_name = Language::get('user_deleted');
			elseif($user_type == 6)
				$user_name = Language::get('user_banned');
			else {
				$user_name = Data::$main_user->get_full_name();
				$formatted_user_name = '<a href="' . Site::$link . 'profile/@' . Data::$main_user->get('login') . '">' . $user_name . '</a>';
			}

			$ava = Data::$main_user->get_u_ava();
		}

		$is_default_ava = $ava == Site::_DEFAULT_AVA_;
		$ava_class = 'dark_mode_invert';
		if($is_default_ava)
		    $ava_class = '';

		if($formatted_user_name == '')
			$formatted_user_name = $user_name;

		$data_user_name = '';
		if($user_id !== -1)
			$data_user_name = ' data-user_name="' . $user_name . '"';

		if($level == 0)
			$container_class = 'mb-4';
		else
			$container_class = 'mb-2';

		$comment_html = '<div class="row '.$container_class.'">
			<div class="user_image col-3 col-sm-2 col-md-1">
				<div class="'.$ava_class.'" style="background-image:url(' . $ava . ')"></div>
			</div>

			<div class="col-9 col-sm-10 col-md-11" data-user_id="' . $user_id . '" data-unix_time="' . $unix_time . '" data-level="'.$level.'" ' . $data_user_name . '>
			
				<span>' . $formatted_user_name . ', ' . \Api\helper::format_date($unix_time, 'friendlify') . ',
						<a href="?reply" class="reply_link" title="' . Language::get('reply', 1) . '">' . Language::get('reply') . '</a>,
						<a href="?delete" class="delete_link" title="' . Language::get('delete', 1) . '">' . Language::get('delete') . '</a>
				</span>

				<p>' . $comment_text . '</p>


			</div>
		</div>';

		echo json_encode(['error' => 0, 'comment_html' => $comment_html]);
		return TRUE;
	}

	public static function actionCommentDelete() {

		global $sql;

		if(!array_key_exists('user_id', $_POST) || !is_numeric($_POST['user_id']) || !array_key_exists('unix_time', $_POST) || !is_numeric($_POST['unix_time']) || !array_key_exists('level', $_POST) || !in_array($_POST['level'], [0, 1])) {
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment ($_POST)']);
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_comments = NULL;

		$user_id = $_POST['user_id'];
		$unix_time = $_POST['unix_time'];
		$level = $_POST['level'];


		if((!Site::$allow_anonymous_comments && Data::$main_user == NULL) || (Data::$main_user !== NULL && Data::$main_user->get('id') != $user_id)) {
			echo json_encode(['error' => 1, 'msg' => 'not_logged_in']);
			return FALSE;
		}


		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_comments = $sql->r('SELECT `comments` FROM `dposts` WHERE `id` = ?', $post_id);
		}

		if($post_comments == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'post_not_found']);
			return FALSE;
		}

		if(!array_key_exists('comments', $post_comments) || strlen($post_comments['comments']) == 0){
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment (post has no comments)']);
			return FALSE;
		}


		$comments = json_decode($post_comments['comments'], TRUE);
		$user_comments = \Api\helper::safeGet('user_comments', $comments, '');

		$user_comments = explode('~', $user_comments);
		$comments_count = count($user_comments);

		if(!is_array($comments) || ($comments_count == 1 && $user_comments[0] == '')){
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment(post has no comments)']);
			return FALSE;
		}

		if($comments_count % 4 !== 0) {
			\Api\helper::admin_notify('invalid_comments', json_encode($user_comments) . json_encode($post_comments) . json_encode($_POST) . json_encode($args));

			echo json_encode(['error' => 1, 'msg' => 'invalid_comment (c%4!==0)']);
			return FALSE;
		}

		$cut_from = FALSE;

		for($i = 0; $i < $comments_count;) {

			if($user_comments[$i] == $level && $user_comments[$i + 1] == $user_id && $user_comments[$i + 2] == $unix_time) {
				$cut_from = $i;
				break;
			}

			$i += 4;
		}

		if($cut_from === FALSE) {
			echo json_encode(['error' => 1, 'msg' => 'invalid_comment(father not found)']);
			return FALSE;
		}

		if($level == 1 || $cut_from==$comments_count || ($cut_from+4<$comments_count && $user_comments[$cut_from+4] == 0))
			$cut_to=$cut_from+4;
		else {

			$cut_to = $cut_from+4;

			for(; $cut_to < $comments_count;$cut_to += 4)
				if($user_comments[$cut_to] == 0)
					break;

		}

		$restore_info = array_splice($user_comments,$cut_from,$cut_to-$cut_from,[]);

		$user_comments = implode('~', $user_comments);
		$restore_info = implode('~', $restore_info);

		if(is_array($comments))
			$comments['user_comments'] = $user_comments;
		else {
			$comments = [];
			$comments['user_comments'] = $user_comments;
		}
		$post_comments = json_encode($comments);


		$sql->a('UPDATE `dposts` SET `comments`=? WHERE `id`=?', $post_comments, $post_id);

		$recovery_name = \Api\helper::random_str(10);
		$_SESSION['c_'.$recovery_name] = $cut_from.'~'.$restore_info;

		$t_prepend = '';
		if(array_key_exists('comments_restore_info',$_COOKIE))
			$t_prepend = $_COOKIE['comments_restore_info'].'~';
		setcookie('comments_restore_info',$t_prepend.'c_'.$recovery_name.'`'.$_SERVER['REQUEST_TIME'],time()+20*86400,'/');

		echo json_encode(['error' => 0, 'restore_info' => 'c_'.$recovery_name]);
		return TRUE;
	}

	public static function actionCommentRestore() {

		global $sql;

		if(!array_key_exists('restore_info', $_POST)) {
			echo json_encode(['error' => 1, 'msg' => 'invalid recovery info ($_POST)']);
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_comments = NULL;

		if(!Site::$allow_anonymous_comments && Data::$main_user == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'not_logged_in']);
			return FALSE;
		}


		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_comments = $sql->r('SELECT `comments` FROM `dposts` WHERE `id` = ?', $post_id);
		}

		if($post_comments == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'post_not_found']);
			return FALSE;
		}


		$comments = json_decode($post_comments['comments'], TRUE);
		$user_comments = \Api\helper::safeGet('user_comments', $comments, '');

		$user_comments = explode('~', $user_comments);
		$comments_count = count($user_comments);

		if(!is_array($comments) || $comments_count == 1 && $user_comments[0] == ''){
			unset($user_comments[0]);
			$comments_count = 0;
		}

		if($comments_count % 4 !== 0) {
			\Api\helper::admin_notify('invalid_comments', json_encode($user_comments) . json_encode($post_comments) . json_encode($_POST) . json_encode($args));

			echo json_encode(['error' => 1, 'msg' => 'invalid_comment (c%4!==0)']);
			return FALSE;
		}


		$restore_info_name = $_POST['restore_info'];
		$restore_info = $_SESSION[$restore_info_name];

		$needle_position = strpos($restore_info,'~');
		$insert_from = substr($restore_info,0,$needle_position);

		$restore_info = substr($restore_info,$needle_position+1);
		$restore_info = explode('~', $restore_info);

		array_splice($user_comments,$insert_from,0,$restore_info);

		$user_comments = implode('~', $user_comments);

		if(is_array($comments))
			$comments['user_comments'] = $user_comments;
		else {
			$comments = [];
			$comments['user_comments'] = $user_comments;
		}
		$post_comments = json_encode($comments);


		$sql->a('UPDATE `dposts` SET `comments`=? WHERE `id`=?', $post_comments, $post_id);

		unset($_SESSION[$restore_info_name]);

		echo json_encode(['error' => 0]);
		return TRUE;
	}

	public static function actionReview() {

		global $sql;

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/posts' . Data::$css_ext) . '">');
		MainController::actionHeader();

		if(Data::$main_user == NULL) {
			\Api\helper::alert(Language::get('not_logged_to_login', 2), 'danger');
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_data = NULL;
		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_data = $sql->r('SELECT `p`.`name`,`p`.`content`,`p`.`keywords`,`p`.`description`,`p`.`creator_id`,`p`.`comments`,`p`.`src`,`c`.`class` AS "class", `c`.`id` AS "category_id",`c`.`name` AS "category_name",`t`.`id` AS "theme_id",`t`.`name` AS "theme_name" FROM `dposts` `p` INNER JOIN `dcategories` `c` ON `c`.`id` = `p`.`category_id` INNER JOIN `dcategories` `t` ON `t`.`id` = `p`.`theme_id` WHERE `p`.`id` = ?', $post_id);
		}

		if($post_data == NULL) {
			\Api\helper::alert(Language::get('post_not_found', 2), 'danger');
			return FALSE;
		}

		if($post_data['creator_id'] != Data::$main_user->get('id')) {
			\Api\helper::alert(Language::get('not_your_post', 2), 'danger');
			return FALSE;
		}

		$comments = json_decode($post_data['comments'], TRUE);
		$comments['edit'] = (array)$comments['edit'];

		if(array_key_exists('class', $comments['edit'])) {
			if($comments['edit']['class'] == -1)
				$old_class = Language::get('graduated');
			elseif($comments['edit']['class'] == 0)
				$old_class = Language::get('class_all');
			else
				$old_class = $comments['edit']['class'];

			if($post_data['class'] == -1)
				$new_class = Language::get('graduated');
			elseif($post_data['class'] == 0)
				$new_class = Language::get('class_all');
			else
				$new_class = $post_data['class']; ?>

			<div class="section mb-4">
				<h2 class="header" title="<?= Language::get('class', 1) ?>"><?= Language::get('class') ?></h2>
				<p class="old"><?= $old_class ?></p>
				<p class="new"><?= $new_class ?></p>
			</div> <?php
		}

		if(array_key_exists('category_name', $comments['edit'])) {
			$new_category_name = $post_data['category_name'];

			if($comments['edit']['category_name'] != $new_category_name) { ?>
				<div class="section mb-4">
					<h2 class="header" title="<?= Language::get('category', 1) ?>"><?= Language::get('category') ?></h2>
					<p class="old"><?= $comments['edit']['category_name'] ?></p>
					<p class="new"><?= $new_category_name ?></p>
				</div> <?php
			}
		}

		if(array_key_exists('theme_name', $comments['edit'])) {
			$new_theme_name = $post_data['theme_name'];

			if($comments['edit']['theme_name'] != $new_theme_name) { ?>
				<div class="section mb-4">
					<h2 class="header" title="<?= Language::get('theme', 1) ?>"><?= Language::get('theme') ?></h2>
					<p class="old"><?= $comments['edit']['theme_name'] ?></p>
					<p class="new"><?= $new_theme_name ?></p>
				</div> <?php
			}
		}

		if(array_key_exists('src', $comments['edit'])) { ?>
			<div class="section mb-4">
				<h2 class="header" title="<?= Language::get('src', 1) ?>"><?= Language::get('src') ?></h2>
				<p class="old">
					<?= $comments['edit']['src'] ?>
					<img class="src_preview zoomable" src="<?= $comments['edit']['src'] ?>" alt="<?= Language::get('src') ?>">
				</p>
				<p class="new">
					<?= $post_data['src'] ?>
					<img class="src_preview zoomable" src="<?= $post_data['src'] ?>" alt="<?= Language::get('src') ?>">
				</p>
			</div> <?php
		}

		$t_vars_to_check = ['keywords', 'description', 'name'];
		foreach($comments['edit'] as $key => $value) {
			if(in_array($key, $t_vars_to_check)) { ?>
				<div class="section mb-4">
					<h2 class="header" title="<?= Language::get($key, 1) ?>"><?= Language::get($key) ?></h2>
					<?= \Api\helper::html_diff($value, $post_data[$key], 'divs') ?>
				</div> <?php
			}
		}

		if(array_key_exists('content', $comments['edit'])) {
			$new_content = \Api\helper::html2text($post_data['content']);
			if($new_content == $comments['edit']['content'])
				$new_content = Language::get('formatting_changed');
			else
				$new_content = \Api\helper::html_diff($comments['edit']['content'], $new_content, 'divs') ?>

			<div class="section mb-4">
				<h2 class="header" title="<?= Language::get('content', 1) ?>"><?= Language::get('content') ?></h2>
				<p><?= $new_content ?></p>
			</div> <?php
		}

		if(count($comments['edit']) == 0) { ?>
			<h1 class="mb-4" title="<?= Language::get('no_changes_made', 1) ?>"><?= Language::get('no_changes_made') ?></h1><?php
		}

		if(array_key_exists('teacher_comment', $comments)) { ?>
			<div class="section mb-4">
				<h2 class="header" title="<?= Language::get('teacher_comment', 1) ?>"><?= Language::get('teacher_comment') ?></h2>
				<p><?= $comments['teacher_comment'] ?></p>
			</div> <?php
		} ?>

		<div class="btn-group">
			<a href="<?= Site::link('post/delete/' . $post_id) ?>" class="btn btn-danger" title="<?= Language::get('delete_post', 1) ?>"><?= Language::get('delete_post') ?></a>
			<a href="<?= Site::link('post/view/' . $post_id) ?>" class="btn btn-dark" title="<?= Language::get('view_post', 1) ?>"><?= Language::get('view_post') ?></a>
			<a href="<?= Site::link('post/edit/' . $post_id) ?>" class="btn btn-dark" title="<?= Language::get('edit', 1) ?>"><?= Language::get('edit') ?></a>
			<button id="accept" type="button" class="btn btn-success" title="<?= Language::get('accept_edit', 1) ?>"><?= Language::get('accept_edit') ?></button>
		</div>

		<script>
			$("#accept").click(function() {
				$.ajax({
					method: "POST",
					url: site_url + 'post/accept/<?=$post_id?>',
				}).done(function(msg) {
					msg = JSON.parse(msg);
					if( msg.error !== 0 && msg.error !== "0" ){
						alert(text["error_while_getting_data"]);
						mail_error("Unable to accept changes. Ajax failed", [msg, sorting_data]);
					}
					else
						window.location.href = "<?=Site::link('author/' . Data::$main_user->get('id'))?>";
				});
			});
		</script><?php

		return TRUE;
	}

	public static function actionGetCategories() {

		global $sql;

		$args = func_get_args();
		if(!array_key_exists(0, $args) || !is_numeric($args[0])) {
			echo json_encode(['error' => 1, 'msg' => 'No class specified!']);
			exit();
		}

		$class = $args[0];

		if(!in_array($class, [-1, 0, 5, 6, 7, 8, 9, 10, 11])) {
			echo json_encode(['error' => 1, 'msg' => 'Invalid class!']);
			exit();
		}

		$categories_data = ['error' => 0];
		$res = $sql->a('SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 0 AND `name`!="todas"',
		$class);
		$stmt = $sql->p(FALSE, 'SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 1', 0);

		while($row = \Api\sql::fetch($res))
			$categories_data[$row['id']] = ["name" => $row['name']] + \Api\helper::reindex_array($sql->res2data($sql->b([$row['id']], 1, $stmt)), -1);

		echo json_encode($categories_data);
	}

	public static function actionAccept() {

		global $sql;

		if(Data::$main_user == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'not_logged_in']);
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_data = NULL;

		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_data = $sql->r('SELECT `creator_id`,`comments` FROM `dposts` WHERE `id` = ?', $post_id);
		}

		if($post_data == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'post_not_found']);
			return FALSE;
		}

		if($post_data['creator_id'] != Data::$main_user->get('id')) {
			echo json_encode(['error' => 1, 'msg' => 'not_your_post']);
			return FALSE;
		}

		$comments = json_decode($post_data['comments'], TRUE);
		unset($comments['edit']);
		unset($comments['teacher_comment']);
		$comments = json_encode($comments);

		$sql->a('UPDATE `dposts` SET `comments`=? WHERE `id`=?', $comments, $post_id);
		echo json_encode(['error' => 0]);
		return TRUE;
	}

	//private

	public static function actionDelete() {

		global $sql;

		if(Data::$main_user == NULL) {
			\Api\Helper::redirect('login');
			return FALSE;
		}

		if(Site::$users_can_post === FALSE && !in_array(Data::$main_user->get('type'), [2, 3, 5])) {
			\Api\helper::alert(Language::get('access_denied', 2), 'danger');
			return FALSE;
		}

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/posts' . Data::$css_ext) . '">');
		MainController::actionHeader();

		$is_teacher = in_array(Data::$main_user->get('type'), [2, 3, 5]);

		$args = func_get_args();
		if(count($args) != 1 || !is_numeric($args[0]) || $args[0] < 0) {
			header('Location: ' . Site::$link);
			return FALSE;
		}
		$post_id = $args[0];
		$post_data = $sql->r('SELECT `name`,`creator_id` FROM `dposts` WHERE `id` = ?', $post_id);
		if($post_data == NULL) {
			\Api\helper::alert(Language::get('post_not_found', 2), 'danger');
			return FALSE;
		}

		if(!$is_teacher && $post_data['creator_id'] != Data::$main_user->get('id')) {
			\Api\helper::alert(Language::get('access_denied', 2), 'danger');
			return FALSE;
		} ?>

		<h1 class="mb-4" title="<?= Language::get('delete_post_confirmation', 1) ?>"><?= Language::get('delete_post_confirmation') ?></h1>

		<p><?= $post_data['name'] ?></p>

		<a href="<?= Site::link('post/view/' . $post_id) ?>" class="btn btn-dark" title="<?= Language::get('no', 1) ?>"><?= Language::get('no') ?></a>
		<button id="delete_post" class="btn btn-danger" title="<?= Language::get('yes', 1) ?>"><?= Language::get('yes') ?></button>

		<script>
			$("#delete_post").click(function() {
				$.ajax({
					method: "POST",
					url: site_url + 'post/deleted/<?=$post_id?>',
				}).done(function(msg) {
					msg = JSON.parse(msg);
					if( msg.error !== 0 && msg.error !== "0" ){
						alert(text["error_while_getting_data"]);
						mail_error("Unable to accept changes. Ajax failed", [msg, sorting_data]);
					}
					else
						window.location.href = "<?=Site::link('author/' . Data::$main_user->get('id'))?>";
				});
			});
		</script><?php

		return TRUE;
	}

	public static function actionDeleted() {

		global $sql;

		if(Data::$main_user == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'not_logged_in']);
			return FALSE;
		}

		$args = func_get_args();

		$post_id = NULL;
		$post_data = NULL;

		if(array_key_exists(0, $args) && strlen($args[0]) > 0) {
			$post_id = $args[0];

			$post_data = $sql->r('SELECT `src`,`comments`,`content`,`creator_id` FROM `dposts` WHERE `id` = ?', $post_id);
		}

		if($post_data == NULL) {
			echo json_encode(['error' => 1, 'msg' => 'post_not_found']);
			return FALSE;
		}

		if(!in_array(Data::$main_user->get('type'), [2, 3, 5]) && $post_data['creator_id'] != Data::$main_user->get('id')) {
			echo json_encode(['error' => 1, 'msg' => 'not_your_post']);
			return FALSE;
		}

		$comments = $post_data['comments'];
		$comments = json_decode($comments, TRUE);

		$images_src = [];

		$contents = $post_data['content'];
		if(array_key_exists('edit', $comments)) {

			//edit src
			if(array_key_exists('src', $comments['edit']) && strlen($comments['edit']['src']) > 0 && (strpos($comments['edit']['src'], Site::$domain) !== FALSE || strpos($comments['edit']['src'], 'i.ibb.co') !== FALSE))
				$images_src = array_merge($images_src, [$comments['edit']['src']]);

			$comments['edit'] = (array)$comments['edit'];
			if(array_key_exists('content', $comments['edit']))
				$contents .= $comments['edit']['content'];
		}

		//html content
		error_reporting(0);

		$dom = new DOMDocument();
		$dom->loadHTML($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		$images = $dom->getElementsByTagName('img');
		foreach($images as $img) {
			$t_src = $img->getAttribute('src');

			if(strlen($t_src) > 0 && (strpos($t_src, Site::$domain) !== FALSE || strpos($t_src, 'i.ibb.co') !== FALSE))
				$images_src[] = $t_src;
		}

		if(Site::$development)
			error_reporting(E_ALL);

		//src
		if(array_key_exists('delete', $comments) && count($comments['delete']) > 0)
			$images_src = array_unique($images_src, $comments['delete']);
		elseif(strlen($post_data['src']) > 0 && (strpos($post_data['src'], Site::$domain) !== FALSE || strpos($post_data['src'], 'i.ibb.co') !== FALSE))
			$images_src = array_merge($images_src, [$post_data['src']]);

		$images_src = array_unique($images_src);
		foreach($images_src as $value)
			$images_src = array_unique($images_src, $value);

		\Api\helper::delete_images($images_src,TRUE);

		if(count($images_src) > 0)
			\Api\helper::log(3, 'Delete images: ' . implode('  ', $images_src));
		$sql->a('DELETE FROM `dposts` WHERE `id`=?', $post_id);

		echo json_encode(['error' => 0]);
		return TRUE;
	}

}