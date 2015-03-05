<?xml version='1.0' encoding='utf-8' ?>
<rss version='2.0'>
<channel>
	<title>{$rss->title}</title>
	<link>{$base_url}</link>
	<description>{$rss->description}</description>
	<language>{$rss->language}</language>
	<copyright>{$rss->copyright}</copyright>
	<category>{$rss->category}</category>
	<generator>Hand made by new.bgcat.eu</generator>
	<ttl>60</ttl>
        {foreach from=$cat_list item=o}
	<item>
		<title>{$o->name}</title>
		<description>{$o->description}</description>
		<link>{$base_url}?cat_id={$o->id}</link>
		<pubDate>{$o->udate}</pubDate>
		
	</item>
	{/foreach}
        
</channel>
</rss>