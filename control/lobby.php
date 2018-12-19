<?php
include('header.php');
?>
<div id="page_content">
	<div id="page_global">
		<div class="page_indata">
			<div id="page_wrapper">
				<div class="room_top_box">
					<div id="room_top_options">
						<?php if(allowRoom()){ ?>
							<div id="room_options" class="room_options">
								<button id="add_new_room" data-box="system/box/create_room.php" data-type="modal" class="getbox theme_btn reg_button"><i class="fa fa-plus-circle"></i> <?php echo $lang['add_room']; ?></button>
								<div class="clear"></div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div id="container_rooms">
					<?php echo getRoomList('box'); ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script data-cfasync="false" type="text/javascript" src="js/lobby.js<?php echo $bbfv; ?>"></script>