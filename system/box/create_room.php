<?php
require_once('../config_session.php');
if(!allowRoom()){ 
	echo 0;
	die();
}
?>
<div class="pad_box">
	<div class="boom_form">
		<div class="setting_element">
			<p class="label"><?php echo $lang['room_name']; ?></p>
			<input id="set_room_name" class="full_input" type="text" maxlength="<?php echo $data['max_room_name']; ?>" />
		</div>
		<div class="setting_element">
			<p class="label"><?php echo $lang['room_description']; ?></p>
			<input id="set_room_description" class="full_input" type="text" maxlength="200" />
		</div>
		<div class="setting_element">	
			<p class="label"><?php echo $lang['room_type']; ?></p>
			<select  class="select_room"  id="set_room_type">
				<?php echo roomRanking(); ?>
			</select>
		</div>
		<div class="setting_element">
			<p class="label"><?php echo $lang['password']; ?> <span class="small_text theme_color"> <?php echo $lang['optional_pass']; ?></span></p>
			<input id="set_room_password" class="full_input" type="text" maxlength="15"/>
		</div>
	</div>
	<div class="button_half pop_button theme_btn button_left" onclick="addRoom();" id="add_room"><?php echo $lang['create']; ?></div>
	<div class="pop_button cancel_modal button_half default_btn button_right"><?php echo $lang['cancel']; ?></div>
	<div class="clear"></div>
</div>