$(document).ready(function(){
	
	cleanData();
	cleanDatabase = setInterval(cleanData, 600000);

	$(document).on('click', '#avatar_image', function() {
		var cloneAvatar = $('.avatar_spin').html();
		$('#avatarupload').ajaxForm({
			beforeSubmit : function(arr, $form, options){
				if($("#avatar_image").val() !== ""){
					var filez = $("#avatar_image")[0].files[0].size;
					filez = (filez / 1024 / 1024).toFixed(2);
					if( filez > avw ){
						callSaved(system.fileBig, 3);
						return false;
					}
				}
				else {
					callSaved(system.noFile, 3);
					return false;
				}
			},
			beforeSend: function() {
				$('.profile_avatar .avatar_spin').html(largeSpinner);
			},
			complete: function(xhr) {
				if(xhr.responseText == 1){
					callSaved(system.wrongFile, 3);
					$('.avatar_spin').html(cloneAvatar);
				}
				else if(xhr.responseText == 7){
					callSaved(system.error, 1);
					$('.avatar_spin').html(cloneAvatar);
				}
				else if(xhr.responseText == 5){
					updateAvatar();
				}
				else {
					callSaved(system.error, 1);
					$('.avatar_spin').html(cloneAvatar);
				}
			}
		});
	});
	$(document).on("change", '#avatar_image',function(event){
		$('#avatar_form').submit();
		event.preventDefault();
	});
	$(document).on('change', '#set_profile_country', function(){
		var CountryTarget = $("select#set_profile_country").val();
		$.post('system/action_profile.php', {
			profile_country: CountryTarget,
			token: utk,
			}, function(response) {	
			$("#region_profile").html(response);
			$("select").selectBoxIt({ autoWidth: false });
		});
	});
	$(document).on('click', '.get_info', function(){
		var profile = $(this).attr('data');
		closeTrigger();
		getProfile(profile);
	});
	$(document).on('click', '#change_password', function(){
		var actual = $('#set_actual_pass').val();
		var newPass = $('#set_new_pass').val();
		var newRepeat = $('#set_repeat_pass').val();
		$.post('system/action_profile.php', { 
			actual_pass: actual,
			new_pass: newPass,
			repeat_pass: newRepeat,
			change_password: 1,
			token: utk,
			}, function(response) {
				if(response == 2){
					callSaved(system.emptyField, 3);
				}
				else if(response == 3){
					callSaved(system.notMatch, 3);
				}
				else if(response == 4){
					callSaved(system.shortPass, 3);
				}
				else if(response == 5){
					callSaved(system.badActual, 3);
				}
				else if(response == 1){
					callSaved(system.saved, 1);
					$('#set_actual_pass, #set_new_pass, #set_repeat_pass').val('');
				}
				else {
					callSaved(system.error, 3);
				}
		});
	});
	$(document).on('click', '.name_choice', function() {	
		var curColor = $(this).attr('data');
		if($('.my_name_color').attr('data') == curColor){
			$('.bccheck').remove();
			$('.my_name_color').attr('data', '');
			saveNameColor('user');
		}
		else {
			$('.bccheck').remove();
			$(this).append('<i class="bccheck fa fa-check"></i>');
			$('.my_name_color').attr('data', curColor);
			saveNameColor(curColor);
		}
	});
	$(document).on('click', '.delete_room_muted', function(){
		var action = 'room_unmute';
		var target = $(this).attr('data');
		var hideIt = $(this).parent();
		$.post('system/action.php', {
			take_action: action,
			target: target,
			token: utk,
			}, function(response) {
				if(response == 1){
					hideIt.remove();
				}
				else {
					callSaved(system.error, 3);
				}
		});
	});
	$(document).on('click', '.delete_room_blocked', function(){
		var action = 'room_unblock';
		var target = $(this).attr('data');
		var hideIt = $(this).parent();
		$.post('system/action.php', {
			take_action: action,
			target: target,
			token: utk,
			}, function(response) {
				if(response == 1){
					hideIt.remove();
				}
				else {
					callSaved(system.error, 3);
				}
		});
	});
	$(document).on('click', '.delete_room_admin', function(){
		var target = $(this).attr('data');
		var elem = $(this).parent();
		$.post('system/action_room.php', {
			remove_room_admin: 1,
			target: target,
			token: utk,
			}, function(response) {
				if(response == 1){
					elem.hide();
				}
				else {
					callSaved(system.error, 3);
				}
		});
	});
	$(document).on('click', '.delete_room_moderator', function(){
		var target = $(this).attr('data');
		var elem = $(this).parent();
		$.post('system/action_room.php', {
			remove_room_mod: 1,
			target: target,
			token: utk,
			}, function(response) {
				if(response == 1){
					elem.hide();
				}
				else {
					callSaved(system.error, 3);
				}
		});
	});
	$(document).on('click', '.choice', function() {	
		var curColor = $(this).attr('data');
		var toChange = $('.user_color').attr('data-u');
		if($('.user_color').attr('data') == curColor){
			$('.bccheck').remove();
			$('.user_color').attr('data', '');
			saveUserColor('user', toChange);
		}
		else {
			$('.bccheck').remove();
			$(this).append('<i class="bccheck fa fa-check"></i>');
			$('.user_color').attr('data', curColor);
			saveUserColor(curColor, toChange);
		}
	});
	$(document).on('keydown', function(event) {
		if( event.which === 8 && event.ctrlKey && event.altKey ) {
			getConsole();
		}
	});
	$(document).on("change", '#admin_avatar_image',function(event){
		$('#admin_avatar_form').submit();
		event.preventDefault();
	});
	
	$(document).on('click', '#admin_avatar_image', function() {
		var cloneAvatar = $('.avatar_spin').html();
		$('#avatarupload').ajaxForm({
			beforeSubmit : function(arr, $form, options){
				if($("#admin_avatar_image").val() !== ""){
					var filez = $("#admin_avatar_image")[0].files[0].size;
					filez = (filez / 1024 / 1024).toFixed(2);
					if( filez > avw ){
						callSaved(system.fileBig, 3);
						return false;
					}
				}
				else {
					callSaved(system.noFile, 3);
					return false;
				}
			},
			beforeSend: function() {
				$('.profile_avatar .avatar_spin').html(largeSpinner);
			},
			complete: function(xhr) {
				if(xhr.responseText == 1){
					callSaved(system.wrongFile, 3);
					$('.avatar_spin').html(cloneAvatar);
				}
				else if(xhr.responseText == 7){
					callSaved(system.error, 3);
					$('.avatar_spin').html(cloneAvatar);
				}
				else if(xhr.responseText == 5){
					var thisAdminAvatar = $('#this_admin_avatar').attr('value');
					adminUpdateAvatar(thisAdminAvatar);
				}
				else {
					callSaved(system.error, 1);
					$('.avatar_spin').html(cloneAvatar);
				}
			}
		});
	});
	
});
var waitGuest = 0;
registerGuest = function() {
	var gname = $('#new_guest_name').val();
	var gpass = $('#new_guest_password').val();
	var gemail = $('#new_guest_email').val();
	if(gname == '' || gpass == '' || gemail == ''){
		callSaved(system.emptyField, 3);
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_name').val())){
		callSaved(system.emptyField, 3);
		$('#new_guest_name').val("");
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_password').val())){
		callSaved(system.emptyField, 3);
		$('#new_guest_password').val("");
		return false;
	}
	else if (/^\s+$/.test($('#new_guest_email').val())){
		callSaved(system.emptyField, 3);
		$('#new_guest_email').val("");
		return false;
	}
	else {
		if(waitGuest == 0){
			waitGuest = 1;
			$.post('login/guest_registration.php', {
				new_guest_name: gname,
				new_guest_password: gpass,
				new_guest_email: gemail,
				token: utk
				}, function(response) {
					if(response == 2){
						callSaved(system.error, 3);
						$('#new_guest_password').val("");
						$('#new_guest_name').val("");
						$('#new_guest_email').val("");	
					}
					else if (response == 4){
						callSaved(system.invalidUsername, 3);
						$('#new_guest_name').val("");
					}
					else if (response == 5){
						callSaved(system.usernameExist, 3);
						$('#new_guest_name').val("");
					}
					else if (response == 6){
						callSaved(system.invalidEmail, 3);
						$('#new_guest_email').val("");
					}
					else if (response == 10){
						callSaved(system.emailExist, 3);
						$('#new_guest_email').val("");
					}
					else if (response == 16){
						callSaved(system.maxReg, 3);
					}
					else if (response == 17){
						callSaved(system.shortPass, 3);
						$('#new_guest_password').val("");
					}
					else if (response == 1){
						location.reload();
					}
					else if(response == 0){
						callSaved(system.registerClose, 3);
					}
					else {
						waitGuest = 0;
						return false;
					}
					waitGuest = 0;
			});
		}
		else{
			return false;
		}
	}
}
verifyAccount = function(){
	$('.resend_hide').hide();
	$.post('system/action_verify.php', {
		verify: 1,
		send_verification: 1,
		token: utk,
		}, function(response) {	
		if(response == 1){
			callSaved(system.emailSent, 1);
		}
		else if(response == 3){
			callSaved(system.somethingWrong, 3);
		}
		else {
			callSaved(system.oops, 3);
		}
	});
}
validCode = function(type){
	var vCode = $('#boom_code').val();
	if (/^\s+$/.test(vCode) || vCode == ''){
		callSaved(system.emptyField, 3);
	}
	else {
		$.post('system/action_verify.php', {
			valid_code: vCode,
			verify_code:1,
			token: utk,
			}, function(response) {	
			if(response == 0){
				callSaved(system.invalidCode, 3);
			}
			else if(response == 1){
				if(type == 1){
					location.reload();
				}
				if(type == 2){
					$('#not_verify').hide();
					$('#now_verify').show();
				}
			}
			else {
				callSaved(system.somethingWrong, 3);
			}
			$('#boom_code').val('');
		});
	}
}
editProfile = function(){
	$.post('system/box/edit_profile.php', {
		token: utk,
		}, function(response) {
			showEmptyModal(response, 560);
			hideAll();
	});
}
setUserTheme = function(item){
	var theme = $(item).val();
	$.post('system/system_action.php', { 
		set_user_theme: theme,
		token: utk,
		}, function(response) {
			$("#actual_theme").attr("href", "css/themes/" + response + "/" + response + ".css"+bbfv);
	});
}
setUserSound = function(item){
	var set_sound = $(item).val();
	$.post('system/action_profile.php', {
		change_sound: set_sound,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
	});
}
setPrivateMode = function(item){
	var set_priv = $(item).val();
	$.post('system/action_profile.php', {
		set_private_mode: set_priv,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
	});
}
logoutToPage = function(l){
	$.post('login/logout.php', {
		logout_from_system: 1,
		token: utk,
		}, function(response) {
			if(response == 1){
				window.location.href = l;
			}
	});
}
openLogout = function(){
	$.post('system/box/logout.php', {
		token: utk,
		}, function(response) {
			if(response != 0){
				showModal(response);
				hideAll();
			}
			else {
				return false;
			}
	});
}
logOut = function(){
	$.post('login/logout.php', { 
		logout_from_system: 1,
		token: utk,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
	});
}
deleteAvatar = function(){
	$.ajax({
		url: "system/action_profile.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			delete_avatar: 1,
			token: utk
		},
		success: function(response)
		{
			var proAvatar = response.profile_avatar;
			var linkAvatar = response.avatar_link;
			$('.profile_avatar .avatar_spin').html(proAvatar);
			$('.glob_av').attr('src', linkAvatar);
		},
	});
}
updateAvatar = function(){
	$.ajax({
		url: "system/action_profile.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			reload_avatar: 1,
			token: utk
		},
		success: function(response)
		{
			var proAvatar = response.profile_avatar;
			var linkAvatar = response.avatar_link;
			$('.profile_avatar .avatar_spin').html(proAvatar);
			$('.glob_av').attr('src', linkAvatar);
		},
	});
}
saveProfile = function(){
	$.post('system/action_profile.php', { 
		save_profile: '1',
		email: $('#set_profile_email').val(),
		age: $('#set_profile_age').val(),
		gender: $('#set_profile_gender').val(),
		country: $('#set_profile_country').val(),
		region: $('#set_profile_region').val(),
		token: utk
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
			else {
				return false;
			}
	});	
}
saveAbout = function(){
	var mood = '';
	if($('#set_mood').length){
		mood = $('#set_mood').val();
	}
	$.post('system/action_profile.php', { 
		save_about: '1',
		mood: mood,
		about: $('#set_user_about').val(),
		token: utk
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
			else if(response == 2){
				callSaved(system.restrictedContent, 3);
			}
			else if(response == 3){
				callSaved(system.error, 3);
			}
			else {
				return false;
			}
	});	
}
setUserLang = function(){
	var language = $('#set_profile_language').val();
	$.post('system/system_action.php', {
		change_language: language,
		token: utk,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
			else {
				callSaved(system.error, 3);
			}
	});
}
setUserTime = function(){
	var userTime = $('#set_user_timezone').val();
	$.post('system/system_action.php', {
		change_user_timezone: userTime,
		token: utk,
		}, function(response) {
			if(response == 1){
				location.reload();
			}
			else {
				return false;
			}
	});
}
getProfile = function(profile){
	$.post('system/box/profile.php', {
		get_profile: profile,
		cp: curPage,
		token: utk,
		}, function(response) {
			if(response == 1){
				return false;
			}
			if(response == 2){
				callSaved(system.noUser, 3);
			}
			else {
				showEmptyModal(response,530);
			}
	});
}
editUser = function(id){
	$.post('system/box/admin_user.php', {
		edit_user: id,
		token: utk,
		}, function(response) {
			if(response == 99){
				callSaved(system.cantModifyUser, 3);
			}
			else {
				showEmptyModal(response, 530);
			}
	});	
}
saveThisUser = function(id){
	$.post('system/action_staff.php', { 
		set_user_id: id,
		set_user_email: $('#set_user_email').val(),
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			if(response == 1){
				callSaved(system.saved, 1);
			}
			else if(response == 2){
				callSaved(system.emailExist, 3);
			}
			else if(response == 3){
				callSaved(system.invalidEmail, 3);
			}
			else {
				callSaved(system.error, 3);
			}
	});		
}
adminUpdateAvatar = function(id){
	$.ajax({
		url: "system/action_staff.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			admin_reload_avatar: id,
			token: utk
		},
		success: function(response)
		{
			var proAvatar = response.profile_avatar;
			var linkAvatar = response.avatar_link;
			$('.profile_avatar .avatar_spin').html(proAvatar);
			$('.admin_user'+id).attr('src', linkAvatar);
			if(user_id == id){
				$('.glob_av').attr('src', linkAvatar);
			}
		},
	});
}
adminRemoveAvatar = function(id){
	$.ajax({
		url: "system/action_staff.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			remove_avatar: id,
			token: utk
		},
		success: function(response)
		{
			var okDelete = response.ok_delete;
			if(okDelete == 0){
				callSaved(system.cannotUser, 3);
			}
			else {
				var proAvatar = response.profile_avatar;
				var linkAvatar = response.avatar_link;
				$('.profile_avatar .avatar_spin').html(proAvatar);
				$('.admin_user'+id).attr('src', linkAvatar);
				if(user_id == id){
					$('.glob_av').attr('src', linkAvatar);
				}
			}
		},
	});
}
addFriend = function(t, friend, type){
	if(!type){
		type = 0;
	}
	$.post("system/system_action.php", { 
		add_friend: friend,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			else if(response == 1){
				callSaved(system.newFriend, 1);
			}
			else if(response == 2){
				callSaved(system.friendSent, 1);
			}
			else if(response == 3){
				callSaved(system.noUser, 3);
			}
			else if(response == 4){
				callSaved(system.alreadyAction, 3);
			}
			else {
			}
			if(type == 0){
				$(t).remove();
			}
			else if(type == 1){
				$(t).parent().remove();
				if($('.friend_request').length < 1){
					hideModal();
				}
			}
			else {
				return false;
			}
	});
}
declineFriend = function(t, friend){
	$.post("system/system_action.php", {
		remove_friend: friend,
		token: utk,
		}, function(response) {
			$(t).parent().remove();
			if($('.friend_request').length < 1){
				hideModal();
			}
	});
}
removeFriend = function(t, id){
		$.post('system/system_action.php', { 
			remove_friend: id,
			token: utk,
			}, function(response) {
				$(t).parent().remove();
		});
}
removeIgnore = function(t, id){
	$.post('system/system_action.php', { 
		remove_ignore: id,
		token: utk,
		}, function(response) {
			$(t).parent().remove();
	});
}
ignoreUser = function(t, id){
	$.post('system/system_action.php', { 
		add_ignore: id,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			else if(response == 1){
				callSaved(system.ignored, 1);
			}
			else if(response == 2){
				callSaved(system.alreadyAction, 3);
			}
			else {
				callSaved(system.error, 3);
			}
			$(t).remove();
	});
}
changeUsername = function(){
	$.post('system/box/edit_name.php', { 
		token: utk,
		}, function(response) {
			showModal(response);
	});
}
adminChangeName = function(u){
	$.post('system/box/admin_edit_name.php', { 
		target: u,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.error, 3);
			}
			else {
				showModal(response);
			}
	});
}
changeMyUsername = function(){
	var myNewName = $('#my_new_username').val();
	$.post('system/action_profile.php', { 
		edit_username: 1,
		new_name: myNewName,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
				editProfile();
			}
			else if(response == 2){
				callSaved(system.invalidUsername, 3);
				$('#my_new_username').val('');
			}
			else if(response == 3){
				callSaved(system.usernameExist, 3);
				$('#my_new_username').val();
			}
			else {
				callSaved(system.error, 3);
				hideModal();
			}
	});
}
adminSaveName = function(u){
	var myNewName = $('#new_user_username').val();
	$.post('system/action_staff.php', { 
		target_name: u,
		user_new_name: myNewName,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
				editUser(u);
			}
			else if(response == 2){
				callSaved(system.invalidUsername, 3);
				$('#new_user_username').val('');
			}
			else if(response == 3){
				callSaved(system.usernameExist, 3);
				$('#new_user_username').val();
			}
			else {
				callSaved(system.error, 3);
			}
	});
}
saveNameColor = function(newColor){
	$.post('system/action_profile.php', {
		my_username_color: newColor,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
	});
}
changeRank = function(t, target){
	$.post('system/system_action.php', {
		change_rank: $(t).val(),
		target: target,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			else if(response == 1){
				callSaved(system.saved, 1);
			}
			else {
				callSaved(system.error, 3);
			}
	});
}
changeRoomRank = function(t, target){
	$.post('system/action_room.php', {
		change_room_rank: $(t).val(),
		target: target,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
			else {
				callSaved(system.cannotUser, 3);
			}
	});
}
takeAction = function(t, target){
	var checkAction = $(t).val();
	if(checkAction != 'no_action'){
		$.post('system/action.php', {
			take_action: checkAction,
			target: target,
			token: utk,
			}, function(response) {
				if(response == 0){
					callSaved(system.cannotUser, 3);
				}
				else if(response == 1){
					callSaved(system.actionComplete, 1);
				}
				else if(response == 2){
					callSaved(system.alreadyAction, 3);
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
listAction = function(t, act){
	var target = $(t).attr('data');
	closeTrigger();
	$.post('system/action.php', {
		take_action: act,
		target: target,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			else if(response == 1){
				callSaved(system.actionComplete, 1);
			}
			else if(response == 2){
				callSaved(system.alreadyAction, 3);
			}
			else {
				callSaved(system.error, 3);
			}
	});
}
openVerify = function(){
	$.post('system/action_verify.php', {
		open_verify: 1,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.oops, 3);
			}
			else {
				showModal(response);
			}
	});
}
clearUserMood = function(id){
	$.post('system/action_staff.php', {
		clear_mood: id,
		token: utk,
		}, function(response) {
			if(response == 1){
				$('#admin_mood').remove();
			}
			else {
				callSaved(system.error, 3);
			}
	});
}
saveUserColor = function(color, u){
	$.post('system/action_staff.php', {
		user_color: color,
		user: u,
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
removeUserAction = function(elem, u, t){
	$.post('system/action.php', {
		remove_action: 1,
		action_target: u,
		action_type: t,
		token: utk,
		}, function(response) {
			if(response == 0){
				callSaved(system.cannotUser, 3);
			}
			else {
				$(elem).parent().remove();
			}
	});	
}
appLeftMenu = function(aIcon, aText, aCall, optMenu){
	var qmenu = '';
	if(!optMenu){
		optMenu = '';
	}
	qmenu += '<div id="quiz_score_menu" class="list_element left_item" onclick="'+aCall+'">';
	qmenu += '<div class="left_item_in">';
	qmenu += '<span class="boom_menu_icon"><i class="fa fa-'+aIcon+' menui"></i></span>'+aText;
	qmenu += '</div>';
	if(optMenu != ''){
		qmenu += '<div class="left_notify">';
		qmenu += '<span id="'+optMenu+'" class="notif_left bnotify"></span>';
		qmenu += '</div>';
	}
	qmenu += '</div>';
	$(qmenu).insertAfter('#end_left_menu');
}
appMoreMenu = function(mIcon, mText, mCall, optMenu){
	var mmenu = '';
	if(!optMenu){
		optMenu = '';
	}
	mmenu += '<div class="left_item elem_in more_left" onclick="'+mCall+'">';
	mmenu += '<div class="left_item_in">';
	mmenu += '<span class="boom_menu_icon"><i class="fa fa-'+mIcon+'"></i></span>'+mText;
	mmenu += '</div>';
	if(optMenu != ''){
		mmenu += '<div class="left_notify">';
		mmenu += '<span id="'+optMenu+'" class="notif_left bnotify"></span>';
		mmenu += '</div>';
	}
	mmenu += '</div>';
	$(mmenu).insertBefore('#chat_help_menu');
}
cleanData = function(){
	if(boomAllow(8)){
		$.post('system/system_action.php', {
			clean_data: 1,
			token: utk,
			}, function(response) {
				return false;
		});
	}
}
getActionBox = function(){
	$.post('system/box/user_action.php', {
		token: utk,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				showModal(response, 500);
			}
	});	
}

var newsWait = 0;
uploadNews = function(){
	var file_data = $("#news_file").prop("files")[0];
	var filez = ($("#news_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fmw ){
		callSaved(system.fileBig, 3);
	}
	else if($("#news_file").val() === ""){
		callSaved(system.noFile, 3);
	}
	else {
		if(newsWait == 0){
			newsWait = 1;
			postIcon(1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			$.ajax({
				url: "system/file_news.php",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(response){
					var we = response.error;
					if(we > 0){
						if(we == 1){
							callSaved(system.wrongFile, 3);
						}
						postIcon(2);
					}
					else {
						$('#post_file_data').attr('data-key', response.key);
						$('#post_file_data').html(response.file);
					}
					newsWait = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
unsetReport = function(id, type){
	if(type == 1){
		var removeReport = ".crep" + id;
	}
	if(type == 2){
		var removeReport = ".prep" + id;
	}
	$(removeReport).remove();
	$.post('system/action_staff.php', {
		unset_report: id,
		type: type,
		token: utk,
		}, function(response) {
			if(response != 0){
				loadReport();
				$('#report_notify').text(response).show();
			}
			else {
				hideModal();
				$('#report_notify').text('').hide();
			}
	});
}
removeReport = function(id, type){
	if(type == 1){
		var removeReport = ".crep" + id;
	}
	if(type == 2){
		var removeReport = ".prep" + id;
	}
	$(removeReport).remove();
	$.post('system/action_staff.php', {
		remove_report: id,
		type: type,
		token: utk,
		}, function(response) {
			callSaved(system.actionComplete, 1);
			if(response != 0){
				loadReport();
				$('#report_notify').text(response).show();
			}
			else {
				hideModal();
				$('#report_notify').text('').hide();
			}
	});
}
getConsole = function(){
	$.post('system/box/console.php', {
		token: utk,
		}, function(response) {
			if(response == 0){
				return false;
			}
			else {
				showEmptyModal(response, 500);
			}
	});
}
sendConsole = function(){
	var console = $('#console_content').val();
	$.post('system/console.php', {
		run_console: console,
		token: utk,
		}, function(response) {
			if(response == 1){
				callSaved(system.confirmedCommand, 1);
			}
			else if(response == 2){
				callSaved(system.invalidCommand, 3);
			}
			else if(response == 3){
				callSaved(system.error, 3);
			}
			else if(response == 4){
				callSaved(system.noUser, 3);
			}
			else if(response == 5){
				callSaved(system.cannotUser, 3);
			}
			else {
				callSaved(system.invalidCommand, 3);
			}
			$('#console_content').val('');
	});
}
openPlayer = function(){
	$('#player_box').toggle();
}