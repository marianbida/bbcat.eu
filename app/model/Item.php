<?php

	class Item
	{

		private static $instance;
		public static function getInstance()
		{    
			if (self::$instance === null) {
				$c = __CLASS__;
				self::$instance = new $c;
			}
			return self::$instance;
		}

		private $_table_media, $_table_quater_lang, $_db, $_cache;
        
		public function __construct()
		{
			$this->_db              = Registry::get('db');
			$this->_table_stat		= "cat_page_visit_stat";
			$this->_table_lang		= "cat_page_lang";
			$this->_table_category  = "cat_category";
			$this->_table_banned    = "cat_banned";
			$this->_table           = "cat_page";
			$this->_table_admin		= "cat_admin";
			$this->_table_paypal    = "paypal";
			$this->_letter          = "letter";
			$this->lang_id			= isset($_SESSION['lang_id']) ? $_SESSION['lang_id'] : 1;
			$this->langs			= Registry::get('lang')->getList();
			$this->_table_payment   = "payment";
			$this->media_cat_id		= 1;
			$this->_cache           = Registry::get('cache');

		}
		
    function getLetter($id)
	{
        $r = $this->_db->q( "
                SELECT *
                FROM `{$this->_letter}`
                WHERE `id` = '$id'
            ");
        return $r[0]->content;
    }
	
    function getPayment($name){
        $r = $this->_db->q( "
                SELECT *
                FROM `{$this->_table_payment}`
                WHERE `name` = '$name'
            ");
        return $r;
    }
	
    public function mailForId($id, $email){
        $r = $this->_db->q("
                SELECT COUNT(*) AS counter
                FROM `{$this->_table}`
                WHERE id = {$id}
                AND email = \"{$email}\";");
        if($r[0]->counter){
            return true;
        } else {
            return false;
        }
    }

    public function isHaveCheckId($id){
        $r = $this->_db->q("
                SELECT COUNT(*) AS counter
                FROM `{$this->_table}`
                WHERE id = {$id};");
        if($r[0]->counter){
            return true;
        } else {
            return false;
        }

    }
	
    function hmac($algo,$data,$passwd){
        # md5 and sha1 only
        $algo   =   strtolower($algo);
        $p      =   array('md5'=>'H32','sha1'=>'H40');

        if(strlen($passwd)>64) $passwd = pack   ($p[$algo], $algo($passwd));
        if(strlen($passwd)<64) $passwd = str_pad($passwd,   64,             chr(0));

        $ipad = substr($passwd,0,64) ^ str_repeat(chr(0x36),64);
        $opad = substr($passwd,0,64) ^ str_repeat(chr(0x5C),64);

        return($algo($opad.pack($p[$algo],$algo($ipad.$data))));
    }

    public function insertReport($report){

        $this->_db->q("
        INSERT INTO `{$this->_table_paypal}`
        (`report`) VALUES ('{$report}')");
    }

	public function setPayedOk($id)
	{
		$this->_db->q("
		UPDATE `{$this->_table}`
		SET
			`payed`     = 1
       WHERE id         = {$id}
       LIMIT 1

		;");

		return true;
	}

	public function insertRecord(Array $data = array()){

		$this->_db->q("
		INSERT INTO `{$this->_table}`
		SET
			`url`        = '{$data['address']}',
			`email`      = '{$data['email']}',
			`accepted`   = 'n',
			`category`   = '{$data['categories']}',
			`votes`      = 0,
			`visits`     = 0
		;");
		$id = $this->_db->insert_id;
		$this->_db->q("
		INSERT INTO `{$this->_table_lang}`
		SET
				`id`            = $id,
				`lang_id`		= 1,
				`title`			= '{$data['name']}',
				`description`   = '{$data['description']}',
				`keywords`		= '{$data['keywords']}'
                
		;");
             
		return $id;
	}

        public function setStatData($data){

            $this->_db->q("
            INSERT INTO `{$this->_table_stat}`
            SET
                `ip`         = '{$data[1]}',
                `date`       = '{$data[0]}',
                `page_id`    = '{$data[2]}'

            ;");

            return TRUE;
        }

        public function countStatData($id){
            $r = $this->_db->q("
		SELECT COUNT(*) AS counter
                    FROM `{$this->_table_stat}`
                    WHERE page_id = {$id};");

		return $r[0]->counter;
        }

         public function countStatDataRange($id,$start_date, $end_date){
            $r = $this->_db->q("
		SELECT COUNT(*) AS counter
                    FROM `{$this->_table_stat}`
                    WHERE page_id = {$id}
                    AND date BETWEEN '{$start_date}' AND '{$end_date}';");

		return $r[0]->counter;
        }

        public function setCountStatData($count, $id){
            $this->_db->q("
            UPDATE `{$this->_table}`
            SET
                    `visits`    = '{$count}',
            WHERE   id          = {$id}
            LIMIT 1

            ;");

            return TRUE;
        }

        public function getRecords($offset = 0, $count = 20, $category_id = NULL,  $ord = '', $is_exist = null)
        {
            $w = array();
            if ($category_id !== NULL) {
                $w[] = "t1.`category` = '{$category_id}' AND t1.`accepted` = 'y' ";
            }
            if ($is_exist !== NULL) {
                $w[] = "t1.`url_exist` = '{$is_exist}' ";
            }
            $where = $w ? "WHERE " . implode(" AND ", $w) : '';
            $order = $ord != '' ? "ORDER BY {$ord}" : '';
            $q = "
            SELECT
                t1.`id`, t1.`udate`, t1.`url`, t1.`image`, t1.`email`, t1.`accepted`, t1.`ip`, t1.`category`, t1.`votes`, t1.`visits`,
                    t2.`title`, t2.`description`, t2.`keywords`
            FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON t2.`id` = t1.`id`
            {$where}
            {$order}
                    LIMIT {$offset}, {$count}

            ;";
            // @mail('marian.bida@gmail.com', 'q', $q);
            $r = $this->_db->q($q);
            // @mail('marian.bida@gmail.com', 'error', $this->_db);
            return $r;
        }

        public function getRecordView($where_p, $lang_id, $limit=1){
		//$limit = "LIMIT {$start}, {$count}";
            $where      = array();
            $where[]    = "{$where_p} AND t2.lang_id = '{$lang_id}'";
            $where      = $where ? "WHERE " . implode(" AND ", $where) : '';

            $q = "
            SELECT
                t1.`id`, t1.`url`, t1.`image`, t1.`email`, t1.`accepted`, t1.`ip`, t1.`category`, t1.`votes`, t1.`visits`,
                            t2.`title`, t2.`description`, t2.`keywords`
            FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON t2.`id` = t1.`id`
            {$where}
            LIMIT {$limit}

            ;";
            $r = $this->_db->q($q);
			if ($r) {
				return $r;
			}
			return null;
        }
         
         public function getAllRecords(){
            $q = "
            SELECT
                t1.`id`, t1.`udate`, t1.`url`, t1.`image`, t1.`email`, t1.`accepted`, t1.`ip`, t1.`category`, t1.`votes`, t1.`visits`,
                                t2.`title`, t2.`description`, t2.`keywords`
            FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON      t2.`id`         = t1.`id`
            WHERE   t1.`accepted`   = 'y'

            ;";
            return  $this->_db->q($q);
        }

        public function findRecords($limit1,$limit2, $lang_id = 1, $word=""){
            $q = "
                SELECT
                                t1.`id`, t1.`udate`, t1.`url`, t1.`image`, t1.`email`, t1.`accepted`, t1.`ip`, t1.`category`,
                                t1.`votes`, t1.`visits`, t2.`title`, t2.`description`, t2.`keywords`
                FROM `{$this->_table}` AS t1
                LEFT JOIN `{$this->_table_lang}` AS t2
                ON t2.`id` = t1.`id`
                        WHERE
                                t2.`lang_id`    = '{$lang_id}' AND
                                t1.`accepted`   = 'y' AND
                                t2.`title`          LIKE '%{$word}%' OR
                                t2.`description`    LIKE '%{$word}%' OR
                                t2.`keywords`       LIKE '%{$word}%' OR
                                t1.`url`            LIKE '%{$word}%'
                LIMIT {$limit1}, {$limit2}
            ;";
                
            return $this->_db->q($q);
        }
         public function findRecordsCount($lang_id = 1, $word="") {

             $r = $this->_db->q( "
            SELECT COUNT(*) AS counter
                    FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON t2.`id` = t1.`id`
            WHERE
                t2.`lang_id`    = '{$lang_id}' AND
                t1.`accepted`   = 'y' AND
                t2.`title`          LIKE '%{$word}%' OR
                t2.`description`    LIKE '%{$word}%' OR
                t2.`keywords`       LIKE '%{$word}%' OR
                t1.`url`            LIKE '%{$word}%'

            ;");

            return  $r[0]->counter;
        }
         
        public function isHaveCheck($url_for_check) {
            $r = $this->_db->q("
                    SELECT COUNT(`url`) AS `total`
            FROM `{$this->_table}`
                    WHERE `url` LIKE '{$url_for_check}'
            ;");
            if ($r[0]->total>0) {
                return 1;
            } else {
                return 0;
            }
        }

	public function sendEmail($data, $msg) {
		$email = new Email;
		$email->from    (array(CONTACT_EMAIL,'marian.bida@gmail.com'));
		$email->to      ($data['email']);
		$email->subject ('Publised site');
		$email->message ($msg);
		return $email->send();
	}
	
	public function countRecords($category_id) {

        $r = $this->_db->q("
		SELECT COUNT(*) AS `total`
		FROM `{$this->_table}`
                WHERE 
                    `category`  = '{$category_id}' AND
                    `accepted`  = 'y'
		;");
		if ($r) {
			return $r[0]->total;
		}
		return 0;
	}
    public function countRecordsAll() {
            $r = $this->_db->q("
            SELECT COUNT(*) AS `total`
            FROM `{$this->_table}`
                    WHERE `accepted` = 'y'
            ;");
            if ($r) {
                return $r[0]->total;
            }
            return 0;
    }
}