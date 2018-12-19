<?php
require('config_session.php');

if(isset($_POST['take_action'], $_POST['target'])){
	$action = escape($_POST['take_action']);
	$target = escape($_POST['target']);
	if($action == 'mute'){
		$do_action = muteAccount($target);
		echo $do_action;
		die();
	}
	else if($action == 'ban'){
		$do_action = banAccount($target);
		echo $do_action;
		die();
	}
	else if($action == 'unban'){
		$do_action = unbanAccount($target);
		echo $do_action;
		die();
	}
	else if($action == 'unmute'){
		$do_action = unmuteAccount($target);
		echo $do_action;
		die();
	}
	else if($action == 'verify_account'){
		$do_action = verifyUser($target);
		echo $do_action;
		die();
	}
	if($action == 'room_block'){
		$do_action = blockRoom($target);
		echo $do_action;
		die();
	}
	else if($action == 'room_mute'){
		$do_action = muteRoom($target);
		echo $do_action;
		die();
	}
	else if($action == 'room_unmute'){
		$do_action = unmuteRoom($target);
		echo $do_action;
		die();
	}
	else if($action == 'room_unblock'){
		$do_action = unblockRoom($target);
		echo $do_action;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['remove_action'], $_POST['action_target'], $_POST['action_type']) && boomAllow(8)){
	$target = escape($_POST['action_target']);
	$type = escape($_POST['action_type']);
	$action = 0;
	switch($type){
		case 'muted':
			$action = unmuteAccount($target);
			break;
		case 'banned':
			$action = unbanAccount($target);
			break;
	}
	echo $action;
	die();
}
?>