<?php

final class Categories {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    private $db, $_cache;

    public function __construct() {
        $this->db = Registry::get('db');
        $this->_table = "cat_category";
        $this->_table_lang = "cat_category_lang";
        $this->lang_id = isset($_SESSION['lang_id']) ? $_SESSION['lang_id'] : 1;
        $this->langs = Registry::get('lang')->getList();
        $this->media_cat_id = 1;
        $this->_cache = Registry::get('cache');
    }

    public function getRecords($start = 0, $count = 20, $category_id = NULL, $lang_id = 3) {
        $where = array();
        if ($category_id !== NULL) {
            $where[] = "t1.`ref` = '{$category_id}' ";
        }
        $where = $where ? "WHERE " . implode(" AND ", $where) : '';
        $order = '';
        $limit = "LIMIT {$start}, {$count}";
        $q = "
		SELECT 
			t1.`id`, t1.`pages`, t1.`ref`,
			t2.`name`, t2.`title`, t2.`description`, t2.`keywords`
		
		FROM `{$this->_table}` AS t1
		LEFT JOIN `{$this->_table_lang}` AS t2
		ON t2.`id` = t1.`id` AND t2.`lang_id` = '{$lang_id}'
		{$where}
		{$order}
		{$limit}
		;";
        return $this->db->q($q);
    }

    public function getParent($child = 1) {
        $where = "WHERE t1.`id` = {$child}";
        $r = $this->db->q("
                            SELECT t1.`ref`
                            FROM `{$this->_table}` AS t1
                            LEFT JOIN `{$this->_table_lang}` AS t2
                            ON t2.`id` = t1.`id`
                            {$where}
                        ;");
        if ($r) {
            return $r[0]->ref;
        }
        return 0;
    }

    public function breadcrumbs($lang_id = 1) {
        $r = $this->db->q("
                            SELECT t1.`ref`, t2.`name`, t1.`id`
                            FROM `{$this->_table}` AS t1
                            LEFT JOIN `{$this->_table_lang}` AS t2
                            ON t2.`id` = t1.`id` AND t2.`lang_id` = '{$lang_id}'
               ;");
        return $r;
    }

    public function getChild($lang_id = 1, $parent = 1) {
        $where = "WHERE t1.`ref` = {$parent}";
        $r = $this->db->q = "
                        SELECT t1.`ref`, t2.`name`, t1.`id`
                        FROM `{$this->_table}` AS t1
                        LEFT JOIN `{$this->_table_lang}` AS t2
                        ON t2.`id` = t1.`id` AND t2.`lang_id` = '{$lang_id}'
                        {$where}
                    ;";
        return $r;
    }

    public function getAllRecords() {
        return $this->db->q("
                        SELECT t1.`id`, t1.`ref`, t1.`udate`,
                        t2.`name`, t2.`description`
                        FROM `{$this->_table}` AS t1
                        LEFT JOIN `{$this->_table_lang}` AS t2
                        ON t2.`id` = t1.`id` AND t2.`lang_id` = 3
                    ;");
    }

    public function getAllRecordsCount() {
        $r = $this->db->q("
                            SELECT COUNT(*) AS `total`
                            FROM `{$this->_table}`
                            ;");
        if ($r) {
            return (int) $r[0]->total;
        }
        return 0;
    }

    public function getRecord($category_id = NULL, $lang_id = 1) {
        $q = "
                SELECT t1.`id`, t1.`ref`, t2.`name`
                FROM `{$this->_table}` AS t1
                LEFT JOIN `{$this->_table_lang}` AS t2
                ON t2.`id` = t1.`id` AND t2.`lang_id` = '{$lang_id}'
                WHERE t1.`id` = '{$category_id}'
		;";

        return $this->db->q($q);
    }

    public function getPathBack($category_id = NULL, $lang_id = 1) {
        return array_reverse($this->getPathRecource($category_id, $lang_id, array()));
    }

    private function getPathRecource($category_id = NULL, $lang_id = 1, $arr = array()) {
        $tmp = $this->getRecord($category_id, $lang_id);
        if ($tmp) {
            $arr[] = $tmp[0];
            return $this->getPathRecource($tmp[0]->ref, $lang_id, $arr);
        } else {
            return $arr;
        }
    }

    public function countRecordsAll() {
        $r = $this->db->q("
		SELECT COUNT(*) AS `total`
		FROM `{$this->_table}`
		;");
        if ($r) {
            return (int) $r[0]->total;
        }
        return 0;
    }

}
