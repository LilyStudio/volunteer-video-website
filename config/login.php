<?php

define("_INNER_ACCESS",true);

require_once('common.php');
$username = $_POST['username'];
$password = $_POST['password'];


if(!preg_match('/^[a-zA-Z0-9]+$/', $username) || !preg_match('/^[a-zA-Z0-9]+$/', $password)) {
	//hacker?
	echo("error1"); 
	//die();
}

$conn = MakeConn();
$sql = "SELECT * FROM user_list WHERE username='$username' AND password='$password'";
$result = DataGet($sql);
if(IsDataEmpty($result))
{
	echo("error2"); 
	die();
}


$row = mysql_fetch_array($result);
$id = $row['id'];
$realname = $row['realname'];
session_start();
$_SESSION['username'] = $username;
$_SESSION['userid'] = $id;
$_SESSION['realname'] = $realname;
echo("succs"); 


?>
