$(document).ready(function(){
});
accessRoom = function(rt, rank){
	var rp = $('#pass_input').val();
	if(user_rank >= rank){
		$.post('system/action_room.php', {
			pass: rp,
			room: rt,
			get_in_room: 1,
			token: utk
			}, function(response) {
			if(response == 10){
				location.reload();
			}
			else if(response == 5){
				callSaved(system.wrongPass, 3);
				$('#pass_input').val('');
			}
			else if(response == 1){
				callSaved(system.error, 3);
			}
			else if(response == 2){
				callSaved(system.accessRequirement, 3);
			}
			else if(response == 3){
				callSaved(system.roomFull, 3);
			}
			else if(response == 4){
				callSaved(system.error, 3);
			}
			else if(response == 99){
				callSaved(system.roomBlock, 3);
			}
			else {
				callSaved(system.error, 3);
			}
		});
	}
	else {
		callSaved(system.accessRequirement, 3);
	}
}
var waitJoin = 0;
switchRoom = function(room, pass, rank){
	if(waitJoin == 0){
		waitJoin = 1;
		if(user_rank >= rank){
			if(pass == 1){
				$.post('system/box/pass_room.php', {
					room_rank: rank,
					room_id: room,
					token: utk
					}, function(response) {
						showModal(response);
						waitJoin = 0;
				});
			}
			else {
				$.post('system/action_room.php', {
					room: room,
					get_in_room: 1,
					token: utk
					}, function(response) {	
					if(response == 10){
						location.reload();
					}
					else if(response == 99){
						callSaved(system.roomBlock, 3);
						waitJoin = 0;
					}
					else if(response == 3){
						callSaved(system.roomFull, 3);
						waitJoin = 0;
					}
					else {
						waitJoin = 0;
						return false;
					}
				});
			}
		}
		else {
			callSaved(system.accessRequirement, 3);
			waitJoin = 0;
		}
	}
	else {
		return false;
	}
}
waitRoom = 0;
addRoom = function(){
	var rType = $("#set_room_type").val();
	var rPass = $("#set_room_password").val();
	var rName = $("#set_room_name").val();
	var rDescription = $("#set_room_description").val();
	var er = $("#error_room");
	if (/^\s+$/.test(rName) || rName == ''){
		callSaved(system.emptyField, 3);
	}
	else {
		if(waitRoom == 0){
			waitRoom = 1;
			$.post('system/action_room.php', { 
				set_name: rName,
				set_type: rType,
				set_pass: rPass,
				set_description: rDescription,
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
				else if (response == 5){
					hideModal();
					callSaved(system.maxRoom, 3);
				}
				else if (response == 6){
					callSaved(system.roomExist, 3);
				}
				else if (response == 7){
					location.reload();
				}
				else {
					waitRoom = 0;
					return false;
				}
				waitRoom = 0;
			});
		}
		else {
			return false;
		}	
	}
}
searchRooms = function(t){
	var searchRoom = $(t).val().toLowerCase();
	if(searchRoom == ''){
		$(".room_box").each(function(){
			$(this).show();
		});	
	}
	else {
		$(".room_box").each(function(){
			var roomData = $(this).text().toLowerCase();
			if(roomData.indexOf(searchRoom) < 0){
				$(this).hide();
			}
			else if(roomData.indexOf(searchRoom) > 0){
				$(this).show();
			}
		});
	}
}
var myRoom = 0;
showMyRoom = function(){
	if(myRoom == 0){
		myRoom = 1;
		$(".room_box").each(function(){
			$(this).hide();
		});	
		$(".owner").each(function(){
			$(this).show();
		});
	}
	else {
		myRoom = 0;
		$(".room_box").each(function(){
			$(this).show();
		});	
	}
}