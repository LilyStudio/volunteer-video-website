<?php
function fail() {
	$_SESSION['vid'] = '';
	$_SESSION['key'] = '';
	$_SESSION['time'] = '';
	die(":(");
}
require_once('global.php');
require_once('common.php');
IsLoginNeeded();

$vid = $_GET['vid'];
$key = $_GET['key'];

if(!preg_match('/^[0-9]+$/', $vid) || !preg_match('/^[a-zA-Z0-9]+$/', $key)) {
	//hacker?
	//error_log("1");
	fail();
}

$vid_s = $_SESSION['vid'];
if($vid_s != $vid) {
	//error_log("2");
	error_log("session vid wrong");
	fail();
}

$key_s = $_SESSION['key'];
if($key_s != $key) {
	//error_log("3");
	error_log("key wrong");
	fail();
}

$time = $_SESSION['time'];
if(time() - $time > 10) {
	//error_log("4");
	error_log("timeout");
	fail();
}

if(!(preg_match("/Mozilla|Opera|MSIE|AppleWebKit/i", $_SERVER['HTTP_USER_AGENT'])
	&&preg_match("/$key_s|swf/i", $_SERVER['HTTP_REFERER']))) {
	error_log("user_agent wrong");
	fail();
}

$conn = MakeConn();
$sql = "SELECT * FROM video_list WHERE id=$vid";
$result = DataGet($sql);
if(IsDataEmpty($result))
{
	//error_log("5");
	error_log("Video not found?!");
	fail();
}
$row = mysql_fetch_array($result);
$url = '/home/lldev/video/'.$row['url'];
$file_extension = strtolower(substr(strrchr($url,"."),1));
switch($file_extension) { 
		case "flv": $ctype="video/x-flv"; break; 
		case "mp4": $ctype="video/mp4"; break; 
		default: $ctype="application/octet-stream";
}

//$file = fopen($url,"rb");
//if (!$file) {
	//error_log("6");
//	error_log("file not found?!");
//	fail();
//} else {
	$_SESSION['vid'] = '';
	$_SESSION['key'] = '';
	$_SESSION['time'] = '';
	header("Content-type: $ctype");
	header("Cache-Control: no-store, no-cache, must-revalidate");
/*	header('Content-Length: '.filesize($url));
	while (!feof ($file)) {
		echo fread($file,50000);
	}
	fclose ($file); 
*/
	header("X-Sendfile: $url");
//}
