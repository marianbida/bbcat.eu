<?php

class PublishController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    #if paymant will make later

    public function later() {
        global $tpl, $lang, $lang_id;
        $lang->load('ad/publish');
        $lang->load('ad/categories');
        $lang->load('ad/about');
        $lang->load('ad/footer');
        $id = $_SESSION['id'];
        #if pay later
        $letter = Registry::get('item')->getLetter("1");
        $date = date('m/d/Y');
        if (isset($_POST['later'])) {
            //echo $id;
            $id = $_SESSION['id'];
            $tpl->assign('letter_info', $letter);
            $tpl->assign('id', $id);
            $tpl->assign('date', $date);
            #msg about payment (if later)
            $msg = $tpl->fetch("ad/mail/letter.tpl");
            $mail = Registry::get('email');
            $mail->from('marian.bida@gmail.com', 'Pay for site on Bgcat.eu');
            $mail->to($_SESSION['email']);
            $mail->subject('Pay for site on Bgcat.eu');
            $mail->message($msg);
            $state = $mail->send();
        }
        $step = '03';
        $tpl->assign('step', $step);
        $this->_template = "ad/publish.tpl";
    }

    #if paymant successful

    public function success() {
        global $tpl, $lang, $lang_id;
        $lang->load('ad/publish');
        $lang->load('ad/categories');
        $lang->load('ad/about');
        $lang->load('ad/footer');
        $id = $_SESSION['id'];

        $letter = Registry::get('item')->getLetter("3");
        $date = date('m/d/Y');
        #msg about payment successful
        $tpl->assign('letter_info', $letter);
        $tpl->assign('id', $id);
        $tpl->assign('date', $date);

        $msg = $tpl->fetch("ad/mail/letter.tpl");
        $mail = Registry::get('email');

        $mail->from('marian.bida@gmail.com', 'Pay for site on Bgcat.eu');
        $mail->to($_SESSION['email']);
        $mail->subject('Pay for site on Bgcat.eu');
        $mail->message($msg);

        $state = $mail->send();

        $letter = Registry::get('item')->getLetter("5");
        #msg about payment successful for admin
        $tpl->assign('letter_info', $letter);
        $tpl->assign('id', $id);
        $tpl->assign('date', $date);
        $msg = $tpl->fetch("ad/mail/letter.tpl");
        $mail = Registry::get('email');

        $mail->from('info@webmax.bg', 'Pay for site on Bgcat.eu');
        $mail->to('marian.bida@gmail.com');
        $mail->subject('Pay for site on Bgcat.eu');
        $mail->message($msg);

        $state = $mail->send();
        Registry::get('item')->setPayedOk($id);
        $step = '03';
        $tpl->assign('step', $step);
        $this->_template = "ad/publish.tpl";
    }

    #cancel

    public function cancel() {
        global $tpl, $lang, $lang_id;

        $lang->load('ad/publish');
        $lang->load('ad/categories');
        $lang->load('ad/about');
        $lang->load('ad/footer');

        $id = $_SESSION['id'];
        $tpl->assign("id", $id);
        //echo $id;
        $step = '01';
        $tpl->assign('step', $step);

        $this->_template = "ad/publish.tpl";
    }

    public function index() {
        global $tpl, $lang, $lang_id;

        $lang->load('user/login');
        $lang->load('newsletter/index');
        $lang->load('search/index');
        $lang->load('ad/publish');
        $lang->load('ad/categories');
        $lang->load('ad/about');
        $lang->load('ad/footer');

        $err = array();
        $step = '00';
        $item = "";
        $category = "";
        $name = "";
        //dump($letter = Registry::get('item')->getLetter(1));
        $categories = Registry::get('categories')->getAllRecords();

        if (!empty($_POST) && !isset($_POST['id'])) {
            $check = Registry::get('check');
            $data = array(
                'lang_id' => $lang_id,
                'address' => $_POST['address'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'keywords' => $_POST['keywords'],
                'email' => $_POST['email'],
                'categories' => $_POST['categories']
            );

            $cat = Registry::get('categories')->getRecord($data['categories']);
            $category = $cat[0]->id;
            $name = $cat[0]->name;

            if (!empty($data['address'])) {
                $i = Registry::get('item')->isHaveCheck($data['address']);

                if ($i > 0) {
                    $err['address'] = $lang->getIn('v', 'address_req');
                }
            }

            if (empty($data['address']) || !($check->is_url($data['address']))) {
                $err['address'] = $lang->getIn('v', 'address_req');
            }

            $check1 = $check->is_more_less_than($data['name'], 128, 5);
            if (empty($data['name']) || $check1 || $data['name'] == $lang->getIn('publ', 'def_for_title')) {
                $err['name'] = $lang->getIn('v', 'name_req');
            }

            $check2 = $check->is_more_less_than($data['description'], 200, 20);

            if (empty($data['description']) || $check2 || $data['description'] == $lang->getIn('publ', 'def_for_descr')) {
                $err['description'] = $lang->getIn('v', 'description_req');
            }

            $check3 = $check->is_more_less_than($data['keywords'], 200, 20);
            if (empty($data['keywords']) || $check3 || $data['keywords'] == $lang->getIn('publ', 'def_for_keys')) {
                $err['keywords'] = $lang->getIn('v', 'keywords_req');
            }

            if (empty($data['email']) || !($check->is_email($data['email']))) {
                $err['email'] = $lang->getIn('v', 'email_req');
            }

            if (empty($err)) {
                $id = Registry::get('item')->insertRecord($data);
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $data['email'];
                #get info about payment systems
                $epay = Registry::get('item')->getPayment("epay");
                $paypal = Registry::get('item')->getPayment("paypal");
                #begin block for ePay
                $min = $epay[0]->min;
                $invoice = sprintf("%.0f", $id);
                $sum = $epay[0]->amount;
                $currency = $epay[0]->type;
                $exp_date = "01.08.2020";
                $descr = $epay[0]->descr;
                $d = <<<DATA
                    MIN={$min}
                    INVOICE={$invoice}
                    AMOUNT={$sum}
                    CURRENCY={$currency}
                    EXP_TIME={$exp_date}
                    DESCR={$descr}
DATA;
                $secret = $epay[0]->secret;
                $ENCODED = base64_encode($d);
                $CHECKSUM = Registry::get('item')->hmac('sha1', $ENCODED, $secret);
                #end block for ePay
                if ($id) {
                    $tpl->assign("id", $id);
                    $tpl->assign("ENCODED", $ENCODED);
                    $tpl->assign("CHECKSUM", $CHECKSUM);
                    $tpl->assign("epay", $epay);
                    $tpl->assign("paypal", $paypal);
                }
                $letter = Registry::get('item')->getLetter("2");
                $date = date('m/d/Y');
                #assign letter
                $tpl->assign('letter_info', $letter);
                $tpl->assign('url', $data['address']);
                $tpl->assign('mail', $data['email']);
                $tpl->assign('title', $data['name']);
                $tpl->assign('keywords', $data['keywords']);
                $tpl->assign('description', $data['description']);
                $tpl->assign('category', $name);
                $tpl->assign('date', $date);

                #send mail to user

                $msg = $tpl->fetch("ad/mail/letter.tpl");
                $mail = Registry::get('email');
                $mail->from('info@bgcat.eu', 'bgCat.eu');
                $mail->to($data['email']);
                $mail->subject('Регистрация в bgCat.eu');
                $mail->message($msg);
                $state = $mail->send();

                $letter = Registry::get('item')->getLetter("4");
                $date = date('m/d/Y');
                $tpl->assign('letter_info', $letter);
                $tpl->assign('date', $date);
                $tpl->assign('data', $data);

                #send mail to admin
                $msg = $tpl->fetch("ad/mail/letter.tpl");
                $mail->from('info@bgcat.eu', 'Нов сайт');
                $mail->to('marian.bida@gmail.com');
                $mail->subject("Нов сайт {$data['address']}");
                $mail->message($msg);
                $state = $mail->send();
                $step = '01';
            }
        }
        $tpl->assign('category', $category);
        $tpl->assign('name', $name);
        $tpl->assign('categories', $categories);
        $tpl->assign('err', $err);
        $tpl->assign('step', $step);

        $this->_template = "ad/publish.tpl";
    }

}
