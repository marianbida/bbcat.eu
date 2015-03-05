	<!-- content -->
          	<div style="margin-top:10px" id="wrap">
                <h1>{$lang.publ.head}</h1>
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
                                                    <form name="publish" id="publish" action="{$base_url}publish" method="post">
							<h2>{$lang.publ.deteils}</h2>
							<p>{$lang.publ.web_address}</p>
							<input type="text" name="address" id="address" style="width:300px" value="{$smarty.post.address|escape|default:$lang.publ.def_for_addr}" onfocus='showDown("address","{$lang.publ.def_for_addr}");' onblur='showUp("address","{$lang.publ.def_for_addr}")'/>
							{if $err.address}
								<p class="error">{$err.address}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_addr}</p>
                                                        <p><select name="categories">
                                                            <option disabled>{$lang.publ.category}</option>
                                                            {if $category==""}
                                                                <option value="1">Начало</option>
                                                                {foreach from=$categories item=item}
                                                                        {if $item->ref == 1}
                                                                            <option value="{$item->id}">{$item->name}</option>
                                                                             {foreach from=$categories item=subitem}
                                                                                {if $subitem->ref == $item->id}
                                                                                    <option value="{$subitem->id}">&nbsp&nbsp&nbsp&nbsp{$subitem->name}</option>
                                                                                {/if}
                                                                             {/foreach}
                                                                        {/if}
                                                                {/foreach}
                                                                {else}
                                                                    <option value="1">Начало</option>
                                                                        {foreach from=$categories item=item}
                                                                              {if $item->ref == 1}
                                                                                 {if $item->id == $category}
                                                                                    <option value={$item->id} selected="selected">{$item->name}</option>
                                                                                    {else}
                                                                                        <option value="{$item->id}">{$item->name}</option>
                                                                                 {/if}
                                                                                 {foreach from=$categories item=subitem}
                                                                                    {if $subitem->ref == $item->id}
                                                                                        {if $subitem->id == $category}
                                                                                            <option value={$subitem->id} selected="selected">&nbsp&nbsp&nbsp&nbsp{$subitem->name}</option>
                                                                                            {else}
                                                                                                <option value="{$subitem->id}">&nbsp&nbsp&nbsp&nbsp{$subitem->name}</option>
                                                                                        {/if}
                                                                                    {/if}
                                                                                 {/foreach}
                                                                            {/if}
                                                                        {/foreach}
                                                            {/if}
                                                        </select></p>
                                                        <p>{$lang.publ.head_for_site}</p>
							<input type="text" id="name" name="name" style="width:300px" value="{$smarty.post.name|escape|default:$lang.publ.def_for_title}" onfocus='showDown("name","{$lang.publ.def_for_title}");' onblur='showUp("name","{$lang.publ.def_for_title}")'/>
							{if $err.name}{* comes from err array in controller validation *}
								<p class="error">{$err.name}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_head}</p>
							<p>{$lang.publ.descr_for_site}</p>
							<textarea name="description" id="description" onfocus="if(this.value=='{$lang.publ.def_for_descr}') this.value='';" onblur="if(this.value=='') this.value='{$lang.publ.def_for_descr}';">{$smarty.post.description|escape|default:$lang.publ.def_for_descr}</textarea>
							{if $err.description}
								<p class="error">{$err.description}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_descr}</p>
							<p>{$lang.publ.keys_for_site}</p>
							<input type="text" name="keywords" id="keywords" style="width:300px" value="{$smarty.post.keywords|escape|default:$lang.publ.def_for_keys}" onfocus='showDown("keywords","{$lang.publ.def_for_keys}");' onblur='showUp("keywords","{$lang.publ.def_for_keys}")'/>
							{if $err.keywords}
								<p class="error">{$err.keywords}</p>
							{/if}
							<p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_keys}</p>
							<p> {$lang.publ.e_mail}</p>
							<input type="text" name="email" id="email" style="width:300px" value="{$smarty.post.email|escape|default:$lang.publ.def_for_mail}" onfocus='showDown("email","{$lang.publ.def_for_mail}");' onblur='showUp("email","{$lang.publ.def_for_mail}")'/>
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