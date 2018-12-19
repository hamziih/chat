<div class="tab_element sub_list">
	<div class="admin_sm_content">
		<?php echo $boom['default']; ?> <?php echo $boom['stream_alias']; ?>
	</div>
	<div onclick="editPlayer(<?php echo $boom['id']; ?>);" class="admin_sm_option">
		<i class="fa fa-edit"></i>
	</div>
	<div onclick="deletePlayer(<?php echo $boom['id']; ?>, this);" class="admin_sm_option">
		<i class="fa fa-times"></i>
	</div>
</div>