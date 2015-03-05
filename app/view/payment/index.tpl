
    <div id="content">
        <ul class="menu">
            <li id="main" class="active" style="background-image:url({$base_url}images/button.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
            <li id="about" class="active" style="background-image:url({$base_url}images/button.gif);"><a href="{$base_url}about">{$lang.cat.about}</a></li>
            <li id="add" class="active" style="background-image:url({$base_url}images/button.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
            <li id="contacts" class="active" style="background-image:url({$base_url}images/button.gif);" ><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>																																																																																																																																														
            <li id="payment" class="active" style="background-image:url({$base_url}images/button_active.gif);"  ><a href="{$base_url}payment">{$lang.cat.payment}</a></li>
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

                                   <!-- <input type="submit" value="{$lang.publ.pay_epay}">-->
                        </form>
                            <form name="publish" id="publish" action="{$base_url}payment/later" method="post">

                                <input type="hidden" name="leter" value="leter">
                                <input type="submit" value="{$lang.publ.pay_later}">

                            </form>
                                    {else}
                            <form action="{$base_url}payment" method="post">
                                <p> {$lang.publ.id}</p>
                                <input type="text" name="id" id="id" style="width:300px" value="{$smarty.post.id|escape}" />
                                    {if $err.id}
                                <p class="error">{$err.id}</p>
                                    {/if}
                                <p> {$lang.publ.email}</p>
                                <input type="text" name="email" id="email" style="width:300px" value="{$smarty.post.email|escape}" />
                                    {if $err.email}
                                <p class="error">{$err.email}</p>
                                    {/if}<br/>
                                <button type="submit">Плати</button>

                            {/if}
                        {/if}





                            </form>
                    </div>
                            </td>
                            </tr>
                            </table>

                    </div>