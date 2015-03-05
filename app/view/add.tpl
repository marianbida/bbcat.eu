<div class="mainContentLeft">
	<!-- left -->
	<div class="leftSideMain">
		{include file="category/left_menu_list.tpl"}
		<div style="padding:0 0 10px 0;">
			<img src="includes/high-quality.jpg" alt="high-quality" />
		</div>
		{include file="google/search_form.tpl"}
	</div>
	<!-- end of left -->
	<div class="tablica">
		<h1 class="header-catalog">{$lang.ads.search}</h1>
		<div class="KT_tng" style="background:#efefef">
			<div class="KT_tnglist" style="background:#efefef">
			{include file="ad/search_form.tpl"}
			</div>
			<br clear="all" />
		</div>
		<br clear="all" />
		<div class="pager">
				{$pagination}
			</div>
		{include file="ad/results.tpl"}
		<div class="pager">
				{$pagination}
			</div>
	</div>
</div>
</div>