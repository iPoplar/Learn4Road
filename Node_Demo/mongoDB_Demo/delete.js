var mongoose = require('mongoose');

require('./model.js');

var Book = mongoose.model('Book');

Book.findOne({author:'Jim'}, function(err, doc){
    if(err){
        console.log('findOne err', err);
        return;
    }
    
    if(doc){
        //remove() 也是有回调函数，可以判读是否删除成功
        doc.remove();
    }
});