<?php

class HomeController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    private $breadcrumbs, $parent;

    public function index() {
        global $tpl, $lang, $lang_id, $meta;

        $lang->load('ad/categories');
        $lang->load('ad/footer');

        $page_list = array();
        $p = array();
        $curent_page = 1;
        $url_tail_arr = array();
        $category_id = isset($_GET['c']) ? (int) $_GET['c'] : 1;
        $err = array();

        if (isset($_GET['current_page'])) {
            $curent_page = $_GET['current_page'];
        }
        foreach ($_GET as $k => $v) {
            $in_arr = in_array($k, array('wm', 'current_page'));
            if (!empty($v) && !$in_arr) {

                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $url_tail_arr[] = $k . '[]=' . $vv;
                    }
                } else {
                    $url_tail_arr[] = $k . '=' . $v;
                }
            }
        }

        $category = Registry::get('categories');
        //$this->breadcrumbs  = Registry::get('categories')->breadcrumbs  ($lang_id);
        $this->parent = Registry::get('categories')->getParent($category_id);
        $sub_category_list = Registry::get('categories')->getRecords(0, 100, $category_id, $lang_id);
        $total_pages1 = Registry::get('item')->countRecords($category_id);

        $tmp = $total_pages1 % 20;
        if ($tmp > 0) {
            $t = (int) ($total_pages1 / 20);
        } else {
            $t = $total_pages1 / 20;
        }

        $breadcrumbs = $this->model->categories->getPathBack($category_id, $lang_id);
        $str = array();
        $i = 0;
        foreach ($breadcrumbs as $v => $value) {
            $str[$i] = ($value->name);
            $i++;
        }

        $title = "";
        for ($i = count($str) - 1; $i > 0; $i--) {
            $title = $title . $str[$i] . " | ";
        }

        $meta->title = $title . "Добави сайт | Директория Catalog.MyVarna.info";

        $total_pages = Registry::get('item')->countRecordsAll();

        $get_pages = Registry::get('item')->getRecords(($curent_page - 1) * 20, ($curent_page - 1) * 20 + 20, $category_id, 't1.`id` DESC');

        $tpl->assign('total_pages', $total_pages);
        $tpl->assign('page_list', $get_pages);
        $tpl->assign('category_list', $sub_category_list);
        $tpl->assign('breadcrumbs', $breadcrumbs);

        $url_tail = implode('&', $url_tail_arr);

        $tpl->assign('pages', $t);
        $tpl->assign('page', $curent_page);
        $tpl->assign('url', "?" . $url_tail);

        $this->setTemplate("home/index.tpl");
    }

}
