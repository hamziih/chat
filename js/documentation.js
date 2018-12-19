$(document).ready(function(){
	
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
	
});