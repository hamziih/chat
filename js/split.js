var regSpinner = '<i class="fa fa-spinner fa-spin fa-fw reg_spinner"></i>';
var largeSpinner = '<div class="large_spinner"><i class="fa fa-spinner fa-spin fa-fw boom_spinner"></i></div>';

selectIt = function(){
	$("select:visible").selectBoxIt({ 
		autoWidth: false,
		hideEffect: 'fadeOut',
		hideEffectSpeed: 100
	});
}
hideAll = function(){
	$('.hideall').hide();
}
adjustSubMenu = function(){
	$('#side_menu').hide();
}
hideSubMenu = function(){
	var mobWidth = $(window).width();
	if(mobWidth <= 1024){
		$('.sub_page_menu').hide();
	}
}
var curCall = '';
callSaved = function(text, type){
	var s = 3000;
	if(type == 1){
		s = 1000;
	}
	if(text == curCall && $('.saved_data:visible').length){
		return false;
	}
	else {
		if(type == 1){
			$('.saved_data').removeClass('saved_warn saved_error').addClass('saved_ok');
		}
		if(type == 2){
			$('.saved_data').removeClass('saved_ok saved_error').addClass('saved_warn');
		}
		if(type == 3){
			$('.saved_data').removeClass('saved_warn saved_ok').addClass('saved_error');
		}
		$('.saved_span').text(text);
		$('.saved_data').fadeIn(300).delay(s).fadeOut();
		curCall = text;
	}
}
textArea = function(elem, height) {
    $(elem).css('height', height + 'px');
    $(elem).css('height', (elem.scrollHeight)+"px");
}
loadLob = function(p){
	$.post('system/pages/'+p, { 
		token: utk,
		}, function(response) {
			$('#page_wrapper').html(response);
			selectIt();
			pageTop();
	});
}
loadWrap = function(content){
	$('#page_wrapper').html(content);
	selectIt();
	pageTop();
}
loadFirst = function(){
	if(loadPage != ''){
		$.post(loadPage, { 
			token: utk,
			}, function(response) {
				$('#page_wrapper').html(response);
				selectIt();
		});
	}
}
boomAllow = function(rnk){
	if(user_rank >= rnk){
		return true;
	}
	else {
		return false;
	}
}
isStaff = function(rnk){
	if(rnk >= 8){
		return true;
	}
	else {
		return false;
	}
}
showModal = function(r,s){
	hideLargeModal();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.small_modal_in').css('max-width', s+'px');
	$('#small_modal_content').html(r);
	$('#small_modal').show();
	$('.hide_for_modal').hide();
	offScroll();
	modalTop();
	selectIt();
}
showEmptyModal = function(r,s){
	hideSmallModal();
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('.large_modal_in').css('max-width', s+'px');
	$('#large_modal_content').html(r);
	$('#large_modal').show();
	offScroll();
	modalTop();
	selectIt();
}
showSide = function(content, s){
	if(!s){
		s = 400;
	}
	if(s == 0){
		s = 400;
	}
	$('#side_inside').html(content);
	$('#side_content').css('width', s).show();
	selectIt();
}
closeSide = function(){
	$('#side_inside').html('');
	$('#side_content').hide();
}
hideModal = function(){
	$('#small_modal_content, #large_modal_content').html('');
	$('#small_modal, #large_modal').hide();
	onScroll();
}
hideLargeModal = function(){
	$('#large_modal_content').html('');
	$('#large_modal').hide();
	onScroll();
}
hideSmallModal = function(){
	$('#small_modal_content').html('');
	$('#small_modal').hide();
	onScroll();
}
pageTop = function(){
	$("html, body").animate({ scrollTop: 0 }, "fast");
}
editMyOptions = function(){
	$.post('system/box/user_setting.php', {
		token: utk,
		}, function(response) {
			showModal(response, 460);
			hideAll();
	});
}
modalTop = function(){
	$(".modal_back").animate({ scrollTop: 0 }, "fast");
}
offScroll = function(){
	if(curPage != 'chat'){
		$('body').addClass('modal_open');
	}
}
onScroll = function(){
	if(curPage != 'chat'){
		$('body').removeClass('modal_open');
	}
	else {
		$('body').css('overflow', 'hidden');
	}
}
privatePlay = function(){
	document.getElementById('private_sound').play();	
}
messagePlay = function(){
	document.getElementById('message_sound').play();	
}
usernamePlay = function(){
	document.getElementById('username_sound').play();
}
whistlePlay = function(){
	document.getElementById('whistle_sound').play();
}
notifyPlay = function(){
	document.getElementById('notify_sound').play();
}
newsPlay = function(){
	document.getElementById('news_sound').play();
}
updateSession = function(){
	$.post('system/update_session.php', { 
		token: utk,
		}, function(response) {
			if(response == 0){
				location.reload();
			}
	});
}
modalZone = function(t, val){
	$(t).parent().find('.modal_menu_item').removeClass('modal_selected');
	$(t).addClass('modal_selected');
	$('.modal_zone').hide();
	if(val == 'personal_friends' || val == 'personal_ignores'){
		lazyBoom();
	}
	$('#'+val).fadeIn(200);
	selectIt();
}
tabZone = function(t, val, d){
	$(t).parent().find('.tab_menu_item').removeClass('tab_selected');
	$(t).addClass('tab_selected');
	$('#'+d +' .tab_zone').hide();
	$('#'+val).fadeIn(200);
	selectIt();
}
subModalZone = function(val){
	$('.modal_menu_item').removeClass('modal_selected');
	$('.modal_zone').hide();
	$('#'+val).fadeIn(200);
	selectIt();
}
lazyBoom = function(){
	$(".lazyboom").each(function(){
		$(this).attr('src', $(this).attr('data-img'));
	});
}
closeTrigger = function(){
	$('.drop_list').slideUp(100);
}
getLanguage = function(){
	$.post('system/box/language.php', {
		}, function(response) {
				showModal(response, 240);
	});
}

showRules = function(){
	$.post('system/box/terms.php', {
		}, function(response) {
			showModal(response, 500);
	});
}
showHelp = function(){
	$.post('system/box/help.php', {
		}, function(response) {
			showModal(response, 500);
	});
}
showPrivacy = function(){
	$.post('system/box/privacy.php', {
		}, function(response) {
			showModal(response, 500);
	});
}
backLocation = function(){
	window.history.back();
	hideAll();
}
openSamePage = function(l){
	var addEmbed = '';
	if(pageEmbed == 1){
		addEmbed = '?embed=1';
	}
	window.location.href = l+addEmbed;
}
openLinkPage = function(l){
	window.open(l, '_BLANK');
}
openParentPage = function(l){
	window.open(l, '_PARENT');
}
checkPageHistory = function(){
	if(window.history.length <= 1){
		$('.back_location').hide();
	}
}
getBox = function(f, t, s){
	if(!s){
		s = 0;
	}
	if(curPage == 'chat'){
		closeLeft();
	}
	hideModal();
	hideAll();
	$.post(f, { 
		token: utk,
		}, function(response) {
			if(t == 'modal'){
				showModal(response, s);
			}
			if(t == 'emodal'){
				showEmptyModal(response, s);
			}
			if(t == 'side'){
				showSide(response, s);
			}
			if(t == 'panel' && curPage == 'chat'){
				panelIt(s);
				chatRightIt(response);
			}
			else {
				return false;
			}
			selectIt();
	});	
}
boomAddCss = function(addFile){
	$('head').append('<link rel="stylesheet" href="'+addFile+bbfv+'" type="text/css" />');
}
adjustSide = function(){
		var winHeight = $(window).height();
		var sideTop = $('#side_close').outerHeight();
		$('#side_inside').css({ "height": winHeight - sideTop });	
}
$(document).ready(function(){
	
	loadFirst();
	adjustSide();
	
	if(curPage != 'chat' && logged == 1){
		updateSession();
		var upsess = setInterval(updateSession, 60000);
	}
	
	checkPageHistory();

	$(document).on('click', '.close_modal, .cancel_modal', function(){
		hideModal();
	});
	
	$(document).on('click', '#open_sub_mobile', function(){
		$('#side_menu').toggle();
	});
	
	$(document).on('click', '.mod_select', function(){
		$('.mod_select').removeClass('mod_selected');
		$(this).addClass('mod_selected');
	});
	
	$(document).on('click', '.get_dat', function(){
		var p = $(this).attr('data');
		loadLob(p);
		hideAll();
	});
	
	$(document).on('click', '.open_page', function(){
		hideAll();
		var toPage = $(this).attr('data');
		window.open(toPage, '_blank'); 
	});
	
	$(document).on('click', '.getmenu', function(){
		var getPage = $(this).attr('data');
		window.location.href = getPage;
	});
	
	$(document).on('click', '#open_head_menu', function(){		
		$('#head_menu').toggle();
	});
	
	$(document).on('click', '#main_mob_menu', function(){		
		$('#mobile_main_menu').toggle();
	});
	
	$(document).on('click', '#mobile_main_menu ul li', function(){		
		$('#mobile_main_menu').toggle();
	});
	
	$('#mobile_main_menu ul').on('mouseleave', function() {
		$("#mobile_main_menu").hide();
	});
	
	$(document).on('click', '#open_sub_mobile, #close_sub', function(){		
		$('.sub_page_menu').toggle();
	});
	
	$(document).on('mouseleave', '#head_menu ul', function(){
		$('#head_menu').hide();
	});
	
	$(document).on('click', '.confirm_logout', function() {
		logOut();
	});
	
	$( window ).resize(function() {
		adjustSubMenu();
		adjustSide();
	});
	
	$('.fancybox').fancybox({
	  helpers: {
		overlay: {
		  locked: false
		}
	  }
	});
	
	$(document).on('click', '.getbox', function(){
		if(!$(this).attr('data-type')){
			return false;
		}
		if(!$(this).attr('data-box')){
			return false;
		}
		var dSize = 0;
		var dType = $(this).attr('data-type');
		var dFile = $(this).attr('data-box');
		if($(this).attr('data-size')){
			dSize = $(this).attr('data-size');
		}
		getBox(dFile, dType, dSize);
	});
	
	$(document).on('click', '.docu_head', function(){
		if($(this).next('.docu_content').is(":visible")){
			$(this).next('.docu_content').hide();
		}
		else {
			$( ".docu_content" ).each(function() {
				$(this).hide();
			});
			$(this).next('.docu_content').show();
		}
	});
	
	$(document).on('click', '.intro_language', function(){
		var language = $(this).attr('data-lang');
		$.post('system/load_lang.php', {
			lang: language,
			}, function(response) {
				location.reload();
		});
	});
	
	var modal = document.getElementById('small_modal');	
	var largeModal = document.getElementById('large_modal');
	
	/*
	var modal = document.getElementById('small_modal');	
	var largeModal = document.getElementById('large_modal');	
	window.onclick = function(event) {
		if (event.target == modal || event.target == largeModal) {
			hideModal();
		}
	}
	*/
});