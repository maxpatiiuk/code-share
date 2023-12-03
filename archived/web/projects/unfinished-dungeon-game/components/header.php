<?php

function require_file($require){

	require_once(dirname(__FILE__).'/'.$require);

}


require_file('../config/main.php');

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Game</title>
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta
		name="author"
		content="Max Patiiuk">
	<meta
		name="theme-color"
		content="#000"/>
	<meta
		name="robots"
		content="noindex,nofollow">
	<meta
		name="apple-mobile-web-app-title"
		content="Game">
	<meta
		name="application-name"
		content="Game">
	<meta
		name="description"
		content="Game">
	<link
			rel="icon"
			href="https://max.patii.uk/favicon.ico"><?php

	if(defined('CSS')) { ?>
		<link
			rel="stylesheet"
			href="<?=LINK?>static/css/<?=CSS?>.css"> <?php
	}

	if(defined('JS')){ ?>
		<script src="<?=LINK?>static/js/<?=JS?>.js"></script> <?php
	}

	require_file ('../library/grid/header.php'); ?>

</head>
<body>