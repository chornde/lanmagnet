<?php

	$config = [
		'db' => [
			'dsn' => 'mysql:host=localhost;dbname=lanmagnet',
			'user' => 'lanmagnet',
			'pass' => 'lanmagnet123',
		],
        'lans' => [
            'file' => 'lans.yml'
        ],
		'steam' => [
			'api' => [
				'key' => 'EB7CD18887BB75FB44EC38C409F21CAB'
			]
		]
	];
	
	return $config;