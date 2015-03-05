<?php
class Mod {
	private $_tpl, $_db;
	private $_table			=	"mod";
	private $_table_lang	=	"mod_lang";

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
		$WHERE	=	array();
		if (isset($data['page'])) {
			$start = ITEMS_PER_PAGE * $data['page'];
			$count = ITEMS_PER_PAGE;
			$limit = "LIMIT $start, $count";
		}
		if (isset($data["brand_id"])) {
			$WHERE[] = "t1.`brand` = {$data["brand_id"]}";
		}
		if (isset($data["model_id"])) {
			$WHERE[] = "t1.`model` REGEXP '[[:<:]]" . $data["model_id"] . "[[:>:]]' ";
		}
		if (isset($data["brand_list"])) {
			$WHERE[] = "t1.`brand` in ({$data["brand_list"]})";
		}
		if (isset($data["model_list"])) {
			$lo = array();
			foreach (explode(',', $data["model_list"]) as $model_id) {
				$lo[] = " t1.`model` REGEXP '[[:<:]]" . $model_id . "[[:>:]]' ";
			}
			//dump($lo);
			$local = implode(" OR ", $lo);
			$WHERE[] = "(" . $local . ")";
		}
		$where = empty($WHERE) ? '' : "WHERE " . implode(' AND ', $WHERE);
		$list = array();
		$q = "
		SELECT t1.`id`, t1.`brand`, t1.`model`, t2.`name`
		FROM `{$this->_table}` t1
		INNER JOIN `{$this->_table_lang}` t2
		ON t1.`id` = t2.`id` AND t2.`lang_id` = 1
		$where
		ORDER BY t2.`name` ASC
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
		//dump($list);
		return $list;
	}

	function get($id)
	{
		$q = "
		SELECT *
		FROM `{$this->_table}`
		WHERE `id` = $id
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
            WHERE `id` = $id
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
		//update main
		$q = "
            UPDATE	`{$this->_table}`
            SET
                        `brand` = \"{$data["brand"]}\",
                        `model` = \"{$data["model"]}\"
            WHERE       `id`    = {$data["id"]}
            LIMIT	1
		;";
		$this->_db->q($q);
		//update lang
		$lang_list = array(1);
		foreach ($lang_list as $code) {
			$q = "
                UPDATE	`{$this->_table_lang}`
                SET
                        `name`      =	\"{$data['name'][$code]}\"
                WHERE	`id`        =   \"{$data['id']}\" AND
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
            WHERE `id` = $id
            LIMIT 1
		;";
		$this->_db->q($q);
		$q = "
            DELETE FROM `{$this->_table_lang}`
            WHERE `id` = $id
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows ? TRUE : FALSE;
	}
	public function insertRecord ($data)
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
            INSERT INTO	`{$this->_table}`
            SET
                `brand` = \"{$data['brand']}\",
                `model` = \"{$data['model']}\"
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
				`id`		=	$id,
				`lang_id`	=	$code,
				`name`		=	\"{$data['name'][$code]}\"
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
            FROM `{$this->_table_lang}`
            WHERE
                    `lang_id`           = 1 AND
                    `{$data['key']}`    = \"{$data['val']}\"
            LIMIT 1;
		";
		//echo $q;
		$r = $this->_db->q($q);
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