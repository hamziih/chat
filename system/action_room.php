<?php
require('config_session.php');

if(isset($_POST['set_room_name'], $_POST['set_room_description'], $_POST['set_room_password'], $_POST['save_room'])){
	if(!boomRole(5) && !boomAllow(9)){
		die();
	}
	$player_check = 0;
	$name = escape($_POST['set_room_name']);
	$description = escape($_POST['set_room_description']);
	$password = escape($_POST['set_room_password']);
	if(isset($_POST['set_room_player'])){
		$player = escape($_POST['set_room_player']);
		$player_check = 1;
	}
	$get_room = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id = '{$data['user_roomid']}'");
	$room = $get_room->fetch_assoc();
	
	if(roomExist($name, $data['user_roomid'])){
		echo 2;
		die();
	}
	if($name == '' || checkName($name) || strlen($name) > $data['max_room_name'] ){
		echo 4;
		die();
	}
	if($data['user_roomid'] == 1){
		$password = '';
	}
	if($player_check == 1){
		if($player != 0){
			if($player != $room['room_player_id']){
				$check_player = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '$player'");
				if($check_player->num_rows > 0){
					$setplay = $check_player->fetch_assoc();
					$player_id = $setplay['id'];
				}
				else {
					$player_id = $room['room_player_id'];
				}
			}
			else {
				$player_id = $room['room_player_id'];
			}
		}
		else {
			$player_id = 0;
		}
	}
	else {
		$player_id = 0;
	}
	$mysqli->query("UPDATE boom_rooms SET room_name = '$name', description = '$description', password = '$password', room_player_id = '$player_id' WHERE room_id = '{$data['user_roomid']}'");
	echo 1;
	die();
}
if(isset($_POST['room'], $_POST['get_in_room'])){
	$target = escape($_POST['room']);
	$check_action = getDelay();
	$muted = 0;
	$blocked = 0;
	$role = 0;
	$check_room = $mysqli->query("SELECT *,
	(SELECT count(id) FROM boom_room_action WHERE action_room = '$target' AND action_user = '{$data['user_id']}' AND action_muted = '1') as is_muted,
	(SELECT count(id) FROM boom_room_action WHERE action_room = '$target' AND action_user = '{$data['user_id']}' AND action_blocked = '1') as is_blocked,
	(SELECT room_rank FROM boom_room_staff WHERE room_staff = '{$data['user_id']}' AND room_id = '$target') as room_status
	FROM boom_rooms 
	WHERE room_id = '$target'");
	if($check_room->num_rows > 0){
		$room = $check_room->fetch_assoc();
		if($room['is_muted'] > 0){
			$muted = 1;
		}
		if($room['is_blocked'] == 1){
			echo 99;
			die();
		}
		if(!is_null($room['room_status'])){
			$role = $room['room_status'];
		}
		if(boomAllow($room['access'])){
			if($room['password'] != ''){
				if(isset($_POST['pass'])){
					$pass = escape($_POST['pass']);
					if($pass == $room['password'] || boomAllow(8) || $room['room_creator'] == $data['user_id']){
						$mysqli->query("UPDATE boom_users SET join_msg = 0, user_roomid = '$target', last_action = '" . time() . "', user_role = '$role', room_mute = '$muted' WHERE user_id = '{$data['user_id']}'");
						$mysqli->query("UPDATE boom_rooms SET room_action = '" . time() . "' WHERE room_id = '$target'");
						echo 10;
					}
					else {
						echo 5;
					}
				}
				else {
					echo 4;
				}
			}
			else {
				$mysqli->query("UPDATE boom_users SET join_msg = 0, user_roomid = '$target', last_action = '" . time() . "', user_role = '$role', room_mute = '$muted' WHERE user_id = '{$data['user_id']}'");
				$mysqli->query("UPDATE boom_rooms SET room_action = '" . time() . "' WHERE room_id = '$target'");
				echo 10;
			}
		}
		else {
			echo 2;
		}
	}
	else {
		echo 1;
	}
	die();
}
if(isset($_POST['set_name']) && isset($_POST['set_pass']) && isset($_POST['set_type']) && isset($_POST['set_description'])){
	$set_pass = escape($_POST["set_pass"]);
	$set_type = escape($_POST["set_type"]);
	$set_name = escape($_POST['set_name']);
	$set_description = escape($_POST['set_description']);
	if(!boomAllow($data['allow_room']) || !roomType($set_type)){
		die();
	}
	$room_system = 0;
	if(isOwner()){
		$room_system = 1;
	}
	if(!validRoomName($set_name)){
		echo 2;
		die();
	}
	$max_room = $mysqli->query("SELECT room_id FROM boom_rooms WHERE room_creator = '{$data['user_id']}'");
	if($max_room->num_rows >= 2 && !boomAllow(8)){
		echo 5;
		die();
	}
	$check_duplicate = $mysqli->query("SELECT room_name FROM boom_rooms WHERE room_name = '$set_name'");
	if($check_duplicate->num_rows > 0){
		echo 6;
		die();
	}
	if($set_pass !== ''){
		if(strlen($set_pass) > 16 && strlen($set_pass) < 4){
			echo 4;
			die();
		}
		$mysqli->query("INSERT INTO boom_rooms (room_name, access, description, password, room_system, room_creator, room_action) VALUES ('$set_name', '$set_type', '$set_description', '$set_pass', '$room_system', '{$data['user_id']}', '" . time() . "')");
	}
	else {
		$mysqli->query("INSERT INTO boom_rooms (room_name, access, description, room_system, room_creator, room_action) VALUES ('$set_name', '$set_type', '$set_description', '$room_system', '{$data['user_id']}', '" . time() . "')");
	}
	$last_id = $mysqli->insert_id;
	if(!boomAllow(10)){
		$mysqli->query("UPDATE boom_users SET user_roomid = '$last_id', last_action = '" . time() . "', user_role = '5' WHERE user_id = '{$data['user_id']}'");
		$mysqli->query("INSERT INTO boom_room_staff ( room_id, room_staff, room_rank) VAlUES ('$last_id', '{$data['user_id']}', '5')");
	}
	else {
		$mysqli->query("UPDATE boom_users SET user_roomid = '$last_id', last_action = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
	}
	if(isset($_POST['from_chat'])){
		$groom = roomInfo($last_id);
		echo $groom['room_name'] . '|room|' . $last_id;
	}
	else {
		echo 7;
		die();
	}
	die();
}
if(isset($_POST['leave_room'])){
	$mysqli->query("UPDATE boom_users SET user_roomid = '0' WHERE user_id = '{$data['user_id']}'");
	echo 1;
	die();
}
if(isset($_POST['change_room_rank'], $_POST['target']) && (boomAllow(9) || boomRole(5))){
	$target = escape($_POST['target']);
	$rank = escape($_POST['change_room_rank']);
	$user = userRoomDetails($target);
	if(canRoomAction($user) && betterRole($rank)){
		if($rank == 0){
			$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$target' AND room_id = '{$data['user_roomid']}'");
		}
		else {
			if(checkMod($target)){
				$mysqli->query("INSERT INTO boom_room_staff ( room_id, room_staff, room_rank) VALUES ('{$data['user_roomid']}', '{$user['user_id']}', '$rank')");
			}
			else {
				$mysqli->query("UPDATE boom_room_staff SET room_rank = '$rank' WHERE room_id = '{$data['user_roomid']}' AND room_staff = '$target'");
			}
		}
		if(roomStaff($rank)){
			$mysqli->query("DELETE FROM boom_room_action WHERE action_user = '$target' AND action_room = '{$data['user_roomid']}'");
			$mysqli->query("UPDATE boom_users SET user_role = '$rank', room_mute = '0' WHERE user_id = '$target' AND user_roomid = '{$data['user_roomid']}'");
		}
		else {
			$mysqli->query("UPDATE boom_users SET user_role = '$rank' WHERE user_id = '$target' AND user_roomid = '{$data['user_roomid']}'");
		}
		$room_name = roomName();
		systemNotify($target, 'room_rank', $room_name, $rank);
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['remove_room_admin'], $_POST['target'])){
	$toremove = escape($_POST['target']);
	if(boomAllow(9)){
		$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$toremove' AND room_id = '{$data['user_roomid']}' AND room_rank = 5");
		$mysqli->query("UPDATE boom_users SET user_role = 0 WHERE user_id = '$toremove' AND user_roomid = '{$data['user_roomid']}'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['remove_room_mod'], $_POST['target'])){
	$toremove = escape($_POST['target']);
	if(boomAllow(9) || boomRole(5)){
		$mysqli->query("DELETE FROM boom_room_staff WHERE room_staff = '$toremove' AND room_id = '{$data['user_roomid']}' AND room_rank = 4");
		$mysqli->query("UPDATE boom_users SET user_role = 0 WHERE user_id = '$toremove' AND user_roomid = '{$data['user_roomid']}'");
		echo 1;
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['admin_add_room'], $_POST['admin_set_name'], $_POST['admin_set_pass'], $_POST['admin_set_type'], $_POST['admin_set_description']) && boomAllow(10)){
	$set_pass = escape($_POST["admin_set_pass"]);
	$set_type = escape($_POST["admin_set_type"]);
	$set_name = escape($_POST['admin_set_name']);
	$set_description = escape($_POST['admin_set_description']);
	if(strlen($set_name) > $data['max_room_name'] && strlen($set_name) < 4){
		echo 2;
		die();
	}
	$check_duplicate = $mysqli->query("SELECT room_name FROM boom_rooms WHERE room_name = '$set_name'");
	if($check_duplicate->num_rows > 0){
		echo 6;
		die();
	}
	if($set_pass !== ''){
		if(strlen($set_pass) > 16 && strlen($set_pass) < 4){
			echo 4;
			die();
		}
		$mysqli->query("INSERT INTO boom_rooms (room_name, access, description, password, room_system, room_creator, room_action) VALUES ('$set_name', '$set_type', '$set_description', '$set_pass', '1', '{$data['user_id']}', '" . time() . "')");
	}
	else {
		$mysqli->query("INSERT INTO boom_rooms (room_name, access, description, room_system, room_creator, room_action) VALUES ('$set_name', '$set_type', '$set_description', '1', '{$data['user_id']}', '" . time() . "')");
	}
	$last_id = $mysqli->insert_id;
	$room = roomInfo($last_id);
	if(empty($room)){
		echo 1;
		die();
	}
	else {
		echo boomTemplate('element/admin_room', $room);
		die();
	}
}
if(isset($_POST['admin_set_room_name'], $_POST['admin_set_room_id'], $_POST['admin_set_room_description'], $_POST['admin_set_room_password'], $_POST['admin_set_room_access'])){
	$player_id = 0;
	$target = escape($_POST['admin_set_room_id']);
	$name = escape($_POST['admin_set_room_name']);
	$description = escape($_POST['admin_set_room_description']);
	$password = escape($_POST['admin_set_room_password']);
	if(isset($_POST['admin_set_room_player'])){
		$player = escape($_POST['admin_set_room_player']);
		$getplayer = $mysqli->query("SELECT * FROM boom_radio_stream WHERE id = '$player'");
		if($getplayer->num_rows > 0){
			$play = $getplayer->fetch_assoc();
			$player_id = $play['id'];
		}
		else {
			$player_id = 0;
		}
	}
	$room_access = escape($_POST['admin_set_room_access']);
	$get_room = $mysqli->query("SELECT * FROM boom_rooms WHERE room_id = '{$data['user_roomid']}'");
	$room = $get_room->fetch_assoc();
	
	if(roomExist($name, $target)){
		echo 2;
		die();
	}
	if($name == '' || strlen($name) > $data['max_room_name'] ){
		echo 4;
		die();
	}
	if($target == 1){
		$password = '';
		$room_access = 0;
	}
	$mysqli->query("UPDATE boom_rooms SET room_name = '$name', description = '$description', password = '$password', room_player_id = '$player_id', access = '$room_access' WHERE room_id = '$target'");
	echo 1;
	die();
}
?>