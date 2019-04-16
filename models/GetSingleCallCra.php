<?php

class GetSingleCallCra extends ApiMethod {
    
 
    const API = 'MessagesUnitairesWS/getSingleCallCra';
    
    
    public function sendRequest(string $seek) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&refExt='         .urlencode($seek);
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}