<?php
final class Faq {
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_db, $_cache;
	private $_table			=	"faq";
	private $_table_lang	=	"faq_lang";
	
	public function __construct()
	{
		$this->_db = Registry::get('db');
		$this->_cache = Registry::get('cache');
	}

	/**
	 * @param $id, lang_id
	 **/
	public function getRecord($id, $lang_id)
	{
		$out = $this->_cache->get('faq.'.$id.'.'.$lang_id);
		if (!$out) { 
			$out = $this->_db->q("
			SELECT t1.faq_id, t2.title, t2.content
			FROM `{$this->_table}` t1
			INNER JOIN `{$this->_table_lang}` t2
			ON t1.`faq_id` = t2.`faq_id` AND t2.`lang_id` = " . $lang_id . "
			WHERE t1.`faq_id` = " . $id . "
			LIMIT 1
			;");
			if ($out) {
				$out = $out[0];
			}
			$this->_cache->set('faq.'.$id.'.'.$lang_id, $out);
		}
		return $out;
	}

	

	

	

	

	public function getRecords($start, $count, $lang_id)
	{
		$out = array();
		$limit	=	'';
		if (isset($data['page'])) {
			$limit = "LIMIT $start, $count";
		}
		$q = "
		SELECT t1.`faq_id`, t2.*
		FROM " . $this->_table . " AS t1
		INNER JOIN " . $this->_table_lang . " AS t2
		ON t1.`faq_id` = t2.`faq_id` AND t2.`lang_id` = " . $lang_id . "
		ORDER BY t1.`ord` ASC
		$limit
		;";
		$out = $this->_db->q($q);
		return $out;
	}

	public function getTotal()
	{
		$r = $this->_db->query("SELECT COUNT(*) as `total` FROM `{$this->_table}`;");
		$o = $r->fetch_object();
		$total = $o->total;
		return $total;
	}
}