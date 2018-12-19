<?php
require_once('../config_session.php');
if(!boomAllow(10)){
	echo 0;
	die();
}
?>
<?php echo boomTemplate('element/modal_top', $lang['console']); ?>
<div class="pad_box">
	<div class="boom_form">
	<input class="full_input" id="console_content"/>
	</div>
	<button id="send_console" onclick="sendConsole();" class="reg_button theme_btn"><i class="fa fa-check"></i> <?php echo $lang['execute']; ?></button>
	<button class="reg_button cancel_modal default_btn"><?php echo $lang['cancel']; ?></button>
</div>