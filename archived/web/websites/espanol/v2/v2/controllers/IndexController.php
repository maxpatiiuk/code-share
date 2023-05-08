<?php


use Api\User;

class IndexController{

	public function actionMain(){

		global $sql, $page, $class, $category, $theme, $author, $show_unverified;

		$sorting = func_get_args();
		$param_len = count($sorting);

		Data::formatData("extra",
		                 "assign",
		                 '<link rel="stylesheet" href="' . Site::link('public/css/index' . Data::$css_ext) . '">' . '<script src="' . Site::link('public/scripts/categories' . Data::$js_ext) . '"></script>'
		);
		MainController::actionHeader();

		$page = 1;
		$class = -2;
		$category = -1;
		$theme = -1;
		$author = -1;
		$show_unverified = FALSE;
		for($i = 0; $i < $param_len; $i++){
			if($sorting[$i] == 'class' && $i + 1 < $param_len && is_numeric($sorting[$i + 1]) && $sorting[$i + 1] > 0){
				$class = $sorting[$i + 1];
				$i += 1;
				continue;
			}
			if($sorting[$i] == 'category' && $i + 1 < $param_len && is_numeric($sorting[$i + 1]
				) && $sorting[$i + 1] > 0){
				$category = $sorting[$i + 1];
				$i += 1;
				continue;
			}
			if($sorting[$i] == 'theme' && $i + 1 < $param_len && is_numeric($sorting[$i + 1]) && $sorting[$i + 1] > 0){
				$theme = $sorting[$i + 1];
				$i += 1;
				continue;
			}
			if($sorting[$i] == 'unverified' && $i + 1 < $param_len && $sorting[$i + 1] == "1"){
				$show_unverified = TRUE;
				$i += 1;
				continue;
			}
			if($sorting[$i] == 'author' && $i + 1 < $param_len && preg_match('/\d+|@?[\w\-]{3,60}/', $sorting[$i + 1])){
				$author = $sorting[$i + 1];
				$i += 1;
				continue;
			}
			if(Site::$posts_per_page !== -1 && $sorting[$i] == 'page' && $i + 1 < $param_len && is_numeric($sorting[$i + 1]
				) && $sorting[$i + 1] > 0){
				$page = $sorting[$i + 1];
				$i += 1;
				continue;
			}
		}

		if(!is_numeric($author)){
			if($author[0] == '@')
				$author = substr($author, 1);
			$author = new User($sql->c('SELECT `id` FROM `dusers` WHERE `login` = ?', $author));
		} elseif(Data::$main_user != NULL && $author == Data::$main_user->get('id'))
			$author = &Data::$main_user;
		elseif($author != -1)
			$author = new User($author);
		if(!is_numeric($author) && $author->get('login') == NULL)
			$author = -1;

		if($author instanceof User)
			$author_id = $author->get('id'); else
			$author_id = $author;

		$categories_data = [];

		if($theme != -1 && $category == -1){
			$category_info = $sql->c('SELECT `c`.`id`,`c`.`name`,`c`.`class` FROM `dcategories` `c` WHERE `c`.`id` = (SELECT `t`.`class` FROM `dcategories` `t` WHERE `t`.`id` = ?)',
			                         $theme
			);
			if($category_info == NULL)
				$theme = -1; else {
				$categories_data[$category_info['class']][$category_info['id']] = [$category_info['name']];
				$category = $category_info['id'];
				if($class != $category_info['class'])
					$class = $category_info['class'];
			}
		}

		if($class == -2){
			if($category != -1)
				$class = 0; else {

				$category_info = $sql->c('SELECT `id`,`name`,`class` FROM `dcategories` WHERE `id` = ?', $category);
				if($category_info == NULL){
					$class = 0;
					$category = -1;
					$theme = -1;
				} else {
					$categories_data[$category_info['class']][$category_info['id']] = [$category_info['name']];
					$category = $category_info['id'];
					$class = $category_info['class'];
				}

			}
		}

		if(!array_key_exists($category, $categories_data)){
			$category_name = $sql->c('SELECT `name` FROM `dcategories` WHERE `id` = ?', $category);
			if($category_name == NULL){
				$category = -1;
				$theme = -1;
			} else
				$categories_data[$class][$category] = ["name" => $category_name];
		} elseif(!array_key_exists($theme, $categories_data[$category])) {
			$theme_name = $sql->c('SELECT `name` FROM `dcategories` WHERE `class` = ? AND `type` = 1', $category);
			if($theme_name == NULL)
				$theme = -1; else
				$categories_data[$class][$category][$theme] = $theme_name;
		}

		$res = $sql->a('SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 0', $class);

		$stmt = $sql->p(FALSE, 'SELECT `id`,`name` FROM `dcategories` WHERE `class` = ? AND `type` = 1', 0);

		while($row = \Api\sql::fetch($res))
			$categories_data[$class][$row['id']] = ["name" => $row['name']] + \Api\helper::reindex_array($sql->res2data($sql->b([$row['id']],
			                                                                                                                    1,
			                                                                                                                    $stmt
				)
				),
			                                                                                             -1
				); ?>

		<div class="row">
			<form
					id="search_form"
					class="col-12 col-md-3"> <?php

				if(Data::$main_user !== NULL && (Site::$users_can_post || in_array(Data::$main_user->get('type'),
				                                                                   [2, 3, 5]
						))){
					$new_verified = FALSE;
					$link = Site::link(Main::getLink(NULL, NULL, NULL, Data::$main_user->get('id')));
					if(!in_array(Data::$main_user->get('type'), [2, 3, 5])){
						$comments = $sql->res2data($sql->a('SELECT `comments` FROM `dposts` WHERE `creator_id` = ? AND `verified` = 1',
						                                   Data::$main_user->get('id')
						)
						);
						foreach($comments as $data){
							$json = json_decode($data['comments'], TRUE);
							if($json != NULL && array_key_exists('edit', $json)){
								$new_verified = TRUE;
								break;
							}
						}
					} elseif($sql->c('SELECT COUNT(1) FROM `dposts` WHERE `verified` = 0') > 0) {
						$new_verified = TRUE;
						$link = Site::link(Main::getLink(NULL, NULL, NULL, NULL, TRUE));
					} ?>
					<div class="main_page_btn_group">
						<a
								id="add_post"
								href="<?= Site::link('post/add/') ?>"
								class="main_page_button"
								title="<?= Language::get('add_post', 1) ?>">
							<svg
									xmlns="http://www.w3.org/2000/svg"
									viewBox="0 0 491 491">
								<path d="M465,211H280V26c0-8-11-26-34-26s-34,18-34,26v184H26C18,211,0,223,0,245s18,34,26,34h184v184c0,8,11,26,34,26s34-18,34-26V280H465c8,0,26-11,26-34S473,211,465,211z"></path>
							</svg>
						</a>
						<a
								id="show_posts"
								href="<?= $link ?>"
								class="main_page_button <?php if($new_verified)
									echo 'verified'; ?>"
								title="<?= Language::get('show_posts', 1) ?>">
							<svg
									xmlns="http://www.w3.org/2000/svg"
									viewBox="0 0 24 24">
								<path d="M24,3c0-0-0-1-1-1H1c0,0-1,0-1,1v2c0,0,0,1,1,1h22c0,0,1-0,1-1V3z"></path>
								<path d="M24,11c0-0-0-1-1-1H1c0,0-1,0-1,1v2c0,0,0,1,1,1h22c0,0,1-0,1-1V11z"></path>
								<path d="M24,19c0-0-0-1-1-1H1c0,0-1,0-1,1v2c0,0,0,1,1,1h22c0,0,1-0,1-1V19z"></path>
							</svg>
						</a>
					</div> <?php
				}

				$categories = [[-1, Language::get('all')]];
				$t_active_exist = FALSE;
				if(array_key_exists($class, $categories_data)){//$class != -2) {     //or 0
					foreach($categories_data[$class] as $key => $value){
						if($key == 'name' || $value['name'] == 'Todas')
							continue;
						$categories[] = [$key, $value['name']];
						if($key == $category && !$t_active_exist){
							$categories[count($categories) - 1][2] = 1;
							$t_active_exist = TRUE;
						}
					}
				}
				if(!$t_active_exist)
					$categories[0][2] = 1;

				$themes = [[-1, Language::get('all')]];
				$t_active_exist = FALSE;
				if(array_key_exists($class, $categories_data) && $category != -1){
					foreach($categories_data[$class][$category] as $key => $value){
						if($key == 'name' || $value['name'] == 'Todas')
							continue;
						$themes[] = [$key, $value];
						if($key == $theme && !$t_active_exist){
							$themes[count($themes) - 1][2] = 1;
							$t_active_exist = TRUE;
						}
					}
				}
				if(!$t_active_exist)
					$themes[0][2] = 1;


				if(Site::$use_classes){
					$classes = [[0, Language::get('all')], [5, 5], [6, 6], [7, 7], [8, 8], [9, 9], [10, 10], [11, 11], [-1, Language::get('graduated')],
					];
					if($class == 0)
						$classes[0][2] = 1; elseif($class == -1)
						$classes[count($classes) - 1][2] = 1;
					elseif($class >= 5 && $class <= 11)
						$classes[$class - 4][2] = 1;

					\Api\helper::input(Language::get('class', 2),
					                   'class',
					                   'select',
					                   TRUE,
					                   $classes,
					                   '',
					                   Fields::get('rclass')
					);
				}
				\Api\helper::input(Language::get('category', 2),
				                   'category',
				                   'select',
				                   TRUE,
				                   $categories,
				                   '',
				                   Fields::get('a_category')
				);
				\Api\helper::input(Language::get('theme', 2),
				                   'theme',
				                   'select',
				                   TRUE,
				                   $themes,
				                   '',
				                   Fields::get('a_theme')
				);
				\Api\helper::input('', 'author', 'hidden', FALSE, $author_id);
				\Api\helper::input(NULL,
				                   'submit',
				                   'submit',
				                   'btn-outline-dark',
				                   Language::get('search', 2),
				                   '',
				                   '',
				                   'type="button"'
				); ?>

				<script>

					$( "#search_form" ).submit( function ( e ) {
						e.preventDefault();

						let v_class = $( "#a2class" ).val();
						let v_category = $( "#a2category" ).val();
						let v_theme = $( "#a2theme" ).val();
						let v_author = $( "#a2author" ).val();

						if ( $.isNumeric( v_class ) && v_class !== "0" )
							v_class = "class/" + v_class + "/";
						else
							v_class = "";
						if ( $.isNumeric( v_category ) && v_category !== "-1" )
							v_category = "category/" + v_category + "/";
						else
							v_category = "";
						if ( $.isNumeric( v_theme ) && v_theme !== "-1" )
							v_theme = "theme/" + v_theme + "/";
						else
							v_theme = "";
						if ( $.isNumeric( v_author ) && v_author !== "-1" )
							v_author = "author/" + v_author + "/";
						else
							v_author = "";

						window.location.href = '<?=Site::link()?>' + v_class + v_category + v_theme + v_author;
					} );

					let current_class = <?=$class?>;
					let sorting_data = JSON.parse( '<?=json_encode($categories_data)?>' );

					let class_field = $( "#a2class" );
					let category_field = $( "#a2category" );
					let theme_field = $( "#a2theme" );
				</script>

			</form>
			<div class="col-12 col-md-9">
				<div id="posts_container"> <?php

					$display_verified = Data::$main_user !== NULL && Site::$users_can_post && !in_array(Data::$main_user->get('type'
						),
					                                                                                    [2, 3, 5]
						);//users can post and user is not admin but is logged in
					$display_unverified = $display_verified && $author_id == Data::$main_user->get('id'
						);//1 and selected author is logged in
					$teacher_display_unverified = Data::$main_user !== NULL && in_array(Data::$main_user->get('type'),
					                                                                    [2, 3, 5]
						);//is admin
					$teacher_display_only_unverified = $teacher_display_unverified && $show_unverified;////3 and unverified/1 in URL

					if($author_id != -1){ ?>
						<div><h1 title="<?= Language::get('post_created_by', 1) ?>"><?= Language::get('post_created_by'
								) ?>
								<a
										class="gray_link"
										href="<?= Site::link('profile/@' . $author->get('login')
										) ?>"><?= $author->get_full_name() ?></a>
							</h1></div> <?php
					}


					$query = 'SELECT p.id,p.name,p.src,p.created_unix';

					if($display_verified)
						$query .= ',p.comments';
					if($display_unverified || ($teacher_display_unverified && !$show_unverified))
						$query .= ',p.verified';
					if($class == 0)
						$query .= ',c.class';
					if($category == -1)
						$query .= ',c.id AS "category_id",c.name AS "category_name"';
					if($theme == -1)
						$query .= ',t.id AS "theme_id",t.name AS "theme_name"';
					if($author_id == -1)
						$query .= ',p.creator_id';

					$query_part = ' FROM dposts p LEFT JOIN dcategories c ON c.id = p.category_id LEFT JOIN dcategories t ON t.id = p.theme_id WHERE';

					if(!$display_unverified && !$teacher_display_only_unverified)
						$query_part .= ' p.verified = 1'; elseif($teacher_display_only_unverified)
						$query_part .= ' p.verified = 0';
					else
						$query_part .= ' 1=1';


					if($class != 0)
						$query_part .= ' AND c.class = ' . $class;
					if($category != -1)
						$query_part .= ' AND c.id = ' . $category;
					if($theme != -1)
						$query_part .= ' AND t.id = ' . $theme;
					if($author_id != -1)
						$query_part .= ' AND p.creator_id = ' . $author_id;

					$query .= $query_part . ' ORDER BY p.`created_unix` DESC';

					$local_posts_per_page = Site::$posts_per_page;
					if($author_id != -1)
						$local_posts_per_page--;

					if(Site::$posts_per_page !== -1)
						$query .= ' LIMIT ' . $local_posts_per_page;
					if(Site::$posts_per_page !== -1 && $page != -1)
						$query .= ' OFFSET ' . ($page - 1) * $local_posts_per_page;


					$posts = $sql->res2data($sql->a($query));

					if($posts == FALSE)
						$posts = [];

					if(count($posts) == 0){
						echo '<div class="col">';
						\Api\helper::alert(Language::get('no_posts_found', 2), 'warning');
						echo '</div>';
					}


					foreach($posts as $post){

						$post_info = \Api\helper::format_date($post['created_unix'], 'friendlify');

						if(array_key_exists('creator_id', $post)){

							$post_info .= ', ';

							if(Data::$main_user != NULL && $post['creator_id'] == Data::$main_user->get('id')){
								$user_login = Data::$main_user->get('login');
								$user_name = Data::$main_user->get_full_name();
							} else {
								$user = new User($post['creator_id']);
								$user_login = $user->get('login');
								$user_name = $user->get_full_name();
							}

							$post_info .= '<a href="' . Site::$link . 'author/@' . $user_login . '">' . $user_name . '</a>';
						}

						if(Site::$use_classes && array_key_exists('class', $post)){
							$post_info .= ', <a href="' . Site::$link . 'class/' . $post['class'] . '">';

							if($post['class'] == 0)
								$post_info .= Language::get('all') . ' ' . Language::get('classes'); elseif($post['class'] == -1)
								$post_info .= Language::get('graduated');
							else
								$post_info .= $post['class'] . ' ' . Language::get('class');

							$post_info .= '</a>';
						}

						if(array_key_exists('category_id',
						                    $post
						   ) && $post['category_name'] != 'Todas' && $post['category_id'] != NULL){
							$post_info .= ', <a href="' . Site::$link;

							if(array_key_exists('class', $post))
								$post_info .= 'class/' . $post['class']; else
								$post_info .= 'class/' . $class;

							$post_info .= '/category/' . $post['category_id'] . '">' . $post['category_name'] . '</a>';
						}

						if($post['theme_name'] != 'Todas' && array_key_exists('theme_id', $post) && $post['theme_id'] != NULL){
							$post_info .= ', <a href="' . Site::$link;

							if(array_key_exists('class', $post))
								$post_info .= 'class/' . $post['class'] . '/'; else
								$post_info .= 'class/' . $class . '/';

							if(array_key_exists('category_name', $post))
								$post_info .= 'category/' . $post['category_id'] . '/'; else
								$post_info .= 'category/' . $category . '/';

							$post_info .= 'theme/' . $post['theme_id'] . '">' . $post['theme_name'] . '</a>';
						}

						if(strlen($post['src'])){
							$esc = 'background: url(' . $post['src'] . ') no-repeat center/contain var(';
							if($_SESSION['dark_theme'] == 0)
								$esc .= '--b2)'; else
								$esc .= '--t2)';
						} else
							$esc = 'filter:hue-rotate(' . substr($post['created_unix'],
							                                     -2
								) . '0deg);background: url(' . Site::link('public/images/textures/t' . rand(1,
							                                                                                8
								                                          ) . '.svg'
								) . ') repeat, linear-gradient(to right, var(--gradient-color_2), var(--gradient-color_1))';

						$link = Site::link('post/view/' . $post['id']);
						$link_class = '';
						if(array_key_exists('comments', $post))
							$comments = json_decode($post['comments'],
							                        TRUE
							); else
							$comments = '';

						if($display_unverified && $post['verified'] == 0){
							$link_class = 'class="unverified"';
							$link = Site::link('post/edit/' . $post['id']);
						} elseif($display_verified && $comments != '' && array_key_exists('edit', $comments)) {
							$link_class = 'class="verified"';
							$link = Site::link('post/review/' . $post['id']);
						} elseif($teacher_display_unverified && ($teacher_display_only_unverified || $post['verified'] == 0)) {
							$link_class = 'class="verified"';
							$link = Site::link('post/edit/' . $post['id']);
						} ?>

						<div class="post">
							<a
									class="esc dark_mode_invert"
									href="<?= Site::link('post/view/' . $post['id']) ?>"
									style="<?= $esc ?>"></a>
							<a href="<?= $link ?>" <?= $link_class ?>><h2><?= $post['name'] ?></h2></a>
							<span class="d-block"><?= $post_info ?></span>
						</div> <?php

					} ?>

				</div> <?php


				try {
					if($local_posts_per_page == -1)
						throw new Exception();

					$simple_query = 'SELECT COUNT(1)' . $query_part;

					$posts_count = $sql->c($simple_query);
					if($posts_count <= $local_posts_per_page)
						throw new Exception();

					$pages_count = ceil($posts_count / $local_posts_per_page);

					if($pages_count <= 1)
						throw new Exception();

					function show_page($target_page){

						global $class, $category, $theme, $author, $show_unverified, $page;

						if($target_page == '>'){ ?>
							<li class="page-item"><a
										class="page-link"
										href="<?= Site::link(Main::getLink($class,
										                                   $category,
										                                   $theme,
										                                   $author,
										                                   $show_unverified,
										                                   $page + 1
										)
										) ?>"><?= $target_page ?></a></li> <?php
						} elseif($target_page == '<') { ?>
							<li class="page-item"><a
										class="page-link"
										href="<?= Site::link(Main::getLink($class,
										                                   $category,
										                                   $theme,
										                                   $author,
										                                   $show_unverified,
										                                   $page - 1
										)
										) ?>"><?= $target_page ?></a></li> <?php
						} elseif($page == $target_page) { ?>
							<li class="page-item disabled"><a
										class="page-link"
										disabled><?= $target_page ?></a></li> <?php
						} elseif($target_page == '...') { ?>
							<li class="page-item disabled"><a
										class="page-link"
										disabled>...</a></li> <?php
						} else { ?>
							<li class="page-item"><a
										class="page-link"
										href="<?= Site::link(Main::getLink($class,
										                                   $category,
										                                   $theme,
										                                   $author,
										                                   $show_unverified,
										                                   $target_page
										)
										) ?>"><?= $target_page ?></a></li> <?php
						}

					} ?>




					<nav
							class="col-12 mt-5"
							aria-label="<?= Language::get('pages') ?>">
						<ul class="pagination justify-content-center"> <?php

							if($page != 1 && $pages_count > 1)
								show_page('<');

							if($pages_count <= 5)
								for($i = 1; $i <= $pages_count; $i++)
									show_page($i); else {
								if($page <= 5)
									for($i = 1; $i <= $page; $i++)
										show_page($i); else {
									show_page(1);
									show_page(2);
									show_page('...');
									show_page($page - 1);
									show_page($page);
								}

								if($page + 4 >= $pages_count)
									for($i = $page + 1; $i <= $pages_count; $i++)
										show_page($i); else {
									show_page($page + 1);
									show_page('...');
									show_page($pages_count - 1);
									show_page($pages_count);
								}
							}

							if($page != $pages_count)
								show_page('>');

							?>

						</ul>
					</nav> <?php

				} catch(Exception $e){
				} ?>

			</div>
		</div> <?php

		return TRUE;
	}

	public function actionContacts(){

		if(!Site::_SHOW_CONTACTS)
			\Api\helper::redirect('mailto:' . Site::_EMAIL_, FALSE);

		$args = func_get_args();
		$alert_show = 0;
		if(count($args) == 1 && $args[0] === 'sent')
			$alert_show = 'success';

		MainController::actionHeader(); ?>

		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<h1 title="<?= Language::get('contact_us', 1) ?>"><?= Language::get('contact_us') ?></h1> <?php

					foreach(Site::_CONTACTS_ as $key => $value){

						if(Language::array_key_exists($key))
							$t_name = Language::get($key, 2); else
							$t_name = [ucfirst($key), ''];

						if($key == 'email' && $value[0] == 1)
							$t_value = Site::_EMAIL_; elseif(array_key_exists(Site::$current_language, $value))
							$t_value = $value[Site::$current_language];
						else
							$t_value = $value[0];

						if(strlen($t_value) == 0)
							continue;

						//$t_value = \Api\helper::text2url($t_value,false);

						\Api\helper::input($t_name,
						                   strtolower($key),
						                   'text',
						                   FALSE,
						                   $t_value,
						                   '',
						                   NULL,
						                   'readonly disabled'
						);

					} ?>

				</div>
				<form class="col-sm-12 col-md-6">
					<h1 title="<?= Language::get('write_to_us', 1) ?>"><?= Language::get('write_to_us') ?></h1> <?php

					if($alert_show === 'success')
						\Api\helper::alert(Language::get('email_send', 2), 'success');

					if(Data::$main_user == NULL)
						$email = ''; else
						$email = Data::$main_user->get('email');

					\Api\helper::input(Language::get('email', 2),
					                   'email',
					                   'email',
					                   TRUE,
					                   $email,
					                   '',
					                   Fields::get('remail')
					);
					\Api\helper::input(Language::get('msg', 2), 'msg', 'textarea', TRUE, '', '', Fields::get('msg'));
					\Api\helper::input('',
					                   'submit',
					                   'button',
					                   FALSE,
					                   Language::get('send_message'),
					                   '',
					                   Fields::get('msg'),
					                   'class="btn-outline-dark"'
					); ?>

					<script>
						$( function () {
							forming( $( "#a2submit" ), '<?=Site::link('contacts/send'
							)?>', '<?=Site::link('contacts/sent')?>' );
						} );
					</script>

				</form>
			</div>
		</div> <?php
	}

	public function actionBrowserConfig(){

		header('Content-Type: application/xml; charset=utf-8');

		echo '<?xml version = "1.0" encoding = "utf-8"?>
		<browserconfig>
			<msapplication>
				<tile>
					<square70x70logo src="/ms-icon-70x70.png" />
					<square150x150logo src="/ms-icon-150x150.png" />
					<square310x310logo src="/ms-icon-310x310.png" />
					<TileColor>' . Site::_BRAND_COLOR_ . '</TileColor>
				</tile>
			</msapplication>
		</browserconfig>';
	}

	public function actionManifestJson(){

		header('Content-Type: application/json; charset=utf-8');

		echo '{
		  "name": "' . Site::_TITLE_ . '",
		  "short_name": "' . Site::_NAME_ . '",
		  "theme_color": "' . Site::_BRAND_COLOR_ . '",
		  "background_color": "' . Site::$background_color . '",
		  "display": "browser",
		  "Scope": "/",
		  "start_url": "/",
		  "icons": [
		    {
		      "src": "public/images/icons/android-icon-72x72.png",
		      "sizes": "72x72",
		      "type": "image/png"
		    },
		    {
		      "src": "public/images/icons/android-icon-96x96.png",
		      "sizes": "96x96",
		      "type": "image/png"
		    },
		    {
		      "src": "public/images/icons/android-icon-120x120.png",
		      "sizes": "120x120",
		      "type": "image/png"
		    },
		    {
		      "src": "public/images/icons/android-icon-144x144.png",
		      "sizes": "144x144",
		      "type": "image/png"
		    },
		    {
		      "src": "public/images/icons/android-icon-150x150.png",
		      "sizes": "150x150",
		      "type": "image/png"
		    },
		    {
		      "src": "public/images/icons/android-icon-192x192.png",
		      "sizes": "192x192",
		      "type": "image/png"
		    }
		  ],
		  "splash_pages": null
		}';
	}

	public function actionContactsValidate(){

		global $field_data, $field;

		$field_data = ['email' => 'remail', 'msg' => 'msg',
		];

		$validation_results = \Api\lrp::validate_fields();

		if($validation_results['error'] !== 0)
			echo json_encode($validation_results);

		else {

			$email = $field['email'];
			$msg = $field['msg'];

			mail::send(Language::get('new_question_subject'),
			           mail::content(Language::get('new_question_subject'),
			                         Language::get('new_question_content') . '<br>Email: ' . $email . '<br>Msg: ' . $msg
			           ),
			           Site::_EMAIL_,
			           Site::_REAL_EMAIL_
			);

			echo json_encode(['error' => 0]);
		}
	}

	public function actionServiceWorker(){

		if(SITE::_USE_SERVICE_WORKER_){
			?>
			<script src="<?= Site::link('public/scripts/serviceworker' . Data::$js_ext) ?>"></script> <?php
		}

	}

	public function actionFavicon(){

		header('Content-Type: image/x-icon');

		echo file_get_contents(Site::server_link('public/images/icons/favicon.ico'));
	}

	public function actionRobotsTxt(){

		header('Content-Type: text/plain');

		if(Site::$seo)
			echo 'User-agent: *
Disallow: /profile/delete
Disallow: /profile/ban/
Disallow: /profile/logout/
Disallow: /post/add/
Disallow: /post/edit/
Disallow: /post/review/
Disallow: /post/delete/
Disallow: /error/
Disallow: /cron/
Disallow: /admin/
Disallow: /wp-admin/
'; else
			echo 'User-agent: *
Disallow: /';
	}

	public function actionCron(){

		global $sql;

		$data = $sql->res2data($sql->a('SELECT `u_name`,`birth_date`,`email`,`parameters`,YEAR(FROM_UNIXTIME(UNIX_TIMESTAMP()-`birth_date`))-1970 AS "age" FROM `dusers` WHERE DAY(FROM_UNIXTIME(`birth_date`)) = DAY(CURRENT_DATE()) AND MONTH(FROM_UNIXTIME(`birth_date`)) = MONTH(CURRENT_DATE())'
		)
		);

		$subject = Language::get('happy_birthday_subject');
		$content1 = Language::get('happy_birthday_content_1');
		$content2 = Language::get('happy_birthday_content_2');

		foreach($data as $user){

			$parameters = json_decode($user['parameters'], TRUE);

			if(\Api\helper::safeGet('mail_subscribed', $parameters, "false") !== "false")
				mail::send($subject,
				           mail::content($subject, $content1 . $user['age'] . $content2),
				           Site::_EMAIL_,
				           $user['email']
				);
		}

	}

	public function actionGoogleVerification($key){

		header('Content-Type: text/html');

		if('google' . $key . '.html' == Site::$google_site_verification)
			echo 'google-site-verification: ' . Site::$google_site_verification; else
			die();
	}

	public function actionBlank(){

		header('Content-Type: text/plain');

		echo 'I will find you and I will stop you. ' . \Api\helper::get_user_ip();
	}

}