<option value=""{if $current_category_id eq ''} selected="selected"{/if}>- Всички категории</option>
{foreach from=$category_list item=item}
{if $item->category_parent != 0}
	{if $current_category_id}
		{if $current_category_id eq $item->category_parent}
			<option value="{$item->category_id}"{if $item->category_id eq $current_sub_category_id} selected="selected"{/if}>{$item->title}</option>
		{/if}
	{else}
		<option value="{$item->category_id}"{if $item->category_id eq $current_sub_category_id} selected="selected"{/if}>{$item->title}</option>
	{/if}
{/if}
{/foreach}