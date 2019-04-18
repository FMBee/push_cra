<?php
	
	error_reporting( $GLOBALS['_DEV'] ? (E_ERROR | E_WARNING | E_PARSE | E_NOTICE) : 0 );

	require_once 'functions.php';

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
	

    //entêtes du tableau [agences]
    
    define('CODE', 0);
    define('DMC' , 1);
    define('MDP' , 2);
    define('MAIL', 3);


    //parametres
    
	$GLOBALS['config'] = [
			
		'base' => [
	        'host'      => 'localhost',
	        'port'  	=> '',
	        'username'  => 'root',
	        'password'  => 'eclipse',
	        'db'        => 'base',
	    ],
		'logs' => [
			'push'	=> 'logs/push.log',
			'link'	=> 'http://vps300047.ovh.net/push_cra/logs/push.log',
		],
		'mailing_dev' => [
		    'host'		=> '10.106.76.135',
            'port'      => 25,           
            'secure'    => null,           
		    'auth'		=> false,
		    'username'	=> '',
		    'password'	=> '',
		    'from'		=> 'ged@groupegarrigue.fr',
		    'fromname'	=> 'GIE Garrigue',
		    'listA'		=> [
			],
			'listBCC'	=> [
//  							'mathieulequin@universpneus.com',
							'fredericmevollon@universpneus.com'
			],
		],
		'mailing' => [
		    'host'		=> '10.106.76.135',
            'port'      => 25,           
            'secure'    => null,         
		    'auth'		=> false,
		    'username'	=> '',
		    'password'	=> '',
		    'from'		=> 'ged@groupegarrigue.fr',
		    'fromname'	=> 'GIE Garrigue',
		    'listA'		=> [
			],
			'listBCC'	=> [
//  							'mathieulequin@universpneus.com',
							'fredericmevollon@universpneus.com'
			],
		],
	    'agences' => [
	        '156929' => ['AGEN', '9100120865', '2q8zyJi8', 'agen@universpneus.fr'],
	        '156935' => ['AGIP', '9100120866', 'PFe8uxxl', 'gourdon@universpneus.fr'],
	        '156919' => ['BALM', '9100120877', 'sKuC4NYm', 'aaa'],
	        '156939' => ['BAYO', '9100120872', 'aHzTTLqO', 'gourdon@universpneus.fr'],
	        '156948' => ['BREN', '9100120876', 'IpnLzW4a', 'aaa'],
	        '156925' => ['BRI2', '9100120861', 'zd7A1ZxO', 'brivetourisme@universpneus.fr'],
	        '156913' => ['BRIV', '9100120871', 'ohztJrFR', 'brive@universpneus.fr'],
	        '156911' => ['CAPL', '9100120870', 'WMLjceSh', 'cahorspl@universpneus.fr'],
	        '156931' => ['CATO', '9100120866', 'PFe8uxxl', 'cahors@universpneus.fr'],
	        '156945' => ['COLO', '9100120876', 'IpnLzW4a', 'aaa'],
	        '156914' => ['FIGE', '9100120873', 'dQz9Y28x', 'figeac@universpneus.fr'],
	        '156920' => ['GOUR', '9100120866', 'PFe8uxxl', 'gourdon@universpneus.fr'],
	        '156930' => ['GRAM', '9100120866', 'PFe8uxxl', 'gramat@universpneus.fr'],
	        '156927' => ['LATE', '9100120865', '2q8zyJi8', 'lateste@universpneus.fr'],
	        '156921' => ['LESC', '9100120872', 'aHzTTLqO', 'lescar@universpneus.fr'],
	        '156909' => ['MONT', '9100120868', 'RJ5Ohc83', 'montauban@universpneus.fr'],
	        '156941' => ['MTMA', '9100120872', 'aHzTTLqO', 'montdemarsan@universpneus.fr'],
	        '156915' => ['MTRE', '9100120874', 'saSD821s', 'montreal@universpneus.fr'],
	        '158014' => ['NERA', '9100120874', 'saSD821s', 'nerac@universpneus.fr'],
	        '156934' => ['NOTR', '9100120866', 'PFe8uxxl', 'nds@universpneus.fr'],
	        '156942' => ['ONET', '9100120873', 'dQz9Y28x', 'rodez@universpneus.fr'],
	        '156918' => ['PESS', '9100120865', '2q8zyJi8', 'pessac@universpneus.fr'],
	        '156917' => ['PSG',  '9100120875', 'hJvsEV7u', 'aaa'],
	        '156944' => ['PSGL', '9100120875', 'hJvsEV7u', 'aaa'],
	        '156933' => ['SARL', '9100120866', 'PFe8uxxl', 'sarlat@universpneus.fr'],
	        '156937' => ['SOUI', '9100120871', 'ohztJrFR', 'souillac@universpneus.fr'],
	        '156912' => ['STAL', '9100120876', 'IpnLzW4a', 'aaa'],
	        '156947' => ['STGA', '9100120876', 'IpnLzW4a', 'aaa'],
	        '156916' => ['STJE', '9100120864', '3TT24WLP', 'saintjean@universpneus.fr'],
	        '156926' => ['STLA', '9100120865', '2q8zyJi8', 'saintlaurent@universpneus.fr'],
	        '156908' => ['STLT', '9100120867', 'U8jNjxHG', 'saintlaurentlestours@universpneus.fr'],
	        '156910' => ['STVI', '9100120869', 'JdA6inzD', 'saintvite@universpneus.fr'],
	        '156938' => ['TARB', '9100120872', 'aHzTTLqO', 'tarbes@universpneus.fr'],
	        '156936' => ['TERR', '9100120871', 'ohztJrFR', 'terrasson@universpneus.fr'],
	        '156946' => ['TOUL', '9100120876', 'IpnLzW4a', 'aaa'],
	        '156907' => ['TULL', '9100120861', 'zd7A1ZxO', 'tulle@universpneus.fr'],
	        '156940' => ['URRU', '9100120872', 'aHzTTLqO', 'urrugne@universpneus.fr'],
	        '156932' => ['USSE', '9100120866', 'PFe8uxxl', 'ussel@universpneus.fr'],
	        '158015' => ['VICF', '9100120874', 'saSD821s', 'vicfezensac@universpneus.fr'],
	        '156943' => ['VILL', '9100120873', 'dQz9Y28x', 'villefrance@universpneus.fr'],
	        '156928' => ['VISL', '9100120865', '2q8zyJi8', 'villeneuve@universpneus.fr'],
        ],
		'params' => [
		    'prefix'  => 'push_*',
		    'moveDir' => 'done/'
		]
	];

