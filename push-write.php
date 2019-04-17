<?php

    $file = 'push_'.(new \Datetime())->format('y-m-d_H-i-s-').gettimeofday()['usec'].'.txt';
    
    // $_POST est vide si xml ou json
    $input = file_get_contents("php://input");
    
    file_put_contents($file, utf8_encode($input));
    

/*
 
Array
(
    [status_report] => Array
    (
        [username] => 9100120861
        [sms] => Array
        (
            [0] => Array
            (
                [to] => +33608771970
                [date] => 2019-03-28T09:42:47Z
                [call_id] => 10220468740311
                [broadcast_id] => 115167023
                [contact_id] => 2453821632
                [ref_externe] => 
                [space_id] => 156925
                [status_list] => Array
                (
                    [0] => Array
                    (
                        [date] => 2019-03-28T09:42:46Z
                        [type] => SENT
                        [info] => submitted with sender Vulco
                    )
                    [1] => Array
                    (
                        [date] => 2019-03-28T09:42:47Z
                        [type] => RECEIVED
                    )
                )
                [status] => RECEIVED
            )
        )
    )
)
 
 */