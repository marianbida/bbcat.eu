<tr>
	<th><img src="{$base_url}product_images/60x45/{$item->file}" alt=" " /></th>
	<th>{$item->title}</th>
	<th>{$item->price} лв.</th>
	<th>{$item->quantity}</th>
	<th>{math equation="x*y" x=$item->price y=$item->quantity} лв.</th>
</tr>