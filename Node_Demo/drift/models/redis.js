'use strict';

var redis = require('redis');
var uuid = require('node-uuid');

// 瓶子类型
var type = { male: 0, female: 1 };


/**
 * 扔漂流瓶
 *
 * @param {obj} bottle 漂流瓶对象
 * @param {function} callback 回调函数
 */
function throwBottle(bottle, callback) {
    // 创建 redis 连接
    var client = redis.createClient();
    // 生成漂流瓶 id
    var bottleId = uuid.v4();
    // 漂流瓶的创建时间
    bottle.time = bottle.time || Date.now();

    // 根据漂流瓶类型选择数据库
    // male 类型漂流瓶保存到 0 号数据库
    // female 类型漂流瓶保存到 1 号数据库
    client.select(type[bottle.type], function() {
        // 使用 hash 类型保存漂流瓶对象
        client.hmset(bottleId, bottle, function(err, result) {
            // 扔瓶子失败
            if (err) {
                return callback({ code: 0, msg: '过会儿再试吧～' });
            }
            // 设置漂流瓶生存期
            // 86400 秒，即一天
            // 若一天后没有人捡到这个瓶子
            // 就会被 Redis 删除
            client.expire(bottleId, 86400, function() {
                // 释放连接
                client.quit();
            });
            // 返回结果
            callback({ code: 1, msg: '你成功扔出了一个漂流瓶～' });
        });
    });
}

/**
 * 捡漂流瓶
 *
 * @param {obj} info 捡瓶子的用户对象
 * @param {function} callback 回调函数
 */
function pickBottle(info, callback) {
    // 创建 redis 连接
    var client = redis.createClient();

    // 根据用户性别选择数据库
    // male 选择 0 号数据库
    // female 选择 1 号数据库
    client.select(type[info.type], function() {
        // 从 redis 数据库中随机取出一个瓶子
        client.randomkey(function(err, bottleId) {
            // 出错了
            if (err) {
                return callback({ code: 0, msg: err });
            }
            // 没有取到时
            // 返回海星
            if (!bottleId) {
                return callback({ code: 1, msg: '你捞到一个海星～' });
            }

            // 取到了瓶子
            client.hgetall(bottleId, function(err, bottle) {
                // 读取瓶子内容出错
                if (err) {
                    return callback({ code: 0, msg: '这个瓶子破损了。。。' });
                }

                // 读取瓶子内容成功
                // 从 redis 数据库删除此瓶子
                client.del(bottleId, function() {
                    // 释放连接
                    client.quit();
                });

                // 返回结果
                callback({ code: 1, msg: bottle });
            });
        });
    });
}


// 导出扔瓶子方法
exports.throw = function(bottle, callback) {
    throwBottle(bottle, function (result) {
        callback(result);
    });
};

// 导出捡瓶子方法
exports.pick = function(info, callback) {
    // 20% 概率捡到海星
    if (Math.random() <= 0.2) {
        return callback({ code: 1, msg: "你捞到一个海星～" });
    }
    pickBottle(info, function (result) {
        callback(result);
    });
};

