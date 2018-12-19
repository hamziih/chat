<?php
require_once('../config_session.php');
if(!boomAllow(9)){ 
	die(); 
}
?>
<div class="pad_box">
	<div class="boom_form">
		<div class="setting_element">
			<p class="label"><?php echo $lang['username']; ?></p>
			<input id="set_create_name" class="full_input" type="text" maxlength="<?php echo $data['max_username']; ?>" />
		</div>
		<div class="setting_element">
			<p class="label"><?php echo $lang['password']; ?></p>
			<input id="set_create_password" class="full_input" type="text" maxlength="30" />
		</div>
		<div class="setting_element">
			<p class="label"><?php echo $lang['email']; ?></p>
			<input id="set_create_email" class="full_input" type="text" maxlength="80" value="<?php echo 'user_'.lastRecordedId().'@user.com'; ?>"/>
		</div>
		<div class="setting_element">
			<div class="form_split">
				<div class="form_left">
					<p class="label"><?php echo $lang['gender']; ?></p>
					<select id="set_create_gender">
						<?php echo listGender($data['user_sex']); ?>
					</select>
				</div>
				<div class="form_right">
					<p class="label"><?php echo $lang['age']; ?></p>
					<select id="set_create_age">
						<?php echo listAge($data['min_age'], 2); ?>
					</select>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="button_half pop_button theme_btn button_left" onclick="addNewUser();" id="add_new_user"><?php echo $lang['create']; ?></div>
	<div class="pop_button cancel_modal button_half default_btn button_right"><?php echo $lang['cancel']; ?></div>
	<div class="clear"></div>
</div>