<?php
require_once('../config_session.php');

if(isset($_POST['type'], $_POST['id'])){
	$id = escape($_POST['id']);
	$type = escape($_POST['type']);

	if($data['user_report'] > time() - 60){
		echo 3;
		die();
	}

?>
<div class="pad_box">
	<div id="report_option" data-r="">
		<div class="report_item"><div onclick="sReport(this,'language');" class="report_check"><i class="rcheck fa fa-circle"></i></div><div class="report_text"><?php echo $lang['report_language']; ?></div></div>
		<div class="report_item"><div onclick="sReport(this,'spam');" class="report_check"><i class="rcheck fa fa-circle"></i></div><div class="report_text"><?php echo $lang['report_spam']; ?></div></div>
		<div class="report_item"><div onclick="sReport(this,'content');" class="report_check"><i class="rcheck fa fa-circle"></i></div><div class="report_text"><?php echo $lang['report_content']; ?></div></div>
	</div>
	<div id="report_post" onclick="makeReport(<?php echo $id; ?>, <?php echo $type; ?>);" class="button_half pop_button default_btn button_left"><?php echo $lang['report']; ?></div>
	<div class="pop_button button_half default_btn button_right set_button cancel_modal"><?php echo $lang['cancel']; ?></div>
	<div class="clear"></div>
</div>
<?php
}
else {
	die();
}
?>