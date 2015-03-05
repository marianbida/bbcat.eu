<?php
class Check {
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	var $_db, $out, $error, $error_items;
	var $_captcha_table;

	public function __construct() {

		$this->_db	= Registry::get('db');
		$this->out	=	'';
		$this->_captcha_table = "captcha";
		
	}
    
    public function email($str, $field, $err = FALSE ) {
		if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $str) ){
			$this->error[] = "-> \" " . $err . " \" is not valid!\n";
			$this->error_items[ $field ] = 1;
		}
	}
	public function is_email ($str) {
		return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $str);
	}
	
	public function is_url_a ($url) {
		return preg_match("/((http)\:\/\/)([a-z0-9]{1,})([a-z0-9-.]*)\.([a-z]{2,4})$/", $url);
	}

        public function is_url ($url) {
		return preg_match("/^((https?|ftp)\:\/\/)?([a-z0-9]{1,})([a-z0-9-.]*)\.([a-z]{2,4})$/", $url);
	}

    public function is_more_than($inp, $eq) {
        if(strlen($inp)>$eq) {
            return true;
        } else {
            return false;
        }
    }

    public function is_less_than($inp, $eq) {
        if(strlen($inp)<$eq) {
            return true;
        } else {
            return false;
        }
    }
        
    public function is_more_less_than($inp, $eq_m, $eq_l) {
        if(strlen($inp)>$eq_m || strlen($inp)<$eq_l){
            return true;
        } else {
            return false;
        }
    }

    private function remove($data){
		$this->_db->q("DELETE FROM `{$this->_captcha_table}` WHERE	`word` = '{$data['code']}' AND `ip_address` = '{$data['ip']}';");
	}

	public function is_code ($code)	{
		$ip	=	$_SERVER['REMOTE_ADDR'];
		$r	=	$this->_db->q("
                SELECT * FROM `{$this->_captcha_table}`
                WHERE
                    `word`          = '$code' AND
                    `ip_address`    = '$ip';
               ");
		if ($r) {
			return TRUE;
		}
		return FALSE;
	}

	public function captcha( $str, $field, $err = FALSE ) {
		$code	=	$this->_db->escape( $str );
		$r	=	$this->_db->q('select `captcha_id` from `captcha` where `word` = "'.$code.'" limit 1;');
		if (!$r) {
			$this->error[] = "-> \" " . $err . " \" is not correct!\n";
			$this->error_items[ $field ] = 1;
		};
	}

	public function required( $str, $field, $err = FALSE, $not = FALSE ) {
		if( empty( $str ) ) {
			$this->error[] = "-> \" " . $err . " \" is required!\n";
			$this->error_items[ $field ] = 1;
		}
		if( $not ) {
			if( $str == $not ){
				$this->error[] = "-> \" " . $err . " \" is required!\n";
				$this->error_items[ $field ] = 1;
			}
		}
	}
	public function checkEmpty( $str, $err = FALSE ) {
		if (!$err) {
			return empty($str);
		} else {
			if (empty($str)) {
				$this->error[] = "-> \" " . $err . " \" is required!\n";
			}
		}
	}
	public function checkStrLen( $str, $len, $err = FALSE ) {
		if (!$err) {
			return (strlen($str) >= $len) ? TRUE : FALSE;
		} else {
			if (empty($str)) {
				$this->error[] = "-> \" " . $err . " \" is required!\n";
			}
		}
	}
	public function execute() {
		return empty( $this->error );
	}

        public function getError() {
		return implode('', $this->error);
	}

        public function getErrorItems() {
		return $this->error_items;
	}
	///
	public function checkEmail( $email, $err ) {
		$isValid = TRUE;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
      		$isValid = FALSE;
		} else {
      		$domain = substr($email, $atIndex+1);
      		$local = substr($email, 0, $atIndex);
      		$localLen = strlen($local);
      		$domainLen = strlen($domain);
      		if($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
      		} else
                if ($domainLen < 1 || $domainLen > 255) {
                    // domain part length exceeded
                    $isValid = false;
                } else
                    if ($local[0] == '.' || $local[$localLen-1] == '.') {
                        // local part starts or ends with '.'
                        $isValid = false;
                    }  else
                        if (preg_match('/\\.\\./', $local))	{
                            // local part has two consecutive dots
                            $isValid = false;
                        } else
                            if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                                // character not valid in domain part
                                $isValid = false;
                            } else
                                if (preg_match('/\\.\\./', $domain)) {
                                    // domain part has two consecutive dots
                                    $isValid = false;
                                } else
                                    if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
			
                                        // character not valid in local part unless
                                        // local part is quoted
                                        if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                                            $isValid = false;
                                        }
                                    }
			
                                    if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
                                        // domain not found in DNS
                                        $isValid = false;
                                    }
                            }
                            if( $isValid ) {
                                $this->error[] = "-> \" " . $err . " \" is required!\n";
                            }
                        }
                    }