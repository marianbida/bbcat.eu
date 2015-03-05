{foreach from=$news_list item=item}
<div class="first-page-news" style="display:block;clear:both">
	{if $mode == 'new'}
		<a href="{$base_url}d_newsc.php?news_c={$item->news_id}">
		<span>{$item->news_title}</span>
		<img src="{$base_url}news_images/{$item->news_image}" width="70" align="left" alt=" " />
		<p style="text-indent:0;margin-left:4px">{$item->news_long_text|truncate:100}</p>
		</a>
	{else}
		<a href="{$base_url}d_newsc.php?news_c={$item->news_id}">
		<span>{$item->news_title}</span>
		<br />
		{$item->news_long_text|truncate:100}
		</a>
	{/if}
</div>
{/foreach}