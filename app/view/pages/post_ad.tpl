<div id="content">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" style="background:#fff">
			<div class="left_1">
			{include file="common/telephones.tpl"}
			{include file="common/extra_links.tpl"}
			</div>
		</td>
		<td valign="top">
			<div class="right_1 contacts">
				<div class="contact_form mon">
				<fieldset style="width:600px">
					<legend>{$lang.ads.post_ad}</legend>
					{if $smarty.session.step == '01'}
						{$lang.ads.ad_published}
					{else}
						<div class="opt">
						<form
							action="{$base_url}?view=post_ad&lang_id={$lang_id}&action=post_ad" 
							method="post" 
							enctype="multipart/form-data">
							<p>Публикувайте имот в сайта</p>
							<p>Моля пополнете формата</p>
							
							<div>
								<label for="cat_id">{$lang.ads.category}</label>
								<select name="cat_id" id="cat_id">
								{foreach from=$category_list item=category}
								<option value="{$category->id}"{if $category->id eq $smarty.post.cat_id} selected="selected"{/if}>{$category->name}</option>
								{/foreach}
								</select>
								<span class="error">{$smarty.session.err.cat_id}</span>
							</div>
							<div>
								<label>{$lang.ads.ad_purpose}</label>
								<select name="purpose" id="purpose">
								{foreach from=$lang.ads.purpose item=purpose key=key}
								<option value="{$key}"{if $key == $smarty.post.purpose} selected="selected"{/if}>{$purpose}</option>
								{/foreach}
								</select>
								<span class="error">{$smarty.session.err.purpose}</span>
							</div>
							<div>
								<label>{$lang.ads.country}</label>
								<select name="country_id" id="country" onchange="city.load_region_list(this.value);">
								{foreach from=$country_list item=country key=key}
									<option value="{$country->id}"{if $country->id eq $smarty.post.country_id} selected="selected"{/if}>{$country->title.1}</option>
								{/foreach}
								</select>
								<span class="error">{$smarty.session.err.country}</span>
							</div>
							<div>
								<label>{$lang.ads.region}</label>
								<select name="region_id" id="region_list" onchange="load_front_town_list(this.value)">
									<option value="0">{$lang.button.select}</option>
									{foreach from=$region_list item=region key=key}
									<option value="{$region->id}"{if $region->id eq $smarty.post.region_id} selected="selected"{/if}>{$region->name.1}</option>
									{/foreach}
								</select>
								<span class="error">{$smarty.session.err.region}</span>
							</div>
							<div>
								<label>{$lang.ads.town}</label>
								<select name="town_id" id="city_list">
									<option value="">{$lang.button.select}</option>
									{foreach from=$city_list item=town key=key}
									<option value="{$town->id}"{if $town->id eq $smarty.post.town_id} selected="selected"{/if}>{$town->name.1}</option>
									{/foreach}
									<span class="error">{$smarty.session.err.town}</span>
								</select>
							</div>
							<div>
								<label>{$lang.ads.rooms}</label>
								<input type="text" name="rooms" value="{$smarty.post.rooms|escape}" />
							</div>
							<div>
								<label>{$lang.ads.space}</label>
								<input type="text" name="space" value="{$smarty.post.space}" />
							</div>
							<div>
								<label>{$lang.ads.garden_size}</label>
								<input type="text" name="garden_size" value="{$smarty.post.garden_size}" />
							</div>
							<div>
								<label>{$lang.ads.price} / EUR /</label>
								<input type="text" name="price" value="{$smarty.post.price}" />
								<span class="error">{$smarty.session.err.price}</span>
							</div>
							<div>
								<label>{$lang.ads.price_sqm} / EUR /</label>
								<input type="text" name="price_sqm" value="{$smarty.post.price_sqm}" />
							</div>
							<span class="clear"></span>
							<fieldset style="padding:8px">
								<legend>{$lang.ads.amenities}</legend>
								<ul class="post_ad_amenities">
									<li><input type="checkbox" name="garden" id="garden" value="1" {if $smarty.post.garden eq 1}checked="checked"{/if} /><label for="garden">{$lang.ads.garden}</label></li>
									<li><input type="checkbox" name="lift" id="lift" value="1" {if $smarty.post.lift eq 1}checked="cheked"{/if} /><label for="lift">{$lang.ads.lift}</label></li>
									<li><input type="checkbox" name="regulation" id="regulation" value="1" {if $smarty.post.regulation eq 1}checked="cheked"{/if} /><label for="regulation">{$lang.ads.regulation}</label></li>
									<li><input type="checkbox" name="terrace" id="terrace" {if $smarty.post.terrace eq 1}checked="cheked"{/if} value="1" /><label for="terrace">{$lang.ads.terrace}</label></li>
								</ul>
							</fieldset>
							<fieldset>
								<legend>{$lang.ads.title}</legend>
									{include file="common/tabulation.tpl" prefix="title" style="margin:0 4px 0px 4px;background:#ccc;padding-bottom:0"}
									{foreach from=$lang_list item=item}
									{assign var="lang_id" value=$item->id}
									<div style="margin: 0 4px 4px 4px;background:#ccc;height:30px" id="title_{$item->id}">
										<input type="text" style="width:554px" name="title[{$lang_id}]" value="{$smarty.post.title.$lang_id|escape}" maxchar="255" />
									</div>
									{/foreach}
									<span class="error">{$smarty.session.err.title}</span>
								
							</fieldset>
							<fieldset id="content_hold">
								<legend>{$lang.ads.description}</legend>
								{include
									file="common/tabulation.tpl" 
									prefix="description" 
									style="margin:0 4px 0px 4px;background:#ccc;padding-bottom:0"}
								
									{foreach from=$lang_list item=l}
									{assign var="l_id" value=$l->id}
									<div style="margin: 0 4px 4px 4px;background:#ccc;height:210px" id="description_{$l_id}">
										<textarea style="width:554px" name="description[{$l_id}]" id="content{$l->id}">{$smarty.post.description.$l_id|escape}</textarea>
									</div>
									{/foreach}
									<span class="error">{$smarty.session.err.description}</span>
							</fieldset>
							<fieldset id="image_hold">
								<legend>{$lang.ads.images}</legend>
								<div>
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
									<input type="file" name="media[]" style="width:540px" />
								</div>
							</fieldset>
					
							<div class="clear">
								<label for="name">{$lang.contact.your_name}:<sup class="red">*</sup></label>
								<input type="text" name="name" id="name" value="{$smarty.post.name|escape}" />
								<span class="error">{$smarty.session.err.name}</span>
							</div>
							<div class="clear">
								<label for="email">{$lang.contact.email}:<sup class="red">*</sup></label>
								<input type="text" name="email" id="email" value="{$smarty.post.email|escape}" />
								<span class="error">{$smarty.session.err.email}</span>
							</div>
							<div class="clear">
								<label for="msg">{$lang.contact.msg}:</label>
								<textarea name="msg" id="msg">{$smarty.post.msg}</textarea>
								<span class="error">{$smarty.session.err.msg}</span>
							</div>
							<div class="clear">
								<label for="code">{$lang.inquiry.code}:<sup class="red">*</sup></label>
								<input type="text" name="code" id="code" value="{$smarty.post.code|escape}" />
								<span class="error">{$smarty.session.err.code}</span>
							</div>
							<div class="clear" style="line-height:30px">
								<label for="code">&nbsp;</label>
								<img id="captcha" src="{$base_url}captcha.jpg" alt="-code-" />
								<a href="javascript:media.setImage('captcha','{$base_url}captcha.jpg');">{$lang.captcha.reload_image}</a>
							</div>
							<div class="clear">
								<label>&nbsp;</label>
								<button type="submit">{$lang.button.send}</button>
								<button type="reset">{$lang.button.reset}</button>
							</div>
						</form>
					{/if}
				</fieldset>
			</div>
		</td>
	</tr>
	</table>
</div>
<!-- end of content -->