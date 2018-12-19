<?php if(boomAllow($addons['addons_access'])){ ?>
<script data-cfasync="false" type="text/javascript">

// define giphy app key
var giphyKey = '<?php echo $addons['custom1']; ?>';
var giphyLimit = 0;
var giphyGifMax = <?php echo $addons['custom2'] ?>;
var giphyStickerMax = <?php echo $addons['custom3'] ?>;
var giphyType = 'gifs';
var giphyBox = 'giphy_gifs';
var giphyTemplate = '';

// define giphy content templates
getGiphy = function(){
	hideEmoticon();
	if(giphyTemplate == ''){
		$.post('addons/giphy/system/giphy_template.php', {
			token: utk,
			}, function(response) {
				showEmptyModal(response, 360);
				resetGiphy();
				giphySearch(1);
				giphyTemplate = response;
		});
	}
	else {
		showEmptyModal(giphyTemplate, 360);
		resetGiphy();
		giphySearch(1);
	}
}
giphyMenuTemplate = function(){
	return '<div class="input_item main_item sub_main main_hide sub_options" onclick="getGiphy();"><i class="fa fa-film input_icon bblock"></i></div>';
}
giphyNoDataTemplate = function(){
	return '<div class="pad_box"><p class="centered_element text_med sub_text">'+system.noResult+'</p></div>';
}
giphyItemTemplate = function(i, o, c, u, t){
	var giphyRes = '';
	if(t == 'stickers'){
		giphyRes = 2;
	}
	return '<div onclick="sendGiphy(\''+i+'\', \''+o+'\', \''+c+'\');" class="giphy_res_box'+giphyRes+'"><img src="'+u+'" autoplay loop></div>';
}

startGiphySearch = function(event, item){
	var giphyContent = $(item).val();
	if(event.keyCode == 13 && event.shiftKey == 0){
		if (/^\s+$/.test(giphyContent) || giphyContent == ''){
			return false;
		}
		else {
			giphySearch(0);
		}
	}
}
resetGiphy = function(){
	giphyType = 'gifs';
	giphyLimit = giphyGifMax;
	giphyBox = 'giphy_gifs';
	$('#'+giphyBox).show();
}
sendGiphy = function(gid, ori, ch){
	hideModal();
	$.post('addons/giphy/system/action.php', {
		origin: ori,
		chat: ch,
		id: gid,
		token: utk,
		}, function(response) {
	});	
}
giphySelect = function(giff, type){
	$('.giphy_results').hide();
	if(type == 2){
		giphyType = 'stickers';
		giphyBox = 'giphy_stickers';
		giphyLimit = giphyStickerMax;
		if($('#'+giphyBox).is(':empty')){
			giphySearch(2);
		}
	}
	else {
		giphyType = 'gifs';
		giphyBox = 'giphy_gifs';
		giphyLimit = giphyGifMax;
		if($('#'+giphyBox).is(':empty')){
			giphySearch(1);
		}
	}
	$('#'+giphyBox).show();
}
giphySet = function(type){
	$('.giphy_results').hide();
	$('#'+type).show();	
}
giphySearch = function(type){
	var giphyData = {};
	var giphyUrl = '';
	if(giphyKey == ''){
		return false;
	}
	else {
		if(type == 1){
			giphyData = {api_key: giphyKey, limit: 8};
			giphyUrl = 'https://api.giphy.com/v1/gifs/trending';
		}
		else if(type == 2){
			giphyData = {api_key: giphyKey, limit: 16};
			giphyUrl = 'https://api.giphy.com/v1/stickers/trending';
		}
		else {
			giphyData = {q: $('#find_giphy').val(),api_key: giphyKey, limit: giphyLimit};
			giphyUrl = 'https://api.giphy.com/v1/'+giphyType+'/search?';
			$('#find_giphy').val('');
		}
		$.ajax({
		  url: giphyUrl,
		  type: 'GET',
		  dataType: 'json',
		  data: giphyData,
		})
		.done(function(data) {
		  if (data.meta.status == 200 && data.data.length > 0) {
			$('#'+giphyBox).html('');
			$('#'+giphyBox).scrollTop(0);
			for (var i = 0; i < data.data.length; i++) {
				$('#'+giphyBox).append(giphyItemTemplate(data.data[i].id, data.data[i].images.original.url, data.data[i].images.fixed_height_small.url, data.data[i].images.fixed_width_small.url, giphyType));
			}
		  }
		  else{
			$('#'+giphyBox).html(giphyNoDataTemplate());
		  }
		})
		.fail(function() {
			return false;
		})
	}
}

$(document).ready(function(){
	$(giphyMenuTemplate()).insertBefore('#main_input_box');
	boomAddCss('addons/giphy/files/giphy.css');
});

</script>
<?php } ?>