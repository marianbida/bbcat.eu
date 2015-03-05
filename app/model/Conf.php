<?php

final class Conf {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    private $_table = 'config', $_db;
    var $list = array();

    public function __construct() {
        $this->_db = Registry::get('db');
        $this->list = $this->getList();


        /* foreach ($this->list as $k => $v) {
          if (!defined(strtoupper($k))) {
          define(strtoupper($k), $v);
          }
          } */
    }

    /**
     * Returns all semiconfig variables into an array.
     * @return array
     */
    public function getList() {
        $out = new stdClass;
        $r = $this->_db->q("SELECT * FROM `{$this->_table}`");
        if ($r) {
            foreach ($r as $o) {
                $out->{$o->key} = $o->val;
            }
            //$r->free();
        }
        return $out;
    }

    public function getRecords() {
        $out = array();
        $r = $this->_db->q("SELECT * FROM `{$this->_table}`");
        if (@$r && $r->num_rows > 0) {
            while ($o = $r->fetch_object()) {
                $out[] = $o;
            }
            $r->free();
        }
        return $out;
    }

    /**
     * Returns all semiconfig descriptions into an array.
     * @return array
     */
    public function getDescriptions() {
        $out = '';
        $r = $this->_db->q("SELECT `description` FROM `{$this->_table}`");
        if (@$r && $r->num_rows) {
            while ($o = $r->fetch_object()) {
                $out->{$o->key} = $o->description;
            }
            $r->free();
        }
        return $out;
    }

    /**
     * Returns all semiconfig descriptions into an array.
     * @return array
     */
    public function getDescription($key) {
        $out = '';
        $r = $this->_db->q("SELECT `description` FROM `{$this->_table}` WHERE `key` = '{$key}' ");
        if (@$r && $r->num_rows > 0) {
            $o = $r->fetch_object();
            $out = $o->description;
            $r->free();
        }
        return $out;
    }

    /**
     * 
     * Insert New Config Item
     * 
     * @param array $data[key,val]
     * @return bool
     */
    public function insertRecord($data) {
        $this->db->insert($this->_table, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get a variable name
     * @param <strong> $data | name
     * @return (str) value
     */
    public function getRecord($data = FALSE) {
        if ($data) {
            return $this->list->$data;
        } else {
            return $this->list;
        }
    }

    /**
     * 
     * Update a variable into database
     * 
     * @param (array) key => val
     * @return void
     */
    public function updateRecord($data) {
        foreach ($data as $k => $v)
            $data[$k] = $this->_db->escape($v);
        $q = "
            UPDATE `{$this->_table}`
            SET
                `val`           = \"{$data["val"]}\",
                `description`   = \"{$data['description']}\"
            WHERE
                `key`           = \"{$data['key']}\"
		;";
        $this->_db->q($q);
        if ($this->_db->affected_rows > 0) {
            
        }
        return TRUE;
    }

    /**
     * 
     * Remove Record
     * 
     * @param array $data[key]
     * @return bool
     */
    public function removeRecord($key) {
        $q = "
            DELETE FROM `{$this->_table}`
            WHERE `key` = \"{$key}\"
            LIMIT 1;
        ";
        $this->_db->q($q);
        if ($this->_db->affected_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
