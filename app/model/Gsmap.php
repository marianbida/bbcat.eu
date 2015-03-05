<?php
final class Gsmap {
	private static $instance;
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		//$this->_db	=&	DB::getInstance();
	}
	
	public function render($name, $lang_code, $lat, $lon, $zoom, $size) {
		$out = new stdClass;
		$out->image = sprintf("http://maps.google.com/maps/api/staticmap?format=gif&amp;language=%s&amp;sensor=false&amp;maptype=terrain&amp;center=%s,%s&amp;zoom=%s&amp;size=%s", $lang_code, $lat, $lon, $zoom, $size);
		$out->title = sprintf('%s', $name);
		return $out;
	}
}