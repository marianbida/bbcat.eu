<html>
<body>
	<p>Здравейте {$data.name}, {$data.send_email}</p>
	<p>Това е имот, публикувана в сайта <a href="{$base_url}">{$base_url}</a></p>
	<p>Изпраща Ви го {$data.send_name}, {$data.send_email}</p>
	<p>Повече подробности за обявата можете да видите, ако изберете <a href="{$base_url}?lang_id={$data.lang_id}&view=item&id={$data.ref}">тук</a>.</p>
	<p>Или да посетите директно имота на адресс {$base_url}?lang_id={$data.lang_id}&view=item&id={$data.ref}</p>
	<p>Допълнителен коментар от изпращача: {$data.msg}</p>
</body>
</html>