var redis = require("redis");

var client = redis.createClient();
client.select(1, function() {
    console.log(client === this)
    client.set('k', 'v', redis.print);
    client.quit();
});


var client2 = redis.createClient();
client2.select(2, function() {
    client2.set('k2', 'v2', redis.print);
    client2.quit();
});


