<?php
/*
 * JSON manager
 */
class JSON
{
	var $_inner;
	
	private $_clean = "@\\\(?:n|r|t)@";

	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	function display() {
		header("Content-Type: application/json; charset=UTF-8");
		exit(preg_replace($this->_clean, "", json_encode($this->_inner)));
	}

	function fetch () {
		return preg_replace($this->_clean, "", json_encode($this->_inner));
	}


	function __set($key, $val) {
		$this->_inner->{$key} = $val;
	}

	function __get($key) {
        
		if (isset($this->_inner->{$key})) {
			return $this->_inner->{$key};
		} else {
			return NULL;
		}
	}
}
