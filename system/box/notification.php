<?php
require_once('../config_session.php');

$find_notify = $mysqli->query("
SELECT boom_notification.*, boom_users.user_name, boom_users.user_tumb, boom_users.user_color, boom_post.secret
FROM boom_notification
LEFT JOIN boom_post
ON boom_post.post_id = boom_notification.notify_id
LEFT JOIN boom_users
ON boom_notification.notifier = boom_users.user_id
WHERE boom_notification.notified = '{$data['user_id']}'
ORDER BY boom_notification.notify_date DESC LIMIT 40
");

$notify_list = '';
if($find_notify->num_rows > 0){
	while($notify = $find_notify->fetch_assoc()){
		$view = '';
		$add_link = '';
		$add = 0;
		$notify_message = '';
		if($notify['notify_view'] == 0){
			$view = 'noview';
		}
		switch ($notify['notify_type']) {
			case 'like':
				$notify_message = $lang['liked'];
				$add = 1;
				break;
			case 'unlike':
				$notify_message = $lang['unliked'];
				$add = 1;
				break;
			case 'reply':
				$notify_message = $lang['have_replied'];
				$add = 1;
				break;
			case 'add_post':
				$notify_message = $lang['post_wall'];
				$add = 1;
				break;
			case 'accept_friend':
				$notify_message = $lang['accept_friend'];
				break;
			case 'bad_word':
				$notify_message = str_replace('@delay@', $notify['notify_custom'], $lang['bad_word_use']);
				break;
			case 'flood_abuse':
				$notify_message = $lang['flood_abuse'];
				break;
			case 'muted_word':
				$notify_message = $lang['bad_word_full'];
				break;
			case 'rank_change':
				$notify_message = str_replace('@rank@', getRank($notify['notify_custom']), $lang['rank_change']);
				break;
			case 'room_rank':
				$notify_message = str_replace(array('@room@', '@rank@'), array($notify['notify_custom'], roomTitle($notify['notify_custom2'])), $lang['room_rank_change']);
				break;
			case 'system_mute':
				$notify_message = $lang['system_mute'];
				break;
			case 'system_unmute':
				$notify_message = $lang['system_unmute'];
				break;
		}
		if(!is_null($notify['secret']) && !is_null($notify['notify_id']) && $add == 1){
			$add_link = 'onclick="showPost(\'' . $notify['notify_id'] . '\', \'' . $notify['secret'] . '\');"';
		}
		$notify_list .= '<div ' . $add_link . ' class="list_element notify_item ' . $view . '">
							<div class="notify_avatar">
								<img class="avatar_notify" src="' . myavatar($notify['user_tumb']) . '"/>
							</div>
							<div class="notify_details">
								<p class="hnotify username ' . $notify['user_color'] . '">' . $notify['user_name'] . '</p>
								<p class="notify_text" >' . $notify_message . '</p>
								<span class="date date_notify">' . displayDate($notify['notify_date']) . '</span>
							</div>
						</div>';
	}
	$mysqli->query("UPDATE boom_notification SET notify_view = 1 WHERE notified = '{$data['user_id']}'");
}
else {
	$notify_list .= '<div class="pad_box">' . emptyZone($lang['no_notify']) . '</div>';
}
?>
<div id="notify_list">
	<div id="notify_content">
		<?php echo $notify_list; ?>
	</div>
</div>