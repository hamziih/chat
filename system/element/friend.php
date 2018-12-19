<div class="list_element list_item user_lm_box friend_request">
	<div class="user_lm_avatar">
		<img class="avatar_userlist" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="user_lm_data username <?php echo $boom['user_color']; ?>">
		<?php echo $boom["user_name"]; ?>
	</div>
	<div onclick="declineFriend(this, <?php echo $boom['user_id']; ?>);" class="lm_option">
		<button class="reg_button delete_btn"><i class="fa fa-times"></i></button>
	</div>
	<div onclick="addFriend(this, <?php echo $boom['user_id']; ?>, 1);" class="lm_option">
		<button class="reg_button ok_btn"><i class="fa fa-check-circle"></i></button>
	</div>
</div>