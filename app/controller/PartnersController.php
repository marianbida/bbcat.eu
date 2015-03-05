<?php

final class PartnersController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang_id, $lang, $meta;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $tmp = Registry::get('page')->getRecord(7, $lang_id);

        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;

        $tpl->assign("partner_list", Registry::get('partner')->getRecords());

        $this->_template = "partner/index.tpl";
    }

}
