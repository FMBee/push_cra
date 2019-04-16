<?php

	$GLOBALS['config'] = [
			
		'pricing' => [
	        'host'      => 'localhost',
	        'port'  	=> '',
	        'username'  => 'root',
	        'password'  => 'eclipse',
	        'db'        => 'pricing_indus',
	    ],
		'logs' => [
			'pricing'	=> 'logs/pricing.log',
			'api'	    => 'logs/api.log'
		],
		'mailing' => [
		    'host'		=> '10.106.76.135',
            'port'      => 25,          //587
            'secure'    => null,         //'TLS',    
		    'auth'		=> false,
		    'username'	=> '',
		    'password'	=> '',
		    'from'		=> 'pricing@groupegarrigue.fr',
		    'fromname'	=> 'GIE Garrigue',
		    'listA'		=> [
			],
			'listBCC'	=> [
 							'mathieulequin@universpneus.com',
							'fredericmevollon@universpneus.com'
			],
		],
		'params' => []
	];
	
	error_reporting( $GLOBALS['_DEV'] ? (E_ERROR | E_WARNING | E_PARSE | E_NOTICE) : 0 );

	spl_autoload_register( function($class) {
		
		$filename = 'classes/' .($class) .'.php';
	
		if (is_readable($filename)) {
			
			require_once $filename;
		}

		$filename = 'models/' .($class) .'.php';
	
		if (is_readable($filename)) {
			
			require_once $filename;
		}
	});
	
	require_once 'functions.php';

