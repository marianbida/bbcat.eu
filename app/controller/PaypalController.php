<?php

include 'IpnListener.php';

final class PaypalController {

    public function ipn() {

        $listener = new IpnListener();
        $listener->use_sandbox = true;
        try {
            $verified = $listener->processIpn();
        } catch (Exception $e) {
            // fatal error trying to process IPN.
            exit(0);
        }

        if ($verified) {
            // IPN response was "VERIFIED"
            $a = $listener->getTextReport();
            Registry::get('item')->insertReport($a);

            $a = $listener->getInvoice();
            Registry::get('item')->setPayedOk($a);
        } else {
            // IPN response was "INVALID"
        }
    }

}
