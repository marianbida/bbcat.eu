<?php

final class ContactusController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index($method = NULL, $arg = array()) {
        global $tpl, $lang_id, $lang, $curr_id, $meta;

        $lang->load('newsletter/index');
        $lang->load('search/index');
        $lang->load('contactus/index');

        if (!empty($_POST)) {
            $check = Registry::get('check');
            $email = Registry::get('email');
            $err = array();
            $data = array(
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "email" => $_POST["email"],
                "phone" => $_POST["phone"],
                "message" => $_POST["message"],
                "code" => $_POST["code"]
            );
            if (empty($data['first_name'])) {
                $err['first_name_err'] = "Задължително"; //$language['validation']['first_name_required'];
            }
            if (empty($data['last_name'])) {
                $err['last_name_err'] = "Задължително"; //$language['validation']['first_name_required'];
            }
            if (empty($data['message'])) {
                $err['msg_err'] = "Моля, въведете съобщение"; //$language['validation']['msg_required'];
            }
            if (!$check->is_email($data['email'])) {
                $err['email_err'] = "Въведете валиден email"; //$language['validation']['email_not_valid'];
            }
            if (empty($data['email'])) {
                $err['email_err'] = "Въведете email"; //$language['validation']['email_required'];
            }
            if (!$check->is_code($data['code'])) {
                $err['code_err'] = "Невалиден код"; //$language['validation']['code_not_valid'];
            }
            if (empty($data['code'])) {
                $err['code_err'] = "Въведете код"; //$language['validation']['code_required'];
            }
            if (empty($err)) {
                unset($_SESSION['inquiry_error']);
                $tpl->assign($data);
                $msg = $tpl->fetch("contact/contact_inquiry.tpl");
                $email->from($data['email'], 'Request about from Visitor On web site');
                $email->to('marian.bida@gmail.com');
                $email->subject('Request about from Visitor On web site');
                $email->message($msg);
                $email->send();
                $_SESSION['step'] = "01";
            } else {
                $_SESSION['inquiry_error'] = $err;
            }
        } else {
            unset($_SESSION['inquiry_error']);
        }
        $tmp = Registry::get('page')->getRecord(8, $lang_id);
        $tmp = $tmp[0];
        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;

        $this->_template = "contactus.tpl";
    }

}
