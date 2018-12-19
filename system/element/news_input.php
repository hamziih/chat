<div class="add_post_container">
	<div id="add_wall_form">
		<div class="post_input_container">
			<textarea onkeyup="textArea(this, 34);" id="news_data" maxlength="3000" spellcheck="false" placeholder="<?php echo $lang['start_new_post']; ?>" class="full_textarea" ></textarea>
			<div id="post_file_data" class="main_post_data" data-key="">
			</div>
		</div>
		<div class="main_post_control">
			<div class="main_post_item">
				<i class="fa fa-image"></i>
				<input id="news_file" onchange="uploadNews();" type="file"/>
			</div>
			<div class="main_post_button">
				<button onclick="sendNews();" class="reg_button theme_btn"><i class="fa fa-send"></i> <?php echo $lang['post']; ?></button>
			</div>
		</div>
	</div>
</div>