<!-- search form -->
<h1>{$lang.search.search}</h1>
<div>
	<form action="{$base_url}" method="get" id="form_search">
	<input type="hidden" name="view" value="property" />
	<input type="hidden" name="mode" value="search" />
	<table>
	<tr>
		<td>
		<div class="search_left">
		<h2>{$lang.search.purpose}</h2>
		<div class="odd" style="padding:4px">
			<input type="checkbox" name="offer[]" id="sale" value="0"{if $smarty.get.offer|@count > 0 and '0'|in_array:$smarty.get.offer} checked="checked"{/if}/>
			<label for="sale">{$lang.search.for_sale}</label>
			<input type="checkbox" name="offer[]" id="rent" value="1"{if $smarty.get.offer|@count > 0 and '1'|in_array:$smarty.get.offer} checked="checked"{/if}/>
			<label for="rent">{$lang.search.for_rent}</label>
			
			<input type="checkbox" name="vip" id="vip" value="1"{if $smarty.get.vip|@count > 0} checked="checked"{/if}/>
			<label for="vip">{$lang.search.vip}</label>
		</div>
		
		<h2>{$lang.search.property_type}</h2>
		<div class="odd" style="padding:4px">
			{foreach from=$category_list item=item}
				<div class="clear">
					<input type="checkbox" name="cat[]" id="cat_{$item->id}" value="{$item->id}"{if $smarty.get.cat|@count > 0 && "`$item->id`"|in_array:$smarty.get.cat} checked="checked"{/if}/>
					<label for="cat_{$item->id}">{$item->name}</label>
				</div>
			{/foreach}
		</div>
	</div>
	</td>
	<td valign="top">
	<div class="search_right">
		<h2>{$lang.search.location}</h2>
		<div class="location odd" style="padding:4px">
			<div>
				<label for="region">{$lang.search.region}</label>
				<select name="region" id="region" onchange="load_front_town_list(this.value)">
					<option value="">{$lang.search.select}</option>
				{foreach from=$region_list item=item}
					<option value="{$item->id}"{if $item->id eq $smarty.get.region} selected="selected"{/if}>{$item->name.$lang_id}</option>
				{/foreach}
				</select>
			</div>
			<div class="city">
				<label for="city_list">{$lang.search.city}</label>
				<select name="city" id="city_list">
				<option value="">{$lang.search.select}</option>
				{foreach from=$city_list item=item}
					<option value="{$item->id}"{if $item->id eq $smarty.get.city} selected="selected"{/if}>{$item->name.$lang_id}</option>
				{/foreach}
				</select>
			</div>
		</div>
		
		<h2>{$lang.search.price_area_etc}</h2>
		<div class="odd" style="padding:4px">
			<table>
			<tr>
				<td width="170"><label for="price_min">{$lang.search.price} {$lang.search.from}</label></td>
				<td><input type="text" name="price_min" id="price_min" value="{$smarty.get.price_min|escape}" /></td><td>{$lang.search.till}</td>
				<td><input type="text" name="price_max" id="price_max" value="{$smarty.get.price_max|escape}" /></td><td>{$lang.search.euro}</td>
			</tr>
			<tr>
				<td><label for="area">{$lang.search.area} {$lang.search.from}</label></td>
				<td><input type="text" id="area" name="area_min" id="area_min" value="{$smarty.get.area_min|escape}" /></td><td>{$lang.search.till}</td>
				<td><input type="text" name="area_max" id="area_max" value="{$smarty.get.area_max|escape}" /></td><td> {$lang.search.sqm}</td>
			</tr>
			</table>
		</div>
	</div>
	</td>
	</tr>
	</table>
	<div class="submit_wrap" style="width:400px;display:block;clear:both">
		<button type="submit">{$lang.search.submit}</button>
		<button type="reset">{$lang.search.reset}</button>
	</div>
	</form>
</div>
<!-- end of search form  -->