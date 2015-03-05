<?php
final class Review {
	
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_cache;
	private $_db, $_user;
	private $_table				=	"review";
	private $_table_item		=	"hotel";
	private $_table_item_lang	=	"hotel_lang";
	private $_table_media		=	"media";

	public function __construct() {
		$this->_db      =	Registry::get('db');
		$this->_cache   =   Registry::get('cache');
	}
	
	public function getReviewStat($hotel_id = NULL) {
		$q = "
		SELECT	(SUM(t1.staff) / COUNT(t1.rate)) as staff,
				(SUM(t1.services) / COUNT(t1.rate)) as services,
				(SUM(t1.clean) / COUNT(t1.rate)) as clean,
				(SUM(t1.comfort) / COUNT(t1.rate)) as comfort,
				(SUM(t1.mvalue) / COUNT(t1.rate)) as mvalue,
				(SUM(t1.location) / COUNT(t1.rate)) as location,
				(SUM(t1.rate) / COUNT(t1.rate)) as rate,
				COUNT(t1.rate) as voted
		FROM " . $this->_table . " t1
		WHERE hotel_id = ".$hotel_id." AND active = 1
		;";
		return $this->_db->q($q);
	}
	
	public function getRecords($hotel_id = NULL, $active = NULL, $start = 0, $count = 20, $filter = '') {
		$where = array();
		if ($hotel_id !== NULL) {
			$where[] = "t1.hotel_id = " . $hotel_id;
		}
		if ($active !== NULL){
			$where[] = "t1.active = " . $active;
		}
		if ($filter != '') {
			$where[] = "t1.`key` = '".$this->_db->escape($filter)."'";
		}
		$limit = "LIMIT " . $start * $count . "," . $count;
		$where	= $where ? "WHERE " . implode(" AND ", $where) : '';
		$q = "SELECT t1.* FROM " . $this->_table . " t1 $where ORDER BY t1.review_id DESC $limit;";
		return $this->_db->q($q);
	}
	
	public function getRecord($id = null) {
		return $this->_db->q("SELECT * FROM `{$this->_table}` WHERE `id` = $id;");
	}

	function updateRecord($id, $content) {
		$q = "
            UPDATE `{$this->_table}`
            SET     `content`   = \"{$content}\"
            WHERE   `id`        = {$id} LIMIT 1;
        ";
		$this->_db->q($q);
		return $this->_db->affected_rows ? TRUE : FALSE;
	}

	public function removeRecord($id = null) {
		$q = "
            DELETE
            FROM `{$this->_table}`
            WHERE `id` = {$id}
            LIMIT 1;
        ";
		$this->_db->q($q);
		return $this->_db->affected_rows ? TRUE : FALSE;
	}
	
	public function activateRecord ($id = null, $active = null) {
		$q = "
            UPDATE `{$this->_table}`
            SET     `active`    = {$active}
            WHERE   `id`        = {$id}
            LIMIT 1;";
		$this->_db->q($q);
		return $this->_db->affected_rows ? TRUE : FALSE;
	}

	public function publish($data) {
		$insert = array();
		$insert[] = '`created` = NOW()';
		
		foreach ($data as $k => $v) {
			$insert[] = '`'.$k.'` = \''.$this->_db->escape($v).'\'';
		}
		$q	= 'INSERT INTO '.$this->_table.' SET ' . implode(',', $insert) . ';';
		$this->_db->q($q);
		return $this->_db->insert_id > 0 ? TRUE : FALSE;
	}

	public function	getTotal() {
		$total = 0;
		$q = "
            SELECT COUNT(*) as `total`
            FROM " . $this->_table . "
        ;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$total = $o->total;
			$r->free();
		}
		return $total;
	}
	
	public function getGroupList() {
		return array('yc', 'fwc', 'gof', 'st', 'mc');
	}
}