<?php
final class Log {
	
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_table	= 'event_log';
	private $_db;

	public function __construct() {
		$this->_db =& DB::getInstance();
	}

	/**
	 * Create a record inside log file.
	 * 
	 * 
	 * @param array
	 * event type: insert, update, delete from $lang.event.type.VAR
	 * module: variable from $lang.event.module.VAR
	 * title: variable from $lang.event.title.VAR
	 * original text content if any
	 * change changed text content if any
	 * 
	 * @return boolean
	 */
	public function put ($ip, $user_id, $event, $module, $title, $old, $new) {
		$this->_db->q("
		INSERT INTO " . $this->_table . "
		SET
                `event` = '".$event."',
				`module` = '".$module."',
				`title` = '".$title."',
				`original` = '".$old."',
				`change` = '".$new."',
				`user_id` = ".$user_id.",
				`ip`		=	'".$ip."'
		");
	}
	
	public function getRecords($start = 0, $count = 20, $ip = NULL, $user_id = NULL,
                                $event = NULL, $module = NULL, $title = '', $old = NULL, $new = NULL) {
		
		$where		=	array();
		$group = '';
		$order = "ORDER BY id DESC";
		$limit = "LIMIT $start, $count";
		if ($ip !== NULL) {
			$where[] = 't1.ip = \''.$this->_db->escape($ip).'\'';
		}
		if ($user_id !== NULL) {
			$where[] = 't1.user_id = \''.$this->_db->escape($user_id).'\'';
		}
		if ($event !== NULL) {
			$where[] = 't1.event = \''.$this->_db->escape($event).'\'';
		}
		if ($module !== NULL) {
			$where[] = 't1.module = \''.$this->_db->escape($module).'\'';
		}
		$where = $where ? "WHERE " . implode(" AND ", $where) : '';
		return $this->_db->q("select t1.* from `{$this->_table}` t1 $where $group $order $limit");
	}
}