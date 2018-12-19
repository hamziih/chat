<?php 
require('../config_session.php');
?>
<div class="pad_box">
	<div class="boom_form">
		<div class="setting_element">
			<p class="label"><?php echo $lang['email']; ?></p>
			<input id="test_email" class="full_input" value="<?php echo $data['user_email']; ?>" type="text"/>
		</div>
	</div>
	<div onclick="testMail();" class="pop_button button_half button_left theme_btn"><i class="fa fa-send"></i> <?php echo $lang['send']; ?></div>
	<div class="pop_button cancel_modal button_half default_btn button_right"><?php echo $lang['cancel']; ?></div>
	<div class="clear"></div>
</div>