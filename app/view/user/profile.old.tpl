	<!-- content -->
	<div id="content_outer">
		<div id="content_inner" class="clearfix">
			<!-- right column -->
			<div class="s_col_630">
				<div class="s_box_1">
					<span class="s_b1_top_left"><span class="s_b1_top_right"></span></span>
					<div class="s_box_1_content clear">
						<h2>{$data->first_name} {$data->last_name} | Личен кабинет</h2>
						
						<div>
							<div class="even">
								
							</div>
						</div>
				</div>
				
				<div class="odd">
					
				</div>
				
				
				
				<div class="even">
					
				</div>
			</div>
			
		<div>
			<h2>Хотели <a href="{$full_url}hotel/add">+</a></h2>
			<div class="clearfix" style="padding-left:8px">
				{foreach from=$data->hotel_list item=item}
					<div style="padding-left:4px" class="{cycle values="odd,even"}">
						<p><strong>{$item->city}</strong></p>
						<p>{$item->address}</p>
						<p><a href="{$base_url}profile/remove_address/{$item->id}">изтрий</a></p>
					</div>
				{foreachelse}
					<div>Вие нямате хотели в своя портфеил.</div>
				{/foreach}
			</div>
		</div>
		
					</div>
				<span class="s_b1_bottom_left"><span class="s_b1_bottom_right"></span></span>
			</div>
		</div>
		<!-- end of right column -->
		<span class="clear"></span>
	</div>
</div>
<!--/ content -->