<div id="player_box" class="hidden add_shadow element_color">
	<div id="player" class="border_bottom">
		<div id="player_content">
			<div id="player_actual_status" class="bcell_mid turn_on_play centered_element">
				<i id="current_play_btn" class="fa fa-play-circle"></i>
			</div>
			<div id="sound_display" class="bcell_mid">
				<i class="fa fa-volume-down show_sound"></i>
			</div>
			<div id="player_volume" class="bcell_mid boom_slider">
				<div id="slider"></div>
			</div>
		</div>
	</div>
	<div class="btable">
		<div class="bcell_mid centered_element" id="player_current">
			<i class="fa fa-music theme_color"></i>
		</div>
		<div id="current_player" class="bcell_mid vpad10 hpad5">
			<?php echo $boom['player_title']; ?>
		</div>
		<?php if(boomAllow($data['allow_player'])){ ?>
		<div id="open_player_list" onclick="playerList();" class="bcell_mid">
			<i class="text_med fa fa-list-ul"></i>
		</div>
		<?php } ?>
	</div>
	<?php if(boomAllow($data['allow_player'])){ ?>
	<div id="player_listing" class="hidden sub_menu_in">
		<?php echo playerList(); ?>
	</div>
	<?php } ?>
</div>