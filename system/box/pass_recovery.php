<?php 
require('../config.php');
?>
<div class="pad_box">
	<form class="login_form" autocomplete="off">
		<input id="recovery_username" placeholder="<?php echo $lang['user_recover']; ?>" class="input_data" type="text" maxlength="50">
		<input id="recovery_email" placeholder="<?php echo $lang['email']; ?>" class="input_data" maxlength="80" type="text">
		<button onclick="sendRecovery();" type="button" class="theme_btn full_button pop_button tmargin5" id="recovery_button"><?php echo $lang['recover']; ?></button>
	</form>
</div>