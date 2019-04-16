<?php

class FindCraByIds {
    
 
    const URL = 'https://www.dmc.sfr-sh.fr/DmcWS/1.5.6/JsonService/SupervisionWS/findCraByIds';
    
    private $connect = [
        
        'serviceId'         => '',
        'servicePassword'   => '',
        'spaceId'           => '',
        ];
    
    private $results;
    
    
    public function __construct(array $connect) {
        
        
        foreach ( $connect as $key => $value ) {
            
            $this->connect[$key] = $value;
        }
     
    }
    
    public function sendRequest(string $seek) {
        
        $query = 
            self::URL
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&refExt='         .urlencode($seek);
        
        $this->results = file_get_contents($query);
        
        return $this;
    }
    
    public function results() {
        
        return $this->results;
    }
}