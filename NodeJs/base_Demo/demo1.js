//添加监听器
var http = require('http');
var server = http.createServer();

//为request事件绑定处理函数
//也可以使用server.addListener
server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type': 'text/plain'});;
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();

});

server.listen(1337, '127.0.0.1');
console.log('Server running at http://127.0.0.1:1337/');



//===============================================
//只执行一次的监听器
/*使用emitter.once(event, listener)绑定的事件监听器只会执行一次，然后就会被删除掉。*/

var http = require('http');
var server = http.createServer();

//为request事件绑定处理函数,事件只执行一次
server.once('request', function(req, res){
	res.writeHead(200, { 'Content-Type': 'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end;
});

server.listen(1337, '127.0.0.1');
console.log('Server running at http://127.0.0.1:1337/');



//==================================
//移除监听事件
/*
移除监听器使用emitter.removeListener(event, listener)
*/

var http = require('http');
var server = http.createServer();

function callback(req, res){
	res.writeHead(200, {'Content-Type': 'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();
}

server.on('request', callback);

//移除绑定的监听器callback
server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type': 'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();
});

server.listen(1337, '127.0.0.1');
console.log('Server running at http://127.0.0.1:1337/');

//============================
//移除所有的监听器
//移除所有监听器使用emitter.removeAllListeners([event])。
var http = require('http');
var server = http.createServer();

server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type':'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();
});

server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type':'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();
});


//移除绑定的所有的监听器
server.removeAllListeners('request');

server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type': 'text/plain'});
	res.write('This is write info : Hello poplar');
	console.log('This is console info: Hello poplar');
	res.end();

});

//==========================
/* 设置监听器最大绑定数
emitter.setMaxListeners(n)可以设置同一事件的监听器最大绑定数，
默认情况下，超过10个就会警告提示，这能帮我们快速找到类存泄露的地方。显然，不是所有的事件触发器都限制在10个监听器，
通过这个方法可以设置，如果设置为0就是无限制。
*/

//==============================
/*自定义事件
使用emitter.emit(event, [arg1], [arg2], [...])可以触发自定义的事件。
*/
var http = require('http');
var server = http.createServer();

//绑定自定义事件myevent
server.on('myevent', function(arg){
	console.log(arg);
});

//触发自定义事件
server.emit('myevent', 'Poplar,Come on');

server.listen(1337, '127.0.0.1');
console.log('Server running at http://127.0.0.1');


//==============================
/*
使用EventEmitter.listenerCount(emitter, event)可以查看事件监听器数量。
*/
//查看事件绑定的监听器的个数
var http = require('http');
var event = require('event'); //加载events模块
var server = http.createServer();

server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type':'text/plain'});
	res.write('This is write info :11111');
	console.log('This is console info: 111111');
	res.end();
});

server.on('request', function(req, res){
	res.writeHead(200, {'Content-Type':'text/plain'});
	res.write('This is write info : 22222222');
	console.log('This is console info: 222222');
	res.end();
});

server.listen(1337, '127.0.0.1');
console.log('Server running at http://127.0.0.1');

//查看server绑定的'request'事件的监听器个数
var num = events.EvnetEmitter.listenerCount(server, 'request');
console.log(num);