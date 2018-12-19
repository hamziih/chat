<?php
require('config_session.php');

if(!useWall()){
	die();
}	
if (isset($_POST['offset'], $_POST['load_more'], $_POST['load_more_wall'])){
	$of = escape($_POST["offset"]);
	$wall_content = '';
	$find_friend = $mysqli->query("SELECT target FROM boom_friends WHERE hunter = '{$data['user_id']}' AND status = '3'");
	$friend_array = array($data['user_id']);
	if($find_friend->num_rows > 0){
		while($add_friend = $find_friend->fetch_assoc()){
			array_push($friend_array, $add_friend['target']);
		}
	}
	$newarray = implode(", ", $friend_array);	
	$wall_post = $mysqli->query("SELECT boom_post.*, boom_users.user_name, boom_users.user_id,  boom_users.user_rank, boom_users.user_color, boom_users.user_tumb,
	(SELECT count( parent_id ) FROM boom_post_reply WHERE parent_id = boom_post.post_id ) as reply_count,
	(SELECT count( post_id ) FROM boom_post WHERE post_user IN ($newarray)) as post_count,
	(SELECT like_type FROM boom_post_like WHERE uid = '{$data['user_id']}' AND like_post = boom_post.post_id) as liked,
	(SELECT count(id) FROM boom_post_like WHERE like_post = boom_post.post_id AND like_type = 1 ) as like_count,
	(SELECT count(id) FROM boom_post_like WHERE like_post = boom_post.post_id AND like_type = 2 ) as unlike_count
	FROM  boom_post, boom_users 
	WHERE boom_post.post_user = boom_users.user_id AND boom_post.post_user IN ($newarray)
	ORDER BY boom_post.post_actual DESC LIMIT 10 OFFSET $of");
	
	if($wall_post->num_rows > 0){
		while ($wall = $wall_post->fetch_assoc()){
			$post_count = $wall['post_count'];
			$wall_content .= boomTemplate('element/wall_post',$wall);
		}
	}
	else { 
		$wall_content .= 0;
	}
	echo $wall_content;
}
if(isset($_POST['post_to_wall'], $_POST['post_file']) && boomAllow(1)){
	if(muted()){
		die();
	}
	$content = clearBreak($_POST['post_to_wall']);
	$content = escape($content);
	$content = wordFilter($content);
	$post_file = escape($_POST['post_file']);
	$file_ok = 0;
	
	if(empty($content) && empty($post_file)){
		echo 0;
		die();
	}
	if($post_file != ''){
		$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
		if($get_file->num_rows > 0){
			$file = $get_file->fetch_assoc();
			$content = $content . ' ' . $data['domain'] . '/upload/wall/' . $file['file_name'];
			$file_ok = 1;
		}
		else {
			if($content == ''){
				echo 0;
				die();
			}
		}
	}
	if(strlen($content) < 2000){
		$secret = md5(rand(111111,999999));
		$mysqli->query("INSERT INTO boom_post (post_date, post_user, post_content, secret, post_actual) VALUES ('" . time() . "', '{$data['user_id']}', '$content', '$secret', '" . time() . "' )");
		$postid = $mysqli->insert_id;
		if($file_ok == 1){
			$mysqli->query("UPDATE boom_upload SET file_complete = '1', relative_post = '$postid' WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}'");			
		}
		postFriendsNotify($postid);
		echo showPost($secret, $postid);
		die();
	}
	else {
		echo 2;
		die();
	}
}
if(isset($_POST['like']) && boomAllow(1)){
	$check_like = escape($_POST["like"]);
	$like_result = $mysqli->query("SELECT post_user, (SELECT like_type FROM boom_post_like WHERE like_post = '$check_like' AND uid = '{$data['user_id']}') AS type FROM boom_post WHERE post_id = '$check_like'");
	if($like_result->num_rows > 0){
		$like = $like_result->fetch_assoc();
		$type = $like['type'];
		$who = $like['post_user'];
		if($type == 2){
			updateLike($check_like, 1);
			if(notMe($who)){
				updateNotifyPost($who, $check_like, 'like', 'unlike');
			}
			echo 3;
			die();
		}
		else if($type == 1) {
			deleteLike($check_like);
			if(notMe($who)){
				deleteNotifyPost($who, $check_like, 'like');
			}
			echo 2;
			die();
		}
		else {
			$mysqli->query("INSERT INTO boom_post_like ( uid, liked_uid, like_type, like_post, like_date) VALUE ('{$data['user_id']}', '$who', 1, '$check_like', '" . time() . "')");
			if(notMe($who)){
				postNotify($who, 'like', $check_like);
			}
			echo 1;
			die();
		}
	}
	else {
		die();
	}
}
if(isset($_POST['unlike']) && boomAllow(1)){
	$check_like = escape($_POST["unlike"]);
	$unlike_result = $mysqli->query("SELECT post_user, (SELECT like_type FROM boom_post_like WHERE like_post = '$check_like' AND uid = '{$data['user_id']}') AS type FROM boom_post WHERE post_id = '$check_like'");
	if($unlike_result->num_rows > 0){
		$unlike = $unlike_result->fetch_assoc();
		$type = $unlike['type'];
		$who = $unlike['post_user'];	
		if($type == 1){
			updateLike($check_like, 2);
			if(notMe($who)){
				updateNotifyPost($who, $check_like, 'unlike', 'like');
			}
			echo 6;
			die();
		}
		else if($type == 2){
			deleteLike($check_like);
			if(notMe($who)){
				deleteNotifyPost($who, $check_like, 'unlike');
			}
			echo 5;
			die();
		}
		else {
			$mysqli->query("INSERT INTO boom_post_like ( uid, liked_uid, like_type, like_post, like_date) VALUE ('{$data['user_id']}', '$who', 2, '$check_like', '" . time() . "')");
			if(notMe($who)){
				postNotify($who, 'unlike', $check_like);
			}
			echo 4;
			die();
		}
	}
	else {
		die();
	}
}
if(isset($_POST['content']) && isset($_POST['reply_to_wall']) && isset($_POST['code']) && boomAllow(1)){
	$content = escape($_POST["content"]);
	$content = wordFilter($content);
	$reply_to = escape($_POST["reply_to_wall"]);
	$code = escape($_POST["code"]);
	if(strlen($content) >= 1001){
		echo 1;
		die();
	}
	$check_valid = $mysqli->query("SELECT * FROM boom_post WHERE post_id = '$reply_to' AND secret = '$code'");
	if($check_valid->num_rows < 1){
		echo 1;
		die();
	}
	$get_id = $check_valid->fetch_assoc();
	$id = $get_id['post_id'];
	$secret = $get_id['secret'];
	$who = $get_id['post_user'];
	$mysqli->query("INSERT INTO boom_post_reply (parent_id, reply_uid, reply_date, reply_user, reply_content, reply_secret) VALUES ('$id', '$who', '" . time() . "', '{$data['user_id']}', '$content', '$secret')");
	$mysqli->query("UPDATE boom_post SET post_actual = '" . time() . "' WHERE post_id = '$id'");
	if(notMe($who)){
		postNotify($who, 'reply', $reply_to);
	}
	$get_back = $mysqli->query("SELECT * FROM boom_post_reply WHERE parent_id = '$reply_to' AND reply_user = '{$data['user_id']}' ORDER BY reply_id DESC LIMIT 1");
	if($get_back->num_rows < 1){
		echo 1;
		die();
	}
	$reply = $get_back->fetch_assoc();
	$reply['user_tumb'] = $data['user_tumb'];
	$reply['user_name'] = $data['user_name'];
	$reply['user_color'] = $data['user_color'];
	$reply['user_id'] = $data['user_id'];
	echo boomTemplate('element/reply', $reply);
	die();
}
if(isset($_POST['id'], $_POST['secret'], $_POST['load_comment']) && boomAllow(1)){
	$load_reply = '';
	$id = escape($_POST["id"]);
	$secret = escape($_POST["secret"]);
	$find_reply = $mysqli->query("SELECT boom_post_reply.*, boom_users.user_name, boom_users.user_id, boom_users.user_color, boom_users.user_tumb,
	(SELECT count(reply_id) FROM boom_post_reply WHERE parent_id = '$id' ) as reply_count
	FROM  boom_post_reply, boom_users WHERE boom_post_reply.parent_id = '$id' AND boom_post_reply.reply_secret = '$secret' AND boom_post_reply.reply_user = boom_users.user_id ORDER BY boom_post_reply.reply_id DESC LIMIT 5");
	while($reply = $find_reply->fetch_assoc()){
		$load_reply .= boomTemplate('element/reply', $reply);
		$reply_count = $reply['reply_count'];
	}
	if($reply_count > 5){
		$more = '<a data-max="' . $reply_count . '" data-current="5" onclick="moreComment(this,\'' . $secret . '\',' . $id . ')" class="theme_color more_comment">' . $lang['view_more_comment'] . '</a>';
	}
	else {
		$more = 0;
	}
	echo json_encode( array("reply" => $load_reply, "more"=> $more), JSON_UNESCAPED_UNICODE);
	die();
}
if(isset($_POST['current'], $_POST['id'], $_POST['secret'], $_POST['load_reply']) && boomAllow(1)){
	
	$id = escape($_POST["id"]);
	$secret = escape($_POST["secret"]);
	$offset = escape($_POST["current"]);
	$reply_comment = '';
	
	$find_reply = $mysqli->query("SELECT boom_post_reply.*, boom_users.user_name, boom_users.user_id, boom_users.user_color, boom_users.user_tumb
	FROM  boom_post_reply, boom_users WHERE boom_post_reply.parent_id = '$id' AND boom_post_reply.reply_secret = '$secret' AND boom_post_reply.reply_user = boom_users.user_id ORDER BY boom_post_reply.reply_id DESC LIMIT 10 OFFSET $offset");
	if($find_reply->num_rows > 0){
		while($reply = $find_reply->fetch_assoc()){
			$reply_comment .= boomTemplate('element/reply', $reply);
		}
	}
	else {
		$reply_comment = 0;
	}
	echo $reply_comment;
	die();
}
if(isset($_POST['delete_wall_post'])){
	$post = escape($_POST["delete_wall_post"]);
	$user = getPostData($post);
	if(empty($user)){
		echo 1;
		die();
	}
	$valid = $mysqli->query("SELECT * FROM boom_post WHERE post_id = '$post' AND post_user = '{$data['user_id']}'");
	if($valid->num_rows > 0 || boomAllow(9)){
		$mysqli->query("DELETE FROM boom_post WHERE post_id = '$post'");
		$mysqli->query("DELETE FROM boom_post_reply WHERE parent_id = '$post'");
		$mysqli->query("DELETE FROM boom_notification WHERE notify_id = '$post'");
		$mysqli->query("DELETE FROM boom_post_like WHERE like_post = '$post'");
		$mysqli->query("DELETE FROM boom_report WHERE report_post = '$post' AND report_type = 2");
		removeRelatedFile($post, 'wall');
		updateFriendsNotify($user['post_user']);
		echo 'boom_post' . $post;
		die();
	}
	else {
		echo 1;
		die();
	}
}

?>