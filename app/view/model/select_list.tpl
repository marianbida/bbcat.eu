<option value="">- Изберете модел</option>
{foreach from=$list item=item}
	<option value="{$item->model_id}">{$item->model_name}</option>
{/foreach}