使用require('fs')载入fs模块，模块中所有方法都有同步和异步两种形式。

//同步和异步

//异步方法中回调函数的第一个参数总是留给异常参数(exception),如果方法完成，那么这个参数为null 或 undefined.
//异步方法实例code
var fs = require('fs'); //载入fs模块

fs.unlink('/tmp/shiyanslou', function(err){
	if(err){
		throw err;
	}
	console.log('成功删除了 /tmp/shiyanlou');
});

//同步code
var fs = require('fs');

fs.unlinkSync('/tmp/shiyanlou'); //Sync 表示是同步方法
console.log('成功删除了 /tmp/shiyanlou');

//同步方法执行完并返回结果后，才能执行后续的代码。而异步方法采用回调函数接受返回结果，可以立即执行后续代码。

//readFile读取文件
//使用fs.readFile(filename, [options], callback)方法读取文件。
//
//readFile接收三个参数，filename是文件名；[options]是可选的参数，为一个对象，用于指定文件编码（encoding）及操作方式（flag）；callback是回调函数。

var fs = require('fs'); //引入fs模块

fs.readFile('./text.txt', function(err, data){
	//读取文件失败/错误
	if(err) {
		throw err;
	}
	//读取文件成功
	console.log(data);
});
//以上代码读出的数据是二进制的数据

//=============
var fs = require('fs'); //引入fs模块

//使用toString()
fs.readFile('./test.txt', function(err, data){
	//读取文件失败
	if(err){
		throw err;
	}
	//读取文件成功
	console.log('toString', data.toString());
});

//设置编码格式
fs.readFile('./test.txt', 'utf-8', function(err, data){
	//读取文件失败
	if(err){
		throw err;
	}
	//读取文件成功
	console.log('utf-8:', data.toString());
});

//fs.readFileSync(filename, [options])是readFile的同步方法。


//writeFile写入文件

//使用fs.writeFile(filename, data, [options], callback)写入内容到文件。
//
//writeFile接收四个参数，filename是文件名称；data是要写入文件的数据；[options]是一个对象为可选参数，包含编码格式（encoding），模式（mode）以及操作方式（flag）；callback是回调函数。

var fs = require('fs');

//写入文件内容（如果文件不存在会创建一个文件）
//写入时先会清空文件
fs.writeFile('./test2.txt', 'test test', function(err){
	if(err){
		throw err;
	}
	
	console.log('Saved.');
	
	//写入成功后读取测试
	fs.readFile('./test2.txt', 'utf-8', function(err, data){
		if(err){
			throw err;
		}
		console.log(data);
	});
});

//如果要追加数据到文件，可以传递一个flag参数,
//fs.writeFile('./test2.txt','test test', {'flag':'a'}, function()....)
//flag传递的值，r代表读取文件，，w代表写入文件，a代表追加写入文件


//使用fs.read和fs.write读写文件需要使用fs.open打开文件和fs.close关闭文件。

/*fs.read()

先介绍fs.open(path, flags, [mode], callback)方法，此方法用于打开文件，以便fs.read()读取。path是文件路径，flags是打开文件的方式，[mode]是文件的权限（可选参数，默认值是0666），callback是回调函数。

flags的值：

r ：读取文件，文件不存在时报错；
r+ ：读取并写入文件，文件不存在时报错；
rs ：以同步方式读取文件，文件不存在时报错；
rs+ ：以同步方式读取并写入文件，文件不存在时报错；
w ：写入文件，文件不存在则创建，存在则清空；
wx ：和w一样，但是文件存在时会报错；
w+ ：读取并写入文件，文件不存在则创建，存在则清空；
wx+ ：和w+一样，但是文件存在时会报错；
a ：以追加方式写入文件，文件不存在则创建；
ax ：和a一样，但是文件存在时会报错；
a+ ：读取并追加写入文件，文件不存在则创建；
ax+ ：和a+一样，但是文件存在时会报错。
fs.close(fd, [callback])用于关闭文件，fd是所打开文件的文件描述符。

fs.read(fd, buffer, offset, length, position, callback)方法接收6个参数。

fd是文件描述符，必须接收fs.open()方法中的回调函数返回的第二个参数；
buffer是存放读取到的数据的Buffer对象；
offset指定向buffer中存放数据的起始位置；
length指定读取文件中数据的字节数；
position指定在文件中读取文件内容的起始位置；
callback是回调函数，回调函数的参数：
err用于抛出异常；
bytesRead是从文件中读取内容的实际字节数；
buffer是被读取的缓存区对象。*/

//fs.read
var fs = require('fs');

//打开文件
fs.open('./testread.txt','r', function(err, fd){
	if(err){
		throw err;
	}
	
	console.log('open file success');
	
	var buffer = new Buffer(255);
	//读取文件
	fs.read(fd, buffer, 0, 10, 0, function(err, byteRead, buffer){
		if(err) {
			throw err;
		}
		
		//打印处buffer中存在的数据
		console.log(byteRead, buffer.slice(0, byteRead).toString());
		
		//关闭文件
		fs.close(fd);
	});
	
});


//fs.write(fd, buffer, offset, length, position, callback)方法的参数和fs.read()相同，buffer是需要写入文件的内容。
var fs = require('fs');

fs.open('./testwrite.txt', 'w', function(err, fd){
	if(err){
		throw err;
	}
	console.log('open file success');
	
	var buffer = new Buffer('shiyanlou');
	//读取文件
	fs.write(fd, buffer, 0, 6, 0, function(err, writeten, buffer){
		if(err){
			throw err;
		}
		
		console.log('write success');
		//打印出buffer中存入的数据
		console.log(bytesRead, buffer, slice(0, bytesRead).toString());
		
		//关闭文件
		fs.close(fd);
	});
	
});


//使用fs.mkdir(path, [mode], callback)创建目录，path是需要创建的目录，[mode]是目录的权限（默认值是0777），callback 是回调函数。
var fs = require('fs'); 

//创建 newdir 目录
fs.mkdir('./newdir', function(err){
	if(err){
		throw err;
	}
	console.log('make dir success');
});


//使用fs.readdir(path, callback)读取文件目录
var fs = require('fs');

fs.readdir('./newdir', function(err, files){
	if(err){
		throw err;
	}
	//files是一个数组
	//每个元素是此目录下的文件或文件夹的名称
	console.log(files);
	
});
