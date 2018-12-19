<div class="out_page_container">
	<div class="out_page_content">
		<div class="out_page_box">
			<div class="pad_box">
				<i class="fa fa-envelope-o big_icon bmargin10"></i>
				<p class="centered_element text_med"><?php echo boomThisText($lang['active_message']); ?></p>
				<div class="boom_form vmargin15">
					<input type="text" id="boom_code" placeholder="<?php echo $lang['code']; ?>" class="full_input centered_element input_data sub_input large_input"/>
				</div>
				<button onclick="validCode(1);" class="intro_btn theme_btn"><i class="fa fa-paper-plane"></i> <?php echo $lang['verify_account']; ?></button><br/>
				<?php if(okVerify()){ ?>
				<button onclick="verifyAccount();" class="resend_hide small_intro_btn default_btn"><i class="fa fa-edit"></i> <?php echo $lang['resend']; ?></button>
				<?php } ?>
				<p onclick="openLogout();" class="link_like tmargin5 add_cursor" ><?php echo $lang['logout']; ?></p>
			</div>
		</div>
	</div>
</div>