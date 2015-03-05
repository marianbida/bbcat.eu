<?php

$host = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'bbcat.eu';

// HTTP
define('HTTP_SERVER', "http://{$host}/");
define('HTTP_IMAGE', "http://{$host}/image/");

define("ROOT", '/home/myvarna/bbcat.eu/');
define("BASE_URL", "http://{$host}/");
define("ITEMS_PER_PAGE", 12);

// HTTPS
define('HTTPS_SERVER', '');
define('HTTPS_IMAGE', '');

// DIR
define('DIR_APPLICATION', ROOT . 'catalog/');
define('DIR_SYSTEM', ROOT . 'system/');
define('DIR_DATABASE', ROOT . 'system/database/');
define('DIR_LANGUAGE', ROOT . 'app/lang/');

define('DIR_TEMPLATE', ROOT . 'catalog/view/theme/');
define('DIR_CONFIG', ROOT . 'system/config/');
define('DIR_IMAGE', ROOT . 'image/');
define('DIR_CACHE', ROOT . 'app/cache/');
define('DIR_DOWNLOAD', ROOT . 'download/');
define('DIR_LOGS', ROOT . 'system/logs/');

$config = (object) array(
    // database
    'db' => (object) array(
    ),
    // ads
    'ad' => (object) array(
        'cost' => 'free'
    )
);

include 'db.php';
$config->db = $db;


// Error Reporting
error_reporting(E_ALL);

// Register Globals
session_set_cookie_params(0, '/');
session_start();

$globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);

foreach ($globals as $global) {
    foreach (array_keys($global) as $key) {
        unset($$key);
    }
}
// Magic Quotes Fix
if (ini_get('magic_quotes_gpc')) {

    function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[clean($key)] = clean($value);
            }
        } else {
            $data = stripslashes($data);
        }

        return $data;
    }

    $_GET = clean($_GET);
    $_POST = clean($_POST);
    $_COOKIE = clean($_COOKIE);
}

// Set default time zone if not set in php.ini
if (!ini_get('date.timezone')) {
    // date('e', $_SERVER['REQUEST_TIME'])
    date_default_timezone_set('Europe/Sofia');
}



error_reporting(E_ALL);

function __autoload($class) {
    if (is_file(ROOT . 'app/model/' . $class . '.php')) {
        require_once ROOT . 'app/model/' . $class . '.php';
    } else if (is_file(ROOT . 'app/controller/' . $class . '.php')) {
        require_once ROOT . 'app/controller/' . $class . '.php';
    } else if (is_file(ROOT . 'app/library/' . $class . '.php')) {
        require_once ROOT . 'app/library/' . $class . '.php';
    }
}

function dump($o) {
    echo '<pre style="text-align:left">';
    print_r($o);
    echo '</pre>';
}

Registry::get('db', $config->db);
