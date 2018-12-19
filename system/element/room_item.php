<div class="in_room_element <?php echo $boom['room_current']; ?> list_element" <?php echo $boom['room_ask']; ?>>
	<div class="in_room_icon"><?php echo roomAccess($boom['access']); ?><span class="in_room_protected"><?php echo $boom['room_protected']; ?></span></div>
	<div class="in_room_name"><?php echo $boom['room_name']; ?></div>
	<div class="in_room_count rtl_aleft"><span class="theme_color"><?php echo $boom['room_count']; ?></span> <i class="fa fa-users"></i></div>
</div>