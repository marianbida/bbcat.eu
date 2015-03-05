<?php

class SitemapController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        global $lang_id, $meta, $tpl;

        $page = $this->model->page;
        $portfolio = $this->model->portfolio;

        $tmp = $page->get(23, $lang_id);
        if ($tmp) {
            $meta->title = $tmp->page_title;
            $meta->description = $tmp->page_description;
            $meta->keywords = $tmp->page_keywords;
            $meta->page_title = $tmp->title;
            $meta->page_content = $tmp->content;
        }

        $page_list = $page->getRecords($start = 0, $count = 100, $parent = null, $tmenu = null, $bmenu = null, $sitemap = 'y', $lang_id);
        $portfolio_list = $portfolio->getRecordsByCategory(0, 30, $lang_id, "", "", "");

        $tpl->assign('page_list', $page_list);
        $tpl->assign('portfolio_list', $portfolio_list);


        $this->_template = "sitemap/index.tpl";
    }

    public function xml() {
        global $tpl, $lang_id;

        $tmp = $this->model->page->get(23, $lang_id);
        if ($tmp) {
            $meta->title = $tmp->page_title;
            $meta->description = $tmp->page_description;
            $meta->keywords = $tmp->page_keywords;
            $meta->page_title = $tmp->title;
            $meta->page_content = $tmp->content;
        }

        $action = 'xml';

        if ($action == "xml") {

            header("Content-Type: text/xml; charset=utf-8");

            function convert($str) {
                $what = array('&nbsp;', '&quot;', '&amp;', '&lt;', '&gt;');
                $to = array(' ', '"', '&', '<', '>');
                $newStr = str_replace($what, $to, $str);
                return ($newStr == ' ') ? '' : '<![CDATA[' . $newStr . ']]>';
            }

            function permaLinkId($str) {
                return substr(md5($str), 0, 16);
            }

            //dump($category_list);
            $rss = new stdClass;
            $rss->title = "Директория - добави сайт безплатно";
            $rss->description = "Добавете сайт безплатно в нашата директория";
            $rss->language = "bg";
            $rss->webmaster = "marian.bida@gmail.com (Marian Bida)";
            $rss->copyright = "WebMax.bg";

            $tpl->assign("rss", $rss);

            $page_list = $this->model->page->getRecords($start = 0, $count = 100, $parent = null, $tmenu = null, $bmenu = null, $sitemap = null, $lang_id);
            // dump($page_list);

            $item_list = $this->model->item->getRecords(0, 10000);

            // dump($item_list);

            $tpl->assign('page_list', $page_list);

            $tpl->assign('item_list', $item_list);

            $tpl->display("xml/sitemap.tpl");
            exit;
        }
    }

}
