<?php 
require('../config_session.php');
if(!isset($_POST['edit_user']) || !boomAllow(9)){
	die();
}
$result = '';
$target = escape($_POST['edit_user']);
$user = userDetails($target);
if(!isGreater($user['user_rank']) && notMe($user['user_id'])){
	echo 99;
	die();
}
if(isBot($user['user_bot']) && !isOwner()){
	echo 99;
	die();
}

?>
<div class="modal_wrap_top modal_top">
	<div class="admin_profile_top">
		<div class="profile_avatar" data="<?php echo $user['user_tumb']; ?>" >
			<div class="avatar_spin">
				<img class="fancybox avatar_profile" <?php echo profileAvatar($user['user_tumb']); ?>/>
			</div>
			<?php 
			if(canModifyAvatar($user)){ ?>
			<div class="avatar_control olay">
				<div class="set_button full_button avatar_button" onclick="adminRemoveAvatar(<?php echo $user['user_id']; ?>);">
					<i class="fa fa-times"></i>
				</div>
				<div id="avatarupload" class="avatar_button">
					<form id="admin_avatar_form" action="system/avatar_admin.php" method="post" enctype="multipart/form-data">
						<div class="set_button choose_avatar full_button">
							<span><i class="fa fa-camera"></i></span>
							<input class="upload avatar_select" type="file" name="file" id="admin_avatar_image">
						</div>
						<input type="hidden" value="<?php echo setToken(); ?>" name="token">
						<input id="this_admin_avatar" type="hidden" value="<?php echo $user['user_id']; ?>" name="avatar_target">
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="my_profile_name">
			<div class="p_data">
				<div class="p_item">
					<?php echo rankIcon($user); ?>
				</div>
				<?php if(userVerified($user['verified'])){ ?>
				<div class="p_item" title="<?php echo $lang['verified']; ?>" >
					<i class="fa fa-check success"></i>
				</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			<div class="my_name">
				<?php if(boomAllow($data['allow_name']) && canEditUser($user, 9)){ ?> 
				<i onclick="adminChangeName(<?php echo $user['user_id']; ?>);" class="fa fa-edit"></i>
				<?php } ?>
				<?php echo $user['user_name']; ?>
			</div>
			<?php if(boomAllow($data['allow_mood']) && !empty($user['user_mood'])){ ?>
				<div class="my_mood_admin">
					<p id="admin_mood" class="bellips text_small"><i class="fa fa-times text_med" onclick="clearUserMood(<?php echo $user['user_id']; ?>);"></i> <?php echo $user['user_mood']; ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="cancel_modal profile_close">
		<i class="fa fa-times"></i>
	</div>
</div>
<div class="modal_menu">
	<ul>
		<li class="modal_menu_item modal_selected" onclick="modalZone(this, 'admin_pro_details');"><?php echo $lang['options']; ?></li>
		<li class="modal_menu_item" onclick="modalZone(this, 'admin_pro_email');"><?php echo $lang['email']; ?></li>
		<li class="modal_menu_item" onclick="getProfile(<?php echo $user['user_id']; ?>);"><?php echo $lang['back']; ?></li>
	</ul>
</div>
<div class="modal_zone  pad_box" id="admin_pro_details">
	<div class="boom_form">
		<?php if(!isGuest($user['user_rank'])){ ?>
		<div class="bmargin15">
			<div class="">
				<p class="label"><?php echo $lang['user_rank']; ?></p>
				<select id="profile_rank" onchange="changeRank(this, <?php echo $user['user_id']; ?>);">
					<?php echo changeRank($user['user_rank']); ?>
				</select>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<?php if(boomAllow($data['allow_name_color'])){ ?>
		<div class="bmargin15">
			<p class="label"><?php echo $lang['user_color']; ?></p>
			<div class="user_color" data-u="<?php echo $user['user_id']; ?>" data="<?php echo $user['user_color']; ?>">
				<?php echo colorChoice($user['user_color'], 1); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="modal_zone  pad_box hide_zone" id="admin_pro_email">
	<div class="boom_form">
		<div class="setting_element">
			<p class="label"><?php echo $lang['email']; ?></p>
			<input id="set_user_email" class="full_input" value="<?php echo $user['user_email']; ?>" type="text"/>
		</div>
	</div>
	<button onclick="saveThisUser(<?php echo $user['user_id']; ?>);" type="button" class="save_admin reg_button theme_btn"><?php echo $lang['save']; ?></button>
</div>