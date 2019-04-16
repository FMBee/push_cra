<?php

    $call = new GetSingleCall([
        "serviceId" => "9100120861",
        "servicePassword" => "zd7A1ZxO",
        "spaceId" => "156925"
        ]);
    
    echo $call->sendRequest('id001')->results();