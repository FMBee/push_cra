<?php

    /*
     * Recherche d'une info fournisseur
     */
    function getFourn($name) {
        
        return trim($GLOBALS['dbW']
            ->get(
                'fourn',
                ['', [$name]],
                'c_fourn = ?',
                [$GLOBALS['cFourn']]
                )
            ->first()[$name]
            );
    }

    function  valid_periode($debut, $fin) {
        
        $debut = new \DateTime( empty($debut) ? '2000-01-01' : $debut );
        $fin = new \DateTime( empty($fin) ? '2099-12-31' : $fin );
        $date =  new \DateTime('today');
        
        return ( $date >= $debut && $date <= $fin ); 
    }

    function valid_url() {
        
        if ( !isset($_GET['article']) )	  return Config::get('errors')[2];
        
        $_GET = array_map('trim', $_GET);
    }
    
    function error($message, $fatal=false) {
        
        $GLOBALS['logs']->put(PHP_EOL.$message, '');
        
        if ( $fatal )
            
            die(json_encode(['error' => "{$message} - aborting"]));
        else
            $GLOBALS['errMessage'] .= $message.' / ';
    }
	
	function localPath($path) {
		
		return str_replace('\\', '/', $path) .'/';
// 		return substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/')+1);
	}
	
	
	function debug($var, $console = true) {
	
		if( $GLOBALS['_DEV'] )
		{
			if ($console) {
				
				var_dump($var);
			}
			else
			{
// 				echo "\n<!-- ";
// 				print_r($var);
// 				echo " -->\n";

        	    echo '<pre>';
        	    var_dump($var);
        	    echo '</pre>';
			}
		}
	}
	
	