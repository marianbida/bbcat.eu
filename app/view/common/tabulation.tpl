<div class="tabulation" style="{$style}">
	<ul>
	{foreach from=$lang_list item=item}
	<li>
		<a href="#{$prefix}_{$item->id}">
			<img border="0" src="{$base_url}cms/images/languages/{$item->code}.gif" />
		</a>
	</li>
	{/foreach}
	</ul>
</div>