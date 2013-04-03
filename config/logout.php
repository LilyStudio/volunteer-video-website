<?php
session_start();
session_destroy();

?>
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<?php include("../header.php"); ?>
	</head>

	<body>
		<script type="text/javascript">
		alert("登出成功！");
		window.location.href="/";
		</script>


	</body>
<?php
//header("Location: ../");