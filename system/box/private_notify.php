<?php
/**
* Codychat
*
* @package Codychat
* @author www.boomcoding.com
* @copyright 2017
* @terms any use of this script without a legal license is prohibited
* all the content of Codychat is the propriety of BoomCoding and Cannot be 
* used for another project.
*/
require_once("../config_session.php");

$notify_limit = 50;
function privateNotification($p){
$add_count = '';
if($p['private_count'] > 0){
	$add_count = '<div class="user_lm_icon"><span class="pm_notify private_count bnotify">' . $p['private_count'] . '</span></div>';
}
return '<div class="list_element list_item user_lm_box" >
			<div class="user_lm_avatar">
				<img class="avatar_userlist" src="' . myavatar($p['user_tumb']) . '"/>
			</div>
			<div class="user_lm_data gprivate username ' . $p['user_color'] . '" data="' . $p['user_id'] . '" value="' . $p['user_name'] . '">
				' . $p["user_name"] . '
			</div>
			' . $add_count . '
			<div data="' . $p['hunter'] . '" class="lm_option delete_private">
				<i class="fa fa-times"></i>
			</div>
		</div>';
}
$private = $mysqli->query("
SELECT private_table.*, user_table.user_name, user_table.user_rank, user_table.user_id, user_table.user_tumb, user_table.user_color FROM (
SELECT *, COUNT(*) AS private_count
FROM boom_private
WHERE status = 0 AND target = '{$data['user_id']}'
GROUP BY hunter
) private_table JOIN boom_users user_table
ON private_table.hunter = user_table.user_id
ORDER BY private_table.time DESC
LIMIT $notify_limit
");

/*
$private = $mysqli->query("
SELECT boom_private.*, boom_users.user_name, boom_users.user_rank, boom_users.user_id, boom_users.user_tumb, boom_users.user_color,
(SELECT count(b.hunter) FROM boom_private b WHERE b.hunter = boom_private.hunter AND b.status = 0 AND b.target = '{$data['user_id']}') AS private_count
FROM 
boom_private
LEFT JOIN boom_users
ON boom_private.hunter = boom_users.user_id
WHERE boom_private.target = '{$data['user_id']}' AND boom_private.status = 0
ORDER BY boom_private.time DESC
LIMIT $notify_limit
");
*/

$check = array();
$new_count = 0;
$private_list = '';
$add_not = '';
$private_list = '';
$priv = 0;
if ($private->num_rows > 0){
	while ($my_private= $private->fetch_assoc()){
		if(!in_array($my_private['user_id'], $check)){
			array_push($check, $my_private['user_id']);
			$new_count++;
			$private_list .=  privateNotification($my_private);
		}
	}
	$priv++;
}
if($new_count < $notify_limit){
	if(!empty($check)){
		$check = implode(", ", $check);
		$check_again = $notify_limit - $new_count;
		$add_not = "AND hunter NOT IN ($check)";
	}
	else {
		$check_again = $notify_limit;
	}
	
	/* optional private query ordered
	
	$get_other = $mysqli->query("SELECT boom_private.*, boom_users.user_name, boom_users.user_rank, boom_users.user_id, boom_users.user_tumb, boom_users.user_color
						FROM boom_private, boom_users
						WHERE boom_private.id IN ( SELECT MAX(boom_private.id) FROM boom_private GROUP BY boom_private.hunter ) 
						AND target = '{$data['user_id']}' AND status < 3  AND hunter != '{$data['user_id']}' AND hunter = boom_users.user_id $add_not
						GROUP BY boom_private.hunter
						ORDER BY boom_private.time DESC LIMIT $check_again");				
	*/
	
	$get_other = $mysqli->query("SELECT boom_private.*, boom_users.user_name, boom_users.user_rank, boom_users.user_id, boom_users.user_tumb, boom_users.user_color
						FROM boom_private, boom_users
						WHERE target = '{$data['user_id']}' AND status < 3  AND hunter != '{$data['user_id']}' AND hunter = boom_users.user_id $add_not
						GROUP BY boom_private.hunter
						ORDER BY boom_private.time DESC, boom_private.status ASC LIMIT $check_again");

	if($get_other->num_rows > 0){
		while ($other_private= $get_other->fetch_assoc()){
			$other_private['private_count'] = 0;
			$private_list .= privateNotification($other_private);
		}
		$priv++;
	}
}
if($private_list == '') {
	$private_list .= emptyZone($lang['no_unread_private']);
}
?>
<div class="modal_top">
	<?php if($priv > 0){ ?>
	<div onclick="clearPrivateList();" class="clear_priv bcell_mid hpad10 bold">
		<i class="fa fa-trash"></i> <?php echo $lang['clear']; ?>
	</div>
	<?php } ?>
	<div class="modal_top_empty bold">
	</div>
	<div class="modal_top_element close_modal">
		<i class="fa fa-times"></i>
	</div>
</div>
<div class="private_list">
	<?php echo $private_list; ?>
</div>