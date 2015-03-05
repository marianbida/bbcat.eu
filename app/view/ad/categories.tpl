	<!-- content -->
        {include file="header.tpl"}
        <body>
	<div id="top" style="margin-top:10px;" id="wrap">
                <h1>{$lang.cat.head}</h1>
                <h2>{$lang.cat.begin}</h2>
                {foreach from=$count_site item=item}
                <p>{$item->total}{$lang.cat.companies}</p>
                {/foreach}
                <a href="{$main_part}/publish" title="begin">{$lang.cat.href_begin}</a>
                <p>{$lang.cat.begin}</p>
                <p>{$lang.cat.find}</p>
        </div>
        <div id="list">
                <table name="categories" width="100%" height="100%" >
                    <tr>
                        {foreach from=$items item=item}
                            {assign var="counter" value="`$counter+1`"}
                                {if $counter == 7}
                                    {assign var="counter" value="`$counter-7`"}
                                    </tr>
                                {else}
                                    <td style="height:50px;"><strong><a href="{$main_part}" title="{$item->name}">{$item->name}</a></strong></td>
                                {/if}
		
                        {/foreach}
                 </table>

      </div >
    
       <p>{$lang.cat.res} {$begin_p} - {$end_p} {$lang.cat.from} {$count_site} {$lang.cat.sites_begin}</p>
       <form action="" method="post">
       <table id="sites" style="width:100%;height:100%"  >
            <tr>
                <td>
                    <div id="adv" style="margin: 5px; background:white; width:400px;">
                          <strong><a href="{$nova_part}" title="nova" style="color:blue; font-size:13px;">{$lang.cat.href_nova}</a></strong>
                          <p>{$lang.cat.nova_text}</p>
                          <a href="{$nerra_tv}" title="nerra">{$lang.cat.nerra}</a>
                          <a href="{$google}" ><img height=30px width=100px align="right" src="./css/adv.gif"></a>
                    </div>
                </td>
                <td>
                        <p><strong>{$lang.cat.adv}</strong></p>
                        <p>{$lang.cat.adv_o}</p>
                </td>
            </tr>
            <tr>
            <td >
            {foreach from=$sites item=item}
                            {assign var="counter" value="`$counter+1`"}
                                    {if $counter <12}
                                    <div style="height:100px; background:lavender; border-style:solid; border-width:3px; border-color:white;">
                                        <img height="80px" width="140px" align="left" src="./css/def.jpg"> <a href="{$main_part}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
                                        <p>   {$item->description}</p></br></br>
                                    </div>
                                  
                                {else}
                               
                                {/if}
                           
           {/foreach}
            </td>
            <td style="border-style:solid; border-width:5px; border-color:white;">
           {foreach from=$sites item=item}
                            {assign var="counter1" value="`$counter1+1`"}
                                 
                                    {if $counter1 > 10}
                                        <div style="height:100px; background:white;  border-style:solid; border-width:3px; border-color:white;">
                                            <img height="80px" width="140px" align="left" src="./css/def.jpg"> <a href="{$main_part}" style="margin-left:10px;" title="{$item->url}">{$item->url}</a>
                                            <p>   {$item->description}</p></br></br>
                                        </div>
                                    {else}
                                    {/if}
            {/foreach}
            </td>
            </tr>
            </table>
         </form>
       {include file="ad/footer.tpl"}
      {include file="footer.tpl"}