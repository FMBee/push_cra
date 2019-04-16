<?php

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
	
	