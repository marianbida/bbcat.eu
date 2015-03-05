<?php

final class LoginController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {

        global $tpl, $lang;

        $lang->load('user/login');
        $lang->load('newsletter/index');
        $lang->load('search/index');

        if (!empty($_POST)) {

            $err = array();

            $check = Registry::get('check');
            $email = Registry::get('email');
            $user = Registry::get('user');
            $card = Registry::get('card');

            $username = $_POST["username"];
            $password = $_POST["password"];

            if (empty($username)) {
                $err['username_err'] = $lang->getIn('v', 'user_req');
            }
            if (empty($password)) {
                $err['password_err'] = $lang->getIn('v', 'pass_req');
            }
            if (empty($err)) {
                unset($_SESSION['login_error']);
                $reply = $user->auth($username, $password);

                if (isset($reply->id) && $reply->id > 0) {
                    if (isset($reply->state) && $reply->state == 1) {
                        $_SESSION['step'] = '01';
                    } elseif (isset($reply->state) && $reply->state == 2) {
                        $_SESSION['step'] = '02';
                    } else {
                        unset($_SESSION['step']);
                        $_SESSION['user_id'] = $reply->id;
                        $_SESSION['admin'] = $reply->admin;
                        $_SESSION['first_name'] = $reply->first_name;
                        $user_key = $user->getKey($reply->id);
                        if (empty($user_key)) {
                            //key is empty, assign key to user and continue
                            $user->assignKey(
                                    array(
                                        "key" => (string) $_SESSION["key"],
                                        "user_id" => (int) $reply->id
                                    )
                            );
                            $card->updateOrderUser(
                                    array(
                                        "user_id" => $reply->id,
                                        "key" => (string) $_SESSION["key"]
                                    )
                            );
                        } else {
                            //user key exists
                            if ($user_key != $_SESSION["key"]) {
                                //current
                                $current_order = $order;
                                $current_order_id = $current_order->id;

                                //user
                                $user_order = $card->getOrderByKey(array("key" => $user_key));
                                $user_order_id = $user_order->id;

                                //old new
                                $card->updateItemsOrderId($current_order_id, $user_order_id);
                                $_SESSION['key'] = $user_key;
                            }
                        }

                        $user->touchLastLogin($reply->id);
                        Log::getInstance()->put($_SERVER['REMOTE_ADDR'], $_SESSION['user_id'], 'login', 'user', '-', '-', '-');
                        if (isset($_SESSION['return_url'])) {
                            $return_url = $_SESSION['return_url'];
                            unset($_SESSION['return_url']);
                            header("Location: " . $return_url);
                            exit;
                        }
                        header("Location: /profile");
                        exit;
                    }
                } else {
                    $_SESSION['step'] = '03';
                }
            } else {
                $_SESSION['login_error'] = $err;
            }
        }
        $this->_template = "user/login.tpl";
    }

}
