<?php

final class TagController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function index($key = NULL, $ref = NULL) {
        global $tpl, $lang, $lang_id, $lang_code, $curr_id, $menu_index, $meta;

        $lang->load('ad/list');

        $tmp = Registry::get('page')->getRecord(3, $lang_id);

        $meta->title = $tmp->page_title;
        $meta->description = $tmp->page_description;
        $meta->keywords = $tmp->page_keywords;
        $meta->page_title = $tmp->title;
        $meta->page_content = $tmp->content;

        $menu_index = 1;

        /////////////////////////////////////////////
        $lang->load('country/view');

        $data = Registry::get('country')->getRecord(NULL, 'bulgaria', $lang_id);
        $tpl->assign(
                'map_data', Registry::get('gsmap')->render($data->name, $lang_code, $data->lat, $data->lon, $data->zoom, '290x146')
        );
        $tpl->assign('map_mode', 'country');

        $hotel_list = Registry::get('ads')->getRecordsByCountryId($data->country_id, $lang_id, $curr_id, 'title', 'ASC', 0, 20);

        $tpl->assign('local_hotel_list', $hotel_list);
        $tpl->assign('h2', sprintf($lang->get('header'), $data->name));
        $tpl->assign('country_data', $data);

        $this->_template = "ad/list.tpl";
    }

}
