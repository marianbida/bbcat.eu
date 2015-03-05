<h2 class="p_h_search">Search Hotels</h2>
<form action="{$base_url}" method="get" class="s_form s_form_1">
<div class="clearfix">
	<label>Destination <sup class="destination_info">i</sup></label>
	<input type="text" id="tiny_destination" name="destination" value="{$destination|escape}" />
</div>
<div class="clearfix">
	<div style="width:100px;float:left">
		<label>Check-in Date</label>
		<select id="tiny_check_in_day" name="check_in_day">
			<option value="">- Изберете</option>
		</select>
		<select id="tiny_check_in_month" name="check_in_month">
			<option value="">- Изберете</option>
		</select>
	</div>
	<div style="width:100px;float:left">
		<label>Check-out Date</label>
		<select id="tiny_check_out_day" name="check_out_day">
			<option value="">- Изберете</option>
		</select>
		<select id="tiny_check_out_month" name="check_out_month">
			<option value="">- Изберете</option>
		</select>
	</div>
</div>
<div class="clearfix">
	<label for="tiny_promo" style="margin:4px">
		<input type="checkbox" id="tiny_promo" name="no_date" value="1" /> I don't have specific dates yet
	</label>
</div>
<div class="p_data_submit_new clearfix" style="margin-left:4px;margin-top:4px">
	<span class="button_1" style="width:100px">
		<span class="btn_lbg">
			<span class="btn_rbg">
				<button type="submit">{$lang.button.search}</button>
			</span>
		</span>
	</span>
</div>
</form>