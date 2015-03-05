	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<div id="intro_listing" class="s_mb_10 s_p_0_10">
				<img src="{$hat_image}" width="960" height="100" alt="{$hat_image_alt|escape}" />
			</div>
			<span class="clear"></span>
			<!-- left column -->
			<div class="s_pl_10 s_col_250">
				{include file="search/search_hotel.tpl"}
				{include file="hotel/map.tpl" mdata=$map_data}
				{include file="hotel/nearby.tpl" list=$near_list}
				{include file="brochure/brochure1.tpl"}
			</div>
			<!-- end of left column -->

			<!-- right column -->
			<div class="s_col_700">
				<div id="hotel" class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<div class="s_box_1_content clear">
						<div class="right s_p_10 s_mb_10">
							<span class="s_stars"><span class="s_star_{$data->star}"></span></span>
						</div>
						<span class="label_best_value"></span>
						<h1>{$data->title}</h1>
						<p class="s_location">
							{$data->address}, {$data->district}, {$data->city} (<a class="thickbox" href="{$full_url}map/hotel/{$data->ref}?TB_iframe=true&amp;height=420&amp;width=730"><em>{$lang.ad.show_map}</em></a>)
						</p>

						<!-- tab holder -->
						<div class="s_tabs clearfix">
						<ul class="tabs_2_nav">
							<li><a href="#hotel_info" title="{$lang.ad.info_title}">{$lang.ad.info}</a></li>
							<li><a href="#hotel_reviews" title="{$lang.ad.reviews_title}">{$lang.ad.reviews}</a></li>
							<li><a href="#hotel_reservation" title="{$lang.ad.reservation_title}">{$lang.ad.reservation}</a></li>
							<li><a href="#hotel_gallery_large" title="{$lang.ad.gallery_title}">{$lang.ad.gallery}</a></li>
						</ul>
						<div id="hotel_info" class="s_tab_box clearfix">
							<div id="hotel_gallery">
								<div id="gallery_loading"></div>
								<div class="gallery_slideshow_holder s_thumb_1">
									<div id="gallery_slideshow" class="gallery_slideshow">
										<a href="javascript:;">
											<img id="gruh" src="{$base_url}hotel_images/220x170/{$data->media_list.0->file}" alt="" />
										</a>
									</div>
								</div>
								<div id="thumbnails">
									<ul class="thumbs clearfix">
										{foreach from=$data->media_list item=img key=i}
										{if $i lt 3}
										<li><a class="thumb s_thumb_1" onmouseover="setImage('gruh','{$base_url}hotel_images/220x170/{$img->file}');" href="javascript:setImage('gruh','{$base_url}hotel_images/220x170/{$img->file}');"><img src="{$base_url}hotel_images/60x60/{$img->file}" alt="" /></a></li>
										{/if}
										{/foreach}
									</ul>
								</div>
								{if $data->hotel_rooms}
									<p>{$lang.ad.rooms}:{$data->hotel_rooms}</p>
								{/if}
								{if $data->chain_id}
									<p>{$lang.ad.chain}:<strong>{$data->chain}</strong></p>
								{/if}
							</div>
							
							<div id="hotel_brief" class="right s_w_410 s_static">
								<h3>{$lang.ad.overview}</h3>
								{eval var=$data->description}
							</div>
							
							{if $review_list|@sizeof gt 0}
							<div id="latest_review">
								<div class="s_review">
									<div class="s_meta">
										<a class="s_user bordo" href="javascript:;">{$review_list.0->name}</a>
										<p class="s_date">{$review_list.0->created|date_format}</p>
									</div>
									<div class="s_tooltip s_tooltip_right">
										<span class="d_top_right"></span>
										<p class="s_comment">{$review_list.0->content}</p>
										<span class="d_bottom_left"><span class="d_bottom_right"></span></span>
									</div>
								</div>
							</div>
							{/if}
							<span class="clear"></span>
							
							<!-- availability -->
							<div id="hotel_availability" class="s_mb_20">
								<h2 class="s_h2_1"><span>{$lang.ad.availability}</span></h2>
								<div class="s_box_4">
									<span class="d_top_left"></span>
									<span class="d_top_right"></span>
									<span class="d_bottom_right"></span>
									<table cellpadding="0" cellspacing="0" border="0">
									<thead>
										<tr>
											<th class="first s_p_0" width="60">&nbsp;</th>
											<th style="text-align:left">{$lang.ad.room}</th>
											<th style="text-align:left">{$lang.ad.price}</th>
											<th width="75">&nbsp;</th>
										</tr>
									</thead>
									<tbody>
									<tr>
										<td class="first s_p_10_0"><img src="{$image_url}images/thumb_small_1.jpg" width="60" height="60" /></td>
										<td class="align_left">
											<div class="s_room">
												<h3 class="s_mb_5"><a class="bordo" href="">Standard Twin Room</a></h3>
												<p>Prices are per room for 4 nights<br />
												<strong>Included in room price:</strong> VAT, buffet breakfast.<br />
												<strong>Not included in room price:</strong> city tax.</p>
											</div>
										</td>
										<td valign="middle">
											<select>
												<option>1 day - $500</option>
											</select>
										</td>
										<td>
											<a class="s_button_1 s_button_1_bordo" href=""><span class="s_w_70">{$lang.ad.book}</span></a>
										</td>
									</tr>
									</tbody>
									</table>
								</div>
							</div>
							<!--/ availability -->
							<!-- facilities -->
							<div id="hotel_facilities" class="s_mb_20">
								<h2 class="s_h2_1"><span>{$lang.ad.facilities}</span></h2>
								<ul class="s_list_2 clearfix">
								{foreach from=$data->option_list item=opt}
								<li>{$opt->title}</li>
								{/foreach}
								</ul>
							</div>
							<!--/ facilities -->

							{include file="ad/terms.tpl"}
							
							<!-- tos -->
							<div id="hotel_tos" class="s_static">
								<h2 class="s_h2_1"><span>{$lang.ad.tos}</span></h2>
								{assign var=base_name value=$smarty.const.BASE_NAME}
								{eval var=$ourterms->content}
							</div>
							<!--/ tos -->
						</div>
				
				<div id="hotel_reviews" class="s_tab_box">
					<div class="s_box_4 s_mb_20 clearfix">
						<span class="d_top_left"></span>
						<span class="d_top_right"></span>
						<span class="d_bottom_right"></span>
						<div class="s_mr_20 s_p_10_15 s_f_13" id="overal_rating_box">
							<div class="s_col_70 align_center s_f_24 s_mr_15" id="overal_rating">{$review_sum->rate|number_format:2}</div>
							<div class="s_col_240 s_col_last" id="overal_rating_all">
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.staff}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->staff}%;"></span></span>
								<strong>{$review_sum->staff|number_format:1}</strong>
								<span class="clear"></span>
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.services}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->services}%;"></span></span>
								<strong>{$review_sum->services|number_format:1}</strong>
								<span class="clear"></span>
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.clean}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->clean}%;"></span></span>
								<strong>{$review_sum->clean|number_format:1}</strong>
								<span class="clear"></span>
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.comfort}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->comfort}%;"></span></span>
								<strong>{$review_sum->comfort|number_format:1}</strong>
								<span class="clear"></span>
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.mvalue}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->mvalue}%;"></span></span>
								<strong>{$review_sum->mvalue|number_format:1}</strong>
								<span class="clear"></span>
								<p class="s_col_110 bordo"><strong>{$lang.ad.rating.location}:</strong></p>
								<span class="s_rating left s_mr_10"><span style="width: {math equation="x*10" x=$review_sum->mvalue}%;"></span></span>
								<strong>{$review_sum->location|number_format:1}</strong>
							</div>
						</div>
						<div class="left">
							<h3>{$lang.ad.rating.filter.by}:</h3>
							<ul class="s_list_1 s_pt_5">
								<li><a id="rf_" href="javascript:Review.filter('');" class="bordo">{$lang.ad.rating.filter.all}</a></li>
								{foreach from=$rate_group_list item=v}
								<li><a id="rf_{$v}" href="javascript:Review.filter('{$v}');" class="bordo">{$lang.ad.rating.filter.$v}</a></li>
								{/foreach}
							</ul>
						</div>
						<div class="s_pt_50 s_pr_10 right">
                      	<a href="javascript:Review.showForm('post_review_form', 'ReviewAdd');" class="s_button_2 s_button_2_bordo"><span>{$lang.ad.rating.post}</span></a>
                      </div>
						<script type="text/javascript">
						Review.hotel_id = {$data->hotel_id};
						{literal}
						Review.list();
						{/literal}
						</script>
					</div>
					
					<!--rating-post-form-->
					{assign var="stars" value=","|explode:"one,two,three,four,five,six"}
					<div class="s_box_4 s_mb_20 clearfix" id="post_review_form" style="display:none">
						<span class="d_top_left"></span>
						<span class="d_top_right"></span>
						<span class="d_bottom_right"></span>
						<div id="ReviewAddSuccess" style="display:none">
							<p>Вашето мнение за хотела бе изпратено успешно.</p>
							<p>След модерация от страна на администраторите и управителите ще бъде публикувано в портала.</p>
							<p>Благодарим Ви за вниманието</p>
						</div>
						<form class="form_2" id="ReviewAdd">
							<input type="hidden" value="{$lang_id}" name="lang_id" />
							<input type="hidden" value="{$data->hotel_id}" name="hotel_id" />
							<input type="hidden" value="{$smarty.session.user_id|default:0}" name="user_id" />
							<input type="hidden" value="0" id="rate_cr" name="rate" />
							<input type="hidden" value="review" name="module" />
							<input type="hidden" value="add" name="action" />
							
							<div id="review_rules">
								{$lang.ad.rating.info}
							</div>
							<script type="text/javascript">
							{literal}
							
							function setVal(id, v) {
								$('#'+id).val(v);
								$('#'+id+'_cr').removeAttr('class').addClass('current_rating current_rating_'+v);
								$('#rate_cr').val((parseInt($('#st').val())+parseInt($('#se').val())+parseInt($('#cl').val())+parseInt($('#co').val())+parseInt($('#mv').val())+parseInt($('#lo').val()))/6);
							}
							{/literal}
							</script>
							<div class="left">
								<h3 class="s_mb_10">{$lang.ad.rating.select}</h3>
								<div class="s_mr_20 s_p_10_15 s_f_13" id="1overal_rating_box">
									<div class="s_col_240 s_col_last" id="overal_rating_all">
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.staff}:</strong></p>
										<input type="hidden" id="st" name="staff" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="st_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('st', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
										<span class="clear"></span>
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.services}:</strong></p>
										<input type="hidden" id="se" name="services" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="se_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('se', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
										<span class="clear"></span>
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.clean}:</strong></p>
										<input type="hidden" id="cl" name="clean" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="cl_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('cl', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
										<span class="clear"></span>
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.comfort}:</strong></p>
										<input type="hidden" id="co" name="comfort" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="co_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('co', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
										<span class="clear"></span>
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.mvalue}:</strong></p>
										<input type="hidden" id="mv" name="mvalue" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="mv_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('mv', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
										<span class="clear"></span>
										<p class="s_col_110 bordo"><strong>{$lang.ad.rating.location}:</strong></p>
										<input type="hidden" id="lo" name="location" value="0" />
										<ul class="select_rating left">
											<li class="current_rating" id="lo_cr"><span></span></li>
											{foreach from=$stars item=o name=stars}
											<li class="{$o}_stars"><a href="javascript:setVal('lo', {$smarty.foreach.stars.index+1});" title="{$smarty.foreach.stars.index} {$lang.ad.rating.till} {$smarty.foreach.stars.index+1}"><span>{$smarty.foreach.stars.index+1}</span></a></li>
											{/foreach}
										</ul>
									</div>
								</div>
							</div>
						
						
						<div class="left s_pt_15">
							<h3 class="s_mb_5">{$lang.ad.rating.group}</h3>
							{foreach from=$rate_group_list item=v}
							<label for="rg{$v}" style="width:170px"><input name="key" id="rg{$v}" type="radio" class="checkbox" value="{$v}" /> {$lang.ad.rating.filter.$v}</label>
							{/foreach}
							<div class="clear"></div>
							<p class="s_error_message" id="err_key">&nbsp;</p>
							<div class="clear"></div>
						</div>
						<div class="left s_pt_15">
							<h3 class="s_mb_5">{$lang.ad.rating.name}</h3>
							<input type="text" class="s_w_270 text" name="name" />
							<div class="clear"></div>
							<p class="s_error_message" id="err_name">&nbsp;</p>
						</div>
						<div class="left s_mt_15">
							<h3 class="s_mb_5">{$lang.ad.rating.review}</h3>
							<textarea rows="10" class="s_w_630" id="msg" name="content"></textarea>
							<div class="clear"></div>
							<p class="s_error_message" id="err_content">&nbsp;</p>
						</div>
						<div class="left s_mt_15">
							<h3 class="s_mb_5">{$lang.ad.rating.positive}</h3>
							<textarea rows="2" class="s_w_630" id="positive_review" name="positive"></textarea>
							<div class="clear"></div>
							<p class="s_error_message">&nbsp;</p>
						</div>
						<div class="left s_mt_10">
							<h3 class="s_mb_5">{$lang.ad.rating.negative}</h3>
							<textarea rows="2" class="s_w_630" id="negative_review" name="negative"></textarea>
							<div class="clear"></div>
							<p class="s_error_message">&nbsp;</p>
						</div>
						<span class="clear"></span>
						<div class="data_submit_2 clearfix">
							<button type="submit" class="s_button_2 s_button_2_bordo right"><span>{$lang.ad.rating.post}</span></button>
						</div>
						<div class="data_submit_2 clearfix">
							<button type="button" class="s_button_2 s_button_2_bordo right"><span>{$lang.button.cancel}</span></button>
						</div>
					</form>

                  </div>
					<div id="review_list"></div>
				</div>

				<!--reservation-->
				<div id="hotel_reservation" class="s_tab_box">
				-na-
				</div>
				<!--/reservation-->

				<!--gallery-->
				<div id="hotel_gallery_large" class="s_tab_box">
					<div class="gallery_slideshow_holder_1">
						<div class="gallery_slideshow_1">
							<img src="{$base_url}hotel_images/{$data->media_list.0->file}" width="620" nload="" />
						</div>
					</div>
					<div id="thumbnails">
						<script type="text/javascript">
						{literal}
							var changeImage = function(img) {
								$('.gallery_slideshow_1 img').attr('src', img);
							}
						{/literal}
						</script>
						<ul class="thumbs clearfix">
						{foreach from=$data->media_list item=img key=i}
							<li><a class="thumb s_thumb_1" href="javascript:changeImage('{$base_url}hotel_images/{$img->file}');"><img src="{$base_url}hotel_images/60x60/{$img->file}" width="60" height="60" alt="" /></a></li>
						{/foreach}
						</ul>
					</div>
				</div>
				<!--/gallery-->

			</div>
			<!-- end of tab holder -->
			
			</div>
			<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
		</div>
			</div>
			<!-- end of right column -->
			
			
			<span class="clear"></span>
	
		
		</div>
		</div>
		<!-- end of content -->















{*{if $action eq "404"}
	<div class="mainContentLeft" style="background:#fff">
		<div class="ad_view">
			<h1 class="header-catalog" style="margin-left:4px;margin-bottom:4px;background:#fff">Артикула, които се опитвате да отворите не беше намерен</h1>
		</div>
	</div>
{else}
	{assign var="access" value=","|explode:$smarty.session.access}
	{assign var="id" value=$data->product_id}
	{assign var="lang_id" value=1}
	<div class="mainContentLeft" style="background:#fff">
		<div class="ad_view">
			<h1 class="header-catalog" style="margin-left:4px;margin-bottom:4px;background:#fff">{$data->title} / {$data->manifacturer} / {$data->sub_category_name} / {$data->category_name}</h1>
			<div class="ad_up_wrap clearfix">
				<!-- gallery -->
				<div class="gallery_holder">
					<div class="image_holder">
						<a class="thickbox" rel="ad" href="{$base_url}{$data->media_list.0->category|default:"product_images"}/{$data->media_list.0->file|default:"no-add-image-320-225.jpg"}">
							<img id="gallery_front_image" src="{$base_url}{$data->media_list.0->category|default:"product_images"}/300x225/{$data->media_list.0->file|default:"no-add-image-320-225.jpg"}" alt="{$data->media_list.0->title->$lang_id|escape}" />
						</a>
					</div>
					<div class="thumb_holder">
						{foreach from=$data->media_list item=item name=thumb}
							<div class="thumb_item{if $smarty.foreach.thumb.index eq 0} thumb_item_first{/if}">
								<a class="ad_gallery_item" href="{$base_url}{$item->category|default:"product_images"}/300x225/{$item->file|default:"no-add-image-320-225.jpg"}">
									<img src="{$base_url}{$item->category}/{$item->file}" alt="{$item->title->$lang_id|escape}" />
								</a>
							</div>
						{/foreach}
						<div style="display:none">
						{foreach from=$data->media_list item=item name=thumb}
							<div class="thumb_item{if $smarty.foreach.thumb.index eq 0} thumb_item_first{/if}">
								<a class="thickbox" rel="ad" href="{$base_url}{$item->category}/{$item->file}" onclick="return false">
									<img src="{$base_url}{$item->category}/{$item->file}" alt="{$data->description|escape}" />
								</a>
							</div>
						{/foreach}
						</div>
					</div>

				</div>
				<!-- end of gallery -->
				
				<!-- info -->
				<div class="info_holder" style="margin-top:4px;width:640px;padding-left:0;background: transparent url(/images/test.png) top left no-repeat">
					<div style="padding-left:10px;width:260px;height:230px;float:left">
						<p><strong style="margin:0px;padding:0px">Категория:</strong> {$data->category_name}</p>
						{if $data->sub_category_name ne ''}
							<p><strong >Подкатегория:</strong> {$data->sub_category_name}</p>
						{/if}
						<p><strong>Производител:</strong> {$data->manifacturer}</p>
						{if $data->number ne ''}<p><strong >Каталожен номер:</strong> {$data->number}</p>{/if}
						<p><strong>Цена:</strong> {$data->price} лв.</p>
						<ul>
							<li><a href="{$base_url}card/add/{$id}"><span class="p_button p_basket">Добави в кошницата</span></a></li>
							<li><a title="Запитване" href="{$base_url}item/request/{$id}/?width=600&amp;height=400&amp;KeepThis=true&amp;TB_iframe=true" class="thickbox"><span class="p_button p_newsletter">Направи запитване</span></a></li>
							<li><a href="{$base_url}comment_add/{$id}/?TB_iframe=true&amp;height=440&amp;width=540" title="Коментар" class="thickbox"><span class="p_button p_comment">Добави коментар</span></a></li>
					</ul>
					</div>
						<div style="width:360px;float:left">
							{foreach from=$data->brand_list item=item key=key}
							{if $data->model_list.$key|@sizeof > 0}
							<div style="background:transparent url(/images/test.png) top left no-repeat;float:left;margin:2px;margin-top:0;padding-left:2px;padding-top:0">
								<h2 style="margin-top:2px;margin-left:2px">{$item}</h2>
								<div>
								{foreach from=$data->model_list.$key item=sub key=key}
									{if $key|in_array:$data->model}{$sub}{/if}
								{/foreach}
								</div>
							{/if}
							</div>
							{/foreach}
						</div>
						
					</div>
					<span class="clearfix"></span>
					
					
				</div>
				<!-- end of info -->
				
			</div>
			
			<div class="ad_down_wrap" style="padding-top:8px;width:970px">
				<!-- description -->
				<div style="width:560px;float:left;background:transparent url(/images/test.png) top left no-repeat">
					<div class="description_hold clearfix" style="margin-left:4px">
						<h2>Описание на продукта</h2>
						<div id="description_wrap">
							{$data->description}
						</div>
					</div>
				</div>
				<!-- end of description -->
				
				<!-- comment -->
				<div style="padding-bottom:4px;width:360px;float:left;background:transparent url(/images/test.png) top left no-repeat">
					<div class="description_hold clearfix" style="margin-left:4px">
						<h2>Коментари</h2>
						<div class="clearfix">
						{foreach from=$comment_list item=item}
							<div class="{cycle values="odd,even"}">
								<div style="width:120px;float:left;padding-right:8px">
									<p style="text-align:right">{$item->name}</p>
									<p style="text-align:right;font-size:10px">{$item->created}</p>
									<p><a href="{$base_url}comment/reject/{$item->id}">remove</a></p>
								</div>
								<div style="width:200px;float:left">
									<p>{$item->content}</p>
								</div>
							</div>
						{foreachelse}
							<p>До момента няма публикувани коментари</p>
						{/foreach}
						</div>
					</div>
				</div>
				<!-- end of comment -->
				<br clear="all" />
				<span class="clearfix"></span>
			</div>
		</div>
	</div>
{/if}
*}