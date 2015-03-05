<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$meta->title}</title>
	<meta name="description" content="{$meta->description}" />
	<meta name="keywords" content="{$meta->keywords}" />
	<meta name="author" content="marian.bida@gmail.com" />
	<meta name="area" content="spares" />
	<meta name="rating" content="General" />
	<meta name="copyright" content="-" />
	<meta http-equiv="audience" content="dealers" />
	<meta name="subject" content="corporate page" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="robots" content="all" />
	<style type="text/css" media="all">
	@import "{$base_url}css/thickbox.css";
	@import "{$base_url}css/jquery.tooltip.css";
	@import "{$base_url}css/main.css";
	@import "{$base_url}css/style.css";
	</style>
	<script type="text/javascript">
	var conf = {ldelim}
		base_url : "{$base_url}"
	{rdelim};
	</script>
	<script type="text/javascript" src="{$base_url}js/jquery-1.3.2.js" ></script>
	<script type="text/javascript" src="{$base_url}js/jquery.bgiframe.js" ></script>
	<script type="text/javascript" src="{$base_url}js/jquery.dimensions.js" ></script>
	<script type="text/javascript" src="{$base_url}js/jquery.tooltip.js" ></script>
	<script type="text/javascript" src="{$base_url}js/thickbox.js"></script>
	<script type="text/javascript" src="{$base_url}js/main.js"></script>
	<script type="text/javascript" src="{$base_url}js/swfobject.js"></script>
	<meta name="verify-v1" content="1rVgCqXrdHb5EtXst9WRFPLAlqOKvW3KNvYbNMttES8=" />
</head>
<body style="background:#fff">
<div style="background:#fff">
{if $state eq 1}
	<div style="padding:10px">
		<h1>Благодарим Ви</h1>
		<p>Вашият коментар беще публикуван успешно, след модерация ще бъде публикуван в сайта.</p>
	</div>
{else}
	<form id="comment_form" action="{$base_url}comment_add/{$id}/" method="post" style="width:500px" class="p_form p_form_1">
		<div class="p_form_row_1 clearfix">
			<label for="name">Име:</label>
			<span class="p_text width_3">
				<input type="text" name="name" id="name" value="{$smarty.post.name|escape}" class="p_text" />
			</span>
			<sup class="red">*</sup>
			{if $comment_err.name_err ne ''}
				<p class="p_error_message">{$comment_err.name_err}</p>
			{/if}
		</div>
		<div class="p_form_row_1 clearfix">
			<label for="email">E-mail:</label>
			<span class="p_text width_4">
				<input class="p_text" type="text" name="email" id="email" value="{$smarty.post.email|escape}" />
			</span>
			<sup class="red">*</sup>
			{if $comment_err.email_err ne ''}
				<p class="p_error_message">{$comment_err.email_err}</p>
			{/if}
		</div>
		<div class="p_form_row_1 clearfix">
			<label for="content">Коментар:</label>
			<span class="p_textarea width_4">
				<textarea name="content" id="comment">{$smarty.post.content|escape}</textarea>
			</span>
			<sup class="red">*</sup>
			{if $comment_err.content_err ne ''}
				<p class="p_error_message">{$comment_err.content_err}</p>
			{/if}
		</div>
		<div class="p_form_row_1 clearfix">
			<label for="code">Спам защита:</label>
			<span class="p_text width_4">
				<input class="p_text" type="text" value="" id="code" name="code" value="{$smarty.post.code|escape}" />
			</span>
			<sup class="red">*</sup>
		</div>
		<div class="p_form_row_1 clearfix">
			<label>&nbsp;</label>
			<span>
				<img alt="-code-" src="{$base_url}captcha.jpg?rand=0.5686832850859883" id="captcha" />
			</span>
			{if $comment_err.code_err ne ''}
				<p class="p_error_message">{$comment_err.code_err}</p>
			{/if}
		</div>
		<span class="button_1" style="width:130px">
				<span class="btn_lbg">
					<span class="btn_rbg">
						<button style="font-weight:bold;color:#fff;height:26px;background:none;border:none" type="submit">Публикувай</button>
					</span>
				</span>
			</span>
	</form>
{/if}
</div>
</body>
</html>