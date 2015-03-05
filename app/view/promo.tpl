<div style="padding-bottom:2px;border: 1px solid #fff;background:#fff">
	<table border="0" cellspacing="0">
	<tr>
		<td valign="top">
		<!-- left -->
		<div class="p_search p_search_tiny">
			<div class="p_inner">
				{include file="ad/search/tiny_form.tpl"}
				<ul class="p_faq_tiny">
					<li><a href="{$base_url}faq">Условия за ползване</a></li>
					<li><a href="{$base_url}faq">Начин на плащане</a></li>
					<li><a href="{$base_url}faq">Гаранция</a></li>
					<li><a href="{$base_url}aboutus">Контакти</a></li>
				</ul>
			</div>
		</div>
		<!-- end of left -->
		</td>
		
		<td valign="top">
		<!-- center -->
		<div class="p_center">
			<h2 style="margin-left:2px">{$meta->page_title}</h2>
			<div style="margin:4px">
			{$meta->page_content}
			</div>
			<div class="margin_1 clearfix front_list">
				<h2>Промоции</h2>
				{include file="ad/front_promo_list.tpl" list=$promo_list}
			</div>
		</div>
		<!-- end of center -->
		</td>

		<td>
		<!-- right -->
		<div class="p_right">
			{include file="card/tiny_render.tpl"}
			{include file="newsletter/tiny_render.tpl"}
			{include file="social/tiny_render.tpl"}
			{include file="facebook/tiny_render.tpl"}
			<div class="padding_2" style="background:#fff;border-top:1px solid #DBE3EC">
				{include file="poll/tiny_render.tpl" data=$current_poll}
			</div>
		</div>
		</td>
	</tr>
	</table>
</div>