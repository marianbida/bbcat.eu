<?php

ob_start();

session_start();
error_reporting(E_ALL);

include 'app/conf/app.php';

include ROOT . 'class/Smarty.php';
include ROOT . 'class/Registry.php';
include ROOT . 'class/Check.php';
include ROOT . 'class/Benchmark.php';
include ROOT . 'class/Cache.php';

$ben = new Benchmark();
$ben->mark('start');

$lang_id = $_POST['lang_id'];
$lang_code = 'bg';

include ROOT . 'lang/' . $lang_code . '/common.php';

//
$tpl = new Smarty;
$tpl->template_dir = ROOT . 'view';
$tpl->compile_dir = ROOT . 'view_c';
$tpl->cache_dir = ROOT . 'cache';

include ROOT . 'lang/' . $lang_code . '/common.php';

$tpl->assign("lang", $_);
//$tpl->assign("lang_id", $lang_id);
//$tpl->assign("lang_ids", $lang_ids);
$tpl->assign("base_url", BASE_URL);
$tpl->assign("mode", isset($_GET['mode']) ? $_GET['mode'] : 'normal');
//$tpl->assign("id", $id );
//$tpl->assign("action", $action );
//$tpl->assign("lang_list", $l->getList() );
//$tpl->assign("view", $view );

include 'class/DB.php';
include 'class/JSON.php';

//common
function dump($o) {
    echo '<pre style="text-align:left">';
    print_r($o);
    echo '</pre>';
}

$action = $_REQUEST['action'];
$module = $_REQUEST['module'];

$json = new JSON;

switch ($module) {
    case "review":
        include 'class/Review.php';
        $rev = Review::getInstance();
        switch ($action) {

            case "list":
                $tpl->assign('list', $rev->getRecords($_POST['hotel_id'], 1, 0, 20, $_POST['filter']));
                $tpl->display('review/list.tpl');

                break;

            case "add":
                $check = new Check;

                $valid = 1;

                $err = array();

                $state = FALSE;

                $user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

                //$email	=	(string) $_POST["email"];
                //$name	=	(string) $_POST["name"];
                //$code	=	isset($_POST["code"]) ? (string) $_POST["code"] : '';
                //$tac	=	isset($_POST['tac']) ? (int) $_POST['tac'] : 0;

                if (empty($_POST['key'])) {
                    $err['key'] = $_['validation']['group'];
                }
                if (empty($_POST['name'])) {
                    $err['name'] = $_['validation']['first_name'];
                }
                if (empty($_POST['content'])) {
                    $err['content'] = $_['validation']['review'];
                }
                //if (!$check->is_code($_POST['code'])) {
                //$err['code'] =	$_['validation']['captcha'];
                //}
                if ($valid && sizeof($err) == 0) {
                    unset($_POST['module']);
                    unset($_POST['action']);
                    unset($_POST['code']);

                    $state = $rev->publish($_POST);
                } else {
                    $json->err = $err;
                    $state = 0;
                }
                $json->state = $state;
                $json->display();
                break;
        }
        break;
    case "model":
        include 'class/Model.php';
        $model = new Model;
        switch ($action) {

            case "get_front_model_list":
                $brand_id = $_POST["brand_id"];
                $data = array();
                if ($brand_id != '') {
                    $data["brand_id"] = $brand_id;
                }
                $list = $model->getList($data);
                $tpl->assign("list", $list);
                $json->list = $tpl->fetch("model/select_list.tpl");
                $json->display();
                break;

            case "get_front_mod_list":
                include 'class/Mod.php';
                $mod = new Mod;
                $brand_id = (int) $_POST["brand_id"];
                $model_id = isset($_POST["model_id"]) ? (int) $_POST["model_id"] : 0;
                $data = array();
                if ($brand_id > 0)
                    $data["brand_id"] = $brand_id;
                if ($model_id > 0)
                    $data["model_id"] = $model_id;
                $list = $mod->getList($data);
                $tpl->assign("list", $list);
                $json->list = $tpl->fetch("mod/select_list.tpl");
                $json->display();
                break;
        }
        break;

    case "media":
        break;

    case "category":
        include 'class/Category.php';
        $category = new category;
        switch ($action) {
            case "get_front_category_list":
                $category_id = (int) $_POST['parent'];
                $list = $category->getSubCategoryList($category_id);
                $tpl->assign("list", $list);
                $json->list = $tpl->fetch("category/ajax_option_list.tpl");
                $json->display();
                break;

            case "get_front_sub_category_option_list":
                $category_id = (int) $_POST['category_id'];
                $list = $category->getSubCategoryList($category_id);
                $tpl->assign("list", $list);
                $inf = new stdClass;
                $inf->category_id = $category_id;
                $inf->content = $tpl->fetch("category/ajax_option_list.tpl");
                exit(json_encode($inf));
                ;
                break;
            case "get_front_sub_category_list":
                $list = $category->getSubCategoryList($_POST['category_id']);
                $tpl->assign("list", $list);
                $tpl->display("category/index_list_sub.tpl");
                exit;
                break;
        }
        break;
}
$ben->mark('end');
echo $ben->time('start', 'end');

ob_end_flush();
