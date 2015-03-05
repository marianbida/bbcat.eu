<?php

final class PaymentController {

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

        $mail->from('bgcat.eu@gmail.com', 'Pay for site on Bgcat.eu');
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
        #pay later by id
        if (!empty($_POST) && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $email = $_POST['email'];

            if (!empty($id)) {
                $i = Registry::get('item')->isHaveCheckId($id);

                if ($i < 1) {
                    $err['id'] = $lang->getIn('v', 'id');
                }
            } else {
                $err['id'] = $lang->getIn('v', 'id');
            }

            if (empty($email) || !(Registry::get('check')->is_email($email))) {
                $err['email'] = $lang->getIn('v', 'email_req');
            }
            $check = Registry::get('item')->mailForId($id, $email);
            if (!$check) {
                $err['email'] = $lang->getIn('v', 'email_req');
            }
            if (empty($err)) {
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
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
                $tpl->assign("id", $id);
                $tpl->assign("ENCODED", $ENCODED);
                $tpl->assign("CHECKSUM", $CHECKSUM);
                $tpl->assign("epay", $epay);
                $tpl->assign("paypal", $paypal);
                $step = '01';
            }
        }

        $tpl->assign('err', $err);
        $tpl->assign('step', $step);

        $this->_template = "payment/index.tpl";
    }

}
