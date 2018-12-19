// other used default values
var width = $(window).width(); 
var height = $(window).height();
var docTitle = document.title;
var actualTopic = '';
var actSpeed = '';
var curActive = 0;
var firstPanel = 'userlist';
var morePriv = 1;
var moreMain = 1;
var scroll = 1;
var PageTitleNotification = {
	Vars:{
		Interval: null
	},   
	On: function(notification, intervalSpeed){
		var _this = this;
		_this.Vars.Interval = setInterval(function(){
			 document.title = (docTitle == document.title)
								 ? notification
								 : docTitle;
		}, (intervalSpeed) ? intervalSpeed : 1000);
	},
	Off: function(){
		clearInterval(this.Vars.Interval);
		document.title = docTitle;   
	}
}
focused = true;
window.onfocus = function() {
	focused = true;
	PageTitleNotification.Off();
}
window.onblur = function() {
	focused = false;
}
var fload = 0;
var lastPost = 0;
var cAction = 0;
var privReload = 0;
var lastPriv = 0;
var curNotify = 0;
var curReport = 0;
var curFriends = 0;
var notifyLoad = 0;
var curNews = 0;
var	globNotify = 0;
var curRm = 0;

/*
textReplace = function(t){
	t = t.toString();
	t = t.replace(/%full%/g, 'this is funny');
	return t;
}
*/

chat_reload = function(){
	var cPosted = Date.now();
	var postTime = Date.now() + speed;
	var checkType = $('#main_chat_type').attr('value');
	var priv = $('#get_private').attr('value');
	logsControl();
	$.ajax({
		url: "system/chat_log.php",
		type: "post",
		cache: false,
		dataType: 'json',
		data: { 
			fload: fload,
			caction: cAction,
			taction: tAction,
			last: lastPost,
			snum: snum,
			preload: privReload,
			priv: priv,
			lastp: lastPriv,
			pcount: pCount,
			room: user_room,
			notify: globNotify,
			token: utk
		},
		success: function(response){	
			if(response.check == 99){
				location.reload();
				return false;
			}
			else {
				var answerTime = Date.now();
				var mLogs = response.main_logs;
				var mLast = response.main_last;
				var sesCompare = response.ses_compare;
				var getDel = response.del;
				var checkRank = response.urank;
				var action = response.action;
				var cact = response.cact;
				var pLogs = response.priv_logs;
				var pLast = response.priv_last;
				var getPcount = response.pcount;
				var iconPrivate = response.icon_private;
				var curp = response.curp;
				var newTopic = response.topic;
				var newTaction = response.taction;
				var friendsCount = response.friends;
				var newsCount = response.news;
				var noticeCount = response.notify;
				var reportCount = response.report;
				var setroom = response.setroom;
				var useData = response.use;
				var newNotify = response.nnotif;
				var rm = response.rm;
				balStart = response.acval;
				speed = response.speed;
				uSound = response.user_sound;
				inOut = response.acd;	
				
				if( checkRank != user_rank || action != userAction ){
					location.reload();
				}
				else if(sesCompare != sesid){
					overWrite();
				}
				else if (mLogs == 99 || lastPost == mLast){
					scrollIt(fload);
					if(answerTime < postTime){
						fload = 1;
					}
				}
				else if( mLogs.indexOf("b_o_o_m") >= 1){
					$("#show_chat ul").html(mLogs);
					cAction = cact;
					lastPost = mLast;
					fload = 1;
				}
				else {
					if(answerTime < postTime){
						$("#show_chat ul").append(mLogs);
						if( mLogs.indexOf("my_notice") >= 1 && fload == 1 && uSound > 1){
							usernamePlay();
						}
						if(fload == 1  && uSound > 1){
							messagePlay();
						}
						if(focused == false){
							PageTitleNotification.Off();
							PageTitleNotification.On(system.newMessage);
						}
						cAction = cact;
						lastPost = mLast;
						scrollIt(fload);
						fload = 1;
					}
				}
				beautyLogs();
				for (var i = 0; i < getDel.length; i++){
					$("#log"+getDel[i]).remove();
				}
				if(answerTime < postTime && curp == $('#get_private').attr('value')){
					if(privReload == 1){
						if(pLogs == 99){
							$('#private_content ul').html('');
						}
						else{
							$('#private_content ul').html(pLogs);
						}
						scrollPriv(privReload);
						lastPriv = pLast;
						privReload = 0;
						morePriv = 1;
					}
					else {
						if(pLogs == 99 || lastPriv == pLast){
							scrollPriv(privReload);
						}
						else{
							if(curp == priv){
								$("#private_content ul").append(pLogs);
							}
							scrollPriv(privReload);
						}
						if(getPcount !== pCount  && uSound > 0){
								privatePlay();
								pCount = getPcount;
								if(focused == false){
									PageTitleNotification.Off();
									PageTitleNotification.On(system.newMessage);
								}
						}
						else {
							pCount = getPcount;
						}
						lastPriv = pLast;
					}
				}
				if(answerTime < postTime && newTopic != '' && newTopic != actualTopic){
					$("#show_chat ul").append(newTopic);
					actualTopic = newTopic;
					scrollIt(fload);
					tAction = newTaction;
				}
				if(iconPrivate != 0){
					$("#notify_private").text(iconPrivate);
					$('#notify_private').show();
				}
				else {
					$('#notify_private').hide();
				}
				if(answerTime < postTime && useData == 1){
					if(newsCount > 0){
						$('#news_notify').text(newsCount).show();
						if(!$('#chat_left:visible').length){
							$('#bottom_news_notify').text(newsCount).show();
						}
						if(notifyLoad > 0){
							if(newsCount > curNews){
								newsPlay();
							}
						}
					}
					else {
						$('#news_notify').hide();
						$('#bottom_news_notify').hide();
					}
					if(reportCount > 0){
						$('#report_notify').text(reportCount).show();
					}
					else {
						$('#report_notify').hide();
					}
					if(friendsCount > 0){
						$("#notify_friends").text(friendsCount).show();
					}
					else {
						$("#notify_friends").hide();
					}
					if(noticeCount > 0){
						$("#notify_notify").text(noticeCount).show();
					}
					else {
						$("#notify_notify").hide();
					}
					if(notifyLoad > 0){
						if(noticeCount > curNotify || friendsCount > curFriends || reportCount > curReport){
							notifyPlay();
						}
					}
					grantRoom(setroom);
					curNotify = noticeCount;
					curFriends = friendsCount;
					curReport = reportCount;
					curNews = newsCount;
					globNotify = newNotify;
					notifyLoad = 1;
				}
				checkRm(rm);
				innactiveControl(cPosted);
			}
		},
	});
}
checkRm = function(rmval){
	if(rmval != curRm){
		if(rmval == 1){
			roomBlock();
		}
		else if(rmval == 2){
			fullBlock();
		}
		else {
			unblockAll();
		}
		curRm = rmval;
	}
}
logsControl = function(){
	if($('#show_chat').attr('value') == 1){
		var countLog = $('.ch_logs').length;
		var countLimit = 90;
		var countDiff = countLog - countLimit;
		if(countDiff > 0 && countDiff % 2 === 0){
				$('#chat_logs_container').find('.ch_logs:lt('+countDiff+')').remove();
				moreMain = 1;
		}
	}
}
manageOthers = function(){
	if($('.ch_logs').length > 40){
		var otherElem = $( "#show_chat ul li" ).first();
		if($(otherElem).hasClass("other_logs")){
			$(otherElem).remove();
		}
	}
}
innactiveControl = function(cPost){
	inactiveStart = 2;
	inMaxStaff = 2;
	inMaxUser = 3;
	inIncrement = 125;
	cLatency = (Date.now() - cPost);
	ac = parseInt(balStart);
	sp = parseInt(speed);
	nsp = sp + ((curActive - inactiveStart) * inIncrement);
	msp = sp * inMaxUser;
	if(boomAllow(8)){
		msp = sp * inMaxStaff;
	}
	if(nsp > msp){
		nsp = msp;
	}
	if(ac > 0 && curActive >= inactiveStart){
		clearInterval(chatLog);
		chatLog = setInterval(chat_reload, nsp);
		actSpeed = nsp;
	}
	else {
		clearInterval(chatLog);
		chatLog = setInterval(chat_reload, sp);
		actSpeed = sp;
	}
	$('#current_speed').text(actSpeed);
	$('#current_latency').text(cLatency);
	$('#logs_counter').text($('.ch_logs').length);
}
chatActivity = function(){
	curActive++;
	isInnactive();
}
resetChatActivity = function(){
	curActive = 0;
}
isInnactive = function(){
	if(curActive > inOut && !boomAllow(8) && inOut > 0){
		logOut();
	}
}
roomBlock = function(){
	$('#content, #submit_button, #chat_file').prop('disabled', true);
	if ($('#chat_file').length){
		$("#chat_file")[0].setAttribute("onchange", "doNothing()");
	}
}
fullBlock = function(){
	$('#content, #submit_button, #chat_file, #private_send, #private_file, #message_content').prop('disabled', true);
	if ($('#chat_file').length){
		$("#chat_file")[0].setAttribute("onchange", "doNothing()");
	}
	if ($('#private_file').length){
		$("#private_file")[0].setAttribute("onchange", "doNothing()");
	}
	$(".add_post_container, .add_comment, .do_comment").remove();
}
unblockAll = function(){
	$('#content, #submit_button, #chat_file, #private_send, #private_file, #message_content').prop('disabled', false);
	if ($('#chat_file').length){
		$("#chat_file")[0].setAttribute("onchange", "uploadChat()");
	}
	if ($('#private_file').length){
		$("#private_file")[0].setAttribute("onchange", "uploadPrivate()");
	}
}
doNothing = function(){
	event.preventDefault();
}
chatRightIt = function(data){
	$('#chat_right_data').html(data);
}
warningBox = function(content){
	var bbox = '<div class="pad_box centered_element"><i class="warn fa fa-exclamation-triangle big_icon bmargin10"></i><h3>'+content+'</h3></div>';
	showModal(bbox);
}
beautyLogs = function(){
	$(".ch_logs").removeClass("log2");
	$(".ch_logs:even").addClass("log2");
}
scrollIt = function(f){
	var t = $('#show_chat ul');
	if(f == 0 || $('#show_chat').attr('value') == 1){
		t.scrollTop(t.prop("scrollHeight"));
	}
}
resizeScroll = function(){
	var m = $('#show_chat ul');
	m.scrollTop(m.prop("scrollHeight"));
}
scrollPriv = function(z){
	var p = $('#private_content');
	if(z == 1 || $('#private_content').attr('value') == 1){
		p.scrollTop(p.prop("scrollHeight"));
	}
}
userReload = function(type){
	if($('#container_user:visible').length || type == 1 || firstPanel == 'userlist'){
		if(type == 1){
			panelIt(0);
		}
		if ($('.drop_list:visible').length){
			return false;
		}
		else {
			$.post('system/panel/user_list.php', { 
				token: utk,
				}, function(response) {
				chatRightIt(response);
				firstPanel = '';
			});
		}
	}
}
checkSubItem = function(){
	if($('.sub_options').length){
		$('#ok_sub_item').removeClass('sub_hidden');
	}
}
getTextOptions = function(){
	$.post('system/box/chat_text.php', {
		token: utk,
		}, function(response) {
			showModal(response);
			closeLeft();
	});
}
getChatSub = function(){
	hideEmoticon();
	$('.base_main').addClass('main_hide');
	$('.sub_main').removeClass('main_hide');
}
closeChatSub = function(){
	$('.base_main').removeClass('main_hide');
	$('.sub_main').addClass('main_hide');
}
updateStatus = function(st, zone){
	$('#status_list').toggle();
	$.post('system/action_profile.php', { 
		update_status: st,
		token: utk
		}, function(response) {
			if(response == 1){
				$('#current_status').html($(zone).html());
			}
			else if(response == 2){
				return false;
			}
			else {
				return false;
			}
	});
}
closeRight = function(){
	$("#chat_right").toggle();
}
overWrite = function(){
	$.post('login/logout.php', { 
		overwrite: 1,
		token: utk,
		}, function(response) {
			location.reload();
	});
}
myFriends = function(type){
	if($('#container_friends:visible').length || type == 1){
		if(type == 1){
			panelIt(0);
		}
		$.post('system/panel/friend_list.php', {
			token: utk,
			}, function(response) {
				chatRightIt(response);
		});
	}
}
grantRoom = function(type){
	if(type == 1){
		$('.room_granted').removeClass('nogranted');
	}
	else {
		$('.room_granted').addClass('nogranted');
	}	
}
backHome = function(){
	$.post('system/action_room.php', { 
		leave_room: '1',
		token: utk,
		}, function(response) {
			location.reload();
	});	
}
adjustHeight = function(){
	var winWidth = $(window).width();
	var winHeight = $(window).height();
	var headHeight = $('#chat_head').outerHeight();
	var menuFooter = $('#my_menu').outerHeight();
	var topChatHeight = $('#top_chat_container').outerHeight();
	var sideTop = $('#side_close').outerHeight();
	var panelBar = $('#right_panel_bar').outerHeight();

	var ch = (winHeight - menuFooter - headHeight);
	var ch2 = (winHeight - menuFooter - headHeight);
	var ch3 = (winHeight - menuFooter);
	var cb = (ch - topChatHeight);
	$(".chatheight").css({
		"height": ch2,
	});
	$('#side_inside').css({ "height": winHeight - sideTop });
	if($('#player_box').length){
		$('#player_box').css({ "top": headHeight });
	}
	if(winWidth > leftHide){
		$("#chat_left").removeClass("cleft2").addClass("cleft").css("display", "table-cell");
		$("#warp_show_chat").css({"height": cb});
		$(".pheight").css('height', ch2);
	}
	else {
		$("#chat_left").removeClass("cleft").addClass("cleft2");
		$("#warp_show_chat").css({"height": cb});
		$(".pheight").css('height', ch3);
	}
	if(winWidth > rightHide){
		$("#chat_right").removeClass("cright2").addClass("cright").css("display", "table-cell");
		$(".prheight").css('height', ch2);
		$(".crheight").css('height', ch2 - panelBar);
	}
	else {
		$("#chat_right").removeClass("cright").addClass("cright2");
		$(".prheight").css('height', ch3);
		$(".crheight").css('height', ch3 - panelBar);
	}
}
hidePanel = function(){
	var wh = $(window).width();
	if(wh < leftHide2){
		$("#chat_left").hide();
	}
	if(wh < rightHide2){
		if(!$(".boom_keep:visible").length){
			$("#chat_right").hide();
		}
	}
}
forceHidePanel = function(){
	var wh = $(window).width();
	if(wh < leftHide2){
		$("#chat_left").hide();
	}
	if(wh < rightHide2){
		$("#chat_right").hide();
	}
}
$(function() {
	$( "#private_panel" ).draggable({
		handle: ".private_drag",
		containment: "document",
	});
});
openAvMenu = function(elem, uname, uid, urank){
	var zHeight = $(window).height();
	var offset = $(elem).offset();
	var emoWidth = $(elem).width();
	var emoHeight = $(elem).height();
	var avMenu = $('#av_menu ul').height();
	var avWidth = $('#av_menu ul').width();
	var footHeight = $('#my_menu').outerHeight();
	var inputHeight = $('#top_chat_container').outerHeight();
	var avTop = 0;
	var avLeft = 0;
	
	$('.avitem').attr('data', uid);
	$('.avname').attr('data-name', uname);
	$('#av_menu .gprivate').attr('value', uname);
	
	if(offset.top > zHeight - avMenu - footHeight - inputHeight){
		avTop = offset.top - avMenu + emoHeight;
	}
	else {
		avTop = offset.top;
	}
	if($('#av_menu').css('left') != '-5000px'){
		avLeft = '-5000px';
	}
	else {
		if(rtlMode == 1){
			avLeft = offset.left - (avWidth + 5);
		}
		else {
			avLeft = offset.left + emoWidth + 5;
		}
	}
	$('#av_menu').css({
		'left': avLeft,
		'top': avTop,
		'height': avMenu,
	});	
}
dropUser = function(item, uid, uname, urank, ubot, type){
	$('#action_menu .aclist').attr('data', uid);
	$('#action_menu .aclist_name').attr('value', uname);
	var userDrop = '';
	if(uid != user_id){
		$("#action_menu .rself").each(function(){
			userDrop += $(this)[0].outerHTML;
		});
	}
	$("#action_menu .rglobal").each(function(){
		userDrop += $(this)[0].outerHTML;
	});
	if(urank < user_rank && ubot == 0 && type == 1){
		$("#action_menu .rhigh").each(function(){
			userDrop += $(this)[0].outerHTML;
		});
	}
	if($(item).next('.drop_list').is(":visible")){
		$(item).next('.drop_list').html('').slideUp(100);
	}
	else {
		$( ".drop_list" ).each(function() {
			$(this).html('').hide();
		});
		$(item).next('.drop_list').html(userDrop).slideDown(100);
	}
}
dropControl = function(item){	
	if($(item).next('.drop_list').is(":visible")){
		$(item).next('.drop_list').slideUp(50);
	}
	else {
		$( ".drop_list" ).each(function() {
			$(this).hide();
		});
		$(item).next('.drop_list').slideDown(50);
	}
};
resetAvMenu = function(){
	$('#av_menu').css({
		'left': '-5000px',
	});	
}
closeList = function(){
	$('.drop_list').slideUp(100);
	resetAvMenu();
	hidePanel();
}
function emoticon(target, data){
	var countEmo = $("#content").val();
	var count = ((countEmo.match(/:/g)||[]).length + 2);
	if(count < 42){
		if (document.selection) {
			sel.text = data;
			target.focus();
			sel = document.selection.createRange();
		} 
		else if (target.selectionStart || target.selectionStart == '0') {
			var start = target.selectionStart;
			var end = target.selectionEnd;
			target.value = target.value.substring(0, start) + data + target.value.substring(end, target.value.length);
		} 
		else {
			target.value += data;
		}
	   setTimeout(function() { $(target).focus(); }, 0);
	}
	else {
		setTimeout(function() { $(target).focus(); }, 0);
	}
}
panelIt = function(size){
	if(size == 0){
		$('#chat_right').css('width', defRightWidth+'px');
	}
	else {
		$('#chat_right').css('width', size+'px');
	}
	chatRightIt(largeSpinner);
	if(!$('#chat_right:visible').length){
		$('#chat_right').toggle();
	}
}
openPrivate = function(who, whoName){
	if(who != user_id && who != 999999){
		$('#get_private').attr('value', who);
		if(!$('#private_box:visible').length){
			$('#private_box').toggle();
		}
		$('#private_name p').text(whoName);
		forceHidePanel();
	}
	else {
		return false;
	}
}
closeLeft = function(){
	if($(window).width() < leftHide2 && $('#chat_left:visible').length){
		$('#chat_left').toggle();
	}	
}
getRoomList = function(){
	panelIt(280);
	roomList();
}
uploadIcon = function(target, type){
	var upIcon = $(target).attr('data');
	if(type == 2){
		$('#'+target).removeClass('fa-spinner fa-spin fa-fw').addClass(upIcon);
	}
	else {
		$('#'+target).removeClass(upIcon).addClass('fa-spinner fa-spin fa-fw');
	}
}
var waitUpload = 0;
uploadChat = function(){
	var file_data = $("#chat_file").prop("files")[0];
	var filez = ($("#chat_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fmw ){
		callSaved(system.fileBig, 3);
	}
	else if($("#chat_file").val() === ""){
		callSaved(system.noFile, 3);
	}
	else {
		if(waitUpload == 0){
			waitUpload = 1;
			uploadIcon('chat_file_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			form_data.append("zone", 'chat')
			$.ajax({
				url: "system/file_chat.php",
				dataType: 'script',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(response){
					if(response == 1){
						callSaved(system.wrongFile, 3);
					}
					uploadIcon('chat_file_icon', 2);
					waitUpload = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
uploadPrivate = function(){
	var target = $('#get_private').attr('value');
	var file_data = $("#private_file").prop("files")[0];
	var filez = ($("#private_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fmw ){
		callSaved(system.fileBig, 3);
	}
	else if($("#private_file").val() === ""){
		callSaved(system.noFile, 3);
	}
	else {
		if(waitUpload == 0){
			waitUpload = 1;
			uploadIcon('private_file_icon', 1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			form_data.append("target", target)
			form_data.append("zone", 'private')
			$.ajax({
				url: "system/file_private.php",
				dataType: 'script',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(response){
					if(response == 1){
						callSaved(system.wrongFile, 3);
					}
					if(response == 88){
						callSaved(system.cannotContact, 3);
					}
					uploadIcon('private_file_icon', 2);
					$("#private_file").val("");
					waitUpload = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
getRoomSetting = function(){
	$.post('system/box/room_setting.php', {
		token: utk,
		}, function(response) {
			showModal(response, 500);
			hideAll();
	});
}
saveRoom = function(){
	$.post('system/action_room.php', { 
		save_room: '1',
		set_room_name: $('#set_room_name').val(),
		set_room_description: $('#set_room_description').val(),
		set_room_password: $('#set_room_password').val(),
		set_room_player: $('#set_room_player').val(),
		token: utk

		}, function(response) {
			if(response == 1){
				callSaved(system.saved, 1);
			}
			if(response == 2){
				callSaved(system.roomExist, 3);
			}
			if(response == 3){
				location.reload();
			}
			if(response == 4){
				callSaved(system.roomName, 3);
			}
	});	
}
saveColor = function(){
	var newColor = $('.color_choices').attr('data');
	var newBold = $('#boldit').attr('data');
	$.post('system/action_profile.php', {
		save_color: newColor,
		save_bold: newBold,
		token: utk,
		}, function(response) {
	});
	
}
getWall = function(){
	closeLeft();
	panelIt(400);
	$.post('system/panel/friend_wall.php', {
		token: utk,
		}, function(response) {
		chatRightIt(response);
	});
}
getNews = function(){
	closeLeft();
	panelIt(400);
	$.post('system/panel/news.php', {
		token: utk,
		}, function(response) {
		chatRightIt(response);
		$('#news_notify, #bottom_news_notify').hide();
	});
	
}
waitNews = 0;
sendNews = function(){
	if(waitNews == 0){
		var myNews = $('#news_data').val();
		var news_file = $('#post_file_data').attr('data-key');
		if (/^\s+$/.test(myNews) && news_file == '' || myNews == '' && news_file == ''){
			return false;
		}
		if(myNews.length > 2000){
			return false;
		}
		else{	
			waitNews = 1;
			$.post('system/action_news.php', {
				add_news: myNews,
				post_file: news_file,
				token: utk,
				}, function(response) {
					if(response == 0){
						waitNews = 0;
						return false;
					}
					else {
						$("#container_news").prepend(response);
						$('#container_news .empty_zone').remove();
						$('#news_data').val('').css('height', '34px');
						postIcon(2);
						waitNews = 0;
					}
			});
		}
	}
	else {
		return false;
	}
}
deleteNews = function(t, news){
	$.post('system/action_news.php', {
		remove_news: news,
		token: utk,
		}, function(response) {	
		if(response == 1){
			$(t).parent().parent().remove();
		}
		else {
			return false;
		}
	});
}
friendRequest = function(){
	$('#notify_friends').hide();
	$.post('system/box/friend_request.php', { 
		token: utk,
		}, function(response) {
		showModal(response);
		curFriends = 0;
	});
}
getNotification = function(){
	$('#notify_notify').hide();
	$.post('system/box/notification.php', { 
		token: utk,
		}, function(response) {
		showModal(response, 400);
		curNotify = 0;
	});
}

postIcon = function(type){
	if(type == 2){
		$('#post_file_data').html('').hide();
	}
	else {
		$('#post_file_data').html(regSpinner).show();
	}
	$('#post_file_data').attr('data-key', '');
}
removeFile = function(target){
	postIcon(2);
	$.post('system/action_files.php', {
		remove_uploaded_file: target,
		token: utk,
		}, function(response) {
	});
}
var wallUpload = 0;
uploadWall = function(){
	var file_data = $("#wall_file").prop("files")[0];
	var filez = ($("#wall_file")[0].files[0].size / 1024 / 1024).toFixed(2);
	if( filez > fmw ){
		callSaved(system.fileBig, 3);
	}
	else if($("#wall_file").val() === ""){
		callSaved(system.noFile, 3);
	}
	else {
		if(wallUpload == 0){
			wallUpload = 1;
			postIcon(1);
			var form_data = new FormData();
			form_data.append("file", file_data)
			form_data.append("token", utk)
			$.ajax({
				url: "system/file_wall.php",
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
					wallUpload = 0;
				}
			})
		}
		else {
			return false;
		}
	}
}
var wp = 0;
postWall = function(){
	if(wp == 0){
		var mypost = $('#friend_post').val();
		var post_file = $('#post_file_data').attr('data-key');
		if (/^\s+$/.test(mypost) && post_file == '' || mypost == '' && post_file == ''){
			return false;
		}
		if(mypost.length > 2000){
			return false;
		}
		else{
			wp = 1;
			$.post('system/action_wall.php', { 
				post_to_wall: mypost,
				post_file: post_file,
				token: utk,
				}, function(response) {
					if(response == 2){
						wp = 0;
						return false;
					}
					else if(response == 0){
						callSaved(system.error, 3);
					}
					else {
						$('#container_wall').prepend(response);
						$('#container_wall .empty_zone').remove();
						$('#friend_post').val('').css('height', '34px');
						postIcon(2);
						wp = 0;
					}
			});
		}
	}
	else {
		return false;
	}
}
var wr = 0;
postReply = function(event, id, secret, item) {
	if(event.keyCode == 13 && event.shiftKey == 0){
		var content = $(item).val();
		var code = secret;
		var replyTo = id;
		var updateZone = $(item);
		if (/^\s+$/.test(content) || content == ''){
			return false;
		}
		if(content.length > 1000){
			alert("text is too long");
		}
		else {
			$(item).val('');
			if(wr == 0){
				wr = 1;
				$.post('system/action_wall.php', { 
					content: content,
					code: code,
					reply_to_wall: replyTo,
					token: utk,
					}, function(response) {
						if(response == 1){
							wr = 0;
							return false;
						}
						else {
							$('.cmtbox'+replyTo).prepend(response);
							wr = 0;
						}
				});
			}
			else {
				return false;
			}
		}
	}
	else {
		return false;
	}
}
moreComment = function(t, secret, id){
	var offset = parseInt($(t).attr("data-current"));
	var max = parseInt($(t).attr('data-max'));
	if(max > offset){
		$.post('system/action_wall.php', {
			load_reply: 1,
			current: offset,
			secret: secret,
			id: id,
			token: utk,
			}, function(response) {
				if(response != 0){
					$('.cmtbox'+id).append(response);
				}
				$(t).attr('data-current', offset + 10);
		});
		var newOffset = offset + 10;
		if(newOffset >= max){
			$('.morebox'+id).html('');
		}
	}
	else {
		return false;
	}
}
loadComment = function(id, secret){
	if ($('.cmb'+id+':visible').length){
		$('.cmtbox'+id).html('');
		$('.cmb'+id+' input').val('');
		$('.cmb'+id).hide();
		$('.morebox'+id).html('');
	}	
	else {	
		$.ajax({
			url: "system/action_wall.php",
			type: "post",
			cache: false,
			dataType: 'json',
			data: { 
				load_comment: 1,
				secret: secret,
				id: id,
				token: utk,
			},
			success: function(response){
				var comments = response.reply;
				var more = response.more;
				$('.cmtbox'+id).html(comments);
				$('.cmb'+id).show();
				
				if(more != 0){
					$('.morebox'+id).html(more);
				}
			},
		});
	}
}
showPost = function(i,s) {
	var secret = s;
	var post_id = i;
	$.post('system/box/show_post.php', { 
		show_this_post: 1,
		secret: secret,
		post_id: post_id,
		token: utk,
		}, function(response) {
			hideModal();
			showModal(response, 540);
	});
}
showPostReport = function(id, type, item) {
	var post_id = id;
	$.post('system/box/post_report.php', { 
		post: post_id,
		show_post_report: type,
		token: utk,
		}, function(response) {
			if(response == 1){
				item.remove();
				callSaved(system.alreadyErase, 3);
			}
			else {
				showModal(response, 500);
			}
	});
}
doComment = function(t){
	$('.cmb'+t).show();
	$('.cmb'+t+' input').val('');
}
deleteWall = function(t){
	$.post('system/action_wall.php', { 
		delete_wall_post: t,
		token: utk,
		}, function(response) {
		if(response == 1){
			return false;
		}
		else {
			$('#'+response).remove();
		}

	});
}
likeIt = function(t, id){
	var unCount = parseInt($(t).next('.unlike_count').children('.count').text());
	var liCount = parseInt($(t).find('.count').text());
	$.post('system/action_wall.php', { 
		like: id,
		token: utk,
		}, function(response) {
		if(response == 1){
			$(t).find('.count').text(liCount + 1);
			$(t).addClass("liked");
		}
		else if(response == 2){
			$(t).find('.count').text(liCount - 1);
			$(t).removeClass("liked");
		}
		else if(response == 3){
			$(t).next('.unlike_count').children('.count').text(unCount - 1);
			$(t).next('.unlike_count').removeClass("unliked");
			$(t).find('.count').text(liCount + 1);
			$(t).addClass("liked");
		}
		else {
			return false;
		}
	});
}
unlikeIt = function(t, id){
	var unCount = parseInt($(t).find('.count').text());
	var liCount = parseInt($(t).prev('.like_count').children('.count').text());
	$.post('system/action_wall.php', { 
		unlike: id,
		token: utk,
		}, function(response) {
		if(response == 4){
			$(t).find('.count').text(unCount + 1);
			$(t).addClass("unliked");
		}
		else if(response == 5){
			$(t).find('.count').text(unCount - 1);
			$(t).removeClass("unliked");
		}
		else if(response == 6){
			$(t).prev('.like_count').children('.count').text(liCount - 1);
			$(t).prev('.like_count').removeClass("liked");
			$(t).find('.count').text(unCount + 1);
			$(t).addClass("unliked");
		}
		else {
			return false;
		}
	});
}
var wLoadMore = 0;
moreWall = function(d){
	var actual = parseInt($(d).attr("data-current"));
	var maxCount = parseInt($(d).attr("data-total"));
	if(actual < maxCount && wLoadMore == 0){
		wLoadMore = 1;
		$.post('system/action_wall.php', { 
			load_more_wall: 1,
			offset: actual,
			load_more: 1,
			token: utk,
			}, function(response) {
				$(d).attr("data-current", actual + 10);
				$('#container_wall').append(response);
				var newOf = actual + 10;
				if(newOf >= maxCount){
					$(d).remove();
				}
				wLoadMore = 0;
		});
	}
	else {
		wLoadMore = 0;
		return false;
	}
}
makeReport = function(rpost, type){
	var rReason = $('#report_option').attr('data-r');
	if(rReason == ''){
		callSaved(system.selectSomething, 3);
	}
	else{
		hideModal();
		$.post('system/action_chat.php', { 
			report_post: 1,
			type: type,
			post: rpost,
			reason: rReason,
			token: utk,
			}, function(response) {
				if(response == 1){
					callSaved(system.reported, 1);
				}
				else if(response == 2){
					callSaved(system.alreadyReported, 3);
				}
				else if(response == 3){
					callSaved(system.reportLimit, 3);
				}
				else {
					callSaved(system.error, 3);
				}
		});
	}
}
openReport = function(id, type){
	$.post('system/box/report.php', {
		type: type,
		id: id,
		token: utk,
		}, function(response) {
			if(response == 3){
				callSaved(system.reportLimit, 3);
			}
			else {
				showModal(response);
			}
	});
}
sReport = function(t, reason){
	resetReport();
	$('#report_option').attr('data-r', reason);
	$(t).children('.rcheck').removeClass('fa-circle').addClass('fa-check-circle');
}
resetReport = function(){
	$('.rcheck').removeClass('fa-check-circle').addClass('fa-circle');
	$('#report').attr('data-r', '');
}
loadReport = function(){
	$.post('system/box/show_report.php', { 
		token: utk,
		}, function(response) {
		showModal(response);
	});
}
var targetRoom = '';
accessRoom = function(rt, rank){
	var rp = $('#pass_input').val();
	if(boomAllow(rank)){
		$.post('system/action_room.php', {
			pass: rp,
			room: rt,
			get_in_room: 1,
			token: utk
			}, function(response) {
			if(response == 10){
				hideModal();
				resetRoom(rt);
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
switchRoom = function(room, pass, rank, name){
	targetRoom = name;
	if(room == user_room){
		return false;
	}
	if(waitJoin == 0){
		waitJoin = 1;
		if(boomAllow(rank)){
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
						resetRoom(room);
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
resetRoom = function(troom){
	user_room = troom;
	$("#show_chat ul").html('');
	fload = 0;
	lastPost = 0;
	waitJoin = 0;
	if(targetRoom == ''){
		targetRoom = docTitle;
	}
	document.title = targetRoom;
	docTitle = targetRoom;
	moreMain = 1;
	hideModal();
	if($(window).width() < rightHide2){
		closeRight();
	}
	else {
		userReload(1);
	}
}
roomList = function(){
	$.post('system/panel/room_list.php', { 
		token: utk,
		}, function(response) {
		chatRightIt(response);
	});
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
				from_chat:1,
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
				else if(response.match(/room/)){
					var splt = response.split('|');
					hideModal();
					targetRoom = splt[0];
					resetRoom(splt[2]);
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
streamLook = function(streamType){
	if($(window).width() > 480){
		var swidth = '480';
		var sheight = '270';
		var mtop = '-160';
		var mleft = '-240';
		var maxHeight = 'none';
		var ctheight = 320;
	}
	else {
		return false;
	}
	$("#wrap_stream").css("width", swidth+"px");
	$("#wrap_stream").css("height", sheight+"px");
	$("#wrap_stream").css("max-height", maxHeight);
	$("#wrap_stream").css("min-height", '60px');
	$("#container_stream").css("margin-top", mtop+"px");
	$("#container_stream").css("margin-left", mleft+"px");
	$("#stream_header").css("width",swidth+"px");
	$("#container_stream").css("height", "auto")
	$("#container_stream").css("width", swidth+"px")
	$('#boom_stream_stream').val("");
	$("#stream_panel").hide();
}
hideThisPost = function(elem){
	$(elem).closest( ".other_logs" ).remove();
}
openAddons = function(){
	var addonsContent = $('#addons_loaded').html();
	showModal('<div class="pad_box">'+addonsContent+'<div class="clear"></div></div>');
}
getMonitor = function(){
	$('#monitor_data').toggle();
}
chatInput = function(){
	$('#content').val('');
	if($(window).width() > 768 && $(window).height() > 480){
		$('#content').focus();
	}	
}
showEmoticon = function(){
	if($('.other_emo_box:visible').length){
		$('.other_emo_box').hide();
	}
	$('#main_emoticon').toggle();
	$('#main_emoticon').attr('value', 0);
	if($('#emo_item').attr('value') == 0){
		lazyBoom();
		$('#emo_item').attr('value', 1);
	}
}
hideEmoticon = function(){
	$('#main_emoticon').hide();
}
adjustPanelWidth = function(){
	$('.cright, .cright2').css('width', defRightWidth+'px');
	$('.cleft, .cleft2').css('width', defLeftWidth+'px');
}
openMoreMenu = function(){
	$('#more_menu_list').toggle();
}
registrationMute = function(){
	if(regMute > 0){
		$.post('system/box/registration_mute.php', { 
			token: utk,
			}, function(response) {
				showModal(response);
		});
	}
}

adjustHeight();

// document load start -----------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){
	
	$(document).click(function() {
		resetChatActivity();
	});
	$(document).keydown(function(){
		resetChatActivity();
	});
	
	$('#content, #submit_button').prop('disabled', false);
	$('#container_show_chat').on('click', '#show_chat .username', function() {
		emoticon($('#content')[0], $(this).text() + ' ');
	});
	
	adjustPanelWidth();
	userlist = setInterval(userReload, 30000);
	friendlis = setInterval(myFriends, 30000);
	chatLog = setInterval(chat_reload, speed);
	addBalance = setInterval(chatActivity, 30000);
	clearOtherLogs = setInterval(manageOthers, 30000);
	chat_reload();
	userReload();
	adjustHeight();
	chatActivity();
	registrationMute();
	checkSubItem();
	manageOthers();
	
	var waitReply = 0;
	$('#main_input').submit(function(event){
		var message = $('#content').val();
		if(message == ''){
			event.preventDefault();
		}
		else if(message == '/console' && boomAllow(10)){
			getConsole();
			event.preventDefault();
			chatInput();
		}
		else if(message == '/monitor'){
			getMonitor();
			event.preventDefault();
			chatInput();
		}
		else if (/^\s+$/.test(message)){
			event.preventDefault();
			chatInput();
		}
		else if(message == '/clean'){
			$('.ch_logs').remove();
			chatInput();
			event.preventDefault();
		}
		else{
			chatInput();
			if(waitReply == 0){
				waitReply = 1;
				$.post('system/chat_process.php', {
					content: message,
					snum: snum,
					token: utk,
					}, function(response) {
						if(response == ''){;
						}
						else if(response == 0){
							callSaved(system.cannotUser, 3);
						}
						else if(response == 1){
							callSaved(system.actionComplete, 1);
						}
						else if (response == 2){
							callSaved(system.alreadyAction, 3);
						}
						else if (response == 3){
							callSaved(system.noUser, 3);
						}
						else if (response == 4){
							callSaved(system.error, 3);
						}
						else if (response == 100){
							checkRm(2);
						}
						else if (response == 202){
							callSaved(system.invalidCommand, 3);
						}
						else{
							$('#name').val('');
							$("#show_chat ul").append(response);
							scrollIt(0);
						}
						waitReply = 0;
				});
			}
			else {
				event.preventDefault();
			}
		}
		return false;
	});
	
	$(document).on('click', '.closesmilies', function(){
		if( $('#main_emoticon').attr('value') == 0 ){
			$('#main_emoticon').toggle();
		}
	});
	
	$(document).on('click', '#content, #submit_button', function(){
		var checkLock = $('#main_emoticon').attr('value');
		if(checkLock == 0){
			$('#main_emoticon').hide();
		}
	});
	
	$(document).on('click', '.sub_main', function(){
		closeChatSub();
	});
	
	$(document).on('click', '.emo_menu_item', function(){
		var thisEmo = $(this).attr('data');
		var emoSelect = $(this);
		$.post('system/emoticon.php', { 
			get_emo: thisEmo,
			token: utk,
			type: 1,
			}, function(response) {
				$('#main_emo').html(response);
				$('.emo_menu_item').removeClass('dark_selected');
				emoSelect.addClass('dark_selected');
		});
	});
	
	$(document).on('click', '.emo_menu_item_priv', function(){
		var thisEmo = $(this).attr('data');
		var emoSelect = $(this);
		$.post('system/emoticon.php', { 
			get_emo: thisEmo,
			type: 2,
			token: utk,
			}, function(response) {
				$('#private_emo').html(response);
				$('.emo_menu_item_priv').removeClass('dark_selected');
				emoSelect.addClass('dark_selected');
		});
	});
	
	$(document).on('click', '#emo_item_priv, #emo_close_priv, .closesmilies_priv', function(){
		$('#private_emoticon').toggle();
		if($('#emo_item_priv').attr('value') == 0){
			lazyBoom();
			$('#emo_item_priv').attr('value', 1);
		}
	});
	
	$(document).mouseup(function (e){
		var c = $(".post_drop");
		var c2 = $(".post_options");
		if (!c.is(e.target) && !c2.is(e.target) && c.has(e.target).length === 0){
			c.hide();
		}
	});
	
	$(document).on('click', '#private_close', function(){
		$('#private_content ul').html(largeSpinner);
		$('#get_private').attr('value', 0);
		$('#private_name p').text('');
		$('#private_box').toggle();
		lastPriv = 0;
	});
	
	$(document).on('click', '.gprivate', function(){
		morePriv = 0;
		var thisPrivate = $(this).attr('data');
		var thisUser = $(this).attr('value');
		$('#private_content ul').html(largeSpinner);
		openPrivate(thisPrivate, thisUser);
		closeList();
		hideModal();
		privReload = 1;
		lastPriv = 0;
	});
	
	$(document).on('click', '.delete_private', function(){
		var toDelete = $(this).attr('data');
		var toClear = $(this);
		$.post('system/action_chat.php', { 
			private_delete: toDelete,
			token: utk,
			}, function(response) {
				if(response == 1){
					toClear.parent().hide();
				}
				else {
					return false;
				}
		});
	});
	
	var pWait = 0;
	$('#private_input').submit(function(event){
		var target = $('#get_private').attr('value');
		var message = $('#message_content').val();
		$('#message_content').val('');
		if(message == ''){
			pWait = 0;
			event.preventDefault();
		}
		else if (/^\s+$/.test(message)){
			pWait = 0;
			event.preventDefault();
		}
		else{
			if(pWait == 0){
				pWait = 1;
				$.post('system/private_process.php', {
					target: target,
					content: message,
					token: utk,
					}, function(response) {
					if(response == 10){
						$("#private_content ul").html('');
						$('#message_content').focus();
						scrollPriv(1);
					}
					else if(response == 20){
						$('#message_content').focus();
						callSaved(system.cannotContact, 3);
					}
					else if (response == 100){
						checkRm(2);
					}
					else {
						$('#message_content').focus();
						$("#private_content ul").append(response);
						scrollPriv(1);
					}
					pWait = 0;
				});
			}
			else {
				event.preventDefault();
			}
		}
		return false;
	});
	
	$(document).on('click', '#save_room', function(){
		saveRoom();
	});
	
	$('body').css('overflow', 'hidden');
	
	$(function() {
		if($(window).width() > 1024){
			$( "#private_box" ).draggable({
				handle: "#private_top",
				containment: "document",
			});
		}
	});
	
	$('#show_chat ul').scroll(function() {
		var s = $('#show_chat ul').scrollTop();
		var c = $('#show_chat ul').innerHeight();
		var d = $('#show_chat ul')[0].scrollHeight;
		if(s + c >= d - 100){
			$('#show_chat').attr('value', 1);
		}
		else {
			$('#show_chat').attr('value', 0);
		}
		
	});
	
	$('#private_content').scroll(function() {
		var s = $('#private_content').scrollTop();
		var c = $('#private_content').innerHeight();
		var d = $('#private_content')[0].scrollHeight;
		if(s + c >= d - 100){
			$('#private_content').attr('value', 1);
		}
		else {
			$('#private_content').attr('value', 0);
		}
		
	});
	
	var waitScroll = 0;
	$('#show_chat ul').scroll(function() {
		if(moreMain == 1 && $('#show_chat ul .ch_logs').length != 0){
			var pos = $('#show_chat ul').scrollTop();
			if (pos == 0) {
				if(waitScroll == 0){
					waitScroll = 1;
					var lastlog = $('#show_chat ul .ch_logs').eq(0).attr('id');
					lastget = lastlog.replace('log', '');	
					$.ajax({
						url: "system/action_chat.php",
						type: "post",
						cache: false,
						dataType: 'json',
						data: { 
							more_chat: lastget,
							token: utk
						},
						success: function(response)
						{
							var ccount = response.total;
							var newLogs = response.clogs;

							if(newLogs != 0){
								$("#show_chat ul").prepend(newLogs);
							}
							if(ccount < 60){
								moreMain = 0;
							}
							$("#"+lastlog).get(0).scrollIntoView();
							beautyLogs();
							waitScroll = 0;
						},
					});		
				}
				else {
					return false;
				}
			}
		}
	});
	
	var waitpScroll = 0;
	$('#private_content').scroll(function() {
		if(morePriv == 1){
			var pos = $('#private_content').scrollTop();
			if (pos == 0) {
				if(waitpScroll == 0){
					waitpScroll = 1;
					var lprivate = $('#private_content ul li').eq(0).attr('id');
					var cprivate = $('#get_private').attr('value');
					lastgetp = lprivate.replace('priv', '');	
					$.ajax({
						url: "system/action_chat.php",
						type: "post",
						cache: false,
						dataType: 'json',
						data: { 
							more_private: lastgetp,
							target: cprivate,
							token: utk
						},
						success: function(response)
						{
							var prcount = response.total;
							var newpLogs = response.clogs;

							if(newpLogs != 0){
								$("#private_content ul").prepend(newpLogs);
							}
							if(prcount < 30){
								morePriv = 0;
							}
							$("#"+lprivate).get(0).scrollIntoView();
							waitpScroll = 0;
						},
					});		
				}
				else {
					return false;
				}
			}
		}
	});
	
	$(document).on('click', '.user_choice', function() {	
		var curColor = $(this).attr('data');
		if($('.color_choices').attr('data') == curColor){
			$('.bccheck').remove();
			$('.color_choices').attr('data', '');
		}
		else {
			$('.bccheck').remove();
			$(this).append('<i class="bccheck fa fa-check"></i>');
			$('.color_choices').attr('data', curColor);
		}
		saveColor();
	});

	$(document).on('keydown', function(event) {
		if( event.which === 13 && event.ctrlKey && event.altKey ) {
			getMonitor();
		}
	});	

	$(document).on('click', '#boldit', function() {	
		var curBold = $(this).attr('data');
		if(curBold == 'bolded'){
			$(this).attr('data', '').removeClass('theme_btn').addClass('default_btn');
		}
		else {
			$(this).attr('data', 'bolded').removeClass('default_btn').addClass('theme_btn');
		}
		saveColor();
	});
		
	$(document).on('mouseleave', '#av_menu ul', function(){
		resetAvMenu();
	});
	
	$(document).on('click', '.closeright', function(){		
		closeRight();
	});
	
	$(document).on('click', '#back_home', function(){
		backHome();
	});

	$(document).on('click', '.menu_header', function() {
		if ($('.menu_drop:visible').length){
			$(".menu_drop").fadeOut(100);
		}
		else {
			$(".menu_drop").fadeIn(200);
		}
		$("#wrap_options").fadeOut(100);
	});
	
	$(document).on('click', '.other_panels, .addon_button, .head_li, #content', function(){
		$(".menu_drop, #wrap_options").fadeOut(100);
	});
	
	var addons = '';
	
	getPrivate = function(){
		$.post('system/box/private_notify.php', {
			token: utk,
			}, function(response) {
				showEmptyModal(response, 400);
		});
	}
	
	clearPrivateList = function(){
		$.post('system/action_chat.php', {
			clear_private: 1,
			token: utk,
			}, function(response) {
				hideModal();
		});
	}
	
	var curDel = 1000;
	
	$(document).on('click', '#show_chat .delete_log', function() {
		
		var delTime = Math.round(new Date() / 1000);
		
		if(delTime > ( curDel + 5 )){
			var delType = 0;
		}
		else {
			var delType = 1;
		}
		
		curDel = delTime;
		
		var del_post = $(this).attr('value');
		$.post('system/action_chat.php', {
				del_post: del_post,
				type: delType,
				token: utk,
				}, function(response) {	
					$("#log"+del_post).remove();
		});
	});
	
	$(document).on('click', '#close_right', function(){
		closeRight();
	});
	
	$(document).on('click', '#open_left_menu', function(){
		$('#chat_left').toggle();
	});
	
	$( window ).resize(function() {
		adjustHeight();
		resizeScroll();
		hidePanel();
	});
	
	$(document).on('change, paste, keyup', '#search_friend', function(){
		var searchFriend = $(this).val().toLowerCase();
		if(searchFriend == ''){
			$(".fitem").each(function(){
				$(this).show();
			});	
		}
		else {
			$(".fitem").each(function(){
				var fdata = $(this).text().toLowerCase();
				if(fdata.indexOf(searchFriend) < 0){
					$(this).hide();
				}
				else if(fdata.indexOf(searchFriend) > 0){
					$(this).show();
				}
			});
		}
	});
	
	$(document).on('click', '.cur_status', function(){		
		$('#status_list').toggle();
	});
	
	$(document).on('click', '.open_addons', function(){		
		$('#addons_chat_list').toggle();
	});
	
	$(document).on('click', '.status_option', function(){		
		var t = $(this);
		var newStatus = $(this).attr('data');
		updateStatus(newStatus, t);
	});
	
	$(document).on('click', '.more_left', function(){		
		$('#more_menu_list').toggle();
		closeLeft();
	});
	
	$('#container_stream').on('click', '#close_stream', function(){
		$("#wrap_stream iframe").attr("src", "");
		$("#container_stream").hide();
	});
	
	$(function() {
		$( "#container_stream" ).draggable({
			containment: "document",
			scroll: false
		});
		$( "#stream_panel" ).draggable({
			containment: "document",
			scroll: false
		});
	});
	$(function() {
		$( "#wrap_stream" ).resizable({
             aspectRatio: true,
			 minWidth: 320,
			 containment: "document",
			 handles: "se",
        });
	});
	$("#wrap_stream").resize(function() {
		var streamWidth = $("#wrap_stream").width();
		var streamHeight = $("#wrap_stream").outerHeight();
		var streamHead = $("#stream_header").outerHeight();
		
		$("#stream_header, #container_stream").css("width", streamWidth);
		$("#container_stream").css("height", streamHeight + streamHead);
	});
	
	$(document).on('click', '.boom_youtube', function(event){
		event.preventDefault();
		if($(window).height() > 400 && $(window).width() > 400 || streamMobile == 1 && $(window).height() > 400){
			var streamType = $(this).attr("value");
			streamLook(streamType);
			$("#container_stream").fadeIn(300);
			var linkto = $(this).attr("data");
			$("#wrap_stream iframe").attr("src", linkto);
		}
		else {
			alert(streamAvail);
		}
		
	});
	
});