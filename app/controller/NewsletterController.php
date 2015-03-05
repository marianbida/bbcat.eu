<?php

final class NewsletterController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {

        global $tpl, $lang_id, $lang, $meta;

        $lang->load('newsletter/index');
        $lang->load('search/index');

        $data = new stdClass;
        $state = '';
        $tmp = Registry::get('page')->getRecord(20, $lang_id);

        $meta->title = $tmp[0]->page_title;
        $meta->description = $tmp[0]->page_description;
        $meta->keywords = $tmp[0]->page_keywords;
        $meta->page_title = $tmp[0]->title;
        $meta->page_content = $tmp[0]->content;

        if (isset($_POST["email"])) {
            $state = 0;
            $err = array();
            $check = Registry::get('check');

            $email = (string) $_POST["email"];
            $name = (string) $_POST["name"];
            $code = isset($_POST["code"]) ? (string) $_POST["code"] : '';
            $tac = isset($_POST['tac']) ? (int) $_POST['tac'] : 0;

            if (!$check->is_email($email)) {
                $err['email'] = $lang->getIn('v', 'email_not_valid');
            }
            if (empty($name)) {
                $err['name'] = $lang->getIn('v', 'name_empty');
            }
            if (empty($email)) {
                $err['email'] = $lang->getIn('v', 'email_empty');
            }
            if (Registry::get('user')->newsletter_signed($email)) {
                $err['email'] = $lang->getIn('v', 'alredy_signed');
            }
            if ($tac == 0) {
                $err['tac'] = $lang->getIn('v', 'check_terms');
            }
            if (!$check->is_code($code)) {
                $err['code'] = $lang->getIn('v', 'captcha_empty');
            }
            if (empty($err)) {
                $state = (int) Registry::get('newsletter')->signup(
                                array(
                                    'name' => $name,
                                    'email' => $email
                                )
                );
            } else {
                $tpl->assign("err", $err);
            }
        }

        $tpl->assign("data", $data);
        $tpl->assign("state", $state);

        $this->_template = "newsletter/index.tpl";
    }

}
