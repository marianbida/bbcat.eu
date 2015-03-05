	<div id="content">
		<ul class="menu">
			<li id="main" class="active" style="background-image:url(images/button.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
			<li id="about" class="active" style="background-image:url(images/button.gif);"> <a href="{$base_url}about">{$lang.cat.about}</a></li>
			<li id="add" class="active" style="background-image:url(images/button.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
			<li id="contacts" class="active" style="background-image:url(images/button_active.gif);"> <a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>
			<li id="payment" class="active" style="background-image:url(images/button.gif);"  ><a href="{$base_url}payment">{$lang.cat.payment}</a></li>
		</ul>
        <table>
        <tr>
			<td style="vertical-align: top;">
				{include file="column/left.tpl"}
            </td>
            <td style="vertical-align: top;">
				<div class="main_part" id="main_part">
					<p style="color:grey; font-size:12px;">{$contacts[0]->content}</p>
				</div>
            </td>
        </tr>
		</table>
	</div>