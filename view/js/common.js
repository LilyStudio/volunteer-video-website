hashWatcher = function() {
	var timer, last;
	return {
		register: function(fn, thisObj) {
			if(typeof fn !== 'function') return;
			timer = window.setInterval(function() {
				if(location.hash !== last) {
 					last = location.hash;
					fn.call(thisObj || window, last);
				}
			}, 100);
		},
		stop: function() {
			window.clearInterval(timer);
		},
		set: function(newHash) {
			last = newHash;
			location.hash = newHash;
		},
		setold: function(oldHash) {
			last = oldHash;
		}
	};
}();

function getvideowindow(newhash)
{
			var vid = newhash.substring(6);
			$.ajax({
				async:true, 
    			cache:false, 
    			timeout: 1000, 
				type: "Get",
				url: "config/videoinfoset.php?vid="+vid,
				data: "vid="+vid,
				success: function (data) {
					$("#video_autostart").attr("href", "/view/player.php?vid="+vid+"&key="+data);
					$("#video_autostart").fancybox().trigger('click');
				},
				error: function (err) {
					alert("无法载入视频信息，请重试！");
					window.location.hash = "#";

				}
			});
}

$(document).ready(function($)
{
	var ieversion = $.browser.msie?($.browser.version):888;

	if(window.location.hash.substring(0,6) === "#video") {
		window.location.hash = "#";
	}

	//$("#video_autostart").fancybox().trigger('click');
	$(window).bind('hashchange', function() {
		//console.log("hashchange");
		//console.log(window.location.hash);
		if(window.location.hash.substring(0,6) === "#video") {
			getvideowindow(window.location.hash);
		}
	});
	var videowindowflag=false;
	if(ieversion<8)
	{
		$(".videoj").click(function(){
			var newhash= window.location.hash;
			hashWatcher.setold("");
			hashWatcher.register(getvideowindow(newhash));
		});
	}
	var videowindow = $("#video_autostart");
	if(videowindow.length !== 0)
	{
		videowindow.fancybox({ 
			'width' : 800,
			'height' : 650,
			'autoScale' : false,
			'type' : 'ajax',
			'autoSize' : false
		});
	}

	var fancyconfigwindow = $(".configwindow");

	if(fancyconfigwindow.length !== 0)
	{
		fancyconfigwindow.fancybox({ 
			'width' : 640,
			'height' : 480,
			'autoScale' : false,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'ajax',
			'autoSize' : true,
			'titleShow' : false
		});
	}

	$(window).blur(function(e) {
		var frame = $("#fancybox-frame");
		if(frame.length !== 0)
			window.frames[frame.attr("name")]._blur(e);
	});
});



function pwform_warning(errorinfo)
{
	$("#warninginfo").show();
	$("#warninginfo span").text(errorinfo);
	return;
	
}
function pwform_warning_html(errorinfo)
{
	$("#warninginfo").hide();
	$("#warninginfo span").html(errorinfo);
	return;
	
}


 function post_pwform(oldpw, newpw)
 {
	$.ajax({
		type: "Post",
		url: "config/changepassword.php",
		data: "oldpass="+oldpw+"&newpass="+newpw,
		success: function (data)
		{
			pwform_warning_html(data);
		},
		error: function (err)
		{
			pwform_warning("数据提交错误！");
		}
	});
}

function validate_pwform()
{
	var oldpw=document.getElementById("inputOldpw").value;
	var newpw=document.getElementById("inputNewpw").value;
	var newpwval=document.getElementById("inputNewpwVal").value;
	if(!oldpw)
	{
		pwform_warning("原密码不可为空！");
		$("#inputOldpw").focus();
		return false;
	}
	if(!newpw)
	{
		pwform_warning("新密码不可为空！");
		$("#inputNewpw").focus();
		return false;
	}
	if(!(newpw==newpwval))
	{
		pwform_warning("新密码与确认密码必须相同！");
		$("#inputNewpwVal").focus();
		return false;
	}
	post_pwform(oldpw, newpw);
	return false;
}

 function post_fbform(studentno, name, cellno, problem)
 {
	$.ajax({
		type: "Post",
		url: "config/feedback.php",
		data: "studentno="+studentno+"&name="+name+"&cellno="+cellno+"&problem="+problem,
		success: function (data)
		{
			if(data=="OK")
			{
				alert("提交成功！");
			$.fancybox.close();
			}
			else
			{
				pwform_warning_html("提交失败!");
			}
		},
		error: function (err)
		{
			alert("数据提交错误！");
			$.fancybox.close();
		}
	});

}

function validate_fbform()
{
	var studentno=document.getElementById("studentno").value;
	var name=document.getElementById("name").value;
	var cellno=document.getElementById("cellno").value;
	var problem=document.getElementById("problem").value;
	if(!studentno)
	{
		pwform_warning("学号不可为空！");
		$("#studentno").focus();
		return false;
	}
	if(!name)
	{
		pwform_warning("姓名不可为空！");
		$("#name").focus();
		return false;
	}	
	if(!cellno)
	{
		pwform_warning("手机号码不可为空！");
		$("#cellno").focus();
		return false;
	}
	if(!problem)
	{
		pwform_warning("问题描述不可为空！");
		$("#problem").focus();
		return false;
	}
	post_fbform(studentno, name, cellno, problem);
	return false;
}



function submit_loginform()
{
	post_loginform();
	return false;
}
function post_loginform()
{
	var username=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	$.ajax({
		type: "Post",
		url: "config/login.php",
		data: "username="+username+"&password="+password,
		success: function (data)
		{
			if(data.substring(0,5)==="error")
			{
				alert("用户名密码无效！");
				return false;
			}
			if (data.substring(0,5)==="succs")
			 {
			 	window.location.reload();
			 	return false;
			 };

		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("数据提交错误！");
		}
	});

}