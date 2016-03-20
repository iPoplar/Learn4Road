var mongoose = require('mongoose');
var uri = 'mongodb://username:password@hostname:port/databasename';
uri = 'mongodb://localhost/part9';

mongoose.conncet(uri);

var BooSchema = new mongoose.Schema({
    name: String,
    author: String,
    publishTime: Date
});

mongoose.model('Book', BookSchema);