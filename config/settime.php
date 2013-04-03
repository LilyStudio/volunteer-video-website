<?php
require_once('global.php');
require_once('common.php');
IsLoginNeeded();

$videoid = $_GET["vid"];
$time = $_GET["time"];
$uid = $_SESSION['userid'];

if(!preg_match('/^[0-9]+$/', $videoid) || !preg_match('/^[0-9]+$/', $time)) {
	//hacker?
	error_log("invalid time or video id. vid: ".$videoid." time: ".$time);
	die("0");
}

if(!$_SESSION['cansettime']) {
	//set time directly? no!
	error_log("cannot set time before get time.");
	die("0");
}

if($_SESSION['vid']==$videoid) {
	if(isset($_SESSION['time'])&&$time<>99999) {
		if(time() - $_SESSION['time'] < 50) {
			error_log("time interval too short: ".(time()-$_SESSION['time']));
			die("0");
		}
	}
}

$conn = MakeConn();
$sql = "SELECT * FROM watch_log WHERE user_id=$uid AND video_id=$videoid";
$result = DataGet($sql);
if(IsDataEmpty($result)&&$time==0)
{
	//new record.
	$sql = "INSERT INTO watch_log (user_id, video_id, minute) VALUES ($uid, $videoid, $time)";
} else {
	$row = mysql_fetch_array($result);
	$minute = $row['minute'];
	if($time==99999) {
		//finish
		$sql = "SELECT * FROM video_list WHERE id=$videoid";
		$result = DataGet($sql);
		if(IsDataEmpty($result)) {
			error_log("video id ".$videoid." not found.");
			die("0");
		}
		$row = mysql_fetch_array($result);
		$fulltime = $row['minute'];
		if(abs($fulltime-$minute)>1) {
			error_log("fake finish? delta: ".abs($fulltime-$minute));
			die("0");
		}
	}
	elseif($time <= $minute || $time - $minute > 1) {
		//no need to save, something wrong
		error_log("no need to save. new time: ".$time." old time: ".$minute);
		die("0");
	}
	
	$sql = "UPDATE watch_log SET minute=$time WHERE user_id=$uid AND video_id=$videoid";
}
$result = DataGet($sql);

$_SESSION['time'] = time();
$_SESSION['vid'] = $videoid;

echo $time;
