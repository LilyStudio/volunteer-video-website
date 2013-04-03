<?php

//defined("_INNER_ACCESS") or die('Access Denied!');	//no direct access

require_once('config.php');


function IncludeHeader()
{
	require_once('./header.php');
}

function MakeConn()
{
	$conn = mysql_connect("localhost", "****", "****");
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("lldev", $conn);
	
	mysql_query("SET NAMES 'utf8'"); 
	mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
	mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
	
	return $conn;
}

function DataGet($sqlstring)
{
	$result = mysql_query($sqlstring);
	
	if(!$result)
		die(mysql_error());
	
	return $result;
}

function IsDataEmpty($result)
{
	$num_rows = mysql_num_rows($result);

	if($num_rows==0) 
		return true;
	
	return false;
}

function IsLoginNeeded()
{
	session_start();
	if(!isset($_SESSION['username'])) 
	{
		?>
		<script type="text/javascript">alert("请先登录！");
		window.location.href="/";

		</script>

		<?php
		die();
	}
}

?>
