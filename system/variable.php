<?php
/*
if you are not sure how those settings will affect the system please contact 
us. note that we will not provide support for fixing chat if those value has been
changed wihout proper knowledge of their utility.
*/

// define time variable
$time = ceil(time());

// cookies and sessions variable
$boom_config['prefix'] = 'bc_';

// guest adjustable variable
$boom_config['guest_email'] = 'guest@guest.com';
$boom_config['guest_per_day'] = 12;
$boom_config['guest_delay'] = 30;

// flood adjustment
$boom_config['flood_limit'] = 6;

// default breakpoint and panels in px
$boom_config['right_breakpoint'] = 900;
$boom_config['left_breakpoint'] = 1260;
$boom_config['right_size'] = 250;
$boom_config['left_size'] = 150;

// shared function
function setBoomCookie($i, $p){
	global $boom_config;
	setcookie($boom_config['prefix'] . "userid","$i",time()+ 31556926, '/');
	setcookie($boom_config['prefix'] . "utk","$p",time()+ 31556926, '/');
}
function unsetBoomCookie(){
	global $boom_config;
	setcookie($boom_config['prefix'] . "userid","",time() - 1000, '/');
	setcookie($boom_config['prefix'] . "utk","",time() - 1000, '/');
}
function setBoomLang($val){
	global $boom_config;
	setcookie($boom_config['prefix'] . "lang","$val",time()+ 31556926, '/');
}
function setBoomCookieLaw(){
	global $boom_config;
	setcookie($boom_config['prefix'] . "claw","1",time()+ 31556926, '/');
}
?>