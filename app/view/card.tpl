<div id="card" style="background:#fff" class="padding_2">
	{if $step eq "history"}
		{include file="card/history_view.tpl"}
	{elseif $step eq "05"}
		{include file="card/order_confirmed.tpl"}
	{elseif $step eq "04"}
		<h1 class="p_h_basket">Поздравления</h1>
		<p>На Вашата електронна поща бе изпратено запитване за потвърждаване на поръчката Ви.</p>
		<p>Моля, отворете пощата си и следвайте инструкции за потвърждение.</p>
		<p>След като потвърдите поръчката си, ние ще преминем към нейното изпълнение.</p>
		<p>Наш служител може допълнително да Ви потърси на оставения телефон, за да уточни доставката.</p>
		
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
				<div class="margin_2 padding_2 width_320">
					<span class="clearfix">Промоционален Код: {$data->discount_code}</span>
					<span class="clearfix">Отстъпка на стойност: {$data->discount_percent} %</span>
				</div>
				<div class="order_pre padding_2 width_320" style="text-align:right">
					<div class="clearfix">
						<div class="p_value">{$data->sub_total} лв.</div>
						<div class="p_key">Стойност:</div>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->discount} лв.</span>
						<span class="p_key">Отстъпка:</span>
					</div>
					<div class="clearfix">
						{if $data->delivery gt 0}
							<span class="p_value">{$data->delivery} лв.</span>
						{else}
							<span class="p_value">Безплатнa</span>
						{/if}
						<span class="p_key">Доставка:</span>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->total} лв.</span>
						<span class="p_key">Обща стойност:</span>
					</div>
				</div>
				
			
			{/if}
		</div>
		<div class="order_preview" style="float:left;width:470px" class="f_left padding_2 margin_2">
			<h2>Лични Данни</h2>
			<div class="clearfix">
				<label>Име:</label>
				<p>{$data->first_name|escape}</p>
			</div>
			<div class="clearfix">
				<label>Фамилия:</label>
				<p>{$data->last_name|escape}</p>
			</div>
			<div class="clearfix">
				<label>Телефон:</label>
				<p>{$data->phone|escape}</p>
			</div>
			<div class="p_form_row_1 clearfix">
				<label>E-mail:</label>
				<p>{$data->email|escape}</p>
			</div>
			<h2>Адрес</h2>
			<div class="clearfix">
				<label>Град:</label>
				<p>
				{foreach from=$city_list item=item}
					{if $item->id eq $data->city_id}{$item->title}{/if}
				{/foreach}
				</p>
			</div>
			<div class="clearfix">
				<label>Адрес:</label>
				<p>{$data->address}</p>
				</span>
			</div>
			<div class="clearfix">
				<label>Пояснения:</label>
				<p>{$data->common}</p>
			</div>
			<h2>Метод на плащане</h2>
			<div class="clearfix">
				<label>Метод:</label>
				<p>
				{if $data->method_of_payment eq "_1"}
					Наложен платеж
				{else}
					Банков Превод
				{/if}
				</p>
			</div>
			{if $data->company_name and $data->company_vat}
				<h2>Данни за фактура</h2>
				<div class="clearfix">
					<label>Име:</label>
					<p>{$data->company_name|escape}</p>
				</div>
				<div class="clearfix">
					<label>ЕИК:</label>
					<p>{$data->company_vat}</p>
				</div>
			{/if}
			<h2>Ежемесечен Бюлетин</h2>
			<div class="clearfix">
				<label>&nbsp;</label>
				<p>
				{if $data->monthly_newsletter eq 'yes'}
					Да, желая да получавам ежемесечен бюлетин
				{else}
					Не, благодаря
				{/if}
				</p>
			</div>
		</div>
		
		
	{elseif $step eq "03"}
		<!-- -->
		<h1 class="p_h_basket">Финализиране на поръчката</h1>
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
				<div class="margin_2 padding_2 width_320">
					<span class="clearfix">Промоционален Код: {$data->discount_code}</span>
					<span class="clearfix">Отстъпка на стойност: {$data->discount_percent} %</span>
				</div>
				<div class="order_pre padding_2 width_320" style="text-align:right">
					<div class="clearfix">
						<div class="p_value">{$data->sub_total} лв.</div>
						<div class="p_key">Стойност:</div>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->discount} лв.</span>
						<span class="p_key">Отстъпка:</span>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->delivery} лв.</span>
						<span class="p_key">Доставка:</span>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->total} лв.</span>
						<span class="p_key">Обща стойност:</span>
					</div>
				</div>
				<div>
					<div class="width_3">
						<a class="button_2" href="{$base_url}card" title="Върни се в кошницата">
							<span class="btn_lbg">
								<span class="btn_rbg">Обратно към Кошницата</span>
							</span>
						</a>
					</div>
					<div class="width_4">
						<a class="button_2" href="{$base_url}card/order" title="Върни се към промяна на личните данни">
							<span class="btn_lbg">
								<span class="btn_rbg">Обратно към Поръчка</span>
							</span>
						</a>
					</div>
				</div>
			{else}
				<p>Вашата кошница е празна</p>
			{/if}
		</div>
		<div class="order_preview" style="float:left;width:470px" class="f_left padding_2 margin_2">
			<h2>Лични Данни</h2>
			<div class="clearfix">
				<label>Име:</label>
				<p>{$data->first_name|escape}</p>
			</div>
			<div class="clearfix">
				<label>Фамилия:</label>
				<p>{$data->last_name|escape}</p>
			</div>
			<div class="clearfix">
				<label>Телефон:</label>
				<p>{$data->phone|escape}</p>
			</div>
			<div class="p_form_row_1 clearfix">
				<label>E-mail:</label>
				<p>{$data->email|escape}</p>
			</div>
			<h2>Адрес</h2>
			<div class="clearfix">
				<label>Град:</label>
				<p>
				{foreach from=$city_list item=item}
					{if $item->id eq $data->city_id}{$item->title}{/if}
				{/foreach}
				</p>
			</div>
			<div class="clearfix">
				<label>Адрес:</label>
				<p>{$data->address}</p>
				</span>
			</div>
			<div class="clearfix">
				<label>Пояснения:</label>
				<p>{$data->common}</p>
			</div>
			<h2>Метод на плащане</h2>
			<div class="clearfix">
				<label>Метод:</label>
				<p>
				{if $data->method_of_payment eq "_1"}
					Наложен платеж
				{else}
					Банков Превод
				{/if}
				</p>
			</div>
			{if $data->company_name and $data->company_vat}
				<h2>Данни за Фактура</h2>
				<div class="clearfix">
					<label>Име:</label>
					<p>{$data->company_name|escape}</p>
				</div>
				<div class="clearfix">
					<label>ЕИК:</label>
					<p>{$data->company_vat}</p>
				</div>
			{/if}
			<h2>Ежемесечен Бюлетин</h2>
			<div class="clearfix">
				<label>&nbsp;</label>
				<p>
				{if $data->monthly_newsletter eq 'yes'}
					Да, желая да получавам ежемесечен бюлетин
				{else}
					Не, Благодаря
				{/if}
				</p>
			</div>
			<div class="width_3">
				<a class="button_2" href="{$base_url}card/send" title="Изпрати за Обработка">
					<span class="btn_lbg">
						<span class="btn_rbg">Изпрати за обработка</span>
					</span>
				</a>
			</div>
		</div>
		<!-- -->
	{elseif $step eq "02"}
		<!-- -->
		<h1 class="p_h_basket">Финализиране на поръчката</h1>
		<div class="width_400 f_left">
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
				<div class="margin_2 padding_2 width_320">
					<span class="clearfix">Промоционален Код: {$data->discount_code}</span>
					<span class="clearfix">Отстъпка на стойност: {$data->discount_percent} %</span>
				</div>
				<div class="order_pre padding_2 width_320" style="text-align:right">
					<div class="clearfix">
						<div class="p_value">{$data->sub_total} лв.</div>
						<div class="p_key">Стойност:</div>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->discount} лв.</span>
						<span class="p_key">Отстъпка:</span>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->delivery} лв.</span>
						<span class="p_key">Доставка:</span>
					</div>
					<div class="clearfix">
						<span class="p_value">{$data->total} лв.</span>
						<span class="p_key">Обща стойност:</span>
					</div>
				</div>
				<div style="padding-left:180px">
					<div class="width_3">
						<a class="button_2" href="{$base_url}card" title="Обратно към Кошницата">
							<span class="btn_lbg">
								<span class="btn_rbg">Обратно към Кошницата</span>
							</span>
						</a>
					</div>
				</div>
			{else}
				<p>Вашата кошница е празна</p>
			{/if}
		</div>
		<div style="width:475px;" class="f_left padding_2 margin_2">
			<form class="p_form p_form_1" action="{$base_url}card/order" method="post">
			<h2>Лични Данни</h2>
			<div class="p_form_row_1 clearfix">
				<label>Име:</label>
				<span class="p_text width_3">
					<input type="text" name="first_name" value="{$data->first_name|escape}" class="p_text" />
				</span>
				<sup class="red">*</sup>
				{if $err.first_name}
					<p class="p_error_message">{$err.first_name}</p>
				{/if}
			</div>
			<div class="p_form_row_1 clearfix">
				<label>Фамилия:</label>
				<span class="p_text width_3">
					<input type="text" name="last_name" value="{$data->last_name|escape}" class="p_text" />
				</span>
				<sup class="red">*</sup>
				{if $err.last_name}
					<p class="p_error_message">{$err.last_name}</p>
				{/if}
			</div>
			<div class="p_form_row_1 clearfix">
				<label>Телефон:</label>
				<span class="p_text width_3">
					<input type="text" name="phone" value="{$data->phone|escape}" class="p_text" />
				</span>
				<sup class="red">*</sup>
				{if $err.phone}
					<p class="p_error_message">{$err.phone}</p>
				{/if}
			</div>
			<div class="p_form_row_1 clearfix">
				<label>E-mail:</label>
				<span class="p_text width_3">
					<input type="text" name="email" value="{$data->email|escape}" class="p_text" />
				</span>
				<sup class="red">*</sup>
				{if $err.email}
					<p class="p_error_message">{$err.email}</p>
				{/if}
			</div>
			<h2>Адрес</h2>
			<div class="p_form_row_1 clearfix">
				<label>Град / Населено място:</label>
				<span>
					<select name="city_id" id="city_id">
						<option value="">- Изберете Град</option>
						{foreach from=$city_list item=item}
						<option value="{$item->id}" {if $data->city_id eq $item->id} selected="selected"{/if}>&nbsp;{$item->title}</option>
						{/foreach}
					</select>
				</span>
				<sup class="red">*</sup>
				{if $err.city}
					<p class="p_error_message">{$err.city}</p>
				{/if}
			</div>
			<div class="p_form_row_1 clearfix">
				<label>Адрес:</label>
				<span class="p_textarea width_4">
					<span class="t_top_right"></span>
					<textarea class="p_textarea" name="address" id="address">{$data->address}</textarea>
					<span class="t_bottom_left"></span>
					<span class="t_bottom_right"></span>
				</span>
				<sup class="red">*</sup>
				{if $err.address}
					<p class="p_error_message">{$err.address}</p>
				{/if}
			</div>
			<div class="p_form_row clearfix">
				<label>Пояснения:</label>
				<span class="p_textarea width_4">
					<span class="t_top_right"></span>
					<textarea name="common" id="common" class="p_textarea">{$data->common}</textarea>
					<span class="t_bottom_left"></span>
					<span class="t_bottom_right"></span>
				</span>
			</div>
			<h2>Метод на плащане</h2>
			<div class="p_form_row_2 clearfix">
				<div class="clearfix">
					<label><input type="radio" name="payment_method" value="_1" {if $data->method_of_paymenty ne "_2"}checked="checked"{/if} /></label>
					<div>
						<p>Наложен платеж</p>
					</div>
				</div>
				<div class="clearfix">
					<label><input type="radio" name="payment_method" value="_2" {if $data->method_of_payment eq "_2"}checked="checked"{/if} /></label>
					<div>
						<p>Банков Превод</p>
					</div>
				</div>
			</div>
			<h2>Данни за Фактура</h2>
			<p>Ако желаете да получите фактура, моля попълнете данните</p>
			<div class="p_form_row clearfix">
				<label>Име:</label>
				<span class="p_text width_3">
					<input type="text" name="company_name" value="{$data->company_name|escape}" class="p_text" />
				</span>
			</div>
			<div class="p_form_row clearfix">
				<label>ЕИК:</label>
				<span class="p_text width_3">
					<input type="text" name="company_vat" value="{$data->company_vat}" class="p_text" />
				</span>
			</div>
			<h2>Ежемесечен Бюлетин</h2>
			<p>Желаете ли да получавате нашия ежемесечен бюлетин, съдържащ специални промоции и отстъпки?</p>
			<div class="p_form_row_2 clearfix">
				<div class="clearfix">
					<label><input type="radio" name="monthly_newsletter" value="yes" {if $data->monthly_newsletter ne "no"}checked="checked"{/if} /></label>
					Да, желая да получавам ежемесечен бюлетин
				</div>
				<div class="clearfix">
					<label><input type="radio" name="monthly_newsletter" value="no" {if $data->monthly_newsletter eq "no"}checked="checked"{/if} /></label>
					Не, Благодаря
				</div>
			</div>
			<div class="p_data_submit_new clearfix" style="margin-left:4px;margin-top:4px">
				<span class="button_1" style="width:285px">
					<span class="btn_lbg">
						<span class="btn_rbg">
							<button type="submit">Финализирай Поръчката</button>
						</span>
					</span>
				</span>
			</div>
			
			</form>
			{if 0 and $data->first_name ne '' and $data->last_name ne '' and $data->email ne ''}
			<div class="width_3">
				<a class="button_2" href="{$base_url}card/process" title="Финализирай поръчката">
					<span class="btn_lbg">
						<span class="btn_rbg">Финализирай Поръчката</span>
					</span>
				</a>
			</div>
			{/if}
		</div>
		<!-- -->
	{else}
		<h1 class="p_h_basket">Кошница</h1>
		
		{if $data->verified lt 1}
			{include file="card/verify_human.tpl"}
		{else}
			{if $data->items|@sizeof gt 0 and $data->items.0->item_id gt 0}
				<form id="card_submit" action="{$base_url}card/update" method="post" class="s_form s_form_1">
					<table class="card_table" style="text-align:left">
					<tr>
						<th colspan="2">Артикул</th>
						<th>Цена</th>
						<th>Брой</th>
						<th>Крайна цена</th>
					</tr>
					
						{foreach from=$data->items item=item}
							{include file="card/item_render.tpl" item=$item}
						{/foreach}
					
					</table>
					<div class="margin_2 padding_2 width_320">
						<label for="coupon_code_text">Промоционален Код: <input type="text" id="coupon_code_text" name="coupon_code" value="{$data->discount_code}" /></label>
						<label>Отстъпка на стойност: {$data->discount_percent} %</label>
						{if $smarty.session.err.msg eq "can_not_use"}
						{/if}
					</div>
					<div class="padding_2 width_320" style="text-align:right">
						<span>Стойност: {$data->sub_total} лв.</span><br />
						<span>Отстъпка: {$data->discount} лв.</span><br />
						<span>Обща стойност: {$data->total} лв.</span>
					</div>
					<div class="p_data_submit_new clearfix" style="margin-left:4px;margin-top:4px">
						<span class="button_1" style="width:185px">
							<span class="btn_lbg">
								<span class="btn_rbg">
									<button type="submit">Прекалкулация</button>
								</span>
							</span>
						</span>
					</div>
				</form>
				<div class="margin_2 padding_2 width_320">
					<a class="button_2" href="{$base_url}card/order" title="Финализирай поръчката">
						<span class="btn_lbg">
							<span class="btn_rbg">Финализиране на поръчката</span>
						</span>
					</a>
				</div>
			{else}
				<p>Вашата кошница е празна</p>
			{/if}
		{/if}
	{/if}
	<span class="clearfix"></span>
</div>