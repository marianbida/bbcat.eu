<?php

ini_set('ignore_repeated_errors', 1);
ini_set('ignore_repeated_source', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '2M');

include 'conf/app.php';

$tpl = Registry::get('smarty');
$tpl->template_dir = ROOT . 'app/view';
$tpl->compile_dir = ROOT . 'app/cache/view_c';

$user = Registry::get('user');
$conf = Registry::get('conf');
$page = Registry::get('page');

$lang_id = 3;
$lang_code = 'bg';
$lang_prefix = '';
$dir = 'ltr';

$curr_id = isset($_SESSION['curr_id']) ? $_SESSION['curr_id'] : 1;
$curr_code = '-';
$menu_index = 0;

$req = isset($_GET['req']) ? $_GET['req'] : 'home';

if (isset($_GET['req'])) {
    switch (substr($_GET['req'], 0, 2)) {
        case 'ru':
            $lang_id = 1;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'ru';
            $lang_prefix = 'ru/';
            $dir = 'ltr';
            break;

        case 'en':
            $lang_id = 2;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'en';
            $lang_prefix = 'en/';
            $dir = 'ltr';
            break;

        case 'bg':
            $lang_id = 3;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'bg';
            $lang_prefix = 'bg/';
            $dir = 'ltr';
            break;

        case 'fr':
            $lang_id = 4;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'fr';
            $lang_prefix = 'fr/';
            $dir = 'ltr';
            break;

        case 'de':
            $lang_id = 5;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'de';
            $lang_prefix = 'de/';
            $dir = 'ltr';
            break;

        case 'ro':
            $lang_id = 6;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'ro';
            $lang_prefix = 'ro/';
            $dir = 'ltr';
            break;

        case 'he':
            $lang_id = 7;
            $req = substr($_GET['req'], 3, strlen($_GET['req']));
            $lang_code = 'he';
            $lang_prefix = 'he/';
            $dir = 'rtl';
            break;

        default:
            $lang_id = 3;
            $lang_code = 'bg';
            $lang_prefix = '';
            $dir = 'ltr';
            break;
    }
    $tpl->assign("url_tail", $req);
}

if (isset($_GET['curr_id'])) {
    $_SESSION['curr_id'] = $_GET['curr_id'];
    $curr_id = $_SESSION['curr_id'];
}


$key = isset($_SESSION["key"]) ? (string) $_SESSION['key'] : (string) $user->createKey();
$_SESSION["key"] = $key;
$data = array(
    "key" => $key
);
if (isset($_SESSION["user_id"])) {
    $data["user_id"] = (int) $_SESSION['user_id'];
}

$lang = new Lang($lang_code);
$lang->load('common');

$tpl->assign("lang", $lang->getAll());
$tpl->assign("lang_id", $lang_id);
$tpl->assign("lang_code", $lang_code);
$tpl->assign("curr_id", $curr_id);
$tpl->assign('dir', $dir);

$tpl->assign("base_url", BASE_URL);
$tpl->assign("full_url", BASE_URL . $lang_prefix);
$tpl->assign("image_url", 'http://piqo.info/');

define('IMAGE_URL', 'http://www.piqo.info/');

$tpl->assign("mode", isset($_GET['mode']) ? $_GET['mode'] : 'normal');

$meta = Registry::get('meta');
$rq = $_SERVER['REQUEST_URI'];

if (preg_match('@poll\/view\/(\d+)@', $req, $o)) {
    $id = (int) $o[1];
    $mode = "view";
    include ROOT . "module/poll.php";
} else if (preg_match('@card/history@', $req, $o)) {
    $action = "history";
    include ROOT . "module/card.php";
} else if (preg_match('@card/send@', $req, $o)) {
    $action = "send";
    include ROOT . "module/card.php";
} else if (preg_match('@card/verify_human@', $req, $o)) {
    $check = Check::getInstance();
    $code = isset($_POST['code']) ? $_POST["code"] : '';
    $tac = isset($_POST['tac']) ? $_POST['tac'] : '';
    if ($check->is_code($code) && $tac == 'on') {
        //echo 'yes';
        ////echo $_SESSION["key"];
        $card->verifyOrder($_SESSION["key"]);
    }

    $goto = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "/";

    header("Location: " . $goto);

    exit;
} else if (preg_match('@card/(add|remove)/(\d+)@', $req, $o)) {
    $action = (string) $o[1];
    $item_id = (int) $o[2];
    include ROOT . "module/card.php";
} else if (preg_match('@card/update@', $req, $o)) {
    $action = "update";
    include ROOT . "module/card.php";
} else if (preg_match('@card/order@', $req, $o)) {
    $action = "order";
    include ROOT . "module/card.php";
} else if (preg_match('@card/process@', $req, $o)) {
    $action = "process";
    include ROOT . "module/card.php";
} else if (preg_match('@card/confirm/(\d+)@', $req, $o)) {
    $action = "confirm";
    $order_id = (int) $o[1];
    include ROOT . "module/card.php";
} else if (preg_match('@card@', $req, $o)) {
    $action = '';
    include ROOT . "module/card.php";
} else if (preg_match('@comment_add/(\d+)/@', $req, $o)) {
    $action = "add";
    $id = (int) $o[1];
    $tpl->assign("id", $id);
    include ROOT . "module/comment.php";
    exit;
} elseif (preg_match('@comment/approve/(\d+)@', $req, $o)) {

    $comment = Comment::getInstance();
    $id = (int) $o[1];
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $comment->activate(
                array(
                    "id" => $id
                )
        );
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} elseif (preg_match('@comment/reject/(\d+)@', $req, $o)) {

    $comment = Comment::getInstance();
    $id = (int) $o[1];
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $comment->remove(
                array(
                    "id" => $id
                )
        );
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<p>You are not supposed to be here</p>";
    }
    exit;
} else if (preg_match('@item/view/(\d+)/(.*)@', $req, $o)) {
    $ad_id = (int) $o[1];
    $exist = $ads->exist(
            array(
                "key" => "product_id",
                "val" => $ad_id
            )
    );

    if ($exist) {
        $action = "view";
        include ROOT . "module/ad.php";
    } else {
        $tpl->assign("action", "404");
        $template = "ad.tpl";
        header("HTTP/1.0 404 Not Found");
    }
} else if (preg_match('@item/request/(\d+)/(.*)@', $req, $o)) {
    $ad_id = (int) $o[1];
    $exist = $ads->exist(
            array(
                "key" => "product_id",
                "val" => $ad_id
            )
    );
    if ($exist) {
        $action = "request";
        include ROOT . "module/ad.php";
    }
} else if (preg_match('@item/request_help/(.*)@', $req, $o)) {
    $action = "request_help";
    include ROOT . "module/ad.php";
} else if (preg_match('@password_recovery/(\w{32})/(\d+)/@', $req, $o)) {
    $code = (string) $o[1];
    $user_id = (int) $o[2];
    include ROOT . "module/password_recovery.php";
} else if (preg_match('@profile/activate_code@', $req)) {
    $city = City::getInstance();
    $mode = "activate_code";
    include ROOT . "module/profile.php";
} else if (preg_match('@profile/edit_personal_info@', $req)) {
    $mode = "edit_info";
    include ROOT . "module/profile.php";
} else if (preg_match('@profile/edit_account@', $req)) {
    $mode = "edit_account";
    include ROOT . "module/profile.php";
} else if (preg_match('@profile/edit_password@', $req)) {
    $mode = "edit_password";
    include ROOT . "module/profile.php";
} else if (preg_match('@profile/add_address@', $req)) {
    $mode = "add_address";
    include ROOT . "module/profile.php";
} else if (preg_match('@profile/remove_address/(\d+)@', $req, $o)) {
    $mode = "remove_address";
    $id = (int) $o[1];
    include ROOT . "module/profile.php";
}
if (!empty($req)) {
    switch ($req) {
        case "promo":
            include ROOT . "module/promo.php";
            break;

        case "service":
            include ROOT . "module/service.php";
            break;

        case "advice":
            include ROOT . "module/advice.php";
            break;



        case "send_contact_request":
            include ROOT . 'module/send_contact_request.php';
            break;

        case "tyny_login.php":
            include ROOT . "module/tiny_login.php";
            break;
        case "recovery":
            include ROOT . "module/recovery.php";
            break;

        case "ad_popup":
            include ROOT . "module/ad_popup.php";
            break;

        case "sitemap_xml":
            $action = "xml";
            include ROOT . 'module/sitemap.php';
            break;
    }
}

$tpl->assign('meta', $meta);
$tpl->assign('lang_list', $lang->getList());
$tpl->assign('lp', $lang_prefix);

if (preg_match_all('@[^/]+@', $req, $element) > 0) {
    $controller = $element[0][0];
    $method = !empty($element[0][1]) ? $element[0][1] : 'index';
    $parameters = count($element[0]) > 2 ? array_slice($element[0], 2) : array();
    $filename = 'app/controller/' . ucfirst($controller) . 'Controller.php';
    if (is_file($filename)) {
        require_once($filename);
        $class = ucfirst($controller . 'Controller');
        $class = new $class();
        if (method_exists($class, $method)) {
            $class->$method($parameters);
        } else {
            $class->index($method, $parameters);
        }
        $template = $class->getTemplate();
    }
} else {
    require_once 'app/controller/HomeController.php';
    $class = 'HomeController';
    $class = new $class();
    $class->index();
    $template = $class->getTemplate();
}

$tpl->assign('lang', $lang->getAll());
$tpl->assign('template', $template);
$tpl->assign('total_pages', Registry::get('item')->countRecordsAll());
$tpl->assign('total_categories', Registry::get('categories')->countRecordsAll());
$tpl->assign('meta', $meta);


if ($controller == "autoload") {
    $tpl->display("autoload/index.tpl");
} else {
    $tpl->display("layout/default.tpl");
}

if (isset($_SESSION['step'])) {
    unset($_SESSION['step']);
}