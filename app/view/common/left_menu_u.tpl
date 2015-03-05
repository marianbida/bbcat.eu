<ul id="menu">
{foreach from=$left_menu_list item=item}
<li>
	<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
	<dl class="gallery">
		<dt><a href="{$base_url}prou.php?cid={$item->category_id}&cname={$item->category_name}">{$item->category_name}</a></dt>
			<dd><a href="{$base_url}prou.php?cid={$item->category_id}&cname={$item->category_name}"><img src="{$base_url}category_images/{$item->category_image}" /></a></dd>
		</dl>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
{/foreach}