/* Tabs Model */
function TabModel(idx)
{
	this.idx	=	idx;
	this.tabs	=	'';
	this.conf	=	{
		media_convert:{
			select:function(event,ui){
				try{
					media.set_convert_mode(ui.index);
				}catch (e){
				}
			}
		},
		normal:{
		}
	};

	this.init = function(mode) {
		this.tabs = $(this.idx+" > ul");
		this.tabs.tabs(this.conf[mode]);
	};

	this.select = function(index) {
		this.tabs.tabs('enable', index);
		if (this.tabs.data('selected.tabs') != index) {
			this.tabs.tabs('select', index);
		}
	};

	this.selectOnly = function(index) {
		for (var i = 0;i < this.tabs.tabs('length'); i++) {
			if ( i == index ) {
				this.tabs.tabs('enable', index);
				if (this.tabs.data('selected.tabs') != index) {
					this.tabs.tabs('select', index);
				}
			} else {
				this.tabs.tabs('disable', i);
			}
		}
	};

	this.disable = function(index) {
		this.tabs.tabs('disable', index);
	};

	this.enable = function(index) {
		this.tabs.tabs('enable', index);
	};

	this.add = function(url, label) {
		this.tabs.tabs('add', null, label);

	};

	this.destroy = function() {
		this.tabs.tabs('destroy');
	};
}

function newWin(path,w,h,r) {
		window.open(path,"",'height='+h+',width='+w+',left='+((screen.width - w) / 2)+',top='+((screen.height - h) / 2)+',resizable='+r+',location=no,scrollbars=no,menubars=no,toolbars=no');
}
var CategoryModel = function() {

	var gate = conf.base_url + 'gate.php';

	var getFrontSubCategoryList = function (obj) {
		if (obj.id == undefined || obj.id == '') return;
		obj.target.attr("disabled", "disabled");
		$.post(gate, {module:"category", action:"get_front_category_list", parent:obj.id}, function (data) {
			obj.target.empty().append(data.list).show();
			obj.target.removeAttr("disabled");
		},
		"json"
		);
	};

	var getFrontModelList = function (obj) {
		obj.target.attr("disabled", "disabled");
		$.post(gate, {module:"model", action:"get_front_model_list", brand_id:obj.id}, function (data) {
			obj.target.empty().append(data.list);
			obj.target.removeAttr("disabled");
		},
		"json"
		);
	}
	var getFrontModList = function (_in) {
		_in.target.attr("disabled", "disabled");
		
		var obj = {module:"model", action:"get_front_mod_list", brand_id:_in.brand_id};
		if (_in.model_id != undefined) {
			obj.model_id = _in.model_id;
		}
		$.post(gate, obj, function (data) {
			_in.target.empty().append(data.list);
			_in.target.removeAttr("disabled");
		},"json");
	}
	
	$("#tiny_brand").change(function(){
		getFrontModelList({id:$(this).val(), target:$("#tiny_model")});
		getFrontModList({brand_id:$(this).val(), target:$("#tiny_mod")});
	});
	$("#tiny_model").change(function(){
		getFrontModList({brand_id:$("#tiny_brand").val(), model_id: $(this).val(), target:$("#tiny_mod")});
	});
	$("#tiny_category").change(function(){
		getFrontSubCategoryList({id:$(this).val(), target:$("#tiny_subcategory")});
	});
	$("#search_category").change(function(){
		getFrontSubCategoryList({id:$(this).val(), target:$("#search_sub_category")});
	});
	$("#search_brand").change(function(){
		getFrontModelList({id:$(this).val(), target:$("#search_model")});
		getFrontModList({brand_id:$(this).val(), target:$("#search_mod")});
		
	});
	$("#search_model").change(function(){
		getFrontModList({brand_id:$("#brand").val(), model_id: $(this).val(), target:$("#search_mod")});
	});
}
/* search */
var SearchModel = function() {
	var self		=	this;
	var submitForm = function() {
		$("#search_form").submit();
	};
	//search by
	var setParam = function (e) {
		$("#search_order_by").val(e.target.id.split("_")[1]);
		submitForm();
	}
	$("#ss_price, #ss_manifacturer, #ss_bestbuy, #ss_new").live("click", setParam);
	
	//search vector
	var setVector = function (e) {
		$("#search_order_vector").val(e.target.id.split("_")[1]);
		submitForm();
	};
	$("#ss_asc, #ss_desc").live("click", setVector);
};
$(document).ready(function() {
	var category_obj = new CategoryModel();
	CategoryModel = null;
	//thickbox
	tb_init("a.thickbox");
	//tooltip
	/*$('.cat').tooltip({
			delay: 0,
			showURL: false,
			bodyHandler: function() {
				var id = this.id.split('_')[2];
				var img = $("img#cat_"+id).attr("src");
				return $("<img/>").attr("src", img);
			}
		}
	);
	$('.cat').click(function(){
		//$("a#cat_aa_"+this.id.split('_')[2]).click();
	});*/
  //
  var O = function() {
	this.items = ['news','promo'];
	this.show = function (key) {
		for (var i in this.items) {
			if (key != this.items[i]) {
				$("#"+this.items[i]+'_list').hide();
			} else {
				$("#"+this.items[i]+'_list').show();
			}
		}
	}
  }
  var o_obj = new O();
  $("a.ad_popup").click(function(e){
		e.preventDefault();
		newWin('/?req=ad_popup&image='+$(this).attr("href"), 320, 240, 0);
	});
	//NewsScrollStart();
	$("a.ad_gallery_item").click(function (event) {
		event.preventDefault();
		$("#gallery_front_image").attr("src", $(this).attr("href"));
	});
	//reload captcha
	$("#captcha").live("click", function(){
		setImage('captcha','captcha.jpg');
	});
	var search_obj = new SearchModel;
	SearchModel = null;
	$("#search_tabs").tabs();
	
});
var setImage = function (where, what) {
	$("#"+where).attr("src", what);
}