

$(document).ready(function($)
{
	var ifielow = $.browser.msie===false?999:$.browser.version;

	//$("#video_autostart").fancybox().trigger('click');
	$(window).bind('hashchange', function() {
		//console.log("hashchange");
		//console.log(window.location.hash);
		if(window.location.hash.substring(0,6) === "#video") {
			var vid = window.location.hash.substring(6);
			$.ajax({
				type: "Get",
				url: "config/videoinfoset.php?vid="+vid,
				data: "vid="+vid,
				success: function (data) {
					$("#video_autostart").attr("href", "/view/player.php?vid="+vid+"&key="+data);
					$("#video_autostart").fancybox().trigger('click');
					window.location.hash = "#";
				},
				error: function (err) {
					pwform_warning("无法载入视频信息！");
				}
			});
		}
	});

	var videowindow = $("#video_autostart");
	if(videowindow.length !== 0)
	{
		videowindow.fancybox({ 
			'width' : 750,
			'height' : 600,
			'autoScale' : true,
			'type' : 'ajax',
			'autoSize' : true,
			'onComplete' : function(){
				if(ifielow>8)
					$('#fancybox-outer, #fancybox-content').corner('6px');
			}
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
			'titleShow' : false,
			'onComplete' : function(){
				if(ifielow>8)
					$('#fancybox-outer, #fancybox-content').corner('6px');
			}
		});
	}

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
