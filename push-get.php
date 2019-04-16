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
    
    if ( $logs->error() )      error('Erreur sur fichier log', true);
    
    $logs->init();
    
    $errMessage = '';
    
    
    //------------------ TRAITEMENT
    
    $spaceId = '156925';
    
    if ( array_search($spaceId, array_keys(Config::get('agences'))) === false ) {
        
        echo 'spaceId introuvable';    
    }
    else {
        
        $call = new GetSingleCallCra(
            [
                "serviceId"         => Config::get('agences')[$spaceId][DMC],
                "servicePassword"   => Config::get('agences')[$spaceId][MDP],
                "spaceId"           => $spaceId
            ]
            );
        
        print_r( $call->sendRequest('id001')->results() );
        
        $call = new FindCraByIds(
            [
                "serviceId"         => Config::get('agences')[$spaceId][DMC],
                "servicePassword"   => Config::get('agences')[$spaceId][MDP],
                "spaceId"           => $spaceId
            ]
            );
        
        print_r( $call->sendRequest('2482508840')->results() );
    }