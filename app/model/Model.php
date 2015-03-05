<?php
class Model {
	private $_tpl, $_db;
	private $_table			=	"model";
	private $_table_lang	=	"model_lang";

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
		$where = '';
		if (isset($data['page'])) {
			$start = ITEMS_PER_PAGE * $data['page'];
			$count = ITEMS_PER_PAGE;
			$limit = "LIMIT $start, $count";
		}
		if (isset($data["brand_id"])) {
			$where = "WHERE t1.`brand` = {$data["brand_id"]}";
		}
		if (isset($data["brand_list"])) {
			$where = "WHERE t1.`brand` in ({$data["brand_list"]})";
		}
		$list = array();
		$q = "
            SELECT t1.`model_id`, t1.`brand`, t2.`model_name`
            FROM `{$this->_table}` t1
            INNER JOIN `{$this->_table_lang}` t2
            ON t1.`model_id` = t2.`model_id` AND t2.`lang_id` = 1
            $where
            ORDER BY t2.`model_name` ASC
            $limit
		;";
		//dump($q);
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
		WHERE `model_id` = '$brand_id'
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
            WHERE `model_id` = '$id'
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
            SELECT `model_name`, `lang_id`
            FROM	`{$this->_table_lang}`
            WHERE	`model_id` = $id
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out->{$o->lang_id} = $o->model_name;
			}
			$r->free();
		}
		return $out;
	}

	function edit($data)
	{
		//update main
		$q = "
            UPDATE	`{$this->_table}`
            SET		`brand` = \"{$data["brand"]}\"
            WHERE `model_id` = {$data["model_id"]}
            LIMIT 1
		;";
		$this->_db->q($q);
		
		//update lang
		$lang_list = array(1);
		foreach ($lang_list as $code) {
			$q = "
			UPDATE `{$this->_table_lang}`
			SET
				`model_name`	=	\"{$data['model_name'][$code]}\"
			WHERE
				`model_id`	= \"{$data['model_id']}\" AND
				`lang_id` 	=	'{$code}'
			LIMIT 1;
			";
			$this->_db->q($q);
		}
		//return $this->_db->affected_rows ? TRUE : FALSE;
		return TRUE;
	}

	function remove($id)
	{
		$q = "
            DELETE FROM `{$this->_table}`
            WHERE `model_id` = $id
            LIMIT 1
		;";
		$this->_db->q($q);
		$q = "
            DELETE FROM `{$this->_table_lang}`
            WHERE `model_id` = $id
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
            SET
                `model_id`  = '',
                `brand`     = \"{$data['brand']}\"
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
				`model_id`      =	$id,
				`lang_id`       =	$code,
				`model_name`	=	\"{$data['model_name'][$code]}\"
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