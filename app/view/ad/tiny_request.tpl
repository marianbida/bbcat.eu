<html><style type="text/css">{literal}p.error {	color:red;	font-size:10px;	margin:0;	padding:0}{/literal}</style><div class="csc-textpic-text"><h2 style="font-size:12px">{$data->title}</h2><table><tr>	<td valign="top">		<img			src="{$base_url}product_images/120x90/{$data->media_list.0->file|default:"no-ad-image-120-90.jpg"}"			alt="{$data->description|strip_tags|escape}"			width="120" height="90"			style="border:4px solid #DCE2F0"		/>	</td>	{if $smarty.session.step eq '01'}		<td valign="top" colspan="2">			<p>Запитването Ви беше получено успешно</p>			<p>Сътрудник на компанията ще се свърже с Вас възможно най-скоро</p>		</td>	{else}		<td valign="top">			<form class="p_form p_form_1" id="login_form" action="{$base_url}item/request/{$data->product_id}/front_request" method="post">			<div class="p_form_row_1 clearfix">				<label for="name">Име, Фамилия:<sup class="red">*</sup></label><br />				<span class="p_text">					<input style="width:220px" type="text" name="name" id="name" size="32" value="{$smarty.post.name|escape}" />					{if $smarty.session.error.name_err}						<p class="error">{$smarty.session.error.name_err}</p>					{/if}				</span>			</div>			<div class="p_form_row_1 clearfix">				<label for="email">E-mail:<sup class="red">*</sup></label><br />				<span class="p_text">					<input style="width:220px" type="email" name="email" id="email" size="32" value="{$smarty.post.email|escape}" />					{if $smarty.session.error.email_err}					<p class="error">{$smarty.session.error.email_err}</p>					{/if}				</span>			</div>			<div class="p_form_row_1 clearfix">				<label for="phone">Телефон:</label>				<span class="p_text">					<input style="width:220px" type="text" name="phone" id="phone" size="32" value="{$smarty.post.phone|escape}" />				</span>			</div>			<div class="p_form_row_2 clearfix">				<label>Тип предприятие:</label>				<div class="clearfix">					<label><input type="checkbox" name="_1"{if $smarty.post._1 eq 'on'} checked="checked"{/if}/></label>					Транспортна Фирма <br />				</div>				<div class="clearfix">					<input type="checkbox" name="_2"{if $smarty.post._2 eq 'on'} checked="checked"{/if}/> Транспортна Фирма със собствен сервиз <br />					<input type="checkbox" name="_3"{if $smarty.post._3 eq 'on'} checked="checked"{/if}/> Сервиз <br />					<input type="checkbox" name="_4"{if $smarty.post._4 eq 'on'} checked="checked"{/if}/> Търговска Фирма
				</div>
			</div>			<table>
			<tr>
				<td>
					<label>Код защита:</label>
					<br clear="all" />
					<span style="padding:4px;height:34px;background:#efefef;display:block;">
						<img src="{$base_url}captcha.jpg" alt="Security Code" />
						<input name="code" size="5" style="font-size:20px; height:34px;" />
					</span>
					{if $smarty.session.error.code_err}
						<p class="error">{$smarty.session.error.code_err}</p>
					{/if}
				</td>
			</tr>
			<tr>
				<td><button type="submit">Изпрати</button></td>
			</tr>
			</table>
			</form>
		</td>
		<td valign="top">
			<strong>Условия</strong>
			<p style="font-size:12px">Запитванията се изпълняват всеки работен ден от 10 до 18 часа.</p>
			<p style="font-size:12px">Всички останали запитвания се изпълняват на следвашия ден.</p>
		</td>
	{/if}
</tr>
</table>
</div>