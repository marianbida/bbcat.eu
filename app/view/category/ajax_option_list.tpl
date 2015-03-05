<option value="">- Изберете подкатегория</option>
{foreach from=$list item=item}
<option value="{$item->category_id}">{$item->title}</option>
{/foreach}