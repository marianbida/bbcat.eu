<?php

final class User {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    private $_db;
    private $_table = "user", $_table_key = "user_ref", $_table_address = "user_address";

    public function __construct() {

        $this->_db = Registry::get('db');
    }

    public function assignKey($data) {

        $q = "
            INSERT INTO `{$this->_table_key}`
            SET `user_id`   =  {$data['user_id']},
                `key`       = '{$data['key']}'
		;";
        $this->_db->q($q);
        return $this->_db->affected_rows > 0 ? TRUE : FALSE;
    }

    public function getKey($user_id) {
        $key = '';
        $q = "
            SELECT `key`
            FROM `{$this->_table_key}`
            WHERE `user_id` = $user_id
            LIMIT 1
		;";

        $r = $this->_db->q($q);
        if (@$r && $r->num_rows > 0) {
            $o = $r->fetch_object();
            $key = $o->key;
            $r->free();
        }
        return $key;
    }

    public function createKey() {
        $key = md5(time());
        $q = "
            INSERT INTO `{$this->_table_key}`
                SET `key` = '$key';";
        $this->_db->q($q);
        return $this->_db->affected_rows > 0 ? $key : NULL;
    }

    public function getList(Array $data = array()) {
        $start = 0;
        $count = ITEMS_PER_PAGE;
        if (isset($data['page'])) {
            $start = ITEMS_PER_PAGE * $data['page'];
        }
        return $this->_db->q("SELECT * FROM `{$this->_table}` ORDER BY `id` DESC LIMIT $start, $count;");
    }

    /**
     * @param $user | id or email
     *
     */
    function get($user) {
        $out = new stdClass;
        $q = "
            SELECT *
            FROM `{$this->_table}`
            WHERE   `id`    = '$user'
            OR      `email` = '$user';
		";
        $out = $this->_db->q($q);
        if ($out) {
            $out = $out[0];
            $out->address = $this->getAddressRecords($out->id);
        }
        return $out;
    }

    public function getAddressRecords($user_id) {
        $out = array();
        $q = "
            SELECT t1.*, t2.`title` as `city`
            FROM `{$this->_table_address}` t1
            LEFT JOIN `city_lang` t2
            ON t1.`city_id` = t2.`id` AND t2.`lang_id` = 1
            WHERE t1.`user_id` = $user_id
		;";
        return $this->_db->q($q);
    }

    public function removeAddressRecord($data) {

        $q = "DELETE
            FROM `{$this->_table_address}`
            WHERE   `user_id`   = {$data['user_id']}
            AND     `id`        = {$data['id']};";
        $this->_db->q($q);
        return TRUE;
    }

    public function insertAddressRecord($data) {

        $q = "
            INSERT INTO	`{$this->_table_address}`
            SET	`user_id` = {$data['user_id']},
                `city_id` = {$data['city_id']},
                `address` = \"{$data['address']}\"
		;";
        $this->_db->q($q);
    }

    public function setPasswordWithCode($data) {

        $q = "
		UPDATE `{$this->_table}`
            SET		`password`	=	MD5('{$data['password']}'),
                    `code`		=	''
            WHERE	`code`		=	'{$data['code']}';
		";
        $this->_db->q($q);
        return $this->_db->affected_rows > 0 ? TRUE : FALSE;
    }

    function edit($data) {

        $q = "
		UPDATE	`{$this->_table}`
            SET		`first_name`	=	\"{$data['first_name']}\",
                    `last_name`		=	\"{$data['last_name']}\",
                    `company`		=	\"{$data["company"]}\",
                    `phone`			=	\"{$data["phone"]}\",
                    `city`			=	\"{$data["city"]}\",
                    `email`			=	\"{$data['email']}\",
                    `admin`			=	'{$data['admin']}',
                    `newsletter`	=	'{$data['newsletter']}',
                    `access`		=	'{$data['access']}',
                    `client_no`		=	'{$data['client_no']}'
            WHERE	`id`            =   \"{$data['id']}\"
            LIMIT 1;
		";
        $this->_db->q($q);
        return $this->_db->affected_rows ? TRUE : FALSE;
    }

    function updatePassword($id, $password) {

        $q = "
            UPDATE	`{$this->_table}`
            SET		`password`		=	MD5(\"{$password}\")
            WHERE	`id`            = {$id}
            LIMIT 1
		;";
        if ($this->_db->error) {
            echo $this->_db->error;
        }
        $this->_db->q($q);
        return $this->_db->affected_rows ? TRUE : FALSE;
    }

    public function updateRecord($data) {

        $SET = array();
        $WHERE = array();
        foreach ($data as $k => $v) {
            if ($k != "where") {
                $SET[] = " `{$k}` = \"{$v}\" ";
            }
        }
        foreach ($data['where'] as $k => $v) {
            $WHERE[] = " `{$k}` = \"{$v}\" ";
        }
        $q = "
		UPDATE `{$this->_table}`
        SET " . implode(", ", $SET) . "
        WHERE " . implode(" AND ", $WHERE) . "
		;";
        $this->_db->q($q);
    }

    function getNewsletterList() {
        $list = array();
        $q = "
            SELECT		`email`,`full_name`
            FROM		`{$this->_table}`
            WHERE		`newsletter` = 1
            ORDER BY	`full_name` ASC
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

    function remove($user_id) {

        $q = "
            DELETE FROM `{$this->_table}`
            WHERE `id` = '$user_id';
		";
        $this->_db->q($q);
        return $this->_db->affected_rows ? TRUE : FALSE;
    }

    public function auth($user, $pass) {

        $out = FALSE;
        $q = "
            SELECT *
            FROM `{$this->_table}`
            WHERE ( 
                    `username`  = '{$user}' OR
                    `email`     = \"{$user}\") AND
                    `password`  = MD5('{$pass}'
                  );
		";
        $out = $this->_db->q($q);
        if ($out) {
            $out = $out[0];
        }
        return $out;
    }

    public function register($data) {

        foreach ($data as $item) {
            $this->_db->escape($item);
        }
        $code = md5(time());
        $ip = $_SERVER['REMOTE_ADDR'];
        $q = "
		INSERT INTO `{$this->_table}`
		SET
			`ip`			=	'$ip',
			`first_name`	=	\"{$data['first_name']}\",
			`last_name`		=	\"{$data['last_name']}\",
			`phone`			=	\"{$data['phone']}\",
			`email`			=	\"{$data['email']}\",
			`username`		=	\"{$data['username']}\",
			`code`			=	'$code',
			`password`		=	MD5('{$data['password']}'),
			`state`			=	3,
			`posted`		=	now()
		;";
        $this->_db->q($q);
        $id = (int) $this->_db->insert_id;
        //insert address
        $q = "
		INSERT INTO `{$this->_table_address}`
		SET
                `user_id` = $id,
                `city_id` = {$data['city_id']},
                `address` = \"{$data['address']}\"
		;";
        $this->_db->q($q);

        return $this->_db->affected_rows > 0 ? (int) $id : 0;
    }

    public function add($data) {
        foreach ($data as $item) {
            $this->_db->escape($item);
        }
        $q = "
		INSERT INTO	`{$this->_table}`
		SET			`username`		=	\"{$data['username']}\",
					`password`		=	\"{$data['password']}\",
					`email`			=	\"{$data['email']}\",
					`full_name`		=	\"{$data['full_name']}\",
					`city`			=	\"{$data['city']}\",
					`phone`			=	\"{$data['phone']}\",
					`company`		=	\"{$data['company']}\",
					`newsletter`	=	'{$data['newsletter']}',
					`admin`			=	'{$data['admin']}',
					`client_no`		=	'{$data['client_no']}'
		;";
        $this->_db->q($q);
        return $this->_db->affected_rows > 0 ? $this->_db->insert_id : 0;
    }

    public function activate($user_id) {
        $q = "
            UPDATE	`{$this->_table}`
            SET		`state`	=	3
            WHERE	`id`	=	$user_id;
		";
        $this->q($q);
        return $this->affected_rows == 1 ? TRUE : FALSE;
    }

    public function user_activate($data) {

        $q = "
		UPDATE	`{$this->_table}`
		SET		`state`	=	2
		WHERE
			`id`	=	{$data['id']} AND
			`code`	=	'{$data['code']}';
		";
        $this->q($q);
        return $this->affected_rows == 1 ? TRUE : FALSE;
    }

    public function deactivate($user_id) {
        $q = "
		UPDATE	`{$this->_table}`
		SET		`state`	=	2
		WHERE	`id`	=	$user_id;
		";
        $this->q($q);
        return $this->affected_rows == 1 ? TRUE : FALSE;
    }

    public function generateLostPasswordCode($data) {
        $q = "
		UPDATE	`{$this->_table}`
		SET		`password`	=	'',
				`code`	=	MD5(NOW())
		WHERE	`email`	=	'{$data['email']}';
		";
        $this->_db->q($q);
    }

    public function sendLostPassword($data) {

        $this->generateLostPasswordCode($data);

        $data = $this->get($data['email']);
        $email = new Email;
        $this->_tpl->assign("data", $data);

        $msg = $this->_tpl->fetch("user/lost_password_letter.tpl");

        $email->from('marian.bida@gmail.com', 'Забравена парола / Lost Password');
        $email->to($data->email);
        $email->subject('Забравена парола / Lost Password');
        $email->message($msg);
        return $email->send();
    }

    public function sendActivationRequest($user_id) {
        $data = $this->get($user_id);
        $email = new Email;
        $this->_tpl->assign("data", $data);
        $msg = $this->_tpl->fetch("user/register_confirm_letter.tpl");

        $email->from('marian.bida@gmail.com', 'VilexAuto / Admin');
        $email->to($data->email);
        $email->subject('Account activation');
        $email->message($msg);
        return $email->send();
    }

    public function exist($data) {
        $WHERE = array();
        $WHERE[] = " `{$data['key']}` = '{$data['val']}' ";
        if (isset($data['not'])) {
            $WHERE[] = " `{$data['not']['key']}` != \"{$data['not']['val']}\" ";
        }
        $q = "
            SELECT `id`
            FROM `{$this->_table}`
            WHERE " . implode(" AND ", $WHERE) . "
            LIMIT 1;
		";
        $r = $this->_db->q($q);
        if (@$r && $r->num_rows > 0) {
            $r->free();
            return TRUE;
        }
        return FALSE;
    }

    public function getTotal() {
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

    public function touchLastLogin($user_id) {
        $q = "
            UPDATE `{$this->_table}`
            SET     `last_login`= NOW()
            WHERE   `id`        = $user_id
		;";
        $this->_db->q($q);
    }

    public function newsletter_signed($email) {
        $q = "
            SELECT `id`
            FROM `{$this->_table}`
            WHERE
                `email`         = '{$email}' AND
                `newsletter`    = 1
            LIMIT 1;
        ";
        $r = $this->_db->q($q);
        if ($r && $r->num_rows > 0) {
            return TRUE;
        }
        return FALSE;
    }

}
