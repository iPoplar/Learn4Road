/*
process模块在前面的实验已经用过了，使用时直接通过全局变量process访问，而不需要通过require方法加载。process用来和当前Node.js程序进程互动。

process是EventEmitter的一个实例，process主要包含退出事件、信号事件以及一些属性。
*/


/*
退出事件（exit）

当退出当前进程时，会促发exit事件，exit事件的回调函数中只接受同步操作，并且回调函数只接受一个参数，即退出代码，如：
*/
process.on('exit', function(code){
	setTimeout(function(){
		console.log('This will not run');
	}, 0);
	
	console.log('exit code:', code);
});

/*
运行上面的代码，其中setTimeout方法中的回调函数是不会被执行的，因为exit事件中只会运行同步操作，而不会运行异步操作。

在exit事件之前还有一个beforeExit事件会被触发，在beforeExit的回调函数中可以执行异步操作。值得注意的是，通过process.exit()退出程序或者因为发生错误而退出程序是不会触发beforeExit事件的。顺便说一下，当有错误未被捕获时，就会触发uncaughtException事件。
*/


/*
信号事件

信号事件就是接收到某个特定信号才会被触发的事件。

比如SIGINT事件的触发方式是ctrl+c：
*/
//sigint.js
process.stdin.resume();

process.on('SIGINT', function(){
	console.log('Got SIGINT. Press Control-D to exit');
});

/*
运行代码：

$ node sigint.js
然后按住control键，再按C键就会触发SIGINT事件。
*/


/*
属性

process模块提供了很多属性，其中关于IO输入输出的主要有三个：

process.stdin  // 标准输入
process.stdout // 标准输出
process.stderr // 标准错误
举例：
*/
// stdin.js
process.stdin.setEncoding('utf8');

process.stdin.on('readable', function() {
    var chunk = process.stdin.read();
    if (chunk !== null) {
        process.stdout.write('data: ' + chunk);
    }
});

process.stdin.on('end', function() {
    process.stdout.write('end');
});

/*
运行：

node stdin.js
输入任意字符，Node.js会把输入的字符打印出来，输入ctrl+D触发end事件。

还有其他属性，比如process.argv是一个包含了命令行参数的数组。
*/


/*
方法

process模块还有很多实用的方法，比如：

process.cwd()   // 返回脚本运行工作目录
process.chdir() // 切换工作目录
process.exit()  // 退出当前进程
process.on()    // 添加监听事件
//...
*/



/*
child_process模块

child_process用于创建子进程。

child_process.spawn()方法

通过当前命令启动一个新的进程。如：*/

// test_spawn.js
var spawn = require('child_process').spawn,
    ls    = spawn('ls', ['-lh', '/usr']);

ls.stdout.on('data', function (data) {
    console.log('stdout: ' + data);
});

ls.stderr.on('data', function (data) {
    console.log('stderr: ' + data);
});

ls.on('close', function (code) {
    console.log('child process exited with code ' + code);
});
/*
运行命令：

$ node test_spawn.js
从结果可以看出，子进程成功运行了ls -lh /usr命令。*/

//child_process.exec()方法

//在shell中运行一个命令，并缓存其输出。如：

// test_exec.js
var exec = require('child_process').exec,
    child;

child = exec('cat *.js bad_file | wc -l',
    function (error, stdout, stderr) {
        console.log('stdout: ' + stdout);
        console.log('stderr: ' + stderr);
    if (error !== null) {
        console.log('exec error: ' + error);
    }
});
/*
运行：

$ node test_exec.js
因为没有bad_file 这个文件，所以会看到终端打印出了相关错误信息。*/

//child_process.execFile()方法

//与exec方法类似，执行特定程序文件，参数通过一个数组传送。，如：

// test_execfile.js
var child_process = require('child_process');

// exec: spawns a shell
child_process.exec('ls -lh /usr', function(error, stdout, stderr){
    console.log(stdout);
    console.log('******************');
});

// execFile: executes a file with the specified arguments
child_process.execFile('/bin/ls', ['-lh', '/usr'], function(error, stdout, stderr){
    console.log(stdout);
});
/*
运行：

$ node test_execfile.js
child_process.fork()方法

直接创建一个子进程，此进程是node命令的子进程，fork('./sub.js')相当于spwan('node', './sub.js')。fork还会在父进程与子进程之间，建立一个通信管道，通过child.send()发送消息。如：*/

// main.js
var cp = require('child_process');

var n = cp.fork(__dirname + '/sub.js');

n.on('message', function(m) {
  console.log('PARENT got message:', m);
});

n.send({ hello: 'world' });
// sub.js
process.on('message', function(m) {
  console.log('CHILD got message:', m);
});

process.send({ foo: 'bar' });
/*
运行：

$ node main.js
运行main.js会看到主进程收到了来自子进程的消息，而子进程也收到了来自主进程的消息。*/

//cluster模块

/*单个的Node实例运行在单个线程中。要发挥多核系统的能力，需要启动一个Node进程集群来处理负载。cluster模块就用于创建共享服务器端口的子进程。

举个栗子：*/

// test_cluster.js

var cluster = require('cluster');
var http = require('http');
var numCPUs = require('os').cpus().length;  // 获取CPU内核数

// master是主进程
// 此处判断是否为master进程
// 是则根据CPU内核数创建worker进程
if (cluster.isMaster) {
    // worker是运行节点
    // 根据CPU数量启动worker
    // Fork workers
    for (var i = 0; i < numCPUs; i++) {
        cluster.fork();
    }

    Object.keys(cluster.workers).forEach(function(id) {
        console.log('I am running with ID : ' + cluster.workers[id].process.pid);
    });
    cluster.on('exit', function(worker, code, signal) {
        console.log('worker ' + worker.process.pid + ' died');
    });
} else {
    // cluster.isWorker == true
    // 运行到else中的代码
    // 说明当前进程是worker进程
    // 那么此worker进程就启动一个http服务
    http.createServer(function(req, res) {
        res.writeHead(200);
        res.end("hello world\n");
    }).listen(8000);
}
/*
运行程序：

$ node test_cluster.js
在终端会看到根据CPU内核数创建的子进程信息。

每个worker进程都是通过child_process.fork()方法产生的，所以它们可以通过IPC（进程间通信）与master进程通信。

cluster.worker是worker进程对象，其中有 worker.id、worker.process等属性，还有worker.send()等方法。
*/