	<h2 class="p_h_newsletter">{$lang.poll.poll}</h2>	<div class="static">		{* <h1>{$data->title}</h1> <div>{$poll->content}</div> *}		{if $voted eq 'yes'}			<h2>{$lang.poll.msg.error}</h2>			<p>{$lang.poll.msg.already_voted}</p>		{/if}	</div>	{if $voted != 'yes' }		<!-- poll form -->		<form id="questions_hold" method="post" action="{$full_url}poll/view/{$data->id}" class="p_form p_form_1" style="padding:0">			<input type="hidden" name="posting" value="1" />			{foreach from=$data->question item=question name=question key=key}			{assign var="name" value="answer_`$data->id`_`$question->id`"}			{assign var="err" value="answer_`$data->id`_`$question->id`_error"}			<div>				<!-- question -->				<h3>{$question->title}</h3>				{if $this->validation->$err}					<span class="red"><sup>*</sup> {$lang.poll.msg.please_choose_an_answer}</span>				{/if}				<div style="text-align:left">					{foreach from=$question->answer item=answer}					{assign var="answer_name" value="answer_`$data->id`_`$question->id`"}					{assign var="answer_id" value="answer_`$data->id`_`$question->id`_`$answer->id`"}						<div class="{cycle values="odd,even"}">							<label for="{$answer_id}" style="width:170px;text-align:left;border:none;">								<input 									style="border:none;display:inline;vertical-align:middle" 									class="radio" 									type="radio"									name="{$answer_name}"																		id="{$answer_id}" 									value="{$answer->id}"									{if $smarty.post.$answer_name eq $answer->id}										checked="checked"									{/if}								/>								{$answer->title|escape}							</label>						</div>					{/foreach}				</div>				<!-- end of question -->			</div>			{/foreach}			{include file="poll/form/user_form.tpl"}			<div class="p_data_submit_new clearfix">				<span class="button_1" style="width:100px">					<span class="btn_lbg">						<span class="btn_rbg">							<button type="submit">Изпрати</button>						</span>					</span>				</span>			</div>		</form>		<!-- end of poll form -->	{else}	{/if}