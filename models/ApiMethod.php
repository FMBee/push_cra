<?php

abstract class ApiMethod {
    
 
    const URL = 'https://www.dmc.sfr-sh.fr/DmcWS/1.5.6/JsonService/';
    
    
    protected $connect = [
        
        'serviceId'         => '',
        'servicePassword'   => '',
        'spaceId'           => '',
        ];
    
    protected $query;
    protected $error;
    protected $message;
    protected $results;
    
    
    public function __construct(array $connect) {

// debug($connect);

        foreach ( $connect as $key => $value ) {
            
            $this->connect[$key] = $value;
        }
     
        $this->query = self::URL;
    }
    
    protected function analyse($results) {
        
        $this->error = false;
        $this->message = '';
        $this->results = [];
        
        if ( $results === false ) {
            
            $this->error = true;
            $this->message = 'Erreur d\'accès API';
        }
        else {
            
            $results = json_decode($results, true);
// debug($results);            
            
            if ( $results['success'] ) {
                
                $this->results = $results['response'];
            }
            else {

                $this->error = true;
                $this->message = $results['errorDetail'];
            }
        }
    }
    
    public function results() {
        
        return $this->results;
    }
    
    public function error() {
        
        return $this->error;
    }
    
    public function message() {
        
        return $this->message;
    }
}