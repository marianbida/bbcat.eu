<div class="register_tiny">
	{if !($smarty.session.user_id)}
		<form action="{$base_url}?lang_id={$lang_id}&view=user&action=login" method="post">
			<label for="email">{$lang.user.email}</label>
			<input type="text" name="email" value="{$smarty.post.email|escape}" />
			<label for="pass">{$lang.user.password}</label>
			<input type="password" name="password" value="{$smarty.post.password|escape}" />
			<button type="submit">{$lang.button.login}</button>
		</form>
		<ul class="ul_1">
			<li><a href="{$base_url}?view=user&action=register">{$lang.user.register}</a></li>
			<li><a href="{$base_url}?view=user&action=lost_password">{$lang.user.lost_password}</a></li>
		</ul>
	{else}
		<a href="{$base_url}?lang_id={$lang_id}&view=user&action=logout">{$lang.user.logout}</a>
	{/if}
</div>