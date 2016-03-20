var express = require('express');
var router = express.Router();
var redis = require('../models/redis');

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

// 扔瓶子
router.post('/throw', function(req, res, next) {
    var body = req.body;
    var owner = body.owner;
    var type = body.type;
    var content = body.content;

    if (!(owner && type && content)) {
        return res.json({ code: 0, msg: '信息不完整' });
    }
    if (type && ['male', 'female'].indexOf(type) === -1) {
        return res.json({ code: 0, msg: '类型错误' });
    }
    redis.throw(body, function(result) {
        res.json(result);
    });
});

// 捡瓶子
router.get('/pick', function(req, res, next) {
    var user = req.query.user;
    var type = req.query.type;

    if (!user) {
        return res.json({ code: 0, msg: '信息不完整' });
    }
    if (!type || ['male', 'female'].indexOf(type) === -1) {
        return res.json({ code: 0, msg: '类型错误' });
    }
    redis.pick(req.query, function(result) {
        res.json(result);
    });
});

module.exports = router;

