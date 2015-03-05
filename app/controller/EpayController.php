<?php

final class EpayController {

    public function index() {
        global $tpl, $lang, $lang_id;
        $ENCODED = $_POST['encoded'];
        $CHECKSUM = $_POST['checksum'];
        $secret = '2WD35M66A221X62TXF4ETFQST24526Z8FAP59PL6RFWQ9SO9CLD07BBL8O0XUWI6';
        $hmac = Registry::get('item')->hmac('sha1', $ENCODED, $secret);
        if ($hmac == $CHECKSUM) {

            $data = base64_decode($ENCODED);
            $lines_arr = split("\n", $data);
            $info_data = '';

            foreach ($lines_arr as $line) {
                if (preg_match("/^INVOICE=(\d+):STATUS=(PAID|DENIED|EXPIRED)(:PAY_TIME=(\d+):STAN=(\d+):BCODE=([0-9a-zA-Z]+))?$/", $line, $regs)) {
                    $invoice = $regs[1];
                    $status = $regs[2];
                    $pay_date = $regs[4]; # XXX if PAID
                    $stan = $regs[5]; # XXX if PAID
                    $bcode = $regs[6]; # XXX if PAID
                    $info_data .= "PAYDATE=$paydate;INVOICE=$invoice:STATUS=OK\n";
                }
            }
            Registry::get('item')->insertReport($info_data);
            Registry::get('item')->setPayedOk($invoice);
        }
    }

}

?>
