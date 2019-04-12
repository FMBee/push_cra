<?php

    // entêtes des tables descriptives remises/FACT et remises/DIFF
    define('TITLE', 0);
    define('PRIO', 1);
    define('TABLE', 2);
    define('CLASSE', 3);
    define('FILTER', 4);
    
	$GLOBALS['config'] = [
			
		'Winpro' => [
	        'host'      => '10.106.76.111',
	        'host_dev'  => '10.106.76.111',
	        'port'  	=> '1433',
	        'db'        => 'winpneu',	
	        'db_dev'    => 'winpneu_formation',	
	        'username'  => 'sa',
	        'password'  => 'Logiwin06',
	    ],
		'pricing' => [
	        'host'      => 'localhost',
	        'port'  	=> '',
	        'username'  => 'root',
	        'password'  => 'eclipse',
	        'db'        => 'pricing_indus',
	    ],
		'errors' => [
		    'Arguments incomplets.',
		    'Argument invalide.',
		    'Argument manquant.',
		    'Aucun enregistrement trouvé.',
		    'Erreur de connexion.',
		],
	    'remises' => [
	        'FACT' => [
	            ['Euros pneus sur facture', 0, 'rem_fr_pneu', 'FactEuroPneu', "type_europn = 'F'" ],
	            ['Promotion article', 1, 'art_fourn_promo', 'FactPromoArt', null],
	            ['Conditions temporaires article', 2, 'art_fourn', 'FactCondTempArt', null],
	            ['Conditions temporaires famille', 3, 'rem_fou_tmp', 'FactCondTempFam', null],
	            ['Remise standard', 4, 'rem_fou_art', 'FactRemStd', null],
	        ],
	        'DIFF' => [
	            ['Euros pneus différés', 0, 'rem_fr_pneu', 'DiffEuroPneu', "type_europn = 'D'"],
	            ['Remise RFA', 0, 'rfa_fou', 'DiffRemRfa', null],
	            ['Ristourne périodique article', 1, 'rfa_fou_art_per', 'DiffRistPerArt', null],
	            ['Ristourne périodique', 2, 'rfa_fou_per', 'DiffRistPer', null],
	        ],
	    ],
	    'articles' => [
	        'fam' => [
	            '01',
	        ],    
            'sfam' => [
                'CC',
    	        'CHE',
    	        'DA',
    	        'DI',
    	        'FO',
    	        'GC',
    	        'GCD',
    	        'GCR',
    	        'GG',
    	        'GP',
    	        'ID',
    	        'KA',
    	        'MA',
    	        'MABD',
    	        'MAGO',
    	        'MAGOD',
    	        'MAGOP',
    	        'MAGOR',
    	        'MAPL',
    	        'QD',
    	        'RB',
    	        'RD',
    	        'RM',
    	        'RM65',
    	        'RM70',
    	        'RMGV',
    	        'RMRE',
    	        'RP',
    	        'TP',
    	        'TPC',
            ]
	    ],
	    'formule' => [
	        'coeff'    => '0.7435',
	        'puiss'    => '-0.265',
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
	
// 	ini_set('memory_limit','128M');
	
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

