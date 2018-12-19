$(document).ready(function(){
	$('#main_input').submit(function(event){
		var checkbot = $('#content').val();
		if(checkbot.match("^!quiz") ){
			quizLeaderboard();
			event.stopImmediatePropagation();
			return false;
		}
	});
});
quizLeaderboard = function(type){
	$('#content').val('');
	$.post('addons/quizbot/system/leaderboard.php', { 
		token: utk,
		}, function(response) {
		showModal(response);
	});
}