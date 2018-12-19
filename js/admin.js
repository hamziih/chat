$(document).ready(function(){
	
	$(document).on('click', '.save_admin', function(){
		var saveAdmin = $(this).attr('data');
		saveSettings(saveAdmin);
	});

	$(document).on('click', '.admin_edit_room', function(){
		$.post('system/box/edit_room.php', {
			edit_room: $(this).attr('data'),
			token: utk,
			}, function(response) {
				showModal(response, 500);
		});	
	});

	$(document).on('click', '#admin_save_room', function(){
		saveRoomAdmin();
	});
	
	$(document).on('click', '#search_member', function(){
		validSearch = $('#member_to_find').val().length;
		if(validSearch >= 1){
			$.post('system/action_staff.php', {
				search_member: $('#member_to_find').val(),
				token: utk,
				}, function(response) {
					$('#member_list').html(response);
			});
		}
		else {
			callSaved(system.tooShort, 3);
		}
	});

	$(document).on('change', '#member_critera', function(){
		var checkCritera = $(this).val();
		if(checkCritera == 0){
			return false;
		}
		else {
			$.post('system/action_staff.php', {
				search_critera: $(this).val(),
				token: utk,
				}, function(response) {
					$('#member_list').html(response);
			});
		}
	});

	$(document).on('click', '.delete_ip', function(){
		$.post('system/action_staff.php', {
			delete_ip: $(this).attr('data'),
			token: utk,
			}, function(response) {
				if(response == 1){
					loadLob('admin/setting_ip.php');
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	});

	$(document).on('click', '.delete_room', function(){
		var roomElem = $(this).parent();
		$.post('system/system_action.php', {
			delete_room: $(this).attr('data'),
			token: utk,
			}, function(response) {
				if(response == 1){
					roomElem.remove();
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	});

	$(document).on('change, paste, keyup', '#search_ip', function(){
		var searchIp = $(this).val().toLowerCase();
		if(searchIp == ''){
			$(".ip_box").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".ip_box").each(function(){
				var ipData = $(this).text().toLowerCase();
				if(ipData.indexOf(searchIp) < 0){
					$(this).hide();
				}
				else if(ipData.indexOf(searchIp) > 0){
					$(this).show();
				}
			});
		}
	});

	var addonsReply = 1;
	$(document).on('click', '.activate_addons', function(){
		$(this).hide();
		$(this).prev('.work_button').show();
		if(addonsReply == 1){
			addonsReply = 0;
			var toActive = $(this).attr('data');
			$.post('system/system_action.php', {
				activate_addons: 1,
				addons: toActive,
				token: utk,
				}, function(response) {
					if(response == 0){
						callSaved(system.error, 3);
					}
					else if(response == 99){
						callSaved('An error occured please contact us for assistance', 3);
					}
					loadLob('admin/setting_addons.php');
					addonsReply = 1;
			});
		}
		else {
			return false;
		}
	});
	
	$(document).on('click', '.desactivate_addons', function(){
		var toDesactive = $(this).attr('data');
		$(this).hide();
		$(this).prev('.desactivate_addons').hide();
		$(this).prev('.work_button').show();
		$.post('system/system_action.php', {
			remove_addons: 1,
			addons: toDesactive,
			token: utk,
			}, function(response) {
				loadLob('admin/setting_addons.php');
		});	
	});

	$(document).on('click', '.config_addons', function(){
		var toConfig = $(this).attr('data');
		$.post('addons/'+toConfig+'/system/config.php', {
			addons: toConfig,
			token: utk,
			}, function(response) {
				loadWrap(response);
		});	
	});

	$(document).on('change, paste, keyup', '#search_admin_room', function(){
		var searchRoom = $(this).val().toLowerCase();
		if(searchRoom == ''){
			$(".box_room").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".box_room").each(function(){
				var roomData = $(this).text().toLowerCase();
				if(roomData.indexOf(searchRoom) < 0){
					$(this).hide();
				}
				else if(roomData.indexOf(searchRoom) > 0){
					$(this).show();
				}
			});
		}
	});

	$(document).on('change', '#set_word_action', function() {
		$.post('system/action_staff.php', {
			word_action: $(this).val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					return false;
				}
		});	
	});

	$(document).on('change', '#set_word_delay', function() {
		$.post('system/action_staff.php', {
			mute_delay: $(this).val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					return false;
				}
		});	
	});
	
	$(document).on('change', '#set_spam_action', function() {
		$.post('system/action_staff.php', {
			spam_action: $(this).val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					return false;
				}
		});	
	});
	
	$(document).on('change', '#set_email_filter', function() {
		$.post('system/action_staff.php', {
			email_filter: $(this).val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					return false;
				}
		});	
	});
	
	var waitUpdate = 1;
	$(document).on('click', '.update_system', function(){
		var bbVersion = $(this).attr('data');
		if(waitUpdate == 1){
			waitUpdate = 0;
			$(this).hide();
			$(this).prev('.work_button').show();
			$.post('system/system_action.php', {
				version_install: bbVersion,
				token: utk,
				}, function(response) {
					if(response == 0){
						callSaved('This version is already installed', 3);
					}
					else if(response == 1){
						callSaved('Unable to update please update manually', 3);
					}
					else if(response == 2){
						callSaved('update completed', 1);
					}
					else if(response == 99){
						callSaved('An error occured please contact us for assistance', 3);
					}
					else {
						callSaved(system.error, 3);
					}
					loadLob('admin/setting_update.php');
					waitUpdate = 1;
					return false;
			});
		}
		else {
			return false;
		}
	});
   
});
addWord = function(t, z, i){
	$.post('system/action_staff.php', {
		add_word: $('#'+i).val(),
		type: t,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.dataExist, 3)
			}
			else if(response == 2){
				callSaved(system.emptyField, 3);
			}
			else if(response == 99){
				callSaved(registerKey, 3);
			}
			else {
				$('#'+z+' .empty_zone').hide();
				$('#'+z).prepend(response);
			}
			$('#'+i).val('');
	});	
}
deleteWord = function(t, id){
	$.post('system/action_staff.php', {
		delete_word: id,
		token: utk,
		}, function(response) {
			if(response == 1){
				$(t).parent().remove();
			}
			else {
				callSaved(system.error, 3);
			}
	});	
}
openAddPlayer = function(){
	$.post('system/box/add_player.php', {
		token: utk,
		}, function(response) {
			showModal(response, 500);
	});	
}
addPlayer = function(){
	var playerAlias = $('#add_player_alias').val();
	var playerUrl = $('#add_player_url').val();
	$.post('system/action_staff.php', {
		player_alias: playerAlias,
		player_url: playerUrl,
		token: utk,
		}, function(response) {
			if(response == 1){
				hideModal();
				loadLob('admin/setting_player.php');
			}
			else if(response == 2){
				callSaved(system.emptyField, 3);
			}
			else {
				callSaved(system.error, 3);
			}
	});	
}
saveRoomAdmin = function(){
	$.post('system/action_room.php', {
		admin_set_room_id: $('#admin_save_room').attr('data'),
		admin_set_room_name: $('#set_room_name').val(),
		admin_set_room_description: $('#set_room_description').val(),
		admin_set_room_password: $('#set_room_password').val(),
		admin_set_room_player: $('#set_room_player').val(),
		admin_set_room_access: $('#set_room_access').val(),
		token: utk,

		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
				loadLob('admin/setting_rooms.php');
			}
			if(response == 2){
				callSaved(system.roomExist, 3);
			}
			if(response == 4){
				callSaved(system.roomName, 3);
			}
			else { 
				return false;
			}
	});	
}
saveSettings = function(source){
	if(source == 'main_settings'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'main_settings',
			set_index_path: $('#set_index_path').val(),
			set_title: $('#set_title').val(),
			set_timezone: $('#set_timezone').val(),
			set_default_language: $('#set_default_language').val(),
			set_main_theme: $('#set_main_theme').val(),
			set_site_description: $('#set_site_description').val(),
			set_site_keyword: $('#set_site_keyword').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else if(response == 2){
					location.reload();
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'data_setting'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'data_setting',
			set_chat_delete: $('#set_chat_delete').val(),
			set_private_delete: $('#set_private_delete').val(),
			set_wall_delete: $('#set_wall_delete').val(),
			set_max_avatar: $('#set_max_avatar').val(),
			set_max_file: $('#set_max_file').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'player'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'player',
			set_default_player: $('#set_default_player').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else if(response == 2){
					callSaved(system.saved, 1);
					loadLob('admin/setting_player.php');
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'email'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'email_settings',
			set_mail_type: $('#set_mail_type').val(),
			set_site_email: $('#set_site_email').val(),
			set_email_from: $('#set_email_from').val(),
			set_smtp_host: $('#set_smtp_host').val(),
			set_smtp_username: $('#set_smtp_username').val(),
			set_smtp_password: $('#set_smtp_password').val(),
			set_smtp_port: $('#set_smtp_port').val(),
			set_smtp_type: $('#set_smtp_type').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'registration'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'registration',
			set_registration: $('#set_registration').val(),
			set_activation: $('#set_activation').val(),
			set_allow_email: $('#set_allow_email').val(),
			set_max_reg: $('#set_max_reg').val(),
			set_max_username: $('#set_max_username').val(),
			set_min_age: $('#set_min_age').val(),
			set_reg_mute: $('#set_reg_mute').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'social_registration'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'social_registration',
			set_facebook_login: $('#set_facebook_login').val(),
			set_facebook_id: $('#set_facebook_id').val(),
			set_facebook_secret: $('#set_facebook_secret').val(),
			set_google_login: $('#set_google_login').val(),
			set_google_id: $('#set_google_id').val(),
			set_google_secret: $('#set_google_secret').val(),
			set_twitter_login: $('#set_twitter_login').val(),
			set_twitter_id: $('#set_twitter_id').val(),
			set_twitter_secret: $('#set_twitter_secret').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'guest_registration'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'guest_registration',
			set_allow_guest: $('#set_allow_guest').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'bridge_registration'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'bridge_registration',
			set_use_bridge: $('#set_use_bridge').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else if(response == 404){
					callSaved(system.noBridge, 3);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'limitation'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'limitation',
			set_allow_avatar: $('#set_allow_avatar').val(),
			set_allow_image: $('#set_allow_image').val(),
			set_emo_plus: $('#set_emo_plus').val(),
			set_allow_direct: $('#set_allow_direct').val(),
			set_allow_room: $('#set_allow_room').val(),
			set_allow_player: $('#set_allow_player').val(),
			set_allow_theme: $('#set_allow_theme').val(),
			set_allow_history: $('#set_allow_history').val(),
			set_allow_colors: $('#set_allow_colors').val(),
			set_allow_name_color: $('#set_allow_name_color').val(),
			set_allow_verify: $('#set_allow_verify').val(),
			set_allow_name: $('#set_allow_name').val(),
			set_allow_mood: $('#set_allow_mood').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'modules'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'modules',
			set_use_lobby: $('#set_use_lobby').val(),
			set_use_wall: $('#set_use_wall').val(),
			set_cookie_law: $('#set_cookie_law').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'chat'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'chat',
			set_room_count: $('#set_room_count').val(),
			set_ico: $('#set_ico').val(),
			set_max_main: $('#set_max_main').val(),
			set_max_private: $('#set_max_private').val(),
			set_max_offcount: $('#set_max_offcount').val(),
			set_speed: $('#set_speed').val(),
			set_allow_logs: $('#set_allow_logs').val(),
			set_act_time: $('#set_act_time').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else if(source == 'security_registration'){
		$.post('system/admin_save.php', { 
			save_admin_section: 'security_registration',
			set_use_recapt: $('#set_use_recapt').val(),
			set_recapt_key: $('#set_recapt_key').val(),
			set_recapt_secret: $('#set_recapt_secret').val(),
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.saved, 1);
				}
				else {
					callSaved(system.error, 3);
				}
		});	
	}
	else { 
		return false;
	}
}
eraseAccount = function(target){
	$.post('system/box/delete_account.php', {
		account: target,
		token: utk,
		}, function(response) {
			showModal(response);
	});
}
testMail = function(target){
	$.post('system/system_action.php', {
		test_mail: 1,
		test_email: $('#test_email').val(),
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.actionComplete, 1);
			}
			else {
				callSaved(system.error, 3);
			}
			hideModal();
	});
}
openTestMail = function(target){
	$.post('system/box/test_mail.php', {
		token: utk,
		}, function(response) {
			showModal(response);
	});
}
confirmDelete = function(target){
	$.post('system/action_staff.php', {
		delete_user_account: target,
		token: utk,
		}, function(response) {
			hideModal();
			if(response == 1){
				callSaved(system.actionComplete, 1);
				$('#found'+target).remove();
			}
			else {
				callSaved(system.cannotUser, 3);
			}
	});
}
savePlayer = function(id){
	$.post('system/action_staff.php', {
		new_stream_url: $('#new_player_url').val(),
		new_stream_alias: $('#new_player_alias').val(),
		player_id: id,
		token: utk,
		}, function(response) {
			if(response == 1){
				hideModal();
				callSaved(system.saved, 1);
				loadLob('admin/setting_player.php');
			}
			else {
				callSaved(system.error, 3);
			}
	});	
}
moreAdminSearch = function(ct){
	var lct = $('#search_admin_list .tab_element:last').attr('id');
	lastCt = lct.replace('found', '');	
	$.post('system/action_staff.php', {
		more_search_critera: ct,
		last_critera: lastCt,
		token: utk,
		}, function(response) {
			if(response == 0){
				$('#search_for_more').remove();
			}
			else {
				$('#search_admin_list').append(response);
			}
	});
	
}
roomAdmin = 0;
addAdminRoom = function(){
	var rType = $("#set_room_type").val();
	var rLimit = $("#set_room_limit").val();
	var rPass = $("#set_room_password").val();
	var rName = $("#set_room_name").val();
	var rDescription = $("#set_room_description").val();
	if (/^\s+$/.test(rName) || rName == ''){
		callSaved(system.emptyField, 3);
	}
	if(roomAdmin == 0){
		roomAdmin = 1;
		$.post('system/action_room.php', { 
			admin_add_room: 1,
			admin_set_name: rName,
			admin_set_type: rType,
			admin_set_pass: rPass,
			admin_set_description: rDescription,
			token: utk
			}, function(response) {
				
			if(response == 1){
				callSaved(system.error, 3);
			}
			else if (response == 2){
				callSaved(system.roomName, 3);
			}
			else if (response == 4){
				callSaved(system.shortPass, 3);
			}
			else if (response == 6){
				callSaved(system.roomExist, 3);
			}
			else {
				$('#room_listing').prepend(response);
				hideModal();
			}
			roomAdmin = 0;
		});
	}
	else {
		return false;
	}	
}
adminCreateRoom = function(){
	$.post('system/box/admin_create_room.php', {
		token: utk,
		}, function(response) {
			showModal(response);
	});
}
deletePlayer = function(id, item){
	$.post('system/action_staff.php', {
		delete_player: id,
		token: utk,
		}, function(response) {
			if(response == 1){
				$(item).parent().remove();
			}
			else if(response == 2){
				loadLob('admin/setting_player.php');
			}
			else {
				callSaved(system.error, 3);
			}
	});	
}

editPlayer = function(id){
	$.post('system/box/edit_player.php', {
		edit_player: id,
		token: utk,
		}, function(response) {
			showModal(response, 500);
	});	
}
createUser = function(){
	$.post('system/box/create_user.php', {
		token: utk,
		}, function(response) {
			showModal(response, 500);
	});	
}
waitCreate = 0;
addNewUser = function(){
	if(waitCreate == 0){
		waitCreate = 1;
		$.post('system/action_staff.php', {
			create_user: 1,
			create_name: $('#set_create_name').val(),
			create_password: $('#set_create_password').val(),
			create_email: $('#set_create_email').val(),
			create_gender: $('#set_create_gender').val(),
			create_age: $('#set_create_age').val(),
			token: utk
			}, function(response) {
				if(response == 5){
					callSaved(system.invalidEmail, 3);
				}
				else if(response == 4){
					callSaved(system.usernameExist, 3);
				}
				else if(response == 3){
					callSaved(system.invalidUsername, 3);
				}
				else if(response == 2){
					callSaved(system.emptyField, 3);
				}
				else if (response == 1){
					callSaved(system.saved, 1);
					hideModal();
					loadLob('admin/setting_members.php');
				}
				waitCreate = 0;
		});
	}
}
savePageData = function(p, c){
	$.post('system/admin_save.php', {
		page_content: $('#'+c).val(),
		page_target: p,
		save_page: 1,
		token: utk,
		}, function(response) {
			callSaved(system.saved, 1);
	});	
}