<?php
class Category {

	static $instance;
	
	private $_db;

	public static function getInstance()
	{
		if (!isset($instance)) {
			$c = __CLASS__;
			$instance = new $c;
		}
		return $instance;
	}
	
	public function __construct()
	{
		$this->_db			=&	DB::getInstance();
		$this->_table		=	"category";
		$this->_table_lang	=	"category_lang";
		$this->_lang_id		=	1;//$lang_id;
		$this->_lang_list	=	array(1);//		=	new Lang;
	}

	public function set_charset($charset) {
		$this->_db->set_charset($charset);
	}

	public function getSubCategoryList($category_parent = FALSE)
	{
		$list = array();
		$cat_id = '';
		if ($category_parent) {
			$cat_id = 'AND t1.`category_parent` = "'.$category_parent.'"';
		}
		$q = "
		SELECT t1.*, t2.`title`, t3.`title` as `parent_title`, t4.`file` as `category_image`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`category_id` = t2.`category_id`
		LEFT JOIN `{$this->_table_lang}` t3
		ON t1.`category_parent` = t3.`category_id`
		LEFT JOIN `media` t4
		ON t4.`item_id` = t1.`category_id` AND t4.`category_id` = 1 AND t4.`ord` = 0
		WHERE t2.`lang_id` = '{$this->_lang_id}' AND `category_parent` != 0 $cat_id and t3.`lang_id` = '{$this->_lang_id}'
		GROUP BY t1.`category_id`
		ORDER BY t1.`category_order` ASC
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
	/**
	 *
	 *
	 */
	public function getList (Array $data = array())
	{
		$list	=	array();
		$category_parent	=	'';
		$where	=	'';
		$WHERE	=	array();
		$WHERE[] = "t2.`lang_id` = {$this->_lang_id}";
		if (isset($data['category_parent'])) {
			$WHERE[] = "t1.`category_parent` = {$data['category_parent']}";
		}
		if (isset($data['active'])) {
			$WHERE[] = "t1.`category_active` = {$data['active']}";
		}
		$where = !empty($WHERE) ? "WHERE " . implode(" AND ", $WHERE) : '';
		$q = "
		SELECT	t1.`category_id`, t1.`category_parent`, t1.`category_order`, t1.`category_active`,
				t2.`title`,
				t3.`title` AS `title_parent`,
				t4.`file` as `category_image`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`category_id` = t2.`category_id`
		LEFT JOIN `{$this->_table_lang}` t3
		ON t1.`category_parent` = t3.`category_id` AND t3.`lang_id` = '{$this->_lang_id}'
		LEFT JOIN `media` t4
		ON t4.`item_id` = t1.`category_id` AND t4.`category_id` = 1 AND t4.`ord` = 0
		$where
		ORDER BY t1.`category_order` ASC
		;";
		$r = $this->_db->q($q);
		//dump($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$list[] = $o;
			}
			$r->free();
		}
		return $list;
	}

	/**
	 *
	 *
	 */
	function get_cat_names ($id)
	{
		$list = array();
		$q = "
			SELECT `lang_id`,`name`
			FROM `{$this->table_lang}`
			WHERE `cat_id` = '$id'
			ORDER BY `lang_id` ASC;
		";
		$r = $this->_db->q($q);
		if ($r->num_rows > 0) {
			while( $o = $r->fetch_object() ) {
				$list[$o->lang_id] = $o->name;
			}
		}
		return $list;
	}

	function get_cat_descriptions($id)
	{
		$list = array();
		$q = "select `lang_id`,`description` from `{$this->table_lang}` where `cat_id` = '$id' order by `lang_id` asc";
		$r = $this->q( $q );
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$list[$o->lang_id] = $o->description;
			}
		}
		return $list;
	}

	public function getComplex($id)
	{
		$out = '';
		$q = "
		SELECT t1.`category_id`, t1.`category_parent`, t1.`category_active`, t1.`category_order`, t1.`brand`
		FROM `{$this->_table}` t1
		WHERE t1.`category_id` = $id
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$out = $r->fetch_object();
			$out->category_name = $this->getCategoryName($id);
		}
		return $out;
	}

	public function getCategoryName($category_id)
	{
		$out = array();
		$q = "
		SELECT *
		FROM `{$this->_table_lang}`
		WHERE `category_id` = $category_id;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
		  while ($o = $r->fetch_object()) {
			  $out[$o->lang_id] = $o->title;
		  }
		  $r->free();
		}
		return $out;
	}

	function get($id)
	{
		$o = FALSE;
		$q = "
		SELECT *
		FROM `{$this->table}`
		WHERE `id` = '$id'
		;";
		$r = $this->q( $q );
		if ($r->num_rows == 1) {
			$o = $r->fetch_object();
			$o->name		=	$this->get_cat_names( $id );
			$o->description	=	$this->get_cat_descriptions( $id );
			$r->free();
		}
		return $o;
	}
	/* edit category */
	function edit (Array $data)
	{
		//update main
		$q = "
		UPDATE `{$this->_table}`
		SET		`category_active`	=	{$data['active']},
				`category_parent`	=	{$data['category_parent']},
				`category_order`	=	{$data['category_order']},
				`brand`				=	\"{$data["brand"]}\"
		WHERE	`category_id`		=	{$data['id']}
		LIMIT 1
		;";
		//dump($q);
		$this->_db->q($q);
		//update main
		foreach ($this->_lang_list as $item) {
			$q = "
			UPDATE					`{$this->_table_lang}`
			SET		`title`			=	\"{$data['title'][$item]}\"
			WHERE	`category_id`	=	{$data['id']} AND `lang_id` = {$item}
			LIMIT 1
			;";
			//dump($q);
			$this->_db->q($q);
		}
		return $this->_db->affected_rows ? TRUE : FALSE;
	}

	// edit category
	function add(Array $data)
	{
		//update main
		$q = "
		UPDATE `{$this->_table}`
		SET		`category_active`	=	{$data['active']},
				`category_parent`	=	{$data['category_parent']},
				`category_order`	=	{$data['category_order']},
				`temp`				=	0,
				`brand`				=	\"{$data["brand"]}\"
		WHERE	`category_id`		=	{$data['id']}
		LIMIT 1
		;";
		$this->_db->q($q);
		//update main
		foreach ($this->_lang_list as $item) {
			$q = "
			UPDATE					`{$this->_table_lang}`
			SET		`title`			=	\"{$data['title'][$item]}\"
			WHERE	`category_id`	=	{$data['id']} AND `lang_id` = {$item}
			LIMIT 1
			;";
			$this->_db->q($q);
		}
		return $this->_db->affected_rows ? TRUE : FALSE;
	}

	public function createTemp ($category_parent = 0)
	{
		$q = "
		DELETE
		FROM `{$this->_table}`
		WHERE `temp` = 1
		;";
		$this->_db->q($q);
		//insert into main
		$q = "
		INSERT INTO `{$this->_table}`
		SET
			`category_parent`	= $category_parent,
			`category_active`	=	0,
			`temp`				=	1
		;";
		$this->_db->q($q);
		$id = $this->_db->insert_id;

		foreach ($this->_lang_list as $item) {
			$q = "
			INSERT INTO `{$this->_table_lang}`
			SET
				`lang_id`		=	{$item},
				`category_id`	=	$id,
				`title`			=	'n/a'
			";
			$this->_db->q($q);
		}
		return $id;
	}

	public function remove($id)
	{
		$q = "DELETE FROM `{$this->_table}` WHERE `category_id` = '$id';";
		$this->_db->q($q);
		$q = "DELETE FROM `{$this->_table_lang}` WHERE `category_id` = '$id';";
		$this->_db->q($q);
		return TRUE;
	}

	public function active ($data) {
		$q = "
		UPDATE	`{$this->table}`
		SET		`active`			=	{$data['active']}
		WHERE	`id`				=	{$data['id']}
		;";
		$this->q($q);
	}
	
	public function exist ($data) {
		$q = "
		SELECT count(`id`) as `total`
		FROM `{$this->table}`
		WHERE `{$data['key']}` = '{$data['value']}';
		";
		$r = $this->q($q);
		if( $r->num_rows > 0 ){
			$o = $r->fetch_object();
			if( $o->total > 0 ){
				return TRUE;
			}
			$r->free();
		}
		return FALSE;
	}
}