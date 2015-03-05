		<!-- content -->
                              
                <body>
               	<form id="index" name="index" method="get" action="{$base_url}search">
                <div style="margin-top:10px;" id="wrap">
                       
			<h1>{$lang.cat.head}</h1>
			<h2><a href="{$base_url}" title="begin">{$lang.cat.begin}</a></h2>
			<p>{$total_pages}{$lang.cat.companies}</p>
			<a href="{$base_url}publish" title="begin">{$lang.cat.href_begin}</a>
			<p><input id="q" name="q" type="text" style="width:200px" value="{$smarty.get.find|escape|default:$lang.cat.find_def}" onfocus='showDown("q","{$lang.cat.find_def}");' onblur='showUp("q","{$lang.cat.find_def}")'/></p>
                        <p><button type="submit">{$lang.cat.find}</button></p>
                        
                
                <div class="breadcrumbs">
                        {foreach from=$breadcrumbs item=item name=breadcrumbs}
                                <strong style="color:red"><a href="{$base_url}?cat_id={$item->id}" title="{$item->name}">{$item->name}</a>{if !$smarty.foreach.breadcrumbs.last} / {/if}</strong>
                        {/foreach}
                </div>
                <hr />
                <div id="list">
			{foreach from=$category_list item=item}
				<strong><a href="{$base_url}?cat_id={$item->id}" title="{$item->name}">{$item->name}</a></strong>
			{/foreach}
		</div>
                <p>{$lang.cat.res} {$begin_p} - {$end_p} {$lang.cat.from} {$count_site} {$lang.cat.sites_begin}</p>
                <table id="sites" style="width:100%;height:100%"  >
                   
                    <tr >
                     <td >
                          
                                {if !$pagess && $f==0}
                                    {foreach from=$page_list item=item}
                                            <div class="zebra {cycle values="zebraA,zebraB"}">
                                                <a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">
                                                        <img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" align="left" />
                                                </a>
                                                <a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
                                                <p>{$item->description}</p>
                                            </div>
                                    {/foreach}
                                    {elseif $f==1}
                                    {foreach from=$pagess item=item}
                                            <div class="zebra {cycle values="zebraA,zebraB"}">
                                                <a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">
                                                        <img src="http://open.thumbshots.org/image.aspx?url={$item->url}" alt=""  height="90" width="120" align="left" />
                                                </a>
                                                <a href="{$item->url}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
                                                <p>{$item->description}</p>
                                            </div>
                                    {/foreach}
                                    {else}
                                       <strong style="color:red"> <p>{$lang.cat.not_find}</p></strong>
                                {/if}
                            </td>
                    </tr>
                   </table>
                  </div>
                                        {if $pages > 1}
                                        <div class="mv_pages">

                                          {if $page gt 1}
                                           <a href="{$url}&amp;current_page=1">&laquo;</a>
                                           <a href="{$url}&amp;current_page={$page-1}">&lsaquo;</a>
                                          {/if}
                                          {math assign="i_loop" equation="min($pages, $page+3+max(0,3-$page))"}
                                          {math assign="i_start" equation="max($page-3-max(0, 3+$page-$pages), 1)"}
                                          {section loop=$i_loop+1 start=$i_start name=p}
                                           {if $smarty.section.p.index ne $page}
                                            <a href="{$url}&amp;current_page={$smarty.section.p.index}">{$smarty.section.p.index}</a>
                                           {else}
                                            <u>{$page}</u>
                                           {/if}
                                          {/section}
                                          {if $page lt $pages}
                                           <a href="{$url}&amp;current_page={$page+1}">&rsaquo;</a>
                                           <a href="{$url}&amp;current_page={$pages}">&raquo;</a>
                                          {/if}

                                        </div>
                                        {/if}
            </form>
      