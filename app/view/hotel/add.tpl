	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<div id="intro_listing" class="s_mb_10 s_p_0_10">
				<img src="{$image_url}images/city_varna.jpg" />
			</div>
			<span class="clear"></span>
			<!-- left column -->
			<div class="s_mt_70 s_pl_10 s_col_320">
				{include file="search/search_inner.tpl"}
			</div>
			<!--/ left column -->

			<!-- right column -->
			<div class="s_col_630">
				<div class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<div class="s_box_1_content clear">
						<h2>{$lang.ad.ad_header}</h2>
						<div style="float:left;width:380px">
							<form action="{$full_url}hotel/add" method="post" class="form_2 s_p_10">
							<div class="form_row_2 clearfix">
								<label for="name">{$lang.ad.name}:</label>
								<input class="text" type="text" name="name" id="name" value="{$smarty.post.name|escape}" />
								{if $err.name}
									<p>Моля, въведете име на хотела</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="chain">{$lang.ad.chain}:</label>
								<input type="text" name="chain" id="chain" value="{$data->chain|escape}" class="text" />
								{if $err.chain}
									<p>Моля, въведете име на хотелска верига</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="type">Тип:</label>
								<input type="text" name="type" id="type" value="{$data->type|escape}" class="text" />
								{if $err.type}
									<p>Моля, изберете тип на хотела</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="country">Страна:</label>
								<select name="country_id" id="country_id">
								{foreach from=$country_list item=item}
								<option value="{$item->country_id}"{if $data->country_id eq $item->country_id} selected="selected"{/if}>&nbsp;{$item->name}</option>
								{/foreach}
								</select>
								{if $err.country}
									<p>Моля, изберете страна</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="region">Област:</label>
								<input type="text" name="region" id="region" value="{$data->region|escape}" class="text" />
								{if $err.region}
									<p>Моля, изберете област</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="street">Улица:</label>
								<input type="text" name="street" id="street" value="{$data->street|escape}" class="text" />
								{if $err.street}
									<p>Моля, въведете адрес</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="zip">Пощенски код и Град:</label>
								<input type="text" name="zip" id="zip" value="{$data->zip|escape}" class="text" />
								<input type="text" name="city" id="city" value="{$data->city|escape}" class="text" />
								{if $err.city}
									<p>Моля, въведете пощенски код и град</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="phone">Телефон:</label>
								<input class="text" type="text" name="phone" id="phone" value="{$data->phone|escape}" />
								{if $err.phone}
									<p>Моля, въведете телефон</p>
								{/if}
							</div>
							<div class="form_row_2 clearfix">
								<label for="fax">Факс:</label>
								<input class="text" type="text" name="fax" id="fax" value="{$data->fax|escape}" />
								{if $err.fax}
									<p>Моля, въведете факс</p>
								{/if}
							</div>
							<div class="clearfix" style="padding-left:173px">
								<span class="s_button_p_button_1 p_submit">
									<span class="p_button_inner">
										<button type="submit" class="p_button_1 p_submit">{$lang.button.save_and_continue}</button>
									</span>
								</span>
							</div>
							</form>
						</div>
						<div style="float:left;width:220px">
							<p>Моля, попълнете всички полета маркирани с "*" и натиснете бутона "Запази и Продължи"</p>
							<!-- Please fill out the following information, then press 'save and continue'. -->
							<p>Вашата заявка за регистрация ще бъде разгледана от администратор.</p>
							<p>След одобряване, Вие ще получите email със статуса на заявката и след одобряване ще имате възможност да променяте разширените параметри на хотела.</p>
						</div>
					</div>
				<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
			</div>
		</div>
		<!-- end of right column -->
		<span class="clear"></span>
	</div>
</div>
<!--/ content -->