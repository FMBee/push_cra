<?php

class Log {
	
	private $_handle,
			$_error = false;
	
	public function __construct($file, $mode = 'a+'){
		
		$this->_handle = fopen($file, $mode);
		
		$this->_error = !$this->_handle;
	}
	
	public function put($line, $stamp=null, $eol=true, $echo=false) {
		
		$this->_error = !fwrite(	$this->_handle, 
									(is_null($stamp) ? date('H:i:s-') .gettimeofday()['usec'] : $stamp) .' ' 
									.$line 
									.($eol ? PHP_EOL : '')
								);
		
		if ( $GLOBALS['_DEV'] || $echo )     echo $line .($eol ? PHP_EOL : '');
	}

	public function init() {
		
		$this->put('*--------------------------------*', '');
		$this->put(date('d-m-Y H:i:s', time()) .' process begins');
	}
	
	public function close() {
	
	    $this->put(date('d-m-Y H:i:s', time()) .' end of process');
		
		fclose($this->_handle);
	}
	
	public function error() {
		
		return $this->_error;
	}
	
	
}