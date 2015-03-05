<?php

final class NewsController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang_id, $lang, $menu_index, $meta;
        $menu_index = 4;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $tmp = Registry::get('page')->getRecord(5, $lang_id);
        $tmp = $tmp[0];

        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;

        $menu_index = 4;

        $tpl->assign('news_list', Registry::get('news')->getRecords(0, 20, $lang_id));
        $this->_template = "news.tpl";
    }

    public function view($id = NULL) {
        global $tpl, $lang_id, $lang;
        $tpl->assign("data", Registry::get('news')->getRecord($id[0], $lang_id));
        $this->_template = "news/view.tpl";
    }

}
