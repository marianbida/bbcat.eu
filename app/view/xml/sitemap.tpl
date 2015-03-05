<?xml version='1.0' encoding='utf-8' ?>
<rss version='2.0' xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
	<title>{$rss->title}</title>
	<link>{$base_url}</link>
	<description>{$rss->description}</description>
	<language>{$rss->language}</language>
	<webMaster>{$rss->webmaster}</webMaster>
	<copyright>{$rss->copyright}</copyright>
	<category>{$rss->category}</category>
	<generator>WebMaxCMS by http://webmax.bg</generator>
	<ttl>60</ttl>
	<atom:link href="http://bbcat.eu/sitemap/xml" rel="self" type="application/rss+xml" />
	<image>
		<url>{$base_url}images/webmax.153.50.transparent.png</url>
		<title>{$rss->title}</title>
		<link>{$base_url}</link>
	</image>
	{foreach from=$page_list item=item}
	{assign var="updated" value=$item->udate|strtotime}
	<item>
		<title>{$item->page_title}</title>
		<description><![CDATA[{$item->page_description}]]></description>
		<link>{$base_url}{$item->prefix}</link>
		<pubDate>{"r"|date:$updated}</pubDate>
		<guid isPermaLink="false">{$item->page_title|md5}</guid>
	</item>
	{/foreach}
	{foreach from=$item_list item=item}
	{assign var="updated" value=$item->udate|strtotime}
	<item>
		<title>{$item->title|htmlspecialchars|default:"-na-"}</title>
		<description><![CDATA[{$item->description}]]></description>
		<link>{$base_url}view/{$item->id}</link>
		<pubDate>{"r"|date:$updated}</pubDate>
		<guid isPermaLink="false">{$item->url|md5}</guid>
	</item>
	{/foreach}
</channel>
</rss>