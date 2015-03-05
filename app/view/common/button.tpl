<!-- {$type|default:'submit'} button -->
<span class="s_button_{$class|default:'submit'}">
	<span class="p_button_inner">
	<button type="{$type|default:'submit'}" class="{$class|default:'btn'}"{if $id} id="{$id}"{/if}>
		{$value|default:'Submit'}
	</button>
	</span>
</span>
<!-- end of {$type|default:'submit'} button -->