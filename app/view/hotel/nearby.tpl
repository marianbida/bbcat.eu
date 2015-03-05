<div id="hotels_nearby" class="s_box_1">
	<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
	<div class="s_box_1_content clear">
		<h2 class="s_mb_5 s_p_5_10 uppercase bordo">{$lang.nearby.hotels}</h2>
		{foreach from=$list item=v}
		<div class="s_offer s_block_1 clearfix">
			<a title="{$v->title|escape}" href="{$full_url}hotel/bg/{$v->ref}" class="s_thumb1">
				<img width="60" height="40" alt="{$v->alt|escape}" src="{$base_url}hotel_images/90x65/{$v->image}" />
			</a>
			<h3><a title="{$v->hotelTitle}" href="{$full_url}hotel/{$v->countryCode}/{$v->ref}">{$v->hotelTitle}</a></h3>
			<p>{$v->cityTitle}</p>
			{*<p><small>{$lang.from}:</small> <a title="{$v->ref}" href="{$full_url}hotel/{$v->countryCode}/{$v->ref}"><strong>€[na]</strong></a></p>*}
		</div>
		{/foreach}
	</div>
	<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
</div>