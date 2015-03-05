<?php
final class Continent {

	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	public function __construct() {
		$this->_db	=	DB::getInstance();
	}
	
	function getRecords($start = 0, $count = 20, $lang_id = 1) {
		$out = array();
		$limit = "LIMIT " . ($start * $count) . "," . $count;
		$out = $this->_db->q("
		SELECT t1.continent_id, t1.alias, t2.name 
		FROM `continent` t1
		INNER JOIN `continent_lang` t2
		ON t1.`continent_id` = t2.`continent_id` AND t2.`lang_id` = " . $lang_id . "
		ORDER BY t1.`active` DESC, t1.`continent_id` ASC
		" . $limit . ";
		");
		return $out;
	}
	function getTotal() {
		$total = 0;
		$r = $this->_db->q("SELECT COUNT(*) as `t` FROM `continent`");
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->t;
			$r->free();
		}
		return $total;
	}
	public function getComplex ($country_id = NULL) {
		$out = new stdClass;
		$r = $this->_db->q("SELECT `lang_id`, `name` FROM `continent_lang` WHERE `continent_id` = " . $country_id . ";");
		if (@$r && $r->num_rows > 0) {
			$out->country_id = $country_id;
			$out->name = array();
			while ($o = $r->fetch_object()) {
				$out->name[$o->lang_id] = $o->name;
			}
			$r->free();
		}
		return $out;
	}
}