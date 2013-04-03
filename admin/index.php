<?php
header("Content-type: text/html; charset=utf-8");
require_once("password.php");
require_once("../config/global.php");
require_once("../config/common.php");
session_start();

if( isset($_POST["password"]) )
	$_SESSION['password'] = $_POST["password"];

if($_SESSION['password']!=constant("password")) { ?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
	<form method="post" id="loginbtn">
		<h2>后台管理系统</h2>
    	<input type="password" name="password" placeholder="请在此框内输入密码"/></br>
		<input type="submit" value="登陆" class="btn"/>
	</form>
</body>
</html>
<?php
die();
}
if(!isset($_GET['todo'])) { ?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="all">
    <div id="top">
	<a href="?todo=logout">注销</a> 
	<a href="?todo=showpasswordform">修改密码</a> <br />
    </div>
	<form method="post" action="?todo=seekstudent">
		按学号查询：
		<input name="student_username" />&nbsp&nbsp
		<input type="submit" value="查询" class="btn"/>
	</form>
	<table >
		<tr><th>编号</th><th>视频</th><th>完成人数</th><th></th></tr>
<?php
$arr = array();
$arr2 = array();
$conn = MakeConn();
$sql = "SELECT * FROM video_list";
$result = DataGet($sql);
$n = 0;
while ($row = mysql_fetch_array($result)) {
	$n++;
	$arr[$row['id']] = array('n' => $n, 'name' => $row['name'], 'done' => 0);
}
$sql = "SELECT * FROM watch_log";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$arr[$row['video_id']]['done'] += ($row['minute']==99999)?1:0;
	$arr2[] = $row;
}
foreach ($arr as $id => $row) {
	$n = $row['n'];
	$name = $row['name'];
	$done = $row['done'];
	echo "<tr>
			<td>$n</td>
			<td>$name</td>
			<td>$done</td>
			<td>
				<form id=\"form\" method=\"post\" action=\"?todo=seekvideo\">
			   		<input type=\"hidden\" name=\"vid\" value=\"$id\" />
			   		<input type=\"submit\" value=\"详情\" class=\"btn\"/>
			   	</form>
			</td>
		</tr>";
}
?>
	</table>
<a href="?todo=seekallcomplete">查看所有课程完成学生</a> <br />
<a href="?todo=seekallstudent">查看学生</a> <br />

<div id="feedback">
	反馈
	<table>
		<tr><th>时间</th><th>学号</th><th>姓名</th><th>联系方式</th><th>问题</th><th></th></tr>
<?php
$conn = MakeConn();
$sql = "SELECT * FROM feedback WHERE status IS NULL";
$result = DataGet($sql);
while($row = mysql_fetch_array($result)) {
	$id = $row['id'];
	$q = $row['q'];
	$time = $row['time'];
	$username = $row['studentno'];
	$realname = $row['realname'];
	$number = $row['number'];
	echo "<tr> <td>$time</td> <td>$username</td> <td>$realname</td> <td>$number</td> <td>$q</td> <td><a href=\"?todo=delfeedback&id=$id\">删除</a></td></tr>";
}
?>
	</table>
</div>

</div>
</body>
</html>
<?php
	die();
}
//判断需要做什么
switch($_GET['todo']) {
	case "logout":
		session_destroy();
		header("Location: ./");
		break;
	case "showpasswordform": ?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="modify">
	<form method="post" action="?todo=setnewpassword">
		旧密码：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="password" name="oldpassword"/><br />
		新密码：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="password" name="newpassword"/><br />
		重复新密码：<input type="password" name="newpassword2"/><br />
		<input type="submit" value="设置密码" class="btn" />
	</form>
</div>
</body>
</html>
<?php
		break;
	case "setnewpassword":
		if($_POST['oldpassword']!=constant("password"))
			die("<html><body>旧密码错误<br /><a href=\"?todo=showpasswordform\">返回</a></body></html>");
		if($_POST['newpassword']!=$_POST['newpassword2'])
			die("<html><body>密码不一致<br /><a href=\"?todo=showpasswordform\">返回</a></body></html>");
		if(!preg_match("/^[0-9a-zA-Z]+$/", $_POST['newpassword']))
			die("<html><body>非法字符。请仅使用数字以及大小写英文字母<br /><a href=\"?todo=showpasswordform\">返回</a></body></html>");
		//保存新密码
		$string = "<?php\ndefine(\"password\", \"".$_POST['newpassword']."\");";
		file_put_contents("password.php", $string);
		header("Location: ./");
		break;
	case "seekstudent": 
		$username = $_POST['student_username'];
		if(!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
			die("<html><body>非法字符。<br /><a href=\"./\">返回</a></body></html>");
		}
	?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="video">
	<a href="./">返回</a><br />
	<table>
		<tr>
			<th>编号</th>
			<th>视频</th>
			<th>进度</th>

		</tr>
<?php
$arr = array();
$conn = MakeConn();
$sql = "SELECT * FROM video_list";
$result = DataGet($sql);
$n = 0;
while ($row = mysql_fetch_array($result)) {
	$n++;
	$arr[$row['id']] = array('n' => $n, 'name' => $row['name'], 'time' => $row['minute'], 'done' => 0);
}

$sql = "SELECT watch_log.video_id, watch_log.minute FROM watch_log, user_list WHERE user_list.username='$username' AND user_list.id=watch_log.user_id";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$arr[$row['video_id']]['done'] = $row['minute'];
}

foreach($arr as $row) {
	$n = $row['n'];
	$name = $row['name'];
	$time = $row['done'];
	$alltime = $row['time'];
	if($time=="99999")
		$complete = "完成";
	else
		$complete = strval(round(floatval($time)/floatval($alltime), 2)*100)."%";
	echo "<tr> <td>$n</td> <td>$name</td> <td>$complete</td> </tr>";
}

?>
	</table>
</div>
</body>
</html>
<?php
		break;
	case "seekvideo":
		$vid = $_POST['vid'];
		if(!preg_match("/^[0-9]+$/", $vid)) {
			die("<html><body>非法字符。<br /><a href=\"./\">返回</a></body></html>");
		}
		$arr = array();
		$conn = MakeConn();
		$sql = "SELECT * FROM video_list WHERE id='$vid'";
		$result = DataGet($sql);
		$row = mysql_fetch_array($result);
		$vid_name = $row['name'];
		$alltime = $row['minute'];
	?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="video">
	<a href="./">返回</a><br /><br/>
	<?php echo $vid_name; ?>
	<table>
		<tr>
			<th>学号</th>
			<th>姓名</th>
			<th>进度</th>
			<th></th>
		</tr>
<?php
$sql = "SELECT user_list.username, user_list.realname, watch_log.minute FROM watch_log, user_list WHERE watch_log.video_id='$vid' AND user_list.id=watch_log.user_id";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$username = $row['username'];
	$time = $row['minute'];
	$realname = $row['realname'];
	if($time=="99999")
		$complete = "完成";
	else
		$complete = strval(round(floatval($time)/floatval($alltime), 2)*100)."%";
	echo "<tr>
			<td>$username</td>
			<td>$complete</td>
			<td>$realname</td>
			<td>
				<form id=\"form\" method=\"post\" action=\"?todo=seekstudent\">
			   			<input type=\"hidden\" name=\"student_username\" value=\"$username\" />
			   			<input type=\"submit\" value=\"详情\" class=\"btn\"/>
			   	</form>
			</td>
		  </tr>";
}

?>
	</table>
</div>
</body>
</html>
<?php
		break;
	case "seekallcomplete":
?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="video">
	<a href="./">返回</a><br /><br/>
	所有课程完成学生
	<table>
		<tr><th>学号</th><th>姓名</th></tr>
<?php
$arr = array();
$conn = MakeConn();
$sql = "SELECT * FROM video_list";
$result = DataGet($sql);
$num = mysql_num_rows($result);

$sql = "SELECT * FROM user_list";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$arr[$row['id']]['all_done'] = 0;
	$arr[$row['id']]['username'] = $row['username'];
	$arr[$row['id']]['realname'] = $row['realname'];
}
$sql = "SELECT * FROM watch_log";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$arr[$row['user_id']]['all_done'] += ($row['minute']==99999)?1:0;
}
foreach ($arr as $id => $row) {
	$username = $row['username'];
	$realname = $row['realname'];
	$done = $row['all_done'];
	if($done==$num)
		echo "<tr><td>$username</td><td>$realname</td></tr>";
}
?>
	</table>
</div>
</body>
</html>
<?php
		break;
	case "seekallstudent": ?>
<html>
<head>
	<title>后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="admin.css" />
	<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css" />
</head>
<body>
<div id="video">
	<a href="./">返回</a><br /><br/>
	所有学生
	<table>
		<tr><th>学号</th><th>已学习</th><th></th></tr>
<?php
$conn = MakeConn();
$arr = array();
$sql = "SELECT * FROM user_list";
$result = DataGet($sql);
while ($row = mysql_fetch_array($result)) {
	$arr[$row['id']]['all_done'] = 0;
	$arr[$row['id']]['username'] = $row['username'];
}
//$sql = "SELECT * FROM watch_log";
//$result = DataGet($sql);
foreach($arr2 as $row) {
	$arr[$row['user_id']]['all_done'] += ($row['minute']==99999)?1:0;
}
foreach ($arr as $id => $row) {
	$username = $row['username'];
	$done = $row['all_done'];
	echo "<tr>
			<td>$username</td>
			<td>$done</td>
			<td>
				<form id=\"form\" method=\"post\" action=\"?todo=seekstudent\">
			   		<input type=\"hidden\" name=\"student_username\" value=\"$username\" />
			   		<input type=\"submit\" value=\"详情\" class=\"btn\"/>
			   	</form>
			</td>
		  </tr>";
}
?>
	</table>
</div>
</body>
</html>
<?php
		break;
	case "delfeedback":
		$id = $_GET['id'];
		if(!preg_match("/^[0-9]+$/", $id)) {
			die("<html><body>非法字符。<br /><a href=\"./\">返回</a></body></html>");
		}
		$conn = MakeConn();
		$sql = "UPDATE feedback set status='deleted' where id=$id";
		$result = DataGet($sql);
		header("Location: ./");
		break;
}
