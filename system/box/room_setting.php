<?php
require_once('../config_session.php');

if(!boomRole(5) && !boomAllow(9)){
	die();
}
$room = roomDetails();
?>
<div class="modal_menu">
	<ul>
		<li class="modal_menu_item modal_selected" onclick="modalZone(this, 'room_setting');"><?php echo $lang['options']; ?></li>
		<?php if(boomAllow(9)){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'room_admin');"><?php echo $lang['admin']; ?></li>
		<?php } ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'room_moderator');"><?php echo $lang['mod']; ?></li>
		<li class="modal_menu_item" onclick="modalZone(this, 'room_muted');"><?php echo $lang['muted']; ?></li>
		<?php if(!isMainRoom()){ ?>
		<li class="modal_menu_item" onclick="modalZone(this, 'room_blocked');"><?php echo $lang['blocked']; ?></li>
		<?php } ?>
	</ul>
</div>
<div class="modal_zone pad_box" id="room_setting">
	<div class="boom_form">
		<?php if(usePlayer()){ ?>
		<div class="chat_settings ">
			<p class="label"><?php echo $lang['default_player']; ?></p>
			<select id="set_room_player">
				<?php echo adminPlayer($room['room_player_id'], 1); ?>
			</select>
		</div>
		<?php } ?>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['room_name']; ?></p>
			<input id="set_room_name" maxlength="30" class="full_input" value="<?php echo $room['room_name']; ?>" type="text"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['room_description']; ?></p>
			<input id="set_room_description" maxlength="120" class="full_input" value="<?php echo $room['description']; ?>" type="text"/>
		</div>
		<div class="chat_settings">
			<p class="label"><?php echo $lang['password']; ?></p>
			<input id="set_room_password" maxlength="30" class="full_input" value="<?php echo $room['password']; ?>" type="text"/>
		</div>
	</div>
	<button type="button" id="save_room" class="reg_button theme_btn"><i class="fa fa-floppy-o"></i> <?php echo $lang['save']; ?></button>
</div>
<?php if(boomAllow(9)){ ?>
<div class="modal_zone  vpad15 hide_zone" id="room_admin"><?php echo getRoomAdmin($data['user_roomid']); ?></div>
<?php } ?>
<div class="modal_zone  vpad15 hide_zone" id="room_moderator"><?php echo getRoomMod($data['user_roomid']); ?></div>
<div class="modal_zone  vpad15 hide_zone" id="room_muted"><?php echo getRoomMuted($data['user_roomid']); ?></div>
<?php if(!isMainRoom()){ ?>
<div class="modal_zone  vpad15 hide_zone" id="room_blocked"><?php echo getRoomBlocked($data['user_roomid']); ?></div>
<?php } ?>