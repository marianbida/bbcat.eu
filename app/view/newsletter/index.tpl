	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<div id="intro_listing" class="s_mb_10 s_p_0_10">
				<img src="{$base_url}images/city_varna.jpg" alt="" />
			</div>
			<span class="clear"></span>
			<!-- left column -->
			<div class="s_mt_70 s_pl_10 s_col_320">
				{include file="search/search_inner.tpl"}
				{include file="brochure/brochure.tpl"}
			</div>
			<!--/ left column -->

			<!-- right column -->
			<div class="s_col_630">
				<div id="hotels_listing" class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<div class="s_box_1_content clear">
						<h2>{$meta->page_title}</h2>
						{if $state eq 1}
							<p>{$lang.newsletter.signup_success}</p>
						{else}
							<div style="padding-left:10px">
								{eval var=$meta->page_content}
								<form id="login_form" action="{$base_url}{$lp}newsletter" method="post" class="form_2">
								<div class="form_row_2 clearfix">
									<label for="name">{$lang.newsletter.name}:</label>
									<input class="text s_w_200" type="text" name="name" id="nl_name" value="{$smarty.post.name|escape}" maxchar="255" />
									<sup class="red">*</sup>
									{if $err.name}
										<p class="s_error_message">{$err.name}</p>
									{/if}
								</div>
								<div class="form_row_2 clearfix">
									<label for="email">{$lang.newsletter.email}:</label>
									<input class="text s_w_200" type="text" name="email" id="nl_email" value="{$smarty.post.email|escape}" maxchar="255" />
									<sup class="red">*</sup>
									{if $err.email}
										<p class="s_error_message">{$err.email}</p>
									{/if}
								</div>
								<div class="form_row_2 clearfix">
									<label for="code">{$lang.newsletter.captcha}:</label>
									<input class="text s_w_200" type="text" value="{$smarty.post.code|escape}" id="nl_code" name="code"/>
									<sup class="red">*</sup>
									{if $err.code}
										<p class="s_error_message">{$err.code}</p>
									{/if}
								</div>
								<div class="clearfix">
									<label>&nbsp;</label>
									<span>
										<img alt="captcha" src="{$base_url}captcha.jpg" id="captcha" />
									</span>
								</div>
								<div class="form_row_2 clearfix clearfix"> 
									<label for="newsletter_tac"></label>
									<span>
										<input type="checkbox" id="newsletter_tac" value="1" name="tac"{if $smarty.post.tac eq 1} checked="checked"{/if}/> {$lang.newsletter.tac}
									</span>
									<span class="clear"></div>
									{if $err.tac}
										<p class="s_error_message">{$err.tac}</p>
									{/if}
								</div>
								<div class="data_submit_2 clearfix">
									<span class="s_button_2 s_button_2_bordo">
										<button type="submit">{$lang.newsletter.signup}</button>
									</span>
								</div>
								</form>
							</div>
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
						{/if}
					</div>
				<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
			</div>
		</div>
		<!-- end of right column -->
		<span class="clear"></span>
	</div>
</div>
<!--/ content -->