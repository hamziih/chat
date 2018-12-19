<div class="tab_element sub_list box_room">
	<div class="admin_sm_content bellips">
		<?php if($boom['room_id'] == 1){ $boom['room_action'] = time(); } ?>
		<?php echo roomActive($boom['room_action']); ?> <?php echo $boom['room_name']; ?>
	</div>
	<div data="<?php echo $boom['room_id']; ?>" class="admin_edit_room admin_sm_option">
		<i class="fa fa-pencil-square edit_btn"></i>
	</div>
	<?php if($boom['room_id'] == 1){ ?>
		<div class="admin_sm_option">
			<i class="fa fa-home"></i>
		</div>
	<?php } else { ?>
	<div data="<?php echo $boom['room_id']; ?>" class="admin_sm_option delete_room">
		<i class="fa fa-times"></i>
	</div>
	<?php } ?>
</div>