<?php
require_once('global.php');
require_once('common.php');
$oldpass = $_POST['oldpass'];
$newpass = $_POST['newpass'];

if(!preg_match('/^[a-zA-Z0-9]+$/', $oldpass) || !preg_match('/^[a-zA-Z0-9]+$/', $newpass)) {
		?>
	<script>
		alert("修改失败！");
		//$.fancybox.close();
	</script>

	<?php
	die();
}

session_start();
$username = $_SESSION['username'];

$conn = MakeConn();
$sql = "UPDATE user_list SET password='$newpass' WHERE username='$username' AND password='$oldpass'";
$result = DataGet($sql);
if(mysql_affected_rows()==0) {
	?>
	<script>
		alert("修改失败！");
		//$.fancybox.close();
	</script>

	<?php
	
} else {
	?>
	<script>
		alert("修改成功！");
		$.fancybox.close();
	</script>

	<?php

}