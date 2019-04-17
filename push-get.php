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
    
    //------------------ creation logs
    
    $logs = new Log(Config::get('logs/push'));
    
    if ( $logs->error() )      echo('Erreur sur fichier log');
    

    //------------------ TRAITEMENT
    
    $logs->init();
    
    $run = new spoolFiles(
        
        glob(Config::get('params/prefix'))
        );
    
    $logs->close();


    


  
    