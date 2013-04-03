<html>
	<head>
		<script src="flowplayer/flowplayer-3.2.12.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script language="JavaScript">
			var time_server=0, minute_server=0;

			function _blur(e) {
				/*
				e = e || window.event;
				if (window.ActiveXObject && /MSIE/.test(navigator.userAgent)) {  //IE
					var x = e.clientX;
					var y = e.clientY;
					var w = document.body.clientWidth;
					var h = document.body.clientHeight;

					if (x >= 0 && x <= w && y >= 0 && y <= h) {
    						window.focus();
    						return false;
					}
				}*/

				if(!fullscreen) {
					$f("player").pause();
					//console.log("video paused for losing focus");
				}
				//else
					//console.log("lose focus but continue");
			}

			function admitdata (secs) {
				//secs = Math.floor(secs);
				//console.log("secs: "+secs+" time_server: "+time_server);
				if(secs > time_server) {
					time_server = secs;
					if((Math.floor(time_server%60)==1 && Math.floor(time_server/60)!=minute_server) || secs == 99999*60){
						//console.log("admittime: " + Math.floor(secs/60));
						$.ajax({
							type: "get",
							url: "../config/settime.php?vid="+vid+"&time=" + Math.floor(secs/60),
							success: function(data) {
								//console.log("Server return: "+data);
								if(parseInt(data)!==Math.floor(time_server/60)) {
									alert("Fail to save time. 请刷新页面, 否则时间不会被记录!");
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert("Fail to save time. 请刷新页面, 否则时间不会被记录!");
							}
						});

					}
				}
			}

			

			function updateServerTime() {
				$.ajax({
					type: "get",
					url: "../config/readtime.php?vid="+vid,
					success: function(data) {
						time_server = data*60;
						minute_server = data;
						//console.log("get time from server: " + time_server);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert("Fail to get time_server. 请刷新页面, 否则时间不会被记录!");
					}
				});
			}
			
			vid = "<?php echo $_GET["vid"]; ?>"; 
			//updateServerTime();
			//key = "<?php echo $_GET["key"]; ?>";

			function delayRun(code,time) {
				var t=setTimeout(code,time);
			}

			function jumpto(time) {
				tmp = first_seek;
				first_seek = false;
				setTimeout("$f('player').seek("+time+")", 5);
				setTimeout("first_seek = tmp", 10);
				setTimeout("$f('player').resume()", 10);
			}

			var tmp;
			var first_seek = true;
			var fullscreen = false;

			$(document).ready(function(){
				
				updateServerTime();

				$f("player", "/view/flowplayer/flowplayer-3.2.16.swf",{

					
					onFullscreenExit: function() {
						//console.log("exit fullscreen");
						fullscreen = false;
					},

					onBeforeFullscreen: function() {
						//console.log("before fullscreen");
						fullscreen = true;
					},

					plugins: {
						myContent: {
							url: '/view/flowplayer/flowplayer.content-3.2.8.swf' ,
							top: 20,
							width: 165,
							height: 30,
							borderRadius: 10,
							closeButton: true,
							display: "none",
							style : {

							},

							html: ''
						
						}
					
					
					},



					clip: {
						debug: true ,
						
						start: 0,

						scaling: 'fit',

						quality: 'best',
						
						onBeforeSeek: function (clip,target) {
							//updateServerTime();
							//console.log("onBeforeSeek fired");
							
							if(first_seek) {
								//the target time of first seek is incorrect! bug?
								//console.log("disable first seek");
								first_seek = false;
								return false;
							}
							if (target <= time_server ){
								//console.log("seek to "+target+" is allowed");
								$f("player").getPlugin("myContent").hide();
								return true;
							}
							//console.log("seek to "+target+" is NOT allowed");
							if(time_server - $f("player").getTime() > 2)
								$f("player").getPlugin("myContent").show();
							return false;
						},

						onSeek: function (clip,target) {
							$f("player").getPlugin("myContent").hide();
						},

						onBegin : function (clip) {
							fullLength = clip.fullDuration;
							//console.log("Full length of current clip: " + fullLength);
							//updateServerTime();
							//time_max = time_server;
							//jumpto(0);
							if(time_server!==99999*60&&time_server>0) {
								$f("player").getPlugin("myContent").setHtml("<a href='javascript:jumpto(" + time_server + ")'>单击此处跳转到 " + Math.floor(time_server/60) +" 分 0 秒</a>");
								$f("player").getPlugin("myContent").show();
							}// else {
							//	$f("player").getPlugin("myContent").hide();
							//}
							//console.log("time_max is "+time_max);

							window.setInterval(function() {
								admitdata($f("player").getTime());
								$f("player").getPlugin("myContent").setHtml("<a href='javascript:jumpto(" + time_server + ")'>单击此处跳转到 " + Math.floor(time_server/60) +" 分 " + Math.floor(time_server%60) +" 秒</a>");
								if(time_server - $f("player").getTime() < 2)
									$f("player").getPlugin("myContent").hide();								
																
							},1000);
						},

						onLastSecond : function() {
							admitdata(99999*60);
						}
					}
				});

				/* Video paused on losing focus */
				//version 1:
				$(window).blur(function(e) { _blur(e); });
				//$(window).parent.blur(function(e) { _blur(); });

			});
	
		</script>
	</head>
	<body>
	<div href="/config/video.php?vid=<?php echo $_GET["vid"]; ?>&key=<?php echo $_GET["key"] ; ?>"
    		style="display:block;width:544px;height:324px;"
    		id="player">
		</div>
	
	</body>

</html>
