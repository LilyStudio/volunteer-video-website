<?php
$conn = MakeConn();
//$userpro_id=$_SESSION['userid'];
$userpro_id=$_SESSION['userid'];
$sql_userpro="SELECT * FROM user_list where id=$userpro_id";
$result_userpro=DataGet($sql_userpro);
if(($result_userpro)&&(!IsDataEmpty($result_userpro)))
	$row_userpro=mysql_fetch_array($result_userpro);

$sql_userfinish="SELECT count(*) as cnt FROM watch_log where user_id=$userpro_id and minute=99999";
$sql_allvideo="SELECT count(*) as cnt FROM video_list";
$result_userfinish=DataGet($sql_userfinish);
$result_allvideo=DataGet($sql_allvideo);
$row_userfinish=mysql_fetch_array($result_userfinish);
$row_allvideo=mysql_fetch_array($result_allvideo);


	?>

		<div id="left-panel-wrapper">
			<ul id="username" class="unstyled">
				<li>
					<span><i class="icon-user" ></i><?php echo($row_userpro['realname']); ?></span>
					<div id="config">
						<a class="configwindow" data-fancybox-type="iframe" href="view/changepw.php" title="修改密码"><i class="icon-lock"></i></a>
						<a href="config/logout.php" title="登出系统"><i class="icon-off"></i></a>
					</div>
				</li>
			</ul>
			<div id="avatar">
				<img src="view/image/placeholder.png" class="img-polaroid"/>
			</div>
			<div id="progress">
				<ul id="complete" class="num unstyled">
					<li>
					<p class="progressnum"><?php echo($row_userfinish['cnt']); ?></p>
					<p class="progresslabel">已完成</p>
				</li>
				</ul>
				<ul id="incomplete" class="num unstyled">
					<li>
					<p class="progressnum"><?php echo($row_allvideo['cnt']-$row_userfinish['cnt']); ?>
					<p class="progresslabel">未完成</p>
				</li>
				</ul>
				<div id="progressbar" class="progress progress-success progress-striped">
					<div class="bar" style="width: <?php echo($row_userfinish['cnt']*100.0/$row_allvideo['cnt']); ?>%"></div>
				</div>
			</div>
			<div id="feedback" class="row-fluid"><span class="feedback"><a class="configwindow" data-fancybox-type="iframe" href="view/feedback.php" title="问题反馈"><button class="main-btn span9" id="feedback-btn">
				问题反馈</button></a></span></div>

			

		</div>
