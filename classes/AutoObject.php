<?php

class AutoObject {
    

    private $values = [];
    
    /**
     * Constructor
     * 
     * @param array $values
     * couples nom/valeur
     */
    public function __construct(array $values) {
        
        foreach ( $values as $name => $value ) {
            
            $this->__set($name, $value);
        }
    }
    
    /**
     * Magic method
     * 
     * @return mixed
     */
    public function __get($name) {
        
        return $this->values[$name];
    }
    
    /**
     * Magic method
     */
    public function __set($name, $value) {
        
        switch ( gettype($value) ) {
            
            case 'string':
                
                $this->values[$name] = trim($value);
                break;
                
            default:
                $this->values[$name] = $value;
        }
    }

    /**
     * Getter
     * 
     * @return mixed
     */
    public function get($name) {
        
        return $this->__get($name);
    }
}