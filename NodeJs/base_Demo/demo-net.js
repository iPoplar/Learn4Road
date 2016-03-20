/*
TCP和UDP的网络编程，net模块提供了一个异步网络包装器，用于TCP网络编程，它包含了创建服务器和客户端的方法。dgram模块用于UDP网络编程。
*/

/*
TCP Server

net模块通过net.createServer方法创建TCP服务器，通过net.connect方法创建客户端去连接服务器。

通过net模块创建一个TCP Server：
*/
//server.js

var net = require('net');

//创建TCP服务器
var server = net.createServer(function(socket){
	console.log('client connected');
	
	//监听客户端的数据
	socket.on('data', function(data){
		console.log('Server got data from client:', data.toString());
	});
	//监听客户端断开连接事件
	socket.on('end', function(data){
		console.log('connection closed');
	});
	//发送数据给客户端
	socket.write('Hello\r\n');
});

//启动服务
server.listen(8080, function(){
	console.log('server bound');
});

/*然后再创建一个客户端：*/
//client.js

var net = require('net');

//连接服务器
var client = net.connect({port: 8080}, function(){
	console.log('connected to server');
	client.write('World!\r\n');
});

//接收服务端的数据
client.on('data', function(data){
	console.log('client got data from server:', data.toString());
	//断开连接
	client.end();
});

//断开连接
client.on('end', function(){
	console.log('disconnected from server');
});


/*
运行测试：

在虚拟机中打开两个终端，先运行TCP服务器代码：

$ node server.js
然后在另一个终端运行TCP客户端代码：

$ node client.js
即可看到两个终端运行结果
*/

//========================
/*
UDP Server

UDP和TCP类似，通过dgram.createSocket创建服务。
*/

//udpServer.js

var dgram = require('dgram');

var server = dgram.createSocket('udp4');

server.on('error', function(err){
	console.log('Server error:\n'+ err.stack);
	server.close();
});

//接收来自客户端的消息
server.on('listening', function(){
	var address = server.address();
	console.log("server listening on" + address.address + ":" + address.port);
});

server.bind(41234);
//server listening 0.0.0.0:41234


//udpClient.js

var dgram = require('dgram');

var client = dgram.createSocket('udp4');
var message = new Buffer('hello shiyanlou');

client.send(message, 0, message.length, 41234, 'localhost', function(err, bytes){
	client.close();
});

//发送的消息必须通过Buffer创建。

/*
然后运行服务端：

$ node server.js
再运行客户端：

$ node client.js
此时，服务端就会收到来自客户端的消息。
*/
