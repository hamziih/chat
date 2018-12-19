<?php
require('../config_session.php');

if(isset($_POST['show_post_report'], $_POST['post']) && boomAllow(8)){
	$report_id = escape($_POST['post']);
	$type = escape($_POST['show_post_report']);
	$show_report = '';
	if($type == 1){
		$get_report = $mysqli->query("SELECT boom_chat.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
			FROM boom_chat
			LEFT JOIN boom_users
			ON boom_chat.user_id = boom_users.user_id WHERE boom_chat.post_id = '$report_id' LIMIT 1");
	}
	if($type == 2){
		$get_report = $mysqli->query("SELECT boom_post.*, boom_users.user_name, boom_users.user_color, boom_users.user_tumb, boom_users.user_bot
			FROM boom_post
			LEFT JOIN boom_users
			ON boom_post.post_user = boom_users.user_id WHERE boom_post.post_id = '$report_id' LIMIT 1");
	}
	if($get_report->num_rows > 0){
		$report = $get_report->fetch_assoc();
		$report['report_type'] = $type;
		$showreport = boomTemplate('element/report', $report);
	}
	else {
		$mysqli->query("DELETE FROM boom_report WHERE report_type = '$type' AND report_post = '$report_id'");
		echo 1;
		die();
	}
}
else {
	die();
}
?>
<div class="pad_box">
	<?php echo $showreport; ?>
</div>