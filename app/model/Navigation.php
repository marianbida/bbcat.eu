<?php
final class Navigation {

	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	private $_page;

	public function __construct() {
		$this->_page =& Registry::get('page');
	}

	public function getTop($lp, $idx, $lang_id)
	{
		$out = array();
		$r = $this->_page->getRecords(0, 20, NULL, 'y', NULL, $lang_id);
		foreach ($r as $item) {
			$out[] = array($lp.$item->prefix, $item->mtitle, $item->title);
		}
		$out[$idx][3] = 'selected';
		return $out;
	}

	public function getBottom($lp, $idx, $lang_id)
	{
		$out = array();
		$r = $this->_page->getRecords(0, 20, NULL, NULL, 'y', $lang_id);
		foreach ($r as $item) {
			$out[] = array($lp.$item->prefix, $item->mtitle, $item->title);
		}
		return $out;
	}
}