var express = require('express');
var mongoose = require('mongoose');
var crypto = require('crypto');
var moment = require('moment');

var model = require('../models/model');
var checkIsLogin = require('./checkIsLogin');

var User = model.User;
var Article = model.Article;

var router = express.Router();

/* GET home page. */
/*-----------------------------------*\
|-------------主页index---------------|
\*-----------------------------------*/

//asc | 1 正序 
//desc | -1 倒序
 
var page = 1;
var pageSize = 5;
router.get('/', function(req, res, next) {
	page = req.query.page ? parseInt(req.query.page) : 1;
	Article
	.count(function(err, total) {
		Article
		.find()
		.skip((page - 1) * pageSize)
		.limit(pageSize)
		.sort('-createTime')
		.exec(function(err, arts) {
			if(err) {
				req.flash('error',err);
				return res.redirect('/');
			}
			res.render('index', { 
				title: '主页',
				user: req.session.user,
				success: req.flash('success').toString(),
				error: req.flash('error').toString(),
				total: total,
				page: page,
				pageSize: pageSize,
				isFirstPage: (page - 1) == 0,
				isLastPage: ((page - 1) * pageSize + arts.length) == total,
				arts: arts,
				moment: moment
			});
		});
	});
});

/*-----------------------------------*\
|-------------注册register------------|
\*-----------------------------------*/
router.get('/reg', checkIsLogin.login);
router.get('/reg', function(req, res, next) {
	res.render('register', { 
		title: '注册',
		user: req.session.user,
		success: req.flash('success').toString(),
		error: req.flash('error').toString()
	});
});

router.post('/reg', function(req, res, next) {
	var username = req.body.username,
		password = req.body.password,
		passwordRepeat = req.body.passwordRepeat;

	//检查两次输入的密码是否一致
	if(password != passwordRepeat) {
		req.flash('error', '两次输入的密码不一致！');
		return res.redirect('/reg');
	}

	//检查用户名是否已经存在
	User.findOne({username:username}, function(err, user) {
		if(err) {
			req.flash('error', err);
			return res.redirect('/reg');
		}

		if(user) {
			req.flash('error', '用户名已经存在');
			return res.redirect('/reg');
		}

		//对密码进行md5加密
		var md5 = crypto.createHash('md5'),
			md5password = md5.update(password).digest('hex');

		var newUser = new User({
			username: username,
			password: md5password,
			email: req.body.email
		});

		newUser.save(function(err, doc) {
			if(err) {
				req.flash('error', err);
				return res.redirect('/reg');
			}
			req.flash('success', '注册成功！');
			newUser.password = null;
			delete newUser.password;
			req.session.user = newUser;
			return res.redirect('/');
		});
	});
});

/*-----------------------------------*\
|-------------登录login---------------|
\*-----------------------------------*/
router.get('/login', checkIsLogin.login);
router.get('/login', function(req, res, next) {
	User.find(function(err, doc) {
		res.render('login', {
			title: '登录',
			user: req.session.user,
			success: req.flash('success').toString(),
			error: req.flash('error').toString(),
			datas: doc
		});
	});
});

router.post('/login', function(req, res, next) {
	var username = req.body.username,
		password = req.body.password;

	User.findOne({username:username}, function(err, user) {
		if(err) {
			req.flash("err", err);
			return next(err);
		}
		if(!user) {
			req.flash('error', '用户不存在！');
			return res.redirect('/login');
		}
		//对密码进行md5加密
		var md5 = crypto.createHash('md5'),
			md5password = md5.update(password).digest('hex');
		if(user.password !== md5password) {
			req.flash('error', '密码错误！');
			return res.redirect('/login');	
		}
		req.flash('success', '登录成功！');
		user.password = null;
		delete user.password;
		req.session.user = user;
		return res.redirect('/');
	});
});


/*-----------------------------------*\
|-------用户详情页面/u/:username------|
\*-----------------------------------*/
router.get('/u/:author', function(req, res, next) {
	page = req.query.page ? parseInt(req.query.page) : 1;
	Article
	.count({author: req.params.author})
	.exec(function(err, total) {
		Article
		.find({author: req.params.author})
		.skip((page - 1) * pageSize) 
		.limit(pageSize)
		.sort('-createTime')
		.exec(function(err, arts) {
			if(err) {
				req.flash('error', err);
				return res.redirect('/');
			}
			res.render('user', { 
				title: req.params.author ,
				user: req.session.user,
				success: req.flash('success').toString(),
				error: req.flash('error').toString(),
				total: total,
				page: page,
				pageSize: pageSize,
				isFirstPage: (page - 1) == 0,
				isLastPage: ((page - 1) * pageSize + arts.length) == total,
				arts: arts,
				moment: moment
			});
		});
	});
});

/*-----------------------------------*\
|----------文章/u/:author/:_id--------|
\*-----------------------------------*/
router.get('/u/:author/:_id', function(req, res, next) {
	Article.findOne({
		author: req.params.author,
		_id: req.params._id
	}, function(err, art) {
			if(err) {
				req.flash('error', '抱歉，因不明原因，此文章已从银河系消失！');
				return res.redirect('/');
			}
			if(art) {
				Article.update({
					_id: req.params._id
				},{
					 $inc: {'pv': 1}
				}, function(err) {
					if(err) {
						return req.flash('error', err);
					}
				});
			}
			res.render('article', {
				title: '文章内容',
				user: req.session.user,
				success: req.flash('success').toString(),
				error: req.flash('error').toString(),
				moment: moment,
				art: art
			});
		});
});

/*-----------------------------------*\
|------------模糊查询/search----------|
\*-----------------------------------*/
router.get('/search', function(req, res, next) {
	var query = req.query.title,
		title = new RegExp(query, 'i');
	page = req.query.page ? parseInt(req.query.page) : 1;
	Article
	.count({title: title})
	.exec(function(err, total) {
		Article
		.find({title: title})
		.skip((page - 1) * pageSize)
		.limit(pageSize)
		.sort('-createTime')
		.exec(function(err, arts) {
			if(err) {
				req.flash('error', err);
				return res.redirect('/');
			}
			res.render('search', { 
				title: '查询结果',
				user: req.session.user,
				success: req.flash('success').toString(),
				error: req.flash('error').toString(),
				search: query,
				total: total,
				page: page,
				pageSize: pageSize,
				isFirstPage: (page - 1) == 0,
				isLastPage: ((page - 1) * pageSize + arts.length) == total,
				arts: arts,
				moment: moment
			});
		});
	});
});

/*-----------------------------------*\
|-------------发表post----------------|
\*-----------------------------------*/
router.get('/post', checkIsLogin.notLogin);
router.get('/post', function(req, res, next) {
	res.render('post', { 
		title: '发表',
		user: req.session.user,
		success: req.flash('success').toString(),
		error: req.flash('error').toString()
	});
});

router.post('/post', function(req, res, next) {
	var data = new Article({
		title: req.body.title,
		author: req.session.user.username,
		tag: req.body.tag,
		content: req.body.content
	});

	data.save(function(err, doc) {
		if(err) {
			req.flash('error', err);
			return res.redirect('/post');
		}
		req.flash('success', '文章发表成功！')
		return res.redirect('/');
	});
});

/*-----------------------------------*\
|-------------编辑/edit/:_id----------|
\*-----------------------------------*/
router.get('/edit/:_id', function(req, res, next) {
	Article.findOne({_id: req.params._id}, function(err, art) {
		if(err) {
			req.flash('error', err);
			return res.redirect('back');
		}
		res.render('edit', {
			title: '编辑',
			user: req.session.user,
			success: req.flash('success').toString(),
			error: req.flash('error').toString(),
			moment: moment,
			art: art
		});
	});
});

router.post('/edit/:_id', function(req, res, next) {
	Article.update({_id: req.params._id},{
		title: req.body.title,
		tag: req.body.tag,
		content: req.body.content,
		createTime: Date.now()
	}, function(err, art) {
		if(err) {
			req.flash('error', err);
			return res.redirect('back');
		}
		req.flash('success', '文章编辑成功！');
		return res.redirect('/u/' + req.session.user.username);
	});
});

/*-----------------------------------*\
|------------删除/delete/:_id---------|
\*-----------------------------------*/
router.get('/remove/:_id', function(req, res, next) {
	Article.remove({_id: req.params._id}, function(err) {
		if(err) {
			req.flash('error', err);
		} else {
			req.flash('success', '文章删除成功！');
		}
		return res.redirect('back');
	})
});

/*-----------------------------------*\
|-------------退出logout--------------|
\*-----------------------------------*/
router.get('/logout', function(req, res, next) {
	req.session.user = null;
	req.flash('success', '退出登录成功！');
	return res.redirect('/login');
});

module.exports = router;
