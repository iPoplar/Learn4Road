var mongoose = require('mongoose');

require('./model.js');

var Book = mongoose.model('Book');

var cond = {
     // 还可以使用 $and
    $or: [
         // 除了值相当，还有大于 $gt ，大于等于 $gte ，小于 $lt ，小于等于 $lte，不等于 $ne
        {author: 'Jame'},
        {author: 'Jim'}
    ]
};

Book.find(cond, function(err, docs){
    if(err){
        console.log('find by cond err: ', err);
        return;
    }
    
    console.log('cond:', cond, 'result:', docs);
});