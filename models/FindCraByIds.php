<?php

class FindCraByIds extends ApiMethod {
    
 
    const API = 'SupervisionWS/findCraByIds';
    
    
    public function sendRequest(string $seek) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&contactIds=['    .urlencode($seek) .']';
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}