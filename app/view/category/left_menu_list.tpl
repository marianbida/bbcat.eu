<h1 class="header-catalog">Каталог</h1>
<div class="left_category_list" style="background:#fff;margin-left:2px">
	<ul>
	{foreach from=$category_list item=item}
	{if $item->category_parent == 0}
		<li class="cat"  id="cat_a_{$item->category_id}" style="margin-bottom:2px;background:#4B78B1" {if $smarty.get.category_id eq $item->category_id} style="margin-bottom:0;background:#4B78B1;border-left: 3px solid black" {/if}>
			<a id="cat_aa_{$item->category_id}" href="{$base_url}?req=pro&amp;category_id={$item->category_id}&amp;cname={$item->title}">{$item->title}</a>
		</li>
		{if $current_category_id == $item->category_id}
			<li style="background:none;padding-top:0;margin-top:0">
			<ul style="margin-left:2px;margin-top:0">
			{foreach from=$category_list item=sub_item}
				{if $sub_item->category_parent eq $item->category_id}
				<li class="cat {if $smarty.get.sub_category_id eq $sub_item->category_id} sub_category_current{/if}" {if $smarty.get.sub_category_id eq $sub_item->category_id} style="border-left: 3px solid black" {/if}id="cat_a_{$sub_item->category_id}">
						<a  href="{$base_url}?req=pro&amp;category_id={$item->category_id}&amp;sub_category_id={$sub_item->category_id}&amp;cname={$sub_item->title}">{$sub_item->title}</a>
				</li>
				{/if}
			{/foreach}
			</ul>
			</li>
		{/if}
	{/if}
	{/foreach}
	</ul>
</div>