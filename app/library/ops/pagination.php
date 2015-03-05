<?php
	$cat_list	=	array();
	$data		=	array();
	$sub_action	=	'';
	$error		=	'';
	$cat_id		=	'';
	$this->video_formats = array("AVI","MOV","MPG","WMV");
	$this->load->model("Media_model", "media");
	$this->tpl->assign('one', $one);
	$this->tpl->assign('two', $two);
	$this->tpl->assign('parent', $one);
	$this->tpl->assign('lang_list', $this->lang_list);
	$this->tpl->assign('languages_list', $this->language->listLanguages($this->language->code, TRUE, TRUE));
	//
	switch($action){
	/** 
	 * @param $_POST['items']
	 * @return void
	 */
	case "update_media_order":
		if ($this->input->post("item_id") != 0) {
			$items = explode('_', $this->input->post("items") );
			for( $i = 0; $i < sizeof( $items ); $i++ ) {
				$this->media->updateOrder( array(
						"id"	=>	$item[ $i ],
						"order"	=>	$i
					)
				);
			};
		}
		exit;
	break;
	/* remove single media item */
	case "remove":
		$id = $this->input->post("id");
		$file_remove_status = FALSE;
		$thumb_remove_status = FALSE;
		$reply 				= new stdclass;
		$reply->status		=	$this->media->remove($id);
		echo json_encode($reply);
		exit;
	break;
	/* get media pagination */
	case "getMediaPagination":
		$out		=	'';
		$page		=	$this->input->post('page');
		$cat_id		=	$this->input->post('type');
		$id			=	$this->input->post('id');
		$admin		=	$this->input->post('admin');
		$item_id	=	$this->input->post("item_id");
		if($admin == 1) {
			$data	=	array(
				"category_id"	=>	$cat_id
			);
		}else{
			$data	=	array(
				"category_id"	=>	$cat_id
			);	
		}
		if($item_id != 0){
			$data['item_id'] = $item_id;
		}
		$total	=	$this->media->getTotal( $data );
		$steps	=	floor($total / ITEMS_PER_PAGE_ADMIN);
		$page_prev	=	($page - 1) > 0 ? $page - 1 : 0;
		$page_next	=	$page + 1 <= $steps ? $page + 1  : $steps;
		if ($steps > 0) {
			//$out .= "<ul>";
			$out .= "<div><a href=\"javascript:media.init(0,".$cat_id.");\">&laquo;</a></div>";
			$out .= "<div><a href=\"javascript:media.init(".$page_prev.",".$cat_id.");\">&lsaquo;</a></div>";
			for( $i = 0; $i <= $steps; $i++ ) {
				$ii = $i + 1;
				$out .= "<div style='width:15px;height:15px;background:transparent url(/media/images/box_arrow.gif) center center no-repeat'>";
				if ($page != $i) {
					$out .= "<a style='width:15px;height:15px;line-height:15px;text-align:center;color:#fff' href=\"javascript:media.init(".$i.",".$cat_id.");\">".$ii."</a> ";
				} else {
					$out .= "<strong>".$ii."</strong> ";
				}
				$out .= "</div>";
			}
			$out .= "<div class='inline'><a href=\"javascript:media.init(".$page_next.",".$cat_id.");\">&rsaquo;</a> </div>";
			$out .= "<div class='inline'><a href=\"javascript:media.init(".$steps.",".$cat_id.");\">&raquo;</a> </div>";
			//$out .= "<div class='inline'><a href=\"javascript:media_show_all(".$cat_id.");\">all</a></div>";
			//$out .= "</div>";
		}
		echo $out;
		exit;
	break;
	case "add_to_item":
		if($this->input->post("item_id")) {
			$data = array(
				"data"	=>	array(
					"item_id"	=>	$this->input->post("item_id")
				),
				"where"	=>	array(
					"id"	=>	$this->input->post("id")
				)
			);
			$state = $this->media->edit($data);
			echo $state > 0 ? TRUE : FALSE;
		}
		exit;
	case "remove_from_item":
		$data = array(
			"data"	=>	array(
				"item_id"	=>	0
			),
			"where"	=>	array(
				"id"	=>	$this->input->post("id")
			)
		);
		$state = $this->media->edit($data);
		echo $state > 0 ? TRUE : FALSE;
		exit;
	break;
	case "approve":
		$data = array(
			"data"	=>	array(
				"approved"	=>	1
			),
			"where"	=>	array(
				"id"	=>	$this->input->post("id")
			)
		);
		$this->media->edit($data);
		echo 1;
		exit;
	break;
	case "refuse":
		$data = array(
			"data"	=>	array(
				"approved"	=>	0
			),
			"where"	=>	array(
				"id"	=>	$this->input->post("id")
			)
		);
		$this->media->edit($data);
		echo 1;
		exit;
	break;
	case "json_get_info":
		/**
	 	* get info on a single media file
	 	* @return object json
	 	*/
	
		$out = new stdclass;
		$id = $this->input->post('id');
		$out->info = $this->media->get( $id );
		echo json_encode( $out );
		exit;
	break;
	case "edit_title":
		/**
	 	* Edit single media title
	 	* @return state json
	 	*/
		$out = new stdclass;
		$data = 
		//update main table
		$this->media->edit(array(
				"data"	=>	array("hide"=>$this->input->post("hide")),
				"where"	=>	array("id"=>$this->input->post("id"))
			)	
		);
		//update info table
		$titles = array();
		foreach($this->language->lang_list as $code){
			$titles[$code] = $this->input->post("title_" . $code );
		}
		$data = array(
			"data"	=>	array(
				"title"	=>	$titles
			),
			"where"	=>	array(
				"id"	=>	$this->input->post("id")
			)
		);
		$out->status = $this->media->editInfo($data);
		echo json_encode($out);
		exit;
		break;
	case "upload":
		$status = 0;
		$valid = TRUE;
		$data = array();
		/*
		 * 
		 $rule = array(
			"cat_id"	=>	'required|numeric'
		);
		$this->form_validation->set_rules( $rule );
		if( $this->form_validation->run() == FALSE ){
			$out['validation_error'] = $this->validation->error_string;
			$valid = FALSE;
		}else {
			$valid = TRUE;
		}
		*/
		$valid = true;
		if( $valid && isset( $_FILES['Filedata'] ) )
		{
			$media_category		=	(int) $this->input->post("cat_id");
			$media_hide_image	=	$this->input->post("hide") ? (int) $this->input->post("hide") : 0;
			$media_dir 			=	$this->media->getCategoryDirectory( $media_category );
			// for flash single file upload
			$_name		=	md5(time()).'.'.$this->media->getExtension($_FILES['Filedata']['name']);//$_FILES['Filedata']['name'];
			$_type		=	$_FILES['Filedata']['type'];
			$_tmp_name	=	$_FILES['Filedata']['tmp_name'];
			if( $_name != '' )
			{
				$file	=	BASEPATH . '../media/media/' . $media_dir . '/' . $_name;
				$title	=	$this->input->post('title'); 
				$data = array(
					'category_id'	=>	$media_category,
					'type_id'		=>	$this->media->getMediaType($_type),
					'file'			=>	$_name,
					'location'		=>	$file,
					'title'			=>	isset( $_POST['title'] ) && !empty( $_POST['title'] ) ? $title : '',
					'tmp_name'		=>	$_tmp_name,
					"hide"			=>	$media_hide_image,
					"item_id"		=>	$this->input->post("item_id") ? (int) $this->input->post("item_id") : 0 
				);
				if( $data['type_id'] == 0 ) {
					$data['type_id'] = $this->media->getMediaTypeByExtension( $data['file'] );
				}
				// pattern for preg_match in
				$step = -1;
				$pattern = '@^(.*)-(\d+)\.([a-z0-9]{1,4})$@i';
				while ($this->media->is_media_exist(BASEPATH.'../media/media/'.$media_dir.'/'.$_name)){
					if (preg_match($pattern, $_name, $matches)) {
						$_name = $matches[1] . '-' . ++$step . '.' . $matches[3];
					} elseif (preg_match('@^(.*)\.([^.]+)$@', $_name, $matches)) {
						$_name = $matches[1] . '-' . ++$step . '.' . $matches[2];
					}
				}
				$data['file'] = $_name;
				$data['location'] = BASEPATH.'../media/media/' . $media_dir . '/' . $_name;
				$this->media->processMedia( $data );
			}
			echo 1;
		}else{
			echo 0;
		}
	exit;
	break;
	case "convert":
		$mode	=	$this->input->post("mode");
		$data = array(
			"mode"		=>	$this->input->post("mode"),
			"fps"		=>	FALSE,
			"format"	=>	"flv",
			"id"		=>	$this->input->post("item_id")
		);
		switch($mode){
		case 1:
			$data["width"]	=	$this->input->post("width");
			$data["height"]	=	$this->input->post("height");
			$data["fps"]	=	$this->input->post("fps");			
		break;
		case 2:
			$data["size"]	=	$this->input->post("size");
			$data["fps"]	=	$this->input->post("fps");
		break;
		default:
		break;
		}
		$this->media->convert($data);
		exit;
	break;
	case "get_info":
		$out = '';
		if( $this->input->post('type') && $this->input->post('id') )
		{
			$type = $this->input->post('type');
			$id = $this->input->post('id');
			if(  $type == 'media' && $id )
			{
				
				$item = $this->media->get($id);
				$this->tpl->assign('preview_media', $item->type);
				$this->tpl->assign('item', $item );
				$this->tpl->assign('hide_add_to_item', $this->input->post('hide_add'));
				$this->tpl->assign('hide_actions', $this->input->post('hide_actions'));
				$this->tpl->assign('video_formats', $this->video_formats);
				$out = $this->tpl->fetch('multimedia/media_info_ajax.tpl');
			}
		}
		echo $out;
		exit;
	break;
	case "getMediaPagination":
		/* ajax get media pagination */
		$out		=	'';
		$page		=	$this->input->post('page');
		$cat_id		=	$this->input->post('type');
		$id			=	$this->input->post('id') != 0 ? $this->input->post('id') : FALSE ;
		$admin		=	$this->input->post('admin');
		$item_id	=	$this->input->post("item_id");
		$data = array(
			"category_id"	=>	$cat_id
		);
		if($id) $data['id'] = $id;
		$total	=	$this->media->getTotal( $data );
		$steps	=	floor($total / ITEMS_PER_PAGE_ADMIN);
		if( $steps > 0 ){
			$out .= "<ul>";
			
				$out .= "<li class='inline'><a href=\"javascript:media.init(0,".$cat_id.");\">&laquo;</a> </li>";
			
			for( $i = 0; $i <= $steps; $i++ ){
				$ii = $i + 1;
				$out .= "<li class='inline'>";
				if( $page != $i )
				{
					$out .= "<a href=\"javascript:media.init(".$i.",".$cat_id.");\">".$ii."</a> ";
				}else{
					$out .= "<strong>".$ii."</strong> ";
				}
				$out .= "</li>";
			}
			
				$out .= "<li class='inline'><a href=\"javascript:media.init(".$steps.",".$cat_id.");\">&raquo;</a> </li>";
				$out .= "<li class='inline'><a href=\"javascript:media_show_all(".$cat_id.");\">all</a></li>";
			
			$out .= "</ul>";
		}
		echo $out;
		exit;
	break;
	case "getMediaDetailList":
		/* ajax get media detail list */
		$list_view	=	$this->input->post("list_view");
		$all		=	$this->input->post("all");
		$all		=	$all == 1 ? TRUE : FALSE;
		$page		=	$this->input->post("page");
		$type		=	$this->input->post("type");
		$admin		=	$this->input->post("admin");
		$item_id	=	$this->input->post("item_id") != 0 ? $this->input->post("item_id") : FALSE;
		$reorder	=	$this->input->post("reorder");
		if ($all) {
			$data = array(
				"category_id"	=>	$type
			);
			if ($id) {
				$data['id'] = $id;
			}
			$page = $this->media->getTotal($data); 
		}
		$data = array(
			"page"			=>	$page,
			"category_id"	=>	$type,
		);
		if ($item_id) {
			$data['item_id'] = $item_id;
		}
		$list = $this->media->getList($data);
		$this->tpl->assign("list_view", $list_view);
		$this->tpl->assign("media", $list );
		$this->tpl->assign("reorder",$reorder);
		$this->tpl->display("multimedia/media_detail_list_ajax.tpl");
		exit;
	break;
	case "getMediaList";
		/* ajax reply getMediaList */
		$all		=	$this->input->post("all");
		$all 		=	$all == 1 ? TRUE : FALSE;
		$page		=	$this->input->post("page");
		$type		=	$this->input->post("type");
		$admin		=	$this->input->post("admin");
		$item_id	=	$this->input->post("item_id") != 0 ? $this->input->post("item_id") : FALSE;
		$data = array(
			"page"			=>	$page,
			"category_id"	=>	$type,
			"admin"			=>	$admin
		);
		if($item_id) {
			$data["item_id"]	=	$id;
		}
		$list = $this->media->getList($data);
		$this->tpl->assign("list", $list);
		$this->tpl->display('multimedia/media_left_ajax.tpl');
		exit;
	break;
	case "file":
		$cat_id = $one;
	break;
	case "category":
		switch($one){
		case "remove":
			$this->media->removeCategory($two);
		break;
		case "new":
			if(!empty($_POST)){
				$this->load->library('form_validation');
				$rules = array();
				$rules[] = array(
					'field'	=> 'directory',
					'label'	=> $this->language->vars['media']['category']['directory'],
					'rules'	=> 'required|min_length[3]'
				);
				$this->form_validation->set_rules($rules);
				$error['directory_exist_err'] = $this->media->directory_exist(
					$this->input->post('directory')
				);
				if (!$error['directory_exist_err'] && $this->form_validation->run() !== FALSE) {
					 $next_id = $this->media->getCategoryNextId();
					 $data = array(
					 	"id"		=> $next_id,
					 	"directory"	=>	$this->input->post("directory"),
					 	"title"		=>	array()
					 );
					 foreach( $this->language->getList() as $lang ){
					 	$data['title'][ $lang ] = $this->input->post($lang.'_title');
					 }
					 $this->media->addCategory( $data );
				} else {
					foreach( $rules  as $k => $v ){
						$error[$v['field']. '_err'] = form_error( $v['field']);
					}
				}
			}
		break;
		case "edit":
			if(!empty($_POST)){
				$data = array(
					"id"		=>	$two,
					"old_dir"	=>	$this->media->getCategoryDirectory($two),
					"directory"	=>	$this->input->post("directory"),
					"title"		=>	array()
				);
			 	foreach( $this->language->getList() as $lang ){
			 		$data['title'][ $lang ] = $this->input->post($lang.'_title');
				}
				$this->media->updateCategory($data);
			}
			$data = $this->media->getCategory($two);
		break;
		default:
		}
		break;
	}
	$this->tpl->assign("cat_id", $cat_id);
	$this->tpl->assign("data", $data);
	$this->tpl->assign("error", $error);
	$this->tpl->assign("cat_list", $this->media->getCategoryList());
	$this->tpl->view('multimedia/admin/' . $action . '.tpl');
	exit;
class Multimedia extends Controller
{
	/**
	 * @var Media_model
	 */
	var $media;
    private $_video_formats;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('validation');
		$this->load->library('pagination');
		$this->load->model("Media_model", "media");
		$this->_video_formats = array('MOV','WMV','AVI');
	}
	/**
	 * render upload form
	 * @param (int) cat_id, (int) item_id, (whatever) etc
	 * @return html
	 */
	public function upload_hold($one = FALSE, $two = FALSE, $three = FALSE)
	{
		header("Content-Type: text/html; charset=utf8");
		$this->tpl->assign("one", $one);
		$this->tpl->assign("two", $two);
		$this->tpl->assign("three", $three);
		echo $this->tpl->display("media/upload_hold.tpl");
	}
	
	
	public function write_err( $err )
	{
		$file = fopen( BASEPATH . '../error.txt', 'w');
		$content = $err;
		fwrite( $file, $content );
		fclose( $file );
	}
	/* ajax get total media by type */
	public function getTotalMedia( $type, $admin = FALSE)
	{
		if( $type )
		{
			echo $this->media->getTotal( $type, $admin = FALSE );
		}
	}
	
	
	public function index()
	{
		$this->info();
	}
	/* media get */
	public function get_video( $key )
	{
		$media_id = $this->media->getMediaByKey( $key );//old
		$media_id = $key;//new
		if( $media_id )
		{
			$media = $this->media->get( $media_id );
		}
		$media = explode('/',$media->location);
		//$this->db->select(
		
		$this->tpl->assign('id', $media_id);
		$this->tpl->assign('caption', 'n/a');
		$this->tpl->assign('description', 'n/a');
		$this->tpl->assign('embed', 'embed');
		$this->tpl->assign('path', $this->config->item('base_url') . $media[0].'/'.$media[1].'/');
		$this->tpl->assign('file',$media[2]);
		
		header('Content-type: text/xml; encoding=utf8');
		$this->tpl->display('tutorials/video/xml.tpl');
		exit;
	}
	/* get attachments */
	/* ajax reply getMediaList */
	public function getAttachments()
	{
		$page = 0;
		$type = $this->input->post('type');
		$out = $this->media->getList( $page, $type );
		$this->tpl->assign('media', $out);
		echo $this->tpl->fetch('media/media_left_ajax.tpl');
		exit;
	}
	/* ajax get attachments list */
	public function get_attachments_list( $type, $id )
	{
		$out = '';
		$q = "
		select 
			t1.`id`,t1.`media_id`, t2.`title`, t2.`file`, t2.`location`
		from
			`tutorial_attachment` t1
		left join
			`media` t2
		on 
			t1.`media_id` = t2.`id`
		where
			t1.`tutorial_id` = '$id'
		order by
			t1.`id` asc
		;";
		$r = $this->db->query( $q );
		if( $r->num_rows() > 0 )
		{
			$this->tpl->assign('attachments', $r->result() );
			$this->tpl->assign('id', $id );
			$out = $this->tpl->fetch('tutorials/list_of_attachments.tpl');
		}
		echo $out;
		exit;
	}
}