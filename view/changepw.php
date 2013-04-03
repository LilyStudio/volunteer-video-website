
<div id="changepwform">


	<h2>修改密码</h2>
	<form class="form-horizontal" onsubmit="return validate_pwform(this);">
		<div class="control-group" >
			<label class="control-label" for="inputOldpw">原密码</label>
			<div class="controls">
				<input type="password" id="inputOldpw" name="oldpass" placeholder="Old Password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputNewpw">新密码</label>
			<div class="controls">
				<input type="password" id="inputNewpw" name="newpass" placeholder="New Password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputNewpwVal">确认密码</label>
			<div class="controls">
				<input type="password" id="inputNewpwVal" placeholder="Repeat New Password">
			</div>
		</div>
		<div id="warninginfo" style="display: none" class="alert alert-error" >
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<span></span>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-inverse">修改密码</button>
			</div>
		</div>
	</form>
</div>