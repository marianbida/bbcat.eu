<?php

class Db {

    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    private $link;
    public $affected_rows = 0;
    public $insert_id = 0;
    public $lastQuery;

    public function __construct($conf = null) {
        $this->_conf = $conf;
        $this->link = mysqli_init();
        if (!$this->link) {
            die('mysqli_init failed');
        }
        if (!$this->link->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 1')) {
            die('Setting MYSQLI_INIT_COMMAND failed');
        }
        if (!$this->link->real_connect($this->_conf->host, $this->_conf->user, $this->_conf->pass, $this->_conf->base, 131072)) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        } else {
            $this->link->set_charset("utf8");
            $this->link->query('SET AUTOCOMMIT = 1');
        }
    }

    public function __destruct() {
        $this->link->close();
    }

    public function escape($str) {
        return get_magic_quotes_gpc() ? $this->link->escape_string(stripslashes($str)) : $this->link->escape_string($str);
    }

    public function decode($str) {
        return html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    }

    public function encode($str) {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }

    public function q($q) {
        //$start = $this->getTime();
        $out = array();
        if ($this->link->multi_query($q)) {
            do {
                $r = $this->link->store_result();
                if ($r) {
                    $mode = 'object';
                    while ($o = $r->{'fetch_' . $mode}()) {
                        $out[] = $o;
                    }
                    $r->free();
                }
            } while ($this->link->more_results());
        } else {
            //printf("<br />Second Error: %s\n", $this->link->error);
        }
        //$this->logQuery($q, $start);
        $this->logQuery($q);
        //$this->Result($q);
        $this->affected_rows = $this->link->affected_rows;
        $this->insert_id = $this->link->insert_id;
        return $out;
    }

    public function getTotal() {
        $out = $this->q("SELECT @total AS `t`");
        return (int) $out[0]->t;
    }

    private function logQuery($q) {
        $this->lastQuery = $q;
    }

}
