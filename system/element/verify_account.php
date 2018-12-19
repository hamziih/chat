<div class="pad_box">
	<div id="not_verify">
		<div class="boom_form">
			<p><?php echo boomThisText($lang['active_message']); ?></p>
		</div>
		<div class="boom_form">
			<input type="text" id="boom_code" placeholder="<?php echo $lang['code']; ?>" class="full_input input_data"/>
		</div>
		<button onclick="validCode(2);" class="reg_button theme_btn"><i class="fa fa-check-circle"></i> <?php echo $lang['verify_account']; ?></button>
		<?php if(okVerify()){ ?>
		<button onclick="verifyAccount();" class="resend_hide reg_button default_btn"><i class="fa fa-envelope-o"></i> <?php echo $lang['resend']; ?></button>
		<?php } ?>
	</div>
	<div id="now_verify" class="hidden">
		<div class="centered_element">
			<div class="boom_form">
				<i class="fa fa-check big_icon bmargin10 success"></i>
				<p><?php echo $lang['verified_now']; ?></p>
			</div>
			<button class="cancel_modal reg_button theme_btn"><?php echo $lang['close']; ?></button>
		</div>
	</div>
</div>