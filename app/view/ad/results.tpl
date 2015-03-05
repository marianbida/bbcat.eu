{assign var="access" value=","|explode:$smarty.session.access}
<div class="listing">
	{foreach from=$list item=item}
		<div class="listed_item odd">
			<h3><a href="{$base_url}item/view/{$item->product_id}/{$item->title|title2key}">{$item->title}</a></h3>
			<table>
			<tr>
				<td>
					<a href="{$base_url}item/view/{$item->product_id}/{$item->title|title2key}" class="thumb">
						<img src="{$base_url}product_images/60x45/{$item->image|default:"no-ad-image-60-45.jpg"}" alt="{$item->image_alt|escape}" style="border:2px solid #BFCDE8" />
					</a>
				</td>
				<td width="420" valign="top">
					{if $item->number}<p><strong>Номер</strong>: {$item->number}</p>{/if}
					<p><strong>Производител</strong>: {$item->manifacturer}</p>
					<p class="p_desc">{$item->description|strip_tags|truncate:50}</p>
					<ul class="item_option">
						<li><a href="{$base_url}item/view/{$item->product_id}/{$item->title|title2key}"><span class="p_button p_detail">Прегледай</span></a></li>
						<li><a href="{$base_url}card/add/{$item->product_id}"><span class="p_button p_basket">Добави в кошницата</span></a></li>
						<li><a class="thickbox" title="Коментар" href="{$base_url}comment_add/{$item->product_id}/?TB_iframe=true&amp;height=240&amp;width=480"><span class="p_button p_comment">Добави коментар</span></a>
						</li>
						{* <li><a href="javascript:;"><span class="p_button p_newsletter">бюлетин</span></a></li>*}
					</ul>
				</td>
				<td width="160">
					<p>
						<strong>Цена:</strong>
						{if $item->price eq '0.00'}
							n/a
						{else}
							{if $item->promo_price gt 0}
								<del>{$item->price}</del> лв. {$item->promo_price} лв.
							{else}
								{$item->price} лв.
							{/if}
						{/if}
					</p>
				</td>
				<td width="10"></td>
			</tr>
			</table>
		</div>
	{foreachelse}
	{/foreach}
</div>