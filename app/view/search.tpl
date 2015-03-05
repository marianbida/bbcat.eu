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
						<h2>{$h2}</h2>
						<div class="s_sorting_box">
							<form class="form_2 s_p_10_20 clearfix">
								<strong class="left">{$lang.sort.sort_by}:</strong>
								<label class="radio"><input name="sort_on" class="radio" type="radio" {if $smarty.get.sort_on eq 'star' or $smarty.get.sort_on eq ''}checked{/if} /> {$lang.sort.star}</label>
								<label class="radio"><input name="sort_on" class="radio" type="radio" {if $smarty.get.sort_on eq 'price'}checked{/if} /> {$lang.sort.price}</label>
								<label class="radio"><input name="sort_on" class="radio" type="radio" {if $smarty.get.sort_on eq 'alpha_asc'}checked{/if} /> {$lang.sort.alpha_asc}</label>
							</form>
						</div>
						{foreach from=$list item=v}
						{if $search_mode eq 'hotel'}
							<div class="s_offer_1 s_block_1 clearfix">
								<a class="s_thumb" href="{$full_url}hotel/{$v->country_code}/{$v->ref}">
									<img src="{$base_url}hotel_images/120x90/{$v->file}" width="90" height="65" />
								</a>
								<div class="s_info">
									<h3><a href="{$full_url}hotel/{$v->country_code}/{$v->ref}" title="">{$v->title}</a></h3>
									<p class="s_location">{$v->city}</p>
									<p class="s_desc" style="overflow:hidden;height:45px">{$v->short|strip_tags}</p>
								</div>
								<div class="s_feats">
									<span class="s_stars right"><span class="s_star_{$v->star}">{$v->star}</span></span>
								  <p class="s_price right"><small>{$lang.common.from}:</small> <a href="{$full_url}hotel/{$v->country_code}/{$v->ref}" title=""><strong class="s_f_14">{$item->curr_left} {$item->lowest_price} {$item->curr_right}</strong></a></p>
								  <a class="s_button_1 s_button_1_bordo right" href="{$full_url}hotel/{$v->country_code}/{$v->ref}" title=""><span>{$lang.btn.details}</span></a>
								</div>
							</div>
						{elseif $search_mode eq 'district'}
							<div class="s_offer_1 s_block_1 clearfix">
								<a class="s_thumb" href="{$full_url}district/{$v->country_code}/{$v->ref}">
									<img src="{$base_url}hotel_images/120x90/{$v->file}" width="90" height="65" />
								</a>
								<div class="s_info">
									<h3><a href="{$full_url}hotel/{$v->country_code}/{$v->ref}" title="">{$v->title}</a></h3>
									<p class="s_location">{$v->city} / {$v->hotel_total}</p>
									<p class="s_desc" style="overflow:hidden;height:45px">{$v->short|strip_tags}</p>
								</div>
							</div>
						{/if}
						{/foreach}
						<!--pager-->
						{$pagination}
						<!--/pager-->
					</div>
				<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
			</div>
		</div>
		<!-- end of right column -->
		<span class="clear"></span>
	</div>
</div>
<!--/ content -->