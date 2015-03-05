<?php

final class Registry {

    static private $data = array();

    static public function get($key, $conf = null) {
        if (!isset(self::$data[$key])) {
            $_c_ = ucfirst($key);
            self::$data[$key] = $conf === null ? new $_c_ : new $_c_($conf);
        }
        return self::$data[$key];
    }

    static public function set($key, $value) {
        self::$data[$key] = $value;
    }

    static public function has($key) {
        return isset(self::$data[$key]);
    }

}
