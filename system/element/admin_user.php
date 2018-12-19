<div class="tab_element sub_list" id="found<?php echo $boom['user_id']; ?>">
	<div class="admin_sm_avatar">
		<img class="admin_user<?php echo $boom['user_id']; ?> avatar_userlist" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="admin_sm_username username <?php echo $boom['user_color']; ?>">
		<?php echo $boom['user_name']; ?>
	</div>
	<div onclick="getProfile(<?php echo $boom['user_id']; ?>);" class="admin_edit_user admin_sm_option">
		<i class="fa fa-pencil-square edit_btn"></i>
	</div>
	<?php if(boomAllow(10) && notMe($boom['user_id']) && !isBot($boom['user_bot']) && !userOwner($boom)){ ?>
	<div onclick="eraseAccount(<?php echo $boom['user_id']; ?>);" class="admin_sm_option">
		<i class="fa fa-times edit_btn"></i>
	</div>
	<?php } ?>
</div>