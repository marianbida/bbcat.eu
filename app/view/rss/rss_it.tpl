<?xml version='1.0' encoding='utf-8' ?>
<rss version='2.0'>
<channel>
	<title>{$rss_t->title}</title>
	<link>{$base_url}</link>
	<description>{$rss_t->description}</description>
	<language>{$rss_t->language}</language>
	<copyright>{$rss_t->copyright}</copyright>
	<category>{$rss_t->category}</category>
	<generator>Hand made by new.bgcat.eu</generator>
	<ttl>60</ttl>
        {foreach from=$item_list item=o}
         
	<item>
                
		<title>{$o->title}</title>
		<description>{$o->description}</description>
                <keywords>{$o->keywords}</keywords>
		<link>{$o->url}</link>
		<pubDate>{$o->udate}</pubDate>

	</item>

	{/foreach}
</channel>
</rss>