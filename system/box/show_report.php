<?php
require_once('../config_session.php');
$me = $data['user_id'];
if(!boomAllow(8)){
	die();
}
$report_list = '';
$find_report = $mysqli->query("SELECT boom_report.*, boom_users.user_name, boom_users.user_id, boom_users.user_color, boom_users.user_tumb,
(SELECT secret FROM boom_post WHERE post_id = boom_report.report_post) as relation
FROM boom_report, boom_users WHERE boom_report.report_user = boom_users.user_id
ORDER BY report_date DESC LIMIT 40");

if($find_report->num_rows > 0){
	while($report = $find_report->fetch_assoc()){
		$report_message = '';
		$reason = '';
		$add_link = '';
		if($report['report_type'] == 1){
			$report_message = $lang['reported_chat'];
			$add_link = 'onclick="showPostReport(\'' . $report['report_post'] . '\', \'1\', this);"';
			$class = 'crep' . $report['report_post'];
		}
		if($report['report_type'] == 2){
			$report_message = $lang['reported_post'];
			$add_link = 'onclick="showPostReport(\'' . $report['report_post'] . '\', \'2\', this);"';
			$class = 'prep' . $report['report_post'];
		}
		switch ($report['report_reason']) {
			case 'language':
				$reason = $lang['report_language'];
				break;
			case 'content':
				$reason = $lang['report_content'];
				break;
			case 'spam':
				$reason = $lang['report_spam'];
				break;
	
		}
		$report_list .= '<div ' . $add_link . ' class="' . $class . ' list_element notify_item">
					<div class="notify_avatar">
						<img class="avatar_notify" src="' . myavatar($report['user_tumb']) . '"/>
					</div>
					<div class="notify_details">
						<p class="hnotify username ' . $report['user_color'] . '">' . $report['user_name'] . '</p>
						<p class="notify_text" >' . $lang['reported_reason'] . ' : ' . $reason . '</p>
						<span class="date date_notify">' . displayDate($report['report_date']) . '</span>
					</div>
				</div>';
	}
}
else {
	$report_list .= emptyZone($lang['no_report']);
}
?>
<div class="pad_box">
	<?php echo $report_list; ?>
</div>