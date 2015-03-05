<?php

final class CityController {

    private $_template;

    public function getTemplate() {
        return $this->_template;
    }

    public function view() {
        global $tpl, $lang, $lang_id;
        $this->_template = "destination.tpl";
    }

    public function index($method = NULL, $arg = array()) {

        global $tpl, $lang_id, $lang, $curr_id, $meta, $menu_index;
        $menu_index = 1;

        $lang->load('city/view');
        $lang->load('ad/list');
        $lang->load('newsletter/index');
        $lang->load('search/index');

        $data = Registry::get('city')->getRecord(NULL, $arg[0], $lang_id);

        //map
        $map = new stdClass;
        $map->lon = $data->lon;
        $map->lat = $data->lat;
        $map->name = $data->name;
        $map->type = 'city';
        $map->alias = $data->city_alias;
        $map->title = sprintf('Карта на %s', $data->name);
        $tpl->assign('map_data', $map);
        $tpl->assign('map_mode', 'city');

        //meta
        $meta->title = sprintf($lang->get('header'), $data->name) . ' | Look-Tour.com';
        $meta->description = sprintf($lang->get('header'), $data->name) . ' | Look-Tour.com';
        $meta->keywords = sprintf($lang->get('header'), $data->name) . ' | Look-Tour.com';


        $tpl->assign('h2', sprintf($lang->get('header'), $data->name));

        //`get_hotels_by_city`(IN in_city int, IN in_lang int, IN in_curr int, IN in_ord varchar(100), IN in_ord_type varchar(100), IN in_offset int, IN in_records int, IN in_resort int)
        $chl = Registry::get('ads')->getRecordsByCityId($data->city_id, $lang_id, $curr_id, 'title', 'ASC', 0, 20, 0);
        $total = Registry::get('ads')->getTotal();

        $tpl->assign('city_data', $data);
        $tpl->assign('local_hotel_list', $chl);

        $this->_template = "destination.tpl";
    }

}
