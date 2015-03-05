<?php

final class Page {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    private $_table_media, $_table_quater_lang, $_db, $_cache;

    public function __construct() {
        $this->_db = Registry::get('db');
        $this->_table = "page";
        $this->_table_lang = "page_lang";
        $this->lang_id = isset($_SESSION['lang_id']) ? $_SESSION['lang_id'] : 1;
        $this->langs = Registry::get('lang')->getList();
        $this->_cache = Registry::get('cache');
    }

    public function getRecordByPrefix($prefix, $lang_id = 3) {
        $r = $this->_db->q("
            SELECT t1.*, t2.*
            FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON t2.`id` = t1.`id`
                WHERE t1.`prefix` = \"{$prefix}\" 
                AND t2.lang_id = {$lang_id};
        ");
        return $r;
    }

    public function get($pageId = null, $langId = null) {
        $r = $this->_db->q("
            SELECT t1.*, t2.*
            FROM `{$this->_table}` AS t1
            LEFT JOIN `{$this->_table_lang}` AS t2
            ON t2.`id` = t1.`id`
                WHERE t1.`id` = '{$pageId}' 
                AND t2.lang_id = {$langId};
        ");
        if ($r) {
            return $r[0];
        }
        return null;
    }

    /**
     * @return <array>
     */
    public function getRecords($start = 0, $count = 20, $parent = null, $tmenu = null, $bmenu = null, $sitemap = null, $lang_id = 1) {
        $w = array();
        if ($parent !== null) {
            $w[] = 't1.parent = ' . $parent;
        }
        if ($tmenu !== null) {
            $w[] = 't1.top_menu = \'' . $tmenu . '\'';
        }
        if ($bmenu !== null) {
            $w[] = 't1.bot_menu = \'' . $bmenu . '\'';
        }
        if ($sitemap !== null) {
            $w[] = "t1.sitemap = '{$sitemap}' ";
        }
        $q = '
		SELECT
			t1.*,
			t2.*
		FROM ' . $this->_table . ' t1
		LEFT JOIN ' . $this->_table_lang . ' t2
		ON t1.id = t2.id AND t2.lang_id = ' . $lang_id . ' ';
        $q .= $w ? 'WHERE ' . implode(' AND ', $w) : '';
        //$q .= ' ORDER BY t1.ord ASC';
        //dump($q);
        $out = $this->_db->q($q);
        return $out;
    }

}
