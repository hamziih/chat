<?php
require('database.php');
date_default_timezone_set("America/Montreal");
$yes = 'installed';
$no = 'not installed';

$gd = $yes;
$curl = $yes;
$mysq = $yes;
$zip = $yes;
$mail = $yes;
$mbs = $yes;

if(!function_exists('mysqli_connect')) {
  $mysq = $no;
}
if(!extension_loaded('gd') && !function_exists('gd_info')) {
	$gd = $no;
}
if (!function_exists('curl_init')) {
	$curl = $no;
}
if (!extension_loaded('zip')) {
	$zip = $no;
}
if(!function_exists('mail')){
	$mail = $no;
}
if(!extension_loaded('mbstring')){
	$mbs = $no;
}
?>
<p>Mysqli: <?php echo $mysq; ?></p>
<p>Server host: <?php echo $_SERVER['SERVER_NAME']; ?></p>
<p>Php version: <?php echo phpVersion(); ?></p>
<p>Curl is on : <?php echo $curl; ?></p>
<p>Gd library : <?php echo $gd; ?></p>
<p>Zip : <?php echo $zip; ?></p>
<p>Mail : <?php echo $mail; ?></p>
<p>Mbstring : <?php echo $mbs; ?></p>
<?php 
if($mysq == $yes && !mysqli_connect_errno()){
	$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	$get_data = $mysqli->query("SELECT * FROM boom_setting WHERE id = '1'");
	if($get_data->num_rows > 0){
		$data = $get_data->fetch_assoc();
		echo '<p>Server host: ' . $_SERVER['SERVER_NAME'] . '</p>';
		echo '<p>Index path : ' . $data['domain'] . '</p>';
	}
	else {
		die();
	}
}
else {
	die();
}
?>