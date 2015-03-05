<!-- content -->
<div id="content">
<table border="0" cellpadding="0" cellspacing="0">
<tr align="left" valign="top">
	<td class="white_bg">
		<div class="left_1">
			{include file="common/telephones.tpl"}
			{include file="common/extra_links.tpl"}
		</div>
	</td>
	<td width="606">
		{if $action == "login"}
			<div class="login_extended contact_form">
			{if $smarty.session.user_id > 0}
				<h1>{$lang.user.greatings}</h1>
				<p>{$lang.user.msg.login_success}</p>
				<a href="{$base_url}?view=user&amp;action=logout">{$lang.user.logout}</a>
			{else}
					<h1>{$lang.user.login}</h1>
					<form action="{$base_url}?lang_id={$lang_id}&view=user&action=login" method="post">
					{if $smarty.session.step == '01'}
						<p>Здравейте, Вие не сте потвърдили регистрацията си, моля проверете в пощата си за писмо с инструкции за потвърждение на регистрацията си.</p>
						<p>След потвърждаване на регистрацията и преглед на регистрацията от страна на администрацията на сайта, Вие ще можете да взезете в системата.</p>
					{elseif $smarty.session.step == '02'}
						<p>Здравейте, Вашия акаунт все още е в процес на одобрение от администрацията на сайта, моля опитайте да влезете в системата по късно.</p>
					{elseif $smarty.session.step == '03'}
						<p>{$lang.validation.wrong_user_or_pass}</p>
					{/if}
						<div>
							<label for="email">{$lang.user.email}:</label>
							<input type="text" name="email" value="{$smarty.post.email|escape}" />
							<span class="error">{$smarty.session.login_error.email_err}</span>
						</div>
						<div>
							<label for="pass">{$lang.user.password}:</label>
							<input type="password" name="password" value="{$smarty.post.password|escape}" />
							<span class="error">{$smarty.session.login_error.pass_err}</span>
						</div>
						<div>
							<label>&nbsp;</label>
							<button type="submit">{$lang.button.login}</button>
						</div>
						<div>
							<label>&nbsp;</label>
							
					</form>
					<ul class="ul_1" style="margin-left:200px">
						<li style="text-align:left"><a href="{$base_url}?lang_id={$lang_id}&view=user&action=register">{$lang.user.register}</a></li>
					</ul>
					
					
			{/if}
			</div>
		{elseif $action == "new_password"}
			<div class="login_extended contact_form">
				<h1>{$lang.user.new_password}</h1>
				{if $smarty.session.step == '01'}
					<p>Вашата парола е сменена успешно</p>
					<p>Вече можете да влезете в системата с новата си парола</p>
					<p>С най-искрени пожелания, администрация на сайта</p>
				{elseif $smarty.session.step == '02'}
					<p>Възникна грешка при записа на новата ви парола</p>
					<p>За повече информация, моля обърнете се на посочените телефона в контакт секцията на сайта</p>
					<p>С най-искрени пожелания, администрация на сайта</p>
				{else}
					<form action="{$base_url}?lang_id={$lang_id}&view=user&action=new_password" method="post">
					<input style="display:none" type="hidden" name="code" value="{$smarty.post.code|escape}" />
						<div>
							<label for="password">{$lang.user.password}:</label>
							<input type="text" name="password" value="{$smarty.post.password|escape}" />
							<span class="error">{$smarty.session.new_password_error.password_err}</span>
						</div>
						<div>
							<label for="passconf">{$lang.user.passconf}:</label>
							<input type="text" name="passconf" value="{$smarty.post.passconf|escape}" />
							<span class="error">{$smarty.session.new_password_error.passconf_err}</span>
						</div>
						<div>
							<label>&nbsp;</label>
							<button type="submit">{$lang.button.send}</button>
						</div>
					</form>
					<ul class="ul_1" style="margin-left:200px">
						<li style="text-align:left"><a href="{$base_url}?lang_id={$lang_id}&view=user&action=register">{$lang.user.register}</a></li>
					</ul>
				{/if}
			</div>
		
		{elseif $action == "change_password"}
			<div class="login_extended contact_form">
				<h1>{$lang.user.new_password}</h1>
				{if $smarty.session.step == '01'}
					<form action="{$base_url}?lang_id={$lang_id}&view=user&action=new_password&code={$smarty.get.code|escape}" method="post">
					<input style="display:none" type="hidden" name="code" value="{$smarty.get.code|escape}" />
					<input style="display:none" type="hidden" name="code" value="{$smarty.get.code|escape}" />
					<input style="display:none" type="hidden" name="code" value="{$smarty.get.code|escape}" />
						<div>
							<label for="password">{$lang.user.password}:</label>
							<input type="text" name="password" value="{$smarty.post.password|escape}" />
							<span class="error">{$smarty.session.change_password_error.password_err}</span>
						</div>
						<div>
							<label for="passconf">{$lang.user.passconf}:</label>
							<input type="text" name="passconf" value="{$smarty.post.passconf|escape}" />
							<span class="error">{$smarty.session.change_password_error.passconf_err}</span>
						</div>
						<div>
							<label>&nbsp;</label>
							<button type="submit">{$lang.button.send}</button>
						</div>
					</form>
					<ul class="ul_1" style="margin-left:200px">
						<li style="text-align:left"><a href="{$base_url}?lang_id={$lang_id}&view=user&action=register">{$lang.user.register}</a></li>
					</ul>
				{else}
					<p>Вие не трябва да сте на тази страница, един или няколко от задължителните параметри липсват</p>
				{/if}
			</div>
		{elseif $action == "lost_password"}
			<div class="login_extended contact_form">
				<h1>{$lang.user.lost_password}</h1>
				{if $smarty.session.step == '01'}
					<p>Вашата текуща парола бе изтрита.</p>
					<p>На посочения от Вас e-mail адрес бе изпратено писмо с инструкции за въвеждане на нова парола.</p>
				{else}
					<form action="{$base_url}?lang_id={$lang_id}&view=user&action=lost_password" method="post">
					<div>
							<label for="email">{$lang.user.email}:</label>
							<input type="text" name="email" value="{$smarty.post.email|escape}" />
							<span class="error">{$smarty.session.lost_password_error.email_err}</span>
						</div>
						<div>
							<label>&nbsp;</label>
							<button type="submit">{$lang.button.send}</button>
						</div>
					</form>
					<ul class="ul_1" style="margin-left:200px">
						<li style="text-align:left"><a href="{$base_url}?lang_id={$lang_id}&view=user&action=register">{$lang.user.register}</a></li>
					</ul>
				{/if}
			</div>
		{else}
			<div class="register_form">
				<h1>Регистрация</h1>
				{if $smarty.session.step == "step_3"}
					<p>Вие успешно потвърдихте регистрацията си, след проверка от администрацията на сайта, Вашия потребител ще бъде активиран.</p>
					<p>Благодарим Ви предварително.</p>
				{elseif $smarty.session.step == "step_2"}
					<p>Вие успешно се регистрирахте в системата Ни, на Вашия е-mail адресс беше изпратено писмо за потвърждение, моля влезте в пощата си и следвайте инструкциите в писмото за да потвърдите регистрацията си.</p>
					<p>Благодарим Ви предварително</p>
				{else}
					<p>Информация относно регистрацията</p>
					<form action="{$base_url}?view=user&amp;action=register" method="post">
					
					<div>
						<label for="first_name">{$lang.user.first_name}:<sup class="red">*</sup></label>
						<input type="text" name="first_name" id="first_name" value="{$smarty.post.first_name|escape}" />
						<span class="error">{$smarty.session.register_error.first_name_err}</span>
					</div>
					
					<div>
					<label for="last_name">{$lang.user.last_name}:<sup class="red">*</sup></label>
					<input type="text" name="last_name" id="last_name" value="{$smarty.post.last_name|escape}" />
					
						<span class="error">{$smarty.session.register_error.last_name_err}</span>
					
					</div>
					
					<div>
						<label for="phone">{$lang.user.phone}:</label>
						<input type="text" name="phone" id="phone" value="{$smarty.post.phone|escape}" />
					</div>
					
					<div>
						<label for="email">{$lang.user.email}:<sup class="red">*</sup></label>
						<input type="text" name="email" id="email" value="{$smarty.post.email|escape}" />
						{if $smarty.session.register_error.email_err}
							<span class="error">{$smarty.session.register_error.email_err}</span>
						{/if}
					</div>
					
					<div>
						<label for="password">{$lang.user.password}:<sup class="red">*</sup></label>
						<input type="password" name="password" id="password" value="{$smarty.post.password|escape}" />
						{if $smarty.session.register_error.password_err}
							<span class="error">{$smarty.session.register_error.password_err}</span>
						{/if}
					</div>
					
					<div>
						<label for="passconf">{$lang.user.passconf}:<sup class="red">*</sup></label>
						<input type="password" name="passconf" id="passconf" value="{$smarty.post.passconf|escape}" />
						<span class="error">{$smarty.session.register_error.passconf_err}</span>
					</div>
					<div class="clear">
						<label for="code">{$lang.inquiry.code}:<sup class="red">*</sup></label>
						<input type="text" name="code" id="code" value="{$smarty.post.code|escape}" />
						{if $smarty.session.register_error.code_err}
							<span class="error">{$smarty.session.register_error.code_err}</span>
						{/if}
					</div>
					<div class="clear">
						<label for="code">&nbsp;</label>
						<img id="captcha" src="{$base_url}captcha.jpg" alt="-code-" />
						<a href="javascript:media.setImage('captcha','{$base_url}captcha.jpg');">{$lang.captcha.reload_image}</a>
					</div>
					<button type="submit">{$lang.button.register}</button>
					</form>
				{/if}
			</div>
		{/if}
	</td>
</tr>
</table>
</div>
<!-- end of content -->