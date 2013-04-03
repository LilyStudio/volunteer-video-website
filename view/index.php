
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
	<div id="header" class="container">
		<div id="navigation" class="container"></div>
	</div>
	<div id="main" class="container row mini-layout panel">
		<div id="left-panel" class="span3">
		<?php
			include ("userprofile.php");
		?>
		</div>
		<div id="right-panel" class="span9">
				<div id="tab-nav" class="tabbable"> <!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs" id="toptab">
						<li class="active"><a href="#allvideo" data-toggle="tab">所有课程</a></li>
						<li><a href="#unfinished" data-toggle="tab">未完成课程</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="allvideo">
							<?php
								include ("allvideo.php");
							?>
						</div>
						<div class="tab-pane" id="unfinished">
							<?php
								include ("unfinished.php");
							?>
						</div>
					</div>
				</div>
		</div>
	</div>
	<div id="footer">
		<!--<div id="infopush" class="container panel"></div>-->
		<div id="copyright" class="container panel">
			<div id="info">
				<span class="info-left">Copyright © NJU Youth League Committee, All Rights Reserved 南京大学团委版权所有</span>
				<span class="info-right"><a  href="http://lilystudio.org/" title="小百合工作室" target="_blank">小百合工作室</a>&nbsp;提供技术支持 </span>
				
			</div>
			<div id="footerline"></div>
		</div>
	</div>
	
	<div id="footerbg">
	
	</div>
</body>

</html>


