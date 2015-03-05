<?php
class Manifacturer {
	
	private static $instance;
	
	public static function getInstance()
	{
		if (!isset($instance)) {
			$c = __CLASS__;
			$instance = new $c;
		}
		return $instance;
	}
	
	private $_tpl, $_db;
	private $_table			=	"manifacturer";
	private $_table_lang	=	"manifacturer_lang";

	public function __construct()
	{
		global $tpl;
		$this->_tpl			=&	$tpl;
		$this->_db			=&	DB::getInstance();
	}

	public function getList(Array $data = array())
	{
		$start = 0;
		$limit = '';
		if (isset($data['page'])) {
			$start = ITEMS_PER_PAGE * $data['page'];
			$count = ITEMS_PER_PAGE;
			$limit = "LIMIT $start, $count";
		}
		$list = array();
		$q = "
		SELECT t1.`id`, t2.`name`
		FROM `{$this->_table}` t1
		INNER JOIN `{$this->_table_lang}` t2
		ON t1.`id` = t2.`id` AND t2.`lang_id` = 1
		ORDER BY t2.`name` ASC
		$limit
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$list[] = $o;
			}
			$r->free();
		}
		return $list;
	}

	function get($brand_id)
	{
		$q = "
		SELECT *
		FROM `{$this->_table}`
		WHERE `brand_id` = '$brand_id'
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			return $r->fetch_object();
		} else {
			return FALSE;
		}
	}
	function getComplex($id)
	{
		$q = "
		SELECT *
		FROM `{$this->_table}`
		WHERE `id` = '$id'
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$o->name = $this->getNames($id);
			return $o;
		} else {
			return FALSE;
		}
	}

	public function getNames($id)
	{
		$out = new stdClass;
		$q = "
		SELECT `name`, `lang_id`
		FROM	`{$this->_table_lang}`
		WHERE	`id` = $id
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out->{$o->lang_id} = $o->name;
			}
			$r->free();
		}
		return $out;
	}

	function edit($data)
	{
		//update lang
		$lang_list = array(1);
		foreach ($lang_list as $code) {
			$q = "
			UPDATE `{$this->_table_lang}`
			SET
				`name`	=	\"{$data['name'][$code]}\"
			WHERE
				`id`	= \"{$data['id']}\" AND
				`lang_id` 	=	'{$code}'
			LIMIT 1;
			";
			$this->_db->q($q);
		}
		//return $this->_db->affected_rows ? TRUE : FALSE;
		return TRUE;
	}

	function remove($brand_id)
	{
		$q = "
		DELETE FROM `{$this->_table}`
		WHERE `truck_id` = $brand_id
		LIMIT 1
		;";
		$this->_db->q($q);
		$q = "
		DELETE FROM `{$this->_table_lang}`
		WHERE `truck_id` = $brand_id
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows ? TRUE : FALSE;
	}

	public function add($data)
	{
		foreach ($data as $item) {
			if (is_array($item)) {
				foreach ($item as $subitem) {
					$this->_db->escape($subitem);
				}
			} else {
				$this->_db->escape($item);
			}
		}
		$q = "
		INSERT INTO `{$this->_table}`
		SET `id` = ''
		";
		$this->_db->q($q);
		$id = $this->_db->insert_id;
		//insert into lang
		//update lang
		$lang_list = array(1);
		foreach ($lang_list as $code) {
			$q = "
			INSERT INTO `{$this->_table_lang}`
			SET
				`id`	=	$id,
				`lang_id`	=	$code,
				`name`	=	\"{$data['name'][$code]}\"
			;";
			$this->_db->q($q);
		}
		
		if (!isset($data['getInsertId'])) {
			return $this->_db->affected_rows > 0 ? TRUE : FALSE;
		} else {
			return $this->_db->affected_rows > 0 ? $id : FALSE;
		}
	}

	public function exist($data)
	{
		$q = "
		SELECT `id`
		FROM `{$this->_table}`
		WHERE `{$data['key']}` = '{$data['val']}'
		LIMIT 1;
		";
		$r = $this->q($q);
		if (@$r && $r->num_rows > 0) {
			return TRUE;
			$r->free();
		}
		return FALSE;
	}

	public function getTotal()
	{
		$total = 0;
		$q = "
		SELECT COUNT(*) as `total`
		FROM `{$this->_table}`
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$total = $o->total;
		}
		return $total;
	}
	
	public function truncateRecords()
	{
		$q = "TRUNCATE TABLE `{$this->_table}`";
		$this->_db->q($q);
		$q = "TRUNCATE TABLE `{$this->_table_lang}`";
		$this->_db->q($q);
		return TRUE;
	}
}