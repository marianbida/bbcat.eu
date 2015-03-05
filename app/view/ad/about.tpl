<body>
        <form id="index" name="index" method="get" action="{$base_url}search">
 	<div id="header" style="background-image:url(images/header_bg.gif);">
		<div>
			<a href="{$base_url}" class="logo"><img src="images/logo.gif" alt="" width="192" height="42" /></a>																																																	
			<div class="search" style="background-image:url(images/search_block.jpg);">
				
					<input id="q" name="q" type="text" class="search_field"  value="{$smarty.get.find|escape|default:$lang.cat.find_def}" onfocus='showDown("q","{$lang.cat.find_def}");' onblur='showUp("q","{$lang.cat.find_def}")'/>
					<input type="submit" class="search_button" value="" style="background-image:url(images/search.gif);"/>
				
			</div>
		</div>
	</div>
	<div id="content">
		<ul class="menu">
			<li id="main" class="active" style="background-image:url(images/button.gif);"><a href="{$base_url}">{$lang.cat.begin}</a></li>
			<li id="about" class="active" style="background-image:url(images/button_active.gif);" ><a href="{$base_url}about">{$lang.cat.about}</a></li>
			<li id="add" class="active" style="background-image:url(images/button.gif);"><a href="{$base_url}publish">{$lang.cat.href_begin}</a></li>
			<li id="contacts" class="active" style="background-image:url(images/button.gif);" ><a href="{$base_url}contacts">{$lang.cat.contacts}</a></li>																																																																																																																																															
		</ul>
		<br>
            <a class="ui_facebook" target="_blank" title="Посетете Ни във Facebook" href="http://www.facebook.com/pages/bgcateu/201740569902017">Facebook</a>

                <table>
                <tr>
                <td style="vertical-align: top;">
               
               	<div class="column"  style="background-image:url(images/column_bg.gif);">
			<img src="images/top.gif" alt="" width="231" height="5" /><br />
			<div>
				<img src="images/title1.gif" alt="" width="209" height="30" /><br />
				<p style="color:grey; font-size:12px;">
					Lorem ipsum dolor sit amet, consectetuer adipi scing elit.Mauris urna urna, varius et, interdum a, tincidunt quis, libero. Aenean sit amturpis. Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. Proin nunc. Donec nonummy, tellus er sodales enim, in tincidunmauris in odio. Massa ac laoreet iaculipede nisl ullamcor- permassa, ac con- sectetuer feipsum eget pede. Proin nunc.
				</p>
				<p style="color:grey; font-size:12px;">
					 Aenean sit amturpis. Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorper- massa, cosectetuer feipsum eget pede. Proin nunc. Donec nonummy, tellus er sodales enim, in tincidunmauris in odio. Massa ac laoreet iaculipede nisl ullamcor- permassa, ac con- sectetuer feipsum eget pede. Proin nunc.
				</p >
				<a href="{$base_url}publish" class="link">{$lang.cat.href_begin}</a>
			</div>
			<img src="images/bot.gif" alt="" width="231" height="5" /><br />
		</div>
               
                </td>
                <td style="vertical-align: top;">
                    <div class="main_part" id="main_part">
                        <p style="color:grey; font-size:12px;">{$lang.about.1}</p>
                    </div>
                </td>
            </tr>
      </table>
      <div id="fly_adv" style="position: fixed; bottom: 0px;">
                <div class="lists">
                    <ul style="margin-top: 4px;">
                        <li>
                            <a class="ui_facebook" href="javascript:FaceBook.toggle();" style="font-size:12px; color:green">Bgcat.eu във Facebook</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="facebook_fly" style="position: fixed; bottom: 34px; display: block;">
                <div id="ffi">
                    <iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:238px; height:255px;" src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/bgcateu/201740569902017&width=238&colorscheme=light&connections=8&stream=false&header=false&height=255"></iframe>
                </div>
            </div>
    </div>

