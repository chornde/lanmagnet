<?php

	define('config', require('config.php'));
	require('functions.php');
	require('autoload.php');
	
	$pdo = new PDO('sqlite:lanmagnet.sqlite');
	$Steam = new Steam(config['steam'], $pdo);

	require('index.tpl');
	
	if(!empty($_POST['steamid'])){
		$Steam->add($_POST['steamid']);
	}
	
	// vre($Steam->GetSchemaForGame('49520'));
	// vre($Steam->GetOwnedGames('76561198076619771'));
	// vre($Steam->GetPlayerSummaries('76561198076619771'));