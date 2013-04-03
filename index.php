<?php
	require_once ('config/global.php');
	require_once ('config/common.php');

	if($_SERVER['HTTP_HOST']!="njuvolunteer.info") {
		header("Location: http://njuvolunteer.info/");
		die();
	}

	if(preg_match("/MSIE 6|TencentTraveler|QQBrowser|baidubrowser|MetaSr|theworld|360se/i", $_SERVER['HTTP_USER_AGENT'])) {
		?>
<html>
<head>
	<title>南京大学亚青会网络培训</title>
</head>
<body>
	很抱歉，您的浏览器不兼容本网站。<br />
	请使用最新版 <a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie">IE</a> 或 <a href="https://www.google.com/intl/zh-CN/chrome/browser/">Chrome</a> 浏览器！
</body>
</html>
		<?php
		die();
	}

	session_start();
	if(isset($_SESSION['userid']))
	{
		require_once ('view/index.php');
	}
	else
	{
		require_once ('view/login.php');
	}
?>