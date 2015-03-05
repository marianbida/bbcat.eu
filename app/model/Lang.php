<?php
final class Lang {
	private static $instance;
	private $_dir;
	private $_data = array();

	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function __construct($dir = '') {
		$this->_dir = $dir;
		$this->_db = Registry::get('db');
		$this->_cache = Registry::get('cache');
	}

	public function get($k) {
		return (isset($this->_data[$k]) ? $this->_data[$k] : $k);
	}

	public function getIn($k, $v) {
		return (isset($this->_data[$k][$v]) ? $this->_data[$k][$v] : $k.' '.$v);
	}
	public function getAll($data = FALSE) {
		$result = $this->_data;
		if ($data) {
			$result = array_merge($data, $this->_data);
		}
		return $result;
	}

	public function load($filename) {
		$file = DIR_LANGUAGE . $this->_dir . '/' . $filename . '.php';
		if (file_exists($file)) {
			$_ = array();
			require_once($file);
			$this->_data = $this->_array_merge_recursive_distinct($this->_data, $_);
		} else {
			exit('Error: Could not load language ' . $filename . '!');
		}
	}

    function getCode ($id) {
		$q = "SELECT `code` FROM `languages` WHERE `id` = '$id' LIMIT 1;";
		$r = $this->q( $q );
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$r->free();
			return $o->code;
		}
	}

	function getList() {
		$i = 0;
		while (++$i < 1000) {
			$out = $this->_cache->get('lang.list');
		}
		if (!$out) { 
			$out = $this->_db->q("SELECT * FROM `lang` ORDER BY `id` ASC;");
			$this->_cache->set('lang.list', $out);
		}
		return $out;
	}

    private function _array_merge_recursive_distinct () {
		$arrays = func_get_args();
		$base = array_shift($arrays);
		if(!is_array($base)) $base = empty($base) ? array() : array($base);
		foreach ($arrays as $append) {
			if (!is_array($append)) $append = array($append);
			foreach ($append as $key => $value) {
				if (!array_key_exists($key, $base) and !is_numeric($key)) {
					$base[$key] = $append[$key];
					continue;
				}
				if(is_array($value) || is_array($base[$key])) {
					$base[$key] = $this->_array_merge_recursive_distinct($base[$key], $append[$key]);
				} else if(is_numeric($key)) {
					if(!in_array($value, $base)) $base[] = $value;
				} else {
					$base[$key] = $value;
				}
			}
		}
		return $base;
	}
}