	<!-- content -->
	<div style="margin-top:10px" id="wrap">
                <h1>{$lang.pub.head}</h1>
		<a href="{$base_url}" title="begin">{$lang.publ.href_begin}</a>
		<p><strong>{$lang.publ.publish}</strong></p>

		{if $step eq '01'}
			<p>{$lang.publ.m.pub_sucsess}</p>
		{else}
			{if $step eq '02'}
				<p class="error">{$lang.publ.m.pub_no_sucsess}</p>
			{else}
				<table id="publish" style="width:100%;height:100%">
					<tr>
						<td width="32%">
							<form action="{$base_url}publish" method="post">
							<h2>{$lang.publ.deteils}</h2>
							<p>{$lang.publ.web_address}</p>
							<input type="text" name="address" style="width:300px" value="{$smarty.post.address|escape|default:$lang.publ.def_for_address}"/>
							{if $err.address}
								<p class="error">{$err.address}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_addr}</p>
                                                        <p><select name="categories">
                                                            <option disabled>{$lang.publ.category}</option>
                                                            <option value="1">Начало</option>
                                                            {foreach from=$categories item=item}
                                                                <option value="{$item->id}">{$item->name}</option>
                                                            {/foreach}
                                                        </select></p>
                                                        <p>{$lang.publ.head_for_site}</p>
							<input type="text" name="name" style="width:300px" value="{$smarty.post.name|escape|default:$lang.publ.def_for_title}"/>
							{if $err.name}{* comes from err array in controller validation *}
								<p class="error">{$err.name}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_head}</p>
							<p>{$lang.publ.descr_for_site}</p>
							<textarea name="description">{$smarty.post.description|escape|default:$lang.publ.def_for_descr}</textarea>
							{if $err.description}
								<p class="error">{$err.description}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_descr}</p>
							<p>{$lang.publ.keys_for_site}</p>
							<input type="text" name="keywords" style="width:300px" value="{$smarty.post.keywords|escape|default:$lang.publ.def_for_keys}"/>
							{if $err.keywords}
								<p class="error">{$err.keywords}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_keys}</p>
							<p> {$lang.publ.e_mail}</p>
							<input type="text" name="email" style="width:300px" value="{$smarty.post.email|escape|default:$lang.publ.def_for_mail}"/>
							{if $err.email}
								<p class="error">{$err.email}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_mail}</p>
							<p style="color:red">{$lang.publ.condition}</p>
							<button type="submit">{$lang.publ.button_pub}</button>
							</form>
						</td>
						<td width="33%" style="vertical-align: top">
							<h2>{$lang.publ.condition_main}</h2>
							<ol>
								<li>{$lang.publ.item_1}</li>
								<li>{$lang.publ.item_2}</li>
								<li>{$lang.publ.item_3}</li>
							</ol>
						</td>
						<td width="33%" style="vertical-align: top">
							<h2>{$lang.publ.adv}</h2>
							<p>{$lang.publ.adv_1}</p>
						</td>
				   </tr>
			   </table>
            {/if}
		{/if}