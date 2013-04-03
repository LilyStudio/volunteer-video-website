<?php
require_once('global.php');
require_once('common.php');
//IsLoginNeeded();

$studentno = $_POST['studentno'];
$name = $_POST['name'];
$cellno = $_POST['cellno'];
$problem = $_POST['problem'];

if($studentno==""||$name==""||$cellno==""||$problem=="") {
	error_log("Something missing");
	die("NO");
}

$conn = MakeConn();

$studentno = mysql_real_escape_string(htmlspecialchars($studentno));
$name = mysql_real_escape_string(htmlspecialchars($name));
$cellno = mysql_real_escape_string(htmlspecialchars($cellno));
$problem = mysql_real_escape_string(htmlspecialchars($problem));
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-n-j H:i:s");

//error_log("'$time', '$studentno', '$name', '$cellno', '$problem'");

$sql = "INSERT INTO feedback (time, studentno, realname, number, q) VALUES ('$time', '$studentno', '$name', '$cellno', '$problem')";
$result = DataGet($sql);

echo "OK";
