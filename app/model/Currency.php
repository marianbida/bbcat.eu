<?php
final class Currency {
	private $_db, $_cache;
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function __construct() {
		$this->_db	=& Registry::get('db');
		$this->_cache =& Registry::get('cache');
	}

	function getRecords($start = 0, $count = 20, $state = 'y') {
		$out = $this->_cache->get('curr.list.'.$start.'.'.$count.'.'.$state);
		if (!$out) { 
			$r = $this->_db->q('SELECT * FROM `currency` WHERE act = \''.$state.'\' ORDER BY `id` ASC LIMIT '.$start.','.$count.';');
			if ($r) {
				foreach ($r  as $o) {
					$out[$o->id] = $o->code;
				}
			}
			$this->_cache->set('curr.list.'.$start.'.'.$count.'.'.$state, $out);
		}
		return $out;
	}
	//id, code, ratio, rate, reverserate
	public function updateRecord($code, $ratio, $rate, $reverserate) {
		$this->_db->q("
		UPDATE `currency` 
		SET `ratio` = " . $ratio . ", `rate` = " . $rate . ", `reverserate` = " . $reverserate . "
		WHERE `code` = '" . $code . "'
		LIMIT 1");
	}
}