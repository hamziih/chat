<?php
require('../config.php');
$social = getSocialData();
?>
<div class="pad_box">
	<?php if(alterLogin()){ ?>
		<?php if($social['facebook_login'] == 1){ ?>
			<button class="fbl_button full_button intro_btn_pop" onclick="window.location.href='login/facebook_login.php'"><i class="fa fa-facebook ficon_login"></i> Facebook</button>
		<?php } ?>
		<?php if($social['google_login'] == 1){ ?>
			<button class="gplus_button full_button intro_btn_pop" onclick="window.location.href='login/google_login.php'"><i class="fa fa-google-plus ficon_login"></i> Google</button>
		<?php } ?>
		<?php if($social['twitter_login'] == 1){ ?>
			<button class="twit_button full_button intro_btn_pop" onclick="window.location.href='login/twitter_login.php'"><i class="fa fa-twitter ficon_login"></i> Twitter</button>
		<?php } ?>
		<p class="rules_text sub_text centered_element"><?php echo $lang['i_agree']; ?> <span class="rules_click" onclick="showRules();"><?php echo $lang['rules']; ?></span></p>
	<?php } ?>
</div>