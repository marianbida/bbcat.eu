    <div id="content">
		<ul class="menu">
            <li id="main" class="active" style="background-image:url({$base_url}images/button.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
            <li id="about" class="active" style="background-image:url({$base_url}images/button.gif);"><a href="{$base_url}about">{$lang.cat.about}</a></li>
            <li id="add" class="active" style="background-image:url({$base_url}images/button_active.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
            <li id="contacts" class="active" style="background-image:url({$base_url}images/button.gif);" ><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>																																																																																																																																															
            <li id="payment" class="active" style="background-image:url({$base_url}images/button.gif);"  ><a href="{$base_url}payment">{$lang.cat.payment}</a></li>
        </ul>
        <table>
        <tr>
			<td style="vertical-align: top;">
				{include file="column/left.tpl"}
            </td>
            <td style="vertical-align: top;">
				<div class="main_part" id="main_part">
                {if $step eq '03'}
					<p>{$lang.publ.pub_success}</p>
                {else}
					{if $step eq '01'}
						<form action="{$paypal[0]->submit_url}" method="post">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="business" value="{$paypal[0]->buisness}">
							<input type="hidden" name="invoice" value="{$id}">
							<input type="hidden" name="lc" value="BG">
							<input type="hidden" name="item_name" value="{$paypal[0]->descr} {$id}">
							<input type="hidden" name="item_number" value="{$id}">
							<input type="hidden" name="amount" value="{$paypal[0]->amount}">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="no_shipping" value="1">
							<input type="hidden" name="rm" value="1">
							<input type="hidden" name="return" value="{$base_url}{$paypal[0]->url_ok}">
							<input type="hidden" name="cancel_return" value="{$base_url}{$paypal[0]->url_not_ok}">
							<input type="hidden" name="currency_code" value="{$paypal[0]->type}">
							<input type="hidden" name="notify_url" value="{$base_url}{$paypal[0]->notify_url}">
							<input type="submit" value="{$lang.publ.pay}">
						</form>

						<form action="{$epay[0]->submit_url}" method=POST>
							<input type=hidden name=PAGE value="paylogin">
							<input type=hidden name=ENCODED value="{$ENCODED}">
							<input type=hidden name=CHECKSUM value="{$CHECKSUM}">
							<input type=hidden name=URL_OK value="{$base_url}{$epay[0]->url_ok}">
							<input type=hidden name=URL_CANCEL value="{$base_url}{$epay[0]->url_not_ok}">
						   <input type="submit" value="{$lang.publ.pay_epay}">
						</form>
						<form name="publish" id="publish" action="{$base_url}publish/later" method="post">
							<input type="hidden" name="later" value="later">
							<input type="submit" value="{$lang.publ.pay_later}">
						</form>
                    {else}
						{if $step eq '02'}
							<p class="error">{$lang.publ.pub_no_success}</p>
                        {else}
							<table id="publish" style="width:100%;height:100%">
                            <tr>
                                <td width="32%">
                                    <form name="publish" id="publish" action="{$base_url}publish" method="post">
                                        <p>{$lang.publ.web_address}</p>
                                        <input type="text" name="address" id="address" style="width:300px" value="{$smarty.post.address|escape|default:$lang.publ.def_for_addr}" onfocus='showDown("address","{$lang.publ.def_for_addr}");' onblur='showUp("address","{$lang.publ.def_for_addr}")'/>
                                        {if $err.address}
											<p class="error">{$err.address}</p>
                                        {/if}
                                        <input type="button" value="{$lang.publ.auto}" style="color:green; height:25px; width: 115px; background-color: lightgray" onclick='load();'>
                                        <p><span style="color:#449911">{$lang.publ.exemple}</span> {$lang.publ.exemple_for_addr}</p>
                                        <p>
                                            <select name="categories">
                                                <option disabled="disabled">{$lang.publ.category}</option>
                                            {if $category == ""}
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
                                            </select>
                                        </p>
                                        <p>{$lang.publ.head_for_site}</p>
                                        <input type="text" id="name" name="name" style="width:300px" value="{$smarty.post.name|escape|default:$lang.publ.def_for_title}" onfocus='showDown("name","{$lang.publ.def_for_title}");' onblur='showUp("name","{$lang.publ.def_for_title}")'/>
                                        {if $err.name}
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
                                        <input type="image" src="images/publish.gif" style="width:80px; height:25px; margin-top:10px; margin-left: 350px;" name="submit"/>
                                        <!--<button type="submit" style="background-image:url(images/publish.gif);"></button>-->
                                    </form>
                                </td>
                            </tr>
                        </table>
                 {/if}
            {/if}
{/if}
                    </div>
                </td>
        </table>

    </div>
