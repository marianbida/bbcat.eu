<div style="background:#fff">
	{*<!-- left -->
	<div class="leftSideMain">
		{include file="category/left_menu_list.tpl"}
	</div>
	<!-- end of left -->
	*}
	<!-- left -->
	<div class="p_search p_search_tiny">
		<div class="p_inner">
			{include file="ad/search/tiny_form.tpl"}
			<ul class="p_faq_tiny">
				<li><a href="{$base_url}faq#faq_16">Условия за ползване</a></li>
				<li><a href="{$base_url}faq#faq_22">Начин на плащане</a></li>
				<li><a href="{$base_url}faq#faq_22">Гаранция</a></li>
				<li><a href="{$base_url}faq#faq_21">Условия на доставка</a></li>
				<li><a href="{$base_url}aboutus">Контакти</a></li>
			</ul>
		</div>
	</div>
	<!-- end of left -->
	<!-- center -->
	<div class="p_center">
		<h2 style="margin-left:2px">{$meta->page_title}</h2>
		<div style="margin:4px">
		{$meta->page_content}
		</div>
		<div style="padding-left:8px">
			{foreach from=$comment_list item=item}
			<div class="clearfix {cycle values="odd,even"}" style="border-left:2px solid #efefef">
				<div style="width:64px;float:left">
					<a style="margin:2px;margin-top:4px" href="{$base_url}item/view/{$item->item_id}/{$item->description|title2key}">
						<img style="border:2px solid #efefef" src="{$base_url}product_images/60x45/{$item->file|default:"no-ad-image-60-45.jpg"}" />
					</a>
				</div>
				<div style="float:left;width:420px">
					<p>{$item->content}</p>
					<p style="font-size:11px">{$item->name} / {$item->created}</p>
				</div>
			</div>
			{/foreach}
		</div>
	</div>
	<!-- end of center -->
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
	<br clear="all" />
	<span class="clearfix"></span>
</div>