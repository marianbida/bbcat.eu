<?php

final class BrochureController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $lang_id, $lang, $tpl;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $this->_template = "brochure.tpl";
    }

    public function get() {
        global $lang_id, $lang, $tpl;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $this->_template = "brochure.tpl";
    }

}
