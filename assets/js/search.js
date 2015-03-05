/* search */
var SearchModel = function()
{
	var self		=	this;
	$("#ss_up").live("click", function(){
		$("#search_order_vector").val("DESC");
	});
	$("#ss_down").live("click", function(){
		$("#search_order_vector").val("ASC");
	});
};
var search_obj = new SearchModel();
SearchModel = null;