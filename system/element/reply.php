<div class="comment_reply background_reply">
	<div class="comment_avatar get_info" data="<?php echo $boom['user_id']; ?>">
		<img class="avatar_reply" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="comment_text">
		<span class="m_wall reply_name name_ellips username <?php echo $boom['user_color']; ?>"><?php echo $boom['user_name']; ?></span> <span class="text_xsmall no_break date"><?php echo displayDate($boom['reply_date']); ?></span> 
		<br /><?php echo boomPostIt($boom['reply_content']); ?>
	</div>
</div>