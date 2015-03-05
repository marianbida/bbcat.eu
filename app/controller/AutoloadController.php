<?php

class AutoloadController {

    public function __construct() {
        $this->model['check'] = Registry::get('check');
        $this->model['fetch'] = Registry::get('fetch');
    }

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index() {
        global $tpl, $lang, $lang_id;

        $response = new stdClass;

        if (isset($_POST['url']) && $_POST['url']) {
            $url = $_POST['url'];
            $check = Registry::get('check')->is_url_a($url);

            if ($check) {
                $page_content = Registry::get('fetch')->fetch_f($url);
                #for title
                $reg_t = "/<title>(.*)<\/title>/sUSi";
                preg_match($reg_t, $page_content, $titles);
                if (!empty($titles[1])) {
                    $response->title = Registry::get('fetch')->UTF($titles[1]);
                }

                #for description
                $reg_d = "/meta name=\"description\" content=\"(.*)\"/sUSi";
                preg_match($reg_d, $page_content, $description);
                if (!empty($description[1])) {
                    $response->description = Registry::get('fetch')->UTF($titles[1]);
                }
                #for keywords
                $reg_k = "/meta name=\"keywords\" content=\"(.*)\"/sUSi";
                preg_match($reg_k, $page_content, $keywords);
                if (!empty($keywords[1])) {
                    $response->keywords = Registry::get('fetch')->UTF($titles[1]);
                }
            }
        }

        echo json_encode($response);

        exit;
    }

}
