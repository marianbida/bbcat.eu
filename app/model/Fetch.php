<?php
final class Fetch{
    public function fetch_f($url="", $cookies = FALSE, $post = FALSE) {
        if (is_array($url)) {
            $data     = $url;
        } else {
            $data           = array();
            $data['url']    = $url;
        }

        $data['cookies']          = isset($data['cookies']) ?         $data['cookies'] : $cookies;
        $data['post']             = isset($data['post']) ?            $data['post'] : $post;
        $data['cookie_file']      = isset($data['cookie_file']) ?     $data['cookie_file'] : realpath('.') . '/cookies.txt';
        $data['user_agent']       = isset($data['user_agent']) ?      $data['user_agent'] : 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.2) Gecko/20090728 Firefox/3.5.2';
        $data['show_header']      = isset($data['show_header']) ?     $data['show_header'] : 0;
        $data['follow_location']  = isset($data['follow_location']) ? $data['follow_location'] : 1;
        $data['return_transfer']  = isset($data['return_transfer']) ? $data['return_transfer'] : 1;

        if (preg_match('@https?://@i', $data['url']) && extension_loaded('curl')) {
            $ch = curl_init($data['url']);
            if ($data['cookies']) {
                $values = array();
                foreach ($data['cookies'] as $k => $v) {
                    $values[] = $k . '=' . urlencode($v) . ';';
                }
                curl_setopt ($ch, CURLOPT_COOKIE, implode(' ', $values) );
            }
            if ($data['post']) {
                $values = array();
                foreach ($data['post'] as $k => $v) {
                    $values[] = $k . '=' . urlencode($v);
                }
            curl_setopt($ch, CURLOPT_POST, count($values));
            // the parameter 'username' with its value 'johndoe'
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $values));
            }
            if (isset($data['referer'])) {
                curl_setopt($ch, CURLOPT_REFERER, $data['referer']);
            }
            curl_setopt($ch, CURLOPT_USERAGENT,      $data['user_agent']);
            curl_setopt($ch, CURLOPT_HEADER,         $data['show_header']);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $data['follow_location']);
            curl_setopt($ch, CURLOPT_COOKIEFILE,     $data['cookie_file']);
            curl_setopt($ch, CURLOPT_COOKIEJAR,      $data['cookie_file']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, $data['return_transfer']);
            $raw_data = curl_exec($ch);
        } else {
            $raw_data = file_get_contents($data['url']);
        }
            return $raw_data;
    }

    public function UTF($text) {
        $utf = iconv('CP1251', 'UTF-8', $text);
        $cp1251 = @iconv('UTF-8', 'CP1251', $text);
        if (!$cp1251) {
            return $utf;
        } else {
            return $text;
        }
    }
}

?>
