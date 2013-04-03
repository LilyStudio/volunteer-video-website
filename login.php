<?php

defined("_INNER_ACCESS") or die('Access Denied!');	//no direct access

require_once('config/common.php');
$username = $_POST['username'];
$password = $_POST['password'];

if(!preg_match('/^[a-zA-Z0-9]+$/', $username) || !preg_match('/^[a-zA-Z0-9]+$/', $password)) {
	//hacker?
	header("Location: ../#fail");
	die();
}

$sql = "SELECT * FROM user_list WHERE username='$username' AND password='$password'";
$result = DataGet($sql);
if(IsDataEmpty($result))
{
	header("Location: ../");
	die();
}


$row = mysql_fetch_array($result);
$id = $row['id'];
session_start();
$_SESSION['username'] = $username;
$_SESSION['userid'] = $id;
header("Location: ../");


?>