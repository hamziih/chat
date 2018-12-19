<div id="side_content" class="chat_side_panel">
	<div id="side_close" class="panel_top btable">
		<div class="side_close_btn bcell_mid" onclick="closeSide();">
			<i class="fa fa-times"></i>
		</div>
		<div class="side_close_empty bcell_mid">
		</div>
	</div>
	<div id="side_inside">
	</div>
</div>
<div id="small_modal" class="small_modal_out modal_back">
	<div class="small_modal_in modal_in">
		<div class="modal_top">
			<div class="modal_top_empty">
			</div>
			<div class="modal_top_element close_modal">
				<i class="fa fa-times"></i>
			</div>
		</div>
		<div id="small_modal_content" class="modal_content small_modal_content">
		</div>
	</div>
</div>
<div id="large_modal" class="large_modal_out modal_back">
	<div class="large_modal_in modal_in">
		<div id="large_modal_content" class="modal_content large_modal_content">
		</div>
	</div>
</div>
<div class="saved_data"><span class="saved_span"></span></div>
<audio class="hidden" id="private_sound" src="<?php echo $data['domain']; ?>/sounds/private.mp3<?php echo $bbfv; ?>"></audio>
<audio class="hidden" id="message_sound" src="<?php echo $data['domain']; ?>/sounds/new_messages.mp3<?php echo $bbfv; ?>"></audio>
<audio class="hidden" id="username_sound" src="<?php echo $data['domain']; ?>/sounds/username.mp3<?php echo $bbfv; ?>"></audio>
<audio class="hidden" id="whistle_sound" src="<?php echo $data['domain']; ?>/sounds/whistle.mp3<?php echo $bbfv; ?>"></audio>
<audio class="hidden" id="notify_sound" src="<?php echo $data['domain']; ?>/sounds/notify.mp3<?php echo $bbfv; ?>"></audio>
<audio class="hidden" id="news_sound" src="<?php echo $data['domain']; ?>/sounds/new_news.mp3<?php echo $bbfv; ?>"></audio>