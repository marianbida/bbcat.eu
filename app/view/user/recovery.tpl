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
						<div>
							{$meta->page_content}
						</div>
						{if $step eq '01'}
							<h2>Поздравления</h2>
							<div>
								<p>Поздравления, Вашата нова парола беше изпратена на посочения от Вас e-mail адрес.</p>
							</div>
						{else}
							<h2>Забравена парола</h2>
							<form action="{$base_url}recovery" method="post" class="form_2">
							<div class="form_row_2 clearfix">
								<label for="email">E-mail:</label>
								<input class="text s_w_200" type="text" name="email" id="email" value="{$smarty.post.email|escape}" />
								<sup>*</sup>
								{if $err.email_err}
									<p class="s_error_message">{$err.email_err}</p>
								{/if}
							</div>
							<div class="data_submit_2 clearfix">
								<span class="s_button_2 s_button_2_bordo"><button type="submit">{$lang.button.send}</button></span>
							</div>
							</form>
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