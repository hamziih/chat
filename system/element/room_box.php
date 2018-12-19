<div class="<?php echo $boom['myr']; ?>room_box">
	<div class="room_content">
		<div class="room_top">
			<div class="room_title">
				</i> <?php echo $boom['room_name']; ?>
			</div>
			<div class="room_counter">
				<span class="theme_color"><?php echo $boom['room_count']; ?></span> <i class="fa fa-users"></i> 
			</div>
		</div>
		<div class="room_center" title="<?php echo $boom['room_description']; ?>">
			<?php echo $boom['room_description']; ?>
		</div>
		<div class="room_bottom">
			<button <?php echo $boom['room_ask']; ?> class="rooms_button join_btn full_button"><?php echo roomAccess($boom['access']); ?> <?php echo $boom['room_protected'];?> <?php echo $lang['join_room']; ?></button>
		</div>
	</div>
</div>