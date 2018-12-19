<?php 
require('../config.php');
?>
<div id="login_form_box" class="pad_box">
	<p  class="login_title"><?php echo $lang['login']; ?></p>
	<input id="user_username" placeholder="<?php echo $lang['username']; ?>"class="user_username input_data" type="text" maxlength="50" name="username">
	<input id="user_password" placeholder="<?php echo $lang['password']; ?>" class="input_data" maxlength="30" type="password" name="password"><br />
	<div class="login_control">
		<button onclick="sendLogin();" type="button" class="theme_btn full_button intro_btn_pop"><i class="fa fa-sign-in"></i> <?php echo $lang['login']; ?></button>
	</div>
	<p onclick="getRecovery();" class="forgot_password sub_text"><?php echo $lang['forgot']; ?></p>
</div>
<?php if(registration()){ ?>
<div class="not_member" onclick="getRegistration();">
	<p class=""><?php echo $lang['not_member']; ?></p>
</div>
<?php } ?>