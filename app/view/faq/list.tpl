{foreach from=$list item=item}
{assign var="url" value="`$base_url`faq/view/`$item->faq_id`"}
{if $item->title != ''}
<tr>
	<td>
		<h3 class="news_title"><a href="{$url}">{$item->title}</a></h3>
		<a href="{$url}"><img width="186" src="{$base_url}news_images/{$item->news_image}" border="0" style="float:left; padding-right:10px;border-left:2px solid #F8DA6A" /></a>{$item->content|truncate:300}<br />
		<a href="{$url}">подробно...</a>
		<div style="clear:both; height:1px"></div>
		<div class="news_date">{$item->news_date}</div>
	</td>
</tr>
{/if}
{/foreach}