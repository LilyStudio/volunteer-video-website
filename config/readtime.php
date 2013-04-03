<?php
require_once('global.php');
require_once('common.php');
IsLoginNeeded();

$videoid = $_GET["vid"];
$_SESSION['cansettime'] = true;

$conn = MakeConn();
$sql = "SELECT * FROM watch_log WHERE user_id='".$_SESSION['userid']."' AND video_id='$videoid'";
$result = DataGet($sql);
if(IsDataEmpty($result))
{
	die("-1");
}
$row = mysql_fetch_array($result);
$minute = $row['minute'];

if($minute=="")
	error_log("readtime fail? $sql");

echo $minute;