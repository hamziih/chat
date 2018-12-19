<?php
require('../config.php');
if(!allowGuest()){
	die();
}
?>
<div id="guest_form_box" class="pad_box">
	<input id="guest_username" placeholder="<?php echo $lang['username']; ?>"class="user_username input_data" type="text" maxlength="50" name="username" autocomplete="off">
	<?php if(boomRecaptcha()){ ?>
	<div class="recapcha_div tmargin5">
		<div id="boom_recaptcha" class="guest_recaptcha">
		</div>
	</div>
	<?php } ?>
	<div class="login_control">
		<button onclick="sendGuestLogin();" type="button" class="theme_btn full_button intro_btn_pop"><i class="fa fa-sign-in"></i> <?php echo $lang['login']; ?></button>
	</div>
</div>