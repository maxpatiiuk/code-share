<?php


class AdminController{

	public function actionUsers(){

		global $sql;

		$args = func_get_args();
		if(count($args) == 1 && is_numeric($args[0]) && $args[0] >= -1 && $args[0] <= 11)
			$class = $args[0]; else
			$class = 0;

		MainController::actionHeader();

		if(Data::$main_user == NULL || !in_array(Data::$main_user->get('type'), [2, 5])){
			\Api\helper::alert(Language::get('access_denied', 2), 'danger');

			return FALSE;
		}

		?>
		<h1 title="<?= Language::get('users', 1) ?>"><?= Language::get('users') ?></h1> <?php

		if(Site::$use_classes){
			$classes = [[0, Language::get('all')], [5, 5], [6, 6], [7, 7], [8, 8], [9, 9], [10, 10], [11, 11], [-1, Language::get('graduated')],
			];
			if($class == 0)
				$classes[0][2] = 1; elseif($class == -1)
				$classes[count($classes) - 1][2] = 1;
			elseif($class >= 5 && $class <= 11)
				$classes[$class - 4][2] = 1;

			\Api\helper::input(Language::get('class', 2), 'class', 'select', TRUE, $classes, '', Fields::get('rclass')); ?>

			<script>

				$( "#a2class" ).change( function () {

					window.location.href = '<?=Site::link('admin/users/class/')?>' + $( this ).val();

				} );

			</script> <?php
		}

		$users_data = $sql->res2data($sql->a('SELECT `u_name`,`login`,`email`,`parameters`,`type`,`register_date`,`u_last_online` FROM `dusers` WHERE `type` <> 5')); ?>

		<table class="table table-striped table-hover">

			<thead>

				<th>#</th>
				<th title="<?= Language::get('name', 1) ?>"><?= Language::get('name') ?></th> <?php
				if(Site::$use_classes && $class == 0){ ?>
					<th title="<?= Language::get('class', 1) ?>"><?= Language::get('class') ?></th> <?php
				} ?>
				<th title="<?= Language::get('email', 1) ?>"><?= Language::get('email') ?></th>
				<th title="<?= Language::get('notifications', 1) ?>"><?= Language::get('notifications') ?></th>
				<th title="<?= Language::get('type', 1) ?>"><?= Language::get('type') ?></th>
				<th title="<?= Language::get('register_date', 1) ?>"><?= Language::get('register_date') ?></th>
				<th title="<?= Language::get('last_online', 1) ?>"><?= Language::get('last_online') ?></th>


			</thead>

			<tbody><?php

			$user_types = [Language::get('user'), Language::get('admin'), Language::get('partial_admin'), Language::get('spectator'), '', Language::get('banned'), Language::get('deleted')];
			$edit = Language::get('edit', 2);


			$has_posts = FALSE;

			if(is_array($users_data)){

				foreach($users_data as $data){

					if(strlen($data['u_name']) == 0)
						$name = $data['login']; else
						$name = $data['u_name'];

					$type = $user_types[$data['type'] - 1];

					$parameters = json_decode($data['parameters'], TRUE);

					if(is_array($parameters) && array_key_exists('reset', $parameters) && array_key_exists('confirm_email', $parameters['reset']))
						$email_class = 'class="table-danger"'; else
						$email_class = '';

					if(is_array($parameters) && array_key_exists('mail_subscribed', $parameters) && !in_array($parameters['mail_subscribed'], [FALSE, "false", 0, "0"]))
						$notifications = "+"; else
						$notifications = '-';

					$local_class = '';
					if(Site::$use_classes){
						$local_class = 0;

						if(is_array($parameters) && array_key_exists('class', $parameters) && is_numeric($parameters['class']))
							$local_class = $parameters['class'];

						if($class == 0){
							if($local_class == -1)
								$local_class = Language::get('graduated'); elseif($local_class == 0)
								$local_class = Language::get('all');
							else
								$local_class = $parameters['class'];
						} else {
							if($local_class != $class)
								continue;
						}

					}

					$has_posts = TRUE; ?>

					<tr>
							<th>
								<a
										title="<?= $edit[1] ?>"
										href="<?= Site::link('profile/@' . $data['login']) ?>"><?= $edit[0] ?></a>
							</th>
							<th><?= $name ?></th> <?php
						if(Site::$use_classes && $class == 0){ ?>
							<th><?= $local_class ?></th> <?php
						} ?>
						<th <?= $email_class ?>><?= $data['email'] ?></th>
							<th><?= $notifications ?></th>
							<th><?= $type ?></th>
							<th><?= \Api\helper::format_date($data['register_date'], 'friendlify') ?></th>
							<th><?= \Api\helper::format_date($data['u_last_online'], 'friendlify') ?></th>
						</tr> <?php

				}
			} ?>



			</tbody>

		</table> <?php

		if(!$has_posts)
			\Api\helper::alert(Language::get('no_users', 2), 'danger');

		return true;
	}

}