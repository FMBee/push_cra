<?php

class GetSingleCallCra extends ApiMethod {
    
 
    const API = 'MessagesUnitairesWS/getSingleCallCra';
    
    
    public function sendRequest(string $mode, string $seek) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect));
        
        switch ( $mode ) {
            
            case 'ref':
                
                $this->query .= '&refExt=' .urlencode($seek);
                break;
            
            case 'date':
                
                $this->query .= '&beginDate=' .urlencode($seek);
                break;
            
            case 'page':
                
                break;
        }
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}

/*
 GetSingleCallCra
 Array
 (
     [success] => 1
     [response] => Array
     (
         [list] => Array
         (
             [0] => Array
             (
                 [media] => SMS
                 [messageId] => 2482508840
                 [lastCall] => 1555075326000
                 [statusLastChange] => 1555075333000
                 [lastResult] => Reçu
                 [attemps] => 1
                 [callId] => 10110504728460
                 [status] => DONE
                 [callResponse] => rep4
                 [to] => 0617365731
                 [textMsg] => essai 4
                 [refExt] => id001
             )
         
         )
         [total] => 1
     )
 )
 */