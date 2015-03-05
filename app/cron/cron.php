<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
        ini_set('max_execution_time', 50);

	include __DIR__ . '/../conf/app.php';
	
        $out = (object) array(
            'three' => 0,
            'one' => 0,
            'expired' => 0,
            'vip' => 0,
            'active' => 0,
            'notify3' => 0
	);
	
	$ben    = Registry::get('benchmark');
	$db     = Registry::get('db');
	$user   = Registry::get('user');
	$item   = Registry::get('item');
	$email  = Registry::get('email');
	
        $email->initialize(array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mail.myvarna.info',
            'smtp_port' => '25',
            'smtp_user' => 'noreply@catalog.myvarna.info',
            'smtp_pass' => 'faskdjfkjasdfjd',
            '_smtp_auth'=> true,
            'charset'   => 'utf-8',
            'mailtype'  => 'html',
            'newline'   => "\r\n"
        ));
	
	$tpl = Registry::get('smarty');
	$tpl->template_dir	= ROOT . 'app/view';
	$tpl->compile_dir	= ROOT . 'app/cache/view_c';
	$tpl->cache_dir		= ROOT . 'app/cache';

	// get items
        $state = array();
        $list = $item->getRecords(0, 20, NULL,  $ord = '', 1);
        if ($list) {
            foreach ($list as $item) {
                // $item->sss = get_headers($item->url, 1);
            }
            $out->expired = sizeof($list);
        }

	if ($out->notify3 === 0) {
            // exit;
        }
        
        // send status
	$tpl->assign("out", $out);
	$tpl->assign("list", $list);
	$msg = $tpl->fetch("ad/mail/cron.report.tpl");
        
        $email->from("noreply@catalog.myvarna.info");
	$email->to('marian.bida@gmail.com');
	$email->subject("Catalog.MyVarna.info / cron / cron.php every 1 minute");
	$email->message($msg);
        
        // $state = $email->send();
        