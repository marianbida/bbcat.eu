	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<!-- right column -->
			<div class="s_col_960 s_pl_10">
				<div id="hotel" class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<h1>{$data->first_name} {$data->last_name} | {$lang.user.cabinet}</h1>
					<div class="s_box_1_content clear">
						<!-- tab holder -->
						<div class="s_tabs clearfix">
							<ul class="tabs_2_nav">
								<li><a href="#tab1">{$lang.user.reservations}</a></li>
								<li><a href="#profile_hotel_list">{$lang.user.hotels}</a></li>
								<li><a href="#profile_stat">{$lang.user.stat}</a></li>
								<li><a href="#tab4">{$lang.user.profile}</a></li>
							</ul>
							<div id="tab1" class="s_tab_box clearfix">
								<p>-na-</p>
							</div>
							<div id="profile_hotel_list" class="s_tab_box">
								{foreach from=$user_hotel_list item=o}
								<div class="clearfix">
									<p>{$o->title}</p>
								</div>
								{/foreach}
							</div>
							<div id="profile_stat" class="s_tab_box">
								<div class="s_tabs clearfix">
									<ul class="tabs_2_nav">
										<li><a href="#tab3_1">{$lang.user.visits}</a></li>
										<li><a href="#tab3_2">{$lang.user.common}</a></li>
									</ul>
									<div id="tab3_1" class="s_tab_box clearfix">
										<p>-na-</p>
									</div>
									<div id="tab3_2" class="s_tab_box">
										<p>-na-</p>
									</div>
								</div>
							</div>
							<div id="tab4" class="s_tab_box">
								<div class="s_tabs clearfix">
									<ul class="tabs_2_nav">
										<li><a href="#tab4_1">{$lang.user.personal}</a></li>
										<li><a href="#tab4_2">{$lang.user.account}</a></li>
										<li><a href="#tab4_3">{$lang.user.password}</a></li>
										<li><a href="#tab4_4">{$lang.user.history}</a></li>
									</ul>
									<div id="tab4_1" class="s_tab_box clearfix">
										<form action="{$full_url}profile/editpersonalinfo" method="post" class="form_2">
										
										<div class="form_row_2 clearfix">
											<label for="first_name">Име:</label>
											<input class="text s_w_200" type="text" name="first_name" id="first_name" value="{$data->first_name|escape}" />
										</div>
										<div class="form_row_2 clearfix">
											<label for="last_name">Фамилия:</label>
											<input type="text" name="last_name" id="last_name" value="{$data->last_name|escape}" class="text s_w_200" />
										</div>
										<div class="form_row_2 clearfix">
											<label for="company">Фирма:</label>
											<input type="text" name="company" id="company" value="{$data->company|escape}" class="text s_w_200" />
										</div>
										<div class="form_row_2 clearfix">
											<label for="company_var">ЕИК:</label>
											<input type="text" name="company_vat" id="company_vat" value="{$data->company_vat|escape}" class="text s_w_200" />
										</div>
										<div class="form_row_2 clearfix">
											<label for="phone">Телефон:</label>
											<input class="text s_w_200" type="text" name="phone" id="phone" value="{$data->phone|escape}" />
										</div>
										<div class="data_submit_2 clearfix">
											<span class="s_button_2 s_button_2_bordo">
												<button type="submit">{$lang.button.save}</button>
											</span>
										</div>
										</form>
									</div>
									<div id="tab4_2" class="s_tab_box">
										<form action="{$base_url}profile/editaccount" method="post" class="form_2">
											<div class="form_row_2 clearfix">
												<label for="username">{$lang.user.user}:</label>
												<input type="text" class="text s_w_200" name="username" id="username" value="{$data->username|escape}" />
											</div>
											<div class="form_row_2 clearfix">
												<label for="email">{$lang.user.email}:</label>
												<input class="text s_w_200" type="text" name="email" id="email" value="{$data->email|escape}" />
											</div>
											<div class="data_submit_2 clearfix">
												<span class="s_button_2 s_button_2_bordo">
													<button type="submit">{$lang.button.save}</button>
												</span>
											</div>
										</form>
									</div>
									<div id="tab4_3" class="s_tab_box">
										<form action="{$base_url}profile/editpassword" method="post" class="form_2">
										<div class="form_row_2 clearfix">
											<label for="password">{$lang.user.password}:</label>
											<input class="text s_w_200" type="text" name="password" id="password" />
										</div>
										<div class="form_row_2 clearfix">
											<label for="passconf">{$lang.user.confirm}:</label>
											<input class="text s_w_200" type="text" name="passconf" id="passconf" />
										</div>
										<div class="data_submit_2 clearfix">
											<span class="s_button_2 s_button_2_bordo">
												<button type="submit">{$lang.button.save}</button>
											</span>
										</div>
										</form>
									</div>
									<div id="tab4_4" class="s_tab_box">
										<table>
										<tr>
											<th>Действие</th>
											<th>Дата</th>
										</tr>
										{foreach from=$profile_log item=v}
										<tr>
											<td>{$v->event}</th>
											<td>{$v->timestamp|date_format}</th>
										</tr>
										{/foreach}
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- end of tab holder -->
					</div>
					<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
				</div>
			</div>
			<!-- end of right column -->
			<span class="clear"></span>
		</div>
	</div>
	<!-- end of content -->