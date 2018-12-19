<?php
require_once('../config_session.php');

if (isset($_POST['secret'], $_POST['post_id'], $_POST['show_this_post'])){
	$secret = escape($_POST["secret"]);
	$postid = escape($_POST["post_id"]);
}
else {
	die();
}
?>
<div class="pad_box">
	<?php echo showPost($secret, $postid); ?>
</div>