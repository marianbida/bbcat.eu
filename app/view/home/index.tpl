    <div id="content">
		<ul class="menu">
			<li id="main" class="active" style="background-image:url(images/button_active.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
            <li id="about" class="active" style="background-image:url(images/button.gif);" ><a href="{$base_url}about">{$lang.cat.about}</a></li>
            <li id="add" class="active" style="background-image:url(images/button.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
            <li id="contacts" class="active" style="background-image:url(images/button.gif);"  ><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>		
            <li id="payment" class="active" style="background-image:url(images/button.gif);"  ><a href="{$base_url}payment">{$lang.cat.payment}</a></li>
		</ul>
        <div class="clear"></div>
        <a class="ui_facebook" target="_blank" title="Посетете Ни във Facebook" href="http://www.facebook.com/pages/bgcateu/201740569902017">Facebook</a>
		<table>
		<tr>
			<td style="vertical-align: top;">
				{include file="column/left.tpl"}
			</td>
			<td style="vertical-align: top;">
				<div class="main_part" id="main_part">
					<div class="breadcrumbs">
						{foreach from=$breadcrumbs item=item name=breadcrumbs}
						<strong style="color:green"><a href="{$base_url}?c={$item->id}" title="{$item->name}">{$item->name}</a>{if !$smarty.foreach.breadcrumbs.last} > {/if}</strong>
						{/foreach}
					</div>
					<div id="list" style="margin-left:10px;margin-top:4px">
						{foreach from=$category_list item=item name=clist}
						<strong><a href="{$base_url}?c={$item->id}" title="{$item->name}">{$item->name}</a></strong> {if !$smarty.foreach.clist.last}&bull;{/if}
						{/foreach}
					</div>
					<table id="sites" style="width:100%;height:100%; margin-top:10px">
					<tr>
						<td>
							{if !$pagess && $f==0}
							{foreach from=$page_list item=item}
							<div class="zebra {cycle values="zebraA,zebraB"}">
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px;" title="{$item->url}">
									<img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" align="left" />
								</a>
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px" title="{$item->url}">{$item->url}</a>
								<p style="margin-top:2px">{$item->description}</p>
							</div>
								{foreachelse}
									<p>{$lang.cat.not_find}</p>
								{/foreach}
								{elseif $f==1}
								{foreach from=$pagess item=item}
							<div class="zebra {cycle values="zebraA,zebraB"}">
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px;" title="{$item->url}">
									<img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" align="left" />
								</a>
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
								<p>{$item->description}</p>
							</div>
								{foreachelse}
									<p>{$lang.cat.not_find}</p>
								{/foreach}
							{else}
								<strong style="color:green"><p>{$lang.cat.not_find}</p></strong>
							{/if}
						</td>
					</tr>
					</table>
					{if $pages > 1}
					<div class="mv_pages">
					{if $page gt 1}
						<a href="{$url}&amp;current_page=1">&laquo;</a>
						<a href="{$url}&amp;current_page={$page-1}">&lsaquo;</a>
					{/if}
					{math assign="i_loop" equation="min($pages, $page+3+max(0,3-$page))"}
					{math assign="i_start" equation="max($page-3-max(0, 3+$page-$pages), 1)"}
					{section loop=$i_loop+1 start=$i_start name=p}
					{if $smarty.section.p.index ne $page}
						<a href="{$url}&amp;current_page={$smarty.section.p.index}">{$smarty.section.p.index}</a>
					{else}
						<u>{$page}</u>
					{/if}
					{/section}
					{if $page lt $pages}
						<a href="{$url}&amp;current_page={$page+1}">&rsaquo;</a>
						<a href="{$url}&amp;current_page={$pages}">&raquo;</a>
					{/if}
					</div>
					{/if}
				</div>
			</td>
		</tr>
		</table>
		<div id="fly_adv" style="position: fixed; bottom: 0px">
			<div class="lists">
				<ul style="margin-top: 4px">
					<li>
						<a class="ui_facebook" href="javascript:FaceBook.toggle();" style="font-size:12px; color:green">Bgcat.eu във Facebook</a>
					</li>
				</ul>
			</div>
			<div id="facebook_fly" style="position: fixed; bottom: 34px; display: block">
				<div id="ffi">
					<iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:238px; height:255px;" src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/bgcateu/201740569902017&width=238&colorscheme=light&connections=8&stream=false&header=false&height=255"></iframe>
				</div>
			</div>
		</div>
    </div>
	