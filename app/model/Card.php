<?php
class Card {

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
		global	$tpl;
		$this->_tpl				=&	$tpl;
		$this->_db				=&	DB::getInstance();
		$this->_table			=	"card_order";
		$this->_table_item		=	"card_item";
		
		$this->_table_lang		=	"news_lang";
		$this->_table_key		=	"user_ref";
		$this->_table_ad_lang	=	"products_lang";
		$this->_table_media		=	"media";
		$this->_lang_list		=	array(1);
	}
	
	public function in_order($data)
	{
		$q = "
		SELECT `id`
		FROM `{$this->_table_item}`
		WHERE `order_id` = {$data['order_id']} AND `item_id` = {$data['item_id']}
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$r->free();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function getOrderByKey($data)
	{
		$out	= new stdClass;
		$q = "
		SELECT *
		FROM `{$this->_table}`
		WHERE `key` = '{$data['key']}' AND `state` = 1
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$out = $r->fetch_object();
			$r->free();
		} else {
			$id = $this->createOrder($data);
			$out = $this->getOrderById($id);
		}
		return $out;
	}

	public function getOrderById($id)
	{
		$out = new stdClass;
		$q = "
		SELECT * 
		FROM `{$this->_table}`
		WHERE `id` = $id
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$out = $r->fetch_object();
			$r->free();
		}
		return $out;
	}

	public function createOrder($data)
	{
		/*$q = "
		INSERT INTO `{$this->_table}`
		SET		`key`		=	'{$data['key']}',
				`user_id`	=	{$data['user_id']},
				`state`		=	1
		;";*/
		$verified	=	isset($data["user_id"]) ? 1 : 0;
		$user_id	=	isset($data["user_id"]) ? (int) $data['user_id'] : 0;
		$q = "
		INSERT INTO `{$this->_table}`
		SET		`key`		=	'{$data['key']}',
				`state`		=	1,
				`verified`	=	{$verified},
				`user_id`	=	{$user_id}
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? $this->_db->insert_id : 0;
	}
	/**
	 * @param $data[id, lang_id]
	 **/
	public function get(Array $data)
	{
		$out = new stdClass;
		$q = "
		SELECT t1.`news_id`, t1.`news_image` as `image`, t2.*, t3.`file` as `news_image`
		FROM `{$this->_table}` t1
		INNER JOIN `{$this->_table_lang}` t2
		ON t1.`news_id` = t2.`news_id` AND t2.`lang_id` = {$data['lang_id']}
		LEFT JOIN `media` t3
		ON t1.`news_id` = t3.`item_id` AND t3.`category_id` = 2 AND t3.`ord` = 0
		WHERE t1.`news_id` = '{$data['id']}'
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
		}
		return $o;
	}

	public function getComplex(Array $data)
	{
		$out = new stdClass;
		$out->items = array();
		$q = "
		SELECT t1.*, t2.item_id, t2.`price`, t2.`other`, t2.`quantity`, t3.`title`, t3.`description`, t4.`file`
		FROM `{$this->_table}` AS t1
		LEFT JOIN `{$this->_table_item}` AS t2
		ON t2.`order_id` = t1.`id`
		LEFT JOIN `{$this->_table_ad_lang}` t3
		ON t2.`item_id` = t3.`product_id` AND t3.`lang_id` = 1
		LEFT JOIN `{$this->_table_media}` t4
		ON t2.`item_id` = t4.`item_id` AND t4.`ord` = 0
		WHERE t1.`id` = {$data['id']}
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if ($r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out->id 				=	$o->id;
				$out->sub_total			=	$o->sub_total;
				$out->discount			=	$o->discount;
				$out->discount_percent	=	$o->discount_percent;
				$out->discount_code		=	$o->discount_code;
				$out->delivery			=	$o->delivery;
				$out->total				=	$o->total;
				$out->first_name		=	$o->first_name;
				$out->last_name			=	$o->last_name;
				$out->phone				=	$o->phone;
				$out->email				=	$o->email;
				$out->city_id			=	$o->city_id;
				$out->city				=	$o->city;
				$out->address			=	$o->address;
				$out->common			=	$o->common;
				$out->company_name		=	$o->company_name;
				$out->company_vat		=	$o->company_vat;
				$out->city_id			=	$o->city_id;
				$out->method_of_payment	=	$o->method_of_payment;
				$out->monthly_newsletter=	$o->monthly_newsletter;
				$out->received_date		=	$o->received_date;
				$out->processed_date	=	$o->processed_date;
				$out->verified			=	$o->verified;
				$out->state				=	$o->state;
				$out->items[]			=	$o;
			};
			$r->free();
		}
		//dump($out);
		return $out;
	}

	//
	public function editItem($data)
	{
		$set = '';
		$SET = array();
		foreach ($data as $k => $v) {
			$SET[] = "`$k` = \"" . $this->_db->escape($v) . "\" ";
		}
		$q = "
		UPDATE	`{$this->_table_item}`
		SET		" . implode(", ", $SET) . "
		WHERE	`item_id`	=	{$data["item_id"]} AND `order_id` = {$data["order_id"]}
		;";
		//echo $q;
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}

	public function createTemp ()
	{
		//delete temp news
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
			`temp`				=	1
		;";
		$this->_db->q($q);
		$id = $this->_db->insert_id;
		//insert into main
		foreach ($this->_lang_list as $item) {
			$q = "
			INSERT INTO `{$this->_table_lang}`
			SET
				`lang_id`	=	{$item},
				`news_id`	=	$id
			";
			$this->_db->q($q);
		}
		return $id;
	}

	/* add */
	public function addToOrder($data)
	{
		$q = "
		INSERT INTO `{$this->_table_item}`
		SET		`order_id`	=	{$data['order_id']},
				`item_id`	=	{$data['item_id']},
				`price`		=	{$data['price']},
				`quantity`	=	{$data['quantity']}
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	
	public function fixOrder($data)
	{
		$q = "
		UPDATE `{$this->_table}`
		SET		`sub_total` = (SELECT SUM(`price` * `quantity`) FROM `{$this->_table_item}` WHERE `order_id` = {$data['order_id']}),
				`items_total`	=	(SELECT COUNT(*) FROM `{$this->_table_item}` WHERE `order_id` = {$data['order_id']}),
				`discount`		=	( sub_total / 100 ) * discount_percent,
				`delivery`		=	IF(sub_total - discount < 50, city_price, 0),
				`total`			=	sub_total - discount + delivery
		WHERE `id` = {$data['order_id']}
		;";
		$this->_db->q($q);
	}

	public function removeFromOrder($data)
	{
		$q = "
		DELETE FROM `{$this->_table_item}`
		WHERE	`order_id`	=	{$data['order_id']} AND
				`item_id`	=	{$data['item_id']}
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}

	public function removeRecord($id)
	{
		//remove from main
		$q = "
		DELETE FROM `{$this->_table}`
		WHERE `id` = $id
		LIMIT 1
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows == 1 ? TRUE : FALSE;
	}

	public function getRecords($data)
	{
		$out	=	array();
		$limit	=	'';
		$where	=	array();
		if (isset($data['state'])) {
			$where[] = "t1.`state` = {$data['state']}";
		}
		if (isset($data['state_gt'])) {
			$where[] = "t1.`state` >= {$data['state_gt']}";
		}
		if (isset($data['verified'])) {
			$where[] = "t1.`verified` >= {$data['verified']}";
		}
		if (isset($data['user_id'])) {
			$where[] = "t1.`user_id` = {$data['user_id']}";
		}
		if (isset($data['page'])) {
			$page_count =	isset($data["limit"]) ? (int) $data["limit"] : ITEMS_PER_PAGE;
			$page_start	=	$page_count * ($data['page'] - 1);
			$limit = "LIMIT $page_start, $page_count";
			unset($data['page']);
		}
		$where = empty($where) ? '' : "WHERE " . implode(" AND ", $where);
		$q = "
		SELECT t1.*
		FROM `{$this->_table}` t1
		$where
		ORDER BY t1.`id` DESC
		$limit
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if (@$r && $r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out[] = $o;
			}
			$r->free();
		}
		
		return $out;
	}

	public function getTotal($data)
	{
		$total =	0;
		$where	=	array();
		if (isset($data['state'])) {
			$where[] = "t1.`state` = {$data['state']}";
		}
		if (isset($data['state_gt'])) {
			$where[] = "t1.`state` >= {$data['state_gt']}";
		}
		if (isset($data['verified'])) {
			$where[] = "t1.`verified` >= {$data['verified']}";
		}
		if (isset($data['user_id'])) {
			$where[] = "t1.`user_id` = {$data['user_id']}";
		}
		$where = empty($where) ? '' : "WHERE " . implode(" AND ", $where);
		$q = "
		SELECT COUNT(*) as `total`
		FROM `{$this->_table}` t1
		$where
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->total;
			$r->free();
		}
		return $total;
	}

	/**
	 * @param	<array> $data[<int> user_id, <string> key]
	 * @return	<bool> state
	 */
	public function updateOrderUser($data)
	{
		$q = "
		UPDATE	`{$this->_table}`
		SET		`user_id`	=	{$data['user_id']}
		WHERE	`key`		=	\"{$data['key']}\"
		LIMIT 1
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	public function updateOrderDiscount($data)
	{
		$where = array();
		foreach ($data as $k => $v) {
			if (!in_array($k, array('discount_percent','discount_code'))) {
				$where[] = " t1.`{$k}` = \"{$v}\" ";
			}
		}
		$WHERE = !empty($where) ? "WHERE " . implode(" AND ", $where) : '';
		$q = "
		UPDATE	`{$this->_table}` t1
		SET		t1.`discount_percent`	=	{$data['discount_percent']},
				t1.`discount_code`		=	\"{$data['discount_code']}\"
		$WHERE
		LIMIT 1
		;";
		//dump($q);
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}

	public function updateItemsOrderId ($order_old, $order_new)
	{
		$q = "
		UPDATE `{$this->_table_item}`
		SET `order_id` = {$order_new}
		WHERE `order_id` = {$order_old}
		;";
		$this->_db->q($q);
		if ($this->_db->affected_rows > 0) {
			$this->fixOrder(
				array (
					"order_id"	=>	$order_new
				)
			);
		}
	}
	public function updateOrderDetails ($data) {
		foreach ($data as $k => $v) {
			$data[$k] = $this->_db->escape($v);
		}
		$where = array();
		$where[] = " t1.`id` = \"{$data['id']}\" ";
		$WHERE = !empty($where) ? "WHERE " . implode(" AND ", $where) : '';
		$q = "
		UPDATE	`{$this->_table}` t1
		SET		t1.`first_name`			=	\"{$data['first_name']}\",
				t1.`last_name`			=	\"{$data['last_name']}\",
				t1.`phone`				=	\"{$data['phone']}\",
				t1.`email`				=	\"{$data['email']}\",
				t1.`city_id`			=	{$data['city_id']},
				t1.`city_price`			=	\"{$data['city_price']}\",
				t1.`city`				=	\"" . $data['city'] . "\",
				t1.`address`			=	\"{$data['address']}\",
				t1.`common`				=	\"{$data['common']}\",
				t1.`company_name`		=	\"{$data['company_name']}\",
				t1.`company_vat`		=	\"{$data['company_vat']}\",
				t1.`method_of_payment`	=	\"{$data['method_of_payment']}\",
				t1.`monthly_newsletter`	=	\"{$data['monthly_newsletter']}\"
		$WHERE
		LIMIT 1
		;";
		//dump($q);
		$this->_db->q($q);
		//fix price
		$this->fixOrder(
			array (
				"order_id"	=>	$data['id']
			)
		);
		//echo $this->_db->affected_rows;
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	
	public function updateOrderState($id = null, $state = null)
	{
		$q = "
		UPDATE	`{$this->_table}` t1
		SET		t1.`state`			=	{$state}
		WHERE t1.`id` = $id 
		LIMIT 1
		;";
		$this->_db->q($q);
		
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	
	public function updateOrderProcessDate($id = null)
	{
		$q = "
		UPDATE	`{$this->_table}` t1
		SET		t1.`processed_date`	= NOW()
		WHERE	t1.`id` = $id 
		LIMIT	1
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	
	public function updateOrderRecivedDate($id = null)
	{
		$q = "
		UPDATE	`{$this->_table}` t1
		SET		t1.`received_date`	= NOW()
		WHERE	t1.`id` = $id 
		LIMIT	1
		;";
		$this->_db->q($q);
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}
	
	public function getCodeCount($code = null, $state = 1)
	{
		$total = 0;
		$q = "
		SELECT COUNT(*) as `total`
		FROM `{$this->_table}`
		WHERE `discount_code` = \"" . $code . "\" AND `state` >= $state
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = (int) $o->total;
			$r->free();
		}
		return $total;
	}
	public function verifyOrder ($key)
	{
		$q = "
		UPDATE `{$this->_table}`
		SET `verified` = 1
		WHERE `key` = '{$key}'
		
		;";
		//echo $q;
		$this->_db->q($q);
	}
	
}