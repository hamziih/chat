<?php if($boom['report_type'] == 1){ ?>
<div class="head_report">
	<div class="report_avatar">
		<img class="avatar_notify" src="<?php echo myavatar($boom['user_tumb']); ?>"/>
	</div>
	<div class="report_name">
		<p class="rep_name username <?php echo $boom['user_color']; ?>"><?php echo $boom['user_name']; ?></p>
		<span class="date date_notify"><?php echo displayDate($boom['post_date']); ?></span>
	</div>
</div>
<div class="report_content">
	<?php echo systemReplace($boom['post_message']); ?>
</div>
<?php } ?>
<?php 
if($boom['report_type'] == 2){
	echo showPost($boom['secret'], $boom['post_id']);
} 
?>
<div id="report_control">
	<div class="report_action rep_left">
		<button onclick="removeReport(<?php echo $boom['post_id']; ?>,<?php echo $boom['report_type']; ?>);" class="remove_report reg_button full_button delete_btn"><?php echo $lang['delete']; ?></button>
	</div>
	<div class="report_action rep_right">
		<button onclick="unsetReport(<?php echo $boom['post_id']; ?>,<?php echo $boom['report_type']; ?>);" class="unset_report reg_button full_button default_btn"><?php echo $lang['action_none']; ?></button>
	</div>
</div>