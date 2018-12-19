<div class="post_element" id="boom_post<?php echo $boom['post_id']; ?>">
	<div class="post_title">
		<div class="post_avatar get_info bcell_mid" data="<?php echo $boom['user_id']; ?>">
			<img class="avatar_post" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
		</div>
		<div class="post_info bcell_mid">
			<p class="username name_ellips <?php echo $boom['user_color']; ?>"><?php echo $boom['user_name']; ?></p>
			<p class="text_xsmall date"><?php echo displayDate($boom['post_date']); ?></p>
		</div>
		<?php if(!notMe($boom['post_user']) || boomAllow(8) && isGreater($boom['user_rank']) || boomAllow(10)){ ?>
			<div class="post_edit delete_wall bcell_mid_center" onclick="deleteWall(<?php echo $boom['post_id']; ?>);"><i class="fa fa-trash"></i></div>
		<?php }else { ?>
			<div class="report_post post_edit bcell_mid_center" onclick="openReport(<?php echo $boom['post_id']; ?>, 2);"><i class="fa fa-flag"></i></div>
		<?php } ?>
	</div>
	<div class="post_content">
		<?php echo boomPostIt($boom['post_content']); ?>
	</div>
	<div class="post_control">
		<div class="like_container">
			<div onclick="likeIt(this,<?php echo $boom['post_id']; ?>);" class="<?php if($boom['liked'] == 1){ echo 'liked'; } ?> like_count">
				<i class="fa fa-thumbs-up"></i><span class="count"> <?php echo $boom['like_count']; ?></span>
			</div>
			<div onclick="unlikeIt(this,<?php echo $boom['post_id']; ?>);" class="<?php if($boom['liked'] == 2){ echo 'unliked'; } ?> unlike_count">
			<i class="fa fa-thumbs-down"></i><span class="count"> <?php echo $boom['unlike_count']; ?></span>
			</div>
		</div>
		<?php if($boom['reply_count'] > 0){ ?>
			<div class="comment_count load_comment" onclick="loadComment(<?php echo $boom['post_id']; ?>,'<?php echo $boom['secret']; ?>');">
				<?php echo $boom['reply_count']; ?> <i class="fa fa-comment"></i>
			</div>
		<?php } ?>
		<?php if(!muted()){ ?>
		<div onclick="doComment(<?php echo $boom['post_id']; ?>)" class="do_comment">
			<i class="fa fa-reply"></i>
		</div>
		<?php } ?>
	</div>
	<div class="add_comment_zone cmb<?php echo $boom['post_id']; ?>">
		<div class="reply_post">
			<?php if(!muted()){ ?>
			<input onkeydown="postReply(event, <?php echo $boom['post_id']; ?>,'<?php echo $boom['secret']; ?>', this);" maxlength="200" placeholder="<?php echo $lang['comment_here']; ?>" class="add_comment full_input">
			<?php } ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="cmtbox cmtbox<?php echo $boom['post_id']; ?>">
	</div>
	<div class="morebox morebox<?php echo $boom['post_id']; ?>">
	</div>
	<div class="clear"></div>
</div>