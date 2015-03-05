<option value="">- Изберете модификация</option>
{foreach from=$list item=item}
	<option value="{$item->id}">{$item->name}</option>
{/foreach}