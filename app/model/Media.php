<?php
class Media {
	
	private static $instance;
	
	public static function getInstance() {      
		if (self::$instance === null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	private $_db;
	private $_table				=	"media";
	private $_table_category	=	"media_category";
	private $_table_type		=	"media_type";
	private $_table_info		=	"media_info";
	
	var $thumb_dirs;
	
	public function __construct() {
		$this->_db			=&	DB::getInstance();
		$this->thumb_dirs		=	array(
			array(
				"dir"		=>	"120x90",
				"width"		=>	120,
				"height"	=>	90
			),
			array(
				"dir"		=>	"300x225",
				"width"		=>	300,
				"height"	=>	225
			),
			array(
				"dir"		=>	"185x140",
				"width"		=>	185,
				"height"	=>	140
			),
			array(
				"dir"		=>	"140x140",
				"width"		=>	140,
				"height"	=>	140
			),
			array (
				"dir"		=>	"60x45",
				"width"		=>	60,
				"height"	=>	45
			)
		);
		$media_conf 					=	new stdclass;
		//$media_conf->base_dir			=	$this->base_dir;
		$media_conf->thumb_dir_small	=	$this->thumb_dirs[0]['dir'];
		$media_conf->thumb_dir_medium	=	$this->thumb_dirs[1]['dir'];
		$media_conf->thumb_dir_list		=	$this->thumb_dirs[2]['dir'];
		$this->media_conf = $media_conf;
	}

	public function updateTitles ($data)
	{
		foreach ($data['title'] as $k => $v) {
			$q = "
			UPDATE `{$this->_table_info}`
			SET		`title` = \"{$v}\"
			WHERE	`id` 	=	{$data['id']} AND `lang_id` = $k
			LIMIT 1
			;";
			$this->_db->q($q);
		}
		return $this->_db->affected_rows > 0 ? TRUE : FALSE;
	}

	public function getCatId($cat)
	{
		$q = "select `id` from `media_cat` where `cat` = '$cat' limit 1;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			return $o->id;
		}
	}
	
	public function getCat( $cat_id )
	{
		$q = "select `cat` from `media_cat` where `id` = '$cat_id' limit 1;";
		$r = $this->_db->q($q);
		if( $r && $r->num_rows == 1 ) {
			$o = $r->fetch_object();
			return $o->cat;
		}
	}
	public function _getList( $cat, $id = FALSE )
	{
		$out = array();
		$external_id = '';
		$cat_id = $this->getCatId( $cat );
		if( $id )
		{
			$external_id = " and `external_id` = '$id' ";
		}
		$q = "
		SELECT * 
		FROM `{$this->_table}` 
		WHERE `cat_id` = '$cat_id' $external_id 
		ORDER BY `title` ASC;
		";
		$r = $this->_db->q($q);
		if( $r->num_rows > 0 )
		{
			while( $o = $r->fetch_object() )
			{
				$out[] = $o;
			}
		}
		return $out;
	}
	public function getImageById( $image_id )
	{
		$q = "select `image` from `media` where `id` = $image_id;";
		$r = $this->_db->q( $q );
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$r->free();
			return $o->image;
		}else{
			return FALSE;
		}
	}
	public function deleteImage( $prefix, $image_id )
	{
		$file = $this->getImageById( $image_id );
		if( $file ) {
			$file_long	=	ROOT . 'images/' . $prefix . '/' . $file;
			if( is_file( $file_long ) ) {
				unlink( $file_long );
			}
		}
		
		$image = $this->getImage( $image_id );
		
		$q = "
		DELETE FROM `{$this->_table}` 
		WHERE `id` = $image_id 
		LIMIT 1;
		";
		$this->_db->q( $q );
		$this->fixOrder(
			array(
				"category_id"	=>	$image->category_id,
				"external_id"	=>	$image->item_id
			)
		);
	}
	
	private function getImage( $image_id ){
		$q = "select * from `media` where `id` = $image_id;";
		$r = $this->_db->q( $q );
		if( $r && $r->num_rows == 1 )
		{
			$o = $r->fetch_object();
			$r->free();
			return $o;
		}else{
			return FALSE;
		}
	}
	private function fixOrder( $data = array() )
	{
		$q = "
		SELECT `id`
		FROM `{$this->_table}`
		WHERE `category_id` = {$data['category_id']} AND `item_id` = {$data['item_id']}
		ORDER BY `ord` ASC
		;";
		//echo $q;
		$r = $this->_db->q( $q );
		if( @$r && $r->num_rows > 0 ){
			$i = 0;
			while( $o = $r->fetch_object() ){
				$this->_db->q("UPDATE `{$this->_table}` SET `ord` = ".$i." WHERE `id` = ".$o->id." LIMIT 1;");
				$i++;
			}
			$r->free();
		}
	}
	public function getMaxOrder( $data = array() ){
		$out = 0;
		$q = "
		SELECT count(*) as `total`
		FROM `{$this->_table}`
		WHERE `cat_id` = {$data['cat_id']} AND `external_id` = {$data['external_id']};
		";
		$r = $this->_db->q($q);
		if( @r && $r->num_rows > 0 ){
			$o = $r->fetch_object();
			if( $o->total > 0 ){
				$out = $o->total + 1;
			}
		}
		return $out;
	}
	public function insertMedia( $file, $cat_id, $external_id, $title, $width, $height, $size )
	{
		$order = $this->getMaxOrder( array("cat_id" => $cat_id, "external_id" => $external_id ) );
		$q = "
		INSERT INTO `{$this->_table}` 
			(`image`,`cat_id`,`external_id`,`title`,`width`,`height`,`size`,`uploaded`,`ord`) 
		VALUES
			('$file','$cat_id', '$external_id', '$title', $width, $height, $size, now(), $order);
		";
		$this->_db->q( $q );
		return $this->affected_rows == 1 ? TRUE : FALSE;
	}
	public function getThumb( $order, $image_id = FALSE, $external_id, $cat_id )
	{
		$q = "
		select t1.`image`, (select `cat` from `media_cat` where `id` = $cat_id) as `directory`
		from `{$this->_table}` t1
		where t1.`external_id` = '$external_id' and t1.`ord` = $order and t1.`cat_id` = $cat_id
		limit 1;";
		$r = $this->_db->q( $q );
		if( $r && $r->num_rows == 1 )
		{
			return $r->fetch_object();
		}
	}
	//resize image($source_filename, $destination_filename, $newwidth, $newheight)
	function do_image_create($file, $filename, $target_width, $target_height, $force = null)
	{
		$info = @getimagesize($file);
		$width = $info[0];
		$height = $info[1];
		$tmp=imagecreatetruecolor($newwidth, $newheight);
		switch($info['mime'])
		{
			case 'image/gif':	$src = imagecreatefromgif($file);	break;
			case 'image/jpeg':	$src = imagecreatefromjpeg($file);	break;
			case 'image/png':	$src = imagecreatefrompng($file);	break;
		}
		if (@$src) {
			if ($force == 'width') {
				$newwidth=$target_width;
				$newheight=($height/$width)*$newwidth;
			} elseif ($force == 'height') {
				$newheight=$target_height;
				$newwidth=($width/$height)*$newheight;
			} else {
				$newheight=$target_height;
				$newwidth=($width/$height)*$newheight;
				if ($newwidth>$target_width) {
					$newwidth=$target_width;
					$newheight=($height/$width)*$newwidth;
				}
			}
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg($tmp, $filename, 90);
			imagedestroy($src);
			imagedestroy($tmp);
			chmod($filename, 0666);
		}
	}
	//image_crop($source_filename, $destination_filename, $newwidth, $newheight)
	function do_image_crop($source, $dest, $nw, $nh)
	{
		$info = @getimagesize($source);
		$w = $info[0];
		$h = $info[1];
		switch($info['mime']) {
			case 'image/gif'	:	$simg = imagecreatefromgif($source);	break;
			case 'image/jpeg'	:	$simg = imagecreatefromjpeg($source);	break;
			case 'image/png'	:	$simg = imagecreatefrompng($source);	break;
		}
		if (@$simg) {
			$dimg = imagecreatetruecolor($nw, $nh);
			$wm = $w/$nw;
			$hm = $h/$nh;
			$h_height = $nh/2;
			$w_height = $nw/2;
			if ($w > $h) {
				$adjusted_width = $w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
			} elseif ( ($w < $h) || ($w == $h) ) {
				$adjusted_height = $h / $wm;
				$half_height = $adjusted_height / 2;
				$int_height = $half_height - $h_height;
				imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
			} else {
				imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
			}
			imagejpeg($dimg, $dest, 100);
			imagedestroy($simg);
			imagedestroy($dimg);
			//chmod($dest,0666);
		}
	}
	function image_crop($source, $dest, $nw, $nh, $quality = 100)
	{
		$source_file	= $source;
		$target_file	= $dest;
		$target_width	= $nw;
		$target_height	= $nh;
		$quality	= isset($quality) ? $quality : 100;
		$access_mode	= isset($parameters['access_mode']) ? $parameters['access_mode'] : 0666;

		if (!is_file($source_file)) {
			return FALSE;
		}
		$source_info = getimagesize($source_file);
		$source_width = $source_info[0];
		$source_height = $source_info[1];
		switch($source_info['mime']) {
			case 'image/gif':
					$source_image = imagecreatefromgif($source_file);
			break;
			case 'image/jpeg':
					$source_image = imagecreatefromjpeg($source_file);
			break;
			case 'image/png':
					$source_image = imagecreatefrompng($source_file);
			break;
			default:
				$source_image = FALSE;
		}
		if ($source_image) {
			$temp_image = imagecreatetruecolor($target_width, $target_height);
			$index_width = $source_width/$target_width;
			$index_height = $source_height/$target_height;
			$position_x = $target_width/2;
			$position_y = $target_height/2;
			if ($source_width > $source_height) {
				$adjusted_width = $source_width / $index_height;
				$start_width = ($adjusted_width / 2) - $position_x;
				imagecopyresampled($temp_image, $source_image, -$start_width, 0, 0, 0, $adjusted_width, $target_height, $source_width, $source_height);
			} elseif ( ($source_width < $source_height) || ($source_width == $source_height) ) {
				$adjusted_height = $source_height / $index_width;
				$start_width = ($adjusted_height / 2) - $position_y;
				imagecopyresampled($temp_image, $source_image, 0, -$start_width, 0, 0, $target_width, $adjusted_height, $source_width, $source_height);
			} else {
				imagecopyresampled($temp_image, $source_image, 0, 0, 0, 0, $target_width, $target_height, $source_width, $source_height);
			}

			imagejpeg($temp_image, $target_file, $quality);
			imagedestroy($source_image);
			imagedestroy($temp_image);
			chmod($target_file, $access_mode);
		} else {
			return FALSE;
		}
	}
	//new
	public function getCategoryDirectory($category_id)
	{
		$q = "
		SELECT `directory`
		FROM `{$this->_table_category}`
		WHERE `id` = $category_id
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			return $o->directory;
		} else {
			return FALSE;
		}
	}
	public function getExtension ($file)
	{
		$temp = explode('.', $file);
		return $temp[sizeof($temp) - 1];
	}
	
	public function getMediaType ($media_type)
	{
		/// so strange things
		$media_type = str_replace('\"','', $media_type);
		$q = "
		SELECT `id`
		FROM `{$this->_table_type}`
		WHERE `type` = '$media_type'
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			return $o->id;
		} else {
			return 0;
		}
	}
	public function getMediaTypeByExtension($media_file)
	{
		$type_id = 0;
		$arr = explode('.', $media_file);
		$arr = array_reverse($arr);
		$ext = $arr[0];
		$q = "
		SELECT `id`
		FROM `{$this->_table_type}`
		WHERE `extension` = '$ext'
		LIMIT 1
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows == 1) {
			$o = $r->fetch_object();
			$type_id = $o->id;
		}
		return $type_id;
	}
	public function is_media_exist($media_file)
	{
		return is_file($media_file);
	}
	public function processMedia ($data)
	{
		$cat_directory	=	$this->getCategoryDirectory($data['category_id']);
		$format_options	=	$this->getFormatOptions();
		//$this->write_err( $data['tmp_name'].' '.$data['location'] );
		if (move_uploaded_file($data['tmp_name'] , $data['location'])) {
			//chmod($data['location'], 0666);
			if ($format_options[$data['type_id']]->thumb) {
				if ($format_options[$data['type_id']]->video) {
					//create one temp big thumbnail in cache directory
					$tmp	=	array(
						"location"	=>	$data['location'],
						"target"	=>	ROOT . 'cache/media/'.$data['file'],
						"width"		=>	0,
						"height"	=>	0
					);
					$temp_location = $this->createVideoThumbnail($tmp);
					//make thumbnails from the temp
					foreach ($this->thumb_dirs as $item) {
						$data['file'] = $this->convertToDesctinationExtension( array(
								"extension"	=>	"png",
								"source"	=>	$data['file']
							)
						);
						$source 		=	BASEPATH.'cache/media/'.$data['file'];
						$destination	=	BASEPATH.'../'.$this->base_dir.'/'.$cat_directory.'/'.$item['dir'].'/'.$data['file'];
						//echo $source."\n".$destination."\n";
						$this->do_image_crop($source, $destination, $item['width'], $item['height']);
					}
					$this->removeFile($temp_location);
					$data['file'] = $this->convertToDesctinationExtension( array(
							"extension"	=>	$format_options[$data['type_id']]->extension,
							"source"	=>	$data['file']
						)
					);
		
				} else {
					list($width, $height, $type, $attr) = getimagesize($data['location']);
					$data['width']	=	$width;
					$data['height']	=	$height;
					foreach ($this->thumb_dirs as $item) {
						if (!is_dir(ROOT.$cat_directory.'/'.$item['dir'].'/')) {
							mkdir(ROOT.$cat_directory.'/'.$item['dir'].'/');
						}
						$this->do_image_crop($data['location'], ROOT.$cat_directory.'/'.$item['dir'].'/'.$data['file'], $item['width'], $item['height']);
					}
				}
			}
		}
		$data['size']	=	filesize($data['location']);
		unset( $data['tmp_name'] );
		$data['location'] = str_replace(ROOT.'../', '', $data['location']);
		$this->add($data);
	}

	public function getFormatOptions(){
		$out = array();
		$q = "
		SELECT `id`, `thumb`, `video`, `extension`
		FROM `{$this->_table_type}`
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			while ($o = $r->fetch_object()) {
				$out[$o->id] = $o;
			}
		}
		return $out;
	}
	public function add(Array $data)
	{
		$title = $data['title'];
		unset( $data['title']);
		$data['location'] = ROOT . $this->getCategoryDirectory($data['category_id']) . '/' . $data['file'];
		$q = "
		INSERT INTO `{$this->_table}`
		SET	`category_id`	=	{$data['category_id']},
			`type_id`		=	{$data['type_id']},
			`file`			=	'{$data['file']}',
			`location`		=	'{$data['location']}',
			`hide`			=	{$data['hide']},
			`item_id`		=	{$data['item_id']},
			`user_id`		=	{$data['user_id']},
			`width`			=	{$data['width']},
			`height`		=	{$data['height']},
			`size`			=	{$data['size']}
		;";
		$this->_db->q($q);
		if ($this->_db->error) die($this->_db->error);
		$id = $this->_db->insert_id;
		foreach (array(1) as $lang_id) {
			$q = "
			INSERT INTO `{$this->_table_info}`
			SET `id` = $id, `lang_id` = $lang_id, `title` = '', `updated` = now()
			;";
			$this->_db->q($q);
		}
		//fix order
		$this->fixOrder(
			array (
				"category_id"	=>	3,
				"item_id"		=>	$data['item_id']
			)
		);
		return $this->_db->affected_rows == 1 ? TRUE : FALSE;
	}
	public function getTotal(Array $data)
	{
		$total = 0;
		$where		=	array();
		$WHERE		=	'';
		if (isset($data['item_id']) && !empty($data['item_id'])) {
			$where['item_id'] = $data['item_id'];
		}
		if (isset($data['category_id']) && !empty($data['category_id'])) {
			$where['category_id'] = $data['category_id'];
		}
		if ( ! empty($where)) {
			$WHERE = "WHERE ";
			foreach ($where as $k => $v) {
				$WHERE .= " t1.`$k` = \"$v\" AND";
			}
		}
		$WHERE = rtrim($WHERE, " AND ");
		$q = "
		SELECT COUNT(*) as `total`
		FROM	`{$this->_table}` t1
		$WHERE
		;";
		$r = $this->_db->q($q);
		if (@$r && $r->num_rows > 0) {
			$o = $r->fetch_object();
			$total = $o->total;
			$r->free();
		}
		return $total;
	}
	public function getList ($data)
	{
		$out = array();
		$user_id = '';
		$where = '';
		$WHERE = array();
		if (isset($data['category_id'])) {
			$WHERE[] = "t1.`category_id` = {$data['category_id']}";
		}
		if (isset($data['user_id'])) {
			$WHERE[] = "t1.`user_id` = {$data['user_id']}";
		}
		if (isset($data['id'])) {
			$WHERE[] = "t1.`id` = {$data['id']}";
		}
		if (isset($data['item_id'])) {
			$WHERE[] = "t1.`item_id` = {$data['item_id']}";
		}
		if (isset($data['hide'])) {
			$WHERE[] = "t1.`hide` = {$data['hide']}";
		}
		if (isset($data['exact_limit'])) {
			$page_count	=	$data['page'];
			$page_start	=	0;
		} else {
			$page_count	=	isset($data['admin']) && $data['admin'] === TRUE ? ITEMS_PER_PAGE : ITEMS_PER_PAGE;
			$page_start	=	$page_count * isset($data['page']) ? $data["page"] : 0;
		}
		$hide		=	isset($data['hide']) &&  $data['hide'] !== FALSE ? " AND t1.`hide` = {$data['hide']} " : "";
		$order		=	isset($data['random']) ? 'rand()' : 't1.`ord` ASC';
		$item_id	=	isset($data['item_id']) ? " and t1.`item_id` = {$data['item_id']} " : '';
		$order		=	isset($data['item_id']) ? " t1.`ord` ASC" : ' t1.`ord` ASC';
		$where = !empty($WHERE) ? "WHERE " . implode(" AND ", $WHERE) : '';
		$q = "
		SELECT t1.*, t2.`title` AS `type`, t3.`directory` AS `category`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_type}` t2
		ON t1.`type_id` = t2.`id`
		LEFT JOIN `{$this->_table_category}` t3
		ON t1.`category_id` = t3.`id`
		$where
		ORDER BY $order
		LIMIT $page_start, $page_count
		;";
		//dump($q);
		$r = $this->_db->q($q);
		if ($r) {
			foreach ($r as $o) {
				$o->title = $this->getTitles($o->id);
				$out[] = $o;
			};
		}
		return $out;
	}
	
	public function getRecords($start = 0, $count = 20, $category_id = NULL, $item_id = NULL, $user_id = NULL)
	{
		$where = array();
		if ($category_id !== NULL) {
			$where[] = 't1.`category_id` = '.$category_id;
		}
		if ($item_id !== NULL) {
			$where[] = 't1.`item_id` = '.$item_id;
		}
		if ($user_id !== NULL) {
			$where[] = 't1.`user_id` = '.$user_id;
		}
		$order		=	"ORDER BY ord ASC";
		$where = $where ? "WHERE " . implode(" AND ", $where) : '';
		$q = "
		SELECT t1.*, t2.`title` AS `type`, t3.`directory` AS `category`
		FROM `{$this->_table}` t1
		LEFT JOIN `{$this->_table_type}` t2
		ON t1.`type_id` = t2.`id`
		LEFT JOIN `{$this->_table_category}` t3
		ON t1.`category_id` = t3.`id`
		$where
		$order
		LIMIT $start, $count
		;";
		//dump($q);
		return $this->_db->q($q);
	}

	public function getTitles($id)
	{
		$out = new stdClass;
		$q = "
		SELECT *
		FROM `{$this->_table_info}`
		WHERE `id` = {$id}
		;";
		$r = $this->_db->q($q);
		if ($r) {
			foreach ($r as $o) {
				$out->{$o->lang_id} = $o->title;
			}
		}
		return $out;
	}

	public function remove($id)
	{
		$file = $this->getImageById($id);
		if ($file) {
			$file_long	=	ROOT . 'images/' . $prefix . '/' . $file;
			if (is_file($file_long)) {
				unlink($file_long);
			}
		}
		
		$image = $this->getImage($id);
		
		$q = "
		DELETE FROM `{$this->_table}` 
		WHERE `id` = $id 
		LIMIT 1;
		";
		$this->_db->q($q);
		//print_r($image);
		//exit;
		$this->fixOrder(
			array(
				"category_id"	=>	$image->category_id,
				"item_id"	=>	$image->item_id
			)
		);
		return TRUE;
	}
}