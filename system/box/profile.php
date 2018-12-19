<?php
require('../config_session.php');

if(!isset($_POST['get_profile'], $_POST['cp'])){
	die();
}
$id = escape($_POST['get_profile']);
$cur_page = escape($_POST['cp']);
$user = userRoomDetails($id);
if(empty($user)){
	echo 2;
	die();
}
?>
<div class="modal_wrap_top modal_top">
	<div class="my_profile_top">
		<div id="proav" class="profile_avatar" data="<?php echo $user['user_tumb']; ?>" >
			<div class="avatar_spin">
				<img class="fancybox avatar_profile" <?php echo profileAvatar($user['user_tumb']); ?>/>
			</div>
		</div>
		<div class="my_profile_name">
			<div class="p_data">
				<?php if(userVerified($user['verified']) && !isGuest($user['user_rank'])){ ?>
				<div class="p_item" title="<?php echo $lang['verified']; ?>" >
					<i class="fa fa-check success"></i>
				</div>
				<?php } ?>
				<?php if(isMuted($user) != ''){?>
				<div class="p_item" title="<?php echo $lang['verified']; ?>" >
					<?php echo isMuted($user); ?>
				</div>
				<?php } ?>
				<div class="p_item">
					<?php echo rankIcon($user); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="my_name">
				<?php echo $user['user_name']; ?>
			</div>
			<?php if(!empty($user['user_mood'])){ ?>
				<div class="my_mood">
					<p class="bellips text_small"><?php echo $user['user_mood']; ?></p>
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
		<li class="modal_menu_item modal_selected" onclick="modalZone(this, 'profile_info');"><?php echo $lang['main_info']; ?></li>
		<?php if($user['user_about'] != ''){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'profile_about');"><?php echo $lang['about_me']; ?></li>
		<?php } ?>
		<?php if(!isGuest($user['user_rank']) && !isBot($user['user_bot'])){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'profile_friends');"><?php echo $lang['friends']; ?></li>
		<?php } ?>
		<?php if(!isBot($user['user_bot']) && ( canRoomAction($user) || canEditUser($user, 8))){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'room_actions');"><?php echo $lang['do_action']; ?></li>
		<?php } ?>
		<?php if(canEditUser($user, 9)){ ?>
		<li class="modal_menu_item" onclick="editUser(<?php echo $user['user_id']; ?>);""><?php echo $lang['edit']; ?></li>
		<?php } ?>
	</ul>
</div>
<div class="pro_zone">
	<div class="modal_zone pad_box" id="profile_info">
		<?php if(boomAge($user['user_age'])){ ?>
		<p class="list_element info_pro"><span class="bold"><?php echo $lang['age']; ?> : </span> <?php echo getUserAge($user['user_age']); ?></p>
		<?php } ?>
		<?php if(boomSex($user['user_sex'])){ ?>
		<p class="list_element info_pro"><span class="bold"><?php echo $lang['gender']; ?> : </span> <?php echo getGender($user['user_sex']); ?></p>
		<?php } ?>
		<?php if(boomLocation($user)){ ?>
		<p class="list_element info_pro"><span class="bold"><?php echo $lang['location']; ?> : </span> <?php echo userLocation($user); ?></p>
		<?php } ?>
		<?php if(userVisible($user['user_status'])){ ?>
		<p class="list_element info_pro"><span class="bold"><?php echo $lang['last_seen']; ?> : </span> <?php echo displayDate($user['last_action']); ?></p>
		<?php } ?>
		<p class="list_element info_pro"><span class="bold"><?php echo $lang['join_chat']; ?> : </span> <?php echo longDate($user['user_join']); ?></p>
		<?php if(boomAllow(10) && !isBot($user['user_bot'])){ ?>
			<p class="list_element info_pro"><span class="bold"><?php echo $lang['email']; ?> :</span> <?php echo $user['user_email']; ?></p>
			<p class="list_element info_pro"><span class="bold"><?php echo $lang['ip']; ?> :</span> <?php echo $user['user_ip']; ?></p>
		<?php } ?>
		<?php if(boomAllow(8) && isGreater($user['user_rank']) || isOwner()){ ?>
			<p class="list_element info_pro"><span class="bold"><?php echo $lang['other_account']; ?> :</span> <?php echo sameAccount($user); ?></p>
		<?php } ?>
		<div class="paction">
			<?php if($user['my_friend'] == 0 && !isBot($user['user_bot']) && notMe($user['user_id']) && !isGuest($user['user_rank']) && boomAllow(1) && $user['ignored'] == 0 ){ ?>
				<button id="profriend" onclick="addFriend(this, <?php echo $user['user_id']; ?>);" class="pact_btn reg_button ok_btn"><i class="fa fa-user-plus"></i> <?php echo $lang['add_friend']; ?></button>
			<?php } ?>
			<?php if(!isBot($user['user_bot']) && notMe($user['user_id']) && $user['ignored'] == 0 && !isStaff($user['user_rank'])){ ?>
				<button id="proignore" onclick="ignoreUser(this, <?php echo $user['user_id']; ?>);" class="pact_btn reg_button delete_btn"><i class="fa fa-ban"></i> <?php echo $lang['ignore']; ?></button>
			<?php } ?>
		</div>
	</div>
	<?php if($user['user_about'] != ''){ ?>
	<div class="hide_zone  pad_box modal_zone" id="profile_about">
		<p><?php echo $user['user_about']; ?></p>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if(!isGuest($user['user_rank']) && !isBot($user['user_bot'])){ ?>
	<div class="hide_zone  pad_box modal_zone" id="profile_friends">
		<?php echo findFriend($user); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php if(canRoomAction($user) || canEditUser($user, 8)){ ?>
	<div class="hide_zone modal_zone pad_box" id="room_actions">
		<?php if(canEditUser($user, 8)){ ?>
			<?php if(!isBot($user['user_bot'])){ ?>
			<p class="text_med vpad10 theme_color"><?php echo $lang['main_action']; ?></p>
			<div class="bmargin15">
				<p class="label"><?php echo $lang['do_action']; ?></p>
				<div class="edit_verify ">
					<select id="set_user_action" onchange="takeAction(this, <?php echo $user['user_id']; ?>);">
						<?php echo listAction($user); ?>
					</select>
				</div>
			</div>
			<?php } ?>
			<div class="clear"></div>
		<?php } ?>
		<?php if(canRoomAction($user) && insideChat($cur_page)){ ?>
			<p class="text_med vpad10 theme_color"><?php echo $lang['room_action']; ?></p>
			<?php if(boomRole(5) || boomAllow(9)){ ?>
			<div class="bmargin15">
				<div class="">
					<p class="label"><?php echo $lang['user_rank']; ?></p>
					<select id="room_ranking" onchange="changeRoomRank(this, <?php echo $user['user_id']; ?>);">
						<?php echo changeRoomRank($user['room_ranking']); ?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
			<div class="bmargin15">
				<p class="label"><?php echo $lang['do_action']; ?></p>
				<div class="">
					<select id="set_room_action" onchange="takeAction(this, <?php echo $user['user_id']; ?>);">
						<?php echo listRoomAction($user); ?>
					</select>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>