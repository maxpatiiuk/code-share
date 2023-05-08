<!DOCTYPE html>
<html lang="uk">
	<head>
		<meta charset="<?=Site::$charset?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="<?=Site::_AUTHOR_?>">
		<meta name="theme-color" content="<?=Site::_BRAND_COLOR_?>"/>
		<meta name="robots" content="index,follow"> <?php
		if(array_key_exists("meta",$result))
			echo $result["meta"]; ?>
		<link rel="canonical" href="<?=Site::link($uri)?>">
		<link rel="apple-touch-icon" sizes="57x57" href="<?=Site::link('public/images/icons/apple-icon-57x57.png')?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?=Site::link('public/images/icons/apple-icon-60x60.png')?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?=Site::link('public/images/icons/apple-icon-72x72.png')?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?=Site::link('public/images/icons/apple-icon-76x76.png')?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?=Site::link('public/images/icons/apple-icon-114x114.png')?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?=Site::link('public/images/icons/apple-icon-120x120.png')?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?=Site::link('public/images/icons/apple-icon-144x144.png')?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?=Site::link('public/images/icons/apple-icon-152x152.png')?>">
		<link rel="apple-touch-icon" sizes="180x180" href="<?=Site::link('public/images/icons/apple-icon-180x180.png')?>">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?=Site::link('public/images/icons/android-icon-192x192.png')?>">
		<link rel="icon" type="image/png" sizes="32x32" href="<?=Site::link('public/images/icons/favicon-32x32.png')?>">
		<link rel="icon" type="image/png" sizes="96x96" href="<?=Site::link('public/images/icons/favicon-96x96.png')?>">
		<link rel="icon" type="image/png" sizes="16x16" href="<?=Site::link('public/images/icons/favicon-16x16.png')?>">
		<meta name="msapplication-TileImage" content="<?=Site::link('public/images/icons/ms-icon-144x144.png')?>">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<link rel="shortcut icon" href="<?=Site::link('favicon.ico')?>">
		<link rel="stylesheet" href="<?=Site::link('public/css/main'.Data::$cssExt)?>">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="manifest" href="<?=Site::link('public/json/manifest.json')?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100"><?php
		if($paramethers[3])
			echo '<link rel="stylesheet" href="'.Site::link('public/css/others'.Data::$cssExt).'">';
		if($paramethers[5])
			echo $paramethers[5]; ?>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script><?php

		if(strlen(Site::$googleAnalyticsId) > 1){
			echo '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94002926-1"></script>
			<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag(\'js\', new Date());gtag(\'config\', \''.Site::$googleAnalyticsId.'\');</script>';
		} ?>

	</head>
	<body>