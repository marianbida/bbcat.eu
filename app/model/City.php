<?php
final class City {

	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_db, $_table = 'city', $_table_lang = 'city_lang';
	

	public function __construct()
	{
		$this->_db			=	DB::getInstance();
		//$this->langs 		=	new Lang;
		//$this->langs 		=	$this->langs->getList();
	}

	public function regionHasChilds ($id) {
		$total = 0;
		$q = "SELECT COUNT(*) as `total` FROM `{$this->_table}` WHERE `parent_id` = $id;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->total;
			$r->free();
		}
		return $total > 0 ? TRUE : FALSE;
	}
	
	public function get_titles ($id) {
		$out = new stdClass;
		$q = "
		SELECT `title`,`lang_id`
		FROM `{$this->_table_lang}`
		WHERE `id` = $id;
		";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out->{$o->lang_id} = $o->title;
			}
			$r->free();
		}
		return $out;
	}

	public function getCity($id)
	{
		$out = '';
		$q = "
		select t1.*
		from `{$this->_table}` t1
		where t1.`id` = '$id' 
		;";
		$r = $this->q( $q );
		if( $r && $r->num_rows == 1 ){
			$o = $r->fetch_object();
			$o->name		=	$this->get_names( $o->id );
			$o->description	=	$this->get_description( $o->id );
			$out = $o;
			$r->free();
		}
		return $out;
	}
	
	public function getRecord($city_id = NULL, $city_alias = NULL, $lang_id = 3)
	{
		$out = '';
		$where = array();
		if ($city_id != NULL ) $where[] = "t1.city_id = " . $city_id;
		if ($city_alias != NULL ) $where[] = "t1.city_alias = '" . $city_alias . "'";
		$where = !$where ? '' : 'WHERE ' . implode(' AND ', $where);
		
		$out = $this->_db->q("
		SELECT t1.*, t2.name
		FROM " . $this->_table . " t1 
		LEFT JOIN " . $this->_table_lang . " t2
		ON t1.city_id = t2.city_id AND t2.lang_id = " . $lang_id . "
		" . $where);
		return $out ? $out[0] : array();
	}

	public function getRegion( $id )
	{
		$out = '';
		$q = "select t1.`id` from `{$this->_table}` t1 where t1.`id` = $id;";
		$r = $this->q( $q );
		if( $r && $r->num_rows == 1 )
		{
			$o = $r->fetch_object();
			$o->name		=	$this->get_names( $o->id );
			$o->description	=	$this->get_description( $o->id );
			$out = $o;
			$r->free();
		}
		return $out;
	}
	
	public function getQuater($id)
	{
		$out = '';
		$q = "
		select t1.`id`
		from `{$this->_table}` t1
		where t1.`id` = $id;
		";
		$r = $this->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$o->name		=	$this->get_names( $o->id );
			$o->description	=	$this->get_description( $o->id );
			$out = $o;
			$r->free();
		}
		return $out;
	}

	public function getList( $data = array() )
	{
		$ACTIVE = '';
		$WHERE = '';
		if( isset( $data['active'] ) ){
			$ACTIVE = " AND t1.`active` = {$data['active']} ";
			$WHERE = " WHERE 1=1 ";
		}
		if( isset( $data['parent_id'] ) ){
			if( $WHERE != '' ){
				$WHERE .= " AND `parent_id` = {$data['parent_id']} ";
			}else {
				$WHERE .= " WHERE `parent_id` = {$data['parent_id']} ";
			}
		}
		if( isset( $data['order'] ) ){
			$ORDER = " ORDER BY t1.{$data['order']} ";
		}else{
			$ORDER = " ORDER BY `id` ASC ";
		}
		$list = array();
		$q = "
		SELECT t1.* 
		FROM `{$this->_table}` t1
		$WHERE $ACTIVE
		$ORDER;
		";
		$r = $this->q( $q );
		if( $r && $r->num_rows > 0 ) {
			while( $o = $r->fetch_object() ) {
				$o->name		=	$this->get_names( $o->id );
				$o->description	=	$this->get_description( $o->id );
				$list[] = $o;
			}
			$r->free();
		}
		return $list;
	}

	public function getCityList($data = array())
	{
		$out = array();
		$where = array();
		if (isset($data['parent_id']) && !empty($data['parent_id'])) {
			$where[] = "t1.`parent_id` = {$data['parent_id']}";
		}
		if (isset($data['active'])) {
			$where[] = "t1.`active` = {$data['active']}";
		}
		if (isset($data['order'])) {
			$order = "ORDER BY t1.{$data['order']['key']} {$data['order']['val']} ";
		} else {
			$order = "ORDER BY t2.`title` ASC";
		}
		$where = !empty($where) ? "WHERE " . implode(" AND ", $where) : '';
		if (isset($data['page'])) {
			
		}
		$start	=	isset($data['page']) ? ($data['page']) * (isset($data["items_per_page"]) ? $data["items_per_page"] : ITEMS_PER_PAGE) : 0;
		$count	=	isset($data["items_per_page"]) ? $data["items_per_page"] : ITEMS_PER_PAGE;
		$limit = "LIMIT $start, $count";
		
		$q = "
		SELECT t1.*, t2.`title`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`id` = t2.`id` AND t2.`lang_id` = 1
		$where
		$order
		$limit
		;";
		//echo $data['page'];
		//dump($q);
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out[] = $o;
			}
			$r->free();
		}
		return $out;
	}
	
	public function getQuaterList ($data = array())
	{
		$ACTIVE = '';
		$WHERE = 'WHERE `quater` = 1 ';
		if (isset($data['parent_id']) && !empty($data['parent_id'])) {
			$WHERE .= " AND `parent_id` = {$data['parent_id']} ";
		} else {
			$WHERE .= " AND `parent_id` != 0 ";
		}
		if (isset($data['active'])) {
			$ACTIVE = " AND t1.`active` = {$data['active']} ";
		}
		if (isset($data['order'])) {
			$ORDER = " ORDER BY t1.{$data['order']} ";
		} else {
			$ORDER = " ORDER BY `id` ASC ";
		}
		$list = array();
		$q = "
		SELECT t1.* 
		FROM `{$this->_table}` t1
		$WHERE $ACTIVE
		$ORDER;
		";
		$r = $this->q($q);
		if ($r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$o->name		=	$this->get_names($o->id);
				$o->description	=	$this->get_description($o->id);
				$list[] = $o;
			}
			$r->free();
		}
		return $list;
	}
	
	
	
	
	

	
	
	

	public function getFirstRegion(){
		$id = 0;
		$q = "
		SELECT `id`
		FROM `{$this->_table}`
		WHERE `parent_id` = 0
		ORDER BY `id` ASC
		LIMIT 1;
		";
		$r = $this->q( $q );
		if( $r->num_rows ){
			$o = $r->fetch_object();
			$id = $o->id;
		}
		return $id;
	}
	
	
	

	public function child_exist( $id ){
		$out = FALSE;
		$q = "
		SELECT count(*) as `total`
		FROM `{$this->_table}`
		WHERE
			`parent_id` = $id;
		";
		$r = $this->q( $q );
		if( $r && $r->num_rows > 0 ){
			$o = $r->fetch_object();
			if( $o->total > 0 )
				$out = TRUE;
		}
		return $out;
	}
}