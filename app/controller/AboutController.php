<?php

class AboutController extends BaseController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {

        global $tpl, $lang, $lang_id;
        $prefix = "aboutus";
        $about = Registry::get('page')->getRecordByPrefix($prefix, $lang_id);
        $lang->load('ad/categories');
        $lang->load('ad/footer');
        $lang->load('ad/about');

        $tpl->assign('about', $about);

        $this->_template = "about/index.tpl";
    }

}
