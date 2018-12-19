<div class="ulist_square list_element">
		<div class="ulist_avatar">
			<img class="avatar_friends lazyboom get_info" data="<?php echo $boom['user_id'];?>" src="" data-img="<?php echo myavatar($boom['user_tumb']); ?>"/>
		</div>
		<div class="ulist_name">
			<p class="username <?php echo $boom['user_color']; ?>"><?php echo $boom['user_name']; ?></p>
		</div>
		<div class="ulist_del" onclick="removeFriend(this, <?php echo $boom['user_id']; ?>);">
			<i class="fa fa-times"></i>
		</div>
</div>