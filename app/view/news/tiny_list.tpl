{foreach from=$news_list item=item}
{if $item->title != ''}
<div class="first-page-news">
	<a href="{$base_url}news/view/{$item->news_id}">
	<span>{$item->title}</span>
	<img style="border:1px solid #ABA474;margin-right:3px" src="{$base_url}news_images/{$item->news_image}" width="70" align="left" alt=" " />
	<p style="color:#ABA474;text-indent:0;margin-left:4px">{$item->content|strip_tags|truncate:100}</p>
	</a>
</div>
{/if}
{/foreach}