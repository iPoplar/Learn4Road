'use strict'

//捞瓶子
$('.pick').on('click', function(){
  var modal = $('#pick-modal');

  modal.modal('show');
  $('.btn-primary', modal).off('click').on('click', function(){
    var user = $('form', modal).serialize();

    $.getJSON('/pick', user, function(data){
      if(typeof data.msg === 'object'){
        //捞到一个瓶子
        //显示瓶子信息
        $('.bottle-user span').text(data.msg.owner);
        $('.bottle-content span').text(data.msg.content);
      }else{
        //没有捞到瓶子
        //显示提示信息
        showMsg(data);
      }

      modal.modal('hide');
    });
  });
});

//扔瓶子
$('.throw').on('click', function(){
  var modal = $('#throw-modal');

  modal.modal('show');
  $('.btn-primary', modal).off('click').on('click', function(){
    var bottle = $('form', modal).serialize();

    $.post('/throw', bottle, function(data){
      //显示提示信息
      shhowMsg(data);
      modal.modal('hide');
    });
  });
});

//显示提示信息
function showMsg(data){
  //只显示简单信息
  if(typeof data.msg === 'object'){
    return false;
  }

  var dataClass = data.code === 0 ? 'danger' : 'success';
  var box = $('<div class="alert alert-' + dataClass + '" role="alert"></div>');

  box.text(data.msg);
  $('.show-msg').html(box);

  //5 秒后信息自动消失
  setTimeout(function(){
    $('.show-msg').html('');
  }, 5000);
}
