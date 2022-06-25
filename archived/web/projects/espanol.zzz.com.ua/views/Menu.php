<div
		id="zoomable"
		style="display:none !important;"></div>
<div
		id="modal"
		style="display:none !important;"></div>

<div id="menu">

	<a
			href="<?= Site::$link ?>"
			id="logo"
			class="dark_mode_invert"></a>

	<nav class="navbar navbar-expand-sm navbar-light">
		<div class="mx-auto d-sm-flex d-flex flex-sm-nowrap">
			<button
					class="navbar-toggler"
					type="button"
					data-toggle="collapse"
					data-target="#navbar"
					aria-expanded="false"
					aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div
					class="collapse navbar-collapse"
					id="navbar">
				<ul class="navbar-nav text-xs-only-center"> <?php
					foreach($menuItems as $value){
						echo '<li class="nav-item';

						if(strpos(Data::$current_uri, 'category/' . $value['name']) !== FALSE)
							echo ' active';

						echo '"><a class="nav-link"  href="' . Site::link(Main::getLink(0, $value['id'])) . '">' . ucfirst($value['name']) . '</a></li>';
					}

					if(Site::_SHOW_CONTACTS){ ?>
					<li
							class="nav-item<? if(strpos(Data::$current_uri, 'contacts') !== FALSE)
								echo ' active'; ?>">
						<a
								href="<?= Site::link('contacts') ?>"
								class="nav-link"
								title="<?= Language::get('contacts', 1); ?>"><?= Language::get('contacts'); ?></a>
						</li><?php
					}


					if(Data::$main_user !== NULL){
						$url_key = 'profile';
						$link_href = 'profile/@' . Data::$main_user->get('login');
						$language_ley = 'profile';

						if(in_array(Data::$main_user->get('type'), [2, 5])){ ?>
						<li
								class="nav-item<? if(strpos(Data::$current_uri, 'admin/users') !== FALSE)
									echo ' active'; ?>">
							<a
									href="<?= Site::link('admin/users') ?>"
									class="nav-link"
									title="<?= Language::get('admin_panel', 1); ?>"><?= Language::get('admin_panel'); ?></a>
							</li><?php
						}
					} else {
						$url_key = 'login';
						$link_href = 'login';
						$language_ley = 'logIn';
					} ?>
					<li
							class="nav-item<? if(strpos(Data::$current_uri, $url_key) !== FALSE)
								echo ' active'; ?>">
						<a
								href="<?= Site::link($link_href) ?>"
								class="nav-link"
								title="<?= Language::get($language_ley, 1); ?>"><?= Language::get($language_ley); ?></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

</div>
<script>
	let mail_url = "<?=Site::link(Data::$mail_url);?>";
	let language_mode = <?=Site::_LANGUAGE_MODE_?>;
	let site_url = "<?=Site::$link?>";

	text[ "error_while_getting_data" ] = '<?=Language::get('error_while_getting_data')?>';
	text[ "no_internet" ] = "<?=Language::get('no_internet')?>";
	text[ "error_while_saving" ] = "<?=Language::get('error_while_saving')?>";
</script> <?php

if(Data::formatData('container') === TRUE){
	echo '<div class="container">';
	Data::$closing_tags .= '</div>';
}
