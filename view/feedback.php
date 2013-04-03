<?php session_start(); ?>
<div id="feedbackform" class="fancyboxform">

	<h2>问题反馈</h2>
	<form class="form-horizontal" onsubmit="return validate_fbform(this);">
		<div class="control-group" >
			<label class="control-label" for="studentno">学号</label>
			<div class="controls">
				<input type="text" id="studentno" name="oldpass"  placeholder="Student No."
				<?php if (isset($_SESSION['username'])) {
					echo "value='".$_SESSION['username']."'";
					echo " disabled";
				}
				?> >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="name">姓名</label>
			<div class="controls">
				<input type="text" id="name" name="newpass" placeholder="Name" 
				<?php if (isset($_SESSION['username'])) {
					echo "value='".$_SESSION['realname']."'";
					echo " disabled";
				}
				?> >
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="cellno">手机号</label>
			<div class="controls">
				<input type="text" id="cellno" placeholder="Cell No.">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="problem">问题描述</label>
			<div class="controls">
				<textarea rows="5" type="text" id="problem" placeholder="Describe your problem"></textarea>
			</div>
		</div>
		<div id="warninginfo" style="display: none" class="alert alert-error" >
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<span></span>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-inverse">提交问题</button>
			</div>
		</div>
	</form>
</div>