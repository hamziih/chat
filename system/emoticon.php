<?php
if(isset($_POST['get_emo']) && isset($_POST['type'])){
	
	$emo = htmlspecialchars($_POST['get_emo']);
	$emo_link = '';
	$emo_search = '';
	$emo_type = 'emoticon';
	$panel_type = htmlspecialchars($_POST['type']);
	
	switch($panel_type){
		case 1:
			$emo_act = 'document.chat_data.content';
			$closetype = 'closesmilies';
			break;
		case 2:
			$emo_act = 'document.private_form.message_content';
			$closetype = 'closesmilies_priv';
			break;
	}
	
	if($emo != 'base_emo'){
		$emo_link = $emo . '/';
		$emo_search = $emo;
	}
	if(stripos($emo, 'sticker') !== false){
		$emo_type = 'sticker';
	}
	if(stripos($emo, 'custom') !== false){
		$emo_type = 'custom_emo';
	}
	$files = scandir('../emoticon/' . $emo_search);
	$load_emo = '';
	foreach ($files as $file) 
	{
		if ($file != "." && $file != "..")
		{
				$smile = preg_replace('/\.[^.]*$/', '', $file);
				if(strpos($file, '.png')){
					$load_emo .= '<div  title=":' . $smile . ':" class="' . $emo_type . ' ' . $closetype . '"><img  src="emoticon/' . $emo_link . $smile . '.png" onclick="emoticon(' . $emo_act . ', \':' . $smile . ':\')"/></div>';;
				}
				if(strpos($file, '.gif')){
					$load_emo .= '<div  title=":' . $smile . ':" class="' . $emo_type . ' ' . $closetype . '"><img  src="emoticon/' . $emo_link . $smile . '.gif" onclick="emoticon(' . $emo_act . ', \':' . $smile . ':\')"/></div>';
				}
		}
	}
	echo $load_emo;
	die();
}
?>