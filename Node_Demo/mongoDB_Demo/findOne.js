var mongoose = require('mongoose');

require('./model.js');

var Book = mongoose.model('Book');

Book.findOne({author:"Jim"}, function(err, doc){
    if(err){
        console.log('err:', err);
        return;
    }
    doc.author = 'Jame';
    doc.save();
    console.log('FindOne result:', doc);
});