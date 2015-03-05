<div class="item {cycle values="odd,even,mon"}">
	<div class="title">{$item->title.$lang_id}</div>
	<div class="thumb">
		<a href="{$url|escape}"><img src="{$thumb}" alt="" /></a>
	</div>
	<div class="details">
		<div class="items">
		{$lang.search.purpose}: <span class="type">{$item->category}</span>, <span class="purpose">{$lang.ads.purpose.$purpose}</span><br />
		{$lang.search.price}: <span class="price">{$lang.search.euro} {$item->price|number_format:0:'':' '}</span>
		</div>
		<div class="short_description">
			<p><a href="{$url|escape}">{$lang.search.more}</a></p>
		</div>
	</div>
	<span class="clear"></span>
</div>
