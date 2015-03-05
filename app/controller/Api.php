<?php

class ApiController extends BaseController {

    public function __construct() {
        $this->model['page'] = Registry::get('page');
    }

    public function index() {

        global $tpl, $lang, $lang_id;
        $prefix = "aboutus";

        $about = $this->model['page']->getRecordByPrefix($prefix, $lang_id);

        $lang->load('ad/categories');
        $lang->load('ad/footer');
        $lang->load('ad/about');

        $tpl->assign('about', $about);

        $this->setTemplate("api/index.tpl");
    }

}
