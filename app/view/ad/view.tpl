    <div id="content">
		<ul class="menu">
			<li id="main" class="active" style="background-image:url(/images/button_active.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
            <li id="about" class="active" style="background-image:url(/images/button.gif);" ><a href="{$base_url}about">{$lang.cat.about}</a></li>
            <li id="add" class="active" style="background-image:url(/images/button.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
            <li id="contacts" class="active" style="background-image:url(/images/button.gif);"  ><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>		
            <li id="payment" class="active" style="background-image:url(/images/button.gif);"  ><a href="{$base_url}payment">{$lang.cat.payment}</a></li>
		</ul>
        <br />
		<a class="ui_facebook" target="_blank" title="{$lang.about.3}" href="http://www.facebook.com/www.newbgcat.eu">Facebook</a>
		<table>
		<tr>
			<td style="vertical-align: top;">
				{include file="column/left.tpl"}
			</td>
            <td style="vertical-align: top">
				<div class="main_part" id="main_part">
					<table id="sites" style="width:100%; height:100%; margin-top:10px">
                    <tr>
						<td>
							<p style="margin-top:15px; margin-left:15px; margin-bottom: 15px;">{$item->title}</p>
							<a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">
								  <img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" />
							</a>
							<h3>{$lang.about.url}</h3><a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a><br />
							<h3>{$lang.about.desc}</h3>
							<p style="margin-top:15px; margin-left:15px;">{$item->description}</p>
							<h3>{$lang.about.keywords}</h3>
							<p style="margin-top:15px; margin-left:15px;">{$item->keywords}</p>

							<h3>{$lang.about.visits} <a style="color:green;">{$counter}</a></h3>
							<h3>{$lang.about.visits_r} <a style="color:green;">{$count_r}</a></h3>
							<br />
							<br />
							<h3>{$lang.about.sites}</h3><br/>

							{foreach from=$same_s item=item}
							 <div class="zebra {cycle values="zebraA,zebraB"}">
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px;" title="{$item->url}">
									<img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" align="left" />
								</a>
								<a href="{$base_url}view/{$item->id}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
								<p>{$item->description}</p>
							 </div>
							{/foreach}
							<br />
							<a href="{$ref}"><< {$lang.about.4} </a>
					   </td>
                    </tr>
                    </table>
				</div>
                <div id="footer" style="background-image:url({$base_url}/images/footer_bg.gif);">
					<div>
						<ul>
							<li><a href="{$base_url}">{$lang.cat.begin}</a> |</li>
							<li><a href="{$base_url}about">{$lang.cat.about}</a> |</li>
							<li><a href="{$base_url}publish">{$lang.cat.href_begin}</a> |</li>
							<li><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>
						</ul>
					</div>
					<span>Copyright &copy; Уеб дизайн и оптимизация <a href="http://webmax.bg" target="_blank" title="WebMax.bg" class="bft">webmax.bg</a></span>
                </div>
                <div id="fly_adv" style="position: fixed; bottom: 0px;">
                    <div class="lists">
                        <ul style="margin-top: 4px;">
                            <li><a class="ui_facebook" href="javascript:FaceBook.toggle();" style="font-size:12px; color:green">Bgcat.eu във Facebook</a></li>
                        </ul>
                    </div>
                </div>
                <div id="facebook_fly" style="position: fixed; bottom: 34px; display: block;">
                    <div id="ffi">
                        <iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:238px; height:255px;" src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/bgcateu/201740569902017&width=238&colorscheme=light&connections=8&stream=false&header=false&height=255"/>
                    </div>
                </div>
           </td>
       </table>
    </div>
	