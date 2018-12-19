<?php
require_once('../config_session.php');
?>
<div class="pad_box">
	<input id="new_verification_email" class="input_data" type="text" value="<?php echo $data['user_email']; ?>"/>
	<button onclick="saveNewEmail()" class="button_left theme_btn full_button pop_button"><?php echo $lang['save']; ?></button>
	<div class="clear"></div>
</div>