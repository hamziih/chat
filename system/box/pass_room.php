<?php
require_once('../config_session.php');

if(!isset($_POST['room_rank'], $_POST['room_id'])){
	die();
}
$ar = escape($_POST['room_rank']);
$rid = escape($_POST['room_id']);
if(!is_numeric($ar) || !is_numeric($rid)){
	die();
}
?>
<div class="pad_box">
	<h2 class="pop_h2 centered_element"><?php echo $lang['enter_password']; ?></h2>
	<div class="boom_form">
		<input id="pass_input" class="input_data" type="password"/>
	</div>
	<button onclick="accessRoom(<?php echo $rid; ?>, <?php echo $ar; ?>);" id="access_room" class="button_left default_btn button_half pop_button"><?php echo $lang['ok']; ?></button>
	<button class="cancel_modal button_half button_right pop_button default_btn"><?php echo $lang['cancel']; ?></button>
	<div class="clear"></div>
</div>