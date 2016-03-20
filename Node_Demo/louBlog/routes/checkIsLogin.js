//已经登录
function login(req, res, next) {
	if(req.session.user) {
		req.flash('error', '抱歉，您已登录！');
		return res.redirect('back');//返回之前的页面
	}
	next();
}

//未登录
function notLogin(req, res, next) {
	if(!req.session.user) {
		req.flash('error', '抱歉，您还没有登录！');
		return res.redirect('/login');//返回登录页面
	}
	next();
}

exports.login = login;
exports.notLogin = notLogin;
