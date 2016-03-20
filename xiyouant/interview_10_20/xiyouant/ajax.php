<?php
$callback = isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需			
//$formInfo = array("name"=>$_GET['name'],"id"=>$_GET['id']);

$date["msg"]="so，why， 发送失败了？！";


$demo = array(
'id' => '04131093',
'name' => '张煜堃',
'status' => 3,
'direction' => 2,
'judge'=>'**'
);

//$tmp = json_encode($formInfo); 
$demo_json = json_encode($demo); // 格式是{"key":"value","key2":"value2"}


 echo $callback . '(' . $demo_json .')';  //返回格式，必需
//echo $callback . '(' . $tmp .')';  //返回格式，必需
?>