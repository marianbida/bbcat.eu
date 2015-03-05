<?php

class ViewController extends BaseController {

    private $breadcrumbs, $parent;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        global $tpl, $lang, $lang_id;

        $meta = $this->model->meta;

        $lang->load('ad/categories');
        $lang->load('ad/about');
        $lang->load('ad/footer');

        $req = $_GET['req'];
        $tmp_req = substr($req, strpos($req, '/') + 1, strripos($req, '/'));
        $page_list = array();
        $p = array();
        $url_tail_arr = array();
        $err = array();
        $curent_page = 1;
        $category_id = isset($_GET['c']) ? (int) $_GET['c'] : 1;

        $r = $this->model->item->getRecordView("t1.`id` = '{$tmp_req}'", $lang_id);
        $r = $r[0];
        $same_sites = $this->model->item->getRecordView("t1.`category` = '{$r->category}'", $lang_id, 10);
        $data = array(
            '0' => date("Y.m.d H:i:s"),
            '1' => $_SERVER['REMOTE_ADDR'],
            '2' => $tmp_req
        );
        $this->model->item->setStatData($data);

        $count = $this->model->item->countStatData($tmp_req);
        $today = date("Y.m.d");
        $tomorrow = date("Y.m.d", time() + 86400);

        $count_range = $this->model->item->countStatDataRange($tmp_req, $today, $tomorrow);
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/";
        $this->model->item->setCountStatData($count, $tmp_req);

        $tpl->assign('same_s', $same_sites);
        $tpl->assign('count_r', $count_range);
        $tpl->assign('ref', $ref);
        $tpl->assign('counter', $count);
        $tpl->assign('item', $r);

        if ($r) {
            $meta->title = $r->title;
            $meta->description = $r->description;
            $meta->keywords = $r->keywords;
        }

        $this->setTemplate("ad/view.tpl");
    }

}
