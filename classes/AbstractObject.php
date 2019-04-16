<?php

abstract class AbstractObject {
    

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
        
        $this->values[$name] = trim($value);
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