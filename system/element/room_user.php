<div class="list_element list_item user_lm_box">
	<div class="user_lm_avatar">
		<img class="avatar_userlist" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="user_lm_data username">
		<?php echo $boom["user_name"]; ?>
	</div>
	<div data="<?php echo $boom['user_id']; ?>" class="lm_option <?php echo $boom['action']; ?>">
		<i class="fa fa-times"></i>
	</div>
</div>