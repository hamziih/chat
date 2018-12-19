<li  class="other_logs <?php echo $boom['type']; ?>">
	<div class="my_avatar chat_avatar_wrap">
		<img class="avatar_chat" src="<?php echo myavatar($boom['avatar']); ?>"/>
	</div>
	<div class="my_text">
		<p class="username"><?php echo $boom['name']; ?></p>
		<div class="chat_message"><?php echo $boom['content']; ?></div>
		<?php if($boom['delete'] == 1){ ?>
		<span class="special_delete add_cursor" onclick="hideThisPost(this);"><i class="fa fa-times"></i></span>
		<?php } ?>
	</div>
</li>