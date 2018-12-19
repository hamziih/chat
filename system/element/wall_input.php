<div class="add_post_container">
	<div id="add_wall_form">
		<div class="post_input_container">
			<textarea onkeyup="textArea(this, 34);" id="friend_post" spellcheck="false" maxlength="500" placeholder="<?php echo $lang['start_new_post']; ?>" class="full_textarea" ></textarea>
			<div id="post_file_data" class="main_post_data" data-key="">
			</div>
		</div>
		<div class="main_post_control">
			<?php if(boomAllow($data['allow_image'])){ ?>
			<div class="main_post_item">
				<i class="fa fa-image"></i>
				<input id="wall_file" onchange="uploadWall();" type="file"/>
			</div>
			<?php } ?>
			<div class="main_post_button">
				<button onclick="postWall();" class="reg_button theme_btn"><i class="fa fa-send"></i> <?php echo $lang['post']; ?></button>
			</div>
		</div>
	</div>
</div>