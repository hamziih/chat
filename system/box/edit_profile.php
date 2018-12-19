<?php
require('../config_session.php');
?>
<div class="modal_wrap_top modal_top">
	<div class="my_profile_top">
		<div id="proav" class="profile_avatar" data="<?php echo $data['user_tumb']; ?>" >
			<div class="avatar_spin">
				<img class="fancybox avatar_profile" <?php echo profileAvatar($data['user_tumb']); ?>/>
			</div>
			<?php if(boomAllow($data['allow_avatar'])){ ?>
			<div class="avatar_control olay">
				<div class="set_button full_button avatar_button" onclick="deleteAvatar();" id="delete_avatar"><i class="fa fa-times"></i></div>
				<div id="avatarupload" class="avatar_button">
					<form id="avatar_form" action="system/avatar.php" method="post" enctype="multipart/form-data">
						<div class="set_button choose_avatar full_button">
							<span><i class="fa fa-camera"></i></span>
							<input class="upload avatar_select" type="file" name="file" id="avatar_image">
						</div>
						<input type="hidden" value="<?php echo setToken(); ?>" name="token"> 
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="my_profile_name">
			<div class="my_name">
				<?php if(boomAllow($data['allow_name'])){ ?> 
				<i onclick="changeUsername();" class="fa fa-edit"></i>
				<?php } ?>
				<?php echo $data['user_name']; ?>
			</div>
		</div>
	</div>
	<div class="cancel_modal profile_close">
		<i class="fa fa-times"></i>
	</div>
</div>
<div class="modal_menu">
	<ul>
		<?php if(guestCanRegister()){ ?>
		<li class="modal_menu_item reg_guest ok_btn" onclick="modalZone(this, 'guest_register');"><i class="fa fa-edit"></i> <?php echo $lang['register']; ?></li>
		<?php } ?>
		<li class="modal_menu_item modal_selected" onclick="modalZone(this, 'personal_info');"><?php echo $lang['main_info']; ?></li>
		<li class="modal_menu_item" onclick="modalZone(this, 'personal_about');"><?php echo $lang['about_me']; ?></li>
		<?php if(boomAllow(1)){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'personal_password');"><?php echo $lang['password']; ?></li>
		<li class="modal_menu_item" onclick="modalZone(this, 'personal_friends');"><?php echo $lang['friends']; ?></li>
		<?php } ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'personal_ignores');"><?php echo $lang['ignore_list']; ?></li>
		<li class="modal_menu_item" onclick="modalZone(this, 'personal_options');"><?php echo $lang['options']; ?></li>
	</ul>
</div>
<div class="modal_zone pad_box" id="personal_info">
	<div class="boom_form">
		<div class="form_split">
			<div class="form_left">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['age']; ?></p>
					<select id="set_profile_age">
						<?php echo listAge($data['user_age'], 2); ?>
					</select>
				</div>
			</div>
			<div class="form_right">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['gender']; ?></p>
					<select id="set_profile_gender">
						<?php echo listGender($data['user_sex']); ?>
					</select>
				</div>
			</div>
		</div>
		<div class="form_split">
			<div class="form_left_full">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['country']; ?></p>
					<select id="set_profile_country">
						<?php echo listCountry($data['country'], 2); ?>
					</select>
				</div>
			</div>
			<div class="form_right_full">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['region']; ?></p>
					<div id="region_profile">
						<select id="set_profile_region">
							<?php echo profileRegion(); ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="form_split">
			<div class="chat_settings">
				<p class="label"><?php echo $lang['email']; ?></p>
				<input id="set_profile_email" maxlength="80" class="full_input" value="<?php echo $data['user_email']; ?>" type="text"/>
			</div>
		</div>
	</div>
	<button type="button" onclick="saveProfile()" id="save_profile" class="reg_button theme_btn"><i class="fa fa-floppy-o"></i> <?php echo $lang['save']; ?></button>
	<?php if($data['verified'] == 0 && canVerify()){ ?>
	<button type="button" onclick="openVerify();" class="ok_btn reg_button"><i class="fa fa-check-circle"></i> <?php echo $lang['verify_account']; ?></button>
	<?php } ?>
</div>
<div class="modal_zone  pad_box hide_zone" id="personal_about">
	<div class="form_split">
		<?php if(boomAllow($data['allow_mood'])){ ?>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['mood']; ?></p>
			<input id="set_mood" maxlength="30" class="full_input" value="<?php echo $data['user_mood']; ?>" autocomplete="off" type="text"/>
		</div>
		<?php } ?>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['about_me']; ?></p>
			<textarea id="set_user_about" class="large_textarea about_area full_textarea" spellcheck="false" maxlength="800" ><?php echo $data['user_about']; ?></textarea>
		</div>
	</div>
	<button type="button" onclick="saveAbout()"id="save_about" class="reg_button theme_btn"><i class="fa fa-floppy-o"></i> <?php echo $lang['save']; ?></button>
</div>
<?php if(guestCanRegister()){ ?>
<div class="modal_zone  pad_box hide_zone" id="guest_register">
	<div class="boom_form">
		<div class="chat_settings">
			<p class="label"><?php echo $lang['username']; ?></p>
			<input type="text" <?php if(validate_name($data['user_name'])){ echo ' value="' . $data['user_name'] . '" '; } ?> id="new_guest_name" placeholder="<?php echo $lang['username']; ?>" class="full_input"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['password']; ?></p>
			<input type="text" id="new_guest_password" placeholder="<?php echo $lang['password']; ?>" class="full_input"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['email']; ?></p>
			<input type="text" id="new_guest_email" placeholder="<?php echo $lang['email']; ?>" class="full_input"/>
		</div>
	</div>
	<button onclick="registerGuest();" class="reg_button theme_btn"><i class="fa fa-edit"></i> <?php echo $lang['register']; ?></button>
</div>
<?php } ?>
<div class="modal_zone  vpad15 hide_zone" id="personal_friends">
	<?php echo myFriend(); ?>
	<div class="clear"></div>
</div>
<div class="modal_zone vpad15 hide_zone" id="personal_ignores">
	<?php echo myIgnore(); ?>
	<div class="clear"></div>
</div>
<div class="modal_zone  pad_box hide_zone" id="personal_options">
	<div class="boom_form">
		<div class="form_split">
			<div class="form_left">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['language']; ?></p>
					<select onchange="setUserLang();" id="set_profile_language">
						<?php echo listLanguage($data['user_language'], 1); ?>
					</select>
				</div>
			</div>
			<div class="form_right">
				<div class="chat_settings ">
					<p class="label"><?php echo $lang['sounds']; ?></p>
					<select id="set_sound" onchange="setUserSound(this);">
						<option <?php echo selCurrent($data['user_sound'], 0); ?> value="0"><?php echo $lang['no_sound']; ?></option>
						<option <?php echo selCurrent($data['user_sound'], 1); ?> value="1"><?php echo $lang['private_sound']; ?></option>
						<option <?php echo selCurrent($data['user_sound'], 2); ?> value="2"><?php echo $lang['all_sound']; ?></option>
					</select>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="chat_settings ">
			<p class="label"><?php echo $lang['timezone']; ?></p>
			<select onchange="setUserTime();" id="set_user_timezone">
				<?php echo getTimezone($data['user_timezone']); ?>
			</select>
		</div>
		<?php if(boomAllow($data['allow_theme'])){ ?>
		<div class="chat_settings ">
			<p class="label"><?php echo $lang['user_theme']; ?></p>
			<select id="set_user_theme" onchange="setUserTheme(this);">
				<?php echo listTheme($data['user_theme'], 2); ?>
			</select>
		</div>
		<?php } ?>
		<?php if(!isStaff($data['user_rank']) && !isGuest($data['user_rank'])){?>
		<div class="chat_settings ">
			<p class="label"><?php echo $lang['private_mode']; ?></p>
			<select onchange="setPrivateMode(this);" id="set_private_mode">
				<option <?php echo selCurrent($data['user_private'], 1); ?> value="1"><?php echo $lang['on']; ?></option>
				<option <?php echo selCurrent($data['user_private'], 2); ?> value="2"><?php echo $lang['friend_only']; ?></option>
				<option <?php echo selCurrent($data['user_private'], 0); ?> value="0"><?php echo $lang['off']; ?></option>
			</select>
		</div>
		<?php } ?>
	</div>
	<?php if(boomAllow($data['allow_name_color'])){ ?>
	<div class="boom_form user_edit_color">
		<p class="label"><?php echo $lang['user_color']; ?></p>
		<div class="my_name_color" data="<?php echo $data['user_color']; ?>">
			<?php echo colorChoice($data['user_color'], 3); ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>
<div class="modal_zone  pad_box hide_zone" id="personal_password">
	<div class="boom_form">
		<div class="chat_settings">
			<p class="label"><?php echo $lang['actual_pass']; ?></p>
			<input id="set_actual_pass" class="full_input" maxlength="30" type="password"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['new_pass']; ?></p>
			<input id="set_new_pass" class="full_input"  maxlength="30" type="password"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['repeat_pass']; ?></p>
			<input id="set_repeat_pass" class="full_input" maxlength="30" type="password"/>
		</div>
	</div>
	<button type="button" id="change_password" class="reg_button theme_btn"><i class="fa fa-floppy-o"></i> <?php echo $lang['save']; ?></button>
</div>