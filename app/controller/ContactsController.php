<?php

final class ContactsController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {

        global $tpl, $lang, $lang_id;
        $prefix = 'contactus';
        $contacts = Registry::get('page')->getRecordByPrefix($prefix, $lang_id);

        $lang->load('ad/categories');
        $lang->load('ad/footer');
        $lang->load('ad/contacts');
        $lang->load('ad/about');

        $tpl->assign('contacts', $contacts);
        $this->_template = "contacts/index.tpl";
    }

}
