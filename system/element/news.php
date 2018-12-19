<?php
$unseen = '';
if($boom['news_date'] > $data['user_news']){
	$unseen = '	<span class="new_news bnotify">' . $lang['new'] . '</span>';
}
?>
<div class="news_box news_element">
	<div class="post_title">
		<div class="post_avatar get_info bcell_mid" data="<?php echo $boom['user_id']; ?>">
			<img class="avatar_post" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
		</div>
		<div class="post_info bcell_mid">
			<p class="username name_ellips <?php echo $boom['user_color']; ?>"><?php echo $boom['user_name']; ?></p>
			<p class="text_xsmall date"><?php echo displayDate($boom['news_date']); ?><?php echo $unseen; ?></p>
		</div>
		<?php if(boomAllow(10)){ ?>
			<div onclick="deleteNews(this,<?php echo $boom['id']; ?>);" class="post_edit bcell_mid_center"><i class="fa fa-trash"></i></div>
		<?php } ?>
	</div>
	<div class="post_content">
		<?php echo boomPostIt($boom['news_message']); ?>
	</div>
</div>