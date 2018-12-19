<?php
require_once('../config_session.php');

if(!isset($_POST['account'])){
	die();
}
$account = escape($_POST['account']);
?>
<div class="pad_box">
	<div class="vpad15">
		<p class="centered_element" ><?php echo $lang['want_delete']; ?></p>
	</div>
	<div>
		<div onclick="confirmDelete(<?php echo $account; ?>);" class="pop_button button_half button_left theme_btn"><?php echo $lang['yes']; ?></div>
		<div class="pop_button cancel_modal button_half default_btn button_right"><?php echo $lang['cancel']; ?></div>
		<div class="clear"></div>
	</div>
</div>