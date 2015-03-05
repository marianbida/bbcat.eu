<?php

final class AboutusController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang_id, $menu_index, $lang, $meta;

        $menu_index = 5;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $tmp = Registry::get('page')->getRecord(6, $lang_id);
        $tmp = $tmp[0];
        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;


        $this->_template = "aboutus.tpl";
    }

}
