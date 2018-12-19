<?php 
require('../config_session.php');
if(!isset($_POST['target'])){
	echo 0;
	die();
}
$target = escape($_POST['target']);
$user = userDetails($target);
if(empty($user)){
	echo 0;
	die();
}
if(!canEditUser($user, 9) || !boomAllow($data['allow_name'])){
	echo 0;
	die();
}
?>
<div class="pad_box">

	<div class="boom_form">
		<p class="label"><?php echo $lang['username']; ?></p>
		<input type="text" id="new_user_username" value="<?php echo $user['user_name']; ?>" class="full_input input_data"/>
	</div>
	<button onclick="adminSaveName(<?php echo $user['user_id']; ?>);" class="reg_button theme_btn"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></button>
	<button onclick="editUser(<?php echo $user['user_id']; ?>);" class="reg_button default_btn"><i class="fa fa-times"></i> <?php echo $lang['cancel']; ?></button>
</div>