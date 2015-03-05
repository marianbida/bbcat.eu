<?php

final class LogoutController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang_id, $lang, $curr_id, $meta;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $tmp = Registry::get('page')->getRecord(18, $lang_id);
        $tmp = $tmp[0];
        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;

        Log::getInstance()->put($_SERVER['REMOTE_ADDR'], isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0, 'logout', 'user', '-', '-', '-');

        unset($_SESSION['user_id'], $_SESSION['distributor'], $_SESSION['admin']);
        unset($_SESSION['full_name'], $_SESSION['access']);

        $this->_template = "user/logout.tpl";
    }

}
