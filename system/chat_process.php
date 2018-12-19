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
require_once("config_session.php");
if (!isset($_POST['content'], $_POST['snum'])){
	die();
}
if(checkFlood()){
	echo 100;
	die();
}
if(muted() || roomMuted()){
	die();
}

$snum = escape($_POST['snum']);
$content = escape($_POST['content']);
$content = wordFilter($content, 1);
$content = textFilter($content);
$command = explode(' ',trim($content));
$count = count($command);

if(empty($content) && $content !== '0' || !inRoom()){
	echo 4;
	die();
}

if(substr($command[0], 0, 1) === '/'){	

	if ( $command[0] == '/topic' && ( boomAllow(8) || boomRole(5) ) ){
		$topic = trimCommand($content, '/topic');
		changeTopic($topic, $data['user_roomid']);
		die();
	}
	elseif( $command[0] == '/mute' && boomAllow(8)){
		$mute = trimCommand($content, '/mute');
		$user = nameDetails($mute);
		echo muteAccount($user['user_id']);
		die();
	}
	elseif( $command[0] == '/unmute' && boomAllow(8)){
		$mute = trimCommand($content, '/unmute');
		$user = nameDetails($mute);
		echo unmuteAccount($user['user_id']);
		die();
	}
	elseif( $command[0] == '/ban' && boomAllow(9)){
		$ban = trimCommand($content, '/ban');
		$user = nameDetails($ban);
		echo banAccount($user['user_id']);
		die();
	}
	elseif( $command[0] == '/unban' && boomAllow(9)){
		$ban = trimCommand($content, '/unban');
		$user = nameDetails($ban);
		echo unbanAccount($user['user_id']);
		die();
	}
	elseif( $command[0] == '/verify' && boomAllow(9)){
		$verify = trimCommand($content, '/verify');
		$user = nameDetails($verify);
		echo verifyUser($user['user_id']);
		die();
	}
	elseif( $command[0] == '/setuser' && boomAllow(9)){
		$torank = trimCommand($content, '/setuser');
		$user = nameDetails($torank);
		echo changeUserRank($user['user_id'], 1);
		die();
	}
	elseif( $command[0] == '/setvip' && boomAllow(9)){
		$torank = trimCommand($content, '/setvip');
		$user = nameDetails($torank);
		echo changeUserRank($user['user_id'], 2);
		die();
	}
	elseif( $command[0] == '/setmod' && boomAllow(9)){
		$torank = trimCommand($content, '/setmod');
		$user = nameDetails($torank);
		echo changeUserRank($user['user_id'], 8);
		die();
	}
	elseif( $command[0] == '/setadmin' && boomAllow(10)){
		$torank = trimCommand($content, '/setadmin');
		$user = nameDetails($torank);
		echo changeUserRank($user['user_id'], 9);
		die();
	}
	elseif( $command[0] == '/ignore'){
		$toignore = trimCommand($content, '/ignore');
		$user = nameDetails($toignore);
		echo ignore($user['user_id']);
		die();
	}
	elseif( $command[0] == '/removeignore'){
		$toignore = trimCommand($content, '/removeignore');
		$user = nameDetails($toignore);
		echo removeIgnore($user['user_id']);
		die();
	}
	elseif( $command[0] == '/removefriend'){
		$friend = trimCommand($content, '/removefriend');
		$user = nameDetails($friend);
		echo boomRemoveFriend($user['user_id']);
		die();
	}
	elseif( $command[0] == '/deleteaccount' && boomAllow(10)){
		$todel = trimCommand($content, '/deleteaccount');
		$user = nameDetails($todel);
		echo deleteAccount($user['user_id']);
		die();
	}
	elseif( $command[0] == '/addfriend'){
		$friend = trimCommand($content, '/addfriend');
		$user = nameDetails($friend);
		$response = boomAddFriend($user['user_id']);
		if($response == 2 || $response == 1 ){
			$response = 1;
		}
		else if($response == 4){
			$response = 2;
		}
		echo $response;
		die();
	}
	elseif ( $command[0] == '/clear' && ( boomAllow(8) || boomRole(5) ) ){
		clearRoom($data['user_roomid']);
		die();
	}
	elseif ( $command[0] == '/seen'){
		$search = trimCommand($content, '/seen');
		$result = userSeen($search);
		echo systemSpecial($result, 'seen');
		die();
	}
	else if($command[0] == '/clearcache' && isOwner()){
		boomCacheUpdate();
		echo 1;
		die();
	}
	else {
		echo 202;
		die();
	}
	
}
else{
	$post_data = array(
					'snum'=> $snum,
					'color'=> $data['bccolor'] . ' ' . $data['bcbold']
				);
	postChat($data['user_id'], $data['user_roomid'], $content, $post_data);
	$post = getBackMain($data['user_id']);
	if(!empty($post)){
		echo createLog($data, $post);
	}
}
?>