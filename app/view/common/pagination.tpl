<div class="s_pager">
	<ul class="clearfix">
	{if $current_page gt 1}
		<li class="first"><a href="{$pprefix}?page={$current_page-1}" title="">&laquo;</a></li>
	{/if}
{math assign="i_start" equation="x - (y / 2)" x=$current_page y=$range}
{math assign="i_end" equation="x + (y / 2)" x=$current_page y=$range}
{if $i_start lt 1}
	{math assign="i_end" equation="(x * (-1)) + y" x=$i_start y=$i_end}
	{math assign="i_start" equation="1"}
{/if}
{if $i_end gt $total_pages}
	{math assign="i_start" equation="x - (y - z)" x=$i_start y=$i_end z=$total_pages}
	{math assign="i_end" equation="z + ((x + y) - z)" x=$i_start y=$range z=$total_pages}
{/if}
{section name=p start=$i_start loop=$i_end step=1}
	{if $current_page eq $smarty.section.p.index}
		<li class="selected"><a href="javascript:;" title="">{$smarty.section.p.index}</a></li>
	{else}
		<li><a href="{$pprefix}?page={$smarty.section.p.index}" title="">{$smarty.section.p.index}</a></li>
	{/if}
{/section}
{if $current_page lt $total_pages-1}
	<li class="last"><a href="{$pprefix}?page={$current_page+1}" title="">&raquo;</a></li>
{/if}
</ul>
</div>