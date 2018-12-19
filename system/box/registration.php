<?php 
require('../config.php'); 
?>
<div id="registration_form_box" class="pad_box">
	<p class="login_title"><?php echo $lang['register']; ?></p>
	<input spellcheck="false" id="reg_username" placeholder="<?php echo $lang['username']; ?>" class="input_data" type="text" maxlength="<?php echo $data['max_username']; ?>" autocomplete="off">
	<input type="text" style="display:none">
	<input type="password" style="display:none">
	<input spellcheck="false" id="reg_password" placeholder="<?php echo $lang['password']; ?>" class="input_data" maxlength="30" type="password" autocomplete="off">
	<input spellcheck="false" id="reg_email" placeholder="<?php echo $lang['email']; ?>" class="input_data" maxlength="80" type="text" autocomplete="off">
	<div class="form_split register_options">
		<div class="form_left large_select">
			<select id="login_select_gender" class="login_select">
				<?php echo listGender(1); ?>
			</select>
		</div>
		<div class="form_right large_select">
			<select size="1" id="login_select_age" class="login_select">
				<?php
					echo listAge('', 1);
				?>
			</select>
		</div>
	</div>
	<div class="clear"></div>
	<?php if(boomRecaptcha()){ ?>
	<div class="recapcha_div tmargin10">
		<div id="boom_recaptcha" class="register_recaptcha">
		</div>
	</div>
	<?php } ?>
	<div class="login_control">
		<button onclick="sendRegistration();" type="button" class="theme_btn full_button intro_btn_pop" id="register_button"><i class="fa fa-edit"></i> <?php echo $lang['register']; ?></button>
	</div>
	<div class="clear"></div>
	<p class="rules_text sub_text"><?php echo $lang['i_agree']; ?> <span class="rules_click" onclick="showRules();"><?php echo $lang['rules']; ?></span></p>
</div>