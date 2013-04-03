亲们我解释一下现在的目录结构

根目录下：

	index.php 网站首页。出于模块化考虑，include了三个php，具体见后文。
	
	header.php 用来写入头部固定内容如meta等。




/config：存放与数据库的通信接口等公用函数。

	/config/common.php 公用函数。其中包括：
		IncludeHeader(): 用来在页面中写入header.php的内容，用法：在<head></head>标签里插入此函数。
		MakeConn(): 创建 MySQL 连接，如出错会 die()。某个 php 要用 DataGet($sqlstring) 之前，要 $conn=MakeConn()。
		DataGet($sqlstring): 用于从数据库根据$sql获得查询结果，如出错会 die()。用法：构造一个$sqlstring字符串，然后$result=DateGet($sqlstring)。
		IsDataEmpty($result)：接着$result=DataGet($sqlstring)后面使用，判断sql查询结果是否为0条，若为0条则返回true。
		IsLoginNeeded()：开始session，若用户未登录则报错并提示其登录。用法：在需要登录才可执行的php页面（例如readtime.php)里插入IsLoginNeeded()。


	/config/config.php 数据库连接的基本信息，如用户名、主机名等等。

	/config/global.php 定义了常量_INNER_ACCESS用于确保安全。global.php只被index.php引用，如果用从根目录index.php以外的方式进入其他php页面则报错。
						用法：除了根目录的index.php以外，其他页面在开头加一句  defined("_INNER_ACCESS") or die('Access Denied!');	//no direct access

	/config/readtime.php 用于读取某个视频的播放进度，需要加参数 vid。

	/config/settime.php 用于存储某个视频的进度，应使用ajax方式每分钟访问一次。参数 vid 和 time。

	/config/video.php 获得视频文件用，应将本文件的 URL 传给视频播放器。使用本文件获得视频可防止视频文件被下载。需要传入参数 vid 和 key。
						在传 URL 给播放器之前，应先用 session 保存 vid，key，time()，当本文件被访问是会验证 vid、key 是否一直，以及当前时间和 session 中保存的时间的差。
						验证均通过，开始输出视频数据。


/view：存放整个前端的可见内容。
	/view/index.php 页面的主体实现部分。注意事项：在<head></head>标签里要插入IncludeHeader()函数。

	/js 页面使用的js(文件还没创建)
		/js/jquery.js 大家懂的。
		/js/common.js 每一页都共用的js，例如导航条、搜索框之类的脚本。
		/js/page.js 某页面专用的js，这个名字只是暂取的，页面定下来再改。

	/css 页面使用的css
		/css/structure.css 页面主体结构，各模块的位置和大小等等。注意看里面的书写格式。
		/css/typography.css 各部分字体
		/css/detail.css 除了以上二者以外的东西
		未来还会加上的：bootstrap.css

	/image 页面使用的图像



