<?php
final class Payment {

	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	private $_table_media, $_table_quater_lang, $_db, $_cache;

	public function __construct()
	{
		$this->_db				=	DB::getInstance();
		$this->_table			=	"hotel";
		$this->_table_lang		=	"hotel_lang";
		$this->_table_card		=	"credit_card";
		$this->table_cats			=	"ads_cats";
		$this->table_info			=	"ads_lang";
		$this->_table_quater_lang	=	"quater_lang";
		$this->lang_id				=	isset($_SESSION['lang_id']) ? $_SESSION['lang_id'] : 1;
		$this->langs				=	Registry::get('lang')->getList();
		$this->media				=	new Media;
		$this->media_cat_id			=	1;
		$this->_table_media 		=	'media';
		$this->_table_manifacture_lang	=	"manifacturer_lang";
		$this->_cache = Registry::get('cache');

	}

	public function exist ($data)
	{
		$total = 0;
		$q = "SELECT COUNT(*) as `total` FROM `{$this->_table}` WHERE `{$data['key']}` = {$data['val']};";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->total;
			$r->free();
		}
		return $total > 0 ? TRUE : FALSE;
	}

	public function get_title ($data)
	{
		$out = '';
		if (isset($data["lang_id"])) {
			$q = "
			SELECT `title`, `lang_id` 
			FROM `{$this->_table_lang}` 
			WHERE `product_id` = {$data['product_id']} AND `lang_id` = {$data['lang_id']}";
			$r = $this->_db->q($q);
			if (@$r && $r->num_rows > 0) {
				while ($o = $r->fetch_object()) {
					$out = $o->title;
				}
				$r->free();
			}
		} else {
			$q = "
			SELECT `title`, `lang_id` 
			FROM `{$this->_table_lang}` 
			WHERE `product_id` = {$data['product_id']}";
			$r = $this->_db->q($q);
			if (@$r && $r->num_rows > 0) {
				while ($o = $r->fetch_object()) {
					$out->{$o->lang_id} = $o->title;
				}
				$r->free();
			}
		}
		return $out;
	}

	public function get_description($data)
	{
		$out = '';
		if (isset($data["lang_id"])) {
			$q = "
			SELECT	`description`, `lang_id`
			FROM	`{$this->_table_lang}`
			WHERE	`product_id` = {$data["product_id"]} AND `lang_id` = {$data['lang_id']}";
			$r = $this->_db->q($q);
			if (@$r && $r->num_rows > 0) {
				$out = $r->fetch_object();
				$out = $out->description;
				$r->free();
			}
		} else {
			$q = "
			SELECT	`description`,`lang_id`
			FROM	`{$this->_table_lang}`
			WHERE	`product_id` = {$data["product_id"]}";
			$r = $this->_db->q($q);
			if (@$r && $r->num_rows > 0) {
				while ($o = $r->fetch_object()) {
					$out->{$o->lang_id} = $o->description;
				}
				$r->free();
			}
		}
		return $out;
	}

	public function getIdByRef( $ref )
	{
		$q = "select `id` from `{$this->table}` where `ref`= '$ref';";
		$r = $this->q( $q );
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			return $o->id;
		}
	}

	public function getRecord($id = NULL, $ref = NULL, $lang_id = 1)
	{
		$out = $this->_cache->get('hotel.item.' . $ref);
		if (!$out) {
			$out = $this->_cache->get('hotel.item.' . $id);
		}
		if (!$out) {
			$where = array();
			if ($id != NULL) $where[] = "t1.hotel_id = " . $id;
			if ($ref != NULL) $where[] = "t1.ref = '" . $ref . "'";
			$where = !$where ? '' : 'WHERE ' . implode(',', $where);
			$q = "
			SELECT	t1.*,
					t2.title, t2.description, t2.modified,
					t3.name as city,
					t4.name as district,
					t5.address,
					t6.title AS chain
			FROM `{$this->_table}` t1
			LEFT JOIN `{$this->_table_lang}` t2
			ON t1.hotel_id = t2.hotel_id AND t2.lang_id = " . $lang_id . "
			LEFT JOIN city_lang t3
			ON t1.city_id = t3.city_id AND t3.lang_id = " . $lang_id . "
			LEFT JOIN district_lang t4
			ON t1.district_id = t4.district_id AND t4.lang_id = " . $lang_id . "
			LEFT JOIN hotel_address t5
			ON t1.hotel_id = t5.hotel_id AND t5.lang_id = " . $lang_id . "
			LEFT JOIN hotel_chain AS t6
			ON t1.chain_id = t6.chain_id
			" . $where . "
			;";
			//dump($q);
			$r = $this->_db->q($q);
			if ($r) {
				$out = $r[0];
				$out->media_list = $this->media->getList(
					array (
						"category_id"	=>	1,
						"item_id"		=>	$out->hotel_id,
						"page"			=>	0
					)
				);
				$out->option_list = $this->getRecordOptionList($out->hotel_id, $lang_id);
			}
			$this->_cache->set('hotel.item.' . $out->hotel_id, $out);
			$this->_cache->set('hotel.item.' . $out->ref, $out);
		}
		return $out;
	}
	
	public function getRecordOptionList($id = NULL, $lang_id = NULL) {
		$q = "
		SELECT t2.title
		FROM hotel_option_ref t1
		LEFT JOIN hotel_option_lang t2
		ON t1.option_id = t2.option_id AND t2.lang_id = " . $lang_id . "
		WHERE t1.hotel_id = " . $id . "
		ORDER BY t2.title ASC
		";
		return $this->_db->q($q);
	}
	
	public function getComplex($product_id)
	{
		$out = new stdClass;
		$q = "
		SELECT t1.*
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`product_id` = t2.`product_id` AND t2.`lang_id` = 1
		WHERE t1.`product_id` = '$product_id'
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$out = $r->fetch_object();
			//$out->title = $this->get_title( $id );
			$out->description = $this->get_description(
				array(
					"product_id"	=>	$product_id
				)
			);
			$out->title = $this->get_title(
				array(
					"product_id"	=>	$product_id
				)
			);
			//$out->media_list = $this->media->getList( 'items' , $id );
			$r->free();
		}
		//dump($out);
		return $out;
	}

	public function getFront( $data = array() )
	{
		$out = '';
		$q = "
		SELECT
			t1.*,
			t2.`title`, t2.`description`,
			t3.`name` AS `city`,
			t4.`name` AS `region`,
			t5.`name` AS `category`,
			t6.`name` AS `quater`
		FROM `{$this->table}` t1

		left join `{$this->table_info}` t2
		on t1.`id` = t2.`id`

		left join `city_lang` t3
		on t1.`town_id` = t3.`id`

		LEFT JOIN `city_lang` t4
		ON t1.`region_id` = t4.`id`

		INNER JOIN `ads_cat_lang` t5
		ON t1.`cat_id` = t5.`cat_id` AND t5.`lang_id` = {$data['lang_id']}

		LEFT JOIN `{$this->_table_quater_lang}` t6
		ON t1.`quater_id`	=	t6.`id` AND t6.`lang_id` = {$data['lang_id']}
		where
			t1.`id` = '{$data['id']}' and
			t2.`lang_id` = {$data['lang_id']} and
			t3.`lang_id` = {$data['lang_id']} and
			t4.`lang_id` = {$data['lang_id']}
		;";
		$r = $this->q($q);
		if ($r && $r->num_rows == 1) {
			$out = $r->fetch_object();
			$out->media_list = $this->media->getList('items' , $data['id']);
			$r->free();
		}
		return $out;
	}

	public function getList ($data = array())
	{
		$cat_id		=	'';
		$sub_cat_id	=	'';
		$ref		=	'';
		$price_min	=	'';
		$price_max	=	'';

		$hot		=	'';
		$where		=	array();
		$WHERE		=	'';
		$order = "ORDER BY t1.`product_id` DESC";
		if (isset($data['cat_id']) && !empty($data['cat_id'])) {
			$where['category_id'] = $data['cat_id'];
		}
		if (isset($data['promo']) && !empty($data['promo'])) {
			$where['promo'] = $data['promo'];
		}
		if (isset($data['top']) && !empty($data['top'])) {
			$order = "ORDER BY t1.`seen` DESC";
		}
		$lang_id	=	isset($data['lang_id']) ? $data['lang_id'] : 1;
		if ( ! empty($where)) {
			$WHERE = "WHERE ";
			foreach ($where as $k => $v) {
				$WHERE .= " t1.`$k` = \"$v\" AND";
			}
			if (sizeof($where) == 1) {
				foreach ($where as $k => $v) {
					$WHERE = " WHERE t1.`$k` = \"$v\" ";
				}
			}
		}
		$start	=	isset($data['page']) ? ($data['page']) * ITEMS_PER_PAGE : 0;
		$count	=	isset($data['items_per_page']) ? (int) $data['items_per_page'] : ITEMS_PER_PAGE;
		$limit = "LIMIT $start, $count";
		if (isset($data['no_limit'])) {
			$limit = '';
		}
		$list = array();
		$q = "
		select	t1.*,
				t2.`title`, t2.`description`, t2.`updated`,
				t3.`file` as `image`,
				t4.`title` as `image_title`
		from `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`product_id` = t2.`product_id` AND t2.`lang_id` = $lang_id
		LEFT JOIN `media` t3
		ON t1.`product_id` = t3.`item_id` AND t3.`ord` = 0
		LEFT JOIN `media_info` t4
		ON t4.`id` = t3.`id` AND t4.`lang_id` = $lang_id
		$WHERE
		GROUP BY t1.`product_id`
		$order
		$limit";
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

	public function getSearchCategories($category_id) {
		$out = array();
		$out[] = $category_id;
		$q = "
		SELECT `category_id`
		FROM `{$this->_table_category}`
		WHERE `category_parent` = $category_id
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out[] = $o->category_id;
			}
		}
		return implode(',',$out);
	}
	
	public function search($data)
	{
		$where = array();
		if (isset($data['category_id'])) {
			$where[] = "t1.`category_id` IN(".$this->getSearchCategories($data['category_id']).")";
		}
		if (isset($data['brand_id'])) {
			$where[] = "t1.`brand` REGEXP '[[:<:]]" . $data["brand_id"] . "[[:>:]]' ";
		}
		if (isset($data['model_id'])) {
			$where[] = "t1.`model` REGEXP '[[:<:]]" . $data["model_id"] . "[[:>:]]' ";
		}
		if (isset($data['mod_id'])) {
			$where[] = "t1.`mod` REGEXP '[[:<:]]" . $data["mod_id"] . "[[:>:]]' ";
		}
		if (isset($data['manifacturer_id'])) {
			$where[] = "t1.`manifacturer_id` = {$data['manifacturer_id']} ";
		}
		if (isset($data['promo'])) {
			$where[] = "t1.`promo` = 1 ";
		}
		if (isset($data['description'])) {
			$where[] = "
			(
				t1.`product_id` 	=	'{$data['description']}'		OR
				t2.`title`			LIKE '%{$data['description']}%'		OR
				t2.`description`	LIKE '%{$data['description']}%'		OR
				t1.`number`			LIKE '%{$data['description']}%'
			)";
		}
		$order	=	'ORDER BY t1.`product_id` DESC';
		if (isset($data["order"])) {
			$order = "ORDER BY `{$data["order"]["key"]}` {$data["order"]["val"]} ";
		}
		$start	=	isset($data['page']) ? ($data['page']) * ITEMS_PER_PAGE : 0;
		$count	=	ITEMS_PER_PAGE;
		$limit	=	"LIMIT $start, $count";

		$where = !empty( $where ) ? "WHERE " . implode(" AND ", $where) : '';
		$list = array();
		$q = "
		SELECT t1.*, t2.`title`, t2.`description`, t3.`name` as `manifacturer`, t4.`file` as `image`, t5.`title` as `image_alt`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`product_id` = t2.`product_id` AND t2.`lang_id` = {$data['lang_id']}
		LEFT JOIN `{$this->_table_manifacture_lang}` t3
		ON t1.`manifacturer_id` = t3.`id` AND t3.`lang_id` = {$data['lang_id']}
		LEFT JOIN `media` t4
		ON t1.`product_id` = t4.`item_id` AND t4.`ord` = 0
		LEFT JOIN `media_info` t5
		ON t5.`id` = t4.`id` AND t5.`lang_id` = {$data["lang_id"]}
		$where
		GROUP BY t1.`product_id`
		$order
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

	public function getSearchTotal($data)
	{
		$total = 0;
		$where	=	array();
		if (empty($order)) {
		}
		if (isset($data['category_id'])) {
			$where[] = "t1.`category_id` IN(".$this->getSearchCategories($data['category_id']).")";
		}
		if (isset($data['brand_id'])) {
			$where[] = "t1.`brand` REGEXP '[[:<:]]" . $data["brand_id"] . "[[:>:]]' ";
		}
		if (isset($data['model_id'])) {
			$where[] = "t1.`model` REGEXP '[[:<:]]" . $data["model_id"] . "[[:>:]]' ";
		}
		if (isset($data['mod_id'])) {
			$where[] = "t1.`mod` REGEXP '[[:<:]]" . $data["mod_id"] . "[[:>:]]' ";
		}
		if (isset($data['manifacturer_id'])) {
			$where[] = "t1.`manifacturer_id` = {$data['manifacturer_id']} ";
		}
		if (isset($data['promo'])) {
			$where[] = "t1.`promo` = 1 ";
		}
		if (isset($data['description'])) {
			$where[] = "
			(
				t1.`product_id` 	=	'{$data['description']}'		OR
				t2.`title`			LIKE '%{$data['description']}%'		OR
				t2.`description`	LIKE '%{$data['description']}%'		OR
				t1.`number`			LIKE '%{$data['description']}%'
			)";
		}
		
		$start	=	isset($data['page']) ? ($data['page']) * ITEMS_PER_PAGE : 0;
		$count	=	ITEMS_PER_PAGE;
		$limit	=	"LIMIT $start, $count";

		$where = !empty($where) ? "WHERE " . implode(" AND ", $where) : '';
		$list = array();
		$q = "SELECT COUNT(*) as `total` FROM `{$this->_table}` t1 $where;";
		$out = $this->_db->q($q);
		if ($out) {
			$total = (int) $out[0]->total;
		}
		return $total;
	}
	
	public function getSearchTotalWithDescription($data)
	{
		$total = 0;
		$where = array();
		$make_join = FALSE;
		if (isset($data['category_id'])) {
			$where[] = "t1.`category_id` IN(".$this->getSearchCategories($data['category_id']).")";
		}
		if (isset($data['truck_id'])) {
			$where[] = "t1.`truck_id` LIKE '%{$data['truck_id']}%' ";
		}
		if (isset($data['description'])) {
			//$data['description'] = strtolower($data['description']);
			//$data['description'] = iconv("UTF-8", "WINDOWS-1251", $data['description']);
			$where[] = "
			(
				t2.`product_id` 	=	'{$data['description']}'		OR
				t2.`product_descr`	LIKE '%{$data['description']}%'		OR
				t1.`nomer01`			LIKE '%{$data['description']}%'	OR
				t1.`nomer02`			LIKE '%{$data['description']}%'	OR
				t1.`nomer03`			LIKE '%{$data['description']}%'	OR
				t1.`razmeri`			LIKE '%{$data['description']}%'
			)";
		}
		if (isset($data['type_id'])) {
			$where[] = "t1.`type_id` = {$data['type_id']} ";
		}
		
		$start	=	isset($data['page']) ? ($data['page']) * ITEMS_PER_PAGE : 0;
		$count	=	ITEMS_PER_PAGE;
		$limit	=	"LIMIT $start, $count";

		$where = !empty( $where ) ? "WHERE " . implode(" AND ", $where) : '';
		$list = array();
		$q = "
		SELECT COUNT(*) as `total`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`product_id` = t2.`product_id` AND t2.`lang_id` = {$data['lang_id']}
		$where
		;";
		$out = $this->_db->q($q);
		if ($out) {
			$total = (int) $out[0]->total;
		}
		return $total;
	}

	public function complexSearch($key)
	{
		$list = array();
		$q = "
		SELECT `id`,`ref`
		FROM `{$this->table}`
		WHERE `ref`
			LIKE '%$key%' OR `id` LIKE '%$key%'
		ORDER BY `id` DESC
		LIMIT 12;
		";

		$r = $this->q( $q );
		if ($r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$o->thumb = $this->media->getThumb(0, FALSE, $o->id, $this->media_cat_id );
				$list[] = $o;
			}
			$r->free();
		}
		return $list;
	}

	public function edit( $data )
	{
		$q = "
		UPDATE `{$this->_table}`
		SET
			`category_id`		=	{$data['category_id']},
			`number`			=	\"{$data['num']}\",
			`price`				=	{$data['price']},
			`promo_price`		=	{$data['promo_price']},
			`promo`				=	{$data['promo']},
			`manifacturer_id`	=	{$data['manifacturer_id']},
			`brand`				=	\"{$data['brand']}\",
			`model`				=	\"{$data['model']}\",
			`mod`				=	\"{$data['mod']}\"
		WHERE
			`product_id` = {$data['id']}
		LIMIT 1
		;";
		$this->_db->q($q);
		// update language
		foreach ($this->langs as $item) {
			$q = "
			UPDATE `{$this->_table_lang}`
			SET		`description`	=	\"{$data['description'][$item->id]}\",
					`title`			=	\"{$data['title'][$item->id]}\",
					`updated`		=	NOW()
			WHERE	`product_id` = {$data['id']} AND `lang_id` = {$item->id}
			LIMIT 1
			;";
			$this->_db->q($q);
		}
		return TRUE;
	}

	public function send_ad_publish_notify($data)
	{
		$email	=	new Email;
		$this->tpl->assign("data", $data);
		$msg = $this->tpl->fetch("user/new_ad_publishment_letter.tpl");
		$email->from(CONTACT_INQUIRY_EMAIL, 'System');
		$email->to(array(CONTACT_INQUIRY_EMAIL,'marian.bida@gmail.com'));
		$email->subject('New Ad Publishment');
		$email->message($msg);
		return $email->send();
	}

	/*public function getTotal()
	{
		$total = 0;
		$r = $this->_db->q("SELECT COUNT(*) as `total` FROM `{$this->_table}`;");
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$total = (int) $o->total;
		}
		return $total;
	}*/


	public function cheackAvailability($data)
	{
		$out = '';
		$q = "
		SELECT t1.*
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_lang}` t2
		ON t1.`product_id` = t2.`product_id` AND t2.`lang_id` = 1
		WHERE
			t1.`category_id` = '{$data['category_id']}'
			AND t1.`number` = '{$data['number']}'
			AND t1.`manifacturer_id` = '{$data['manifacturer_id']}'
			AND t2.`title` = '{$data['title']}'
			AND t2.`description` = '{$data['description']}'
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$out = $r->fetch_object();
			$r->free();
		}
		return $out;
	}

	public function touchSeen($id = NULL) {
		$this->_db->q("UPDATE `{$this->_table}` SET `seen` = seen + 1 WHERE `product_id` = " . $id . ";");
	}

	public function getCreditCardRecords($start = 0, $count = 0, $lang_id = 3) {
		$out = $this->_db->q('
		SELECT t1.*, t2.title
		FROM credit_card t1
		LEFT JOIN credit_card_lang t2
		ON t1.card_id = t2.card_id AND t2.lang_id = '.$lang_id.'
		ORDER BY t1.ord ASC');
		return $out;
	}

	public function getRecordsByDistrictId($start = 0, $count = 12, $district_id = 0, $lang_id = 3, $curr_id = 0, $order_by = '', $order_way = '') {
		return $this->_db->q('CALL get_hotels_by_district('.$district_id.', '.$lang_id.', '.$curr_id.', \''.$order_by.'\', \''.$order_way.'\', '.$start.', '.$count.');');
	}

	public function getRecordsByCityId($city_id = 0, $lang_id = 3, $curr_id = 0, $order_by = '', $order_way = '', $start = 0, $count = 12, $resort = 0) {
		$out = $this->_db->q('CALL get_hotels_by_city('.$city_id.', '.$lang_id.', '.$curr_id.', \''.$order_by.'\', \''.$order_way.'\', '.$start.', '.$count.','.$resort.');');
		return $out;
	}

	public function getRecordsByUserId($user_id = 0, $lang_id = 3) {
		$out = array();
		$out = $this->_db->q("
		SELECT t1.*, t2.title
		FROM hotel t1
		left join hotel_lang t2
		on t1.hotel_id = t2.hotel_id AND t2.lang_id = " . $lang_id . "
		WHERE t1.user_id = " . $user_id . "
		");
		return $out;
	}

	public function getRecordsByDate($start, $count, $lang_id, $curr_id, $state) {
		//echo 'CALL get_hotels_by_date('.$lang_id.', '.$curr_id.', '.$start.', '.$count.',\''.$state.'\');';
		return $this->_db->q('CALL get_hotels_by_date('.$lang_id.', '.$curr_id.', '.$start.', '.$count.', \''.$state.'\');');
	}

	public function getRecordsByBest($start, $count, $lang_id, $curr_id, $state) {
		//echo 'CALL get_hotels_by_date('.$lang_id.', '.$curr_id.', '.$start.', '.$count.',\''.$state.'\');';
		return $this->_db->q('CALL get_hotels_by_best('.$lang_id.', '.$curr_id.', '.$start.', '.$count.', \''.$state.'\');');
	}

	public function getRecordsByResort($start, $count, $lang_id, $resort) {
		//echo 'CALL get_hotels_by_resort('.$lang_id.','.$start.','.$count.',\''.$resort.'\');';
		return $this->_db->q('CALL get_hotels_by_resort('.$lang_id.','.$start.','.$count.',\''.$resort.'\');');
	}

	public function getNearHotels($lon, $lat, $dist, $lang_id) {
		//echo 'CALL search_in_radius('.$lang_id.', '.$lon.', '.$lat.', '.$dist.');';
		return $this->_db->q('CALL search_in_radius('.$lang_id.', '.$lon.', '.$lat.', '.$dist.');');
	}

	public function getLandmarks($lon, $lat, $dist, $lang_id) {
		//echo 'CALL search_landmarks('.$lang_id.', '.$lon.', '.$lat.', '.$dist.');';
		return $this->_db->q('CALL search_landmarks('.$lang_id.', '.$lon.', '.$lat.', '.$dist.');');
	}

	public function searchForLocation($q = '', $lang_id = 1, $s = 0, $c = 20) {
		//echo 'CALL search_for_location(\'' . $q . '\', ' . $lang_id . ', ' . $s . ', ' . $c . ');';
		return $this->_db->q('CALL search_for_location(\'' . $q . '\', ' . $lang_id . ', ' . $s . ', ' . $c . ');');
	}

	public function getNearLandmarks($hotel_id, $lang_id, $dist) {
		//echo 'CALL get_landmarks('.$hotel_id.','.$lang_id.','.$dist.');';
		return $this->_db->q('CALL get_landmarks('.$hotel_id.','.$lang_id.','.$dist.');');
	}

	public function getTotal() {
		$o = $this->_db->q("SELECT @total AS t");
		return intval($o[0]->t);
	}
}