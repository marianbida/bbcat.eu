<form id="login_form" action="{$base_url}login" method="post" class="p_form p_form_1">
	<div class="p_form_row_1 clearfix">
		<label for="username">Потребителско име:</label>
		<span class="p_text width_3">
			<input class="p_text" type="text" name="username" id="username" />
		</span>
		<sup class="red">*</sup>
	</div>
	<div class="p_form_row_1 clearfix">
		<label for="password">Парола:</label>
		<span class="p_text width_3">
			<input class="p_text" type="password" name="password" id="password" />
		</span>
		<sup class="red">*</sup>
	</div>
	<div class="p_data_submit_new clearfix">
				<span class="button_1" style="width:100px">
					<span class="btn_lbg">
						<span class="btn_rbg">
							<button type="submit">Вход</button>
						</span>
					</span>
				</span>
			</div>
</form>
<div class="clearfix">
	<ul>
		<li><a href="{$base_url}register">Регистрация</a></li>
		<li><a href="{$base_url}recovery">Забравена парола</a></li>
	</ul>
</div>