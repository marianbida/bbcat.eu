<form action="{$base_url}" method="get" id="search_form">
	<input type="hidden" name="req" value="pro" />
	<input type="hidden" name="order_by" id="search_order_by" value="{$smarty.get.order_by|default:"price"}" />
	<input type="hidden" name="order_vector" id="search_order_vector" value="{$smarty.get.order_vector|default:"asc"}" />
	<div class="clearfix" style="height:70px">
		<label for="description">Въведете номер, описание, размери и др.</label>
		<input style="padding:4px;border:1px solid #e2e2e2;width:580px" name="description" id="description" value="{$smarty.get.description|escape}" />
		<p style="height:8px;margin-left:0;text-indent:0">въведете клучова дума напр. "ксенон"</p>
	</div>
	<div class="clearfix">
		<span class="margin_2">
			<select name="brand_id" id="search_brand" style="padding:2px;width:180px;border:1px solid #E2E2E2">
				<option value="">- Всички марки</option>
				{foreach from=$brand_list item=item}
					<option value="{$item->truck_id}"{if $current_brand_id eq $item->truck_id} selected="selected"{/if}>&nbsp;{$item->truck_name}</option>
				{/foreach}
			</select>
		</span>
		<span class="margin_2">
			
			<select name="model_id" id="search_model" style="padding:2px;width:280px;border:1px solid #E2E2E2">
				<option value="">- Всички модели</option>
				{foreach from=$model_list item=item}
				<option value="{$item->model_id}"{if $current_model_id eq $item->model_id} selected="selected"{/if}>&nbsp;{$item->model_name}</option>
				{/foreach}
			</select>
		</span>
	</div>
	<div class="clearfix" style="margin-top:6px">
		<span class="margin_2">
			
			<select id="search_mod" name="mod_id" style="padding:2px;width:580px;border:1px solid #E2E2E2">
				<option value="">- Всички модификации</option>
				{foreach from=$mod_list item=item}
					<option value="{$item->id}"{if $item->id eq $current_mod_id} selected="selected"{/if}>&nbsp;{$item->name|escape}</option>
				{/foreach}
			</select>
		</span>
	</div>
	<div class="clearfix" style="margin-top:6px">
		<span class="margin_2">
			
			<select name="category_id" id="search_category" style="padding:2px;width:180px;border:1px solid #E2E2E2">
			{include file="category/option_list.tpl" category_parent=0}
			</select>
		</span>
		<span class="margin_2">
			
			<select name="sub_category_id" id="search_sub_category" style="padding:2px;width:180px;border:1px solid #E2E2E2">
			{include file="category/sub_option_list.tpl"}
			</select>
		</span>
		<span class="margin_2">
			
			<select name="manifacturer_id" id="search_manifacturer" style="padding:2px;width:206px;border:1px solid #E2E2E2">
				<option value="">- Всички производители</option>
				{foreach from=$manifacturer_list item=item}
					<option value="{$item->id}"{if $item->id eq $current_manifacturer_id} selected="selected"{/if}>&nbsp;{$item->name|escape}</option>
				{/foreach}
			</select>
		</span>
	</div>
	<div class="clearfix" style="margin-top:6px">
		
	</div>
	<div class="clearfix">
		<label for="promo">
			<input type="checkbox" name="promo" id="promo" value="1" {if $smarty.get.promo eq 1}checked="checked"{/if} /> Промоции
		</label>
	</div>
	<div class="p_data_submit_new clearfix">
		<span class="button_1" style="width:130px">
			<span class="btn_lbg">
				<span class="btn_rbg">
					<button type="submit">{$lang.button.search}</button>
				</span>
			</span>
		</span>
	</div>
</form>
<div id="search_sort">
	<ul id="search_order_set">
		<li><a id="ss_price" {if $smarty.get.order_by eq "price" or $smarty.get.order_by eq ''}class="active"{/if} href="javascript:;">Цена</a></li>
		<li><a id="ss_manifacturer"  {if $smarty.get.order_by eq "manifacturer"}class="active"{/if}  href="javascript:;">Производител</a></li>
		<li><a id="ss_bestbuy"  {if $smarty.get.order_by eq "bestbuy"}class="active"{/if} href="javascript:;">Най-купувано</a></li>
		<li><a id="ss_new" {if $smarty.get.order_by eq "new"}class="active"{/if} href="javascript:;">Най-ново</a></li>
	</ul>
	<ul id="search_order_vector_set">
		<li><a id="ss_asc" {if $smarty.get.order_vector ne "desc"}class="active"{/if} href="javascript:;">Възходящ</a></li>
		<li><a id="ss_desc" {if $smarty.get.order_vector eq "desc"}class="active"{/if} href="javascript:;">Низходящ</a></li>
	</ul>
</div>