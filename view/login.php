
<!DOCTYPE html PUBliC "-//W3C//dtD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/dtD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<?php IncludeHeader(); ?>
	<link rel="stylesheet" type="text/css" href="view/css/structure.css" />
	<link rel="stylesheet" type="text/css" href="view/css/typography.css" />
	<link rel="stylesheet" type="text/css" href="view/css/bootstrap.css" />
	<link rel="stylesheet" href="view/plugin/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen">
		<!--[if IE 9]>
			<link rel="stylesheet" type="text/css" href="view/css/IE9.css" />
		<![endif]-->  

		<!--[if lt IE 9]>  
			<link rel="stylesheet" type="text/css" href="view/css/IE8.css" />
		<![endif]-->  
		
		<!--[if lt IE 8]>
			<link rel="stylesheet" type="text/css" href="view/css/IE7.css" />
		<![endif]-->


		
		<!--[if gt IE 6]>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">		
		<![endif]-->



		<!--[if IE]> 
		<![endif]-->


	<script type="text/javascript" src="view/js/jquery.min.js"></script>
	<script type="text/javascript" src="view/js/bootstrap.js"></script>
	<script type="text/javascript" src="view/js/jquery.corner.js"></script>
	<script type="text/javascript" src="view/plugin/fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="view/js/common.js"></script>
</head>

<body>
	<div id="header-login" class="container">
	</div>
		<form method="post" onsubmit="return submit_loginform(this);" >
		<div id="login" class="panel container">
				<div id="logintitle"><span>南京大学亚青会志愿者视频培训</span></div>
				<div id="photo">
					<img src="view/image/placeholder_photo.png" class="img-rounded" style=""/>
				</div>
				<div id="login-form-wrapper">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input class="login-input" id="username" type="text" placeholder="Username" name="username">
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="login-input" id="password" type="password" placeholder="Password" name="password">
					</div>
					<!--<label class="checkbox">
						<input type="checkbox" name="rememberme" id="rememberme" checked>
						记住密码
					</label>-->
					<button type="submit" id="login-btn" class="main-btn">Log in</button>
					<a class="configwindow" data-fancybox-type="iframe" href="view/feedback.php" title="问题反馈">
						<button id="feedback-linkbtn" class="btn btn-link">问题反馈</button>
					</a>
				</div>
		</div>
		</form>
		<div id="help" class="panel container">
			<span>1. 初始用户名密码均为学号<br />
			2. 若用户名密码无效或使用中有问题，请点击问题反馈按钮，我们会尽快处理。</span>
		</div>
	<div id="info"  class="container" style="width: 500px;">
		<span class="info-middle loginpage">Copyright © NJU Youth League Committee, All Rights Reserved <br /> 南京大学团委版权所有 <a  href="http://lilystudio.org/" title="小百合工作室" target="_blank">小百合工作室</a>&nbsp;提供技术支持</span>
	</div>
	<div id="footerbg">
	
	</div>
	
</body>

</html>


