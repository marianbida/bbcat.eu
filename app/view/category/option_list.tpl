<option value=""{if $smarty.session.cid eq ''} selected="selected"{/if}>- Всички категории</option>
{foreach from=$category_list item=item}
{if $category_parent == 0}
	{if $item->category_parent == 0}
	<option
		value="{$item->category_id}"
		{if $item->category_id eq $current_category_id} selected="selected"{/if}
	>{$item->title}</option>
	{/if}
{else}
	<option
		value="{$item->category_id}"
		{if $item->category_id eq $current_category_id} selected="selected"{/if}
	>{$item->title}</option>
{/if}
{/foreach}