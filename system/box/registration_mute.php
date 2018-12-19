<?php
require_once('../config_session.php');
?>
<div class="pad_box">
	<div class="centered_element vpad15">
		<p class="text_med bold bpad10"><?php echo boomThisText($lang['welcome_reg']); ?></p>
		<p><?php echo boomThisText($lang['reg_mute_text']); ?></p>
	</div>
	<div class="centered_element vpad10">
		<button class="reg_button cancel_modal button_half ok_btn"><i class="fa fa-check"></i> <?php echo $lang['ok']; ?></button>
	</div>
</div>