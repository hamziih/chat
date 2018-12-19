<?php
require('config_session.php');

if(isset($_POST['add_news'], $_POST['post_file']) && boomAllow(10)){
	$news = clearBreak($_POST['add_news']);
	$news = escape($news);
	$news = trimContent($news);
	$post_file = escape($_POST['post_file']);
	$file_ok = 0;
	
	if(empty($news) && empty($post_file)){
		echo 0;
		die();
	}
	if($post_file != ''){
		$get_file = $mysqli->query("SELECT * FROM boom_upload WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}' AND file_complete = '0'");
		if($get_file->num_rows > 0){
			$file = $get_file->fetch_assoc();
			$news = $news . ' ' . $data['domain'] . '/upload/news/' . $file['file_name'];
			$file_ok = 1;
		}
		else {
			if($news == ''){
				echo 0;
				die();
			}
		}
	}
	if($news != ''){
		$mysqli->query("UPDATE boom_users SET user_news = '" . time() . "' WHERE user_id = '{$data['user_id']}'");
		$mysqli->query("INSERT INTO boom_news ( news_poster, news_message, news_date ) VALUE ('{$data['user_id']}', '$news', '" . time() . "')");
		$news_id = $mysqli->insert_id;
		if($file_ok == 1){
			$mysqli->query("UPDATE boom_upload SET file_complete = '1', relative_post = '$news_id' WHERE file_key = '$post_file' AND file_user = '{$data['user_id']}'");			
		}
		updateAllNotify();
		echo thisNews($news_id);
		die();
	}
	else {
		echo 0;
		die();
	}
}
if(isset($_POST['remove_news']) && boomAllow(10)){
	$news = escape($_POST['remove_news']);
	$mysqli->query("DELETE FROM boom_news WHERE id = '$news'");
	updateAllNotify();
	removeRelatedFile($news, 'news');
	echo 1;
	die();
}
?>