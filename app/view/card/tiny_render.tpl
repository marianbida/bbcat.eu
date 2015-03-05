<div class="p_basket p_basket_tiny p_back_one">
	<h2 class="p_h_basket">Кошница</h2>
	<p>{if $order->items_total == 0}Вашата кошница е празна{else}Вие имате {$order->items_total} продукт/и{/if}</p>
	<p>Цена: {$order->total} лв.</p>
	<a style="width:120px" class="button_1" href="{$base_url}card/">
		<span class="btn_lbg">
			<span class="btn_rbg">Поръчай сега</span>
		</span>
	</a>
</div>