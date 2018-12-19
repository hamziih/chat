$(document).ready(function(){
	$(document).on('click', '#start_install', function() {
		var checkAgree = $('.install_accept').attr('value');
		if(checkAgree == 1){
			checkPermission();
		}
		else {
			callSaved('You must accept condition to start intallation', 3);
		}
	});
	var waitInstall = 1;
	$(document).on('click', '#install_component', function() {
		var b = $('#install_component');
		var c = $('#wait_install');
		if(waitInstall == 1){
			b.hide();
			c.show();
			waitInstall = 0;
			$.post('builder/component.php', { 
				db_host: $('#install_db_host').val(),
				db_name: $('#install_db_name').val(),
				db_user: $('#install_db_user').val(),
				db_pass: $('#install_db_password').val(),
				title: $('#install_title').val(),
				domain: $('#install_domain').val(),
				username: $('#install_username').val(),
				email: $('#install_email').val(),
				password: $('#install_password').val(),
				repeat: $('#install_repeat').val(),
				language: $('#install_language').val(),
				purchase: $('#install_purchase').val()
				}, function(response) {
					if(response == 2){
						callSaved('Please check database information', 3);
					}
					else if(response == 3){
						callSaved('Some fields are not filled up properly', 3);
					}
					else if(response == 4){
						callSaved('Account password not matching', 3);
					}
					else if(response == 5){
						callSaved('Username must be minimum 2 characters and maximum 18', 3);
					}
					else if(response == 6){
						callSaved('Please provide a valid email', 3);
					}
					else if(response == 7){
						callSaved('Domain must contain http://  or https:// and not end with /', 3);
					}
					else if(response == 10){
						callSaved('Invalid or already in use purchase code please contact us for assistance.', 3);
					}
					else if(response == 1){
						getEnding();
					}
					else{
						callSaved('An error occured please contact us for assistance', 3);
					}
					waitInstall = 1;
					c.hide();
					b.show();
			});	
		}
		else {
			return false;
		}
	});
	$(document).on('click', '.install_accept', function() {
		var acVal = $(this).attr('value');
		var ac = $(this);
		if(acVal == 1){
			ac.attr('value', 0);
			ac.removeClass('fa-check-circle').addClass('fa-circle');
		}
		else {
			ac.attr('value', 1);
			ac.removeClass('fa-circle').addClass('fa-check-circle');	
		}
	});
	$(document).on('click', '#check_permission', function() {
			checkPermission();
	});
	$(document).on('click', '#install_done', function() {
			location.reload();
	});
});

function checkPermission(){
	$.post('builder/permission.php', { 
		check: 1,
		}, function(response) {
			if(response == 1){
				getComponent();
			}
			else{
				$('#install_content').html(response);
				callSaved('Please correct following errors', 3);
			}
	});	
}
function getComponent(){
	$.post('builder/element.php', { 
		check: 1,
		}, function(response) {
				$('#install_content').html(response);
				selectIt();
	});	
	
}
function getEnding(){
	$.post('builder/ending.php', { 
		check: 1,
		}, function(response) {
				$('#install_content').html(response);
	});	
	
}
var inKey = '';
var inMail = '';
callSaved = function(text, type){
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
	$('.saved_data').fadeIn(300).delay(3000).fadeOut();
}
selectIt = function(){
	$("select:visible").selectBoxIt({ 
		autoWidth: false,
		hideEffect: 'fadeOut',
		hideEffectSpeed: 100
	});
}