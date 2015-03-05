<?php

final class CategoriesController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {

        global $tpl, $lang;

        $lang->load('ad/categories');
        $lang->load('ad/footer');
        //define empty array
        $err = array();
        //step declare
        $step = '00';
        $item = "";

        // check whatever there is a send action to this controller
        // has the form sended data
        if (!empty($_POST)) {
            // create empty error array
            //collect data
            //variable name from form
            //variab name from from
            $address = $_POST['address'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $keywords = $_POST['keywords'];
            $email = $_POST['email'];
            if (empty($address) || !($check->is_url($address))) {
                $err['address'] = $lang->getIn('v', 'address_req');
            }
            if (empty($name) || (strlen($name) < 5) && (strlen($name) > 128)) {
                $err['name'] = $lang->getIn('v', 'name_req');
            }
            if (empty($description) || (strlen($description) < 20) && (strlen($description) > 200)) {
                $err['description'] = $lang->getIn('v', 'description_req');
            }
            if (empty($keywords) || (strlen($keywords) < 20) && (strlen($keywords) > 200)) {
                $err['keywords'] = $lang->getIn('v', 'keywords_req');
            }
            if (empty($email) || !($check->is_email($email))) {
                $err['email'] = $lang->getIn('v', 'email_req');
            }
            //check whatever err arrray is empty, means there was not validation errors found
            if (empty($err)) {

                $item = Registry::get('categories')->getCategories();
                $count_site = Registry::get('categories')->countSites();
                //later
                //set step = '01'; site is published
                if ($item) {
                    $ms = "your site is published!";
                    $tpl->assign("first_name", $name);
                    $tpl->assign("url", $address);
                    $tpl->assign("msg", $ms);
                    $msg = $tpl->fetch("ad/mail/publishmail.tpl");
                    $s_mail = send_email($data, $msg);
                    $step = '01';
                } else
                    $step = '02';

//				
            }
        }

        //asign
        // $tpl->assign('err', $err);
        // $tpl->assign('step', $step);
        //$tpl->assign('item', $item);
        $this->_template = "ad/categories.tpl";
    }

}
