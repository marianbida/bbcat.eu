<?php

final class SearchController {

    private $_template, $breadcrumbs, $parent;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang, $lang_id, $meta;

        $lang->load('ad/categories');
        $lang->load('ad/footer');

        $f = 0;
        $pages = "";
        $category_id = isset($_GET['c']) ? (int) $_GET['c'] : 1;
        $counter = 20;
        $curent_page = 1;
        $url_tail_arr = array();
        $url_tail = array();
        $err = array();

        if (isset($_GET['current_page'])) {
            $curent_page = $_GET['current_page'];
        }

        foreach ($_GET as $k => $v) {
            if (!empty($v) && !in_array($k, array('wm', 'current_page'))) {
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $url_tail_arr[] = $k . '[]=' . $vv;
                    }
                } else {
                    $url_tail_arr[] = $k . '=' . $v;
                }
            }
        }
        if (!empty($_GET['q'])) {
            $search_q = (string) $_GET['q'];
            $pages = Registry::get('item')->findRecords(($curent_page - 1) * 20, ($curent_page - 1) * 20 + 20, 1, $search_q);
            $total_search = Registry::get('item')->findRecordsCount(1, $search_q);

            if (!empty($pages)) {
                $f = 1;
            } else {
                $f = 2;
            }

            $tmp = $total_search % 20;
            if ($tmp > 0) {
                $t = (int) ($total_search / 20);
            } else {
                $t = $total_search / 20;
            }
            $tpl->assign('pages', $t);
        }
        $category = Registry::get('categories');
        $category_list = Registry::get('categories')->getRecords(0, 100, $category_id, $lang_id);
        $total_pages = Registry::get('item')->countRecords($category_id);
        $breadcrumbs = $category->getPathBack($category_id, $lang_id);
        $meta->title = sprintf("Търсене %s ", $_GET['q']);

        $tpl->assign('f', $f);
        $tpl->assign('pagess', $pages);
        $tpl->assign('breadcrumbs', $breadcrumbs);
        $tpl->assign('category_list', $category_list);
        $tpl->assign('total_pages', $total_pages);
        $url_tail = implode('&', $url_tail_arr);
        $tpl->assign('page', $curent_page);
        $tpl->assign('url', "?" . $url_tail);

        $this->_template = "search/index.tpl";
    }

}
