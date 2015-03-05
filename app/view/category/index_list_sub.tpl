{foreach from=$list item=item}
	{assign var="url" value="`$base_url`?req=pro&category_id=`$item->category_parent`&sub_category_id=`$item->category_id`"}
	<div class="products-on-first-page-left">
		<a href="{$url}" title="Към пълния списък с {$item->title} &rsaquo;&rsaquo;"><img src="{$base_url}category_images/{$item->category_image}" alt="{$item->title}" title="Към пълния списък с {$item->category_name} &rsaquo;&rsaquo;" width="222" height="109" border="0" /></a>
		<span><a href="{$url}" title="Към пълния списък с  {$item->title} &rsaquo;&rsaquo;">{$item->title}</a></span>
	</div>
{/foreach}