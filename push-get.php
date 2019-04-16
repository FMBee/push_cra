<?php

    $_DEV = true;
    
    require_once 'core/init.php';
    
    
    $call = new GetSingleCall(
        [
            "serviceId" => "9100120861",
            "servicePassword" => "zd7A1ZxO",
            "spaceId" => "156925"
        ]
        );
    
    print_r( $call->sendRequest('id001')->results() );