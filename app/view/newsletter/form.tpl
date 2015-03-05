<!-- newsletter -->
<div id="newsletter" class="s_box_1 s_box_1_yellow">
	<script type="text/javascript">
	var def_name = "{$lang.newsletter.name}";
	var def_email = "{$lang.newsletter.email}";
	{literal}
		$(document).ready(function(){
			$("#nl_name").unbind('focus').focus(function(){
				if ($(this).val() == def_name) {
					$(this).val('');
				}
			});
			$("#nl_name").unbind('blur').blur(function(){
				if ($(this).val() == '') {
					$(this).val(def_name);
				}
			});
			$("#nl_email").unbind('focus').focus(function(){
				if ($(this).val() == def_email) {
					$(this).val('');
				}
			});
			$("#nl_email").unbind('blur').blur(function(){
				if ($(this).val() == '') {
					$(this).val(def_email);
				}
			});
		});
	{/literal}
	</script>
	<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
	<div class="s_box_1_content clear">
		<h2 class="s_mb_5 s_p_5_10 uppercase bordo">{$lang.newsletter.newsletter}</h2>
		<form class="form_2 s_p_0_10" action="{$full_url}newsletter" method="post">
		<div class="left s_mr_10">
			<input id="nl_name" name="name" class="text s_w_120" type="text" value="{$lang.newsletter.name}" />
		</div>
		<div class="left">
			<input id="nl_email" name="email" value="{$lang.newsletter.email}" class="text s_w_120" type="text" />
		</div>
		<div class="data_submit_1 clear clearfix">
			<span class="s_button_1 s_button_1_bordo right"><button>{$lang.newsletter.subscribe}</button></span>
			<p><em>{$lang.newsletter.subscribe_now}</em></p>
		</div>
		</form>
	</div>
	<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
</div>
<!--/ newsletter -->