function load() {
	var url = document.forms["publish"].elements["address"].value;
	$.ajax({
		type : 'POST',
		url : "/autoload",
		data : {
			"url" : url
		},
		dataType: 'json',
		success : function(data) {
			$("#publish input[name='name']").val(data.title);
			$("#publish textarea[name='description']").val(data.description);
			$("#publish input[name='keywords']").val(data.keywords);
		}
	});
       
}