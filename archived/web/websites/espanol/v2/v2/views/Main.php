<!-- Max Patiiuk (https://max.patii.uk) -->
<!DOCTYPE html>
<html lang="uk">
	<head>
		<meta charset="<?= Site::$charset ?>">
		<meta
				name="viewport"
				content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta
				name="author"
				content="<?= Site::_AUTHOR_ ?>">
		<meta
				name="theme-color"
				content="<?= Site::_BRAND_COLOR_ ?>"/> <?php
		if(Site::$seo){ ?>
			<meta
					name="robots"
					content="index,follow"> <?php
		} else { ?>
			<meta
					name="robots"
					content="noindex,nofollow"> <?php
		} ?>
		<meta
				name="apple-mobile-web-app-title"
				content="<?= Site::_NAME_ ?>">
		<meta
				name="application-name"
				content="<?= Site::_NAME_ ?>">
		<meta
				name="msapplication-config"
				content="<?= Site::link('browserconfig.xml') ?>">
		<meta
				name="msapplication-TileImage"
				content="<?= Site::link('public/images/icons/ms-icon-144x144.png') ?>"> <?php
		if(array_key_exists("meta", $result))
			echo $result["meta"]; ?>
		<link
				rel="canonical"
				href="<?= Site::link($uri) ?>">
		<link
				rel="apple-touch-icon"
				sizes="57x57"
				href="<?= Site::link('public/images/icons/apple-icon-57x57.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="60x60"
				href="<?= Site::link('public/images/icons/apple-icon-60x60.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="72x72"
				href="<?= Site::link('public/images/icons/apple-icon-72x72.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="76x76"
				href="<?= Site::link('public/images/icons/apple-icon-76x76.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="114x114"
				href="<?= Site::link('public/images/icons/apple-icon-114x114.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="120x120"
				href="<?= Site::link('public/images/icons/apple-icon-120x120.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="144x144"
				href="<?= Site::link('public/images/icons/apple-icon-144x144.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="152x152"
				href="<?= Site::link('public/images/icons/apple-icon-152x152.png') ?>">
		<link
				rel="apple-touch-icon"
				sizes="180x180"
				href="<?= Site::link('public/images/icons/apple-icon-180x180.png') ?>">
		<link
				rel="icon"
				type="image/png"
				sizes="192x192"
				href="<?= Site::link('public/images/icons/android-icon-192x192.png') ?>">
		<link
				rel="icon"
				type="image/png"
				sizes="32x32"
				href="<?= Site::link('public/images/icons/favicon-32x32.png') ?>">
		<link
				rel="icon"
				type="image/png"
				sizes="96x96"
				href="<?= Site::link('public/images/icons/favicon-96x96.png') ?>">
		<link
				rel="icon"
				type="image/png"
				sizes="16x16"
				href="<?= Site::link('public/images/icons/favicon-16x16.png') ?>">
		<link
				rel="stylesheet"
				href="<?= Site::link('public/css/main' . Data::$css_ext) ?>">
		<link
				rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"
				integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY="
				crossorigin="anonymous">
		<link
				rel="manifest"
				href="<?= Site::link('manifest.json') ?>"><?php
		if(array_key_exists('dark_theme', $_SESSION) && $_SESSION['dark_theme'] == 1 && Site::$is_dark_theme === FALSE)
			echo '<link rel="stylesheet" href="' . Site::link('public/css/dark' . Data::$css_ext) . '">';
		if($parameters[3])
			echo '<link rel="stylesheet" href="' . Site::link('public/css/others' . Data::$css_ext) . '">';
		if($parameters[5])
			echo $parameters[5]; ?>
		<script src="<?= Site::link('public/scripts/primary' . Data::$js_ext) ?>"></script>
		<script
				src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
				integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
				crossorigin="anonymous"></script>
		<script
				src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
				integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
				crossorigin="anonymous"></script>
		<script
				src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"
				integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s="
				crossorigin="anonymous"></script><?php

		if(Site::_HTTPS_ && Data::$main_user !== NULL && Site::_USE_SERVICE_WORKER_){ ?>
			<script>
				if ( "serviceWorker" in navigator ) {
					window.addEventListener( "load", function () {
						navigator.serviceWorker.register( '<?=Site::link('sw.js')?>' ).then( function ( registration ) {
							// Registration was successful
							console.log( "ServiceWorker registration successful with scope: ", registration.scope );
						}, function ( err ) {
							// registration failed :(
							console.log( "ServiceWorker registration failed: ", err );
						} );
					} );
				}
			</script> <?php
		}

		if(strlen(Site::$googleAnalyticsId) > 1){
			echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . Site::$googleAnalyticsId . '"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag(\'js\', new Date());
			
			  gtag(\'config\', \'' . Site::$googleAnalyticsId . '\');
			</script>';
		} ?>

	</head>
	<body class="mb-4">