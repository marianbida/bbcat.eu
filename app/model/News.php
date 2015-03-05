<?php
final class News {
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	private $_db, $_table = 'news', $_table_lang = 'news';
	
	public function __construct(){
		$this->_db =& Registry::get('db');
	}

	public function getRecord($id, $lang_id) {
		$out = new stdClass;
		$q = "
		SELECT t1.*, t2.*
		FROM `{$this->_table}` AS t1
		INNER JOIN `{$this->_table_lang}` AS t2
		ON t1.`news_id` = t2.`news_id` AND t2.lang_id = " . $lang_id . "
		WHERE t1.`news_id` = " . $id . "
		;";
		$out = $this->_db->q($q);
		return $out[0];
	}

	public function getRecords($start = 0, $count = 20, $lang_id = 3) {
		$out	=	array();
		$limit	=	"LIMIT " . ($start * $count) . ", " . $count;
		$q = "
		SELECT t1.news_id, t1.news_date, t2.*, t3.file as news_image
		FROM " . $this->_table . " AS t1
		INNER JOIN " . $this->_table_lang . " AS t2
		ON t1.news_id = t2.news_id AND t2.lang_id = " . $lang_id . "
		LEFT JOIN media t3
		ON t3.item_id = t1.news_id AND t3.category_id = 2 AND t3.ord = 0
		ORDER BY t1.news_id DESC
		" . $limit . "
		;";
		$out = $this->_db->q($q);
		return $out;
	}

	public function getTotal() {
		$r = $this->_db->q("SELECT COUNT(*) as `total` FROM " . $this->_table . ";");
		$o = $r->fetch_object();
		$total = $o->total;
		return $total;
	}
}