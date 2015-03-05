<html>
<body>
	<div>
		<h1>Поздравления</h1>
		<p>Вие получавате това писмо от сайта VilexAuto.com</p>
		<p>За да потвърдите поръчката си моля последвайте линка за потвърждение или копирайте адреса и го отворете през браузъра си.</p>
		<p>Линк за потвърждение: <a href="{$base_url}card/confirm/{$data->id}">ТУК</a></p>
		<p>Адрес за потвърждение: "<strong>{$base_url}card/confirm/{$data->id}</strong>"</p>
		
		<h2>Детайли на поръчката</h2>
		<div class="order_preview order_preview_left">
			<h2>Артикули</h2>
			{if $data->items|@sizeof gt 0}
				<table class="card_table" style="text-align:left">
				<tr>
					<th colspan="2">Артикул</th>
					<th>Цена</th>
					<th>Брой</th>
					<th>Крайна цена</th>
				</tr>
				{foreach from=$data->items item=item}
					{include file="card/item_render_static.tpl" item=$item}
				{/foreach}
				</table>
				<table>
				<tr>
					<td>Промоционален Код:</td>
					<td>{$data->discount_code}</td>
				</tr>
				<tr>
					<td>Отстъпка на стойност:</td>
					<td>{$data->discount_percent} %</td>
				</tr>
				<tr>
					<td>Стойност:</td>
					<td>{$data->sub_total} лв.</td>
				</tr>
				<tr>
					<td>Отстъпка:</td>
					<td>{$data->discount} лв.</td>
				</tr>
				<tr>
					<td>Доставка:</td>
					<td>
						{if $data->delivery gt 0}
							{$data->delivery} лв.
						{else}
							Безплатнa
						{/if}
					</td>
				</tr>
				<tr>
					<td>Обща стойност:</td>
					<td>{$data->total} лв.</td>
				</tr>
				</table>
			{/if}
		</div>
		<div class="order_preview" style="float:left;width:470px" class="f_left padding_2 margin_2">
			<h2>Лични Данни</h2>
			<table>
			<tr>
				<td>Име:</td>
				<td>{$data->first_name|escape}</td>
			</tr>
			<tr>
				<td>Фамилия:</td>
				<td>{$data->last_name|escape}</td>
			</tr>
			<tr>
				<td>Телефон:</td>
				<td>{$data->phone|escape}</td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td>{$data->email|escape}</td>
			</tr>
			<tr>
				<td>Град:</td>
				<td>
				{foreach from=$city_list item=item}
					{if $item->id eq $data->city_id}{$item->title}{/if}
				{/foreach}
				</td>
			</tr>
			<tr>
				<td>Адрес:</td>
				<td>{$data->address}</td>
			</tr>
			<tr>
				<td>Пояснения:</td>
				<td>{$data->common}</td>
			</tr>
			<tr>
				<td>Метод на плащане:</td>
				<td>
				{if $data->method_of_paymenty eq "_1"}
					Наложен платеж
				{else}
					Банков Превод
				{/if}
				</td>
			</tr>
			{if $data->company_name and $data->company_vat}
			<tr>
				<td>Фактура на Име(компания):</td>
				<td>{$data->company_name|escape}</td>
			</tr>
			<tr>
				<td>ЕИК:</td>
				<td>{$data->company_vat}</td>
			</tr>
			{/if}
			<tr>
				<td>Ежемесечен Бюлетин:</td>
				<td>
				{if $data->monthly_newsletter eq 'yes'}
					Да, желая да получавам ежемесечен бюлетин
				{else}
					Не, Благодаря
				{/if}
				</td>
			</tr>
			</table>
		</div>
	</div>
</body>
</html>