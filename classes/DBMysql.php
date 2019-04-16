<?php

class DBMysql {

	private static $_instance = null;
	private static $_message;
	
	private     $_pdo,
				$_mode = PDO::FETCH_ASSOC,
				$_error = false,
				$_results,
				$_count = 0;
	
	
    public function __construct($config) { 
    	
        try{
            $this->_pdo = new PDO(	'mysql:dbname=' .$config['db']
            						.';host=' .$config['host'],
				            		$config['username'],
				            		$config['password']
            					);
//             $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
        	
        	$this->setError($e->getMessage());
        }
    }

    public static function getInstance($config){

        if ( is_null(self::$_instance) ){
        
        	$db = new DBMysql($config);
        
        	if ( !$db->error() ) {
        
        		self::$_instance = $db;
        	}
        }
        return self::$_instance;
    }
    
    public static function message(){
    
    	return self::$_message;
    }
    
    public function query($sql, $params = array()){
    
    	$this->_error = false;

    	if( $query = $this->_pdo->prepare($sql) ){
    		 
    		$exec = $query->execute( count($params) ? $params : null );
    
    		if( $exec ){
    			 
    			$this->_results = $query->fetchAll($this->_mode);
    			$this->_count = $query->rowCount();
    		}
    		else{
    			$this->setError($query->errorInfo()[2] ."Erreur de requete : {$sql}");
    		}
    	}
    	else{
    	    $this->setError("Erreur prepare() sur requete : {$sql}");
    	}
    	return $this;
    }

    /*
    $db->get(
    		'tableA a JOIN tableB b ON a.id = b.id',	// FROM
    		array(
    				$entete,							// ex: DISTINCT, TOP 100
    				$fields[]							// champs
    		),
    		'a.id = ? and a.nom = ?',					// WHERE
    		$values[]									// valeurs des ? dans l'ordre
    		);
     */
    public function get($table, $fields = array(), $where = '', $params = array() ){
    	 
    	if( count($fields) ){
    		 
    		$sql = "SELECT {$fields[0]} " .implode(', ', $fields[1]) ." FROM {$table}";
    	}
    	else{
    		$sql = "SELECT * FROM {$table}";
    	}
    
    	$sql .= !empty($where) ? " WHERE {$where}" : '';
    	 
    	return $this->query($sql, $params);
    }
    
    public function update($table, $key, $fields, $params){

    	$set = implode(' = ?,', $fields) .' = ?';
    
    	$sql = "UPDATE {$table} SET {$set} WHERE {$key}";
    
    	return $this->query($sql, $params);
    }

    public function insert($table, $fields, $params){
    
    	$set = implode(',', $fields);
    	$values = substr(str_repeat('?,', count($fields)), 0, -1);
    
    	$sql = "INSERT INTO {$table} ({$set}) VALUES ({$values}";
    
    	return $this->query($sql, $params);
    }
    
    public function error(){
    	 
    	return $this->_error;
    }
    
    private function setError($message) {
    	 
    	$this->_error = true;
    	self::$_message = $message;
    }
    
    public function count(){
    	 
    	return $this->_count;
    }
    
    public function results(){
    	 
    	return $this->_results;
    }
    
    public function first(){
    	 
    	return $this->results()[0];
    }
    
    public function allFirstValues() {
    	
    	$values=array();
    	
    	foreach($this->results() as $ligne) {
    		
    		foreach($ligne as $value) {
    			
    			$values[] = $value;
    		}
    	}
    	return $values;
    }
    
} 