<?php
    /*
     * Lancement en ligne de commmande : php push-get.php [TEST] [DEV]
     *
     * Options
     *
     *  - TEST  : mode test
     *  - DEV  : mode DEV et bases DEV 
     *
     */
    
    
    define('_EXIT', 'exit - aborted');
    
    $_TEST 	= false;
    $_DEV 	= false;
    
    foreach ( $argv as $arg ) {
        
        if ( strtoupper($arg) == 'TEST' )    $_TEST = true;
        if ( strtoupper($arg) == 'DEV' )     $_DEV = true;
    }
    
    require_once 'core/init.php';
    
    //TEST:
    
    //:TEST
    
    //------------------ TRAITEMENT
    
    $run = new SpoolFiles(
        
        glob(Config::get('params/prefix'))
        );
    


    


  
    