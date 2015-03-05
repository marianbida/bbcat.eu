{foreach from=$item_list item=item}
<tr class="{cycle values="odd,KT_even"}">
	<td>
		<div style="width:140px; display:compact; float:left; text-align:left;">{$item->product_descr}</div>
	</td>
	<td>
		<div style="width:100px; display:compact; float:left; text-align:left;">{$item->nomer01}</div>
	</td>
	<td>
		<div style="width:100px; display:compact; float:left; text-align:left;">{$item->nomer02}</div>
	</td>
	<td>
		<div style="width:100px; display:compact; float:left; text-align:left;">{$item->nomer03}</div>
	</td>
	<td>
		<div style="width:100px; display:compact; float:left; text-align:left;">{$item->razmeri}</div>
	</td>
	<td>{$item->product_price}</td>
	<td><a href="{$item->url}" onclick="{$item->click}" target="_blank"><img src="{$item->img_src}" border="0" /></a>
	{if $item->product_promo == 1}
		<br /><span style="color:red">ПРОМОЦИЯ</span>
	{/if}
	</td>
</tr>
{foreachelse}
	<p>Категорията е празна или Вашите заявки към филтъра са твърде ограничаващи.</p>
{/foreach}