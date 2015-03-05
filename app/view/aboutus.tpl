	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<div id="intro_listing" class="s_mb_10 s_p_0_10">
				<img src="{$base_url}images/city_varna.jpg" />
			</div>
			<span class="clear"></span>
			<!-- left column -->
			<div class="s_mt_70 s_pl_10 s_col_320">
				{include file="search/search_inner.tpl"}
				{include file="newsletter/form.tpl"}
				{include file="brochure/brochure.tpl"}
			</div>
			<!--/ left column -->

			<!-- right column -->
			<div class="s_col_630">
				<div id="hotels_listing" class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<div class="s_box_1_content clear">
						<h2>{$meta->page_title}</h2>
						{eval var=$meta->page_content}
					</div>
				<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
			</div>
		</div>
		<!-- end of right column -->
		<span class="clear"></span>
	</div>
</div>
<!--/ content -->