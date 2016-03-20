<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-11
 * Time: 下午7:56
 */
include_once('../bin/Mysql.php');
include_once('../bin/interview.php');
include_once('../bin/notice.php');
// $_GET['status']=3; 测试数据
if(!isset($_GET['status']))
{
    exit;
}
/*else{
    $return_array = array("test"=>$_GET['status']);
    $callback = isset($_GET['callback'])?trim($_GET['callback']):'';
    $demo_json = json_encode($return_array,JSON_UNESCAPED_UNICODE);
    echo $callback."($demo_json)";
    exit;
}*/ // 进行输入测试 ，获取成功返回 get 到的 值
$callback = isset($_GET['callback'])?trim($_GET['callback']):'';
$sql = new Mysql();
$status1 = $_GET['status'];

if($status1=="5811")
{
    $notice = get_notice();
    send_notice($notice);

}// 为 5,8,11 为 获取通知

$interviews = interview::get_same_status_interview(array($status1));


$return_array =null;
if($interviews)
{
    foreach($interviews as $interview)
    {
        if(!$interview->get_judge_id())
        {
           $judge = "**";
        }else{

            $judge = $interview->judge->get_name();

        }
        $return_array[] = array("id"=>$interview->player->student_id,"name"=>$interview->player->name
        ,"status"=>$interview->player->get_status(),"direction"=>$interview->player->direction,
            "judge"=>$judge);
    }

}

$callback = isset($_GET['callback'])?trim($_GET['callback']):'';
$demo_json = json_encode($return_array);
echo $demo_json;
exit;


