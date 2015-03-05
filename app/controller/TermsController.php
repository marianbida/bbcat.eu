<?php

final class TermsController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang_id, $lang, $meta;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $tmp = Registry::get('page')->getRecord(9, $lang_id);
        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->h1 = $tmp->page_title;
        $meta->h2 = $tmp->page_title;
        $meta->content = $tmp->content;

        $this->_template = "terms/index.tpl";
    }

}
