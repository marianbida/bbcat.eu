{foreach from=$out item=v key=k}
    <p>{$k}: {$v}</p>
{/foreach}

<p>-------------------</p>
{foreach from=$list item=v}
    <p>url: {$v->url} : {$v->sss[0]} {$v->sss[1]} {$v->sss[2]} {$v->sss[3]} {$v->sss[4]} {$v->sss[5]}</p>
{/foreach}