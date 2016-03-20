/*
http模块主要用于创建http server服务.url模块用于解析url，path模块用于处理和转换文件路径。
*/

//在这个实验中，我们会创建一个简单的http server，所有的代码都放在app这个文件夹中。首先，新建一个文app件夹，在文件夹中新建server.js文件

//创建http server 	server.js
//

//加载所需模块
var http = require('http');
var url = require('url');
var fs = require('fs');

//设置ip和端口
//实际应用中， 可以把这些写到配置文件中
var host = '127.0.0.1',
	port = 8080;

//创建http server
function start(route, handle){
	//参数
	//route 判断url是否存在，存在则调用 handle 处理，不存在则返回404
	//handle 处理不同url请求
	
	//处理request 请求
	function onRequest(req, res){
		//使用 url.parse()方法解析url
		//它会把 url string转化为一个 object
		//这样我们就可以很方便的获取url中的 host, port, pathname 等值了
		var pathname = url.parse(request.url).pathname;
		console.log('Request for' + pathname + 'received.');
		
		//判断并处理不同的url请求
		//后面介绍此方法
		route(handle, pathname, res, req);
	}
	
	//使用 http.creatServer(onRequest).listen(port, host);
	console.log('Server has stared and listening on'+ host + ':' + port);
}

//导出 start 方法
exports.start = start;


//在代码中使用了route()方法，它用于处理判断请求的url是否存在
//现在我们就来编写这个方法。
//
//创建路由		router.js
//

var fs = require('fs');

//路由函数
//处理不同的url的请求
//并返回相应的内容

function route(handle, pathname, res, req) {
	console.log('About to route a request for' + pathname);
	
	//判断此url是否存在特定的处理函数
	//存在则调用 handle 处理
	//不存在则返回404页面
	if(typeof handle[pathname] === 'function'){
		//后面介绍handle函数
		handle[pathname](res, req);
	}else{
		console.log('No request handler found for'+ pathname);
		
		//读取 404 页面
		//所有页面都存放到view文件夹下
		var content = fs.readFileSync('./views/404.html');
		res.writeHead(404, {'Content-Type':'text/html'});
		res.write(content);
		res.end();
	}
}

//导出 route 方法
exports.route = route;



/*在此方法中，调用了handle()方法，这个方法用于处理不同的url请求。
在app文件夹中新建requestHandlers.js文件
*/

//处理url请求

var fs = require('fs');

//home.html 主页
function home(res){
	console.log('Request handler "home" was called.');
	
	//读取 home.html 文件
	var content = fs.readFileSync('./views/home.html');
	res.writeHead(200, {'Content-Type':'text/html'});
	res.write(content);
	res.end();
}

//about.html 关于页面
function about(res){
	console.log('Request handler "about" was called.');
	
	//读取 about.html 文件
	var content = fs.readFileSync('./views/about.html');
	res.write(200, {'Content-Type':'text/html'});
	res.write(content);
	res.end();
}

//导出页面处理函数
exports.home = home;
exports.about = about;

//这个方法比较简单，就是读取文件，然后输出到response。



/*
创建主程序

创建http server，判断url，处理url都写完了，那么我们可以写主程序来运行http server了，在app文件夹新建main.js文件
*/

//引入 server, route及requestHandler
var server = require('./server');
var router = require('./router');
var requestHandlers = require('./requestHandlers');

//保存url 处理方法
var handle = {};
handle['/'] = requestHandlers.home;
handle['/about'] = requestHandlers.about;

//启动http server
server.start(router.route, handle);


/*
到此，所有的服务器代码都写完了，那么我们来添加代码中用到的两个html文件吧

在app文件夹中新建views文件夹，在views文件夹中，新建home.html文件、about.html文件和404.html文件。
*/
/*
//home.html 

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home page</title>
	</head>
	
	<body>
		<p> home page </p>
	</body>		
</html>
*/

/*
//about.html 

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>About page</title>
	</head>
	
	<body>
		<p> about page </p>
	</body>		
</html>
*/

/*
//404.html 

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>404 page</title>
	</head>
	
	<body>
		<p> 404 page not found </p>
	</body>		
</html>
*/


/**************
 运行程序: node main.js
 
 运行成功后，打开浏览器，访问“http://127.0.0.1:8080”就会看到页面显示“home page”，访问“http://127.0.0.1:8080/about”就会看到页面显示“about page”，访问“http://127.0.0.1:8080”下的其他页面就会看到页面显示“404 page not found”。
***************/