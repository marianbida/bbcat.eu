<?php
final class Country {
	
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_table = 'country', $_table_lang = 'country_lang';
	
	public function __construct() {
		$this->_db = Registry::get('db');
	}

	function getRecords($start = 0, $count = 20, $lang_id = 1, $continent_id = NULL, $active = NULL) {
		$out = array();
		$limit = "LIMIT " . ($start * $count) . "," . $count;
		$where = array();
		if ($continent_id) $where[] = "t1.continent_id = " . $continent_id;
		if ($active) $where[] = "t1.active = " . $active;
		
		$where = !$where ? '' : 'WHERE ' . implode(' AND ', $where);
		
		$out = $this->_db->q("
		SELECT t1.country_id, t1.alias, t2.name 
		FROM `country` t1
		INNER JOIN `country_lang` t2
		ON t1.`country_id` = t2.`country_id` AND t2.`lang_id` = " . $lang_id . "
		" . $where . "
		ORDER BY t1.active DESC, t1.country_id ASC
		" . $limit . ";
		");
		return $out;
	}

	function getTotal() {
		$total = 0;
		$r = $this->_db->q("SELECT COUNT(*) as `t` FROM `country`");
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->t;
			$r->free();
		}
		return $total;
	}
	
	public function getRecord($id = NULL, $alias = NULL, $lang_id = 3)
	{
		$out = '';
		$where = array();
		if ($id != NULL ) $where[] = "t1.country_id = " . $id;
		if ($alias != NULL ) $where[] = "t1.alias = '" . $alias . "'";
		$where = !$where ? '' : 'WHERE ' . implode(' AND ', $where);
		
		$r = $this->_db->q("
		SELECT t1.*, t2.name
		FROM " . $this->_table . " t1 
		LEFT JOIN " . $this->_table_lang . " t2
		ON t1.country_id = t2.country_id AND t2.lang_id = " . $lang_id . "
		" . $where);
		if ($r) {
			$out = $r[0];
		}
		return $out;
	}
	
	
}