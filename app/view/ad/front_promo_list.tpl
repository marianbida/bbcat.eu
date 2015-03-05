{foreach from=$list item=item}
	{assign var="id" value=$item->product_id}
	{assign var="title" value=$item->title|title2key}
	<div>
		<h3>{$item->title}</h3>
		<span class="thumb">
			<a href="{$base_url}item/view/{$id}/{$title}" title="">
				<img src="{$base_url}product_images/120x90/{$item->image|default:"no-ad-image-120-90.jpg"}" alt="{$item->image_title|escape}" width="120" height="90" border="0" />
			</a>
		</span>
		<br clear="all" />
		<p class="p_desc">{$item->description|strip_tags|truncate:30}</p>
		<p class="p_price">
		{if $item->promo_price gt 0}
			<i style="text-decoration:line-through">{$item->price}</i> {$item->promo_price} 
		{else}
			{$item->price}
		{/if} лв.
		</p>
		<ul class="options">
			<li><a href="{$base_url}card/add/{$id}"><span class="p_button p_basket"></span></a></li>
			<li><a href="{$base_url}item/view/{$id}/{$title}"><span class="p_button p_detail"></span></a></li>
		</ul>
	</div>
{/foreach}
