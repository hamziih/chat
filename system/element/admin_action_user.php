<div class="tab_element sub_list" id="foundaction<?php echo $boom['user_id']; ?>">
	<div class="admin_sm_avatar">
		<img class="admin_user<?php echo $boom['user_id']; ?> avatar_userlist" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="admin_sm_username username <?php echo $boom['user_color']; ?>">
		<?php echo $boom['user_name']; ?>
	</div>
	<div onclick="removeUserAction(this, <?php echo $boom['user_id']; ?>, '<?php echo $boom['type']; ?>');" class="admin_sm_option">
		<i class="fa fa-times edit_btn"></i>
	</div>
</div>