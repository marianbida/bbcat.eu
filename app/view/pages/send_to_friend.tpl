<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
	@import url("{$base_url}css/style.css");
	@import url("{$base_url}css/register.css");
	@import url("{$base_url}css/thickbox.css");
	</style>
	<script src="{$base_url}js/jquery-1.3.1.js" type="text/javascript"></script>
	<script src="{$base_url}js/jquery.cookie.js" type="text/javascript"></script>
	<script src="{$base_url}js/thickbox.js" type="text/javascript"></script>
	<script src="{$base_url}js/swfobject.js" type="text/javascript"></script>
	<script src="{$base_url}js/main.js" type="text/javascript"></script>
</head>
<body>
	<div class="contact_form" style="width:600px">
	{if $smarty.session.step == 'step_1'}
		<div>Вашето съобщение е изпратено успешно</div>
	{else}
		<form action="{$base_url}?view=send_to_friend&lang_id={$lang_id}&ref={$smarty.get.ref}" method="post">
		<input type="hidden" name="ref" value="{$smarty.get.ref|escape}" style="display:none" />
			<div class="clear">
				<label for="name">{$lang.send_to_friend.receiver_name}:<sup class="red">*</sup></label>
				<input type="text" name="name" id="name" value="{$smarty.post.name|escape}" />
				{if $smarty.session.send_to_friend_error.name_err}
					<span class="error">{$smarty.session.send_to_friend_error.name_err}</span>
				{/if}
			</div>
			<div class="clear">
				<label for="email">{$lang.send_to_friend.receiver_email}:<sup class="red">*</sup></label>
				<input type="text" name="email" id="email" value="{$smarty.post.email|escape}" />
				{if $smarty.session.send_to_friend_error.email_err}
					<span class="error">{$smarty.session.send_to_friend_error.email_err}</span>
				{/if}
			</div>
			
			<div class="clear">
				<label for="msg">{$lang.send_to_friend.msg}:</label>
				<textarea name="msg" id="msg">{$smarty.post.msg|escape}</textarea>
			</div>
			
			<div class="clear">
				<label for="send_name">{$lang.send_to_friend.send_name}:<sup class="red">*</sup></label>
				<input type="text" name="send_name" id="send_name" value="{$smarty.post.send_name|escape}" />
				{if $smarty.session.send_to_friend_error.send_name_err}
					<span class="error">{$smarty.session.send_to_friend_error.send_name_err}</span>
				{/if}
			</div>
			<div class="clear">
				<label for="send_email">{$lang.send_to_friend.send_email}:<sup class="red">*</sup></label>
				<input type="text" name="send_email" id="send_email" value="{$smarty.post.send_email|escape}" />
				{if $smarty.session.send_to_friend_error.send_email_err}
					<span class="error">{$smarty.session.send_to_friend_error.send_email_err}</span>
				{/if}
			</div>
			<div class="clear">
				<label for="code">{$lang.inquiry.code}:<sup class="red">*</sup></label>
				<input type="text" name="code" id="code" value="{$smarty.post.code|escape}" />
				{if $smarty.session.send_to_friend_error.code_err}
					<span class="error">{$smarty.session.send_to_friend_error.code_err}</span>
				{/if}
			</div>
			<div class="clear">
				<label for="code">&nbsp;</label>
				<img id="captcha" src="{$base_url}captcha.jpg" alt="-code-" />
				<a href="javascript:media.setImage('captcha','{$base_url}captcha.jpg');">{$lang.captcha.reload_image}</a>
			</div>
			<div class="clear">
				<button type="submit">{$lang.button.send}</button>
			</div>
		</form>
	{/if}
	</div>
</body>
</html>